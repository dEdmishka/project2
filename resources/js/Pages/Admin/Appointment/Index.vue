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
import { h, ref, watch, onBeforeMount, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import DropdownAction from '@/components/blocks/DropdownAction.vue'
import { Plus, ArrowUpDown, ChevronDown, ChevronsRight, ChevronsLeft } from 'lucide-vue-next';

import CreateDialog from '@/components/admin/appointment/cud/CreateDialog.vue';
import DeleteDialog from '@/components/admin/appointment/cud/DeleteDialog.vue';
import EditDialog from '@/components/admin/appointment/cud/EditDialog.vue';
import VersionSwitcher from '@/components/blocks/VersionSwitcher.vue';

const props = defineProps({
    data: Array,
    centers: Array,
    patients: Array,
    staff: Array,
    wards: Array,
    main_url: String,
})

const data = computed(() => props.data);
const currentCell = ref();
const centerId = ref(localStorage.getItem('selectedCenterId'));

const getData = () => {
    let params = buildParams();

    router.visit(props.main_url, {
        only: ['data'],
        data: params,
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            // console.log('it works')
        }
    })
}

const selectCenter = (center) => {
    centerId.value = center.id
    localStorage.setItem('selectedCenterId', center.id)
    getData()
}

const buildParams = () => {
    let params = {};
    if (centerId.value) params.center = centerId.value
    return params;
}

onBeforeMount(() => {
    getData()
})

const createDialog = ref(false);
const editDialog = ref(false);
const deleteDialog = ref(false);


const showCreateDialog = () => {
    createDialog.value = true;
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
        accessorKey: 'patient',
        accessorFn: row => {
            const first = row.patient?.user?.first_name ?? '';
            const last = row.patient?.user?.last_name ?? '';
            return first || last ? `${first} ${last}`.trim() : '—';
        },
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Patient', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => h('div', { class: '' }, row.getValue('patient')),
    },
    {
        accessorKey: 'staff',
        header: () => h('div', { class: 'text-center' }, 'Staff'),
        cell: ({ row }) => {
            return h('div', { class: 'flex flex-col' }, row.getValue('staff').map(staff =>
                h('p', { class: 'max-w-50 w-full text-ellipsis whitespace-nowrap overflow-hidden hover:whitespace-normal hover:overflow-visible' }, staff.user?.first_name + ' ' + staff.user?.last_name))
            );
        },
        filterFn: (row, columnId, filterValue) => {
            const staff = row.getValue(columnId) || [];

            if (!Array.isArray(staff)) return false;
            if (!filterValue) return true;

            return staff.some(staffItem =>
                staffItem?.user?.first_name.toLowerCase().includes(filterValue.toLowerCase()) ||
                staffItem?.user?.last_name.toLowerCase().includes(filterValue.toLowerCase())
            );
        },
    },
    {
        accessorKey: 'ward',
        accessorFn: row => { return row.ward?.name ?? '—' },
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Ward', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => h('div', { class: '' }, row.getValue('ward')),
    },
    {
        accessorKey: 'procedure',
        accessorFn: row => { return row.ward.procedure?.name ?? '—' },
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Procedure', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => h('div', { class: '' }, row.getValue('procedure')),
    },
    {
        accessorKey: 'time',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Time', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => h('div', { class: '' }, row.getValue('time')),
    },
    {
        accessorKey: 'notes',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Notes', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => h('div', { class: 'max-w-50 w-full text-ellipsis whitespace-nowrap overflow-hidden hover:whitespace-normal hover:overflow-visible' }, row.getValue('notes')),
    },
    {
        accessorKey: 'status',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Status', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => h('div', { class: 'max-w-50 w-full' }, row.getValue('status')),
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

const selectedField = ref('notes')

watch(selectedField, (newField, oldField) => {
    if (oldField) {
        table.getColumn(oldField)?.setFilterValue('');
    }
});
</script>

<template>
    <Layout>
        <template #title>
            Appointments
        </template>
        <div class="grid max-w-[275px]">
            <VersionSwitcher @change="selectCenter" :versions="props.centers"
                :default-version="props.centers[centerId - 1]" />
        </div>
        <!-- {{ $props.data }} -->
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

        <CreateDialog @update="updateData" @close="closeCreateDialog" v-model:open="createDialog"
            :mainUrl="$page.props.main_url" :patients="$page.props.patients" :staff="$page.props.staff"
            :wards="$page.props.wards" />
        <EditDialog @update="updateData" @close="closeEditDialog" :currentCell="currentCell" v-model:open="editDialog"
            :mainUrl="$page.props.main_url" :patients="$page.props.patients" :staff="$page.props.staff"
            :wards="$page.props.wards" />
        <DeleteDialog @update="updateData" @close="closeDeleteDialog" :currentCell="currentCell"
            v-model:open="deleteDialog" :mainUrl="$page.props.main_url" />
    </Layout>
</template>