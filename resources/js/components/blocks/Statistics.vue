<script setup>
const props = defineProps({
  stats: Boolean,
})

const preStats = [
  {
    quantity: "2.7K+",
    description: "pages.users",
  },
  {
    quantity: "100+",
    description: "pages.doctors",
  },
  {
    quantity: "10+",
    description: "pages.centers",
  },
  {
    quantity: "10+",
    description: "pages.years_of_work",
  },
];
</script>

<template>
  <section id="statistics">
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
      <div v-for="stat in preStats" :key="stat.description" class="space-y-2 text-center">
        <h2 class="text-3xl sm:text-4xl font-bold ">{{ stat.quantity }}</h2>
        <p class="text-xl text-muted-foreground">{{ $t(stat.description) }}</p>
      </div>
    </div>
  </section>
</template>