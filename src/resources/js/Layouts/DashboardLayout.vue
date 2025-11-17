<template>
    <div class="flex min-h-screen flex-col">

        <div class="flex flex-1">
            <Sidebar @changeTab="changeTab" />
            <MainContent :activeTab="activeTab" />
        </div>
    </div>
</template>

<script setup>
import {ref} from 'vue';
import Sidebar from './Sidebar.vue';
import MainContent from './MainContent.vue';

const activeTab = ref('reviews');

const changeTab = (tab) => {
    activeTab.value = tab;
};
</script>

<style scoped>
.flex {
    display: flex;
}
.min-h-screen {
    min-height: 100vh;
}
.flex-1 {
    flex: 1;
}
</style>
