<script setup>
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog'

import { Label } from '@/components/ui/label'
import { Input } from '@/components/ui/input'
import { Button } from '@/components/ui/button'
import { Textarea } from '@/components/ui/textarea'
import { Checkbox } from '@/components/ui/checkbox'
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select'

const props = defineProps({
    currentCell: Object,
    showDialog: Boolean,
    mainUrl: String,
})

import { toast } from 'vue-sonner';
import { useForm } from '@inertiajs/vue3';
import { watch, ref } from 'vue';

const form = useForm({
    name: '',
    description: '',
    duration: '',
    price: '',
    is_active: false,
});

watch(
  () => props.currentCell,
  (newData) => {
    if (newData) {
      form.name = newData.name
      form.description = newData.description
      form.duration = newData.duration
      form.price = newData.price
      form.is_active = !!newData.is_active
    }
  },
  { immediate: true }
)

const emit = defineEmits(['update', 'close']);
const errors = ref({});

const submit = () => {
    form.put(`${props.mainUrl}/${props.currentCell.id}`, {
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
        <DialogContent class="sm:max-w-[425px]">
            <DialogHeader>
                <DialogTitle>{{ $t('admin.procedure.edit') }}</DialogTitle>
                <DialogDescription>
                    {{ $t('admin.procedure.make_changes') }}
                </DialogDescription>
            </DialogHeader>
            <div class="grid gap-4 py-4">
                <div class="grid items-center gap-2">
                    <Label for="name" class="text-right">
                        {{ $t('label.name') }}
                    </Label>
                    <Input id="name" class="col-span-3" required v-model="form.name" />
                    <span v-if="errors.name" class="text-red-600 text-sm">{{ errors.name }}</span>
                </div>
                <div class="grid items-center gap-2">
                    <Label for="description" class="text-right">
                        {{ $t('label.description') }}
                    </Label>
                    <Textarea v-model="form.description"></Textarea>
                    <span v-if="errors.description" class="text-red-600 text-sm">{{ errors.description }}</span>
                </div>
                <div class="grid items-center gap-2">
                    <Label for="duration" class="text-right">
                        {{ $t('label.duration') }}
                    </Label>
                    <Input type="number" id="duration" class="col-span-3" required v-model="form.duration" />
                    <span v-if="errors.duration" class="text-red-600 text-sm">{{ errors.price }}</span>
                </div>
                <div class="grid items-center gap-2">
                    <Label for="price" class="text-right">
                        {{ $t('label.price') }}
                    </Label>
                    <Input type="number" id="price" class="col-span-3" required v-model="form.price" />
                    <span v-if="errors.price" class="text-red-600 text-sm">{{ errors.price }}</span>
                </div>
                <div class="grid items-center gap-2">
                    <Label for="status" class="text-right">
                        {{ $t('label.status') }}
                    </Label>
                    <Checkbox v-model="form.is_active" :checked="form.is_active == 1" />
                </div>
            </div>
            <DialogFooter>
                <Button type="submit" @click="submit">
                    {{ $t('label.save_changes') }}
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>