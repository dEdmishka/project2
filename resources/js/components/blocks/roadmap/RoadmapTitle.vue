<script setup>
</script>

<template>
    <section class="grid grid-cols-1 place-items-center py-20 md:py-40 gap-10 px-4">
        <div class="text-center lg:text-start space-y-6">
            <div class="text-5xl md:text-6xl font-bold">
                <slot name="title" />
            </div>
        </div>
    </section>
</template>