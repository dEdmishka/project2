<script setup>
import { Link } from "@inertiajs/vue3"
import { buttonVariants } from "@/components/ui/button";
import {
  Menu,
  Github
} from 'lucide-vue-next'
import { Button } from "@/components/ui/button";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import {
  Medal,
  Map,
  Plane,
  Gift,
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
  <section class="grid lg:grid-cols-2 place-items-center py-20 md:py-40 gap-10 px-4">
    <div class="text-center lg:text-start space-y-6">
      <div class="text-5xl md:text-6xl font-bold">
        <h1 class="inline">
          <span class="inline bg-gradient-to-r from-[#F596D3]  to-[#D247BF] text-transparent bg-clip-text">
            Rehabilitation
          </span>
          <br />
          <!-- {{" "}}
            landing page -->
        </h1>
        <!-- {{" "}}
          for{{" "}} -->
        <h2 class="inline">
          <span class="inline bg-gradient-to-r from-[#61DAFB] via-[#1fc0f1] to-[#03a3d7] text-transparent bg-clip-text">
            System
          </span>
          <!-- {{" "}}
            developers -->
        </h2>
      </div>

      <p class="text-xl text-muted-foreground md:w-10/12 mx-auto lg:mx-0">
        <!-- Build your React landing page effortlessly with the required sections
          to your project. -->
        This is a simple landing page template built with Vue 3 and Tailwind CSS.
      </p>

      <div class="space-y-6 md:space-y-0 md:space-x-4">
        <Link href="/signup" :class="`w-full md:w-1/3 ${buttonVariants({ variant: 'default' })}`">Signup</Link>

        <Link href="/login" :class="`w-full md:w-1/3 ${buttonVariants({ variant: 'outline' })}`">Login</Link>
        <!-- <Link
            rel="noreferrer noopener"
            href="https://github.com/leoMirandaa/shadcn-landing-page.git"
            target="_blank"
            :class="`w-full md:w-1/3 ${buttonVariants({variant: 'outline'})}`"
          >
            Github Repository
            <Github class="ml-2 w-5 h-5" />
          </Link> -->
      </div>

      <div class="space-y-4 md:space-y-0 md:space-x-4 md:px-4">
        <Link href="/contacts" :class="`w-full md:w-2/3 ${buttonVariants({ variant: 'outline' })}`">Our contacts</Link>
      </div>
    </div>

    <div class="text-center space-y-6">
      <div class="text-2xl md:text-3xl font-bold">
        <h6>New to the system? Choose your guideline!</h6>
      </div>
      <div class="text-2sm sm:text-1xl font-bold">
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
    <!-- {/* Hero cards sections */}
      <div class="z-10">
        <HeroCards />
      </div> -->

    <!-- {/* Shadow effect */} -->
    <!-- <div class="shadow"></div> -->
  </section>
</template>