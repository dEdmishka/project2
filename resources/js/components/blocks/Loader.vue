<script setup>
defineProps({
    show: {
        type: Boolean,
        required: true
    }
})
</script>

<template>
    <div v-if="show" class="fixed inset-0 flex items-center justify-center bg-white/70 z-1000">
        <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-blue-500"></div>
    </div>
</template>