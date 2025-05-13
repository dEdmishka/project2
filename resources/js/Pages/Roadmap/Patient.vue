<script setup>
import Layout from '@/Layout/App.vue'
import RoadmapTitle from '@/components/blocks/roadmap/RoadmapTitle.vue'
import RoadmapCard from '@/components/blocks/roadmap/RoadmapCard.vue'

const roadmapAuth = [
  {
    title: 'pages.roadmap.step_1',
    subtitle: 'pages.roadmap.enter_account',
    description: 'pages.roadmap.auth_patient',
    href: '/account',
    hreftitle: 'pages.roadmap.go_to_cabinet',
  },
  {
    title: 'pages.roadmap.step_2',
    subtitle: 'pages.roadmap.choose_center',
    description: 'pages.roadmap.patient_choose_center',
    href: '/account/centers',
    hreftitle: 'pages.roadmap.choose_center',
  },
  {
    title: 'pages.roadmap.step_3',
    subtitle: 'pages.roadmap.end_auth',
    description: 'pages.roadmap.patient_end_auth',
    href: '/account/centers',
    hreftitle: 'pages.roadmap.choose_center',
  },
  {
    title: 'pages.roadmap.step_4',
    subtitle: 'pages.roadmap.choose_procedure',
    description: 'pages.roadmap.patient_choose_procedure',
    href: '/account/procedures',
    hreftitle: 'pages.roadmap.choose_procedure',
  },
  {
    title: 'pages.roadmap.step_5',
    subtitle: 'pages.roadmap.stay_in_touch',
    description: 'pages.roadmap.patient_stay_in_touch',
    href: '/account/notifications',
    hreftitle: 'pages.roadmap.check_messages',
  },
]

const roadmap = [
  {
    title: 'pages.roadmap.step_1',
    subtitle: 'pages.roadmap.register',
    description: 'pages.roadmap.firstly_auth',
    href: '/signup',
    hreftitle: 'pages.roadmap.register',
  },
  {
    title: 'pages.roadmap.step_2',
    subtitle: 'pages.roadmap.authenticate',
    description: 'pages.roadmap.patient_already_auth',
    href: '/login',
    hreftitle: 'pages.roadmap.auth',
  },
  {
    title: 'pages.roadmap.step_3',
    subtitle: 'pages.roadmap.choose_center',
    description: 'pages.roadmap.patient_choose_center',
    href: '/account/centers',
    hreftitle: 'pages.roadmap.choose_center',
  },
  {
    title: 'pages.roadmap.step_4',
    subtitle: 'pages.roadmap.end_auth',
    description: 'pages.roadmap.patient_end_auth',
    href: '/account/centers',
    hreftitle: 'pages.roadmap.choose_center',
  },
  {
    title: 'pages.roadmap.step_5',
    subtitle: 'pages.roadmap.choose_procedure',
    description: 'pages.roadmap.patient_choose_procedure',
    href: '/account/procedures',
    hreftitle: 'pages.roadmap.choose_procedure',
  },
  {
    title: 'pages.roadmap.step_6',
    subtitle: 'pages.roadmap.stay_in_touch',
    description: 'pages.roadmap.patient_stay_in_touch',
    href: '/account/notifications',
    hreftitle: 'pages.roadmap.check_messages',
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
              {{ $t('pages.roadmap.patient') }}
            </span>
          </h1>
        </template>
      </RoadmapTitle>

      <div v-if="$page['props']['auth_user']" class="flex flex-wrap justify-center text-start gap-10">
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