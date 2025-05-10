<script setup>
import { Button } from '@/components/ui/button'
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
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuGroup,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'
import { buttonVariants } from "@/components/ui/button";
import ThemeModeToggler from "@/components/blocks/ThemeModeToggler.vue";
import {
    CornerUpLeft,
    MoreHorizontal,
    Settings2,
    User,
    Menu,
    Github
} from 'lucide-vue-next'

import { useForm } from '@inertiajs/vue3';
import { Link } from "@inertiajs/vue3"
import NotificationMenu from '@/components/blocks/NotificationMenu.vue';

const form = useForm({});

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

const logout = () => {
    form.post('/logout');
}
</script>

<template>
    <NavigationMenu class="max-w-full">
        <div class="container h-14 px-4 w-full flex justify-between gap-2">
            <NavigationMenuItem class="font-bold flex justify-between">
                <Link rel="noreferrer noopener" href="/" class="ml-2 font-bold text-xl flex">
                <div class="text-2xl font-bold my-auto">
                    <h1 class="inline">
                        <span
                            class="inline bg-gradient-to-r from-[#F596D3]  to-[#D247BF] text-transparent bg-clip-text">Rehab</span>
                        <span
                            class="inline bg-gradient-to-r from-[#61DAFB] via-[#1fc0f1] to-[#03a3d7] text-transparent bg-clip-text">System</span>
                    </h1>
                </div>
                </Link>
            </NavigationMenuItem>

            <!-- mobile -->
            <span class="flex items-center xl:hidden">
                <NotificationMenu />
                <ThemeModeToggler />

                <Sheet>
                    <SheetTrigger class="px-2">
                        <Menu class="flex xl:hidden h-5 w-5">
                            <span class="sr-only">Menu Icon</span>
                        </Menu>
                    </SheetTrigger>

                    <SheetContent side="left">
                        <SheetTrigger class="px-2">
                            <Menu class="flex xl:hidden h-5 w-5">
                                <span class="sr-only">Menu Icon</span>
                            </Menu>
                        </SheetTrigger>

                        <SheetContent side="left">
                            <SheetHeader>
                                <SheetTitle class="font-bold text-xl inline">
                                    <span
                                        class="inline bg-gradient-to-r from-[#F596D3]  to-[#D247BF] text-transparent bg-clip-text">Rehab</span>
                                    <span
                                        class="inline bg-gradient-to-r from-[#61DAFB] via-[#1fc0f1] to-[#03a3d7] text-transparent bg-clip-text">System</span>
                                </SheetTitle>
                            </SheetHeader>
                            <nav class="flex flex-col justify-center items-center gap-2 mt-4">
                                <Link v-for="route in routeList" :key="route.label" :href="route.href"
                                    rel="noreferrer noopener" :class="buttonVariants({ variant: 'ghost' })">
                                {{ route.label }}
                                </Link>
                                <a rel="noreferrer noopener" href="https://github.com/dEdmishka" target="_blank"
                                    :class="`w-[110px] border ${buttonVariants({ variant: 'secondary' })}`">
                                    <Github class="mr-2 w-5 h-5" />
                                    Github
                                </a>
                            </nav>
                        </SheetContent>
                    </SheetContent>
                </Sheet>

                <DropdownMenu>
                    <DropdownMenuTrigger as-child>
                        <Button variant="ghost" size="icon" class="h-7 w-7">
                            <MoreHorizontal />
                        </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent class="w-56 rounded-xl mr-4">
                        <DropdownMenuGroup class="border-b last:border-none">
                            <DropdownMenuItem>
                                <Link href="/account" class="flex gap-2 p-2">
                                <User /><span>My Account</span>
                                </Link>
                            </DropdownMenuItem>
                        </DropdownMenuGroup>
                        <DropdownMenuGroup class="border-b last:border-none">
                            <DropdownMenuItem>
                                <Link href="/settings" class="flex gap-2 p-2">
                                <Settings2 /><span>Settings</span>
                                </Link>
                            </DropdownMenuItem>
                        </DropdownMenuGroup>
                        <DropdownMenuGroup class="border-b last:border-none">
                            <DropdownMenuItem @click="logout">
                                <div class="flex gap-2 p-2">
                                    <CornerUpLeft /><span>Logout</span>
                                </div>
                            </DropdownMenuItem>
                        </DropdownMenuGroup>
                    </DropdownMenuContent>
                </DropdownMenu>
            </span>

            <!-- desktop -->
            <nav class="hidden xl:flex flex-1 items-center justify-center gap-2">
                <Link v-for="(route, i) in routeList" :key="i" :href="route.href" rel="noreferrer noopener"
                    :class="`text-[17px] ${buttonVariants({ variant: 'ghost' })}`">
                {{ route.label }}
                </Link>
            </nav>

            <div class="hidden xl:flex items-center gap-2">
                <a rel="noreferrer noopener" href="https://github.com/leoMirandaa/shadcn-landing-page.git"
                    target="_blank" :class="`border ${buttonVariants({ variant: 'secondary' })}`">
                    <Github class="mr-2 w-5 h-5" />
                    Github
                </a>

                <NotificationMenu />
                <ThemeModeToggler />
                <DropdownMenu>
                    <DropdownMenuTrigger as-child>
                        <Button variant="ghost" size="icon" class="h-7 w-7">
                            <MoreHorizontal />
                        </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent class="w-56 rounded-xl mr-4">
                        <DropdownMenuGroup class="border-b last:border-none">
                            <DropdownMenuItem>
                                <Link href="/account" class="flex gap-2 p-2">
                                <User /><span>My Account</span>
                                </Link>
                            </DropdownMenuItem>
                        </DropdownMenuGroup>
                        <DropdownMenuGroup class="border-b last:border-none">
                            <DropdownMenuItem>
                                <Link href="/settings" class="flex gap-2 p-2">
                                <Settings2 /><span>Settings</span>
                                </Link>
                            </DropdownMenuItem>
                        </DropdownMenuGroup>
                        <DropdownMenuGroup class="border-b last:border-none">
                            <DropdownMenuItem @click="logout">
                                <div class="flex gap-2 p-2">
                                    <CornerUpLeft /><span>Logout</span>
                                </div>
                            </DropdownMenuItem>
                        </DropdownMenuGroup>
                    </DropdownMenuContent>
                </DropdownMenu>
            </div>
        </div>
    </NavigationMenu>
</template>
