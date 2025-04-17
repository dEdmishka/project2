<script setup>
import { Button } from '@/components/ui/button'
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from '@/components/ui/dropdown-menu'
import { MoreHorizontal } from 'lucide-vue-next'

defineProps({
    objData: Object,
    editDialog: Object,
    deleteDialog: Object,
})

const emit = defineEmits(['current']);

function showEditDialog(objData, editDialog) {
    // navigator.clipboard.writeText(objData.id);
    editDialog.value = true;
    // console.log(url);
    // console.log(objData);
    emit('current', objData);
}

function showDeleteDialog(objData, deleteDialog) {
    deleteDialog.value = true;
    // console.log(url);
    // console.log(objData);
    emit('current', objData);
}
</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger as-child>
            <Button variant="ghost" class="w-8 h-8 p-0">
                <span class="sr-only">Open menu</span>
                <MoreHorizontal class="w-4 h-4" />
            </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end">
            <DropdownMenuLabel>Actions</DropdownMenuLabel>
            <DropdownMenuItem @click="showEditDialog(objData, editDialog)">
                Edit
            </DropdownMenuItem>
            <DropdownMenuItem @click="showDeleteDialog(objData, deleteDialog)">
                Delete
            </DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>
</template>