<script setup>
import { motion } from 'motion-v'
</script>

<template>
    <motion.div class="grid grid-cols-1 place-items-center py-20 md:py-40 gap-10 px-4" :animate="{
        opacity: [0, 1],
        y: [10, 0],
        transition: {
            type: 'spring',
            duration: 2,
            delay: 0.05
        }
    }">
        <div class="text-center lg:text-start space-y-6">
            <div class="text-5xl md:text-6xl font-bold">
                <slot name="title" />
            </div>
        </div>
    </motion.div>
</template>