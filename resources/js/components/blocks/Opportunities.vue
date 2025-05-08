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

import { motion } from 'motion-v'

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
  <motion.section id="opportunities" class="grid grid-cols-1 place-items-center text-center py-12 sm:py-16"
    initial="hidden" whileInView="visible" :viewport="{ once: true }" :variants="{
      visible: { opacity: 1, y: 0 },
      hidden: { opacity: 0, y: 100 }
    }" :transition="{
      type: 'spring',
      duration: 3,
      delay: 0.05
    }">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 px-4 text-start">
      <Card v-for="(feature, index) in features" :key=feature.title class="grid max-w-75 gap-8 border-0">
        <CardHeader>
          <component class="h-24 w-24" :is="feature.icon" />
        </CardHeader>
        <CardContent class="text-2xl md:text-3xl font-bold">
          <p>{{ feature.description }}</p>
        </CardContent>
        <CardFooter class="grid grid-cols-2 gap-8 items-center font-bold uppercase">
          <div>
            <Link :href="feature.href" class="a-animate">Details</Link>
            <MoveRight class="ml-2 h-4 w-4 inline-block" />
          </div>
        </CardFooter>
      </Card>
    </div>
  </motion.section>
</template>