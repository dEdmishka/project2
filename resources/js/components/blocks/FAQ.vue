<script setup>
import {
    Accordion,
    AccordionContent,
    AccordionItem,
    AccordionTrigger,
} from "@/components/ui/accordion";

import { motion } from 'motion-v'

const FAQList = [
    {
        question: "Lorem ipsum dolor sit amet consectetur adipisicing elit?",
        answer:
            "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sint labore quidem quam? Consectetur sapiente iste rerum reiciendis animi nihil nostrum sit quo, modi quod.",
        value: "item-1",
    },
    {
        question:
            "Lorem ipsum dolor sit amet  Consectetur natus dolores minus quibusdam?",
        answer:
            "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Labore qui nostrum reiciendis veritatis necessitatibus maxime quis ipsa vitae cumque quo?",
        value: "item-2",
    },
    {
        question: "Lorem ipsum dolor sit amet, consectetur adipisicing elit?",
        answer: "Lorem ipsum dolor sit amet consectetur, adipisicing elit.",
        value: "item-3",
    },
    {
        question:
            "Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur natus?",
        answer:
            "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sint labore quidem quam? Consectetur sapiente iste rerum reiciendis animi nihil nostrum sit quo, modi quod.",
        value: "item-4",
    },
    {
        question:
            "Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur natus?",
        answer:
            "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sint labore quidem quam? Consectetur sapiente iste rerum reiciendis animi nihil nostrum sit quo, modi quod.",
        value: "item-5",
    },
];
</script>

<template>
    <motion.section id="faq" class="py-24 sm:py-32" initial="hidden" whileInView="visible" :viewport="{ once: true }"
        :variants="{
            visible: { opacity: 1, y: 0 },
            hidden: { opacity: 0, y: 100 }
        }" :transition="{
            type: 'spring',
            duration: 3,
            delay: 0.05
        }">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">
            {{ $t('pages.freq_asked') }}{{ " " }}
            <span class="bg-gradient-to-b from-primary/60 to-primary text-transparent bg-clip-text">
                {{ $t('pages.questions') }}
            </span>
        </h2>

        <Accordion type="single" collapsible class="w-full max-w-[508px] AccordionRoot">
            <AccordionItem v-for="(item, index) in FAQList" :key="item.value" :value="item.value">
                <AccordionTrigger class="text-left">
                    {{ item.question }}
                </AccordionTrigger>
                <AccordionContent>{{ item.answer }}</AccordionContent>
            </AccordionItem>
        </Accordion>

        <h3 class="font-medium mt-4">
            {{ $t('pages.have_questions') }}{{ " " }}
            <a rel="noreferrer noopener" href="#" class="text-primary transition-all border-primary hover:border-b-2">
                {{ $t('pages.contact') }} {{ $t('pages.with_us') }}
            </a>
        </h3>
    </motion.section>
</template>