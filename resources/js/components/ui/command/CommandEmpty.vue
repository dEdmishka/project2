<script setup>
import { cn } from '@/lib/utils';
import { Primitive } from 'reka-ui';
import { computed } from 'vue';
import { useCommand } from '.';

const props = defineProps({
  asChild: { type: Boolean, required: false },
  as: { type: null, required: false },
  class: { type: null, required: false },
});

const delegatedProps = computed(() => {
  const { class: _, ...delegated } = props;

  return delegated;
});

const { filterState } = useCommand();
const isRender = computed(
  () => !!filterState.search && filterState.filtered.count === 0,
);
</script>

<template>
  <Primitive
    v-if="isRender"
    data-slot="command-empty"
    v-bind="delegatedProps"
    :class="cn('py-6 text-center text-sm', props.class)"
  >
    <slot />
  </Primitive>
</template>
