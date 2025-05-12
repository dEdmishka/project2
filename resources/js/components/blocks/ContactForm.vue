<script setup>
import { Label } from '@/components/ui/label'
import { Input } from '@/components/ui/input'
import { Button } from '@/components/ui/button'
import { Textarea } from '@/components/ui/textarea'


import { toast } from 'vue-sonner';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

import { motion } from 'motion-v'

const form = useForm({
    email: '',
    description: '',
});

const errors = ref({});

const submit = () => {
    form.post(`${props.mainUrl}`, {
        onError: (error) => {
            console.log(error);
            errors.value = error;
        },
        onSuccess: (event) => {
            const data = event.props.data;
            const successMessage = event.props.flash.success;
            toast('Success!', {
                variant: 'default',
                duration: 3000,
                description: successMessage,
                action: {
                    label: 'Got it',
                    onClick: () => console.log('Undo'),
                },
            });

            emit('update', data);
            emit('close', false);
        }
    })
};
</script>

<template>
    <motion.section class="grid grid-cols-1 py-20 gap-10 px-4 w-full" :animate="{
        opacity: [0, 1],
        x: [100, 0],
        transition: {
          type: 'spring',
          duration: 2,
          delay: 1
        }
      }">
        <div class="text-center lg:text-start space-y-6">
            <div class="grid grid-cols-1 gap-4">
                <div class="grid items-center gap-1">
                    <Label for="email" class="text-right">
                        {{ $t('pages.email') }}
                    </Label>
                    <Input id="email" type="email" class="col-span-3" required v-model="form.email" />
                    <span v-if="errors.email" class="text-red-600 text-sm">{{ errors.email }}</span>
                </div>
                <div class="grid items-center gap-1">
                    <Label for="description" class="text-right">
                        {{ $t('pages.message') }}
                    </Label>
                    <Textarea id="description" v-model="form.description" class="max-h-[175px]"></Textarea>
                    <span v-if="errors.description" class="text-red-600 text-sm">{{ errors.description }}</span>
                </div>
            </div>
            <Button type="submit" @click="submit">
                {{ $t('pages.send') }}
            </Button>
        </div>
    </motion.section>
</template>