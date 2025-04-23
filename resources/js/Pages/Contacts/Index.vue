<script setup>
import Layout from '@/Layout/App.vue'
import { Head } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
import Hero from '@/components/Hero.vue'
import About from '@/components/About.vue'
import HowItWorks from '@/components/HowItWorks.vue'
import FAQ from '@/components/FAQ.vue'
import Contacts from '@/components/Contacts.vue'

// defineProps({ user: Object })
</script>

<template>
  <Layout>
    <Contacts />
    <!-- <Head title="Welcome" />
    <h1 class="text-blue-600 text-center p-5">Welcome</h1>
    <h1 class="text-3xl font-bold underline">
      Hello world!
    </h1>
    <Button>Click Me</Button>
    <p>Hello {{ user.name }}, welcome to your first Inertia app!</p> -->
  </Layout>
</template>