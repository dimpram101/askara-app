<script setup lang="ts">
import AppLocalLayout from '@/layouts/AppLocalLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

withDefaults(
   defineProps<{
      canRegister: boolean;
   }>(),
   {
      canRegister: true,
   },
);
</script>

<template>
   <Head title="Home"></Head>

   <AppLocalLayout>
      <!-- Hero Section -->
      <div class="container mx-auto px-6 py-12">
         <div class="overflow-hidden rounded-3xl bg-[#76C6D1] shadow-2xl">
            <div class="flex flex-col items-center lg:flex-row">
               <!-- Hero Text -->
               <div class="p-12 lg:w-1/2 lg:p-16">
                  <h1 class="mb-6 text-5xl font-bold text-white lg:text-6xl">
                     ASKARA
                  </h1>
                  <p class="text-xl leading-relaxed text-white/90">
                     An integrated platform with a smart dashboard and
                     AI-powered tools to diagnose lung diseases
                  </p>
               </div>

               <!-- Hero Image -->
               <div class="flex items-center justify-center p-8 lg:w-1/2">
                  <div class="relative">
                     <img
                        src="/assets/images/hero-logo.png"
                        alt="Medical Illustration"
                        class="w-full max-w-lg"
                        onerror="this.style.display='none'"
                     />
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Feature Cards -->
      <div class="container mx-auto px-6 py-2">
         <div class="grid grid-cols-1 gap-6 md:grid-cols-3 lg:gap-8">
            <!-- AI-CXR Diagnose Card -->
            <div
               class="transform rounded-2xl bg-white p-8 shadow-lg transition hover:-translate-y-1 hover:shadow-xl"
            >
               <div class="flex items-start space-x-4">
                  <div class="flex-shrink-0 rounded-xl bg-yellow-100 p-4">
                     <svg
                        class="h-12 w-12 text-yellow-500"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                     >
                        <path
                           stroke-linecap="round"
                           stroke-linejoin="round"
                           stroke-width="2"
                           d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                        />
                     </svg>
                  </div>
                  <div>
                     <h3 class="mb-2 text-xl font-bold text-gray-800">
                        AI-CXR Diagnose
                     </h3>
                     <p class="text-sm leading-relaxed text-gray-600">
                        Detect lung diseases from chest X-rays instantly with AI
                     </p>
                  </div>
               </div>
            </div>

            <!-- Chatbot Consultation Card -->
            <div
               class="transform rounded-2xl bg-white p-8 shadow-lg transition hover:-translate-y-1 hover:shadow-xl"
            >
               <div class="flex items-start space-x-4">
                  <div class="flex-shrink-0 rounded-xl bg-cyan-100 p-4">
                     <svg
                        class="h-12 w-12 text-[#76C6D1]"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                     >
                        <path
                           stroke-linecap="round"
                           stroke-linejoin="round"
                           stroke-width="2"
                           d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"
                        />
                     </svg>
                  </div>
                  <div>
                     <h3 class="mb-2 text-xl font-bold text-gray-800">
                        Chatbot Consultation
                     </h3>
                     <p class="text-sm leading-relaxed text-gray-600">
                        Understand your AI diagnosis through guided chatbot
                        conversation
                     </p>
                  </div>
               </div>
            </div>

            <!-- Hotspot Mapping Dashboard Card -->
            <div
               class="transform rounded-2xl bg-white p-8 shadow-lg transition hover:-translate-y-1 hover:shadow-xl"
            >
               <div class="flex items-start space-x-4">
                  <div class="flex-shrink-0 rounded-xl bg-blue-100 p-4">
                     <svg
                        class="h-12 w-12 text-blue-500"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                     >
                        <path
                           stroke-linecap="round"
                           stroke-linejoin="round"
                           stroke-width="2"
                           d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                        />
                     </svg>
                  </div>
                  <div>
                     <h3 class="mb-2 text-xl font-bold text-gray-800">
                        Hotspot Mapping Dashboard
                     </h3>
                     <p class="text-sm leading-relaxed text-gray-600">
                        Visualize disease spread with real-time data insights
                     </p>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <!-- Start Screening Button -->
      <div class="container mx-auto flex justify-center px-6 py-8 pb-16">
         <Link
            href="/ai-cxr-diagnose"
            class="transform rounded-full bg-yellow-400 px-12 py-4 text-lg font-semibold text-white shadow-lg transition hover:scale-105 hover:bg-yellow-500 hover:shadow-xl"
         >
            Start Screening
         </Link>
      </div>
   </AppLocalLayout>
</template>
