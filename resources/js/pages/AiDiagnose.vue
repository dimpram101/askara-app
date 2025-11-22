<template>
   <Head title="AI Diagnose" />

   <AppLocalLayout>
      <div class="container mx-auto px-6 py-12">
         <h1 class="mb-6 text-center text-4xl font-bold">AI-CXR Diagnose</h1>
         <p class="mb-4 text-lg">
            An intelligent AI-powered system developed to support medical
            professionals in accurately identifying and analyzing lung diseases
            from X-ray images.
         </p>

         <!-- NIK Input with Search for Fasyankes -->
         <div class="mb-6 flex flex-col items-start">
            <label for="NIK" class="mb-1 font-medium">
               {{ isFasyankes ? 'NIK / Cari Pasien' : 'NIK' }}
            </label>
            <div class="nik-search-container relative w-full max-w-2xl">
               <input
                  type="text"
                  id="NIK"
                  v-model="form.nik"
                  :readonly="isPasien && user.profile?.nik !== null"
                  @input="isFasyankes ? searchPatients() : null"
                  @focus="isFasyankes ? (showDropdown = true) : null"
                  class="w-full rounded border border-gray-300 px-3 py-2 focus:border-blue-500 focus:outline-none disabled:bg-gray-100"
                  :placeholder="
                     isFasyankes
                        ? 'Ketik NIK atau nama pasien untuk mencari...'
                        : 'Enter NIK'
                  "
               />
               <!-- Dropdown Results for Fasyankes -->
               <div
                  v-if="
                     isFasyankes &&
                     showDropdown &&
                     form.nik &&
                     form.nik.length >= 2
                  "
                  class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md border border-gray-300 bg-white shadow-lg"
               >
                  <div v-if="isSearching" class="px-4 py-2 text-gray-500">
                     Mencari...
                  </div>
                  <div
                     v-else-if="searchResults.length === 0"
                     class="px-4 py-2 text-gray-500"
                  >
                     Pasien tidak ditemukan. Anda dapat tetap melanjutkan dengan
                     NIK ini.
                  </div>
                  <button
                     v-else
                     v-for="patient in searchResults"
                     :key="patient.id"
                     type="button"
                     @click="selectPatient(patient)"
                     class="w-full px-4 py-2 text-left hover:bg-blue-50 focus:bg-blue-50 focus:outline-none"
                  >
                     <div class="font-medium">{{ patient.name }}</div>
                     <div class="text-sm text-gray-600">
                        NIK: {{ patient.nik || '-' }}
                     </div>
                  </button>
               </div>
            </div>
            <p v-if="isFasyankes" class="mt-2 text-sm text-gray-600">
               Ketik minimal 2 karakter untuk mencari pasien, atau isi NIK
               secara manual
            </p>
            <div v-if="form.errors.nik" class="mt-2 text-sm text-red-500">
               {{ form.errors.nik }}
            </div>
         </div>

         <!-- Drop Zone -->
         <div
            v-if="!imagePreview"
            @dragover.prevent="isDragging = true"
            @dragleave.prevent="isDragging = false"
            @drop.prevent="handleDrop"
            @click="openFileDialog"
            :class="[
               'cursor-pointer rounded-lg border-4 border-dashed p-12 text-center transition-colors',
               isDragging
                  ? 'border-blue-500 bg-blue-50'
                  : 'border-gray-300 hover:border-gray-400',
            ]"
         >
            <svg
               class="mx-auto mb-4 h-16 w-16 text-gray-400"
               fill="none"
               stroke="currentColor"
               viewBox="0 0 24 24"
            >
               <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"
               />
            </svg>
            <p class="text-gray-500">
               Drag & Drop your chest X-ray images here
            </p>
            <p class="mt-2 text-gray-400">or click to select files</p>
            <input
               ref="fileInputRef"
               type="file"
               accept="image/*"
               class="hidden"
               @change="handleFileSelect"
            />
         </div>

         <!-- Image Preview -->
         <div v-else class="rounded-lg border-2 border-gray-300 p-6">
            <div class="mb-4 flex w-full justify-end">
               <button
                  type="button"
                  @click="resetForm"
                  class="rounded-lg bg-red-500 px-4 py-2 text-white transition-colors hover:bg-red-600"
               >
                  Remove
               </button>
            </div>
            <div class="flex justify-center">
               <img
                  :src="imagePreview"
                  alt="X-ray preview"
                  class="max-h-96 rounded-lg shadow-lg"
               />
            </div>
            <p class="mt-4 text-center text-gray-600">
               {{ form.image?.name }}
            </p>
         </div>

         <!-- Error Display -->
         <div v-if="form.errors.image" class="mt-4 text-sm text-red-500">
            {{ form.errors.image }}
         </div>

         <!-- Analyze Button -->
         <button
            v-if="!diagnosisResult"
            @click="handleSubmit"
            :disabled="!form.image || isAnalyzing"
            class="mt-6 w-full rounded-lg bg-blue-600 px-6 py-3 text-white transition-colors hover:bg-blue-700 disabled:cursor-not-allowed disabled:bg-blue-300"
         >
            {{ isAnalyzing ? 'Analyzing...' : 'Analyze' }}
         </button>

         <!-- Loading Indicator -->
         <div v-if="isAnalyzing" class="mt-6 text-center">
            <div
               class="inline-block h-8 w-8 animate-spin rounded-full border-4 border-solid border-blue-600 border-r-transparent"
            ></div>
            <p class="mt-2 text-gray-500">Analyzing image, please wait...</p>
         </div>

         <!-- Diagnosis Result -->
         <DiagnosisResult
            v-if="diagnosisResult && !isAnalyzing"
            :result="diagnosisResult"
         />

         <!-- ChatBot - Appears after diagnosis -->
         <div v-if="diagnosisResult && !isAnalyzing" class="mt-8">
            <ChatBot :diagnosisResult="diagnosisResult" />
         </div>

         <!-- Action Buttons -->
         <div
            v-if="diagnosisResult && !form.processing"
            class="mt-6 flex items-center justify-center gap-4"
         >
            <button
               @click="saveResult"
               :disabled="form.processing"
               class="rounded-lg bg-green-500 px-6 py-2 text-white transition-colors hover:bg-green-600 disabled:cursor-not-allowed disabled:bg-green-300"
               type="button"
            >
               {{ form.processing ? 'Saving...' : 'Save Result' }}
            </button>
            <button
               @click="resetForm"
               class="rounded-lg bg-red-500 px-6 py-2 text-white transition-colors hover:bg-red-600"
               type="button"
            >
               New Diagnosis
            </button>
         </div>
      </div>
   </AppLocalLayout>
