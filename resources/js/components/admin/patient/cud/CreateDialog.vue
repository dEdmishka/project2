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

const props = defineProps({
    showDialog: Boolean,
    mainUrl: String,
    centers: Array,
    users: Array,
})

import { toast } from 'vue-sonner';
import { useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const form = useForm({
    birth_date: '',
    address: '',
    gender: 'M',
    status: 'active',
    user: '',
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

import { formatPhoneNumber } from '@/helper'

const formatPhone = (event, index) => {
    const input = event.target;
    input.value = formatPhoneNumber(input.value);
    form.phones[index].phone_number = input.value;
};

const openUser = ref(false)
const searchUser = ref('')
const selectedUser = computed(() =>
    props.users.find((u) => u.id === form.user)
)
const filteredUsers = computed(() =>
    props.users.filter(
        (user) =>
            user.first_name.toLowerCase().includes(search.value.toLowerCase()) ||
            user.last_name.toLowerCase().includes(search.value.toLowerCase())
    )
)
function selectUser(user) {
    form.user = user.id
    openUser.value = false
}

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
</script>

<template>
    <Dialog :value="showDialog">
        <DialogContent class="sm:max-w-[850px] h-full md:h-auto overflow-hidden">
            <DialogHeader>
                <DialogTitle>Create patient</DialogTitle>
                <DialogDescription>
                    Make changes to your patient here. Click save when you're done.
                </DialogDescription>
            </DialogHeader>
            <div class="grid gap-4 py-4">
                <div class="grid grid-cols-2 gap-2">
                    <div class="grid items-center gap-2">
                        <Label for="user" class="text-right">
                            User
                        </Label>
                        <Popover id="user" v-model:open="openUser">
                            <PopoverTrigger as-child>
                                <Button variant="outline" role="combobox" class="justify-between">
                                    {{ selectedUser?.first_name || 'Select user...' }} {{ selectedUser?.last_name || ''
                                    }}
                                    <ChevronDown class="ml-2 h-4 w-4 shrink-0 opacity-50" />
                                </Button>
                            </PopoverTrigger>
                            <PopoverContent class="p-0 overflow-y-auto max-h-70">
                                <Command>
                                    <CommandInput placeholder="Search users..." v-model="searchUser" />
                                    <CommandEmpty>No users found.</CommandEmpty>
                                    <CommandGroup>
                                        <CommandItem v-for="user in filteredUsers" :key="user.id"
                                            :value="user.first_name" @select="() => selectUser(user)">
                                            {{ user.first_name }} {{ user.last_name }}
                                            <Check class="ml-auto h-4 w-4"
                                                :class="{ 'opacity-100': form.user === user.id, 'opacity-0': form.user !== user.id }" />
                                        </CommandItem>
                                    </CommandGroup>
                                </Command>
                            </PopoverContent>
                        </Popover>
                        <span v-if="errors.user" class="text-red-600 text-sm">{{ errors.user }}</span>
                    </div>
                    <div class="grid items-center gap-2">
                        <Label for="center" class="text-right">
                            Center
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
                                    <CommandEmpty>No centers found.</CommandEmpty>
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
                <div class="grid grid-cols-1 gap-2">
                    <div class="grid grid-cols-2 items-center gap-2">
                        <Label for="gender" class="text-right">
                            Gender: {{ form.gender === 'M' ? 'Male' : 'Female' }}
                        </Label>
                        <Label for="status" class="text-right">
                            Status: {{ form.status === 'active' ? 'Active' : 'Discharge' }}
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
                        <RadioGroup :default-value="form.status" :orientation="'vertical'" v-model="form.status">
                            <div class="flex items-center space-x-2">
                                <RadioGroupItem id="active" value="active" />
                                <Label for="active">Active</Label>
                            </div>
                            <div class="flex items-center space-x-2">
                                <RadioGroupItem id="discharge" value="discharge" />
                                <Label for="discharge">Discharge</Label>
                            </div>
                        </RadioGroup>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <div class="grid items-center gap-2">
                        <Label for="birth_date" class="text-right">
                            Birth Date
                        </Label>
                        <Input id="birth_date" type="date" class="col-span-3" required v-model="form.birth_date" />
                        <span v-if="errors.birth_date" class="text-red-600 text-sm">{{ errors.birth_date }}</span>
                    </div>
                    <div class="grid items-center gap-2">
                        <Label for="address" class="text-right">
                            Address
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
                    Save changes
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>