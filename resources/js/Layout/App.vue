<script setup>
import AppSidebar from "@/components/account/layout/AppSidebar.vue"
import NavActions from '@/components/account/layout/NavActions.vue'
import Navbar from "@/components/blocks/Navbar.vue"
import Footer from "@/components/blocks/Footer.vue"
import Hero from '@/components/blocks/Hero.vue'
import About from '@/components/blocks/About.vue'
import {
    Breadcrumb,
    BreadcrumbItem,
    BreadcrumbLink,
    BreadcrumbList,
    BreadcrumbPage,
    BreadcrumbSeparator,
} from "@/components/ui/breadcrumb"
import { Separator } from "@/components/ui/separator"
import {
    SidebarInset,
    SidebarProvider,
    SidebarTrigger,
} from "@/components/ui/sidebar"
import { Button } from "@/components/ui/button"
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