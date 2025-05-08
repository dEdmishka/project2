<script setup>
// import UserNavActions from '@/components/account/layout/user/NavActions.vue'
// import UserAppSidebar from '@/components/account/layout/user/AppSidebar.vue'

// import StaffNavActions from '@/components/account/layout/staff/NavActions.vue'
// import StaffAppSidebar from '@/components/account/layout/staff/AppSidebar.vue'

// import PatientNavActions from '@/components/account/layout/patient/NavActions.vue'
// import PatientAppSidebar from '@/components/account/layout/patient/AppSidebar.vue'

// import AdminNavActions from '@/components/admin/layout/NavActions.vue'
// import AdminAppSidebar from '@/components/admin/layout/AppSidebar.vue'

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
import { Toaster } from '@/components/ui/sonner'

import { defineAsyncComponent, computed, ref, onBeforeMount, watch } from 'vue'
import { usePage, router } from '@inertiajs/vue3'

import Loader from '@/components/blocks/Loader.vue'

const StaffNavActions = defineAsyncComponent(() => import('@/components/account/layout/staff/NavActions.vue'))
const StaffAppSidebar = defineAsyncComponent(() => import('@/components/account/layout/staff/AppSidebar.vue'))

const PatientNavActions = defineAsyncComponent(() => import('@/components/account/layout/patient/NavActions.vue'))
const PatientAppSidebar = defineAsyncComponent(() => import('@/components/account/layout/patient/AppSidebar.vue'))

const UserNavActions = defineAsyncComponent(() => import('@/components/account/layout/user/NavActions.vue'))
const UserAppSidebar = defineAsyncComponent(() => import('@/components/account/layout/user/AppSidebar.vue'))

const AdminNavActions = defineAsyncComponent(() => import('@/components/admin/layout/NavActions.vue'))
const AdminAppSidebar = defineAsyncComponent(() => import('@/components/admin/layout/AppSidebar.vue'))

const page = usePage()
const user = page.props.user

const navActions = computed(() => {
    if (user.role === 'admin') return 'AdminNavActions'
    if (user.patient) return 'PatientNavActions'
    if (user.staff) return 'StaffNavActions'

    return 'UserNavActions'
})

const appSidebar = computed(() => {
    if (user.role === 'admin') return 'AdminAppSidebar'
    if (user.patient) return 'PatientAppSidebar'
    if (user.staff) return 'StaffAppSidebar'

    return 'UserAppSidebar'
})

const components = {
    AdminNavActions,
    AdminAppSidebar,
    PatientNavActions,
    PatientAppSidebar,
    StaffNavActions,
    StaffAppSidebar,
    UserNavActions,
    UserAppSidebar,
}


// const props = defineProps({
//     loading: Boolean,
// })

const isLoading = ref(false)
const isSidebarOpen = ref(false)

const toggleSidebar = () => {
    isSidebarOpen.value = !isSidebarOpen.value
    console.log('opened!')
}

onBeforeMount(() => {
    router.on('start', () => {
        isLoading.value = true
    })

    router.on('finish', () => {
        isLoading.value = false
    })
})

import { cn } from '@/lib/utils';
import { motion } from 'motion-v'
</script>

<template>
    <Loader :show="isLoading" />
    <Toaster />

    <SidebarProvider @update:open="toggleSidebar">
        <component :is="components[appSidebar]" v-if="appSidebar" />
        <!-- <AdminAppSidebar /> -->
        <SidebarInset :class="cn({ 'md:max-w-[calc(100dvw-17rem)]': !isSidebarOpen })">
            <header
                class="flex h-16 shrink-0 items-center transition-[width,height] ease-linear group-has-[[data-collapsible=icon]]/sidebar-wrapper:h-12">
                <div class="flex px-5">
                    <SidebarTrigger class="" />
                </div>
                <div class="ml-auto flex-1">
                    <!-- <AdminNavActions /> -->
                    <component :is="components[navActions]" v-if="navActions" />
                </div>
            </header>
            <main class="flex flex-1 flex-col gap-4 p-4 lg:gap-6 lg:p-6">
                <motion.div class="flex flex-col" :animate="{
                    opacity: [0, 1],
                    x: [50, 0],
                    transition: {
                        type: 'linear',
                        duration: 0.5,
                        delay: 0.05
                    }
                }">
                    <h1
                        class="inline text-left font-bold text-2xl md:text-4xl py-2 bg-gradient-to-r from-[#F596D3]  to-[#D247BF] text-transparent bg-clip-text">
                        <slot name="title"></slot>
                    </h1>
                    <Separator class="" />
                </motion.div>
                <div>
                    <!-- <div class="flex flex-1 items-center justify-center rounded-lg border border-dashed shadow-sm"> -->
                    <slot />
                </div>
            </main>
        </SidebarInset>
    </SidebarProvider>
</template>