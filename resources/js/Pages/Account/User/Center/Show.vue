<script setup>
import Layout from "@/Layout/Dashboard/Index.vue";

import CreateDialog from '@/Pages/Account/User/Center/CreateDialog.vue';

import {
    Card,
    CardTitle,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
} from '@/components/ui/card'

import { Button } from '@/components/ui/button'
import Autoplay from 'embla-carousel-autoplay'
import { Carousel, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious } from '@/components/ui/carousel'

import { watch, ref } from 'vue';
import { dayName, formatPhoneNumber } from '@/helper'

const props = defineProps({
    user: Object,
    center: Object,
    main_url: String,
})

const center = ref(props.center)

const createDialog = ref(false);
const showCreateDialog = () => {
    createDialog.value = true;
};
const closeCreateDialog = () => {
    createDialog.value = false;
};
</script>

<template>
    <Layout>
        <Card class="grid p-4 gap-8 border-0 shadow-none">
            <CardHeader>
                <CardTitle
                    class="inline text-center font-bold text-3xl md:text-6xl py-3 bg-gradient-to-r from-[#F596D3]  to-[#D247BF] text-transparent bg-clip-text">
                    {{ center.name }}
                </CardTitle>
                <CardDescription class="inline text-center text-xl text-gray-500 font-bold">
                    {{ $t('pages.added_at') }} {{ center.created_at.slice(0, 10) }}
                </CardDescription>
            </CardHeader>
            <CardContent class="grid grid-cols-2 gap-4">
                <div class="grid">
                    <CardDescription class="text-xl font-bold inline text-black">
                        {{ center.description }}
                    </CardDescription>
                    <CardDescription class="text-xl font-bold inline text-black">
                        {{ $t('label.email') }}: <p class="inline italic">
                            {{ center.email }}</p>
                    </CardDescription>
                    <CardDescription class="text-xl font-bold inline text-black">
                        {{ $t('label.address') }}: <p class="inline italic">
                            {{ center.address }}</p>
                    </CardDescription>
                    <!-- {{ center }} -->
                    <CardDescription class="text-xl font-bold flex gap-2 text-black">
                        {{ $t('label.phones') }}: <p v-for="(phone, index) in center.phone_numbers"
                            class="inline italic">
                            {{ phone.phone_number }}</p>
                    </CardDescription>
                    <CardDescription class="text-xl capitalize font-bold flex gap-2 text-black">
                        {{ $t('label.social_links') }}: <a v-for="(link, index) in center.social_links" :href="link.url"
                            target="_blank" rel="noopener"
                            class="inline italic underline text-blue-600 hover:text-blue-800">
                            {{ link.platform }}</a>
                    </CardDescription>
                    <div class="grid grid-cols-2">
                        <div class="col-span-1">
                            <div v-for="(hour, index) in center.working_hours" :key="index"
                                :class="`text-start font-medium grid grid-cols-3 gap-4 ${hour.is_day_off ? 'text-gray-300' : ''}`">
                                <p class="italic">{{ dayName(hour.day_of_week) }}</p>
                                <p class="text-center">{{ hour.start_time ?? '00:00' }}</p>
                                <p class="text-center">{{ hour.end_time ?? '00:00' }}</p>
                            </div>
                        </div>
                    </div>
                    <CardFooter class="font-bold uppercase items-end p-0 grid">
                        <Button class="cursor-pointer" @click="showCreateDialog">{{ $t('pages.want_to_you') }}</Button>
                    </CardFooter>
                </div>
                <div v-if="center.images" class="grid grid-cols-1 place-items-center text-center">
                    <Carousel class="relative w-full" :plugins="[Autoplay({ delay: 3000 })]">
                        <CarouselContent>
                            <CarouselItem v-for="(image, index) in center.images" :key="index">
                                <div class="p-1">
                                    <Card class="p-0">
                                        <CardContent class="flex aspect-[100/80] items-center justify-center p-0">
                                            <img class="object-cover h-full w-full"
                                                :src="`http://127.0.0.1:8000/${image.url}`" :alt="'image-' + index" />
                                        </CardContent>
                                    </Card>
                                </div>
                            </CarouselItem>
                        </CarouselContent>
                    </Carousel>
                </div>
            </CardContent>
        </Card>

        <CreateDialog :center="center" :user="$page.props.user" @close="closeCreateDialog" v-model:open="createDialog"
            :mainUrl="$page.props.main_url" />
    </Layout>
</template>