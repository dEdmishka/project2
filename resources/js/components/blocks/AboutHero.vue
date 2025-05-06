<script setup>
import { Link } from "@inertiajs/vue3"
import { buttonVariants } from "@/components/ui/button";
</script>

<template>
  <section class="grid lg:grid-cols-2 place-items-center py-20 md:py-40 gap-10 px-4">
    <div class="text-center lg:text-start space-y-6">
      <div class="text-5xl md:text-6xl font-bold">
        <h1 class="inline">
          <span class="inline bg-gradient-to-r from-[#F596D3]  to-[#D247BF] text-transparent bg-clip-text">
            About
          </span>
        </h1>
        <h2 class="inline">
          <span class="inline bg-gradient-to-r from-[#61DAFB] via-[#1fc0f1] to-[#03a3d7] text-transparent bg-clip-text">
            Us
          </span>
        </h2>
      </div>

      <p class="text-xl text-muted-foreground mx-auto lg:mx-0">
        <!-- Build your React landing page effortlessly with the required sections
          to your project. -->
        Ми відкрились відносно недавно, але вже готові Вам презентувати перші здобутки у даній сфері!
        <br />
        Наше завдання - надати Вам всі можливості у відновленні Вашого здоров`я!
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
  </section>
</template>