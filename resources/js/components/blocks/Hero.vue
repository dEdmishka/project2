<script setup>
import { Link } from "@inertiajs/vue3"
import { buttonVariants } from "@/components/ui/button";
import { Button } from "@/components/ui/button";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import {
  Medal,
  Map,
  Plane,
  Gift,
  CircleUserRound,
  ShieldUser,
  BookHeart,
  Building2,
} from 'lucide-vue-next'

import { motion } from 'motion-v'
import { animate, stagger } from "motion"
import { splitText } from "motion-plus"
import { ref, onMounted } from "vue"

const containerRef = ref(null)

onMounted(() => {
  document.fonts.ready.then(() => {
    if (!containerRef.value) return

    containerRef.value.style.visibility = "visible"

    const { words } = splitText(
      containerRef.value.querySelector('h6')
    )

    animate(
      words,
      { opacity: [0, 1], y: [10, 0] },
      {
        type: "spring",
        duration: 3,
        bounce: 0,
        delay: stagger(0.3),
      }
    )
  })
})

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
  <section class="grid lg:grid-cols-2 place-items-center py-20 md:py-40 gap-10 px-4">
    <div class="text-center lg:text-start space-y-6">
      <motion.div class="text-5xl md:text-6xl font-bold" :animate="{
        opacity: [0, 1],
        y: [10, 0],
        transition: {
          type: 'spring',
          duration: 2,
          delay: 0.05
        }
      }">
        <h1 class="inline">
          <span class="inline bg-gradient-to-r from-[#F596D3]  to-[#D247BF] text-transparent bg-clip-text">
            {{ $t('account.title.rehab') }}
          </span>
          <br />
        </h1>
        <h2 class="inline">
          <span class="inline bg-gradient-to-r from-[#61DAFB] via-[#1fc0f1] to-[#03a3d7] text-transparent bg-clip-text">
            {{ $t('account.title.system') }}
          </span>
        </h2>
      </motion.div>

      <motion.p class="text-xl text-muted-foreground md:w-10/12 mx-auto lg:mx-0" :animate="{
        opacity: [0, 1],
        x: [100, 0],
        transition: {
          type: 'spring',
          duration: 2,
          delay: 0.05
        }
      }">
        {{ $t('pages.greeting') }}
        <br />
        {{ $t('pages.you_have_opportunity') }}
      </motion.p>

      <motion.div class="space-y-6 md:space-y-0 md:space-x-4 flex" :animate="{
        opacity: [0, 1],
        x: [-100, 0],
        transition: {
          type: 'spring',
          duration: 2,
          delay: 0.3
        }
      }">
        <motion.div :whileHover="{ scale: 1.05 }" class="w-full md:w-1/3">
          <Link href="/signup" :class="`cursor-pointer w-full ${buttonVariants({ variant: 'default' })}`">
          {{ $t('pages.signup') }}</Link>
        </motion.div>

        <motion.div :whileHover="{ scale: 1.05 }" class="w-full md:w-1/3">
          <Link href="/login" :class="`cursor-pointer w-full ${buttonVariants({ variant: 'outline' })}`">{{
            $t('pages.login') }}
          </Link>
        </motion.div>
      </motion.div>

      <motion.div class="space-y-4 md:space-y-0 md:space-x-4 md:px-4" :animate="{
        opacity: [0, 1],
        x: [-100, 0],
        transition: {
          type: 'spring',
          duration: 2,
          delay: 0.3
        }
      }">
        <motion.div :whileHover="{ scale: 1.05 }" class="w-full md:w-2/3">
          <Link href="/contacts" :class="`cursor-pointer w-full ${buttonVariants({ variant: 'outline' })}`">{{
            $t('pages.our_contacts') }}</Link>
        </motion.div>
      </motion.div>
    </div>

    <div class="text-center space-y-6" ref="containerRef">
      <div class="text-2xl md:text-3xl font-bold">
        <h6>{{
          $t('pages.new_to_system') }}</h6>
      </div>
      <div class="text-2sm sm:text-1xl font-bold">
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
    <!-- {/* Hero cards sections */}
      <div class="z-10">
        <HeroCards />
      </div> -->

    <!-- {/* Shadow effect */} -->
    <!-- <div class="shadow"></div> -->
  </section>
</template>