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

const props = defineProps({
    showDialog: Boolean,
    patient: Object,
    mainUrl: String,
})

import { toast } from 'vue-sonner';
import { useForm } from '@inertiajs/vue3';
import { ref, watch, computed } from 'vue';

import { Upload, X, FileIcon } from 'lucide-vue-next'
import { Progress } from '@/components/ui/progress'

const fileInput = ref(null)
const isDragging = ref(false)

const form = useForm({
    first_name: '',
    last_name: '',
    height: '',
    weight: '',
    blood_type: '',
    blood_pressure: '',
    file: {},
});

const emit = defineEmits(['update', 'close']);
const errors = ref({});
const progress = ref(0);

watch(
    () => props.patient,
    (newData) => {
        if (newData) {
            form.first_name = newData.user.first_name
            form.last_name = newData.user.last_name
        }
    },
    { immediate: true }
)

const submit = () => {
    form.post(`${props.mainUrl}/${props.patient.id}`, {
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
            emit('update', data);
        }
    })
};

function openFilePicker() {
    fileInput.value.click()
}

function handleFileChange(e) {
    addFile(e.target.files)
}

function handleDrop(e) {
    isDragging.value = false
    addFile(e.dataTransfer.files)
}

function addFile(newFile) {
    progress.value = 0

    const file = newFile[0]

    form.file = file

    simulateUpload()
}

function removeFile() {
    progress.value = 0

    form.file = {}
    errors = {}
}

function simulateUpload() {
    const interval = setInterval(() => {
        if (progress.value >= 100) {
            clearInterval(interval)
        } else {
            progress.value += 10
        }
    }, 50)
}
</script>

<template>
    <Dialog :value="showDialog">
        <DialogContent class="sm:max-w-[850px] h-full md:h-auto overflow-auto md:overflow-hidden">
            <DialogHeader>
                <DialogTitle>{{ $t('pages.new_medcard') }}</DialogTitle>
                <DialogDescription>
                    {{ $t('pages.enter_data') }}
                </DialogDescription>
            </DialogHeader>
            <div class="grid gap-4 py-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="grid items-center gap-1">
                        <Label for="first_name" class="text-right">
                            {{ $t('label.first_name') }}
                        </Label>
                        <Input id="first_name" class="col-span-3" required v-model="form.first_name" disabled />
                    </div>
                    <div class="grid items-center gap-1">
                        <Label for="last_name" class="text-right">
                            {{ $t('label.last_name') }}
                        </Label>
                        <Input id="last_name" class="col-span-3" required v-model="form.last_name" disabled />
                    </div>
                    <div class="grid items-center gap-1">
                        <Label for="height" class="text-right">
                            {{ $t('label.height') }}
                        </Label>
                        <Input id="height" class="col-span-3" required v-model="form.height" />
                    </div>
                    <div class="grid items-center gap-1">
                        <Label for="weight" class="text-right">
                            {{ $t('label.weight') }}
                        </Label>
                        <Input id="weight" class="col-span-3" required v-model="form.weight" />
                    </div>
                    <div class="grid items-center gap-1">
                        <Label for="blood_type" class="text-right">
                            {{ $t('label.blood_type') }}
                        </Label>
                        <Input id="blood_type" class="col-span-3" required v-model="form.blood_type" />
                    </div>
                    <div class="grid items-center gap-1">
                        <Label for="blood_pressure" class="text-right">
                            {{ $t('label.blood_pressure') }}
                        </Label>
                        <Input id="blood_pressure" class="col-span-3" required v-model="form.blood_pressure" />
                    </div>
                </div>
                <DialogDescription>
                    {{ $t('pages.include_file') }}:
                </DialogDescription>
                <div class="grid gap-2">
                    <div class="w-1/2 border-2 border-dashed rounded-xl p-4 relative transition-all mx-auto"
                        @dragover.prevent="isDragging = true" @dragleave.prevent="isDragging = false"
                        @drop.prevent="handleDrop" :class="{ 'border-blue-500 bg-blue-50': isDragging }">
                        <input type="file" class="hidden" ref="fileInput" multiple accept=".pdf,.doc,.docx,.txt"
                            @change="handleFileChange" />
                        <div class="p-12 flex items-center justify-center flex-col space-y-2 cursor-pointer"
                            @click="openFilePicker">
                            <Upload class="w-6 h-6 text-gray-500" />
                            <p class="text-sm text-gray-500">{{ $t('pages.drag_and_drop') }}</p>
                        </div>
                        <div v-if="form.file.name" class="mt-4 space-y-2">
                            <div
                                class="flex items-center justify-between bg-white px-3 py-2 rounded-lg border shadow-sm">
                                <div class="flex items-center space-x-2">
                                    <FileIcon class="w-5 h-5 text-gray-500" />
                                    <span class="text-sm">{{ form.file.name }}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <Progress v-model="progress" class="w-20 h-2" />
                                    <Button size="icon" variant="ghost" @click="removeFile()">
                                        <X class="w-4 h-4 text-red-500" />
                                    </Button>
                                </div>
                                <span v-if="errors.file" class="text-red-600 text-sm">{{ errors.file }}</span>
                            </div>
                        </div>
                    </div>
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