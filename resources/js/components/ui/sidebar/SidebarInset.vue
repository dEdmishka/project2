<script setup>
import { cn } from '@/lib/utils';

const props = defineProps({
  class: { type: null, required: false },
});

import { motion } from 'motion-v'
</script>

<template>
  <motion.main
    :animate="{
            opacity: [0, 1],
            x: [50, 0],
            transition: {
                type: 'linear',
                duration: 1,
                delay: 0
            }
        }"
    data-slot="sidebar-inset"
    :class="
      cn(
        'bg-background relative flex w-full flex-1 flex-col',
        'md:peer-data-[variant=inset]:m-2 md:peer-data-[variant=inset]:ml-0 md:peer-data-[variant=inset]:rounded-xl md:peer-data-[variant=inset]:shadow-sm md:peer-data-[variant=inset]:peer-data-[state=collapsed]:ml-2',
        props.class,
      )
    "
  >
    <slot />
  </motion.main>
</template>
