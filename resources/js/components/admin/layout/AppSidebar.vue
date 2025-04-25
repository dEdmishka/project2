<script setup>
import SearchForm from "@/components/blocks/SearchForm.vue"
import VersionSwitcher from "@/components/blocks/VersionSwitcher.vue"
import {
  Sidebar,
  SidebarContent,
  SidebarGroup,
  SidebarGroupContent,
  SidebarGroupLabel,
  SidebarHeader,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
  SidebarRail,
} from "@/components/ui/sidebar"
import { Link } from "@inertiajs/vue3"

// This is sample data.
const props = defineProps();

const data = {
  centers: ["MedicineCenter", "RehabCenter", "SomeOtherCenter"],
  navMain: [
    {
      title: "Getting Started",
      url: "#",
      items: [
        {
          title: "Home",
          url: "/admin",
        },
        {
          title: "Dashboard",
          url: "/admin/dashboard",
          // isActive: true,
        },
        {
          title: "Procedures",
          url: "/admin/procedures",
        },
      ],
    },
    {
      title: "Building Your Application",
      url: "#",
      items: [
        {
          title: "Routing",
          url: "#",
        },
      ],
    },
    {
      title: "API Reference",
      url: "#",
      items: [
        {
          title: "Components",
          url: "#",
        },
        {
          title: "File Conventions",
          url: "#",
        },
      ],
    },
  ],
}
</script>

<template>
  <Sidebar v-bind="props">
    <SidebarHeader>
      <VersionSwitcher :versions="data.centers" :default-version="data.centers[0]" />
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