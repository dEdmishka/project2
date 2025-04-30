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
    departments: Array,
    procedures: Array,
})

import { toast } from 'vue-sonner';
import { useForm } from '@inertiajs/vue3';
import { watch, ref, computed } from 'vue';

const form = useForm({
    name: '',
    description: '',
    ward_number: '',
    capacity: '',
    department: '',
    procedure: '',
});

watch(
    () => props.currentCell,
    (newData) => {
        if (newData) {
            form.name = newData.name
            form.description = newData.description
            form.ward_number = newData.ward_number
            form.capacity = newData.capacity
            form.department = newData.department.id
            form.procedure = newData.procedure.id
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

const openDepartment = ref(false)
const searchDepartment = ref('')
const selectedDepartment = computed(() =>
    props.departments.find((u) => u.id === form.department)
)
const filteredDepartments = computed(() =>
    props.departments.filter(
        (department) => department.name.toLowerCase().includes(search.value.toLowerCase())
    )
)
function selectDepartment(department) {
    form.department = department.id
    openDepartment.value = false
}

const openProcedure = ref(false)
const searchProcedure = ref('')
const selectedProcedure = computed(() =>
    props.procedures.find((u) => u.id === form.procedure)
)
const filteredProcedure = computed(() =>
    props.procedures.filter(
        (procedure) => procedure.name.toLowerCase().includes(search.value.toLowerCase())
    )
)
function selectProcedure(procedure) {
    form.procedure = procedure.id
    openProcedure.value = false
}
</script>

<template>
    <Dialog :value="showDialog">
        <DialogContent class="sm:max-w-[425px]">
            <DialogHeader>
                <DialogTitle>Edit ward</DialogTitle>
                <DialogDescription>
                    Make changes to your ward here. Click save when you're done.
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
                    <Label for="ward_number" class="text-right">
                        Ward Number
                    </Label>
                    <Input type="number" id="ward_number" class="col-span-3" required v-model="form.ward_number" />
                    <span v-if="errors.ward_number" class="text-red-600 text-sm">{{ errors.ward_number }}</span>
                </div>
                <div class="grid items-center gap-2">
                    <Label for="capacity" class="text-right">
                        Capacity
                    </Label>
                    <Input type="number" id="capacity" class="col-span-3" required v-model="form.capacity" />
                    <span v-if="errors.capacity" class="text-red-600 text-sm">{{ errors.capacity }}</span>
                </div>
                <div class="grid gap-2">
                    <Label for="department" class="text-right">
                        Department
                    </Label>
                    <Popover id="department" v-model:open="openDepartment">
                        <PopoverTrigger as-child>
                            <Button variant="outline" role="combobox" class="justify-between">
                                {{ selectedDepartment?.name || 'Select department...' }}
                                <ChevronDown class="ml-2 h-4 w-4 shrink-0 opacity-50" />
                            </Button>
                        </PopoverTrigger>
                        <PopoverContent class="p-0 overflow-y-auto max-h-70">
                            <Command>
                                <CommandInput placeholder="Search departments..." v-model="searchDepartment" />
                                <CommandEmpty>No departments found.</CommandEmpty>
                                <CommandGroup>
                                    <CommandItem v-for="department in filteredDepartments" :key="department.id"
                                        :value="department.name" @select="() => selectDepartment(department)">
                                        {{ department.name }}
                                        <Check class="ml-auto h-4 w-4"
                                            :class="{ 'opacity-100': form.department === department.id, 'opacity-0': form.department !== department.id }" />
                                    </CommandItem>
                                </CommandGroup>
                            </Command>
                        </PopoverContent>
                    </Popover>
                    <span v-if="errors.department" class="text-red-600 text-sm">{{ errors.department }}</span>
                </div>
                <div class="grid gap-2">
                    <Label for="procedure" class="text-right">
                        Procedure
                    </Label>
                    <Popover id="procedure" v-model:open="openProcedure">
                        <PopoverTrigger as-child>
                            <Button variant="outline" role="combobox" class="justify-between">
                                {{ selectedProcedure?.name || 'Select procedure...' }}
                                <ChevronDown class="ml-2 h-4 w-4 shrink-0 opacity-50" />
                            </Button>
                        </PopoverTrigger>
                        <PopoverContent class="p-0 overflow-y-auto max-h-70">
                            <Command>
                                <CommandInput placeholder="Search procedure type..." v-model="searchProcedure" />
                                <CommandEmpty>No procedures types found.</CommandEmpty>
                                <CommandGroup>
                                    <CommandItem v-for="procedure in filteredProcedure" :key="procedure.id"
                                        :value="procedure.name" @select="() => selectProcedure(procedure)">
                                        {{ procedure.name }}
                                        <Check class="ml-auto h-4 w-4"
                                            :class="{ 'opacity-100': form.procedure === procedure.id, 'opacity-0': form.procedure !== procedure.id }" />
                                    </CommandItem>
                                </CommandGroup>
                            </Command>
                        </PopoverContent>
                    </Popover>
                    <span v-if="errors.procedure" class="text-red-600 text-sm">{{ errors.procedure }}</span>
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