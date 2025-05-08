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
        <!-- Build your React landing page effortlessly with the required sections
          to your project. -->
        Ми відкрились відносно недавно, але вже готові Вам презентувати перші здобутки у даній сфері!
        <br />
        Наше завдання - надати Вам всі можливості у відновленні Вашого здоров`я!
      </motion.p>

      <motion.div class="space-y-6 md:space-y-0 md:space-x-4" :animate="{
        opacity: [0, 1],
        x: [-100, 0],
        transition: {
          type: 'spring',
          duration: 2,
          delay: 0.3
        }
      }">
        <motion.Link href="/signup" :class="`w-full md:w-1/3 ${buttonVariants({ variant: 'default' })}`"
          :whileHover="{ scale: 1.05 }">Signup</motion.Link>

        <motion.Link href="/login" :class="`w-full md:w-1/3 ${buttonVariants({ variant: 'outline' })}`"
          :whileHover="{ scale: 1.05 }">Login</motion.Link>
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
        <motion.Link href="/contacts" :class="`w-full md:w-2/3 ${buttonVariants({ variant: 'outline' })}`"
          :whileHover="{ scale: 1.05 }">Our contacts</motion.Link>
      </motion.div>
    </div>
  </section>
</template>