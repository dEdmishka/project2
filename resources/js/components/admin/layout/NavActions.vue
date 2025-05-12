<script setup>
import {
    CornerUpLeft,
} from 'lucide-vue-next'

import { useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import {
    NavigationMenu,
} from "@/components/ui/navigation-menu";

const form = useForm({});

const logout = () => {
    form.post('/admin/logout');
}

</script>

<template>
    <NavigationMenu class="max-w-full">
        <div class="container h-14 px-4 w-full flex justify-between gap-2">
            <div class="flex items-center gap-2 text-sm ml-auto">
                <Button class="p-1" @click="logout">
                    <div class="flex gap-2 p-2">
                        <CornerUpLeft /><span>{{ $t('auth.title.logout') }}</span>
                    </div>
                </Button>
            </div>
        </div>
    </NavigationMenu>
</template>
