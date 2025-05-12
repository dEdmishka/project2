<script setup>
import { Link } from "@inertiajs/vue3"
import { buttonVariants } from "@/components/ui/button";

import { motion } from 'motion-v'
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
            About
          </span>
        </h1>
        <h2 class="inline">
          <span class="inline bg-gradient-to-r from-[#61DAFB] via-[#1fc0f1] to-[#03a3d7] text-transparent bg-clip-text">
            Us
          </span>
        </h2>
      </motion.div>

      <motion.p class="text-xl text-muted-foreground mx-auto lg:mx-0" :animate="{
        opacity: [0, 1],
        x: [100, 0],
        transition: {
          type: 'spring',
          duration: 2,
          delay: 0.05
        }
      }">
        {{ $t('pages.about_us_p1') }}
        <br />
        {{ $t('pages.about_us_p2') }}
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
  </section>
</template>