<script setup>
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import {
    Medal,
    Map,
    Plane,
    Gift
} from 'lucide-vue-next'

const features = [
  {
    icon: Medal,
    title: "Accessibility",
    description:
      "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum quas provident cum",
  },
  {
    icon: Map,
    title: "Community",
    description:
      "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum quas provident cum",
  },
  {
    icon: Plane,
    title: "Scalability",
    description:
      "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum quas provident cum",
  },
  {
    icon: Gift,
    title: "Gamification",
    description:
      "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum quas provident cum",
  },
];
</script>

<template>
    <section
      id="howItWorks"
      class="text-center py-24 sm:py-32"
    >
      <h2 class="text-3xl md:text-4xl font-bold ">
        How It{{" "}}
        <span class="bg-gradient-to-b from-primary/60 to-primary text-transparent bg-clip-text">
          Works{{" "}}
        </span>
        Step-by-Step Guide
      </h2>
      <p class="md:w-3/4 mx-auto mt-4 mb-8 text-xl text-muted-foreground">
        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Veritatis
        dolor pariatur sit!
      </p>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          <Card
          v-for="(feature, index) in features"
            :key=feature.title
            class="bg-muted/50"
          >
            <CardHeader>
              <CardTitle class="grid gap-4 place-items-center">
                <component :is="feature.icon" />
                {{feature.title}}
              </CardTitle>
            </CardHeader>
            <CardContent>{{feature.description}}</CardContent>
          </Card>
      </div>
    </section>
</template>