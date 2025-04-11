<script setup>
import {
    CornerUpLeft,
} from 'lucide-vue-next'

import { useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';

const form = useForm({});

const logout = () => {
    form.post('/admin/logout');
}

</script>

<template>
    <div class="flex items-center gap-2 text-sm">
        <Button class="p-1" @click="logout">
            <div class="flex gap-2 p-2">
                <CornerUpLeft /><span>Logout</span>
            </div>
        </Button>
    </div>
</template>
