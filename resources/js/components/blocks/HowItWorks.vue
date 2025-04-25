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
      "Simple communication between patients and healthcare professionals",
  },
  {
    icon: Map,
    title: "Community",
    description:
      "Data-driven insights to improve patient outcomes and satisfaction",
  },
  {
    icon: Plane,
    title: "Scalability",
    description:
      "Rehabilitation programs tailored to individual needs and preferences",
  },
  {
    icon: Gift,
    title: "Gamification",
    description:
      "Secure and private platform for patient data and communication",
  },
];
</script>

<template>
    <section
      id="howItWorks"
      class="text-center py-12 sm:py-16"
    >
      <h2 class="text-3xl md:text-4xl font-bold ">
        Benefits{{" "}}
        <span class="bg-gradient-to-b from-primary/60 to-primary text-transparent bg-clip-text">
          Of Our{{" "}}
        </span>
        Platform
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