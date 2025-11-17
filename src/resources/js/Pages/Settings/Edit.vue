<template>
		<div class="p-6">
			<h2 class="text-xl font-semibold mb-4">Редактировать задачу</h2>

			<form @submit.prevent="updateTask">
				<div class="space-y-4">
					<!-- Name -->
					<div>
						<InputLabel value="Название" />
						<TextInput
							v-model="form.name"
							type="text"
							class="mt-1 block w-full"
							required
						/>
						<InputError v-if="errors.name" :message="Array.isArray(errors.name) ? errors.name[0] : errors.name" />
					</div>

					<!-- Content -->
					<div>
						<InputLabel value="Описание" />
						<textarea
							v-model="form.content"
							class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
							rows="4"
						></textarea>
						<InputError v-if="errors.content" :message="Array.isArray(errors.content) ? errors.content[0] : errors.content" />
					</div>

					<!-- Status -->
					<div>
						<InputLabel value="Статус" />
						<select
							v-model="form.status"
							class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
						>
							<option value="new">Новая</option>
							<option value="in_progress">В работе</option>
							<option value="done">Выполнена</option>
							<option value="archived">Архивирована</option>
						</select>
						<InputError v-if="errors.status" :message="Array.isArray(errors.status) ? errors.status[0] : errors.status" />
					</div>

					<!-- Due Date -->
					<div>
						<InputLabel value="Срок выполнения" />
						<TextInput
							v-model="form.due_date"
							type="datetime-local"
							class="mt-1 block w-full"
						/>
						<InputError v-if="errors.due_date" :message="Array.isArray(errors.due_date) ? errors.due_date[0] : errors.due_date" />
					</div>

                    <!-- Assignee ID -->
                    <div>
                        <InputLabel value="Исполнитель" />
                        <Multiselect
                            v-model="form.assignee_id"
                            :options="users"
                            track-by="id"
                            label="name"
                            placeholder="Выберите исполнителя"
                            :allow-empty="true"
                            :show-labels="false"
                        />
                        <InputError v-if="errors.assignee_id" :message="errors.assignee_id" />

                        <p class="mt-1 text-sm text-gray-500" v-if="task?.assignee">
                            Текущий исполнитель: {{ task.assignee?.name }} (ID: {{ task.assignee?.id }})
                        </p>
                    </div>
				</div>

				<!-- Actions -->
				<div class="mt-6 flex justify-end gap-3">
					<button
						type="button"
                        @click="goToTask"
						class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
					>
						Отмена
					</button>
					<PrimaryButton :disabled="processing">
						{{ processing ? 'Сохранение...' : 'Сохранить' }}
					</PrimaryButton>
				</div>
			</form>
		</div>

</template>

<script setup>
import { ref, watch, onMounted} from 'vue';
import axios from 'axios';
import Multiselect from 'vue-multiselect'
import 'vue-multiselect/dist/vue-multiselect.css'
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
	show: {
		type: Boolean,
		default: false,
	},
	task: {
		type: Object,
		default: null,
	},
});

onMounted(async () => {
    try {
        const { data } = await axios.get('/api/users');
        users.value = data || [];
    } catch (e) {
        users.value = [];
        console.error(e);
    }
});

const emit = defineEmits(['close', 'updated']);

const form = ref({
	name: '',
	content: '',
	status: 'new',
	due_date: '',
    assignee_id: null,
});

const errors = ref({});
const processing = ref(false);
const users = ref([]);

function formatDateForInput(dateString) {
	if (!dateString) return '';
	const date = new Date(dateString);
	const year = date.getFullYear();
	const month = String(date.getMonth() + 1).padStart(2, '0');
	const day = String(date.getDate()).padStart(2, '0');
	const hours = String(date.getHours()).padStart(2, '0');
	const minutes = String(date.getMinutes()).padStart(2, '0');
	return `${year}-${month}-${day}T${hours}:${minutes}`;
}
function goToTask() {
    window.location.href = `/tasks`;
}

watch(
    () => props.task,
    (newTask) => {
        if (newTask) {
            form.value = {
                name: newTask.name || '',
                content: newTask.content || '',
                status: newTask.status || 'new',
                due_date: formatDateForInput(newTask.due_date),
                // проверяем, есть ли assignee
                assignee_id: newTask.assignee ? newTask.assignee.id : null,
            };
            errors.value = {};
        }
    },
    { immediate: true }
);

watch(
    () => props.show,
    (isShowing) => {
        if (isShowing && props.task) {
            form.value = {
                name: props.task.name || '',
                content: props.task.content || '',
                status: props.task.status || 'new',
                due_date: formatDateForInput(props.task.due_date),
                assignee_id: props.task.assignee ? props.task.assignee.id : null,
            };
            errors.value = {};
        }
    }
);
``
async function updateTask() {
	if (!props.task) return;

	processing.value = true;
	errors.value = {};

	try {
		const payload = {
			name: form.value.name,
			content: form.value.content,
			status: form.value.status,
            assignee_id: form.value.assignee_id || null,
            due_date: form.value.due_date ? new Date(form.value.due_date).toISOString() : null,
		};

		if (form.value.due_date) {
			payload.due_date = new Date(form.value.due_date).toISOString();
		} else {
			payload.due_date = null;
		}

		const { data } = await axios.put(`/api/tasks/${props.task.id}`, payload);

		emit('updated', data);
		emit('close');
	} catch (error) {
		if (error.response?.status === 422) {
			errors.value = error.response.data.errors || {};
		} else {
			alert('Ошибка при обновлении задачи: ' + (error.response?.data?.message || error.message));
		}
	} finally {
		processing.value = false;
	}
}
</script>

