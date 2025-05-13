<script setup>
import Layout from '@/Layout/App.vue'
import RoadmapTitle from '@/components/blocks/roadmap/RoadmapTitle.vue'
import RoadmapCard from '@/components/blocks/roadmap/RoadmapCard.vue'

const roadmapAuth = [
  {
    title: 'pages.roadmap.step_1',
    subtitle: 'pages.roadmap.check_your_data',
    description: 'pages.roadmap.auth_employee',
    href: '/account',
    hreftitle: 'pages.roadmap.go_to_account',
  },
  {
    title: 'pages.roadmap.step_2',
    subtitle: 'pages.roadmap.appointments',
    description: 'pages.roadmap.end_of_registration',
    href: '/account/appointments',
    hreftitle: 'pages.roadmap.show_appointments',
  },
  {
    title: 'pages.roadmap.step_3',
    subtitle: 'pages.roadmap.patients',
    description: 'pages.roadmap.patients_link',
    href: '/account/patients',
    hreftitle: 'pages.roadmap.show_patients',
  },
  {
    title: 'pages.roadmap.step_4',
    subtitle: 'pages.roadmap.stay_in_touch',
    description: 'pages.roadmap.function_chat',
    href: '/account/chat',
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
    subtitle: 'pages.roadmap.notify_administrator',
    description: 'pages.roadmap.notify_administrator_employee',
    href: '/admin',
    hreftitle: 'pages.roadmap.administrator',
  },
  {
    title: 'pages.roadmap.step_3',
    subtitle: 'pages.roadmap.authenticate',
    description: 'pages.roadmap.auth_employee',
    href: '/login',
    hreftitle: 'pages.roadmap.auth',
  },
  {
    title: 'pages.roadmap.step_4',
    subtitle: 'pages.roadmap.check_your_data',
    description: 'pages.roadmap.check_your_account_data',
    href: '/account',
    hreftitle: 'pages.roadmap.go_to_account',
  },
  {
    title: 'pages.roadmap.step_5',
    subtitle: 'pages.roadmap.appointments',
    description: 'pages.roadmap.end_of_registration',
    href: '/account/appointments',
    hreftitle: 'pages.roadmap.show_appointments',
  },
  {
    title: 'pages.roadmap.step_6',
    subtitle: 'pages.roadmap.patients',
    description: 'pages.roadmap.patients_link',
    href: '/account/patients',
    hreftitle: 'pages.roadmap.show_patients',
  },
  {
    title: 'pages.roadmap.step_7',
    subtitle: 'pages.roadmap.stay_in_touch',
    description: 'pages.roadmap.function_chat',
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
              {{ $t('pages.roadmap.employee') }}
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