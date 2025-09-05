<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';
import { Toaster } from '@/components/ui/sonner'
import 'vue-sonner/style.css'
import { ref, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { toast } from "vue-sonner"

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});

interface FlashMessage {
    success?: string;
    error?: string;
}

const page = usePage();
const message = ref<string | null>(null);

watch(() => page.props.flash as FlashMessage, (newFlash: FlashMessage) => {
    if (newFlash.success) {
        message.value = newFlash.success;
        toast.success(message.value, {
            action: {
                label: 'Close',
            },
            style: {
                background: '#6ee7b7'
            },
            class: 'my-toast',
        })
    } else if (newFlash.error) {
        message.value = newFlash.error;
        toast.error(message.value, {
            action: {
                label: 'Close',
            },
            style: {
                background: '#fda4af'
            },
            class: 'my-toast',
        })
    }
}, { deep: true });

</script>

<template>
    <Toaster position="top-center" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <slot />
    </AppLayout>
</template>
