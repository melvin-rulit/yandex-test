<template>
    <div class="p-6">
        <!-- Доступ запрещен -->
        <div v-if="accessDenied" class="text-center space-y-4">
            <div class="text-red-600 font-semibold">
                ❌ У вас нет доступа к этой задаче
            </div>
            <button
                @click="goBack"
                class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition-colors"
            >
                Вернуться к задачам
            </button>
        </div>

        <!-- Задача доступна -->
        <div v-else-if="task">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-semibold">{{ task.name }}</h1>
                <span class="text-sm text-gray-500">Status: {{ task.status }}</span>
            </div>
            <p class="mt-2 whitespace-pre-wrap">{{ task.content }}</p>
            <div class="mt-2 text-sm text-gray-500">Due: {{ formatDate(task.due_date) || '-' }}</div>

            <!-- Комментарии -->
            <h2 class="mt-6 font-semibold">Comments</h2>
            <form @submit.prevent="createComment" class="mt-2 flex gap-2">
                <input v-model="newComment" placeholder="Write a comment..." class="flex-1 border rounded px-2 py-1" />
                <button class="px-3 py-1 bg-indigo-600 text-white rounded" :disabled="!newComment">Send</button>
            </form>
            <ul class="mt-3 space-y-2">
                <li v-for="c in comments" :key="c.id" class="border rounded p-2">
                    <div class="text-sm text-gray-600">{{ c.user?.name }} • {{ formatDate(c.created_at) }}</div>
                    <div>{{ c.content }}</div>
                </li>
            </ul>

            <!-- Участники -->
            <div class="mt-4">
                <h2 class="font-semibold text-sm mb-1">Participants:</h2>
                <div class="flex flex-wrap gap-2">
          <span v-for="u in task.participants" :key="u.id" class="bg-gray-200 text-gray-800 px-2 py-1 rounded text-sm">
            {{ u.name }}
          </span>
                </div>
            </div>

            <!-- Создатель -->
            <div class="mt-4">
                <h2 class="font-semibold text-sm mb-1">Creator:</h2>
                <div class="bg-gray-200 text-gray-800 px-2 py-1 rounded text-sm inline-block">
                    {{ task.creator.name }}
                </div>
            </div>
        </div>

        <!-- Loading -->
        <div v-else class="text-gray-500 italic">Loading...</div>
    </div>
</template>

<script setup>
import { onMounted, onBeforeUnmount, ref, watch} from 'vue';
import axios from 'axios';

const props = defineProps({ id: { type: Number, required: true } });
const task = ref(null);
const comments = ref([]);
const newComment = ref('');
let channel;

function formatDate(v) { return v ? new Date(v).toLocaleString() : ''; }

const accessDenied = ref(false);
async function loadTask() {
    try {
        const { data } = await axios.get(`/api/tasks/${props.id}`);
        task.value = data;
    } catch (error) {
        if (error.response?.status === 403) {
            accessDenied.value = true;
        } else {
            console.error(error);
        }
    }
}

async function createComment() {
    if (!newComment.value) return;
    const { data } = await axios.post(`/api/tasks/${props.id}/comments`, { content: newComment.value });
    comments.value.unshift(data);
    newComment.value = '';
}
async function loadComments() {
    const { data } = await axios.get(`/api/tasks/${props.id}/comments`);
    comments.value = data.data ?? data;
}
function goBack() {
    window.location.href = `/tasks`;
}

function subscribeToChannel(taskId) {
    if (channel) {
        // Отписываемся от старого канала!
        channel.stopListening('TaskUpdated').stopListening('CommentCreated');
        channel = null;
    }

    channel = window.Echo.private(`tasks.${taskId}`)
        .listen('TaskUpdated', (e) => {
            console.log(`TaskUpdated пришёл!`, e);
        })
        .listen('CommentCreated', (e) => {
            console.log('НОВЫЙ КОММЕНТ ПОЙМАН!', e);
        });
    console.log('Я подписался на канал tasks.' + taskId);
}

onMounted(() => {
    subscribeToChannel(props.id);
});

watch(() => props.id, (newId, oldId) => {
    if (newId !== oldId) subscribeToChannel(newId);
});

onBeforeUnmount(() => {
    if (channel) {
        channel.stopListening('TaskUpdated').stopListening('CommentCreated');
    }
});
onMounted(async () => {
    await loadTask();
    await loadComments();
    console.log('Я подписался на канал tasks.' + props.id);
    channel = window.Echo.private(`tasks.${props.id}`)
        .listen('TaskUpdated', (e) => {
            console.log('НОВЫЙ КОММЕНТ ПОЙМАН!', e);
            if (e?.task) task.value = e.task;
        })
        .listen('CommentCreated', (e) => {
            console.log('НОВЫЙ КОММЕНТ ПОЙМАН!', e);
            if (e?.comment) comments.value.unshift(e.comment);
        });
    // channel = window.Echo.private(`tasks.${props.id}`)
    //     .listen('CommentCreated', (e) => {
    //         console.log('НОВЫЙ КОММЕНТ ПОЙМАН!', e);
    //     });
});

onBeforeUnmount(() => {
    if (channel) channel.stopListening('TaskUpdated').stopListening('CommentCreated');
});
</script>
