<script setup>
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog'

import { Button } from '@/components/ui/button'

const props = defineProps({
    currentCell: Object,
    showDialog: Boolean,
    mainUrl: String,
})

import { toast } from 'vue-sonner';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({});

const emit = defineEmits(['update', 'close']);
const errors = ref({});

const submit = () => {
    form.delete(`${props.mainUrl}/${props.currentCell.id}`, {
        onError: (error) => {
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
    <Dialog :value="showDialog">
        <!-- <DialogTrigger as-child>
                <Button variant="outline">
                    Edit Profile
                </Button>
            </DialogTrigger> -->
        <DialogContent class="sm:max-w-[425px]">
            <DialogHeader>
                <DialogTitle>{{ $t('admin.center.delete') }}</DialogTitle>
                <DialogDescription>
                    {{ $t('admin.center.make_changes') }}
                </DialogDescription>
            </DialogHeader>
            <div class="grid gap-4 py-4">
                <h3>{{ $t('admin.you_sure') }} {{ currentCell.name }}?</h3>
                <span v-if="errors" class="text-red-600 text-sm">{{ errors.msg }}</span>
            </div>
            <DialogFooter>
                <Button type="submit" @click="submit">
                    {{ $t('label.delete') }}
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>