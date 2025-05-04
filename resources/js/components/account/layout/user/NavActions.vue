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
import SheetDescription from '@/components/ui/sheet/SheetDescription.vue';

const form = useForm({});

const logout = () => {
    form.post('/logout');
}
</script>

<template>
    <NavigationMenu class="">
        <NavigationMenuList class="container h-14 px-4 flex justify-between">
            <!-- <NavigationMenuItem class="font-bold flex items-center">
                <Link rel="noreferrer noopener" href="/" class="ml-2 font-bold text-xl flex">
                <Github />
                ShadcnUI/Vue
                </Link>
            </NavigationMenuItem> -->

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
                        <!-- <nav class="flex flex-col justify-center items-center gap-2 mt-4">
                            <Link v-for="route in routeList" :key="route.label" :href="route.href"
                                rel="noreferrer noopener" :class="buttonVariants({ variant: 'ghost' })">
                            {{ route.label }}
                            </Link>
                            <a rel="noreferrer noopener" href="https://github.com/leoMirandaa/shadcn-landing-page.git"
                                target="_blank" :class="`w-[110px] border ${buttonVariants({ variant: 'secondary' })}`">
                                <Github class="mr-2 w-5 h-5" />
                                Github
                            </a>
                        </nav> -->
                        <SheetDescription>
                            afafa
                        </SheetDescription>
                    </SheetContent>
                </Sheet>

                <DropdownMenu>
                    <DropdownMenuTrigger as-child>
                        <Button variant="ghost" size="icon" class="h-7 w-7">
                            <MoreHorizontal />
                        </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent class="w-56 rounded-lg mr-4">
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
            <!-- <nav class="hidden md:flex items-center gap-2">
                <Link v-for="(route, i) in routeList" :key="i" :href="route.href" rel="noreferrer noopener"
                    :class="`text-[17px] ${buttonVariants({ variant: 'ghost' })}`">
                {{ route.label }}
                </Link>
            </nav> -->

            <div class="hidden md:flex items-center gap-2">
                <a rel="noreferrer noopener" href="https://github.com/leoMirandaa/shadcn-landing-page.git"
                    target="_blank" :class="`border ${buttonVariants({ variant: 'secondary' })}`">
                    <Github class="mr-2 w-5 h-5" />
                    Github
                </a>

                <ThemeModeToggler />
                <DropdownMenu>
                    <DropdownMenuTrigger as-child>
                        <Button variant="ghost" size="icon" class="h-7 w-7">
                            <MoreHorizontal />
                        </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent class="w-56 rounded-lg mr-4">
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
        </NavigationMenuList>
    </NavigationMenu>
</template>
