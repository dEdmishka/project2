<script setup>
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Link } from "@inertiajs/vue3"
import {
  Medal,
  Map,
  Plane,
  Gift,
  MoveRight,
} from 'lucide-vue-next'
import CardFooter from "./ui/card/CardFooter.vue";
import Autoplay from 'embla-carousel-autoplay'
import { Carousel, CarouselContent, CarouselItem, CarouselNext, CarouselPrevious } from '@/components/ui/carousel'


const features = [
  {
    icon: Medal,
    title: "Accessibility",
    description:
      "Реабілітація за різними напрямками",
    href: "/info/directions",
  },
  {
    icon: Map,
    title: "Community",
    description:
      "Реабілітація поранених",
    href: "/info/wounded",
  },
  {
    icon: Plane,
    title: "Scalability",
    description:
      "Реабілітація дітей",
    href: "/info/kids",
  },
  {
    icon: Gift,
    title: "Gamification",
    description:
      "Реабілітація за кошти НСЗУ",
    href: "/info/national",
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
        <!-- <CarouselItem v-for="(feature, index) in features" :key=feature.title class="basis-1/3 gap-2 px-4 text-start">
          <Card class="grid max-w-75 gap-8 border-0">
            <CardHeader>
              <component class="h-24 w-24" :is="feature.icon" />
            </CardHeader>
            <CardContent class="text-2xl md:text-3xl font-bold">
              <p>{{ feature.description }}</p>
            </CardContent>
            <CardFooter class="grid grid-cols-4 gap-8 items-center font-bold uppercase">
              <Link :href="feature.href">Details</Link>
              <MoveRight class="h-4 w-4 inline-block" />
            </CardFooter>
          </Card>
        </CarouselItem> -->
        <CarouselItem v-for="(feature, index) in features" :key=feature.title class="p-6 basis-1/3">
          <div class="p-1">
            <Card class="flex aspect-square justify-center p-6 text-start">
              <CardHeader>
                <component class="h-24 w-24" :is="feature.icon" />
              </CardHeader>
              <CardContent class="text-2xl md:text-3xl font-bold">
                <p>{{ feature.description }}</p>
              </CardContent>
              <CardFooter class="grid grid-cols-3 gap-8 items-center font-bold uppercase">
                <Link :href="feature.href">Read More</Link>
                <MoveRight class="h-4 w-4 inline-block" />
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