<script setup>
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import {
  Speech,
  ChartNetwork,
  User,
  Shield
} from 'lucide-vue-next'

import { motion } from 'motion-v'

const features = [
  {
    icon: Speech,
    title: "pages.communication",
    description:
      "pages.simple_comm",
  },
  {
    icon: ChartNetwork,
    title: "pages.insights",
    description:
      "pages.data_driven",
  },
  {
    icon: User,
    title: "pages.individuality",
    description:
      "pages.rehab_programs",
  },
  {
    icon: Shield,
    title: "pages.security",
    description:
      "pages.secure_and_private",
  },
];
</script>

<template>
  <motion.section id="howItWorks" class="text-center py-12 sm:py-16" initial="hidden" whileInView="visible"
    :viewport="{ once: true }" :variants="{
      visible: { opacity: 1, y: 0 },
      hidden: { opacity: 0, y: 100 }
    }" :transition="{
      type: 'spring',
      duration: 3,
      delay: 0.05
    }">
    <h2 class="text-3xl md:text-4xl font-bold ">
      {{ $t('pages.benefits') }}{{ " " }}
      <span class="bg-gradient-to-b from-primary/60 to-primary text-transparent bg-clip-text">
        {{ $t('pages.of_our') }}{{ " " }}
      </span>
      {{ $t('pages.of_platform') }}
    </h2>
    <p class="md:w-3/4 mx-auto mt-4 mb-8 text-xl text-muted-foreground">
      {{ $t('pages.short_lorem') }}
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
      <Card v-for="(feature, index) in features" :key=feature.title class="bg-muted/50" :whileHover="{ scale: 1.05 }">
        <CardHeader>
          <CardTitle class="grid gap-4 place-items-center">
            <component :is="feature.icon" />
            {{ $t(feature.title) }}
          </CardTitle>
        </CardHeader>
        <CardContent>{{ $t(feature.description) }}</CardContent>
      </Card>
    </div>
  </motion.section>
</template>