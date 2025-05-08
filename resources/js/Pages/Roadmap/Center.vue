<script setup>
import Layout from '@/Layout/App.vue'
import RoadmapTitle from '@/components/blocks/roadmap/RoadmapTitle.vue'
import RoadmapCard from '@/components/blocks/roadmap/RoadmapCard.vue'

const roadmap = [
  {
    title: 'Крок 1',
    subtitle: 'Повідомте нам',
    description: 'Спершу Вам необхідно повідомити нас про Ваше бажання бути доєднаними до системи! Перейдіть за посиланням нижче, заповніть контактні поля з Вашою поштою та розпишіть у повідомленні Ваші цілі, назву та адресу! Ми обов`язково і якомога швидше вийдемо з Вами на зв`язок для вирішення робочих моментів!',
    href: '/contacts',
    hreftitle: 'Контакти',
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
              Центра
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