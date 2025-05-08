<script setup>
import Layout from '@/Layout/App.vue'
import RoadmapTitle from '@/components/blocks/roadmap/RoadmapTitle.vue'
import RoadmapCard from '@/components/blocks/roadmap/RoadmapCard.vue'

const roadmapAuth = [
  {
    title: 'Крок 1',
    subtitle: 'Перевірте свої дані',
    description: 'Вже зареєстровані та маєте статус працівника? Чудово! Перейдіть на сторінку особистого кабінету, перевірте свої персональні дані, а також скорегуйте свій розклад роботи!',
    href: '/account',
    hreftitle: 'Перейти до кабінету',
  },
  {
    title: 'Крок 2',
    subtitle: 'Заплановані сеанси',
    description: 'Після завершення реєстрації у особистому кабінеті, серед вкладок зліва Ви можете натиснути на посилання <Заплановані сеанси>, де Ви здатні переглянути призначені за Вами та іншими спеціалістами призначення на сеанси!',
    href: '/account/appointments',
    hreftitle: 'Переглянути сеанси',
  },
  {
    title: 'Крок 3',
    subtitle: 'Пацієнти',
    description: 'В особистому кабінеті серед вкладок зліва оберіть посилання <Пацієнти>, де Ви зможете знайти список закріплених за Вами пацієнтів, з якими у Вас були створені сеанси. Тут Ви знайдете всю необхідну Вам інформацію щодо їхніх медичних даних, з якими ви можете ознайомитися в будь-яку мить!',
    href: '/account/patients',
    hreftitle: 'Переглянути пацієнтів',
  },
  {
    title: 'Крок 4',
    subtitle: 'Будьте на зв`язку!',
    description: 'Також серед важливих функцій варто відзначити можливість вести чати з іншими працівниками та/або пацієнтами! Швидко відшукайте необхідного користувача, ініціюйте діалог, та повідомте йому про важливу чи просто робочу інформацію! Також інші пацієнти можуть надіслати Вам запит на початок розмови - Ви маєте право прийняти його, чи відкликати.',
    href: '/account/chat',
    hreftitle: 'Перевірити повідомлення',
  },
]

const roadmap = [
  {
    title: 'Крок 1',
    subtitle: 'Зареєструйтеся',
    description: 'Спершу Вам необхідно зареєструватися в даній системі! Перейдіть за посиланням нижче, заповніть поля з Вашими прізвищем, ім`ям та поштою, після чого Ви потрапите до особистого кабінету!',
    href: '/signup',
    hreftitle: 'Зареєструватися',
  },
  {
    title: 'Крок 2',
    subtitle: 'Повідомте адміністратора',
    description: 'Коли Ви зареєструєтеся в даній системі, повідомте адміністратора про присвоєння Вам статусу працівника. Після цього Ви можете повноцінно працювати!',
    href: '/admin',
    hreftitle: 'Адміністратор',
  },
  {
    title: 'Крок 3',
    subtitle: 'Авторизуйтеся',
    description: 'Вже зареєстровані та маєте статус працівника? Чудово! Тоді ви на один крок менше до Вашого призначення! Перейдіть за посиланням нижче для подальшої авторизації в системі, після чого Ви опинитеся у вже знайомому Вам особистому кабінеті!',
    href: '/login',
    hreftitle: 'Авторизуватися',
  },
  {
    title: 'Крок 4',
    subtitle: 'Перевірте свої дані',
    description: 'На сторінці особистого кабінету перевірте свої персональні дані, а також скорегуйте свій розклад роботи!',
    href: '/account',
    hreftitle: 'Перейти до кабінету',
  },
  {
    title: 'Крок 5',
    subtitle: 'Заплановані сеанси',
    description: 'Після завершення реєстрації у особистому кабінеті, серед вкладок зліва Ви можете натиснути на посилання <Заплановані сеанси>, де Ви здатні переглянути призначені за Вами та іншими спеціалістами призначення на сеанси!',
    href: '/account/appointments',
    hreftitle: 'Переглянути сеанси',
  },
  {
    title: 'Крок 6',
    subtitle: 'Пацієнти',
    description: 'В особистому кабінеті серед вкладок зліва оберіть посилання <Пацієнти>, де Ви зможете знайти список закріплених за Вами пацієнтів, з якими у Вас були створені сеанси. Тут Ви знайдете всю необхідну Вам інформацію щодо їхніх медичних даних, з якими ви можете ознайомитися в будь-яку мить!',
    href: '/account/patients',
    hreftitle: 'Переглянути пацієнтів',
  },
  {
    title: 'Крок 7',
    subtitle: 'Будьте на зв`язку!',
    description: 'Також серед важливих функцій варто відзначити можливість вести чати з іншими працівниками та/або пацієнтами! Швидко відшукайте необхідного користувача, ініціюйте діалог, та повідомте йому про важливу чи просто робочу інформацію! Також інші пацієнти можуть надіслати Вам запит на початок розмови - Ви маєте право прийняти його, чи відкликати.',
    href: '/account/notifications',
    hreftitle: 'Перевірити повідомлення',
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
              Працівника
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