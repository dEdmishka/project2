<script setup>
import SearchForm from "@/components/blocks/SearchForm.vue"
import VersionSwitcher from "@/components/blocks/VersionSwitcher.vue"
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

// This is sample data.
const props = defineProps();

const data = {
  navMain: [
    {
      title: "account.sidebar.profile",
      url: "/account",
      items: [
        {
          title: "account.sidebar.medcard",
          url: "/account/medcard",
        },
        {
          title: "account.sidebar.procedures",
          url: "/account/procedures",
        },
        {
          title: "account.sidebar.appointments",
          url: "/account/appointments",
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
        //   title: "account.sidebar.diagnosis",
        //   url: "/account/diagnosis",
        // },
        // {
        //   title: "account.sidebar.treatments",
        //   url: "/account/treatments",
        // },
        // {
        //   title: "account.sidebar.documents",
        //   url: "/account/documents",
        // },
        // {
        //   title: "account.sidebar.billing",
        //   url: "/account/billing",
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