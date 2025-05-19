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
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select'

import {
    ChevronDown,
    Check,
} from 'lucide-vue-next'

const props = defineProps({
    showDialog: Boolean,
    mainUrl: String,
    centers: Array,
    departmentTypes: Array,
})

import { toast } from 'vue-sonner';
import { useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const form = useForm({
    name: '',
    description: '',
    floor: '',
    center: '',
    department_type: '',
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

const openCenter = ref(false)
const searchCenter = ref('')
const selectedCenter = computed(() =>
    props.centers.find((u) => u.id === form.center)
)
const filteredCenters = computed(() =>
    props.centers.filter(
        (center) => center.name.toLowerCase().includes(searchCenter.value.toLowerCase())
    )
)
function selectCenter(center) {
    form.center = center.id
    openCenter.value = false
}

const openDepartmentType = ref(false)
const searchDepartmentType = ref('')
const selectedDepartmentType = computed(() =>
    props.departmentTypes.find((u) => u.id === form.department_type)
)
const filteredDepartmentType = computed(() =>
    props.departmentTypes.filter(
        (departmentType) => departmentType.type.toLowerCase().includes(searchDepartmentType.value.toLowerCase())
    )
)
function selectDepartmentType(departmentType) {
    form.department_type = departmentType.id
    openDepartmentType.value = false
}
</script>

<template>
    <Dialog :value="showDialog">
        <DialogContent class="sm:max-w-[425px]">
            <DialogHeader>
                <DialogTitle>{{ $t('admin.department.create') }}</DialogTitle>
                <DialogDescription>
                    {{ $t('admin.department.make_changes') }}
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
                        {{ $t('label.floor') }}
                    </Label>
                    <Input type="number" id="duration" class="col-span-3" required v-model="form.floor" />
                    <span v-if="errors.duration" class="text-red-600 text-sm">{{ errors.floor }}</span>
                </div>
                <div class="grid gap-2">
                    <Label for="select" class="text-right">
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
                                    <CommandItem v-for="center in filteredCenters" :key="center.id" :value="center.name"
                                        @select="() => selectCenter(center)">
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
                <div class="grid gap-2">
                    <Label for="select" class="text-right">
                        {{ $t('label.department_type') }}
                    </Label>
                    <Popover id="departmentType" v-model:open="openDepartmentType">
                        <PopoverTrigger as-child>
                            <Button variant="outline" role="combobox" class="justify-between">
                                {{ selectedDepartmentType?.type || 'Select department type...' }}
                                <ChevronDown class="ml-2 h-4 w-4 shrink-0 opacity-50" />
                            </Button>
                        </PopoverTrigger>
                        <PopoverContent class="p-0 overflow-y-auto max-h-70">
                            <Command>
                                <CommandInput placeholder="Search department type..." v-model="searchDepartmentType" />
                                <CommandEmpty>{{ $t('label.no_department_type') }}</CommandEmpty>
                                <CommandGroup>
                                    <CommandItem v-for="departmentType in filteredDepartmentType"
                                        :key="departmentType.id" :value="departmentType.type"
                                        @select="() => selectDepartmentType(departmentType)">
                                        {{ departmentType.type }}
                                        <Check class="ml-auto h-4 w-4"
                                            :class="{ 'opacity-100': form.department_type === departmentType.id, 'opacity-0': form.department_type !== departmentType.id }" />
                                    </CommandItem>
                                </CommandGroup>
                            </Command>
                        </PopoverContent>
                    </Popover>
                    <span v-if="errors.department_type" class="text-red-600 text-sm">{{ errors.department_type }}</span>
                </div>
            </div>
            <DialogFooter>
                <Button type="submit" @click="submit">
                    {{ $t('label.save') }}
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>