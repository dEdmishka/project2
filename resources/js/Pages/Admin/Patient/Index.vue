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
import { Plus } from 'lucide-vue-next';

import CreateDialog from '@/components/admin/patient/cud/CreateDialog.vue';
import DeleteDialog from '@/components/admin/patient/cud/DeleteDialog.vue';
import EditDialog from '@/components/admin/patient/cud/EditDialog.vue';

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
        accessorKey: 'center',
        accessorFn: row => row.center?.name ?? '—',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Center', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => h('div', { class: '' }, row.getValue('center')),
    },
    {
        accessorKey: 'first_name',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['First name', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => h('div', { class: '' }, row.getValue('first_name')),
    },
    {
        accessorKey: 'last_name',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Last name', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => h('div', { class: '' }, row.getValue('last_name')),
    },
    {
        accessorKey: 'email',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Email', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => h('div', { class: '' }, row.getValue('email')),
    },
    {
        accessorKey: 'birth_date',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Birth date', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => h('div', { class: '' }, row.getValue('birth_date')),
    },
    {
        accessorKey: 'address',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Address', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => h('div', { class: 'max-w-50 w-full text-ellipsis whitespace-nowrap overflow-hidden hover:whitespace-normal hover:overflow-visible' }, row.getValue('address')),
    },
    {
        accessorKey: 'gender',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Gender', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => {
            const gender = row.getValue('gender');
            return h('div', { class: 'capitalize' }, (gender === "F") ? 'Female' : 'Male');
        }
    },
    {
        accessorKey: 'status',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Status', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => h('div', { class: 'capitalize' }, row.getValue('status')),
    },
    {
        accessorKey: 'phones',
        header: () => h('div', { class: 'text-center' }, 'Phones'),
        cell: ({ row }) => {
            return h('div', { class: 'flex flex-col' }, row.getValue('phones')?.map(phone =>
                h('p', { class: '' }, phone.phone_number))
            );
        },
        filterFn: (row, columnId, filterValue) => {
            const phones = row.getValue(columnId) || [];

            if (!Array.isArray(phones)) return false;
            if (!filterValue) return true;

            return phones.some(phone =>
                phone.phone_number.toLowerCase().replace(/-/g, "").includes(filterValue.toLowerCase())
            );
        },
    },
    {
        accessorKey: 'social_links',
        header: () => h('div', { class: 'text-center' }, 'Social Links'),
        cell: ({ row }) => {
            return h('div', { class: 'flex flex-col' }, row.getValue('social_links')?.map(link =>
                h('p', { class: 'max-w-50 w-full text-ellipsis whitespace-nowrap overflow-hidden hover:whitespace-normal hover:overflow-visible' }, link.url))
            );
        },
        filterFn: (row, columnId, filterValue) => {
            const socialLinks = row.getValue(columnId) || [];

            if (!Array.isArray(socialLinks)) return false;
            if (!filterValue) return true;

            return socialLinks.some(link =>
                link.url.toLowerCase().includes(filterValue.toLowerCase())
            );
        },
    },
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

const selectedField = ref('first_name')

watch(selectedField, (newField, oldField) => {
    if (oldField) {
        table.getColumn(oldField)?.setFilterValue('');
    }
});
</script>

<template>
    <Layout>
        <template #title>
            Patients
        </template>
        Patients

        <!-- {{ $props.data }} -->
        <div class="w-[calc(100dvw-325px)]">
            <div class="flex items-center py-4">
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
                                :key="column.id" :value="column.id"
                                @update:model-value="() => selectedField = column.id" class="capitalize">
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
            :mainUrl="$page.props.main_url" :centers="$page.props.centers" :users="$page.props.users" />
        <EditDialog @update="updateData" @close="closeEditDialog" :currentCell="currentCell" v-model:open="editDialog"
            :mainUrl="$page.props.main_url" :centers="$page.props.centers" />
        <DeleteDialog @update="updateData" @close="closeDeleteDialog" :currentCell="currentCell"
            v-model:open="deleteDialog" :mainUrl="$page.props.main_url" />
    </Layout>
</template>