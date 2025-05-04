<script setup>
import Layout from "@/Layout/Dashboard/Index.vue";
// defineProps({ user: Object })

import { cn } from '@/lib/utils'
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'
import { Button } from '@/components/ui/button'
import { Label } from '@/components/ui/label'
import {
  Card,
  CardTitle,
  CardContent,
  CardFooter,
  CardHeader,
} from '@/components/ui/card'
import { Command, CommandEmpty, CommandGroup, CommandInput, CommandItem, CommandList } from '@/components/ui/command'

import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog'
import { Input } from '@/components/ui/input'
import {
  Tooltip,
  TooltipContent,
  TooltipProvider,
  TooltipTrigger,
} from '@/components/ui/tooltip'
import { Check, ChevronDown, Plus, Send, ArchiveX, File, Inbox, Trash2 } from 'lucide-vue-next'
import { computed, ref } from 'vue'
import Separator from "@/components/ui/separator/Separator.vue";
import {
  Sidebar,
  SidebarContent,
  SidebarFooter,
  SidebarGroup,
  SidebarGroupContent,
  SidebarHeader,
  SidebarInput,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
} from '@/components/ui/sidebar'

import {
  Popover,
  PopoverContent,
  PopoverTrigger,
} from '@/components/ui/popover'

const input = ref('')
const inputLength = computed(() => input.value.trim().length)
const navMain = ref([
  {
    title: 'Inbox',
    url: '#',
    icon: Inbox,
    isActive: true,
  },
  {
    title: 'Drafts',
    url: '#',
    icon: File,
    isActive: false,
  },
  {
    title: 'Sent',
    url: '#',
    icon: Send,
    isActive: false,
  },
  {
    title: 'Junk',
    url: '#',
    icon: ArchiveX,
    isActive: false,
  },
  {
    title: 'Trash',
    url: '#',
    icon: Trash2,
    isActive: false,
  },
])

// const users = ref([
//   { id: 1, first_name: 'Alice', last_name: 'Smith', email: 'alice@example.com', avatar: "avatar: 'https://th.bing.com/th/id/OIP.zTBrsC7B-MQrfIJLKTUo3QHaHa?w=185&h=185&c=7&r=0&o=5&pid=1.7'," },
//   { id: 2, first_name: 'Bob', last_name: 'Jones', email: 'bob@example.com', avatar: "avatar: 'https://th.bing.com/th/id/OIP.zTBrsC7B-MQrfIJLKTUo3QHaHa?w=185&h=185&c=7&r=0&o=5&pid=1.7'," },
//   { id: 3, first_name: 'Charlie', last_name: 'Brown', email: 'charlie@example.com', avatar: "avatar: 'https://th.bing.com/th/id/OIP.zTBrsC7B-MQrfIJLKTUo3QHaHa?w=185&h=185&c=7&r=0&o=5&pid=1.7'," },
// ])

const props = defineProps({
  main_url: String,
  users: Array,
})

// const search = ref('')
// const selectedUser = ref(null)

// const filteredUsers = computed(() => {
//   return users.value.filter(u =>
//     (u.first_name + ' ' + u.last_name).toLowerCase().includes(search.value.toLowerCase())
//   )
// })

// function selectUser(user) {
//   selectedUser.value = user
//   if (!messages.value[user.id]) {
//     messages.value[user.id] = []
//   }
// }

import { useForm } from '@inertiajs/vue3';

const form = useForm({
  user: '',
});

const errors = ref({});

const submit = () => {
  form.post(`${props.mainUrl}`, {
    onError: (error) => {
      errors.value = error;
    },
    onSuccess: (event) => {
      const data = event.props.data;
      const successMessage = event.props.flash.success;
      toast('Success!', {
        variant: 'default',
        duration: 3000,
        description: successMessage,
        action: {
          label: 'Got it',
          onClick: () => console.log('Undo'),
        },
      });

      emit('update', data);
      emit('close', false);
    }
  })
};

// const selectedUser = ref(null)
const selectedUsers = ref([])
const activeUser = ref(null)

