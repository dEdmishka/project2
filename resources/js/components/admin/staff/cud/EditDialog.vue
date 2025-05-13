<script setup>
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog'

import {
    Plus,
    Trash,
    ChevronDown,
    Check,
} from 'lucide-vue-next'

import { Label } from '@/components/ui/label'
import { Input } from '@/components/ui/input'
import { Button } from '@/components/ui/button'
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group'
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from '@/components/ui/popover'
import {
    Command,
    CommandEmpty,
    CommandGroup,
    CommandInput,
    CommandItem,
} from '@/components/ui/command'
import { Checkbox } from '@/components/ui/checkbox'

const props = defineProps({
    currentCell: Object,
    showDialog: Boolean,
    mainUrl: String,
    centers: Array,
    staffTypes: Array,
})

import { toast } from 'vue-sonner';
import { useForm } from '@inertiajs/vue3';
import { watch, ref, computed } from 'vue';

const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    birth_date: '',
    address: '',
    gender: '',
    status: '',
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
    ],
    center: '',
    staff_type: '',
});

watch(
    () => props.currentCell,
    (newData) => {
        if (newData) {
            form.first_name = newData.first_name
            form.last_name = newData.last_name
            form.email = newData.email
            form.birth_date = newData.birth_date
            form.address = newData.address
            form.gender = newData.gender
            form.status = newData.status
            form.phones = newData.phones
            form.social_links = newData.social_links
            form.working_hours = newData.working_hours
            form.center = newData.center.id
            form.staff_type = newData.staffType.id
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

import { dayName, formatPhoneNumber } from '@/helper'

const formatPhone = (event, index) => {
    const input = event.target;
    input.value = formatPhoneNumber(input.value);
    form.phones[index].phone_number = input.value;
};

const openCenter = ref(false)
const searchCenter = ref('')
const selectedCenter = computed(() =>
    props.centers.find((u) => u.id === form.center)
)
const filteredCenters = computed(() =>
    props.centers.filter(
        (center) => center.name.toLowerCase().includes(search.value.toLowerCase())
    )
)
function selectCenter(center) {
    form.center = center.id
    openCenter.value = false
}

const openStaffType = ref(false)
const searchStaffType = ref('')
const selectedStaffType = computed(() =>
    props.staffTypes.find((u) => u.id === form.staff_type)
)
const filteredStaffType = computed(() =>
    props.staffTypes.filter(
        (staffType) => staffType.type.toLowerCase().includes(search.value.toLowerCase())
    )
)
function selectStaffType(staffType) {
    form.staff_type = staffType.id
    openStaffType.value = false
}
</script>

<template>
    <Dialog :value="showDialog">
        <DialogContent class="sm:max-w-[850px] h-full md:h-auto overflow-auto md:overflow-hidden">
            <DialogHeader>
                <DialogTitle>{{ $t('admin.staff.edit') }}</DialogTitle>
                <DialogDescription>
                    {{ $t('admin.staff.make_changes') }}
                </DialogDescription>
            </DialogHeader>
            <div class="grid gap-4 py-4">
                <div class="grid grid-cols-2 gap-2">
                    <div class="grid items-center gap-2">
                        <Label for="first_name" class="text-right">
                            {{ $t('label.first_name') }}
                        </Label>
                        <Input id="first_name" class="col-span-3" required v-model="form.first_name" />
                        <span v-if="errors.first_name" class="text-red-600 text-sm">{{ errors.first_name }}</span>
                    </div>
                    <div class="grid items-center gap-2">
                        <Label for="last_name" class="text-right">
                            {{ $t('label.last_name') }}
                        </Label>
                        <Input id="last_name" class="col-span-3" required v-model="form.last_name" />
                        <span v-if="errors.last_name" class="text-red-600 text-sm">{{ errors.last_name }}</span>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div class="grid items-center gap-2">
                        <Label for="Email" class="text-right">
                            {{ $t('label.email') }}
                        </Label>
                        <Input type="email" id="email" class="col-span-3" required v-model="form.email" />
                        <span v-if="errors.email" class="text-red-600 text-sm">{{ errors.email }}</span>
                    </div>
                    <div class="grid items-center gap-2">
                        <Label for="center" class="text-right">
                            {{ $t('label.center') }}
                        </Label>
                        <Popover id="center" v-model:open="openCenter">
                            <PopoverTrigger as-child>
                                <Button variant="outline" role="combobox" class="justify-between">
                                    {{ selectedCenter?.name || 'Select center...' }}
                                    <ChevronDown class="ml-2 h-4 w-4 shrink-0 opacity-50" />
                                </Button>
                            </PopoverTrigger>
                            <PopoverContent class="p-0 overflow-y-auto max-h-70">
                                <Command>
                                    <CommandInput placeholder="Search centers..." v-model="searchCenter" />
                                    <CommandEmpty>{{ $t('label.no_center') }}</CommandEmpty>
                                    <CommandGroup>
                                        <CommandItem v-for="center in filteredCenters" :key="center.id"
                                            :value="center.name" @select="() => selectCenter(center)">
                                            {{ center.name }}
                                            <Check class="ml-auto h-4 w-4"
                                                :class="{ 'opacity-100': form.center === center.id, 'opacity-0': form.center !== center.id }" />
                                        </CommandItem>
                                    </CommandGroup>
                                </Command>
                            </PopoverContent>
                        </Popover>
                        <span v-if="errors.center" class="text-red-600 text-sm">{{ errors.center }}</span>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <div class="grid items-center gap-2">
                        <Label for="birth_date" class="text-right">
                            {{ $t('label.birth_date') }}
                        </Label>
                        <Input id="birth_date" type="date" class="col-span-3" required v-model="form.birth_date" />
                        <span v-if="errors.birth_date" class="text-red-600 text-sm">{{ errors.birth_date }}</span>
                    </div>
                    <div class="grid items-center gap-2">
                        <Label for="address" class="text-right">
                            {{ $t('label.address') }}
                        </Label>
                        <Input id="address" class="col-span-3" required v-model="form.address" />
                        <span v-if="errors.address" class="text-red-600 text-sm">{{ errors.address }}</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div class="grid items-center gap-1">
                        <Label for="name" class="text-right">
                            {{ $t('label.social_links') }}
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
                            <Plus class="h-4 w-4 mr-1" /> {{ $t('label.add_social_link') }}
                        </Button>
                    </div>

                    <div class="grid items-center gap-1">
                        <Label for="name" class="text-right">
                            {{ $t('label.phones') }}
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
                            <Plus class="h-4 w-4 mr-1" /> {{ $t('label.add_phone') }}
                        </Button>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div class="space-y-4">
                        <div class="grid items-center gap-2">
                            <Label for="staffType" class="text-right">
                                {{ $t('label.staff_type') }}
                            </Label>
                            <Popover id="staffType" v-model:open="openStaffType">
                                <PopoverTrigger as-child>
                                    <Button variant="outline" role="combobox" class="justify-between">
                                        {{ selectedStaffType?.type || 'Select staff type...' }}
                                        <ChevronDown class="ml-2 h-4 w-4 shrink-0 opacity-50" />
                                    </Button>
                                </PopoverTrigger>
                                <PopoverContent class="p-0 overflow-y-auto max-h-70">
                                    <Command>
                                        <CommandInput placeholder="Search staff type..." v-model="searchStaffType" />
                                        <CommandEmpty>{{ $t('label.no_staff_type') }}</CommandEmpty>
                                        <CommandGroup>
                                            <CommandItem v-for="staffType in filteredStaffType" :key="staffType.id"
                                                :value="staffType.type" @select="() => selectStaffType(staffType)">
                                                {{ staffType.type }}
                                                <Check class="ml-auto h-4 w-4"
                                                    :class="{ 'opacity-100': form.staff_type === staffType.id, 'opacity-0': form.staff_type !== staffType.id }" />
                                            </CommandItem>
                                        </CommandGroup>
                                    </Command>
                                </PopoverContent>
                            </Popover>
                            <span v-if="errors.staff_type" class="text-red-600 text-sm">{{ errors.staff_type
                            }}</span>
                        </div>
                        <div class="grid grid-cols-2 items-center gap-2">
                            <Label for="gender" class="text-right">
                                {{ $t('label.gender') }}: {{ form.gender === 'M' ? $t('label.male') : $t('label.female') }}
                            </Label>
                            <Label for="status" class="text-right">
                                {{ $t('label.status') }}: {{ form.status === 'active' ? $t('label.active') : $t('label.discharge') }}
                            </Label>
                            <RadioGroup :default-value="form.gender" :orientation="'vertical'" v-model="form.gender">
                                <div class="flex items-center space-x-2">
                                    <RadioGroupItem id="M" value="M" />
                                    <Label for="M">{{ $t('label.male') }}</Label>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <RadioGroupItem id="F" value="F" />
                                    <Label for="F">{{ $t('label.female') }}</Label>
                                </div>
                            </RadioGroup>
                            <RadioGroup :default-value="form.status" :orientation="'vertical'" v-model="form.status">
                                <div class="flex items-center space-x-2">
                                    <RadioGroupItem id="active" value="active" />
                                    <Label for="active">{{ $t('label.active') }}</Label>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <RadioGroupItem id="discharge" value="discharge" />
                                    <Label for="discharge">{{ $t('label.discharge') }}</Label>
                                </div>
                            </RadioGroup>
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
                                <Checkbox :model-value="Boolean(hour.is_day_off)"
                                    @update:model-value="val => hour.is_day_off = val ? 1 : 0"
                                    id="day-off-{{ index }}" />
                                <label :for="'day-off-' + index" class="text-sm">{{ $t('label.dayoff') }}</label>
                            </div>
                        </div>
                    </div>
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