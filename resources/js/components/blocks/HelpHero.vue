<script setup>
import { Link } from "@inertiajs/vue3"
import FAQ from '@/components/blocks/FAQ.vue'
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import {
  CircleUserRound,
  ShieldUser,
  BookHeart,
  Building2,
} from 'lucide-vue-next'

const features = [
  {
    icon: CircleUserRound,
    title: "New patient",
    description:
      "Roadmap for patient",
    href: "/roadmap/patient",
  },
  {
    icon: BookHeart,
    title: "New employee",
    description:
      "Roadmap for employee",
    href: "/roadmap/employee",
  },
  {
    icon: ShieldUser,
    title: "New administrator",
    description:
      "Roadmap for administrator",
    href: "/roadmap/administrator",
  },
  {
    icon: Building2,
    title: "New center",
    description:
      "Roadmap for center",
    href: "/roadmap/center",
  },
];
</script>

<template>
  <section class="grid lg:grid-cols-2 place-items-center py-20 gap-10 px-4">
    <div class="text-center lg:text-start space-y-6">
      <div class="text-5xl md:text-6xl font-bold">
        <h1 class="inline">
          <span class="inline bg-gradient-to-r from-[#F596D3]  to-[#D247BF] text-transparent bg-clip-text">
            Help
          </span>
        </h1>
        <h2 class="inline">
          <span class="inline bg-gradient-to-r from-[#61DAFB] via-[#1fc0f1] to-[#03a3d7] text-transparent bg-clip-text">
            Page
          </span>
        </h2>
      </div>

      <p class="text-xl text-muted-foreground md:w-10/12 mx-auto lg:mx-0">
        Вам необхідна допомога? Тоді Ви на правильному шляху!
        <br />
        Оберіть інструкцію користувача та обов'язково перегляньте секцію FaQ!
      </p>

      <div class="text-2sm sm:text-1xl font-bold text-center">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
          <Card v-for="(feature, index) in features" :key=feature.title class="bg-muted/50">
            <Link :href="feature.href">
            <CardHeader>
              <CardTitle class="grid gap-2 place-items-center">
                <component :is="feature.icon" />
                {{ feature.title }}
              </CardTitle>
            </CardHeader>
            <CardContent>{{ feature.description }}</CardContent>
            </Link>
          </Card>
        </div>
      </div>
    </div>
    <FAQ />
  </section>
</template>