<script setup>
import { Card, CardContent, CardHeader, CardTitle, CardFooter } from "@/components/ui/card";
import { Link } from "@inertiajs/vue3"
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
  <section id="opportunities" class="grid grid-cols-1 place-items-center text-center py-12 sm:py-16 ">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 px-4 text-start">
      <Card v-for="(feature, index) in features" :key=feature.title class="grid max-w-75 gap-8 border-0">
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
    </div>
  </section>
</template>