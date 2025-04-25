<script setup>
import { ref, onMounted, onUnmounted } from "vue";
import { ArrowUpToLine } from "lucide-vue-next";
import { Button } from "@/components/ui/button";

const showTopBtn = ref(false);

const handleScroll = () => {
    showTopBtn.value = window.scrollY > 400;
};

const goToTop = () => {
    window.scrollTo({
        top: 0,
        left: 0,
        behavior: "smooth",
    });
};

onMounted(() => {
    window.addEventListener("scroll", handleScroll);
});

onUnmounted(() => {
    window.removeEventListener("scroll", handleScroll);
});

</script>

<template>
    <div>
        <Button v-if="showTopBtn" @click="goToTop" size="icon"
        class="fixed bottom-4 right-4 opacity-90 shadow-md">
            <ArrowUpToLine class="h-4 w-4" />
        </Button>
    </div>
</template>
