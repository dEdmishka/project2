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
    centers: Array,
    departmentTypes: Array,
})

import { toast } from 'vue-sonner';
import { useForm } from '@inertiajs/vue3';
import { watch, ref } from 'vue';

const form = useForm({
    name: '',
    description: '',
    floor: '',
    center: '',
    department_type: '',
});

watch(
  () => props.currentCell,
  (newData) => {
    if (newData) {
      form.name = newData.name
      form.description = newData.description
      form.floor = newData.floor
      form.center = newData.center.id
      form.department_type = newData.departmentType.id
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
                <DialogTitle>Edit procedure</DialogTitle>
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
                        Floor
                    </Label>
                    <Input type="number" id="duration" class="col-span-3" required v-model="form.floor" />
                    <span v-if="errors.duration" class="text-red-600 text-sm">{{ errors.floor }}</span>
                </div>
                <div class="grid gap-2">
                    <Label for="select" class="text-right">
                        Select
                    </Label>
                    <Select id="center" v-model="form.center">
                        <SelectTrigger class="w-full">
                            <SelectValue placeholder="Select a center" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectLabel>Centers</SelectLabel>
                                <SelectItem v-for="(center, index) in centers" :value="center.id" :key="index">
                                    {{ center.name }}
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                </div>
                <div class="grid gap-2">
                    <Label for="select" class="text-right">
                        Select
                    </Label>
                    <Select id="department_type" v-model="form.department_type">
                        <SelectTrigger class="w-full">
                            <SelectValue placeholder="Select a department type" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectLabel>Department Types</SelectLabel>
                                <SelectItem v-for="(departmentType, index) in departmentTypes" :value="departmentType.id" :key="index">
                                    {{ departmentType.type }}
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