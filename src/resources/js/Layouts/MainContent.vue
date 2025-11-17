<template>
    <div>
<TopBlock />
        <div v-if="activeTab === 'reviews'">
            <Reviews />
        </div>
        <div v-if="activeTab === 'settings'">
            <Settings  model-value=""/>
        </div>
    </div>
</template>

<script setup>
import { defineProps } from 'vue';
import Reviews from '../Pages/Reviews/Index.vue';
import Settings from '../Pages/Settings/Index.vue';
import TopBlock from "@/Layouts/TopBlock.vue";

const props = defineProps({
    activeTab: {
        type: String,
        required: true,
    },
});
</script>
