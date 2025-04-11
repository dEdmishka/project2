<script setup>
import { Button } from '@/components/ui/button'
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from '@/components/ui/dropdown-menu'
import { MoreHorizontal } from 'lucide-vue-next'

defineProps({
    objData: Object,
    editDialog: Object,
    deleteDialog: Object,
})

function showEditDialog(objData, url, editDialog) {
    // navigator.clipboard.writeText(objData.id);
    editDialog.value = true;
    console.log(url);
    console.log(objData);
}

function showDeleteDialog(objData, url, deleteDialog) {
    deleteDialog.value = true;
    console.log(url);
    console.log(objData);
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
            <DropdownMenuItem @click="showEditDialog(objData, $page.url, editDialog)">
                Edit
            </DropdownMenuItem>
            <DropdownMenuItem @click="showDeleteDialog(objData, $page.url, deleteDialog)">
                Delete
            </DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>
</template>