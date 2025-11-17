<template>
    <div class="sidebar bg-gray-800 text-white p-6">
        <img :src="Logo" alt="Logo" class="logo-image mb-6" />
        <div class="user-name">
            {{ $page.props.auth.user.name }}
        </div>
        <div class="divider mt-6"></div>
        <ul class="space-y-4 mt-6">
<!--            <li>-->
<!--                <button-->
<!--                    @click="changeTab('settings_reviews')"-->
<!--                    class="option-links">-->
<!--                    Отзывы-->
<!--                </button>-->
<!--            </li>-->
            <li>
                <button
                    @click="changeTab('reviews')"
                    :class="['links w-full text-left', activeTab === 'reviews' ? 'active' : '']">
                    Отзывы
                </button>
            </li>
            <li>
                <button
                    @click="changeTab('settings')"
                    :class="['links w-full text-left', activeTab === 'settings' ? 'active' : '']">
                    Настройки
                </button>
            </li>
        </ul>
    </div>
</template>

<script setup>
import { ref, defineEmits } from 'vue';
import Logo from '@/../images/logo.png';

const emit = defineEmits(['changeTab']);
const activeTab = ref('reviews');

const changeTab = (tab) => {
    activeTab.value = tab;
    emit('changeTab', tab);
};
</script>

<style scoped>
.sidebar {
    height: 100vh;
    width: 300px;
}
.bg-gray-800 {
    background-color: #F6F8FA;
}
.text-white {
    color: #363740;
}

h2 {
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 1.5rem;
}

ul {
    list-style-type: none;
    padding: 0;
}

.links {
    padding: 12px 16px;
    display: block;
    text-align: left;
    font-size: 14px;
    color: #363740;
    transition: all 0.3s;
    border-radius: 12px;
}

.links:hover {
    background-color: #e5e7eb;
}
.active {
    background-color: #ffffff;
    color: #000000;
    border-radius: 12px;
    padding-left: 15px;
    padding-right: 15px;
    font-weight: bold;
}
.user-name {
    font-weight: 700;
    font-size: 16px;
    line-height: 20px;
    letter-spacing: 0.2px;
    vertical-align: middle;
    color: #6C757D;
}
.divider {
    height: 1px;
    background-color: #DCE4EA;
    width: 100%;
}
</style>
