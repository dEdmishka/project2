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
          title: "account.sidebar.appointments",
          url: "/account/appointments",
        },
        {
          title: "account.sidebar.patients",
          url: "/account/patients",
        },
        {
          title: "account.sidebar.chat",
          url: "/account/chat",
        },
        {
          title: "account.sidebar.notifications",
          url: "/account/notifications",
        },
        // {
        //   title: "account.sidebar.schedule",
        //   url: "/account/schedule",
        // },
        // {
        //   title: "account.sidebar.billing",
        //   url: "/account/billing",
        // },
        // {
        //   title: "account.sidebar.treatments",
        //   url: "/account/treatments",
        // },
        // {
        //   title: "account.sidebar.documents",
        //   url: "/account/documents",
        // },
      ],
    },
  ],
}
</script>

<template>
  <Sidebar v-bind="props">
    <SidebarHeader class="pt-4">
      <!-- <SearchForm /> -->
    </SidebarHeader>
    <SidebarContent class="text-xl text-gray-700 dark:text-gray-100">
      <SidebarGroup>
        <SidebarMenu>
          <SidebarMenuItem v-for="item in data.navMain" :key="item.title">
            <SidebarMenuButton as-child>
              <Link :href="item.url" class="font-medium">
              {{ $t(item.title) }}
              </Link>
            </SidebarMenuButton>
            <SidebarMenuSub v-if="item.items.length" class="gap-4">
              <SidebarMenuSubItem v-for="childItem in item.items" :key="childItem.title">
                <SidebarMenuSubButton as-child :is-active="$page.url === childItem.url">
                  <Link :href="childItem.url">{{ $t(childItem.title) }}</Link>
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