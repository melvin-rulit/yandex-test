<template>
    <div class="bg-white p-6 rounded shadow-md max-w-md mx-auto">
        <h2 class="text-xl font-semibold mb-4">Создать задачу</h2>

        <form @submit.prevent="submit">
            <!-- Название задачи -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Название</label>
                <input
                    v-model="form.name"
                    type="text"
                    placeholder="Название задачи"
                    class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                />
                <p v-if="errors.name" class="text-red-500 text-sm mt-1">{{ errors.name }}</p>
            </div>

            <!-- Описание задачи -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Описание</label>
                <input
                    v-model="form.content"
                    type="text"
                    placeholder="Название задачи"
                    class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                />
                <p v-if="errors.content" class="text-red-500 text-sm mt-1">{{ errors.content }}</p>
            </div>

            <!-- Дедлайн -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Дедлайн</label>
                <input
                    v-model="form.due_date"
                    type="date"
                    class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                />
                <p v-if="errors.due_date" class="text-red-500 text-sm mt-1">{{ errors.due_date }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Участники</label>
                <Multiselect
                    v-model="form.participant_ids"
                    :options="users"
                    :multiple="true"
                    track-by="id"
                    label="name"
                    placeholder="Выберите участников"
                    class="w-full"
                />
                <p v-if="errors.participant_ids" class="text-red-500 text-sm mt-1">{{ errors.participant_ids }}</p>
            </div>

            <!-- Кнопки -->
            <div class="flex justify-end gap-3">
                <button
                    type="button"
                    @click="goToTask"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50"
                >
                    Отмена
                </button>

                <button
                    type="submit"
                    class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700"
                >
                    Создать
                </button>
            </div>
        </form>

        <div v-if="successMessage" class="mt-4 text-green-600 text-sm">{{ successMessage }}</div>
    </div>
</template>

<script setup>
import { ref , onMounted} from 'vue'
import axios from 'axios'
import { Inertia } from '@inertiajs/inertia'
import Multiselect from 'vue-multiselect'
import 'vue-multiselect/dist/vue-multiselect.css'

const form = ref({
    name: '',
    status: 'new',
    content: '',
    due_date: '',
    participant_ids: []
})

const errors = ref({})
const successMessage = ref('')
const loading = ref(false);
const users = ref([])
function goToTask() {
    window.location.href = `/tasks`;
}
async function getUsers() {
    loading.value = true;
    try {
        const { data } = await axios.get('/api/users');
        users.value = data;
    } finally {
        loading.value = false;
    }
}
function submit() {
    errors.value = {}
    successMessage.value = ''

    axios.post('/api/tasks', form.value)
        .then(res => {
            successMessage.value = 'Задача успешно создана!'
            //Inertia.visit('/tasks')
            window.location.href = '/tasks'
        })
        .catch(err => {
            if (err.response?.status === 422) {
                errors.value = err.response.data.errors
            } else {
                console.error(err)
            }
        })
}

onMounted(() => {
    getUsers()
})
</script>
