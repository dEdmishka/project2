<script setup>
import { Link } from "@inertiajs/vue3"
import FAQ from '@/components/blocks/FAQ.vue'
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import {
  CircleUserRound,
  ShieldUser,
  BookHeart,
  Building2,
} from 'lucide-vue-next'

const features = [
  {
    icon: CircleUserRound,
    title: "pages.new_patient",
    description:
      "pages.roadmap_patient",
    href: "/roadmap/patient",
    animation: {
      opacity: [0, 1],
      y: [100, 0],
      transition: {
        type: 'spring',
        duration: 2,
        delay: 0.3
      }
    }
  },
  {
    icon: BookHeart,
    title: "pages.new_employee",
    description:
      "pages.roadmap_employee",
    href: "/roadmap/employee",
    animation: {
      opacity: [0, 1],
      y: [100, 0],
      transition: {
        type: 'spring',
        duration: 2,
        delay: 0.8
      }
    }
  },
  {
    icon: ShieldUser,
    title: "pages.new_administrator",
    description:
      "pages.roadmap_administrator",
    href: "/roadmap/administrator",
    animation: {
      opacity: [0, 1],
      y: [100, 0],
      transition: {
        type: 'spring',
        duration: 2,
        delay: 1.3
      }
    }
  },
  {
    icon: Building2,
    title: "pages.new_center",
    description:
      "pages.roadmap_center",
    href: "/roadmap/center",
    animation: {
      opacity: [0, 1],
      y: [100, 0],
      transition: {
        type: 'spring',
        duration: 2,
        delay: 1.8
      }
    }
  },
];
</script>

<template>
  <section class="grid lg:grid-cols-2 place-items-center py-20 gap-10 px-4">
    <div class="text-center lg:text-start space-y-6">
      <div class="text-5xl md:text-6xl font-bold">
        <h1 class="inline">
          <span class="inline bg-gradient-to-r from-[#F596D3]  to-[#D247BF] text-transparent bg-clip-text">
            {{ $t('pages.help') }}
          </span>
        </h1>
        {{ "" }}
        <h2 class="inline">
          <span class="inline bg-gradient-to-r from-[#61DAFB] via-[#1fc0f1] to-[#03a3d7] text-transparent bg-clip-text">
            {{ $t('pages.page') }}
          </span>
        </h2>
      </div>

      <p class="text-xl text-muted-foreground md:w-10/12 mx-auto lg:mx-0">
        {{ $t('pages.help_hero_p1') }}
        <br />
        {{ $t('pages.help_hero_p2') }}
      </p>

      <div class="text-2sm sm:text-1xl font-bold text-center">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
          <Card v-for="(feature, index) in features" :key=feature.title class="bg-muted/50" :animate=feature.animation
            :whilePress="{ scale: 1.05 }">
            <Link :href="feature.href">
            <CardHeader>
              <CardTitle class="grid gap-2 place-items-center">
                <component :is="feature.icon" />
                {{ $t(feature.title) }}
              </CardTitle>
            </CardHeader>
            <CardContent>{{ $t(feature.description) }}</CardContent>
            </Link>
          </Card>
        </div>
      </div>
    </div>
    <FAQ />
  </section>
</template>