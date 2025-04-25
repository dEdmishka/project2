<script setup>
import { Button } from "@/components/ui/button/index"
import { Card, CardHeader, CardTitle, CardDescription, CardFooter } from '@/components/ui/card/index'
import { TrendingUpIcon, TrendingDownIcon } from "lucide-vue-next";
import { Badge } from "@/components/ui/badge";
import Layout from "@/Layout/Dashboard/Index.vue";
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
    <template #title>
      Dashboard
    </template>
    <!-- <div class="flex flex-col items-center gap-1 text-center"> -->
      <div class="grid gap-4 md:grid-cols-2 md:gap-4 lg:grid-cols-4">
<Card class="@container/card">
        <CardHeader class="relative">
          <CardDescription>Total Revenue</CardDescription>
          <CardTitle class="@[250px]/card:text-3xl text-2xl font-semibold tabular-nums">
            $1,250.00
          </CardTitle>
          <div class="absolute right-4 top-4">
            <Badge variant="outline" class="flex gap-1 rounded-lg text-xs">
              <TrendingUpIcon class="size-3" />
              +12.5%
            </Badge>
          </div>
        </CardHeader>
        <CardFooter class="flex-col items-start gap-1 text-sm">
          <div class="line-clamp-1 flex gap-2 font-medium">
            Trending up this month <TrendingUpIcon class="size-4" />
          </div>
          <div class="text-muted-foreground">
            Visitors for the last 6 months
          </div>
        </CardFooter>
      </Card>
      <Card class="@container/card">
        <CardHeader class="relative">
          <CardDescription>New Customers</CardDescription>
          <CardTitle class="@[250px]/card:text-3xl text-2xl font-semibold tabular-nums">
            1,234
          </CardTitle>
          <div class="absolute right-4 top-4">
            <Badge variant="outline" class="flex gap-1 rounded-lg text-xs">
              <TrendingDownIcon class="size-3" />
              -20%
            </Badge>
          </div>
        </CardHeader>
        <CardFooter class="flex-col items-start gap-1 text-sm">
          <div class="line-clamp-1 flex gap-2 font-medium">
            Down 20% this period <TrendingDownIcon class="size-4" />
          </div>
          <div class="text-muted-foreground">
            Acquisition needs attention
          </div>
        </CardFooter>
      </Card>
      <Card class="@container/card">
        <CardHeader class="relative">
          <CardDescription>Active Accounts</CardDescription>
          <CardTitle class="@[250px]/card:text-3xl text-2xl font-semibold tabular-nums">
            45,678
          </CardTitle>
          <div class="absolute right-4 top-4">
            <Badge variant="outline" class="flex gap-1 rounded-lg text-xs">
              <TrendingUpIcon class="size-3" />
              +12.5%
            </Badge>
          </div>
        </CardHeader>
        <CardFooter class="flex-col items-start gap-1 text-sm">
          <div class="line-clamp-1 flex gap-2 font-medium">
            Strong user retention <TrendingUpIcon class="size-4" />
          </div>
          <div class="text-muted-foreground">Engagement exceed targets</div>
        </CardFooter>
      </Card>
      <Card class="@container/card">
        <CardHeader class="relative">
          <CardDescription>Growth Rate</CardDescription>
          <CardTitle class="@[250px]/card:text-3xl text-2xl font-semibold tabular-nums">
            4.5%
          </CardTitle>
          <div class="absolute right-4 top-4">
            <Badge variant="outline" class="flex gap-1 rounded-lg text-xs">
              <TrendingUpIcon class="size-3" />
              +4.5%
            </Badge>
          </div>
        </CardHeader>
        <CardFooter class="flex-col items-start gap-1 text-sm">
          <div class="line-clamp-1 flex gap-2 font-medium">
            Steady performance <TrendingUpIcon class="size-4" />
          </div>
          <div class="text-muted-foreground">Meets growth projections</div>
        </CardFooter>
      </Card>
      <!-- </div> -->
      <!-- <h3 class="text-2xl font-bold tracking-tight">
        No products
      </h3>
      <p class="text-sm text-muted-foreground">
        You can add a new product.
      </p>
      <Button class="mt-4">
        Add Product
      </Button> -->
    </div>
  </Layout>
</template>