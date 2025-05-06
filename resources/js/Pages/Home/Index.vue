<script setup>
import Layout from '@/Layout/App.vue'
import Hero from '@/components/blocks/Hero.vue'
import About from '@/components/blocks/About.vue'
import HowItWorks from '@/components/blocks/HowItWorks.vue'
import FAQ from '@/components/blocks/FAQ.vue'
import Opportunities from '@/components/blocks/Opportunities.vue'
import News from '@/components/blocks/News.vue'
</script>

<template>
  <Layout>
    <Hero />
    <Opportunities />
    <About />
    <HowItWorks />
    <FAQ />
    <News />
  </Layout>
</template>