const openUser = ref(false)
const searchUser = ref('')
const selectedUser = computed(() =>
  props.users.find((u) => u.id === form.user)
)
const filteredUsers = computed(() =>
  props.users.filter(
    (user) =>
      user.first_name.toLowerCase().includes(search.value.toLowerCase()) ||
      user.last_name.toLowerCase().includes(search.value.toLowerCase())
  )
)
function selectUser(user) {
  form.user = user.id
  if (!selectedUsers.value.find(u => u.id === user.id)) {
    selectedUsers.value.push(user)
  }
  selectedUser.value = user
  activeUser.value = user
  if (!messages.value[user.id]) {
    messages.value[user.id] = []
  }
  openUser.value = false
}

function setActiveChat(user) {
  activeUser.value = user
}

const chatMessages = computed(() =>
  activeUser.value ? messages.value[activeUser.value.id] || [] : []
)

// const message = ref('')
const messages = ref({}) // { userId: [{from, text}] }
// const chatMessages = computed(() => {
//   if (!selectedUser.value) return []
//   return messages.value[selectedUser.value.id] || []
// })

// function sendMessage() {
//   if (!message.value.trim() || !selectedUser.value) return
//   messages.value[selectedUser.value.id].push({
//     from: 'me',
//     text: message.value.trim(),
//   })
//   message.value = ''
// }

</script>

