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

</script>

<template>
    <Toaster />

    <Navbar />
    <main class="container mx-auto">
        <slot />
    </main>
    <Footer />
    <ScrollToTop />
    <!-- <SidebarProvider>
        <AppSidebar />
        <SidebarInset>
            <header
                class="flex h-16 shrink-0 items-center gap-2 transition-[width,height] ease-linear group-has-[[data-collapsible=icon]]/sidebar-wrapper:h-12">
                <div class="flex items-center gap-2 px-4">
                    <SidebarTrigger class="-ml-1" />
                    <Separator orientation="vertical" class="mr-2 h-4" />
                    <Breadcrumb>
                        <BreadcrumbList>
                            <BreadcrumbItem class="hidden md:block">
                                <BreadcrumbLink href="#">
                                    Building Your Application
                                </BreadcrumbLink>
                            </BreadcrumbItem>
                            <BreadcrumbSeparator class="hidden md:block" />
                            <BreadcrumbItem>
                                <BreadcrumbPage>Data Fetching</BreadcrumbPage>
                            </BreadcrumbItem>
                        </BreadcrumbList>
                    </Breadcrumb>
                </div>
                <div class="ml-auto px-3">
                    <NavActions />
                </div>
            </header>
            <div class="flex flex-1 items-center justify-center rounded-lg border border-dashed shadow-sm">
                <slot />
            </div>
        </SidebarInset>
    </SidebarProvider> -->
</template>