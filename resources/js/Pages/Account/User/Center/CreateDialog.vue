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
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group'

const props = defineProps({
    showDialog: Boolean,
    user: Object,
    center: Object,
    mainUrl: String,
})

import { toast } from 'vue-sonner';
import { useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { formatPhoneNumber } from '@/helper'

const form = useForm({
    center_id: '',
    center_name: '',
    user_id: '',
    first_name: '',
    last_name: '',
    email: '',
    gender: 'M',
    birth_date: '',
    address: '',
    phones: [{ phone_number: '' }],
    social_links: [{ url: '' }],
});

const emit = defineEmits(['update', 'close']);
const errors = ref({});

watch(
  () => props.user,
  (newData) => {
    if (newData) {
      form.user_id = newData.id
      form.first_name = newData.first_name
      form.last_name = newData.last_name
      form.email = newData.email
    }
  },
  { immediate: true }
)

watch(
  () => props.center,
  (newData) => {
    if (newData) {
      form.center_id = newData.id
      form.center_name = newData.name
    }
  },
  { immediate: true }
)

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
                <DialogTitle>Новий пацієнт</DialogTitle>
                <DialogDescription>
                        Внесіть додаткові дані для завершення реєстрації.
                </DialogDescription>
            </DialogHeader>
            <div class="grid gap-4 py-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="grid items-center gap-1">
                        <Label for="first_name" class="text-right">
                            Ім'я
                        </Label>
                        <Input id="first_name" class="col-span-3" required v-model="form.first_name" disabled />
                    </div>
                    <div class="grid items-center gap-1">
                        <Label for="last_name" class="text-right">
                            Прізвище
                        </Label>
                        <Input id="last_name" class="col-span-3" required v-model="form.last_name" disabled />
                    </div>
                    <div class="grid items-center gap-1">
                        <Label for="email" class="text-right">
                            Пошта
                        </Label>
                        <Input id="email" type="email" class="col-span-3" required v-model="form.email" disabled />
                    </div>
                    <div class="grid items-center gap-1">
                        <Label for="center_name" class="text-right">
                            Центр
                        </Label>
                        <Input id="center_name" class="col-span-3" required v-model="form.center_name" disabled />
                    </div>
                    <div class="grid items-center gap-1">
                        <Label for="gender" class="text-right">
                            Стать: {{ form.gender === 'M' ? 'Male' : 'Female' }}
                        </Label>
                        <RadioGroup :default-value="form.gender" :orientation="'vertical'" v-model="form.gender">
                            <div class="flex items-center space-x-2">
                                <RadioGroupItem id="M" value="M" />
                                <Label for="M">Male</Label>
                            </div>
                            <div class="flex items-center space-x-2">
                                <RadioGroupItem id="F" value="F" />
                                <Label for="F">Female</Label>
                            </div>
                        </RadioGroup>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <div class="grid items-center gap-2">
                        <Label for="birth_date" class="text-right">
                            Дата народження
                        </Label>
                        <Input id="birth_date" type="date" class="col-span-3" required v-model="form.birth_date" />
                        <span v-if="errors.birth_date" class="text-red-600 text-sm">{{ errors.birth_date }}</span>
                    </div>
                    <div class="grid items-center gap-2">
                        <Label for="address" class="text-right">
                            Ваша адреса
                        </Label>
                        <Input id="address" class="col-span-3" required v-model="form.address" />
                        <span v-if="errors.address" class="text-red-600 text-sm">{{ errors.address }}</span>
                    </div>
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
                    Зберегти
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>