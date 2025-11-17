<template>
    <div class="container">
        <div class="reviews-container">
            <div class="reviews-header">
                <div class="rating-number">47</div>
                <div class="stars">
                    <span v-for="n in 5" :key="n" class="star filled">★</span>
                </div>
            </div>
            <div class="divider"></div>
            <div class="reviews-list">
                <p>Всего отзывов {{ totalReviews }}</p>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    totalReviews: {
        type: Number,
        required: true,
    },
});
</script>

<style scoped>
.container {
    display: flex;
    gap: 20px;
}
.reviews-container {
    width: 263px;
    height: 155px;
    position: relative;
    border-radius: 12px;
    border: 1px solid #ffffff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    background-color: #fff;
    padding: 20px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    top: 50px;
}

.reviews-header {
    display: flex;
    align-items: center;
    gap: 10px;
}

.rating-number {
    font-size: 36px;
    font-weight: bold;
    color: #363740;
}
.stars {
    display: flex;
    gap: 3px;
}
.star {
    font-size: 20px;
    color: #ccc;
}
.star.filled {
    color: #f5b300;
}
.divider {
    height: 2px;
    background-color: #e0e0e0;
    margin: 10px 0;
    border-radius: 1px;
}
.reviews-list p {
    font-size: 14px;
    color: #363740;
    margin: 0;
}
</style>
