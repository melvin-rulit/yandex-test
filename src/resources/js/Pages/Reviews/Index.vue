<template>
    <div class="main-content-container">
        <div class="content">
            <ReviewsList @updateReviewsCount="updateReviewsCount"/>
            <ReviewsStats :totalReviews="totalReviews"/>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import ReviewsList from './ReviewsList/Index.vue';
import ReviewsStats from './ReviewsStats/Index.vue';

const totalReviews = ref(0);
const updateReviewsCount = (count) => {
    totalReviews.value = count;
};
</script>

<style scoped>
.main-content-container {
    display: flex;
    justify-content: space-between;
    padding: 20px;
}
.content {
    display: flex;
    gap: 20px;
    width: 100%;
}
</style>
