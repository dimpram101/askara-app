<template>
   <div class="mt-8">
      <h2 class="mb-4 text-2xl font-bold">Diagnosis Result</h2>

      <div class="space-y-4 rounded-lg bg-gray-50 p-6">
         <!-- Prediction -->
         <div class="rounded-lg bg-white p-4 shadow-sm">
            <strong class="text-gray-700">Prediction:</strong>
            <span class="ml-2 text-lg font-semibold text-blue-600">
               {{ result.prediction }}
            </span>
            <span class="ml-2 text-sm text-gray-500">
               (Confidence: {{ result.confidence }}%)
            </span>
         </div>

         <!-- Processing Time -->
         <div class="rounded-lg bg-white p-4 shadow-sm">
            <strong class="text-gray-700">Processing Time:</strong>
            <span class="ml-2">{{ result.processing_time_seconds }} seconds</span>
         </div>

         <!-- Clinical Explanation -->
         <div v-if="result.clinical_explanation" class="rounded-lg bg-white p-6 shadow-sm">
            <h3 class="mb-4 text-xl font-semibold text-gray-800">
               Clinical Explanation
            </h3>

            <!-- Summary -->
            <div class="mb-4">
               <strong class="text-gray-700">Summary:</strong>
               <p class="mt-1 text-gray-600">
                  {{ result.clinical_explanation.ringkasan_diagnosis }}
               </p>
            </div>

            <!-- Clinical Explanation -->
            <div class="mb-4">
               <strong class="text-gray-700">Clinical Explanation:</strong>
               <p class="mt-1 text-gray-600">
                  {{ result.clinical_explanation.penjelasan_klinis }}
               </p>
            </div>

            <!-- Radiological Findings -->
            <div class="mb-4">
               <strong class="text-gray-700">Radiological Findings:</strong>
               <ul class="mt-2 list-inside list-disc space-y-1 text-gray-600">
                  <li
                     v-for="(finding, index) in result.clinical_explanation.temuan_radiologis"
                     :key="index"
                  >
                     {{ finding }}
                  </li>
               </ul>
            </div>

            <!-- Recommended Actions -->
            <div class="mb-4">
               <strong class="text-gray-700">Recommended Actions:</strong>
               <ul class="mt-2 list-inside list-disc space-y-1 text-gray-600">
                  <li
                     v-for="(recommendation, index) in result.clinical_explanation.rekomendasi_tindakan"
                     :key="index"
                  >
                     {{ recommendation }}
                  </li>
               </ul>
            </div>

            <!-- Important Notes (if available) -->
            <div v-if="result.clinical_explanation.catatan_penting" class="mb-4">
               <strong class="text-gray-700">Important Notes:</strong>
               <p class="mt-1 text-gray-600">
                  {{ result.clinical_explanation.catatan_penting }}
               </p>
            </div>

            <!-- Follow Up (if available) -->
            <div v-if="result.clinical_explanation.follow_up" class="mb-4">
               <strong class="text-gray-700">Follow Up:</strong>
               <p class="mt-1 text-gray-600">
                  {{ result.clinical_explanation.follow_up }}
               </p>
            </div>
         </div>

         <!-- AI Disclaimer -->
         <div class="rounded-lg border-2 border-yellow-200 bg-yellow-50 p-4">
            <p class="text-sm italic text-gray-700">
               <code class="font-bold text-red-500">*</code>
               Data yang ditampilkan merupakan hasil analisis AI dan dapat
               mengandung ketidaktepatan. Silakan gunakan sebagai referensi,
               bukan sebagai acuan utama.
            </p>
         </div>
      </div>
   </div>
</template>

<script lang="ts" setup>
interface ClinicalExplanation {
   ringkasan_diagnosis: string;
   penjelasan_klinis: string;
   temuan_radiologis: string[];
   rekomendasi_tindakan: string[];
   catatan_penting?: string;
   follow_up?: string;
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

interface Props {
   result: DiagnosisResponse;
}

defineProps<Props>();
</script>
