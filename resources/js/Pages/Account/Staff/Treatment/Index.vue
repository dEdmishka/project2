<script setup>
import Layout from "@/Layout/Dashboard/Index.vue";

import { valueUpdater } from '@/lib/utils'
import { Button } from '@/components/ui/button'

import {
    DropdownMenu,
    DropdownMenuCheckboxItem,
    DropdownMenuRadioItem,
    DropdownMenuRadioGroup,
    DropdownMenuContent,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'

import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select'

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
import { ArrowUpDown, ChevronDown, ChevronsRight, ChevronsLeft } from 'lucide-vue-next'
import { h, ref, watch } from 'vue'

import CreateDialog from '@/Pages/Account/Patient/Procedure/CreateDialog.vue';

const props = defineProps({
    user: Object,
    data: Array,
    main_url: String,
})

const data = ref(props.data);
const currentCell = ref();

const createDialog = ref(false);

const showCreateDialog = () => {
    createDialog.value = true;
};

const closeCreateDialog = () => {
    createDialog.value = false;
};

const setCurrentCell = (editData) => {
    currentCell.value = editData;
}

const columns = [
    // {
    //     id: 'actions',
    //     enableHiding: false,
    //     cell: ({ row }) => {
    //         const objData = row.original

    //         return h('div', { class: 'grid py-4 px-2' }, h(Button, { class: 'cursor-pointer', onClick: showCreateDialog, onCurrent: setCurrentCell(objData) }, 'Записатися!'))
    //     },
    // },
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
    // initialState: {
    //     pagination: {
    //         pageIndex: 2, //custom initial page index
    //         pageSize: 5, //custom default page size
    //     },
    // }
})

import { motion } from 'motion-v'

const INITIAL_PAGE_INDEX = 0
const goToPageNumber = ref(INITIAL_PAGE_INDEX + 1)
const pageSizes = [5, 10, 20, 30, 40, 50]

const handleGoToPage = (e) => {
    const page = e ? Number(e) - 1 : 0
    goToPageNumber.value = page + 1
    table.setPageIndex(page)
}

const handlePageSizeChange = (e) => {
    table.setPageSize(Number(e))
}

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
            Treatments
        </template>
        <div class="">
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
                            <motion.template v-for="(row, index) in table.getRowModel().rows" :key="row.id" :animate="{
                                opacity: [0, 1],
                                y: [100, 0],
                                transition: {
                                    type: 'linear',
                                    duration: 1,
                                    delay: 0.1 + 0.05 * index
                                }
                            }">
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
                            </motion.template>
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
                <div>
                    <div class="flex items-center gap-2">
                        <span class="flex items-center gap-1">
                            <div>Page</div>
                            <strong>
                                {{ table.getState().pagination.pageIndex + 1 }} of
                                {{ table.getPageCount() }}
                            </strong>
                        </span>
                        <span class="flex items-center gap-1">
                            | Go to page:
                            <Input type="number" :min="1" :max="table.getPageCount()" v-model="goToPageNumber"
                                @update:modelValue="handleGoToPage" class="w-16" />
                        </span>
                        <Select v-model="table.getState().pagination.pageSize"
                            @update:modelValue="handlePageSizeChange">
                            <SelectTrigger class="w-[180px]">
                                <SelectValue placeholder="Select a pagesize" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem :key="pageSize" :value="pageSize" v-for="pageSize in pageSizes">
                                    Show {{ pageSize }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                    </div>
                </div>
                <div class="space-x-2">
                    <Button variant="outline" size="sm" @click="() => table.setPageIndex(0)"
                        :disabled="!table.getCanPreviousPage()">
                        <ChevronsLeft class="h-4 w-4" />
                    </Button>
                    <Button variant="outline" size="sm" :disabled="!table.getCanPreviousPage()"
                        @click="table.previousPage()">
                        Previous
                    </Button>
                    <Button variant="outline" size="sm" :disabled="!table.getCanNextPage()" @click="table.nextPage()">
                        Next
                    </Button>
                    <Button variant="outline" size="sm" @click="() => table.setPageIndex(table.getPageCount() - 1)"
                        :disabled="!table.getCanNextPage()">
                        <ChevronsRight class="h-4 w-4" />
                    </Button>
                </div>
            </div>

        </div>

        <CreateDialog :procedure="currentCell" :user="$page.props.user" @close="closeCreateDialog"
            v-model:open="createDialog" :mainUrl="$page.props.main_url" />
    </Layout>
</template>