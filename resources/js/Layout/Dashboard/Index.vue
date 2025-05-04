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

    <SidebarProvider>
        <component :is="components[appSidebar]" v-if="appSidebar" />
        <!-- <AdminAppSidebar /> -->
        <SidebarInset>
            <header
                class="flex h-16 shrink-0 items-center gap-2 transition-[width,height] ease-linear group-has-[[data-collapsible=icon]]/sidebar-wrapper:h-12">
                <div class="flex items-center gap-2 px-5">
                    <SidebarTrigger class="" />
                </div>
                <div class="ml-auto px-3">
                    <!-- <AdminNavActions /> -->
                    <component :is="components[navActions]" v-if="navActions" />
                </div>
            </header>
            <main class="flex flex-1 flex-col gap-4 p-4 lg:gap-6 lg:p-6">
                <div class="flex items-center">
                    <h1 class="text-lg font-semibold md:text-2xl">
                        <slot name="title"></slot>
                    </h1>
                </div>
                <div>
                    <!-- <div class="flex flex-1 items-center justify-center rounded-lg border border-dashed shadow-sm"> -->
                    <slot />
                </div>
            </main>
        </SidebarInset>
    </SidebarProvider>
</template>