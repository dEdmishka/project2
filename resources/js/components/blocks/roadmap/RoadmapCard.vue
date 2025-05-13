<script setup>
import { Card, CardContent, CardHeader, CardTitle, CardDescription, CardFooter } from "@/components/ui/card";
import { Link } from "@inertiajs/vue3"
import {
    MoveRight,
} from 'lucide-vue-next'

defineProps({
    title: String,
    subtitle: String,
    description: String,
    href: String,
    hreftitle: String,
})
</script>

<template>
    <Card class="p-4 md:w-75 lg:w-100 gap-8 bg-muted/25" :whileHover="{ scale: 1.05 }" :animate="{
        opacity: [0, 1],
        y: [100, 0],
        transition: {
            type: 'spring',
            duration: 1,
            delay: 0.05
        }
    }">
        <CardHeader>
            <CardTitle
                class="inline font-bold text-3xl md:text-6xl py-1 bg-gradient-to-r from-[#F596D3]  to-[#D247BF] text-transparent bg-clip-text">
                {{ $t(title) }}
            </CardTitle>
            <CardDescription
                class="inline font-bold text-2xl md:text-4xl py-1 bg-gradient-to-r from-[#61DAFB] via-[#1fc0f1] to-[#03a3d7] text-transparent bg-clip-text">
                {{ $t(subtitle) }}
            </CardDescription>
        </CardHeader>
        <CardContent class="flex flex-col justify-between flex-grow">
            <CardDescription class="text-xl font-bold">
                {{ $t(description) }}
            </CardDescription>
        </CardContent>
        <CardFooter v-if="href" class="flex gap-8 items-center font-bold uppercase">
            <Link :href="href" class="a-animate">{{ $t(hreftitle) }}</Link>
            <MoveRight class="h-8 w-8 inline-block]" />
        </CardFooter>
    </Card>
</template>