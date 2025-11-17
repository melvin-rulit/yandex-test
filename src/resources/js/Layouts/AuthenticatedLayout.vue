<script setup>
import { ref } from 'vue';

const showingNavigationDropdown = ref(false);
</script>
<template>
<div class="w-64 bg-gray-800 text-white p-6">
<h2 class="text-2xl font-bold mb-6">Dashboard</h2>
<ul class="space-y-4">
    <li>
        <button
            @click="changeTab('settings')"
            class="hover:text-indigo-400 w-full text-left"
        >
            Settings
        </button>
    </li>
    <li>
        <button
            @click="changeTab('reviews')"
            class="hover:text-indigo-400 w-full text-left"
        >
            Reviews
        </button>
    </li>
    <li>
        <button
            @click="changeTab('statistics')"
            class="hover:text-indigo-400 w-full text-left"
        >
            Statistics
        </button>
    </li>
</ul>
</div>
</template>

<style scoped>



</style>
