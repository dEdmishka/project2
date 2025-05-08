<script setup>
// import { Link } from "@inertiajs/vue3"
// import { buttonVariants } from "@/components/ui/button";
// import { Button } from "@/components/ui/button";
// import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
// import {
//   Medal,
//   Map,
//   Plane,
//   Gift,
//   CircleUserRound,
//   ShieldUser,
//   BookHeart,
//   Building2,
// } from 'lucide-vue-next'

import { motion } from 'motion-v'
// import { animate, stagger } from "motion"
// import { splitText } from "motion-plus"
import { ref, reactive } from "vue"
import { Upload, X, FileIcon } from 'lucide-vue-next'
import { Progress } from '@/components/ui/progress'
import { Button } from '@/components/ui/button'

const fileInput = ref(null)
const isDragging = ref(false)

function openFilePicker() {
  fileInput.value.click()
}

function handleFileChange(e) {
  addFiles(e.target.files)
}

function handleDrop(e) {
  isDragging.value = false
  addFiles(e.dataTransfer.files)
}

function addFiles(newFiles) {
  for (const file of newFiles) {
    if (!['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'text/plain'].includes(file.type)) continue

    const entry = {
      file,
      name: file.name,
      size: file.size,
      progress: 0
    }

    const index = form.files.push(entry)
    simulateUpload(index)
  }
}

function removeFile(index) {
  form.files.splice(index, 1)
}

function simulateUpload(index) {
  const interval = setInterval(() => {
    if (form.files[index - 1].progress >= 100) {
      clearInterval(interval)
    } else {
      form.files[index - 1].progress += 10
    }
  }, 50)
}

import { Label } from '@/components/ui/label'
import { Input } from '@/components/ui/input'
import { Textarea } from '@/components/ui/textarea'

import { toast } from 'vue-sonner';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
  files: []
});

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
</script>

<template>
  <div class="w-1/2 border-2 border-dashed rounded-xl p-4 relative transition-all mx-auto"
    @dragover.prevent="isDragging = true" @dragleave.prevent="isDragging = false" @drop.prevent="handleDrop"
    :class="{ 'border-blue-500 bg-blue-50': isDragging }">
    <input type="file" class="hidden" ref="fileInput" multiple accept=".pdf,.doc,.docx,.txt"
      @change="handleFileChange" />
    <div class="p-12 flex items-center justify-center flex-col space-y-2 cursor-pointer" @click="openFilePicker">
      <Upload class="w-6 h-6 text-gray-500" />
      <p class="text-sm text-gray-500">Drag and drop files here or click to upload</p>
    </div>

    <div v-if="form.files.length" class="mt-4 space-y-2">
      <div v-for="(file, index) in form.files" :key="index"
        class="flex items-center justify-between bg-white px-3 py-2 rounded-lg border shadow-sm">
        <div class="flex items-center space-x-2">
          <FileIcon class="w-5 h-5 text-gray-500" />
          <span class="text-sm">{{ file.name }}</span>
        </div>
        <div class="flex items-center space-x-2">
          <Progress v-model="file.progress" class="w-20 h-2" />
          <Button size="icon" variant="ghost" @click="removeFile(index)">
            <X class="w-4 h-4 text-red-500" />
          </Button>
        </div>
        <span v-if="errors.files[index]" class="text-red-600 text-sm">{{ errors.files[index] }}</span>
      </div>
    </div>
  </div>
</template>