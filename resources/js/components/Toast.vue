<script setup lang="ts">
import { computed, watch, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import { CheckCircle, XCircle, Info, AlertTriangle, X } from 'lucide-vue-next';

const page = usePage();
const show = ref(false);
const message = ref('');
const type = ref<'success' | 'error' | 'info' | 'warning'>('success');

const flash = computed(() => page.props.flash as Record<string, string | null>);
console.log(flash);

watch(
    flash,
    (newFlash) => {
        if (newFlash.success) {
            showToast(newFlash.success, 'success');
        } else if (newFlash.error) {
            showToast(newFlash.error, 'error');
        } else if (newFlash.info) {
            showToast(newFlash.info, 'info');
        } else if (newFlash.warning) {
            showToast(newFlash.warning, 'warning');
        }
    },
    { deep: true }
);

const showToast = (msg: string, msgType: typeof type.value) => {
    message.value = msg;
    type.value = msgType;
    show.value = true;

    setTimeout(() => {
        show.value = false;
    }, 5000);
};

const close = () => {
    show.value = false;
};

const iconComponent = computed(() => {
    switch (type.value) {
        case 'success':
            return CheckCircle;
        case 'error':
            return XCircle;
        case 'info':
            return Info;
        case 'warning':
            return AlertTriangle;
        default:
            return Info;
    }
});

const alertVariant = computed(() => {
    return type.value === 'error' ? 'destructive' : 'default';
});

const colorClass = computed(() => {
    switch (type.value) {
        case 'success':
            return 'text-green-600';
        case 'error':
            return 'text-red-600';
        case 'info':
            return 'text-blue-600';
        case 'warning':
            return 'text-yellow-600';
        default:
            return 'text-gray-600';
    }
});

const title = computed(() => {
    switch (type.value) {
        case 'success':
            return 'Success';
        case 'error':
            return 'Error';
        case 'info':
            return 'Information';
        case 'warning':
            return 'Warning';
        default:
            return 'Notification';
    }
});
</script>

<template>
    <Transition
        enter-active-class="transition ease-out duration-300"
        enter-from-class="opacity-0 translate-y-4"
        enter-to-class="opacity-100 translate-y-0"
        leave-active-class="transition ease-in duration-200"
        leave-from-class="opacity-100 translate-y-0"
        leave-to-class="opacity-0 translate-y-4"
    >
        <div
            v-if="show"
            class="fixed right-4 top-4 z-50 w-full max-w-md"
        >
            <Alert :variant="alertVariant" class="relative pr-12 shadow-lg">
                <component :is="iconComponent" :class="['h-5 w-5', colorClass]" />
                <AlertTitle>{{ title }}</AlertTitle>
                <AlertDescription>{{ message }}</AlertDescription>
                <button
                    @click="close"
                    class="absolute right-3 top-3 rounded-sm opacity-70 ring-offset-background transition-opacity hover:opacity-100 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
                >
                    <X class="h-4 w-4" />
                    <span class="sr-only">Close</span>
                </button>
            </Alert>
        </div>
    </Transition>
</template>
