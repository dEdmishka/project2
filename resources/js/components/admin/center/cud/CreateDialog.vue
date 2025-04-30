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

import {
    Plus,
    Trash
} from 'lucide-vue-next'

import { Label } from '@/components/ui/label'
import { Input } from '@/components/ui/input'
import { Button } from '@/components/ui/button'
import { Textarea } from '@/components/ui/textarea'
import { Checkbox } from '@/components/ui/checkbox'

const props = defineProps({
    showDialog: Boolean,
    mainUrl: String,
})

import { toast } from 'vue-sonner';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { dayName, formatPhoneNumber } from '@/helper'

const form = useForm({
    name: '',
    email: '',
    description: '',
    address: '',
    phones: [{ phone_number: '' }],
    social_links: [{ url: '' }],
    working_hours: [
        { day_of_week: 0, start_time: '08:00', end_time: '18:00', is_day_off: false },
        { day_of_week: 1, start_time: '08:00', end_time: '18:00', is_day_off: false },
        { day_of_week: 2, start_time: '08:00', end_time: '18:00', is_day_off: false },
        { day_of_week: 3, start_time: '08:00', end_time: '18:00', is_day_off: false },
        { day_of_week: 4, start_time: '08:00', end_time: '18:00', is_day_off: false },
        { day_of_week: 5, start_time: '08:00', end_time: '16:00', is_day_off: false },
        { day_of_week: 6, start_time: '00:00', end_time: '00:00', is_day_off: true },
    ]
});

const emit = defineEmits(['update', 'close']);
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

const formatPhone = (event, index) => {
    const input = event.target;
    input.value = formatPhoneNumber(input.value);
    form.phones[index].phone_number = input.value;
};
</script>

<template>
    <Dialog :value="showDialog">
        <DialogContent class="sm:max-w-[850px] h-full md:h-auto overflow-auto md:overflow-hidden">
            <DialogHeader>
                <DialogTitle>Створити центр</DialogTitle>
                <DialogDescription>
                    Внесіть дані про центр, щоб створити новий запис.
                </DialogDescription>
            </DialogHeader>
            <div class="grid gap-4 py-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="grid items-center gap-1">
                        <Label for="name" class="text-right">
                            Назва
                        </Label>
                        <Input id="name" class="col-span-3" required v-model="form.name" />
                        <span v-if="errors.name" class="text-red-600 text-sm">{{ errors.name }}</span>
                    </div>
                    <div class="grid items-center gap-1">
                        <Label for="email" class="text-right">
                            Пошта
                        </Label>
                        <Input id="email" type="email" class="col-span-3" required v-model="form.email" />
                        <span v-if="errors.email" class="text-red-600 text-sm">{{ errors.email }}</span>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">

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
                                    <span v-if="errors[`social_links.${index}.url`]" class="text-red-600 text-sm">
                                        {{ errors[`social_links.${index}.url`] }}
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
                                    <Input v-model="phone.phone_number" @input="(e) => formatPhone(e, index)" placeholder="(0XX)-XXX-XX-XX" />
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

                <div class="grid md:grid-cols-2 gap-4">
                    <div class="space-y-4">
                        <div class="grid items-start gap-1">
                            <Label for="address" class="text-right">
                                Адреса
                            </Label>
                            <Input id="address" class="col-span-3" required v-model="form.address" />
                            <span v-if="errors.address" class="text-red-600 text-sm">{{ errors.address }}</span>
                        </div>

                        <div class="grid items-center gap-1">
                            <Label for="description" class="text-right">
                                Опис
                            </Label>
                            <Textarea id="description" v-model="form.description" class="max-h-[175px]"></Textarea>
                            <span v-if="errors.description" class="text-red-600 text-sm">{{ errors.description }}</span>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <div v-for="(hour, index) in form.working_hours" :key="index"
                            class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center">
                            <div class="font-medium">{{ dayName(hour.day_of_week) }}</div>

                            <div>
                                <Input v-model="hour.start_time" type="time" :disabled="hour.is_day_off" />
                            </div>

                            <div>
                                <Input v-model="hour.end_time" type="time" :disabled="hour.is_day_off" />
                            </div>

                            <div class="flex items-center gap-2">
                                <Checkbox v-model:model-value="hour.is_day_off" id="day-off-{{ index }}" />
                                <label :for="'day-off-' + index" class="text-sm">Вихідний</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <DialogFooter>
                <Button type="submit" @click="submit">
                    Зберегти
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>