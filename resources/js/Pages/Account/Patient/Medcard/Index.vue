<script setup>
import Layout from "@/Layout/Dashboard/Index.vue";
import { Button } from '@/components/ui/button'
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import { FileText, Download, Plus } from 'lucide-vue-next'
import { ref, computed } from 'vue'

import CreateDialog from '@/Pages/Account/Patient/Procedure/CreateDialog.vue';

import { toast } from 'vue-sonner';
import { useForm } from '@inertiajs/vue3';
import { motion } from 'motion-v'
import FileUploader from "@/components/blocks/FileUploader.vue";

const props = defineProps({
    user: Object,
    data: Object,
    main_url: String,
})

const data = ref(props.data);

const medicalCardRecord = computed(() =>
    data.records?.find(r => r?.record_type?.name === 'Medical Card')
)

const documents = computed(() => medicalCardRecord.value?.documents || [])


const createDialog = ref(false);

const showCreateDialog = () => {
    createDialog.value = true;
};

const closeCreateDialog = () => {
    createDialog.value = false;
};

const form = useForm({
  files: []
});

const errors = ref({});

const submit = () => {
  form.post(`${props.mainUrl}`, {
    onError: (error) => {
      console.log(error);
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

    //   emit('update', data);
    //   emit('close', false);
    }
  })
};
</script>

<template>
    <Layout>
        <template #title>
            Documents
        </template>
        <div>
            <FileUploader />
            <Button class="ml-2" variant="outline" @click="showCreateDialog">
                <Plus class="h-5"></Plus>
                Create New
            </Button>
        </div>

        <div class="max-w-4xl mx-auto py-6 space-y-6">
            <h1 class="text-2xl font-bold">Medical Card for {{ data.user.first_name }} {{
                data.user.last_name
            }}</h1>

            <Card v-if="medicalCardRecord">
                <CardHeader>
                    <CardTitle>Medical Card Record</CardTitle>
                </CardHeader>
                <CardContent>
                    <p class="text-gray-700 mb-4">{{ medicalCardRecord.content }}</p>

                    <div v-if="documents.length" class="space-y-4">
                        <div v-for="doc in documents" :key="doc.id"
                            class="flex items-center justify-between border p-3 rounded-xl">
                            <div class="flex items-center space-x-3">
                                <FileText class="text-blue-500" />
                                <span>{{ doc.name }}</span>
                            </div>
                            <a :href="`/storage/${doc.path}`" target="_blank"
                                class="text-sm text-blue-600 hover:underline flex items-center">
                                <Download class="w-4 h-4 mr-1" /> View / Download
                            </a>
                        </div>
                    </div>

                    <p v-else class="text-gray-500">No documents uploaded yet.</p>
                </CardContent>
            </Card>

            <p v-else class="text-gray-500">No medical card record found for this patient.</p>
        </div>

        <CreateDialog :data="data" @close="closeCreateDialog" v-model:open="createDialog"
            :mainUrl="$page.props.main_url" />
    </Layout>
</template>