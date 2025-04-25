<script setup>
import Layout from '@/Layout/Dashboard/Index.vue'
import { Head } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
import { Card, CardHeader, CardTitle, CardDescription, CardFooter } from '@/components/ui/card/index'

// defineProps({ user: Object })
</script>

<template>
  <Layout>
    <!-- <Head title="Welcome" />
    <h1 class="text-blue-600 text-center p-5">Welcome</h1>
    <h1 class="text-3xl font-bold underline">
      Hello admin!
    </h1>
    <Button>Click Me</Button> -->
    <!-- <p>Hello {{ user.name }}, welcome to your first Inertia app!</p> -->
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
  </Layout>
</template>