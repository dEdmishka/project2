<script setup>
import { Card, CardContent, CardHeader, CardTitle, CardDescription, CardFooter } from "@/components/ui/card";
import { Link } from "@inertiajs/vue3"
import {
  Stethoscope,
  ShieldHalf,
  Baby,
  Hospital,
  MoveRight,
} from 'lucide-vue-next'
import Autoplay from 'embla-carousel-autoplay'
import { Carousel, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious } from '@/components/ui/carousel'

const features = [
  {
    icon: Stethoscope,
    title: "pages.rehabilitation",
    date: "2025-01-01",
    description:
      "pages.rehab_directions",
    // href: "/info/directions",
  },
  {
    icon: ShieldHalf,
    title: "pages.rehabilitation",
    date: "2025-01-01",
    description:
      "pages.rehab_wounded",
    // href: "/info/wounded",
  },
  {
    icon: Baby,
    title: "pages.rehabilitation",
    date: "2025-01-01",
    description:
      "pages.rehab_kids",
    // href: "/info/kids",
  },
  {
    icon: Hospital,
    title: "pages.rehabilitation",
    date: "2025-01-01",
    description:
      "pages.rehab_national",
    // href: "/info/national",
  },
];
</script>

<template>
  <section id="news" class="grid grid-cols-1 place-items-center text-center py-12 sm:py-16 ">
    <Carousel class="w-full" :opts="{
      align: 'start',
    }" :plugins="[Autoplay({
      delay: 2000,
    })]">
      <CarouselContent>
        <CarouselItem v-for="(feature, index) in features" :key=feature.title class="p-6 basis-1/3">
          <div class="p-1">
            <Card class="flex aspect-square justify-center p-6 text-start">
              <CardHeader>
                <component class="h-24 w-24" :is="feature.icon" />
              </CardHeader>
              <CardTitle class="px-6 text-2xl md:text-3xl font-bold">
                {{ $t(feature.title) }}
              </CardTitle>
              <CardDescription class="px-6">
                {{ feature.date }}
              </CardDescription>
              <CardContent class="text-xl font-bold">
                <p>{{ $t(feature.description) }}</p>
              </CardContent>
              <CardFooter class="grid grid-cols-2 gap-8 items-center font-bold uppercase">
                <div>
                  <!-- <Link :href="feature.href" class="a-animate">{{ $t('pages.read_more') }}</Link> -->
                  <Link href="#" class="a-animate">{{ $t('pages.read_more') }}</Link>
                  <MoveRight class="ml-2 h-4 w-4 inline-block" />
                </div>
              </CardFooter>
            </Card>
          </div>
        </CarouselItem>
      </CarouselContent>
      <!-- <CarouselPrevious />
      <CarouselNext /> -->
    </Carousel>
  </section>
</template>