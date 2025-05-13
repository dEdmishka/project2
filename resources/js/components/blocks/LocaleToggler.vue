<script setup>
import { router, usePage } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'
import { Button } from "@/components/ui/button";
import { Languages } from "lucide-vue-next";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu";

const { locale } = useI18n()
const switchLanguage = (lang) => {
  router.post('/locale', { locale: lang }, {
    preserveScroll: true,
    onSuccess: () => {
      locale.value = lang
    }
  })
}
</script>

<template>
  <DropdownMenu>
    <DropdownMenuTrigger asChild>
      <Button variant="ghost" size="icon" class="ghost">
        <Languages class="h-[1.1rem] w-[1.2rem]" />
        <span class="sr-only">Toggle locale</span>
      </Button>
    </DropdownMenuTrigger>
    <DropdownMenuContent align="end">
      <DropdownMenuItem @click="switchLanguage('ua')">
        Українська
      </DropdownMenuItem>
      <DropdownMenuItem @click="switchLanguage('en')">
        English
      </DropdownMenuItem>
    </DropdownMenuContent>
  </DropdownMenu>
</template>