</template>

<script lang="ts" setup>
import AppLocalLayout from '@/layouts/AppLocalLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import { computed, onMounted, onUnmounted, ref } from 'vue';
import DiagnosisResult from './components/DiagnosisResult.vue';
import ChatBot from '@/components/ChatBot.vue';

interface ClinicalExplanation {
   ringkasan_diagnosis: string;
   penjelasan_klinis: string;
   temuan_radiologis: string[];
   rekomendasi_tindakan: string[];
   catatan_penting: string;
   follow_up: string;
}

interface DiagnosisResponse {
   success: boolean;
   prediction: string;
   confidence: number;
   all_probabilities: Record<string, number>;
   clinical_explanation?: ClinicalExplanation;
   processing_time_seconds: number;
   model_info: {
      type: string;
      device: string;
      llm_provider: string;
   };
   timestamp: string;
}

const page = usePage();
const user = computed(() => page.props.auth.user);

// Check user role
const isPasien = computed(() => user.value.role_names?.includes('Pasien'));
const isFasyankes = computed(() =>
   user.value.role_names?.includes('Fasyankes'),
);

// Patient search states for Fasyankes
const searchResults = ref<any[]>([]);
const showDropdown = ref(false);
const isSearching = ref(false);

// Menggunakan useForm dari Inertia
const form = useForm({
   nik: isPasien.value ? user.value.profile?.nik || '' : '',
   image: null as File | null,
   diagnosis: null as DiagnosisResponse | null,
});

const fileInputRef = ref<HTMLInputElement | null>(null);
const imagePreview = ref<string | null>(null);
const isDragging = ref(false);
const isAnalyzing = ref(false);
const diagnosisResult = ref<DiagnosisResponse | null>(null);

