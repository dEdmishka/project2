<script setup>
import { Button } from '@/components/ui/button'

import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuGroup,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'

import {
    CornerUpLeft,
    MoreHorizontal,
    Settings2,
    User,
} from 'lucide-vue-next'

import { useForm } from '@inertiajs/vue3';
import { Link } from "@inertiajs/vue3"

const form = useForm({});

const logout = () => {
    form.post('/logout');
}
// const data = [
//     [
//         {
//             label: "My Account",
//             url: "/account",
//             icon: User,
//         },
//     ],
//     [
//         {
//             label: "Settings",
//             url: "/settings",
//             icon: Settings2,
//         },
//     ],
//     [
//         {
//             label: "Logout",
//             url: "/logout",
//             icon: CornerUpLeft,
//         },
//     ],
// ]
</script>

<template>
    <div class="flex items-center gap-2 text-sm">
        <!-- <div class="hidden font-medium text-muted-foreground md:inline-block">
            Edit Oct 08
        </div>
        <Button variant="ghost" size="icon" class="h-7 w-7">
            <Star />
        </Button> -->
        <!-- <DropdownMenu>
            <DropdownMenuTrigger as-child>
                <Button variant="ghost" size="icon" class="h-7 w-7">
                    <MoreHorizontal />
                </Button>
            </DropdownMenuTrigger>
            <DropdownMenuContent class="w-56 rounded-lg mr-4">
                <DropdownMenuGroup v-for="(group, index) in data" :key="index" class="border-b last:border-none">
                    <DropdownMenuItem v-for="(item, index) in group" :key="index">
                        <Link :href="item.url" class="flex gap-2 p-2">
                        <component :is="item.icon" />
                        <span>{{ item.label }}</span>
                        </Link>
                    </DropdownMenuItem>
                </DropdownMenuGroup>
            </DropdownMenuContent>
        </DropdownMenu> -->
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
</template>
