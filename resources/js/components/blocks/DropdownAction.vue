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
    editDialog.value = true;
    emit('current', objData);
}

function showDeleteDialog(objData, deleteDialog) {
    deleteDialog.value = true;
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
            <DropdownMenuLabel>{{ $t('pages.actions') }}</DropdownMenuLabel>
            <DropdownMenuItem @click="showEditDialog(objData, editDialog)">
                {{ $t('pages.edit') }}
            </DropdownMenuItem>
            <DropdownMenuItem @click="showDeleteDialog(objData, deleteDialog)">
                {{ $t('pages.delete') }}
            </DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>
</template>