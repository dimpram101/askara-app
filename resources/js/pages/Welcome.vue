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
         <div class="relative rounded-3xl bg-[#76C6D1] shadow-2xl mt-12">
            <div class="flex flex-col items-center lg:flex-row">
               <!-- Hero Text -->
               <div class="relative z-10 p-12 lg:w-3/5 lg:p-16">
                  <h1 class="mb-6 text-5xl font-bold leading-tight text-white lg:text-6xl">
                     Diagnose Lung Diseases<br />with AI Precission
                  </h1>
                  <p class="mb-8 text-xl leading-relaxed text-white/90">
                     An integrated platform with a smart dashboard and
                     AI-powered tools to diagnose lung diseases.<br />
                     Anytime. Anywhere.
                  </p>
                  <Link
                     href="/ai-cxr-diagnose"
                     class="inline-block transform rounded-full bg-yellow-400 px-8 py-3 text-base font-semibold text-white shadow-lg transition hover:scale-105 hover:bg-yellow-500"
                  >
                     Start Screening
                  </Link>
               </div>

               <!-- Hero Image - Fixed Position -->
               <div class="relative xl:right-20 xl:absolute xl:-top-[50px] xl:bottom-0">
                  <div class="relative">
                     <img
                        src="/assets/images/hero-2-logo.png"
                        alt="Medical Illustration"
                        class="w-full max-w-md xl:scale-120 lg:max-w-lg"
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
                     <img
                        src="/assets/images/ai_icon.png"
                        alt="AI-CXR Icon"
                        class="h-12 w-12 text-yellow-500"
                     />
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
                     <img
                        src="/assets/images/chatbot_icon.png"
                        alt="Chatbot Icon"
                        class="h-12 w-12 text-cyan-500"
                     />
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
                     <img
                        src="/assets/images/hotspot_icon.png"
                        alt="Dashboard Icon"
                        class="h-12 w-12 text-blue-500"
                     />
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

   </AppLocalLayout>
</template>
