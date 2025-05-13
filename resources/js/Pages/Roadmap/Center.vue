<script setup>
import Layout from '@/Layout/App.vue'
import RoadmapTitle from '@/components/blocks/roadmap/RoadmapTitle.vue'
import RoadmapCard from '@/components/blocks/roadmap/RoadmapCard.vue'

const roadmap = [
  {
    title: 'pages.roadmap.step_1',
    subtitle: 'pages.roadmap.let_us_know',
    description: 'pages.roadmap.let_us_know_longtext',
    href: '/contacts',
    hreftitle: 'pages.roadmap.contacts',
  },
]
</script>

<template>
  <Layout>
    <section id="patient" class="grid grid-cols-1 place-items-center text-center py-12 sm:py-16">
      <RoadmapTitle>
        <template #title>
          <h1 class="inline">
            <span class="inline bg-gradient-to-r from-[#F596D3]  to-[#D247BF] text-transparent bg-clip-text">
              {{ $t('pages.roadmap.roadmap_for') }}
            </span>
            {{ "" }}
            <span
              class="inline bg-gradient-to-r from-[#61DAFB] via-[#1fc0f1] to-[#03a3d7] text-transparent bg-clip-text">
              {{ $t('pages.roadmap.center') }}
            </span>
          </h1>
        </template>
      </RoadmapTitle>

      <div class="flex flex-wrap justify-center text-start gap-10">
        <RoadmapCard v-for="(item, index) in roadmap" :key="index" :title="item.title" :subtitle="item.subtitle"
          :description="item.description" :href="item.href" :hreftitle="item.hreftitle" />
      </div>
    </section>
  </Layout>
</template>