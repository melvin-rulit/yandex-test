<template>
    <div class="p-6 max-w-4xl mx-auto">
        <h1 class="text-md mb-6">Подключить Яндекс</h1>

        <div v-if="loading" class="text-gray-500 italic">Загрузка...</div>

        <div v-else>
            <p class="yandex-link-instruction">
                <span class="instruction-text">Укажите ссылку на Яндекс, пример:</span>
                <span class="example-url">https://yandex.ru/maps/org/samoye_populyarnoye_kafe/1010501395/reviews/</span>
            </p>

            <div class="flex flex-col space-y-2">
                <TextInput
                    v-model="url"
                    placeholder="https://yandex.ru/maps/org/samoye_populyarnoye_kafe/1010501395/reviews/"
                />
                <button
                    @click="saveUrl"
                    :disabled="loading"
                    class="bg-blue-300 text-white rounded hover:bg-blue-400 disabled:opacity-50"
                    style="width: 128px; height: 25px; border-radius: 6px;">
                    Сохранить
                </button>

                <p v-if="error" class="text-red-500 text-sm mt-2">{{ error }}</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import TextInput from "../../../../vendor/laravel/breeze/stubs/inertia-vue-ts/resources/js/Components/TextInput.vue";

const props = defineProps({
    modelValue: {
        type: String,
        required: true,
    }
});

const emit = defineEmits(['update:modelValue']);
const settings = ref(null);
const url = ref(props.modelValue);
const loading = ref(false);
const error = ref(null);

function isValidUrl(url) {
    const pattern = /^(https?:\/\/)?([a-z0-9-]+(\.[a-z0-9-]+)*\.[a-z]{2,})(\/[^\s]*)?$/i;
    return pattern.test(url);
}

async function fetchSettings() {
    loading.value = true;
    try {
        const { data } = await axios.get('/yandex/settings');
        settings.value = data.data;
    } finally {
        loading.value = false;
    }
}

async function saveUrl() {
    if (!url.value) {
        error.value = 'URL не может быть пустым';
        return;
    }

    error.value = null;
    loading.value = true;

    try {
        const { data } = await axios.put('/yandex/settings', {
            org_url: url.value,
        });
        emit('update:modelValue', data.org_url);
    } catch (err) {
        console.error(err);
        error.value = 'Ошибка при сохранении данных';
    } finally {
        loading.value = false;
    }
}

onMounted(() => fetchSettings());
</script>

<style scoped>
.yandex-link-instruction {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    line-height: 20px;
}
.instruction-text {
    font-family: 'Mulish', sans-serif;
    font-weight: 600;
    font-size: 12px;
    line-height: 20px;
    letter-spacing: 0.2px;
    color: #6C757D;
}
.example-url {
    font-family: 'Mulish', sans-serif;
    font-weight: 400;
    font-size: 12px;
    line-height: 100%;
    color: #DCE4EA;
    text-decoration: underline;
    letter-spacing: 0px;
    vertical-align: middle;
}
</style>
