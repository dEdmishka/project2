<script setup>
import { Button } from "@/components/ui/button";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger,
  DropdownMenuSeparator,
} from "@/components/ui/dropdown-menu";
import { Bell } from "lucide-vue-next";
import { ref, computed } from "vue"
import { usePage, Link } from '@inertiajs/vue3'

const page = usePage()
const notifications = computed(() => page.props.auth.notifications)
const unreadCount = computed(() =>
  notifications.value.filter(n => n.status === 'pending').length
)
</script>

<template>
  <DropdownMenu>
    <DropdownMenuTrigger asChild>
      <Button variant="ghost" size="icon" class="ghost">
        <Bell class="absolute h-[1.1rem] w-[1.2rem]" />
        <span class="ml-6 mb-6 text-xs bg-red-500 text-white rounded-full px-1">
          {{ unreadCount ? unreadCount : '' }}
        </span>
        <span class="sr-only">Notification Menu</span>
      </Button>
    </DropdownMenuTrigger>

    <DropdownMenuContent class="w-80">
      <div class="p-2 font-bold">Notifications</div>
      <DropdownMenuSeparator />
      <template v-if="notifications.length">
        <DropdownMenuItem v-for="(n, index) in notifications" :key="n.id" class="flex flex-col items-start space-y-1">
          <span class="text-sm">{{ n.type }}</span>
          <span class="text-xs text-muted-foreground">{{ n.content }}</span>
          <span class="text-[10px] text-muted-foreground">{{ n.created_at }}</span>
        </DropdownMenuItem>
      </template>
      <div v-else class="p-2 text-sm text-muted-foreground">No notifications</div>
    </DropdownMenuContent>
  </DropdownMenu>
</template>