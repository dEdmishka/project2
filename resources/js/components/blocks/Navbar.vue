<script setup>
import {
    NavigationMenu,
    NavigationMenuItem,
    NavigationMenuList,
} from "@/components/ui/navigation-menu";
import {
    Sheet,
    SheetContent,
    SheetHeader,
    SheetTitle,
    SheetTrigger,
} from "@/components/ui/sheet";

import { Link } from "@inertiajs/vue3"
import { buttonVariants } from "@/components/ui/button";
import {
    Menu,
    Github
} from 'lucide-vue-next'

const routeList = [
    {
        href: "/",
        label: "Home",
    },
    {
        href: "/about",
        label: "About",
    },
    {
        href: "/contacts",
        label: "Contacts",
    },
    {
        href: "/help",
        label: "Help",
    },
];

import ThemeModeToggler from "@/components/blocks/ThemeModeToggler.vue";
import NavActions from '@/components/account/layout/NavActions.vue'
</script>

<template>
    <header class="sticky border-b-[1px] top-0 z-40 w-full bg-white dark:border-b-slate-700 dark:bg-background">
        <NavigationMenu class="mx-auto">
            <NavigationMenuList class="container h-14 px-4 w-screen flex justify-between">
                <NavigationMenuItem  class="font-bold flex items-center">
                    <Link rel="noreferrer noopener" href="/" class="ml-2 font-bold text-xl flex">
                        <Github />
                        ShadcnUI/Vue
                    </Link>
                </NavigationMenuItem >

                <!-- mobile -->
                <span class="flex items-center md:hidden">
                    <ThemeModeToggler />

                    <Sheet>
                        <SheetTrigger class="px-2">
                            <Menu class="flex md:hidden h-5 w-5">
                                <span class="sr-only">Menu Icon</span>
                            </Menu>
                        </SheetTrigger>

                        <SheetContent side="left">
                            <SheetHeader>
                                <SheetTitle class="font-bold text-xl">
                                    Shadcn/Vue
                                </SheetTitle>
                            </SheetHeader>
                            <nav class="flex flex-col justify-center items-center gap-2 mt-4">
                                <Link v-for="route in routeList" :key="route.label" :href="route.href"
                                    rel="noreferrer noopener" :class="buttonVariants({ variant: 'ghost' })">
                                    {{ route.label }}
                                </Link>
                                <a rel="noreferrer noopener"
                                    href="https://github.com/leoMirandaa/shadcn-landing-page.git" target="_blank"
                                    :class="`w-[110px] border ${buttonVariants({ variant: 'secondary' })}`">
                                    <Github class="mr-2 w-5 h-5" />
                                    Github
                                </a>
                            </nav>
                        </SheetContent>
                    </Sheet>

                    <NavActions />
                </span>

                <!-- desktop -->
                <nav class="hidden md:flex items-center gap-2">
                    <Link v-for="(route, i) in routeList" :key="i" :href="route.href" rel="noreferrer noopener"
                        :class="`text-[17px] ${buttonVariants({ variant: 'ghost' })}`">
                        {{ route.label }}
                    </Link>
                </nav>

                <div class="hidden md:flex items-center gap-2">
                    <a rel="noreferrer noopener" href="https://github.com/leoMirandaa/shadcn-landing-page.git"
                        target="_blank" :class="`border ${buttonVariants({ variant: 'secondary' })}`">
                        <Github class="mr-2 w-5 h-5" />
                        Github
                    </a>

                    <ThemeModeToggler />
                    <NavActions />
                </div>
            </NavigationMenuList>
        </NavigationMenu>
    </header>
</template>