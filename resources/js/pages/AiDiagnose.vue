<script lang="ts" setup>
import AppLocalLayout from '@/layouts/AppLocalLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
   <Head title="AI Diagnose" />

   <AppLocalLayout>
      <div class="container mx-auto px-6 py-12">
         <h1 class="mb-6 text-center text-4xl font-bold">
            AI-Powered Lung Disease Diagnosis
         </h1>
         <p class="mb-4 text-lg">
            Upload chest X-ray images to receive instant AI-driven diagnoses for
            various lung diseases.
         </p>
         <div
            class="rounded-lg border-4 border-dashed border-gray-300 p-12 text-center"
         >
            <p class="text-gray-500">
               Drag & Drop your chest X-ray images here
            </p>
            <p class="mt-2 text-gray-400">or click to select files</p>
         </div>
      </div>
   </AppLocalLayout>
</template>
