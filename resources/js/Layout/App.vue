<script setup>
import Navbar from "@/components/blocks/Navbar.vue"
import Footer from "@/components/blocks/Footer.vue"
import { Toaster } from '@/components/ui/sonner'
import ScrollToTop from "@/components/blocks/ScrollToTop.vue"

import { ref, onBeforeMount } from 'vue'
import { router } from '@inertiajs/vue3'

import Loader from '@/components/blocks/Loader.vue'

const isLoading = ref(false)

onBeforeMount(() => {
    router.on('start', () => {
        isLoading.value = true
    })

    router.on('finish', () => {
        isLoading.value = false
    })
})
</script>

<template>
    <Loader :show="isLoading" />
    <Toaster />

    <Navbar />
    <main class="container mx-auto">
        <slot />
    </main>
    <Footer />
    <ScrollToTop />
</template>