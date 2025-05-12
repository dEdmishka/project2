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
import { Calendar } from '@/components/ui/calendar'
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

import {
    ChevronDown,
    Check,
} from 'lucide-vue-next'

const props = defineProps({
    currentCell: Object,
    showDialog: Boolean,
    mainUrl: String,
    patients: Array,
    staff: Array,
    wards: Array,
})

import { toast } from 'vue-sonner';
import { useForm } from '@inertiajs/vue3';
import { watch, ref, computed } from 'vue';

const form = useForm({
    time: '',
    status: 'active',
    notes: '',
    patient: '',
    staff: [],
    ward: '',
});

watch(
    () => props.currentCell,
    (newData) => {
        if (newData) {
            form.time = newData.time
            form.status = newData.status
            form.notes = newData.notes
            form.patient = newData.patient.id
            form.staff = newData.staff.map((s) => s.id)
            form.ward = newData.ward.id
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

const openPatient = ref(false)
const searchPatient = ref('')
const selectedPatient = computed(() =>
    props.patients.find((u) => u.id === form.patient)
)
const filteredPatients = computed(() =>
    props.patients.filter(
        (patient) =>
            patient.user.first_name.toLowerCase().includes(search.value.toLowerCase()) ||
            patient.user.last_name.toLowerCase().includes(search.value.toLowerCase())
    )
)
function selectPatient(patient) {
    form.patient = patient.id
    openPatient.value = false
}

const maximusStaff = 4
const openStaff = ref(false)
const searchStaff = ref('')
const selectedStaff = computed(() =>
    props.staff
        .filter((u) => form.staff.includes(u.id))
)
const filteredStaff = computed(() =>
    props.staff.filter(
        (staff) =>
            staff.user.first_name.toLowerCase().includes(search.value.toLowerCase()) ||
            staff.user.last_name.toLowerCase().includes(search.value.toLowerCase())
    )
)
const toggleStaff = (staff) => {
    const index = form.staff.indexOf(staff.id)
    if (index === -1) {
        if (form.staff.length >= maximusStaff) return
        form.staff.push(staff.id)
    } else {
        form.staff.splice(index, 1)
    }
}

const openWard = ref(false)
const searchWard = ref('')
const selectedWard = computed(() =>
    props.wards.find((u) => u.id === form.ward)
)
const filteredWards = computed(() =>
    props.wards.filter(
        (ward) => ward.name.toLowerCase().includes(search.value.toLowerCase())
    )
)
function selectWard(ward) {
    form.ward = ward.id
    openWard.value = false
}

const openDateTime = ref(false)
const selectedDate = ref(null)
const selectedTime = ref('')

const formattedDateTime = computed(() => {
    if (!selectedDate.value || !selectedTime.value) return ''
    return selectedDate.value + ' ' + selectedTime.value
})

watch(formattedDateTime, newVal => {
    form.time = newVal
})
</script>

<template>
    <Dialog :value="showDialog">
        <DialogContent class="sm:max-w-[425px]">
            <DialogHeader>
                <DialogTitle>{{ $t('admin.appointment.edit') }}</DialogTitle>
                <DialogDescription>
                    {{ $t('admin.appointment.make_changes') }}
                </DialogDescription>
            </DialogHeader>
            <div class="grid gap-4 py-4">
                <div class="grid items-center gap-2">
                    <Label for="notes" class="text-right">
                        {{ $t('label.notes') }}
                    </Label>
                    <Textarea v-model="form.notes"></Textarea>
                    <span v-if="errors.notes" class="text-red-600 text-sm">{{ errors.notes }}</span>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div class="grid items-center gap-2">
                        <Label for="status" class="text-right capitalize">
                            {{ $t('label.status') }}: {{ form.status }}
                        </Label>
                        <RadioGroup :default-value="form.status" :orientation="'vertical'" v-model="form.status">
                            <div class="flex items-center space-x-2">
                                <RadioGroupItem id="active" value="active" />
                                <Label for="active">{{ $t('label.active') }}</Label>
                            </div>
                            <div class="flex items-center space-x-2">
                                <RadioGroupItem id="closed" value="closed" />
                                <Label for="closed">{{ $t('label.closed') }}</Label>
                            </div>
                            <div class="flex items-center space-x-2">
                                <RadioGroupItem id="canceled" value="canceled" />
                                <Label for="canceled">{{ $t('label.canceled') }}</Label>
                            </div>
                        </RadioGroup>
                    </div>
                    <div class="grid gap-2 max-w-sm">
                        <Label for="datetime">{{ $t('label.time') }}</Label>
                        <Popover v-model:open="openDateTime">
                            <PopoverTrigger as-child>
                                <Button variant="outline" class="w-full justify-start text-left">
                                    {{ formattedDateTime || 'Pick date & time' }}
                                </Button>
                            </PopoverTrigger>
                            <PopoverContent class="w-auto p-4">
                                <Calendar v-model="selectedDate" />
                                <div class="mt-2 flex gap-2 items-center">
                                    <Input type="time" v-model="selectedTime" class="w-[120px]" />
                                </div>
                            </PopoverContent>
                        </Popover>
                        <span v-if="errors.time" class="text-red-600 text-sm">{{ errors.time }}</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div class="grid gap-2">
                        <Label for="patient" class="text-right">
                            {{ $t('label.patient') }}
                        </Label>
                        <Popover id="patient" v-model:open="openPatient">
                            <PopoverTrigger as-child>
                                <Button variant="outline" role="combobox" class="justify-between">
                                    {{ selectedPatient?.user.first_name || 'Select patient...' }} {{
                                        selectedPatient?.user.last_name
                                    }}
                                    <ChevronDown class="ml-2 h-4 w-4 shrink-0 opacity-50" />
                                </Button>
                            </PopoverTrigger>
                            <PopoverContent class="p-0 overflow-y-auto max-h-70">
                                <Command>
                                    <CommandInput placeholder="Search patients..." v-model="searchPatient" />
                                    <CommandEmpty>{{ $t('label.no_patient') }}</CommandEmpty>
                                    <CommandGroup>
                                        <CommandItem v-for="patient in filteredPatients" :key="patient.id"
                                            :value="patient.user.first_name" @select="() => selectPatient(patient)">
                                            {{ patient.user.first_name }} {{ patient.user.last_name }}
                                            <Check class="ml-auto h-4 w-4"
                                                :class="{ 'opacity-100': form.patient === patient.id, 'opacity-0': form.patient !== patient.id }" />
                                        </CommandItem>
                                    </CommandGroup>
                                </Command>
                            </PopoverContent>
                        </Popover>
                        <span v-if="errors.patient" class="text-red-600 text-sm">{{ errors.patient }}</span>
                    </div>
                    <div class="grid gap-2">
                        <Label for="ward" class="text-right">
                            {{ $t('label.ward') }}
                        </Label>
                        <Popover id="ward" v-model:open="openWard">
                            <PopoverTrigger as-child>
                                <Button variant="outline" role="combobox" class="justify-between">
                                    {{ selectedWard?.name || 'Select ward...' }}
                                    <ChevronDown class="ml-2 h-4 w-4 shrink-0 opacity-50" />
                                </Button>
                            </PopoverTrigger>
                            <PopoverContent class="p-0 overflow-y-auto max-h-70">
                                <Command>
                                    <CommandInput placeholder="Search ward..." v-model="searchWard" />
                                    <CommandEmpty>{{ $t('label.no_ward') }}</CommandEmpty>
                                    <CommandGroup>
                                        <CommandItem v-for="ward in filteredWards" :key="ward.id" :value="ward.name"
                                            @select="() => selectWard(ward)">
                                            {{ ward.name }}
                                            <Check class="ml-auto h-4 w-4"
                                                :class="{ 'opacity-100': form.ward === ward.id, 'opacity-0': form.ward !== ward.id }" />
                                        </CommandItem>
                                    </CommandGroup>
                                </Command>
                            </PopoverContent>
                        </Popover>
                        <span v-if="errors.ward" class="text-red-600 text-sm">{{ errors.ward }}</span>
                    </div>
                </div>
                <div class="grid gap-2">
                    <Label for="staff" class="text-right">
                        {{ $t('label.staff') }}
                    </Label>
                    <Popover id="staff" v-model:open="openStaff">
                        <PopoverTrigger as-child>
                            <Button variant="outline" role="combobox" class="justify-between flex-wrap">
                                <span v-if="selectedStaff.length === 0">Select staff...</span>
                                <span v-else>
                                    {{selectedStaff.map(s => `${s.user.first_name} ${s.user.last_name}`).join(', ')}}
                                </span>
                                <ChevronDown class="ml-2 h-4 w-4 shrink-0 opacity-50" />
                            </Button>
                        </PopoverTrigger>
                        <PopoverContent class="p-0 overflow-y-auto max-h-70">
                            <Command>
                                <CommandInput placeholder="Search staff..." v-model="searchStaff" />
                                <CommandEmpty>{{ $t('label.no_staff') }}</CommandEmpty>
                                <CommandGroup>
                                    <CommandItem v-for="staff in filteredStaff" :key="staff.id"
                                        :value="staff.user.first_name" @select="() => toggleStaff(staff)"
                                        class="cursor-pointer">
                                        {{ staff.user.first_name }} {{ staff.user.last_name }}
                                        <Check class="ml-auto h-4 w-4" :class="{
                                            'opacity-100': form.staff.includes(staff.id),
                                            'opacity-0': !form.staff.includes(staff.id)
                                        }" />
                                    </CommandItem>
                                </CommandGroup>
                            </Command>
                        </PopoverContent>
                    </Popover>
                    <!-- <Popover id="staff" v-model:open="openStaff">
                        <PopoverTrigger as-child>
                            <Button variant="outline" role="combobox" class="justify-between">
                                {{ selectedStaff?.user.first_name || 'Select staff...' }} {{
                                    selectedStaff?.user.last_name }}
                                <ChevronDown class="ml-2 h-4 w-4 shrink-0 opacity-50" />
                            </Button>
                        </PopoverTrigger>
                        <PopoverContent class="p-0 overflow-y-auto max-h-70">
                            <Command>
                                <CommandInput placeholder="Search staff..." v-model="searchStaff" />
                                <CommandEmpty>No staff found.</CommandEmpty>
                                <CommandGroup>
                                    <CommandItem v-for="staff in filteredStaff" :key="staff.id"
                                        :value="staff.user.first_name" @select="() => selectStaff(staff)">
                                        {{ staff.user.first_name }} {{ staff.user.last_name }}
                                        <Check class="ml-auto h-4 w-4"
                                            :class="{ 'opacity-100': form.staff === staff.id, 'opacity-0': form.staff !== staff.id }" />
                                    </CommandItem>
                                </CommandGroup>
                            </Command>
                        </PopoverContent>
                    </Popover> -->
                    <span v-if="errors.staff" class="text-red-600 text-sm">{{ errors.staff }}</span>
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