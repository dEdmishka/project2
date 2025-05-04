<script setup>
import Layout from "@/Layout/Dashboard/Index.vue";
import { Separator } from "@/components/ui/separator";

import { cn } from '@/lib/utils'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'

import { Camera } from 'lucide-vue-next'
import { Textarea } from '@/components/ui/textarea'
import { useForm } from '@inertiajs/vue3';
import { h, ref, watch } from 'vue'
import { toast } from 'vue-sonner';

const props = defineProps({
  user: Object,
  mainUrl: String,
})

const form = useForm({
  first_name: '',
  last_name: '',
  email: '',
  image: {},
});

watch(
  () => props.user,
  (newData) => {
    if (newData) {
      form.first_name = newData.first_name
      form.last_name = newData.last_name
      form.email = newData.email
      form.image = newData.image
    }
  },
  { immediate: true }
)

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
    }
  })
};

const preview = ref('')

const previewImage = (e) => {
  const file = e.target.files[0];
  preview.value = URL.createObjectURL(file);
  form.image = file
}
// defineProps({ user: Object })
</script>

<template>
  <Layout>
    <div class="w-[calc(100dvw-325px)] text-start">
      Hiiiii our user {{ $page['props']['user'] }}
      <h1 class="text-lg font-semibold md:text-2xl pb-4">
        Profile
      </h1>
      <Separator />
      <div class="grid gap-4 py-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="grid items-center gap-1">
            <Label for="File">Аватар</Label>
            <div class="text-center relative">
              <Input id="image" type="file" @change="previewImage"
                class="w-[120px] h-[120px] rounded-[100%] opacity-0 cursor-pointer p-0" required />
              <figure class="absolute w-[120px] min-h-[120px] top-0 left-0 pointer-events-none">
                <img :src="form?.image?.url ? `http://127.0.0.1:8000/${form?.image?.url}` : preview"
                  class="cursor-pointer w-[120px] h-[120px] rounded-[100%] border-1" />
                <Camera v-if="!form.image" class="absolute top-0 mt-[32px] ml-[32px] w-[50px] h-[50px]" />
              </figure>
            </div>

            <span v-if="errors.image" class="text-red-600 text-sm">{{ errors.image }}</span>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="grid items-center gap-1">
            <Label for="first_name" class="">
              Ім'я
            </Label>
            <Input id="first_name" class="col-span-3" required v-model="form.first_name" />
            <span v-if="errors.first_name" class="text-red-600 text-sm">{{ errors.first_name }}</span>
          </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="grid items-center gap-1">
            <Label for="last_name" class="">
              Прізвище
            </Label>
            <Input id="last_name" class="col-span-3" required v-model="form.last_name" />
            <span v-if="errors.last_name" class="text-red-600 text-sm">{{ errors.last_name }}</span>
          </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="grid items-center gap-1">
            <Label for="email" class="">
              Пошта
            </Label>
            <Input id="email" type="email" class="col-span-3" required v-model="form.email" />
            <span v-if="errors.email" class="text-red-600 text-sm">{{ errors.email }}</span>
          </div>
        </div>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="gap-12 grid grid-cols-2">
          <Button type="submit" @click="submit">
            Зберегти
          </Button>

          <Button class="ml-auto" type="button" variant="outline" @click="form.reset()">
            Reset form
          </Button>
        </div>
      </div>

    </div>
  </Layout>
</template>