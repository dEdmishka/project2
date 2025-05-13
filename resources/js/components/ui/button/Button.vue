<script setup>
import { cn } from '@/lib/utils';
import { Primitive } from 'reka-ui';
import { buttonVariants } from '.';
import { motion } from "motion-v"

const props = defineProps({
  variant: { type: null, required: false },
  size: { type: null, required: false },
  class: { type: null, required: false },
  asChild: { type: Boolean, required: false },
  as: { type: null, required: false, default: 'button' },
});
</script>

<template>
  <motion.Primitive
    data-slot="button"
    :as="as"
    :as-child="asChild"
    :class="cn(buttonVariants({ variant, size }), props.class)"
    :whilePress="{ scale: 1.05 }"
    :whileHover="{ scale: 1.03 }"
  >
    <slot />
  </motion.Primitive>
</template>
