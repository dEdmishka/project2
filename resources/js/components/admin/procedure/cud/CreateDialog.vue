<script setup>
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
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
    showDialog: Boolean,
    mainUrl: String,
})

import { toast } from 'vue-sonner';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({
    name: '',
    description: '',
    duration: '',
    price: '',
    is_active: false,
});

const emit = defineEmits(['update', 'close']);
const errors = ref({});

const submit = () => {
    form.post(`${props.mainUrl}`, {
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
                <DialogTitle>Create procedure</DialogTitle>
                <DialogDescription>
                    Make changes to your procedure here. Click save when you're done.
                </DialogDescription>
            </DialogHeader>
            <div class="grid gap-4 py-4">
                <div class="grid items-center gap-2">
                    <Label for="name" class="text-right">
                        Name
                    </Label>
                    <Input id="name" class="col-span-3" required v-model="form.name" />
                    <span v-if="errors.name" class="text-red-600 text-sm">{{ errors.name }}</span>
                </div>
                <div class="grid items-center gap-2">
                    <Label for="description" class="text-right">
                        Description
                    </Label>
                    <Textarea v-model="form.description"></Textarea>
                    <span v-if="errors.description" class="text-red-600 text-sm">{{ errors.description }}</span>
                </div>
                <div class="grid items-center gap-2">
                    <Label for="duration" class="text-right">
                        Duration
                    </Label>
                    <Input type="number" id="duration" class="col-span-3" required v-model="form.duration" />
                    <span v-if="errors.duration" class="text-red-600 text-sm">{{ errors.price }}</span>
                </div>
                <div class="grid items-center gap-2">
                    <Label for="price" class="text-right">
                        Price
                    </Label>
                    <Input type="number" id="price" class="col-span-3" required v-model="form.price" />
                    <span v-if="errors.price" class="text-red-600 text-sm">{{ errors.price }}</span>
                </div>
                <div class="grid items-center gap-2">
                    <Label for="status" class="text-right">
                        Status
                    </Label>
                    <Checkbox v-model="form.is_active" :checked="form.is_active == 1" />
                </div>
                <div class="grid gap-2">
                    <Label for="select" class="text-right">
                        Select
                    </Label>
                    <Select id="select">
                        <SelectTrigger class="w-full">
                            <SelectValue placeholder="Select a fruit" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectLabel>Fruits</SelectLabel>
                                <SelectItem value="apple">
                                    Apple
                                </SelectItem>
                                <SelectItem value="banana">
                                    Banana
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                </div>
            </div>
            <DialogFooter>
                <Button type="submit" @click="submit">
                    Save changes
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>