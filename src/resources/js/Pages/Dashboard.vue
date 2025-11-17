<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import Sidebar from '@/Layouts/Sidebar.vue'; // Путь к компоненту боковой панели
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'; // Путь к компоненту AuthenticatedLayout
import Settings from '@/Pages/Settings/Index.vue';


// Состояние для активной вкладки
const activeTab = ref('settings');
const changeTab = (tab) => {
    activeTab.value = tab;
};
</script>

<template>
    <Head title="Dashboard" />

    <div class="flex min-h-screen flex-col">
        <!-- Top Layout (AuthenticatedLayout) -->
        <AuthenticatedLayout />

        <!-- Main Content Area -->
        <div class="flex flex-1">
            <!-- Sidebar Component -->
            <Sidebar @changeTab="changeTab" />

            <!-- Main Content Area -->
            <div class="flex-1 p-6">
                <h1 class="text-3xl font-bold mb-6 text-white">Yandex Dashboard</h1>

                <!-- Tab content based on activeTab -->
                <div v-if="activeTab === 'settings'">
                    <Settings />
                </div>
                <div v-if="activeTab === 'reviews'">
                    <Reviews />
                </div>
                <div v-if="activeTab === 'statistics'">
                    <Statistics />
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Для стилизации контейнера и компонентов */
.flex-1 {
    flex: 1;
}

.min-h-screen {
    min-height: 100vh;
}

/* Стили для основного контента */
.p-6 {
    padding: 1.5rem;
}

/* Стили для боковой панели */
.w-64 {
    width: 16rem; /* Ширина боковой панели */
}

.bg-gray-800 {
    background-color: #2d3748; /* Темный фон для боковой панели */
}

.text-white {
    color: white; /* Белый цвет текста */
}

.text-indigo-400 {
    color: #667eea; /* Цвет для кнопок на hover */
}

button {
    padding: 10px;
    width: 100%;
    text-align: left;
    border: none;
    background: none;
    color: white;
    cursor: pointer;
    transition: background 0.3s ease;
}

button:hover {
    background-color: #444; /* Темный фон при наведении */
}
</style>
