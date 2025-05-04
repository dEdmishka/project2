<script setup>
import Layout from '@/Layout/App.vue'
import RoadmapTitle from '@/components/blocks/roadmap/RoadmapTitle.vue'
import RoadmapCard from '@/components/blocks/roadmap/RoadmapCard.vue'

const roadmap = [
  {
    title: 'Крок 1',
    subtitle: 'Зареєструйтеся',
    description: 'Заповніть, будь-ласка, онлайн-анкету. На підставі анкетних даних фахівці нашого центру складуть для Вас попередню програму реабілітації. За потреби, для уточнення програми реабілітації з Вами буде проведена онлай чи оффлайн зустріч.',
    href: '/signup',
    hreftitle: 'Зареєструватися',
  },
  {
    title: 'Крок 1',
    subtitle: 'Зареєструйтеся',
    description: 'Заповніть, будь-ласка, онлайн-анкету. На підставі анкетних даних фахівці нашого центру складуть для Вас попередню програму реабілітації. За потреби, для уточнення програми реабілітації з Вами буде проведена онлай чи оффлайн зустріч.',
    href: '/signup',
    hreftitle: 'Зареєструватися',
  },
  {
    title: 'Крок 1',
    subtitle: 'Зареєструйтеся',
    description: 'Заповніть, будь-ласка, онлайн-анкету. На підставі анкетних даних фахівці нашого центру складуть для Вас попередню програму реабілітації. За потреби, для уточнення програми реабілітації з Вами буде проведена онлай чи оффлайн зустріч.',
    href: '/signup',
    hreftitle: 'Зареєструватися',
  },
  {
    title: 'Крок 1',
    subtitle: 'Зареєструйтеся',
    description: 'Заповніть, будь-ласка, онлайн-анкету. На підставі анкетних даних фахівці нашого центру складуть для Вас попередню програму реабілітації. За потреби, для уточнення програми реабілітації з Вами буде проведена онлай чи оффлайн зустріч.',
    href: '/signup',
    hreftitle: 'Зареєструватися',
  },
  {
    title: 'Крок 1',
    subtitle: 'Зареєструйтеся',
    description: 'Заповніть, будь-ласка, онлайн-анкету. На підставі анкетних даних фахівці нашого центру складуть для Вас попередню програму реабілітації. За потреби, для уточнення програми реабілітації з Вами буде проведена онлай чи оффлайн зустріч.',
    href: '/signup',
    hreftitle: 'Зареєструватися',
  },
]
</script>

<template>
  <Layout>
    <section id="patient" class="grid grid-cols-1 place-items-center text-center py-12 sm:py-16 ">
      <RoadmapTitle>
        <template #title>
          <h1 class="inline">
            <span class="inline bg-gradient-to-r from-[#F596D3]  to-[#D247BF] text-transparent bg-clip-text">
              Шлях
            </span>
            <span
              class="inline bg-gradient-to-r from-[#61DAFB] via-[#1fc0f1] to-[#03a3d7] text-transparent bg-clip-text">
              Спеціаліста
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