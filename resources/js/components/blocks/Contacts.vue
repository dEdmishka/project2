<script setup>
import { Link } from "@inertiajs/vue3"
import { buttonVariants } from "@/components/ui/button";
import {
    Send,
    Github
} from 'lucide-vue-next'
import ContactForm from "./ContactForm.vue";

import { motion } from 'motion-v'
</script>

<template>
    <section class="grid lg:grid-cols-2 place-items-center py-20 md:py-40 gap-10 px-4">
        <div class="text-center lg:text-start space-y-6">
            <motion.div class="text-5xl md:text-6xl font-bold" :animate="{
                opacity: [0, 1],
                y: [10, 0],
                transition: {
                    type: 'spring',
                    duration: 2,
                    delay: 0.05
                }
            }">
                <h1 class="inline">
                    <span class="inline bg-gradient-to-r from-[#F596D3]  to-[#D247BF] text-transparent bg-clip-text">
                        {{ $t('pages.contact') }}
                    </span>
                </h1>
                {{ "" }}
                <h2 class="inline">
                    <span
                        class="inline bg-gradient-to-r from-[#61DAFB] via-[#1fc0f1] to-[#03a3d7] text-transparent bg-clip-text">
                        {{ $t('pages.with_us') }}
                    </span>
                </h2>
            </motion.div>

            <motion.p class="text-xl text-muted-foreground md:w-10/12 mx-auto lg:mx-0" :animate="{
                opacity: [0, 1],
                x: [100, 0],
                transition: {
                    type: 'spring',
                    duration: 2,
                    delay: 0.05
                }
            }">
                {{ $t('pages.contact_us_p1') }}
                <br />
                {{ $t('pages.contact_us_p2') }}
            </motion.p>

            <motion.div class="space-y-6 md:space-y-0 md:space-x-4" :animate="{
                opacity: [0, 1],
                x: [-100, 0],
                transition: {
                    type: 'spring',
                    duration: 2,
                    delay: 0.3
                }
            }">
                <Link rel="noreferrer noopener" href="https://github.com/dEdmishka" target="_blank"
                    :class="`w-full md:w-1/3 ${buttonVariants({ variant: 'outline' })}`">
                {{ $t('pages.github') }}
                <Github class="ml-2 w-5 h-5" />
                </Link>
                <Link rel="noreferrer noopener" href="https://t.me/mishka10101" target="_blank"
                    :class="`w-full md:w-1/3 ${buttonVariants({ variant: 'outline' })}`">
                {{ $t('pages.telegram') }}
                <Send class="ml-2 w-5 h-5" />
                </Link>
            </motion.div>
        </div>
        <ContactForm />
    </section>
</template>