<script setup>
import Layout from '@/Layout/App.vue'
import RoadmapTitle from '@/components/blocks/roadmap/RoadmapTitle.vue'
import RoadmapCard from '@/components/blocks/roadmap/RoadmapCard.vue'

const roadmapAuth = [
  {
    title: 'Крок 1',
    subtitle: 'Розпочніть свою роботу',
    description: 'Вже зареєстровані? Чудово! Тоді розпочинайте своб роботу з необхідної Вам категорії даних!',
    href: '/admin',
    hreftitle: 'Розпочати',
  },
  {
    title: 'Крок 2',
    subtitle: 'Оберіть центр',
    description: 'На сторінках для даних, відмінних від центрів, ми маєте змогу відбирати ті дані, які належать конкретному центру! Для роботи з потрібним центром, просто оберіть необхідний у випадаючому списку!',
    href: '/admin/centers',
    hreftitle: 'Обрати центр',
  },
]

const roadmap = [
  {
    title: 'Крок 1',
    subtitle: 'Авторизуйтеся',
    description: 'Як новому адміністратору, Вам повинні були надати дані для авторизації! Перейдіть за посиланням нижче для подальшої авторизації в системі, після чого Ви опинитеся у дашбоарді!',
    href: '/admin/login',
    hreftitle: 'Авторизуватися',
  },
  {
    title: 'Крок 2',
    subtitle: 'Оберіть центр',
    description: 'На сторінках для даних, відмінних від центрів, ми маєте змогу відбирати ті дані, які належать конкретному центру! Для роботи з потрібним центром, просто оберіть необхідний у випадаючому списку!',
    href: '/admin/centers',
    hreftitle: 'Обрати центр',
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
              Шлях
            </span>
            <span
              class="inline bg-gradient-to-r from-[#61DAFB] via-[#1fc0f1] to-[#03a3d7] text-transparent bg-clip-text">
              Адміністратора
            </span>
          </h1>
        </template>
      </RoadmapTitle>

      <div v-if="$page['props']['auth_user']['role'] === 'admin'"
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