<script setup>
import Layout from "@/Layout/Dashboard/Index.vue";
import { Button } from '@/components/ui/button'
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import { FileText, Download, Plus } from 'lucide-vue-next'
import { ref } from 'vue'

import CreateDialog from '@/Pages/Account/Staff/Intake/CreateDialog.vue';

const props = defineProps({
    user: Object,
    data: Object,
    main_url: String,
})

const data = ref(props.data);

const createDialog = ref(false);

const showCreateDialog = () => {
    createDialog.value = true;
};

const closeCreateDialog = () => {
    createDialog.value = false;
};

const updateData = (newData) => {
    data.value = newData;
}
</script>

<template>
    <Layout>
        <template #title>
            Вступна інформація
        </template>
        <div>
            <Button class="" variant="outline" @click="showCreateDialog">
                <Plus class="h-5"></Plus>
                Внести нові дані
            </Button>
        </div>

        <div class="grid py-6 space-y-6">
            <h1 class="text-2xl font-bold">Intake summary for {{ data.user.first_name }} {{ data.user.last_name }}</h1>
            <Card v-if="data?.records[0]?.documents">
                <CardHeader>
                    <CardTitle>Intake summary Record</CardTitle>
                </CardHeader>
                <CardContent>
                    <p class="text-gray-700 mb-4">{{ data.records[0].content }}</p>
                    <div v-if="data.records[0].documents.length" class="space-y-4">
                        <div v-for="doc in data.records[0].documents" :key="doc.id"
                            class="flex items-center justify-between border p-3 rounded-xl">
                            <div class="flex items-center space-x-3">
                                <FileText class="text-blue-500" />
                                <span>{{ doc.file_name }}</span>
                            </div>
                            <a :href="`/storage/${doc.file_path}`"
                                class="text-blue-600 hover:underline flex items-center">
                                <Download class="w-4 h-4 mr-1" /> View / Download
                            </a>
                        </div>
                    </div>
                    <p v-else class="text-gray-500">No documents uploaded yet.</p>
                </CardContent>
            </Card>
            <p v-else class="text-gray-500">No intake summary record found for this patient.</p>
        </div>

        <CreateDialog @update="updateData" :patient="data" @close="closeCreateDialog" v-model:open="createDialog"
            :mainUrl="$page.props.main_url" />
    </Layout>
</template>