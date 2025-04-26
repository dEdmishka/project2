<script setup>
import Layout from '@/Layout/Dashboard/Index.vue';

import { valueUpdater } from '@/lib/utils'
import { Button } from '@/components/ui/button'
import { Checkbox } from '@/components/ui/checkbox'
import {
    DropdownMenu,
    DropdownMenuCheckboxItem,
    DropdownMenuRadioItem,
    DropdownMenuRadioGroup,
    DropdownMenuContent,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'

import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog'

import { Label } from '@/components/ui/label'
import { Input } from '@/components/ui/input'
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table'
import {
    FlexRender,
    getCoreRowModel,
    getExpandedRowModel,
    getFilteredRowModel,
    getPaginationRowModel,
    getSortedRowModel,
    useVueTable,
} from '@tanstack/vue-table'
import { ArrowUpDown, ChevronDown } from 'lucide-vue-next'
import { h, ref, watch } from 'vue'
import DropdownAction from '@/components/blocks/DropdownAction.vue'
import { Badge } from '@/components/ui/badge';
import { Plus } from 'lucide-vue-next';

import CreateDialog from '@/components/admin/center/cud/CreateDialog.vue';
import DeleteDialog from '@/components/admin/center/cud/DeleteDialog.vue';
import EditDialog from '@/components/admin/center/cud/EditDialog.vue';

const props = defineProps({
    data: Array,
})

const data = ref(props.data);
const currentCell = ref();

const createDialog = ref(false);
const editDialog = ref(false);
const deleteDialog = ref(false);


const showCreateDialog = () => {
    createDialog.value = true;
};
const showEditDialog = () => {
    editDialog.value = true;
};
const showDeleteDialog = () => {
    deleteDialog.value = true;
};

const updateData = (newData) => {
    data.value = newData;
}

const closeCreateDialog = () => {
    createDialog.value = false;
};

const closeEditDialog = () => {
    editDialog.value = false;
};

const closeDeleteDialog = () => {
    deleteDialog.value = false;
};

const setCurrentCell = (editData) => {
    currentCell.value = editData;
}

// const data = [
// {
//     id: 'm5gr84i9',
//     amount: 316,
//     status: 'success',
//     email: 'ken99@yahoo.com',
// },
// {
//     id: '3u1reuv4',
//     amount: 242,
//     status: 'success',
//     email: 'Abe45@gmail.com',
// },
// {
//     id: 'derv1ws0',
//     amount: 837,
//     status: 'processing',
//     email: 'Monserrat44@gmail.com',
// },
// {
//     id: '5kma53ae',
//     amount: 874,
//     status: 'success',
//     email: 'Silas22@gmail.com',
// },
// {
//     id: 'bhqecj4p',
//     amount: 721,
//     status: 'failed',
//     email: 'carmella@hotmail.com',
// },
// ]

const columns = [
    {
        id: 'select',
        header: ({ table }) => h(Checkbox, {
            'modelValue': table.getIsAllPageRowsSelected() || (table.getIsSomePageRowsSelected() && 'indeterminate'),
            'onUpdate:modelValue': value => table.toggleAllPageRowsSelected(!!value),
            'ariaLabel': 'Select all',
        }),
        cell: ({ row }) => h(Checkbox, {
            'modelValue': row.getIsSelected(),
            'onUpdate:modelValue': value => row.toggleSelected(!!value),
            'ariaLabel': 'Select row',
        }),
        enableSorting: false,
        enableHiding: false,
    },
    {
        accessorKey: 'name',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Name', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => h('div', { class: 'lowercase' }, row.getValue('name')),
    },
    {
        accessorKey: 'email',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Email', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => h('div', { class: 'lowercase' }, row.getValue('email')),
    },
    {
        accessorKey: 'address',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Address', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => h('div', { class: 'lowercase' }, row.getValue('address')),
    },
    {
        accessorKey: 'description',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Description', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => h('div', { class: 'lowercase max-w-75 w-full text-ellipsis whitespace-nowrap overflow-hidden' }, row.getValue('description')),
    },
    {
        accessorKey: 'phones',
        header: () => h('div', { class: 'text-right' }, 'Phones'),
        cell: ({ row }) => {
            return h('div', { class: 'text-right font-medium' }, row.getValue('phones'))
        },
    },
    {
        accessorKey: 'social_links',
        header: () => h('div', { class: 'text-right' }, 'Social Links'),
        cell: ({ row }) => {
            return h('div', { class: 'text-right font-medium' }, row.getValue('social_links'))
        },
    },
    {
        accessorKey: 'working_hours',
        header: () => h('div', { class: 'text-right' }, 'Working hours'),
        cell: ({ row }) => {
            return h('div', { class: 'text-right font-medium' }, row.getValue('working_hours'))
        },
    },
    // {
    //     accessorKey: 'price',
    //     header: () => h('div', { class: 'text-right' }, 'Price'),
    //     cell: ({ row }) => {
    //         const amount = Number.parseFloat(row.getValue('price'))

    //         // Format the amount as a dollar amount
    //         const formatted = new Intl.NumberFormat('en-US', {
    //             style: 'currency',
    //             currency: 'UAH',
    //         }).format(amount)

    //         return h('div', { class: 'text-right font-medium' }, formatted)
    //     },
    // },
    // {
    //     accessorKey: 'is_active',
    //     header: 'Status',
    //     cell: ({ row }) => {
    //         const status = row.getValue('is_active');

    //         return h('div', { class: 'capitalize' }, status ? 'Active' : 'Inactive');
    //     },
    // },
    {
        id: 'actions',
        enableHiding: false,
        cell: ({ row }) => {
            const objData = row.original

            return h(DropdownAction, {
                objData,
                editDialog,
                deleteDialog,
                onExpand: row.toggleExpanded,
                onCurrent: setCurrentCell,
            })
        },
    },
]

const sorting = ref([])
const columnFilters = ref([])
const columnVisibility = ref({})
const rowSelection = ref({})
const expanded = ref({})

const table = useVueTable({
    data,
    columns,
    getCoreRowModel: getCoreRowModel(),
    getPaginationRowModel: getPaginationRowModel(),
    getSortedRowModel: getSortedRowModel(),
    getFilteredRowModel: getFilteredRowModel(),
    getExpandedRowModel: getExpandedRowModel(),
    onSortingChange: updaterOrValue => valueUpdater(updaterOrValue, sorting),
    onColumnFiltersChange: updaterOrValue => valueUpdater(updaterOrValue, columnFilters),
    onColumnVisibilityChange: updaterOrValue => valueUpdater(updaterOrValue, columnVisibility),
    onRowSelectionChange: updaterOrValue => valueUpdater(updaterOrValue, rowSelection),
    onExpandedChange: updaterOrValue => valueUpdater(updaterOrValue, expanded),
    state: {
        get sorting() { return sorting.value },
        get columnFilters() { return columnFilters.value },
        get columnVisibility() { return columnVisibility.value },
        get rowSelection() { return rowSelection.value },
        get expanded() { return expanded.value },
    },
})

const selectedField = ref('name')

watch(selectedField, (newField, oldField) => {
  if (oldField) {
    table.getColumn(oldField)?.setFilterValue('');
  }
});
</script>

<template>
    <Layout>
        <template #title>
            Centers
        </template>
        Centers

        <div class="w-full">
            <div class="flex items-center py-4">
                <!-- <Input class="max-w-sm" placeholder="Filter names..."
                    :model-value="table.getColumn('name')?.getFilterValue()"
                    @update:model-value="table.getColumn('name')?.setFilterValue($event)" /> -->
                <Input class="max-w-[250px]" :placeholder="`Filter ${selectedField}...`"
                    :model-value="table.getColumn(selectedField)?.getFilterValue()"
                    @update:model-value="table.getColumn(selectedField)?.setFilterValue($event)" />
                <DropdownMenu>
                    <DropdownMenuTrigger as-child>
                        <Button variant="outline" class="ml-2 min-w-[225px] justify-start">
                            Filter By<span class="capitalize">{{ selectedField }}</span>
                            <ChevronDown class="ml-2 h-4 w-4" />
                        </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="end">
                        <DropdownMenuRadioGroup v-model="selectedField">
                            <DropdownMenuRadioItem @select="(e) => { e.preventDefault() }"
                                v-for="column in table.getAllColumns().filter((column) => column.getCanHide())"
                                :key="column.id" :value="column.id" @update:model-value="() => selectedField = column.id" class="capitalize">
                                {{ column.id }}
                            </DropdownMenuRadioItem>
                        </DropdownMenuRadioGroup>
                    </DropdownMenuContent>
                </DropdownMenu>
                <Button class="ml-2" variant="outline" @click="showCreateDialog">
                    <Plus class="h-5"></Plus>
                    Create New
                </Button>
                <DropdownMenu>
                    <DropdownMenuTrigger as-child>
                        <Button variant="outline" class="ml-auto">
                            Columns
                            <ChevronDown class="ml-2 h-4 w-4" />
                        </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="end">
                        <DropdownMenuCheckboxItem @select="(e) => { e.preventDefault() }"
                            v-for="column in table.getAllColumns().filter((column) => column.getCanHide())"
                            :key="column.id" class="capitalize" :model-value="column.getIsVisible()"
                            @update:model-value="(value) => {
                                column.toggleVisibility(!!value)
                            }">
                            {{ column.id }}
                        </DropdownMenuCheckboxItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            </div>
            <div class="rounded-md border">
                <Table>
                    <TableHeader>
                        <TableRow v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
                            <TableHead v-for="header in headerGroup.headers" :key="header.id">
                                <FlexRender v-if="!header.isPlaceholder" :render="header.column.columnDef.header"
                                    :props="header.getContext()" />
                            </TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <template v-if="table.getRowModel().rows?.length">
                            <template v-for="row in table.getRowModel().rows" :key="row.id">
                                <TableRow :data-state="row.getIsSelected() && 'selected'">
                                    <TableCell v-for="cell in row.getVisibleCells()" :key="cell.id">
                                        <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()" />
                                    </TableCell>
                                </TableRow>
                                <TableRow v-if="row.getIsExpanded()">
                                    <TableCell :colspan="row.getAllCells().length">
                                        {{ JSON.stringify(row.original) }}
                                    </TableCell>
                                </TableRow>
                            </template>
                        </template>

                        <TableRow v-else>
                            <TableCell :colspan="columns.length" class="h-24 text-center">
                                No results.
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>

            <div class="flex items-center justify-end space-x-2 py-4">
                <div class="flex-1 text-sm text-muted-foreground">
                    {{ table.getFilteredSelectedRowModel().rows.length }} of
                    {{ table.getFilteredRowModel().rows.length }} row(s) selected.
                </div>
                <div class="space-x-2">
                    <Button variant="outline" size="sm" :disabled="!table.getCanPreviousPage()"
                        @click="table.previousPage()">
                        Previous
                    </Button>
                    <Button variant="outline" size="sm" :disabled="!table.getCanNextPage()" @click="table.nextPage()">
                        Next
                    </Button>
                </div>
            </div>
        </div>

        <CreateDialog @update="updateData" @close="closeCreateDialog" v-model:open="createDialog"
            :mainUrl="$page.props.main_url" />
        <EditDialog @update="updateData" @close="closeEditDialog" :currentCell="currentCell" v-model:open="editDialog"
            :mainUrl="$page.props.main_url" />
        <DeleteDialog @update="updateData" @close="closeDeleteDialog" :currentCell="currentCell"
            v-model:open="deleteDialog" :mainUrl="$page.props.main_url" />
        <!-- <Dialog v-model:open="showDialog">
            <DialogTrigger as-child>
                <Button variant="outline">
                    Edit Profile
                </Button>
            </DialogTrigger>
            <DialogContent class="sm:max-w-[425px]">
                <DialogHeader>
                    <DialogTitle>Edit profile</DialogTitle>
                    <DialogDescription>
                        Make changes to your profile here. Click save when you're done.
                    </DialogDescription>
                </DialogHeader>
                <div class="grid gap-4 py-4">
                    <div class="grid grid-cols-4 items-center gap-4">
                        <Label for="name" class="text-right">
                            Name
                        </Label>
                        <Input id="name" value="Pedro Duarte" class="col-span-3" />
                    </div>
                    <div class="grid grid-cols-4 items-center gap-4">
                        <Label for="username" class="text-right">
                            Username
                        </Label>
                        <Input id="username" value="@peduarte" class="col-span-3" />
                    </div>
                </div>
                <DialogFooter>
                    <Button type="submit">
                        Save changes
                    </Button>
                </DialogFooter>
            </DialogContent>
        </Dialog> -->
    </Layout>
</template>