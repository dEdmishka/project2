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
    centers: Array,
})

import { toast } from 'vue-sonner';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    birth_date: '',
    gender: '',
    status: '',
    center: '',
    phones: [{ phone_number: '' }],
    social_links: [{ url: '' }],
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
                <DialogTitle>Create department</DialogTitle>
                <DialogDescription>
                    Make changes to your patient here. Click save when you're done.
                </DialogDescription>
            </DialogHeader>
            <div class="grid gap-4 py-4">
                <div class="grid grid-cols-2 gap-2">
                    <div class="grid items-center gap-2">
                        <Label for="first_name" class="text-right">
                            First Name
                        </Label>
                        <Input id="first_name" class="col-span-3" required v-model="form.first_name" />
                        <span v-if="errors.first_name" class="text-red-600 text-sm">{{ errors.first_name }}</span>
                    </div>
                    <div class="grid items-center gap-2">
                        <Label for="last_name" class="text-right">
                            Last Name
                        </Label>
                        <Input id="last_name" class="col-span-3" required v-model="form.last_name" />
                        <span v-if="errors.last_name" class="text-red-600 text-sm">{{ errors.last_name }}</span>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div class="grid items-center gap-2">
                        <Label for="email" class="text-right">
                            Email
                        </Label>
                        <Input id="email" class="col-span-3" required v-model="form.email" />
                        <span v-if="errors.email" class="text-red-600 text-sm">{{ errors.email }}</span>
                    </div>
                    <div class="grid items-center gap-2">
                        <Label for="birth_date" class="text-right">
                            Birth Date
                        </Label>
                        <Input id="birth_date" type="date" class="col-span-3" required v-model="form.birth_date" />
                        <span v-if="errors.birth_date" class="text-red-600 text-sm">{{ errors.birth_date }}</span>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div class="grid items-center gap-2">
                        <Label for="gender" class="text-right">
                            Male
                        </Label>
                        <Checkbox v-model="form.gender" :checked="form.gender == 'M'" />
                    </div>
                    <div class="grid items-center gap-2">
                        <Label for="status" class="text-right">
                            Status
                        </Label>
                        <Checkbox v-model="form.is_active" :checked="form.is_active == 1" />
                    </div>
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
                <div class="grid grid-cols-2 gap-2">

                    <div class="grid items-center gap-1">
                        <Label for="name" class="text-right">
                            Соціальні мережі
                        </Label>
                        <div class="space-y-2">
                            <div v-for="(social, index) in form.social_links" :key="'social-' + index"
                                class="flex gap-2">
                                <div class="flex flex-col items-start gap-1 flex-1">
                                    <Input v-model="social.url"
                                        placeholder="Social URL (e.g. https://instagram.com/center)" />
                                    <span v-if="errors[`social_links.${index}.number`]" class="text-red-600 text-sm">
                                        {{ errors[`social_links.${index}.number`] }}
                                    </span>
                                </div>
                                <Button variant="destructive" size="icon"
                                    @click.prevent="form.social_links.splice(index, 1)"
                                    v-if="form.social_links.length > 1">
                                    <Trash class="h-4 w-4" />
                                </Button>
                            </div>
                        </div>
                        <Button type="button" variant="outline" class="mt-2"
                            @click="(form.social_links.length < 3) ? form.social_links.push({ url: '' }) : null">
                            <Plus class="h-4 w-4 mr-1" /> Додати Соцільну Мережу
                        </Button>
                    </div>

                    <div class="grid items-center gap-1">
                        <Label for="name" class="text-right">
                            Телефони
                        </Label>
                        <div class="space-y-2">
                            <div v-for="(phone, index) in form.phones" :key="index" class="flex gap-2">
                                <div class="flex flex-col items-start gap-1 flex-1">
                                    <Input v-model="phone.phone_number" @input="(e) => formatPhone(e, index)"
                                        placeholder="(0XX)-XXX-XX-XX" />
                                    <span v-if="errors[`phones.${index}.phone_number`]" class="text-red-600 text-sm">
                                        {{ errors[`phones.${index}.phone_number`] }}
                                    </span>
                                </div>
                                <Button variant="destructive" size="icon" @click.prevent="form.phones.splice(index, 1)"
                                    v-if="form.phones.length > 1">
                                    <Trash class="h-4 w-4" />
                                </Button>
                            </div>
                        </div>

                        <Button type="button" variant="outline" class="mt-2"
                            @click="(form.phones.length < 3) ? form.phones.push({ phone_number: '' }) : null">
                            <Plus class="h-4 w-4 mr-1" /> Додати Телефон
                        </Button>
                    </div>
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