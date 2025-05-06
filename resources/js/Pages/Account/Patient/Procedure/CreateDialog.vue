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
import { Calendar } from '@/components/ui/calendar'
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

const props = defineProps({
    showDialog: Boolean,
    user: Object,
    procedure: Object,
    mainUrl: String,
})

import { toast } from 'vue-sonner';
import { useForm } from '@inertiajs/vue3';
import { ref, watch, computed } from 'vue';

const form = useForm({
    procedure_id: '',
    procedure_name: '',
    duration: '',
    user_id: '',
    first_name: '',
    last_name: '',
    time: '',
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
        }
    },
    { immediate: true }
)

watch(
    () => props.procedure,
    (newData) => {
        if (newData) {
            form.procedure_id = newData.id
            form.procedure_name = newData.name
            form.duration = newData.duration
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
                        <Label for="procedure_name" class="text-right">
                            Процедура
                        </Label>
                        <Input id="procedure_name" class="col-span-3" required v-model="form.procedure_name" disabled />
                    </div>
                    <div class="grid items-center gap-1">
                        <Label for="duration" class="text-right">
                            Тривалість процедури
                        </Label>
                        <Input id="duration" class="col-span-3" required v-model="form.duration" disabled />
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div class="grid gap-2 max-w-sm">
                        <Label for="datetime">Time</Label>
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
            </div>
            <DialogFooter>
                <Button type="submit" @click="submit">
                    Зберегти
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>