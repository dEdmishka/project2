<script setup>
import Layout from "@/Layout/Dashboard/Index.vue";
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { RadioGroup, RadioGroupItem } from '@/components/ui/radio-group'
import { Camera, Trash, Plus } from 'lucide-vue-next'
import { Checkbox } from '@/components/ui/checkbox'
import { useForm } from '@inertiajs/vue3';
import { h, ref, watch } from 'vue'
import { toast } from 'vue-sonner';
import { dayName, formatPhoneNumber } from '@/helper'

const props = defineProps({
  user: Object,
  mainUrl: String,
})

const formatPhone = (event, index) => {
  const input = event.target;
  input.value = formatPhoneNumber(input.value);
  form.phones[index].phone_number = input.value;
};

const form = useForm({
  first_name: '',
  last_name: '',
  email: '',
  image: {},
  gender: 'M',
  birth_date: '',
  address: '',
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
});

watch(
  () => props.user,
  (newData) => {
    if (newData) {
      form.first_name = newData.first_name
      form.last_name = newData.last_name
      form.email = newData.email
      form.image = newData.image
      form.gender = newData.staff.gender
      form.birth_date = newData.staff.birth_date
      form.address = newData.staff.address
      form.phones = newData.staff.phone_numbers
      form.social_links = newData.staff.social_links
      form.working_hours = newData.staff.working_hours
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
      toast('account.toast.success', {
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

import { motion } from 'motion-v'
</script>

<template>
  <Layout>
    <template #title>
      {{ $t('account.admin.profile') }}
    </template>
    <div class="text-start">
      <div class="grid gap-4 py-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="grid items-center gap-1">
            <Label for="File" class="ml-[32px] pb-2">{{ $t('label.avatar') }}</Label>
            <motion.div class="text-center relative" :animate="{
              opacity: [0, 1],
              x: [100, 0],
              transition: {
                type: 'linear',
                duration: 1,
                delay: 0.05
              }
            }">
              <Input id="image" type="file" @change="previewImage"
                class="w-[120px] h-[120px] rounded-[100%] opacity-0 cursor-pointer p-0" required />
              <figure class="absolute w-[120px] min-h-[120px] top-0 left-0 pointer-events-none">
                <img :src="form?.image?.url ? `http://127.0.0.1:8000/${form?.image?.url}` : preview"
                  class="cursor-pointer w-[120px] h-[120px] rounded-[100%] border-1" />
                <Camera v-if="!form.image" class="absolute top-0 mt-[32px] ml-[32px] w-[50px] h-[50px]" />
              </figure>
            </motion.div>

            <span v-if="errors.image" class="text-red-600 text-sm">{{ errors.image }}</span>
          </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <motion.div class="grid items-center gap-1" :animate="{
            opacity: [0, 1],
            y: [100, 0],
            transition: {
              type: 'linear',
              duration: 1,
              delay: 0.1
            }
          }">
            <Label for="first_name" class="">
              {{ $t('label.first_name') }}
            </Label>
            <Input id="first_name" class="col-span-3" required v-model="form.first_name" />
            <span v-if="errors.first_name" class="text-red-600 text-sm">{{ errors.first_name }}</span>
          </motion.div>
          <motion.div class="grid items-center gap-1" :animate="{
            opacity: [0, 1],
            y: [100, 0],
            transition: {
              type: 'linear',
              duration: 1,
              delay: 0.15
            }
          }">
            <Label for="birth_date" class="text-right">
              {{ $t('label.birth_date') }}
            </Label>
            <Input id="birth_date" type="date" class="col-span-3" required v-model="form.birth_date" />
            <span v-if="errors.birth_date" class="text-red-600 text-sm">{{ errors.birth_date }}</span>
          </motion.div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <motion.div class="grid items-center gap-1" :animate="{
            opacity: [0, 1],
            y: [100, 0],
            transition: {
              type: 'linear',
              duration: 1,
              delay: 0.2
            }
          }">
            <Label for="last_name" class="">
              {{ $t('label.last_name') }}
            </Label>
            <Input id="last_name" class="col-span-3" required v-model="form.last_name" />
            <span v-if="errors.last_name" class="text-red-600 text-sm">{{ errors.last_name }}</span>
          </motion.div>
          <motion.div class="grid items-center gap-2" :animate="{
            opacity: [0, 1],
            y: [100, 0],
            transition: {
              type: 'linear',
              duration: 1,
              delay: 0.25
            }
          }">
            <Label for="address" class="text-right">
              {{ $t('label.address') }}
            </Label>
            <Input id="address" class="col-span-3" required v-model="form.address" />
            <span v-if="errors.address" class="text-red-600 text-sm">{{ errors.address }}</span>
          </motion.div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <motion.div class="grid items-center gap-1" :animate="{
            opacity: [0, 1],
            y: [100, 0],
            transition: {
              type: 'linear',
              duration: 1,
              delay: 0.3
            }
          }">
            <Label for="email" class="">
              {{ $t('label.email') }}
            </Label>
            <Input id="email" type="email" class="col-span-3" required v-model="form.email" />
            <span v-if="errors.email" class="text-red-600 text-sm">{{ errors.email }}</span>
          </motion.div>
          <motion.div class="grid items-center gap-1" :animate="{
            opacity: [0, 1],
            y: [100, 0],
            transition: {
              type: 'linear',
              duration: 1,
              delay: 0.35
            }
          }">
            <Label for="gender" class="text-right">
              {{ $t('label.gender') }}: {{ form.gender === 'M' ? 'Male' : 'Female' }}
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
          </motion.div>
        </div>
        <div class="grid grid-cols-2 gap-2 items-start">
          <motion.div class="grid items-center gap-1" :animate="{
            opacity: [0, 1],
            y: [100, 0],
            transition: {
              type: 'linear',
              duration: 1,
              delay: 0.4
            }
          }">
            <Label for="name" class="text-right">
              {{ $t('label.social_links') }}
            </Label>
            <div class="space-y-2">
              <div v-for="(social, index) in form.social_links" :key="'social-' + index" class="flex gap-2">
                <div class="flex flex-col items-start gap-1 flex-1">
                  <Input v-model="social.url" placeholder="Social URL (e.g. https://instagram.com/center)" />
                  <span v-if="errors[`social_links.${index}.url`]" class="text-red-600 text-sm">
                    {{ errors[`social_links.${index}.url`] }}
                  </span>
                </div>
                <Button variant="destructive" size="icon" @click.prevent="form.social_links.splice(index, 1)"
                  v-if="form.social_links.length > 1">
                  <Trash class="h-4 w-4" />
                </Button>
              </div>
            </div>
            <Button type="button" variant="outline" class="mt-2"
              @click="(form.social_links.length < 3) ? form.social_links.push({ url: '' }) : null">
              <Plus class="h-4 w-4 mr-1" /> {{ $t('label.add_social_link') }}
            </Button>
          </motion.div>

          <motion.div class="grid items-center gap-1" :animate="{
            opacity: [0, 1],
            y: [100, 0],
            transition: {
              type: 'linear',
              duration: 1,
              delay: 0.45
            }
          }">
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
          </motion.div>
        </div>
        <div class="grid grid-cols-1 gap-2">
          <motion.div class="space-y-1" :animate="{
            opacity: [0, 1],
            y: [100, 0],
            transition: {
              type: 'linear',
              duration: 1,
              delay: 0.5
            }
          }">
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
                  @update:model-value="val => hour.is_day_off = val ? 1 : 0" id="day-off-{{ index }}" />
                <label :for="'day-off-' + index" class="text-sm">{{ $t('label.dayoff') }}</label>
              </div>
            </div>
          </motion.div>
        </div>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <motion.div class="gap-12 grid grid-cols-2" :animate="{
          opacity: [0, 1],
          y: [100, 0],
          transition: {
            type: 'linear',
            duration: 1,
            delay: 0.55
          }
        }">
          <Button type="submit" @click="submit">
            {{ $t('label.save') }}
          </Button>

          <Button class="ml-auto" type="button" variant="outline" @click="form.reset()">
            {{ $t('label.reset_form') }}
          </Button>
        </motion.div>
      </div>

    </div>
  </Layout>
</template>