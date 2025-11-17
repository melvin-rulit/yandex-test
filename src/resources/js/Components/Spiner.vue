<template>
    <div class="spinner-overlay">
        <div class="spinner"></div>
    </div>
</template>

<script setup>
</script>

<style scoped>
.spinner-overlay {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.4);
    position: absolute;
    top: 0;
    left: 0;
    z-index: 999;
    border-radius: 12px;
}

.spinner {
    border: 4px solid #f3f3f3;
    border-top: 4px solid #363740;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
