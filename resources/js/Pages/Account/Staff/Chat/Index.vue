<script setup>
import Layout from "@/Layout/Dashboard/Index.vue";
// defineProps({ user: Object })

import { cn } from '@/lib/utils'
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'
import { Button } from '@/components/ui/button'

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
  Popover,
  PopoverContent,
  PopoverTrigger,
} from '@/components/ui/popover'

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

const props = defineProps({
  main_url: String,
  users: Array,
})

import { useForm } from '@inertiajs/vue3';

const form = useForm({
  user: '',
});

const errors = ref({});

const submit = () => {
  if (!message.value.trim() || !activeUser.value) return
  messages.value[activeUser.value.id].push({
    from: 'me',
    text: message.value.trim()
  })
  message.value = ''
  // form.post(`${props.mainUrl}`, {
  //   onError: (error) => {
  //     errors.value = error;
  //   },
  //   onSuccess: (event) => {
  //     const data = event.props.data;
  //     const successMessage = event.props.flash.success;
  //     toast('account.toast.success', {
  //       variant: 'default',
  //       duration: 3000,
  //       description: successMessage,
  //       action: {
  //         label: 'Got it',
  //         onClick: () => console.log('Undo'),
  //       },
  //     });

  //     emit('update', data);
  //     emit('close', false);
  //   }
  // })
};

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
  activeUser.value = user
  if (!selectedUsers.value.find(u => u.id === user.id)) {
    selectedUsers.value.push(user)
  }
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

const message = ref('')
const messageLength = computed(() => message.value.trim().length)
const messages = ref({})
</script>

<template>
  <Layout>
    <template #title>
      {{ $t('account.admin.chat') }}
    </template>
    <div class="">
      <!-- Hiiiii our user {{ $page['props']['user'] }} -->
      <!-- <h1 class="text-blue-600 text-center p-5">Welcome</h1> -->

      <div class="grid grid-cols-12 gap-12">
        <div class="col-span-3">
          <div class="content gap-0 p-0 outline-none">
            <div class="header pb-4 pt-5">
              <h1 class="text-lg font-semibold md:text-xl">
                {{ $t('pages.new_message') }}
              </h1>
              <div class="desc">
                {{ $t('pages.invite_user') }}
              </div>
            </div>
            <div class="w-full border-r space-y-4 py-2">
              <Popover id="user" v-model:open="openUser">
                <PopoverTrigger as-child>
                  <Button variant="outline" role="combobox" class="w-full">
                    <Avatar>
                      <AvatarImage :src="`http://127.0.0.1:8000/${selectedUser?.image.url}`"
                        :alt="selectedUser?.first_name + ' ' + selectedUser?.last_name" />
                      <AvatarFallback>
                        <div class="bg-muted/50 border rounded-lg"></div>
                      </AvatarFallback>
                    </Avatar>
                    {{ selectedUser?.first_name || 'Select user...' }} {{ selectedUser?.last_name || ''
                    }}
                    <ChevronDown class="ml-2 h-4 w-4 shrink-0 opacity-50" />
                  </Button>
                </PopoverTrigger>
                <PopoverContent class="p-0 overflow-y-auto max-w-70">
                  <Command>
                    <CommandInput placeholder="Search users..." v-model="searchUser" />
                    <CommandEmpty>{{ $t('pages.no_users') }}</CommandEmpty>
                    <CommandGroup>
                      <CommandItem v-for="user in filteredUsers" :key="user.id" :value="user.first_name"
                        @select="() => selectUser(user)">
                        <Avatar>
                          <AvatarImage :src="`http://127.0.0.1:8000/${user?.image.url}`"
                            :alt="user.first_name + ' ' + user.last_name" />
                          <AvatarFallback>
                            <div class="bg-muted/50 border rounded-lg">User</div>
                          </AvatarFallback>
                        </Avatar>
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
            <div class="space-y-2 max-h-[500px] overflow-hidden overflow-y-auto p-2">
              <Card v-for="user in selectedUsers" :key="user.id" class="cursor-pointer" :class="{
                'ring-2 ring-blue-500': activeUser?.id === user.id,
                'hover:ring-1 hover:ring-gray-300': activeUser?.id !== user.id
              }" @click="setActiveChat(user)">
                <CardHeader>
                  <CardTitle class="text-base flex items-center md:gap-4">
                    <Avatar>
                      <AvatarImage :src="`http://127.0.0.1:8000/${user?.image.url}`"
                        :alt="user?.first_name + ' ' + user?.last_name" />
                      <AvatarFallback>
                        <div class="bg-muted/50 border rounded-lg">User</div>
                      </AvatarFallback>
                    </Avatar>
                    {{ user.first_name }} {{ user.last_name }}
                  </CardTitle>
                </CardHeader>
                <CardContent class="text-sm text-gray-500">
                  {{ user.email }}
                </CardContent>
              </Card>
            </div>
          </div>

        </div>
        <div class="col-span-9">
          <div v-if="!activeUser" class="flex flex-col gap-4 p-4 pt-0">
            <div class="grid auto-rows-min gap-4">
              <div class="aspect-video rounded-xl bg-muted/50" />
            </div>
          </div>

          <Card v-else>
            <CardHeader class="flex flex-row items-center justify-between">
              <div class="flex items-center justify-between space-x-4">
                <Avatar>
                  <AvatarImage :src="`http://127.0.0.1:8000/${activeUser?.image.url}`"
                    :alt="activeUser?.first_name + ' ' + activeUser?.last_name" />
                  <AvatarFallback>
                    <div class="bg-muted/50 border rounded-lg">User</div>
                  </AvatarFallback>
                </Avatar>
                <div>
                  <p class="text-sm font-medium leading-none">
                    {{ activeUser?.first_name }} {{ activeUser?.last_name }}
                  </p>
                  <p class="text-sm text-muted-foreground">
                    {{ activeUser?.email }}
                  </p>
                </div>
              </div>
            </CardHeader>

            <CardContent class="min-h-[300px] max-h-[500px] flex flex-col overflow-hidden overflow-y-auto">
              <div class="space-y-4">
                <div v-for="(message, index) in chatMessages" :key="index" :class="cn(
                  'flex w-max max-w-[75%] flex-col gap-2 rounded-lg px-3 py-2 text-sm',
                  message.from === 'me' ? 'ml-auto bg-primary text-primary-foreground' : 'bg-muted',
                )">
                  {{ message.text }}
                </div>
              </div>
            </CardContent>

            <CardFooter>
              <form class="flex w-full items-center space-x-2" @submit.prevent="submit">
                <Input v-model="message" placeholder="Type a message..." class="flex-1" />
                <Button class="p-2.5 flex items-center justify-center" :disabled="messageLength === 0">
                  <Send class="w-4 h-4" />
                  <span class="sr-only">Send</span>
                </Button>
              </form>
            </CardFooter>
          </Card>
        </div>
      </div>
    </div>
  </Layout>
</template>
