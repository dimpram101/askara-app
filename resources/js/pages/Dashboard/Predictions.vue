<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import {
   Dialog,
   DialogContent,
   DialogDescription,
   DialogHeader,
   DialogTitle,
} from '@/components/ui/dialog';

import { Badge } from '@/components/ui/badge';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import {
   ActivitySquare,
   ChevronLeft,
   ChevronRight,
   Eye,
   FileText,
} from 'lucide-vue-next';
import { ref } from 'vue';

interface Prediction {
   id: number;
   nik: string;
   user: {
      id: number;
      name: string;
      email: string;
   } | null;
   predicted_class: string;
   confidence_score: number;
   processing_time: string;
   summary: string | null;
   clinical_explanation: string | null;
   radiological_findings: string | null;
   recommended_actions: string | null;
   important_notes: string | null;
   follow_up_suggestions: string | null;
   all_probabilities: Record<string, number> | null;
   model_metadata: Record<string, any> | null;
   predicted_at: string | null;
   created_at: string;
   image_url: string;
}

interface PaginatedPredictions {
   data: Prediction[];
   current_page: number;
   last_page: number;
   per_page: number;
   total: number;
   links: Array<{
      url: string | null;
      label: string;
      active: boolean;
   }>;
}

interface Props {
   predictions: PaginatedPredictions;
}

defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
   {
      title: 'Dashboard',
      href: '/dashboard',
   },
   {
      title: 'Predictions',
      href: '/dashboard/predictions',
   },
];

// Dialog States
const showDetailDialog = ref(false);
const selectedPrediction = ref<Prediction | null>(null);

// Actions
const openDetailDialog = (prediction: Prediction) => {
   selectedPrediction.value = prediction;
   showDetailDialog.value = true;
};

const getPredictionBadgeClass = (predictedClass: string) => {
   switch (predictedClass.toLowerCase()) {
      case 'normal':
         return 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300';
      case 'tb':
      case 'tuberculosis':
         return 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';
      case 'pneumonia':
         return 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300';
      case 'covid-19':
      case 'covid':
         return 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300';
      default:
         return 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300';
   }
};

const getConfidenceColor = (score: number) => {
   if (score >= 80) return 'text-green-600 dark:text-green-400';
   if (score >= 60) return 'text-yellow-600 dark:text-yellow-400';
   return 'text-red-600 dark:text-red-400';
};

const goToPage = (url: string | null) => {
   if (url) {
      router.get(url, {}, { preserveState: true });
   }
};
</script>

