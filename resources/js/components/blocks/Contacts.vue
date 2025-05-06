<script setup>
import { Link } from "@inertiajs/vue3"
import { buttonVariants } from "@/components/ui/button";
import {
    Send,
    Github
} from 'lucide-vue-next'
import ContactForm from "./ContactForm.vue";
</script>

<template>
    <section class="grid lg:grid-cols-2 place-items-center py-20 md:py-40 gap-10 px-4">
        <div class="text-center lg:text-start space-y-6">
            <div class="text-5xl md:text-6xl font-bold">
                <h1 class="inline">
                    <span class="inline bg-gradient-to-r from-[#F596D3]  to-[#D247BF] text-transparent bg-clip-text">
                        Contact
                    </span>
                </h1>
                <h2 class="inline">
                    <span
                        class="inline bg-gradient-to-r from-[#61DAFB] via-[#1fc0f1] to-[#03a3d7] text-transparent bg-clip-text">
                        Us
                    </span>
                </h2>
            </div>

            <p class="text-xl text-muted-foreground md:w-10/12 mx-auto lg:mx-0">
                Зверніться до нас у будь-який момент!
                <br />
                Вкажіть тему Вашого звернення та зміст у формі, або напишіть нам в особисті!
            </p>

            <div class="space-y-6 md:space-y-0 md:space-x-4">
                <Link rel="noreferrer noopener" href="https://github.com/dEdmishka" target="_blank"
                    :class="`w-full md:w-1/3 ${buttonVariants({ variant: 'outline' })}`">
                Github Repository
                <Github class="ml-2 w-5 h-5" />
                </Link>
                <Link rel="noreferrer noopener" href="https://t.me/mishka10101" target="_blank"
                    :class="`w-full md:w-1/3 ${buttonVariants({ variant: 'outline' })}`">
                Telegram
                <Send class="ml-2 w-5 h-5" />
                </Link>
            </div>
        </div>
        <ContactForm />
    </section>
</template>