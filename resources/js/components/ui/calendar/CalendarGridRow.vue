<script setup>
import { cn } from '@/lib/utils';
import { CalendarGridRow, useForwardProps } from 'reka-ui';
import { computed } from 'vue';

const props = defineProps({
  asChild: { type: Boolean, required: false },
  as: { type: null, required: false },
  class: { type: null, required: false },
});

const delegatedProps = computed(() => {
  const { class: _, ...delegated } = props;

  return delegated;
});

const forwardedProps = useForwardProps(delegatedProps);
</script>

<template>
  <CalendarGridRow
    data-slot="calendar-grid-row"
    :class="cn('flex', props.class)"
    v-bind="forwardedProps"
  >
    <slot />
  </CalendarGridRow>
</template>
