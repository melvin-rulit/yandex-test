<template>
    <div class="top">
        <div class="logout" @click="logout" title="Выйти">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="2"
                stroke="currentColor"
                class="w-6 h-6"
            >
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1" />
            </svg>
        </div>
    </div>
</template>

<script setup>
import { Inertia } from '@inertiajs/inertia';

const logout = () => {
    Inertia.post(route('logout'));
};
</script>

<style scoped>
.top {
    height: 75px;
    border-bottom: 1px solid #DCE4EA;
    background-color: transparent;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    padding: 0 20px;
}
.logout {
    cursor: pointer;
    color: #6C757D;
    transition: color 0.2s;
}
.logout:hover {
    color: #333;
}
</style>

