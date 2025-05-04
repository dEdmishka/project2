<script setup>
import Layout from "@/Layout/Dashboard/Index.vue";
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
    Trash
} from 'lucide-vue-next'

import { Link } from "@inertiajs/vue3"
import {
    Card,
    CardTitle,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
} from '@/components/ui/card'

import { Label } from '@/components/ui/label'
import { Input } from '@/components/ui/input'
import { Button } from '@/components/ui/button'
import { Textarea } from '@/components/ui/textarea'
import { Checkbox } from '@/components/ui/checkbox'
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select'
import Autoplay from 'embla-carousel-autoplay'
import { Carousel, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious } from '@/components/ui/carousel'

import { toast } from 'vue-sonner';
import { watch, ref } from 'vue';
import { dayName, formatPhoneNumber } from '@/helper'

const props = defineProps({
    user: Object,
    center: Object,
    main_url: String,
})

const center = ref(props.center)

import {
    Medal,
    Map,
    Plane,
    Gift,
    MoveRight,
} from 'lucide-vue-next'
const features = [
    {
        icon: Medal,
        title: "Accessibility",
        date: "2023-10-01",
        description:
            "Реабілітація за різними напрямками",
        href: "/info/directions",
    },
    {
        icon: Map,
        title: "Community",
        date: "2023-10-01",
        description:
            "Реабілітація поранених",
        href: "/info/wounded",
    },
    {
        icon: Plane,
        title: "Scalability",
        date: "2023-10-01",
        description:
            "Реабілітація дітей",
        href: "/info/kids",
    },
    {
        icon: Gift,
        title: "Gamification",
        date: "2023-10-01",
        description:
            "Реабілітація за кошти НСЗУ",
        href: "/info/national",
    },
];

</script>

<template>
    <Layout>
        <!-- {{ center }} -->
        <Card class="grid p-4 gap-8 border-0 shadow-none">
            <CardHeader>
                <CardTitle
                    class="inline text-center font-bold text-3xl md:text-6xl py-3 bg-gradient-to-r from-[#F596D3]  to-[#D247BF] text-transparent bg-clip-text">
                    {{ center.name }}
                </CardTitle>
                <CardDescription class="inline text-center text-xl text-gray-500 font-bold">
                    Added at {{ center.created_at.slice(0, 10) }}
                </CardDescription>
            </CardHeader>
            <CardContent class="grid grid-cols-2 gap-4">
                <div class="grid">
                    <CardDescription
                        class="text-xl font-bold inline py-1 bg-gradient-to-r from-[#61DAFB] via-[#1fc0f1] to-[#03a3d7] text-transparent bg-clip-text">
                        {{ center.description }}
                    </CardDescription>
                    <CardDescription
                        class="text-xl font-bold inline py-1 bg-gradient-to-r from-[#61DAFB] via-[#1fc0f1] to-[#03a3d7] text-transparent bg-clip-text">
                        Пошта: <p
                            class="inline bg-gradient-to-r from-[#e43333] via-[#f11f1f] to-[#d70303] text-transparent bg-clip-text">
                            {{ center.email }}</p>
                    </CardDescription>
                    <CardDescription
                        class="text-xl font-bold inline py-1 bg-gradient-to-r from-[#61DAFB] via-[#1fc0f1] to-[#03a3d7] text-transparent bg-clip-text">
                        Адреса: <p
                            class="inline bg-gradient-to-r from-[#e43333] via-[#f11f1f] to-[#d70303] text-transparent bg-clip-text">
                            {{ center.address }}</p>
                    </CardDescription>
                    <!-- {{ center }} -->
                    <CardDescription
                        class="text-xl font-bold flex gap-2 py-1 bg-gradient-to-r from-[#61DAFB] via-[#1fc0f1] to-[#03a3d7] text-transparent bg-clip-text">
                        Телефон: <p v-for="(phone, index) in center.phone_numbers"
                            class="inline bg-gradient-to-r from-[#e43333] via-[#f11f1f] to-[#d70303] text-transparent bg-clip-text">
                            {{ phone.phone_number }}</p>
                    </CardDescription>
                    <CardDescription
                        class="text-xl capitalize font-bold flex gap-2 py-1 bg-gradient-to-r from-[#61DAFB] via-[#1fc0f1] to-[#03a3d7] text-transparent bg-clip-text">
                        Соц. мережі: <a v-for="(link, index) in center.social_links" :href="link.url"
                            class="inline bg-gradient-to-r from-[#e43333] via-[#f11f1f] to-[#d70303] text-transparent bg-clip-text">
                            {{ link.platform }}</a>
                    </CardDescription>
                    <div class="grid grid-cols-2">
                        <div class="col-span-1">
                            <div class="text-start font-medium grid grid-cols-3 gap-4"
                                v-for="(hour, index) in center.working_hours" :key="index">
                                <p>{{ dayName(hour.day_of_week) }}</p>
                                <p class="text-center">{{ hour.start_time ?? '--:--' }}</p>
                                <p class="text-center">{{ hour.end_time ?? '--:--' }}</p>
                            </div>
                        </div>
                    </div>
                    <CardFooter class="font-bold uppercase items-end p-0">
                        <Button class="cursor-pointer" @click="showCreateDialog">Хочу до
                            вас!</Button>
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
    </Layout>
</template>