<template>
   <Head title="Prediction History - Fasyankes" />

   <AppLayout :breadcrumbs="breadcrumbs">
      <div class="space-y-6 p-6">
         <!-- Header -->
         <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
               <div
                  class="flex h-12 w-12 items-center justify-center rounded-lg bg-primary/10"
               >
                  <ActivitySquare class="h-6 w-6 text-primary" />
               </div>
               <div>
                  <h1 class="text-2xl font-bold tracking-tight">
                     Prediction History
                  </h1>
                  <p class="text-sm text-muted-foreground">
                     View all CXR AI diagnosis predictions
                  </p>
               </div>
            </div>
         </div>

         <!-- Stats Cards -->
         <div class="grid gap-4 md:grid-cols-3">
            <Card>
               <CardHeader class="pb-3">
                  <CardTitle class="text-sm font-medium">
                     Total Predictions
                  </CardTitle>
               </CardHeader>
               <CardContent>
                  <div class="text-2xl font-bold">
                     {{ predictions.total }}
                  </div>
               </CardContent>
            </Card>
            <Card>
               <CardHeader class="pb-3">
                  <CardTitle class="text-sm font-medium">
                     Current Page
                  </CardTitle>
               </CardHeader>
               <CardContent>
                  <div class="text-2xl font-bold">
                     {{ predictions.current_page }} / {{ predictions.last_page }}
                  </div>
               </CardContent>
            </Card>
            <Card>
               <CardHeader class="pb-3">
                  <CardTitle class="text-sm font-medium">
                     Per Page
                  </CardTitle>
               </CardHeader>
               <CardContent>
                  <div class="text-2xl font-bold">
                     {{ predictions.per_page }}
                  </div>
               </CardContent>
            </Card>
         </div>

         <!-- Predictions Table -->
         <Card>
            <CardHeader>
               <CardTitle>All Predictions</CardTitle>
            </CardHeader>
            <CardContent>
               <div class="overflow-x-auto">
                  <table class="w-full">
                     <thead>
                        <tr class="border-b">
                           <th class="px-4 py-3 text-left text-sm font-medium">NIK</th>
                           <th class="px-4 py-3 text-left text-sm font-medium">Patient</th>
                           <th class="px-4 py-3 text-left text-sm font-medium">Diagnosis</th>
                           <th class="px-4 py-3 text-left text-sm font-medium">Confidence</th>
                           <th class="px-4 py-3 text-left text-sm font-medium">Predicted At</th>
                           <th class="px-4 py-3 text-right text-sm font-medium">Actions</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr
                           v-for="prediction in predictions.data"
                           :key="prediction.id"
                           class="border-b last:border-0 hover:bg-muted/50"
                        >
                           <td class="px-4 py-3 font-medium">
                              {{ prediction.nik }}
                           </td>
                           <td class="px-4 py-3">
                              <div v-if="prediction.user">
                                 <div class="font-medium">
                                    {{ prediction.user.name }}
                                 </div>
                                 <div
                                    class="text-sm text-muted-foreground"
                                 >
                                    {{ prediction.user.email }}
                                 </div>
                              </div>
                              <span v-else class="text-muted-foreground">
                                 No user
                              </span>
                           </td>
                           <td class="px-4 py-3">
                              <Badge
                                 :class="
                                    getPredictionBadgeClass(
                                       prediction.predicted_class,
                                    )
                                 "
                              >
                                 {{ prediction.predicted_class }}
                              </Badge>
                           </td>
                           <td class="px-4 py-3">
                              <span
                                 :class="
                                    getConfidenceColor(
                                       prediction.confidence_score,
                                    )
                                 "
                                 class="font-semibold"
                              >
                                 {{ prediction.confidence_score }}%
                              </span>
                           </td>
                           <td class="px-4 py-3">
                              <div class="text-sm">
                                 {{
                                    prediction.predicted_at ||
                                    prediction.created_at
                                 }}
                              </div>
                              <div
                                 class="text-xs text-muted-foreground"
                              >
                                 {{ prediction.processing_time }}
                              </div>
                           </td>
                           <td class="px-4 py-3 text-right">
                              <Button
                                 @click="openDetailDialog(prediction)"
                                 variant="ghost"
                                 size="sm"
                                 class="gap-2"
                              >
                                 <Eye class="h-4 w-4" />
                                 View
                              </Button>
                           </td>
                        </tr>
                        <tr v-if="predictions.data.length === 0">
                           <td
                              colspan="6"
                              class="px-4 py-8 text-center text-muted-foreground"
                           >
                              No predictions found
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>

               <!-- Pagination -->
               <div
                  v-if="predictions.last_page > 1"
                  class="mt-4 flex items-center justify-between"
               >
                  <div class="text-sm text-muted-foreground">
                     Showing {{ (predictions.current_page - 1) * predictions.per_page + 1 }}
                     to
                     {{
                        Math.min(
                           predictions.current_page * predictions.per_page,
                           predictions.total,
                        )
                     }}
                     of {{ predictions.total }} results
                  </div>
                  <div class="flex gap-2">
                     <Button
                        @click="
                           goToPage(
                              predictions.links[predictions.current_page - 1]
                                 ?.url,
                           )
                        "
                        :disabled="predictions.current_page === 1"
                        variant="outline"
                        size="sm"
                     >
                        <ChevronLeft class="h-4 w-4" />
                        Previous
                     </Button>
                     <Button
                        @click="
                           goToPage(
                              predictions.links[predictions.current_page + 1]
                                 ?.url,
                           )
                        "
                        :disabled="
                           predictions.current_page === predictions.last_page
                        "
                        variant="outline"
                        size="sm"
                     >
                        Next
                        <ChevronRight class="h-4 w-4" />
                     </Button>
                  </div>
               </div>
            </CardContent>
         </Card>
      </div>

      <!-- Detail Dialog -->
      <Dialog v-model:open="showDetailDialog">
         <DialogContent class="sm:max-w-3xl max-h-[90vh] overflow-y-auto">
            <DialogHeader>
               <DialogTitle class="flex items-center gap-2">
                  <FileText class="h-5 w-5" />
                  Prediction Details
               </DialogTitle>
               <DialogDescription>
                  Complete diagnostic information for this prediction
               </DialogDescription>
            </DialogHeader>

            <div v-if="selectedPrediction" class="space-y-6">
               <!-- Patient Info -->
               <div class="space-y-2">
                  <h3 class="font-semibold text-lg">Patient Information</h3>
                  <div class="grid grid-cols-2 gap-4 rounded-lg border p-4">
                     <div>
                        <p class="text-sm text-muted-foreground">NIK</p>
                        <p class="font-medium">
                           {{ selectedPrediction.nik }}
                        </p>
                     </div>
                     <div v-if="selectedPrediction.user">
                        <p class="text-sm text-muted-foreground">Name</p>
                        <p class="font-medium">
                           {{ selectedPrediction.user.name }}
                        </p>
                     </div>
                     <div v-if="selectedPrediction.user">
                        <p class="text-sm text-muted-foreground">Email</p>
                        <p class="font-medium">
                           {{ selectedPrediction.user.email }}
                        </p>
                     </div>
                     <div>
                        <p class="text-sm text-muted-foreground">
                           Prediction Date
                        </p>
                        <p class="font-medium">
                           {{
                              selectedPrediction.predicted_at ||
                              selectedPrediction.created_at
                           }}
                        </p>
                     </div>
                  </div>
               </div>

               <!-- X-Ray Image -->
               <div v-if="selectedPrediction.image_url" class="space-y-2">
                  <h3 class="font-semibold text-lg">Chest X-Ray Image</h3>
                  <div class="rounded-lg border overflow-hidden">
                     <img
                        :src="selectedPrediction.image_url"
                        alt="Chest X-Ray"
                        class="w-full h-auto"
                     />
                  </div>
               </div>

               <!-- Diagnosis Result -->
               <div class="space-y-2">
                  <h3 class="font-semibold text-lg">Diagnosis Result</h3>
                  <div class="rounded-lg border p-4 space-y-3">
                     <div class="flex items-center justify-between">
                        <span class="text-sm text-muted-foreground">
                           Predicted Class
                        </span>
                        <Badge
                           :class="
                              getPredictionBadgeClass(
                                 selectedPrediction.predicted_class,
                              )
                           "
                        >
                           {{ selectedPrediction.predicted_class }}
                        </Badge>
                     </div>
                     <div class="flex items-center justify-between">
                        <span class="text-sm text-muted-foreground">
                           Confidence Score
                        </span>
                        <span
                           :class="
                              getConfidenceColor(
                                 selectedPrediction.confidence_score,
                              )
                           "
                           class="font-bold text-lg"
                        >
                           {{ selectedPrediction.confidence_score }}%
                        </span>
                     </div>
                     <div class="flex items-center justify-between">
                        <span class="text-sm text-muted-foreground">
                           Processing Time
                        </span>
                        <span class="font-medium">
                           {{ selectedPrediction.processing_time }}
                        </span>
                     </div>
                  </div>
               </div>

               <!-- Clinical Information -->
               <div v-if="selectedPrediction.summary" class="space-y-2">
                  <h3 class="font-semibold text-lg">Summary</h3>
                  <div class="rounded-lg border p-4 text-sm">
                     {{ selectedPrediction.summary }}
                  </div>
               </div>

               <div
                  v-if="selectedPrediction.clinical_explanation"
                  class="space-y-2"
               >
                  <h3 class="font-semibold text-lg">Clinical Explanation</h3>
                  <div class="rounded-lg border p-4 text-sm">
                     {{ selectedPrediction.clinical_explanation }}
                  </div>
               </div>

               <div
                  v-if="selectedPrediction.radiological_findings"
                  class="space-y-2"
               >
                  <h3 class="font-semibold text-lg">Radiological Findings</h3>
                  <div class="rounded-lg border p-4 text-sm whitespace-pre-line">
                     • {{ selectedPrediction.radiological_findings }}
                  </div>
               </div>

               <div
                  v-if="selectedPrediction.recommended_actions"
                  class="space-y-2"
               >
                  <h3 class="font-semibold text-lg">Recommended Actions</h3>
                  <div class="rounded-lg border p-4 text-sm whitespace-pre-line">
                     • {{ selectedPrediction.recommended_actions }}
                  </div>
               </div>

               <div
                  v-if="selectedPrediction.important_notes"
                  class="space-y-2"
               >
                  <h3 class="font-semibold text-lg">Important Notes</h3>
                  <div class="rounded-lg border p-4 text-sm bg-yellow-50 dark:bg-yellow-950">
                     {{ selectedPrediction.important_notes }}
                  </div>
               </div>

               <div
                  v-if="selectedPrediction.follow_up_suggestions"
                  class="space-y-2"
               >
                  <h3 class="font-semibold text-lg">Follow-up Suggestions</h3>
                  <div class="rounded-lg border p-4 text-sm">
                     {{ selectedPrediction.follow_up_suggestions }}
                  </div>
               </div>

               <!-- All Probabilities -->
               <div
                  v-if="selectedPrediction.all_probabilities"
                  class="space-y-2"
               >
                  <h3 class="font-semibold text-lg">All Probabilities</h3>
                  <div class="rounded-lg border p-4 space-y-3">
                     <div
                        v-for="(prob, className) in selectedPrediction.all_probabilities"
                        :key="className"
                        class="space-y-1"
                     >
                        <div class="flex items-center justify-between text-sm">
                           <span>{{ className.replace(/_/g, ' ') }}</span>
                           <span class="font-medium">{{ prob }}%</span>
                        </div>
                        <div class="h-2 bg-muted rounded-full overflow-hidden">
                           <div
                              class="h-full bg-primary transition-all"
                              :style="{ width: prob + '%' }"
                           ></div>
                        </div>
                     </div>
                  </div>
               </div>

               <!-- Model Metadata -->
               <div
                  v-if="selectedPrediction.model_metadata"
                  class="space-y-2"
               >
                  <h3 class="font-semibold text-lg">Model Information</h3>
                  <div class="rounded-lg border p-4 space-y-2">
                     <div
                        v-for="(value, key) in selectedPrediction.model_metadata"
                        :key="key"
                        class="flex items-center justify-between text-sm"
                     >
                        <span class="text-muted-foreground capitalize">{{ key.replace(/_/g, ' ') }}</span>
                        <span class="font-medium">{{ value }}</span>
                     </div>
                  </div>
               </div>
            </div>
         </DialogContent>
      </Dialog>
   </AppLayout>
</template>
