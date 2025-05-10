<script setup>
import Layout from "@/Layout/Dashboard/Index.vue";
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { ref, computed } from 'vue'
import { Card, CardContent, CardTitle } from '@/components/ui/card'
import { Badge } from '@/components/ui/badge'
// import { ArrowUpDown, ChevronDown, ChevronsRight, ChevronsLeft } from 'lucide-vue-next'
import { formatDate, formatTime, hasElements } from "@/helper";
import { buttonVariants } from "@/components/ui/button/index";

const props = defineProps({
    user: Object,
    data: Array,
    types: Array,
    main_url: String,
})

const data = ref(props.data);
const types = ref(props.types);
const selectedTypeId = ref(null)

const selectType = (typeId) => {
    selectedTypeId.value = typeId
}

const selectedTypeName = computed(() => {
    if (!selectedTypeId.value) return 'All Notifications'
    const found = types.value.find(t => t.type === selectedTypeId.value)
    return found ? found.type : 'Notifications'
})

const filteredNotifications = computed(() => {
    return data.value
        .filter(n => !selectedTypeId.value || n.type === selectedTypeId.value)
        .sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
})

const groupedNotifications = computed(() => {
    const groups = {}
    // console.log(filteredNotifications.value)
    filteredNotifications.value.forEach(notification => {
        const date = formatDate(notification.created_at)
        if (!groups[date]) groups[date] = []
        groups[date].push(notification)
    })
    return groups
})
</script>

<template>
    <Layout>
        <template #title>
            Notifications
        </template>
        <div class="">
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-3">
                    <!-- Left: Types -->
                    <div class="content gap-0 p-0 outline-none space-y-2">
                        <h2 class="text-xl font-semibold mb-2">Notification Types</h2>
                        <Button
                            :class="`w-full justify-start ${buttonVariants({ variant: selectedTypeId === null ? 'secondary' : 'ghost' })} border p-5`"
                            @click="selectType(null)">
                            All Notifications
                        </Button>
                        <div v-for="type in types" :key="type.id">
                            <Button
                                :class="`w-full justify-start ${buttonVariants({ variant: selectedTypeId === type.type ? 'secondary' : 'ghost' })} border p-5`"
                                @click="selectType(type.type)">
                                {{ type.type }}
                            </Button>
                        </div>
                    </div>
                </div>
                <div class="col-span-9">
                    <!-- Right: Notifications -->
                    <div class="col-span-3 pl-4 space-y-6">
                        <h2 class="text-xl font-semibold mb-2">
                            {{ selectedTypeName }}
                        </h2>
                        <div v-if="hasElements(groupedNotifications)">
                            <div v-for="(notifications, date) in groupedNotifications" :key="date" class="space-y-2">
                                <h3 class="text-lg font-semibold">{{ date }}</h3>
                                <div class="space-y-2">
                                    <Card v-for="notification in notifications" :key="notification.id">
                                        <CardContent class="flex items-start gap-4 p-3">
                                            <Badge variant="secondary" class="min-w-[65px]">{{ notification.status }}</Badge>
                                            <div class="flex flex-col">
                                                <CardTitle>{{ notification.type }}</CardTitle>
                                                <p>{{ notification.content }}</p>
                                                <span class="text-xs text-muted-foreground">
                                                    {{ formatTime(notification.created_at) }}
                                                </span>
                                            </div>
                                        </CardContent>
                                    </Card>
                                </div>
                            </div>
                        </div>
                        <div v-else class="text-muted-foreground">No notifications found.</div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>