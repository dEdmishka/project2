<script setup>
import Layout from "@/Layout/Dashboard/Index.vue";
import { Head } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'

// defineProps({ user: Object })
</script>

<template>
  <Layout>

    <Head title="Account" />
    Hiiiii our user {{ $page['props']['user'] }}
    <h1 class="text-blue-600 text-center p-5">Welcome</h1>
    <h1 class="text-3xl font-bold underline">
      Hello world!
    </h1>
    <Button>Click Me</Button>
    <!-- <p>Hello {{ user.name }}, welcome to your first Inertia app!</p> -->
  </Layout>
</template>