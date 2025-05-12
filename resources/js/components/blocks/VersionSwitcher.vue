<script setup>
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from "@/components/ui/dropdown-menu"
import {
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from "@/components/ui/sidebar"

import { Check, ChevronsUpDown, GalleryVerticalEnd } from 'lucide-vue-next'
import { ref } from 'vue'

const props = defineProps({
    versions: { type: Array, required: true, },
    defaultVersion: String | Object
})
const emit = defineEmits(['change'])

const selectedVersion = ref(props.defaultVersion);

const selectVersion = (version) => {
    console.log(selectedVersion.value.id)
    console.log(version.id)

    if (selectedVersion.value.id != version.id) {
        selectedVersion.value = version;
        emit('change', version)
    }
}
</script>

<template>
    <SidebarMenu>
        <SidebarMenuItem>
            <DropdownMenu>
                <DropdownMenuTrigger as-child>
                    <SidebarMenuButton size="lg"
                        class="data-[state=open]:bg-sidebar-accent data-[state=open]:text-sidebar-accent-foreground">
                        <div
                            class="flex aspect-square size-8 items-center justify-center rounded-lg bg-sidebar-primary text-sidebar-primary-foreground">
                            <GalleryVerticalEnd class="size-4" />
                        </div>
                        <div class="flex flex-col gap-0.5 leading-none">
                            <span class="font-semibold">{{ $t('current_center') }}</span>
                            <span v-if=selectedVersion class="">{{ selectedVersion?.name }}</span>
                        </div>
                        <ChevronsUpDown class="ml-auto" />
                    </SidebarMenuButton>
                </DropdownMenuTrigger>
                <DropdownMenuContent class="w-[--reka-dropdown-menu-trigger-width]" align="start">
                    <DropdownMenuItem v-for="version in versions" :key="version" @select="selectVersion(version)">
                        {{ version.name }}
                        <Check v-if="version === selectedVersion" class="ml-auto" />
                    </DropdownMenuItem>
                </DropdownMenuContent>
            </DropdownMenu>
        </SidebarMenuItem>
    </SidebarMenu>
</template>