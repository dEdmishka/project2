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

const data = {
  navMain: [
    {
      title: "account.admin.office",
      url: "/admin",
      items: [
        // {
        //   title: "Home",
        //   url: "/admin",
        // },
        // {
        //   title: "Dashboard",
        //   url: "/admin/dashboard",
        // },
        {
          title: "account.admin.centers",
          url: "/admin/centers",
        },
        {
          title: "account.admin.procedures",
          url: "/admin/procedures",
        },
        {
          title: "account.admin.departments",
          url: "/admin/departments",
        },
        {
          title: "account.admin.appointments",
          url: "/admin/appointments",
        },
        {
          title: "account.admin.wards",
          url: "/admin/wards",
        },
      ],
    },
    {
      title: "account.admin.users",
      url: "/admin/patients",
      items: [
        {
          title: "account.admin.patients",
          url: "/admin/patients",
        },
        {
          title: "account.admin.staff",
          url: "/admin/staff",
        },
      ],
    },
    // {
    //   title: "Services",
    //   url: "#",
    //   items: [
    //     {
    //       title: "Records",
    //       url: "/admin/records",
    //     },
    //     {
    //       title: "Reports",
    //       url: "/admin/reports",
    //     },
    //     {
    //       title: "Posts",
    //       url: "/admin/posts",
    //     },
    //     {
    //       title: "Notifications",
    //       url: "/admin/notifications",
    //     },
    //     {
    //       title: "Documents",
    //       url: "/admin/documents",
    //     },
    //     {
    //       title: "Payments",
    //       url: "/admin/payments",
    //     },
    //   ],
    // },
  ],
}
</script>

<template>
  <Sidebar v-bind="props">
    <SidebarHeader>
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