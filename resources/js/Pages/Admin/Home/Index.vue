<script setup>
import Layout from '@/Layout/Dashboard/Index.vue'
import { Card, CardHeader, CardTitle, CardDescription, CardFooter } from '@/components/ui/card/index'
import { TrendingUpIcon, TrendingDownIcon, } from 'lucide-vue-next';
import { Badge } from '@/components/ui/badge';

const props = defineProps({
  user: Object,
  centers: Number,
  users: Number,
  patients: Number,
  staff: Number,
  wards: Number,
  appointments: Number,
  departments: Number,
  procedures: Number,
  documents: Number,
  notifications: Number,
})
</script>

<template>
  <Layout>
    <template #title>
      Home
    </template>
    <div class="grid gap-6 grid-cols-2 items-center">
      <Card class="@container/card">
        <CardHeader class="relative">
          <CardDescription>{{ $t('account.admin.centers') }}</CardDescription>
          <CardTitle class="@[250px]/card:text-3xl text-2xl font-semibold tabular-nums">
            {{ props.centers }}
          </CardTitle>
          <div class="absolute right-4 top-4">
            <Badge variant="outline" class="flex gap-1 rounded-lg text-xs">
              <TrendingUpIcon class="size-3" />
              +12.5%
            </Badge>
          </div>
        </CardHeader>
        <!-- <CardFooter class="flex-col items-start gap-1 text-sm">
          <div class="line-clamp-1 flex gap-2 font-medium">
            Trending up this month
            <TrendingUpIcon class="size-4" />
          </div>
          <div class="text-muted-foreground">
            Visitors for the last 6 months
          </div>
        </CardFooter> -->
      </Card>
      <Card class="@container/card">
        <CardHeader class="relative">
          <CardDescription>{{ $t('account.admin.departments') }}</CardDescription>
          <CardTitle class="@[250px]/card:text-3xl text-2xl font-semibold tabular-nums">
            {{ props.departments }}
          </CardTitle>
          <div class="absolute right-4 top-4">
            <Badge variant="outline" class="flex gap-1 rounded-lg text-xs">
              <TrendingDownIcon class="size-3" />
              -20%
            </Badge>
          </div>
        </CardHeader>
        <!-- <CardFooter class="flex-col items-start gap-1 text-sm">
          <div class="line-clamp-1 flex gap-2 font-medium">
            Down 20% this period
            <TrendingDownIcon class="size-4" />
          </div>
          <div class="text-muted-foreground">
            Acquisition needs attention
          </div>
        </CardFooter> -->
      </Card>
      <Card class="@container/card">
        <CardHeader class="relative">
          <CardDescription>{{ $t('account.admin.wards') }}</CardDescription>
          <CardTitle class="@[250px]/card:text-3xl text-2xl font-semibold tabular-nums">
            {{ props.wards }}
          </CardTitle>
          <div class="absolute right-4 top-4">
            <Badge variant="outline" class="flex gap-1 rounded-lg text-xs">
              <TrendingUpIcon class="size-3" />
              +12.5%
            </Badge>
          </div>
        </CardHeader>
        <!-- <CardFooter class="flex-col items-start gap-1 text-sm">
          <div class="line-clamp-1 flex gap-2 font-medium">
            Strong user retention
            <TrendingUpIcon class="size-4" />
          </div>
          <div class="text-muted-foreground">Engagement exceed targets</div>
        </CardFooter> -->
      </Card>
      <Card class="@container/card">
        <CardHeader class="relative">
          <CardDescription>{{ $t('account.admin.patients') }}</CardDescription>
          <CardTitle class="@[250px]/card:text-3xl text-2xl font-semibold tabular-nums">
            {{ props.patients }}
          </CardTitle>
          <div class="absolute right-4 top-4">
            <Badge variant="outline" class="flex gap-1 rounded-lg text-xs">
              <TrendingUpIcon class="size-3" />
              +35%
            </Badge>
          </div>
        </CardHeader>
        <!-- <CardFooter class="flex-col items-start gap-1 text-sm">
          <div class="line-clamp-1 flex gap-2 font-medium">
            Steady performance
            <TrendingUpIcon class="size-4" />
          </div>
          <div class="text-muted-foreground">Meets growth projections</div>
        </CardFooter> -->
      </Card>
      <Card class="@container/card">
        <CardHeader class="relative">
          <CardDescription>{{ $t('account.admin.staff') }}</CardDescription>
          <CardTitle class="@[250px]/card:text-3xl text-2xl font-semibold tabular-nums">
            {{ props.staff }}
          </CardTitle>
          <div class="absolute right-4 top-4">
            <Badge variant="outline" class="flex gap-1 rounded-lg text-xs">
              <TrendingUpIcon class="size-3" />
              +25%
            </Badge>
          </div>
        </CardHeader>
        <!-- <CardFooter class="flex-col items-start gap-1 text-sm">
          <div class="line-clamp-1 flex gap-2 font-medium">
            Steady performance
            <TrendingUpIcon class="size-4" />
          </div>
          <div class="text-muted-foreground">Meets growth projections</div>
        </CardFooter> -->
      </Card>
      <Card class="@container/card">
        <CardHeader class="relative">
          <CardDescription>{{ $t('account.admin.users') }}</CardDescription>
          <CardTitle class="@[250px]/card:text-3xl text-2xl font-semibold tabular-nums">
            {{ props.users }}
          </CardTitle>
          <div class="absolute right-4 top-4">
            <Badge variant="outline" class="flex gap-1 rounded-lg text-xs">
              <TrendingUpIcon class="size-3" />
              +4.5%
            </Badge>
          </div>
        </CardHeader>
        <!-- <CardFooter class="flex-col items-start gap-1 text-sm">
          <div class="line-clamp-1 flex gap-2 font-medium">
            Steady performance
            <TrendingUpIcon class="size-4" />
          </div>
          <div class="text-muted-foreground">Meets growth projections</div>
        </CardFooter> -->
      </Card>
      <Card class="@container/card">
        <CardHeader class="relative">
          <CardDescription>{{ $t('account.admin.notifications') }}</CardDescription>
          <CardTitle class="@[250px]/card:text-3xl text-2xl font-semibold tabular-nums">
            {{ props.notifications }}
          </CardTitle>
          <div class="absolute right-4 top-4">
            <Badge variant="outline" class="flex gap-1 rounded-lg text-xs">
              <TrendingUpIcon class="size-3" />
              +4.5%
            </Badge>
          </div>
        </CardHeader>
        <!-- <CardFooter class="flex-col items-start gap-1 text-sm">
          <div class="line-clamp-1 flex gap-2 font-medium">
            Steady performance
            <TrendingUpIcon class="size-4" />
          </div>
          <div class="text-muted-foreground">Meets growth projections</div>
        </CardFooter> -->
      </Card>
      <Card class="@container/card">
        <CardHeader class="relative">
          <CardDescription>{{ $t('account.admin.documents') }}</CardDescription>
          <CardTitle class="@[250px]/card:text-3xl text-2xl font-semibold tabular-nums">
            {{ props.documents }}
          </CardTitle>
          <div class="absolute right-4 top-4">
            <Badge variant="outline" class="flex gap-1 rounded-lg text-xs">
              <TrendingUpIcon class="size-3" />
              +4.5%
            </Badge>
          </div>
        </CardHeader>
        <!-- <CardFooter class="flex-col items-start gap-1 text-sm">
          <div class="line-clamp-1 flex gap-2 font-medium">
            Steady performance
            <TrendingUpIcon class="size-4" />
          </div>
          <div class="text-muted-foreground">Meets growth projections</div>
        </CardFooter> -->
      </Card>
      <Card class="@container/card">
        <CardHeader class="relative">
          <CardDescription>{{ $t('account.admin.procedures') }}</CardDescription>
          <CardTitle class="@[250px]/card:text-3xl text-2xl font-semibold tabular-nums">
            {{ props.procedures }}
          </CardTitle>
          <div class="absolute right-4 top-4">
            <Badge variant="outline" class="flex gap-1 rounded-lg text-xs">
              <TrendingUpIcon class="size-3" />
              +4.5%
            </Badge>
          </div>
        </CardHeader>
        <!-- <CardFooter class="flex-col items-start gap-1 text-sm">
          <div class="line-clamp-1 flex gap-2 font-medium">
            Steady performance
            <TrendingUpIcon class="size-4" />
          </div>
          <div class="text-muted-foreground">Meets growth projections</div>
        </CardFooter> -->
      </Card>
      <Card class="@container/card">
        <CardHeader class="relative">
          <CardDescription>{{ $t('account.admin.appointments') }}</CardDescription>
          <CardTitle class="@[250px]/card:text-3xl text-2xl font-semibold tabular-nums">
            {{ props.appointments }}
          </CardTitle>
          <div class="absolute right-4 top-4">
            <Badge variant="outline" class="flex gap-1 rounded-lg text-xs">
              <TrendingUpIcon class="size-3" />
              +4.5%
            </Badge>
          </div>
        </CardHeader>
        <!-- <CardFooter class="flex-col items-start gap-1 text-sm">
          <div class="line-clamp-1 flex gap-2 font-medium">
            Steady performance
            <TrendingUpIcon class="size-4" />
          </div>
          <div class="text-muted-foreground">Meets growth projections</div>
        </CardFooter> -->
      </Card>
    </div>
  </Layout>
</template>