<template>
  <Layout>
    <div class="w-[calc(100dvw-325px)]">
      <h1 class="text-lg font-semibold md:text-2xl">
        Chat
      </h1>
      <Separator class="my-4" />
      <!-- Hiiiii our user {{ $page['props']['user'] }} -->
      <!-- <h1 class="text-blue-600 text-center p-5">Welcome</h1> -->

      <div class="grid grid-cols-12 items-center gap-12">
        <div class="col-span-3">
          <div class="content gap-0 p-0 outline-none">
            <div class="header pb-4 pt-5">
              <h1 class="text-lg font-semibold md:text-xl">
                New message
              </h1>
              <div class="desc">
                Invite a user to this thread. This will create a new group
                message.
              </div>
            </div>
            <div class="w-full border-r space-y-4 py-2">
              <Popover id="user" v-model:open="openUser">
                <PopoverTrigger as-child>
                  <Button variant="outline" role="combobox" class="w-full">
                    {{ selectedUser?.first_name || 'Select user...' }} {{ selectedUser?.last_name || ''
                    }}
                    <ChevronDown class="ml-2 h-4 w-4 shrink-0 opacity-50" />
                  </Button>
                </PopoverTrigger>
                <PopoverContent class="p-0 overflow-y-auto max-w-70">
                  <Command>
                    <CommandInput placeholder="Search users..." v-model="searchUser" />
                    <CommandEmpty>No users found.</CommandEmpty>
                    <CommandGroup>
                      <CommandItem v-for="user in filteredUsers" :key="user.id" :value="user.first_name"
                        @select="() => selectUser(user)">
                        {{ user.first_name }} {{ user.last_name }}
                        <Check class="ml-auto h-4 w-4"
                          :class="{ 'opacity-100': form.user === user.id, 'opacity-0': form.user !== user.id }" />
                      </CommandItem>
                    </CommandGroup>
                  </Command>
                </PopoverContent>
              </Popover>
            </div>

            <!-- SELECTED USER CARDS -->
            <div class="space-y-2">
              <Card v-for="user in selectedUsers" :key="user.id" class="cursor-pointer" :class="{
                'ring-2 ring-blue-500': activeUser?.id === user.id,
                'hover:ring-1 hover:ring-gray-300': activeUser?.id !== user.id
              }" @click="setActiveChat(user)">
                <CardHeader>
                  <CardTitle class="text-base">{{ user.first_name }} {{ user.last_name }}</CardTitle>
                </CardHeader>
                <CardContent class="text-sm text-gray-500">
                  {{ user.email }}
                </CardContent>
              </Card>
            </div>
          </div>

        </div>
        <div class="col-span-9">
          <Card>
            <CardHeader class="flex flex-row items-center justify-between">
              <div class="flex items-center space-x-4">
                <Avatar>
                  <AvatarImage src="/avatars/01.png" alt="Image" />
                  <AvatarFallback>OM</AvatarFallback>
                </Avatar>
                <div>
                  <p class="text-sm font-medium leading-none">
                    Sofia Davis
                    {{ activeUser?.first_name }} {{ activeUser?.last_name }}
                  </p>
                  <p class="text-sm text-muted-foreground">
                    m@example.com
                  </p>
                </div>
              </div>
              <TooltipProvider>
                <Tooltip :delay-duration="200">
                  <TooltipTrigger as-child>
                    <Button variant="outline" class="rounded-full p-2.5 flex items-center justify-center"
                      @click="open = true">
                      <Plus class="w-4 h-4" />
                    </Button>
                  </TooltipTrigger>
                  <TooltipContent :side-offset="10">
                    New message
                  </TooltipContent>
                </Tooltip>
              </TooltipProvider>
            </CardHeader>

            <!-- <div v-if="activeUser" class="border-t pt-4">
      <h2 class="font-medium mb-2">
        Chat with {{ activeUser.first_name }} {{ activeUser.last_name }}
      </h2>
      <div class="h-40 overflow-y-auto border rounded p-2 mb-2">
        <div
          v-for="(msg, i) in chatMessages"
          :key="i"
          :class="msg.from === 'me' ? 'text-right text-blue-600' : 'text-left text-gray-700'"
        >
          {{ msg.text }}
        </div>
      </div>
      <div class="flex gap-2">
        <Input v-model="message" placeholder="Type a message..." />
        <Button @click="sendMessage">Send</Button>
      </div>
    </div> -->
            <CardContent>
              <div class="space-y-4">
                <div v-for="(message, index) in messages" :key="index" :class="cn(
                  'flex w-max max-w-[75%] flex-col gap-2 rounded-lg px-3 py-2 text-sm',
                  message.role === 'user' ? 'ml-auto bg-primary text-primary-foreground' : 'bg-muted',
                )">
                  {{ message.text }}
                </div>
              </div>
            </CardContent>
            <CardFooter>
              <form class="flex w-full items-center space-x-2" @submit.prevent="() => {
                if (inputLength === 0) return
                messages.push({
                  role: 'user',
                  content: input,
                })
                input = ''
              }">
                <Input v-model="input" placeholder="Type a message..." class="flex-1" />
                <Button class="p-2.5 flex items-center justify-center" :disabled="inputLength === 0">
                  <Send class="w-4 h-4" />
                  <span class="sr-only">Send</span>
                </Button>
              </form>
            </CardFooter>
          </Card>
        </div>
      </div>

      <!-- <Dialog v-model:open="open">
        <DialogContent class="gap-0 p-0 outline-none">
          <DialogHeader class="px-4 pb-4 pt-5">
            <DialogTitle>New message</DialogTitle>
            <DialogDescription>
              Invite a user to this thread. This will create a new group
              message.
            </DialogDescription>
          </DialogHeader>
          <Command class="overflow-hidden rounded-t-none border-t">
            <CommandInput placeholder="Search user..." />
            <CommandList>
              <CommandEmpty>No users found.</CommandEmpty>
              <CommandGroup class="p-2">
                <CommandItem v-for="user in users" :key="user.email" :value="user" class="flex items-center px-2"
                  @select="() => {
                    const index = selectedUsers.findIndex(u => u === user)
                    if (index !== -1) {
                      selectedUsers.splice(index, 1)
                    }
                    else {
                      selectedUsers.push(user)
                    }
                  }">
                  <Avatar>
                    <AvatarImage :src="user.avatar" alt="Image" />
                    <AvatarFallback>{{ user.name[0] }}</AvatarFallback>
                  </Avatar>
                  <div class="ml-2">
                    <p class="text-sm font-medium leading-none">
                      {{ user.name }}
                    </p>
                    <p class="text-sm text-muted-foreground">
                      {{ user.email }}
                    </p>
                  </div>
                  <Check v-if="selectedUsers.includes(user)" class="ml-auto flex h-5 w-5 text-primary" />
                </CommandItem>
              </CommandGroup>
            </CommandList>
          </Command>
          <DialogFooter class="flex items-center border-t p-4 sm:justify-between">
            <div v-if="selectedUsers.length > 0" class="flex -space-x-2 overflow-hidden">
              <Avatar v-for="user in selectedUsers" :key="user.email" class="inline-block border-2 border-background">
                <AvatarImage :src="user.avatar" />
                <AvatarFallback>{{ user.name[0] }}</AvatarFallback>
              </Avatar>
            </div>

            <p v-else class="text-sm text-muted-foreground">
              Select users to add to this thread.
            </p>

            <Button :disabled="selectedUsers.length < 2" @click="open = false">
              Continue
            </Button>
          </DialogFooter>
        </DialogContent>
      </Dialog> -->

    </div>
  </Layout>
</template>
