<script setup>
import {
    Card,
    CardHeader,
    CardTitle,
    CardDescription,
    CardContent,
} from '@/components/ui/card'
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select'
import { ref, computed } from 'vue'

const centers = [
    {
        id: '1',
        name: 'Downtown Rehab Center',
        address: '123 Main Street, Cityville',
        lat: 40.7128,
        lng: -74.0060,
        workTime: 'Mon–Fri: 9am – 6pm',
        phone: '+1 234 567 890',
        email: 'downtown@rehab.org',
        socials: {
            Facebook: 'https://facebook.com/downtownrehab',
            Instagram: 'https://instagram.com/downtownrehab',
        },
    },
    {
        id: '2',
        name: 'Lakeside Health Center',
        address: '456 Lake Road, Townsville',
        lat: 40.7128,
        lng: -74.0060,
        workTime: 'Mon–Sat: 8am – 5pm',
        phone: '+1 345 678 901',
        email: 'lakeside@health.org',
        socials: {
            Twitter: 'https://twitter.com/lakesidehealth',
            LinkedIn: 'https://linkedin.com/company/lakesidehealth',
        },
    },
]

const selectedCenterId = ref(centers[0].id)

const selectedCenter = computed(() =>
    centers.find((center) => center.id === selectedCenterId.value)
)
</script>

<template>
    <div class="grid grid-cols-2 gap-4 ">
        <div class="grid max-w-3xl p-6 space-y-6">
            <p class="font-bold text-4xl md:text-5xl">Select a Center</p>
            <Select v-model="selectedCenterId">
                <SelectTrigger class="w-full">
                    <SelectValue placeholder="Choose a center" />
                </SelectTrigger>
                <SelectContent>
                    <SelectItem v-for="center in centers" :key="center.id" :value="center.id">
                        {{ center.name }}
                    </SelectItem>
                </SelectContent>
            </Select>
            <p class="font-bold text-4xl md:text-5xl">Center Contacts</p>

            <Card v-if="selectedCenter" class="font-bold text-2xl md:text-3xl text-neutral-600">
                <CardHeader>
                    <CardTitle>{{ selectedCenter.name }}</CardTitle>
                    <CardDescription>Contact Information</CardDescription>
                </CardHeader>
                <CardContent class="space-y-16">
                    <div><strong>Address:</strong> {{ selectedCenter.address }}</div>
                    <div><strong>Working Hours:</strong> {{ selectedCenter.workTime }}</div>
                    <div><strong>Phone:</strong> {{ selectedCenter.phone }}</div>
                    <div><strong>Email:</strong> {{ selectedCenter.email }}</div>
                    <div v-if="selectedCenter.socials">
                        <strong>Social Networks:</strong>
                        <div class="flex gap-4 mt-1">
                            <a v-for="(url, platform) in selectedCenter.socials" :key="platform" :href="url"
                                target="_blank" rel="noopener" class="underline text-blue-600 hover:text-blue-800">
                                {{ platform }}
                            </a>
                        </div>
                    </div>
                </CardContent>
            </Card>
        </div>
        <div class="grid max-w-2xl p-6 space-y-6">
            <div class="rounded-lg overflow-hidden shadow">
                <iframe v-if="selectedCenter"
                    :src="`https://www.google.com/maps?q=${encodeURIComponent(selectedCenter.address)}&output=embed`"
                    width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade" />
            </div>
        </div>
    </div>
    <div><p class="font-bold text-4xl md:text-5xl">Написати нам</p></div>
</template>