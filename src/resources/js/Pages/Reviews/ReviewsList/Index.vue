<template>
    <Spinner v-if="loading" />
    <div v-if="!loading" class="review-block">
        <div class="yandex-badge">
            <img :src="Vector" alt="Vector" class="badge-icon mr-2" />
            <span>Яндекс Карты</span>
        </div>

        <div class="review-content">
            <div
                v-if="nonEmptyReviews.length"
                v-for="(review, index) in nonEmptyReviews.slice(0, 5)"
                :key="index"
                class="review-item">
                <div class="review-card">
                    <div class="review-text-block">
                        <div class="review-header">
                            <div class="top-content-block">
                                <span class="top_content">12.09.2022 14:22 Филиал 1</span>
                                <img :src="Vector" alt="Vector" class="badge-icon" />
                            </div>

                            <div class="stars">
                            <span
                                v-for="n in 5"
                                :key="n"
                                class="star"
                                :class="{ filled: n <= review.rating }">
                                ★
                            </span>
                            </div>
                        </div>

                    <p>{{ review.author }}</p>
                    <div>
                        <p>{{ review.review_text }}</p>
                    </div>

                </div>
            </div>
            </div>

        </div>
    </div>
</template>


<script setup>
import {ref, onMounted, computed, defineEmits, watch} from 'vue';
import axios from 'axios';
import Vector from '@/../images/Vector.png';
import Spinner from '../../../Components/Spiner.vue';

const reviews = ref([]);
const emit = defineEmits(['updateReviewsCount']);
const loading = ref(true);

const fetchReviews = async () => {
    try {
        const response = await axios.get('/reviews');
        reviews.value = response.data;
    } catch (error) {
        console.error(error);
    } finally {
        loading.value = false;
    }
};
const formatDate = (dateString) => {
    const date = new Date(dateString);
    const options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    };
    return date.toLocaleDateString('ru-RU', options);
};

const nonEmptyReviews = computed(() => {
    return reviews.value.filter(review => review.review_text && review.review_text.trim() !== '');
});

const nonEmptyReviewsCount = computed(() => {
    return nonEmptyReviews.value.length;
});

watch(nonEmptyReviewsCount, (newCount) => {
    emit('updateReviewsCount', newCount);
});

onMounted(() => {
    fetchReviews();
});
</script>

<style scoped>
.review-block {
    display: flex;
    flex-direction: column;
    gap: 20px;
}
.review-content {
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.review-item {
    width: 100%;
}
.review-card {
    padding: 16px;
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border: 1px solid #ddd;
}
.review-card p {
    font-size: 14px;
    color: #363740;
}
.review-card strong {
    color: #333;
}
.review-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
}
.top_content {
    font-weight: 700;
    font-size: 12px;
    color: #363740;
}
.stars {
    display: flex;
    gap: 3px;
}
.star {
    font-size: 16px;
    color: #ccc;
}
.star.filled {
    color: #f5b300;
}
.review-text-block {
    background-color: #F6F8FA;
    padding: 5px;
    border-radius: 6px;
}
.yandex-badge {
    display: inline-flex;
    align-items: center;
    font-family: 'Mulish', sans-serif;
    font-weight: 500;
    font-style: normal;
    font-size: 12px;
    line-height: 100%;
    letter-spacing: 0px;
    color: #363740;
    border: 1px solid #DCE4EA;
    border-radius: 8px;
    padding: 2px 6px;
    width: max-content;
}
.top-content-block {
    display: flex;
    align-items: center;
    gap: 6px;
}
.top_content {
    font-size: 14px;
    color: #555;
}
.badge-icon {
    width: 16px;
    height: 16px;
}

</style>