// Patient search functions for Fasyankes
const searchPatients = async () => {
   if (!form.nik || form.nik.length < 2) {
      searchResults.value = [];
      return;
   }

   isSearching.value = true;
   showDropdown.value = true;

   try {
      console.log('Searching for:', form.nik);
      const response = await fetch(
         `/search-patients?search=${encodeURIComponent(form.nik)}`,
      );

      if (!response.ok) {
         throw new Error(`HTTP error! status: ${response.status}`);
      }

      const data = await response.json();
      console.log('Search results:', data);
      searchResults.value = data;
   } catch (error) {
      console.error('Error searching patients:', error);
      searchResults.value = [];
   } finally {
      isSearching.value = false;
   }
};

const selectPatient = (patient: any) => {
   form.nik = patient.nik || '';
   showDropdown.value = false;
   searchResults.value = [patient];
};

// Close dropdown when clicking outside
const handleClickOutside = (e: MouseEvent) => {
   const target = e.target as HTMLElement;
   // Check if click is outside the NIK input and dropdown container
   if (!target.closest('.nik-search-container')) {
      showDropdown.value = false;
   }
};

// Setup event listeners
onMounted(() => {
   if (typeof window !== 'undefined') {
      window.addEventListener('click', handleClickOutside);
   }
});

onUnmounted(() => {
   if (typeof window !== 'undefined') {
      window.removeEventListener('click', handleClickOutside);
   }
});

const handleDrop = (e: DragEvent) => {
   isDragging.value = false;
   const files = e.dataTransfer?.files;
   if (files?.[0]) handleFile(files[0]);
};

const handleFileSelect = (e: Event) => {
   const target = e.target as HTMLInputElement;
   const file = target.files?.[0];
   if (file) handleFile(file);
};

const handleFile = (file: File) => {
   if (!file.type.startsWith('image/')) {
      Swal.fire({
         icon: 'error',
         title: 'Invalid File',
         text: 'Please select an image file',
      });
      return;
   }

   form.image = file;

   // Create preview
   const reader = new FileReader();
   reader.onload = (e) => {
      imagePreview.value = e.target?.result as string;
   };
   reader.readAsDataURL(file);
};

const resetForm = () => {
   form.reset();
   // Reset NIK kembali ke nilai awal berdasarkan role
   form.nik = isPasien.value ? user.value.profile?.nik || '' : '';
   imagePreview.value = null;
   diagnosisResult.value = null;
   searchResults.value = [];
   showDropdown.value = false;
   if (fileInputRef.value) {
      fileInputRef.value.value = '';
   }
};

const openFileDialog = () => {
   fileInputRef.value?.click();
};

const handleSubmit = async () => {
   if (!form.image) return;

   const formData = new FormData();
   formData.append('file', form.image);

   try {
      isAnalyzing.value = true;
      const response = await fetch('http://localhost:5000/predict', {
         method: 'POST',
         body: formData,
      });

      const data: DiagnosisResponse = await response.json();
      console.log(data);
      if (data.success) {
         diagnosisResult.value = data;
         form.diagnosis = data;
      } else {
         throw new Error('Diagnosis failed');
      }
   } catch (error) {
      console.error('Analysis error:', error);
      Swal.fire({
         icon: 'error',
         title: 'Analysis Failed',
         text: 'Failed to analyze the image. Please try again.',
      });
   } finally {
      isAnalyzing.value = false;
   }
};

const saveResult = async () => {
   const result = await Swal.fire({
      title: 'Save Diagnosis Result',
      text: 'Are you sure you want to save this diagnosis result?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Yes, save it!',
      cancelButtonText: 'Cancel',
   });

   if (result.isConfirmed) {
      form.post('/ai-cxr-diagnose', {
         preserveScroll: true,
         onSuccess: () => {
            Swal.fire({
               icon: 'success',
               title: 'Success',
               text: 'Diagnosis result saved successfully.',
            });
            resetForm();
         },
         onError: () => {
            Swal.fire({
               icon: 'error',
               title: 'Error',
               text: 'Failed to save diagnosis result.',
            });
         },
      });
   }
};
</script>
