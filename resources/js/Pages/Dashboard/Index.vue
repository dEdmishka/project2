<script setup>
import { Button } from "@/components/ui/button/index"

import Layout from "@/Layout/App.vue";
</script>

<template>
  <Layout>
    <!-- <div class="flex flex-1 flex-col gap-4 p-4 pt-0"> -->
    <!-- toggle -->
    <!-- <div class="grid auto-rows-min gap-4 md:grid-cols-3">
          <div class="aspect-video rounded-xl bg-muted/50" />
          <div class="aspect-video rounded-xl bg-muted/50" />
          <div class="aspect-video rounded-xl bg-muted/50" />
        </div>
        <div class="min-h-[100vh] flex-1 rounded-xl bg-muted/50 md:min-h-min" /> -->
    <!-- </div> -->
    <div class="flex flex-col items-center gap-1 text-center">
      <h3 class="text-2xl font-bold tracking-tight">
        No products
      </h3>
      <p class="text-sm text-muted-foreground">
        You can add a new product.
      </p>
      <Button class="mt-4">
        Add Product
      </Button>
    </div>
  </Layout>
</template>