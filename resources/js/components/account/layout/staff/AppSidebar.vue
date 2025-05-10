<script setup>
import SearchForm from "@/components/blocks/SearchForm.vue"
import {
  Sidebar,
  SidebarContent,
  SidebarGroup,
  SidebarHeader,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
  SidebarRail,
  SidebarMenuSub,
  SidebarMenuSubButton,
  SidebarMenuSubItem,
} from "@/components/ui/sidebar"
import { Link } from "@inertiajs/vue3"

const props = defineProps();

const data = {
  navMain: [
    {
      title: "Профіль",
      url: "/account",
      items: [
      {
          title: "Розклад",
          url: "/account/schedule",
        },
        {
          title: "Заплановані сеанси",
          url: "/account/appointments",
        },
        {
          title: "Пацієнти",
          url: "/account/patients",
        },
        {
          title: "Плани лікування",
          url: "/account/treatments",
        },
        {
          title: "Документи",
          url: "/account/documents",
        },
        {
          title: "Зарплата",
          url: "/account/billing",
        },
        {
          title: "Чати",
          url: "/account/chat",
        },
        {
          title: "Повідомлення",
          url: "/account/notifications",
        },
      ],
    },
  ],
}
</script>

<template>
  <Sidebar v-bind="props">
    <SidebarHeader class="pt-4">
      <SearchForm />
    </SidebarHeader>
    <SidebarContent class="text-xl text-gray-700 dark:text-gray-100">
      <SidebarGroup>
        <SidebarMenu>
          <SidebarMenuItem v-for="item in data.navMain" :key="item.title">
            <SidebarMenuButton as-child>
              <Link :href="item.url" class="font-medium">
                {{ item.title }}
              </Link>
            </SidebarMenuButton>
            <SidebarMenuSub v-if="item.items.length" class="gap-4">
              <SidebarMenuSubItem v-for="childItem in item.items" :key="childItem.title">
                <SidebarMenuSubButton as-child :is-active="$page.url === childItem.url">
                  <Link :href="childItem.url">{{ childItem.title }}</Link>
                </SidebarMenuSubButton>
              </SidebarMenuSubItem>
            </SidebarMenuSub>
          </SidebarMenuItem>
        </SidebarMenu>
      </SidebarGroup>
    </SidebarContent>
    <SidebarRail />
  </Sidebar>
</template>