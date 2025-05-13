<script setup>
import Layout from '@/Layout/App.vue'
import RoadmapTitle from '@/components/blocks/roadmap/RoadmapTitle.vue'
import RoadmapCard from '@/components/blocks/roadmap/RoadmapCard.vue'

const roadmapAuth = [
  {
    title: 'pages.roadmap.step_1',
    subtitle: 'pages.roadmap.start_your_work',
    description: 'pages.roadmap.already_auth',
    href: '/admin',
    hreftitle: 'pages.roadmap.start',
  },
  {
    title: 'pages.roadmap.step_2',
    subtitle: 'pages.roadmap.choose_center',
    description: 'pages.roadmap.choose_data',
    href: '/admin/centers',
    hreftitle: 'pages.roadmap.choose_center',
  },
]

const roadmap = [
  {
    title: 'pages.roadmap.step_1',
    subtitle: 'pages.roadmap.auth',
    description: 'pages.roadmap.new_admin',
    href: '/admin/login',
    hreftitle: 'pages.roadmap.auth',
  },
  {
    title: 'pages.roadmap.step_2',
    subtitle: 'pages.roadmap.choose_center',
    description: 'pages.roadmap.choose_data',
    href: '/admin/centers',
    hreftitle: 'pages.roadmap.choose_center',
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
              {{ $t('pages.roadmap.administrator') }}
            </span>
          </h1>
        </template>
      </RoadmapTitle>

      <div v-if="$page['props']['auth_user']?.role === 'admin'"
        class="flex flex-wrap justify-center text-start gap-10">
        <RoadmapCard v-for="(item, index) in roadmapAuth" :key="index" :title="item.title" :subtitle="item.subtitle"
          :description="item.description" :href="item.href" :hreftitle="item.hreftitle" />
      </div>

      <div v-else class="flex flex-wrap justify-center text-start gap-10">
        <RoadmapCard v-for="(item, index) in roadmap" :key="index" :title="item.title" :subtitle="item.subtitle"
          :description="item.description" :href="item.href" :hreftitle="item.hreftitle" />
      </div>
    </section>
  </Layout>
</template>