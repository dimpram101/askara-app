<template>
   <Head title="AI Diagnose" />

   <AppLocalLayout>
      <div class="">
         <!-- Header with Filters -->
         <div class="container mx-auto px-8 py-4 xl:px-4">
            <div class="grid grid-cols-3 items-center gap-x-8">
               <div class="flex items-center space-x-2">
                  <select
                     v-model="selectedYear"
                     class="order w-full rounded-lg border border-gray-300 px-2 py-2 focus:border-transparent focus:ring-2 focus:ring-blue-500"
                  >
                     <option value="2025">2025</option>
                     <option value="2024">2024</option>
                     <option value="2023">2023</option>
                  </select>
               </div>
               <div class="flex items-center space-x-2">
                  <select
                     v-model="selectedProvince"
                     class="w-full rounded-lg border border-gray-300 px-2 py-2 focus:border-transparent focus:ring-2 focus:ring-blue-500"
                  >
                     <option value="all">Province (All)</option>
                     <option value="jakarta">DKI Jakarta</option>
                     <option value="jabar">Jawa Barat</option>
                     <option value="jateng">Jawa Tengah</option>
                     <option value="jatim">Jawa Timur</option>
                     <option value="sumut">Sumatera Utara</option>
                  </select>
               </div>

               <div class="flex items-center space-x-2">
                  <select
                     v-model="selectedCity"
                     class="w-full rounded-lg border border-gray-300 px-2 py-2 focus:border-transparent focus:ring-2 focus:ring-blue-500"
                  >
                     <option value="all">Kab/Kota (All)</option>
                     <option value="jakarta-pusat">Jakarta Pusat</option>
                     <option value="jakarta-utara">Jakarta Utara</option>
                     <option value="bandung">Bandung</option>
                     <option value="surabaya">Surabaya</option>
                  </select>
               </div>
            </div>
         </div>

         <!-- Main Content -->
         <div class="container mx-auto px-8 pb-8 xl:px-4">
            <div class="grid grid-cols-1 gap-x-8 gap-y-4 xl:grid-cols-3">
               <!-- Statistics Cards -->
               <!-- New Patients Card -->
               <div
                  class="overflow-hidden rounded-lg bg-[#8fa4c1] text-white shadow-lg"
               >
                  <div class="p-6">
                     <div class="mb-2 flex items-center justify-between">
                        <h3 class="text-sm font-medium opacity-90">
                           NEW PATIENTS
                        </h3>
                        <!-- <Icon name="heroicons:user-plus" class="h-6 w-6" /> -->
                     </div>
                     <div class="mb-2">
                        <span class="text-3xl font-bold">{{
                           formatNumber(statistics.newPatients)
                        }}</span>
                     </div>
                     <div class="text-sm">
                        <span class=""
                           >+{{ statistics.newPatientsGrowth }}%</span
                        >
                        from Last Year
                     </div>
                  </div>
               </div>

               <!-- Loss to Follow Up Card -->
               <div
                  class="overflow-hidden rounded-lg bg-[#8fa4c1] text-white shadow-lg"
               >
                  <div class="p-6">
                     <div class="mb-2 flex items-center justify-between">
                        <h3 class="text-sm font-medium opacity-90">
                           LOSS TO FOLLOW UP
                        </h3>
                        <!-- <Icon
                        name="heroicons:exclamation-triangle"
                        class="h-6 w-6"
                     /> -->
                     </div>
                     <div class="mb-2">
                        <span class="text-3xl font-bold">{{
                           formatNumber(statistics.lossToFollowUp)
                        }}</span>
                     </div>
                     <div class="text-sm">
                        <span class=""
                           >{{ statistics.lossToFollowUpGrowth > 0 ? '+' : ''
                           }}{{ statistics.lossToFollowUpGrowth }}%</span
                        >
                        from Last Year
                     </div>
                  </div>
               </div>

               <!-- Recovered Patients Card -->
               <div
                  class="overflow-hidden rounded-lg bg-[#8fa4c1] text-white shadow-lg"
               >
                  <div class="p-6">
                     <div class="mb-2 flex items-center justify-between">
                        <h3 class="text-sm font-medium opacity-90">
                           RECOVERED PATIENTS
                        </h3>
                        <!-- <Icon name="heroicons:heart" class="h-6 w-6" /> -->
                     </div>
                     <div class="mb-2">
                        <span class="text-3xl font-bold">{{
                           formatNumber(statistics.recoveredPatients)
                        }}</span>
                     </div>
                     <div class="text-sm">
                        <span class=""
                           >+{{ statistics.recoveredPatientsGrowth }}%</span
                        >
                        from Last Year
                     </div>
                  </div>
               </div>

               <!-- Additional Stats -->
               <!-- <div class="rounded-lg bg-white shadow-lg">
            <div class="p-6">
              <h3 class="mb-4 text-lg font-semibold text-gray-800">Treatment Success Rate</h3>
              <div class="space-y-4">
                <div>
                  <div class="mb-1 flex justify-between text-sm">
                    <span>Overall Success Rate</span>
                    <span class="font-medium">{{ statistics.successRate }}%</span>
                  </div>
                  <div class="h-2 w-full rounded-full bg-gray-200">
                    <div
                      class="h-2 rounded-full bg-green-500 transition-all duration-300"
                      :style="`width: ${statistics.successRate}%`"
                    ></div>
                  </div>
                </div>

                <div class="border-t pt-4">
                  <div class="space-y-2 text-sm text-gray-600">
                    <div class="flex justify-between">
                      <span>Active Cases</span>
                      <span class="font-medium">{{ formatNumber(statistics.activeCases) }}</span>
                    </div>
                    <div class="flex justify-between">
                      <span>Completed Treatment</span>
                      <span class="font-medium">{{
                        formatNumber(statistics.completedTreatment)
                      }}</span>
                    </div>
                    <div class="flex justify-between">
                      <span>Under Treatment</span>
                      <span class="font-medium">{{ formatNumber(statistics.underTreatment) }}</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div> -->

               <div class="mt-4 flex justify-center">
                  <div class="flex items-center space-x-2">
                     <label class="text-sm font-medium text-gray-700"
                        >Display Metric:</label
                     >
                     <select
                        v-model="selectedMetric"
                        class="w-64 rounded-lg border border-gray-300 px-3 py-2 focus:border-transparent focus:ring-2 focus:ring-blue-500"
                        @change="updateMapData"
                     >
                        <option value="cases">Kasus</option>
                        <option value="cured">Sembuh</option>
                        <option value="mortality_rate">Mortality Rate</option>
                        <option value="incident_rate">Incident Rate</option>
                     </select>
                  </div>
               </div>
               <!-- Map Section -->
               <div class="relative xl:col-span-3">
                  <div class="overflow-hidden rounded-lg bg-white shadow-lg">
                     <div class="p-2">
                        <div id="map" class="h-96 w-full rounded-lg"></div>
                        <!-- Loading overlay -->
                        <transition name="fade">
                           <div
                              v-if="isMapLoading"
                              class="bg-opacity-70 absolute inset-0 z-20 flex items-center justify-center bg-white"
                           >
                              <div class="flex flex-col items-center">
                                 <svg
                                    class="mb-2 h-10 w-10 animate-spin text-blue-500"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                 >
                                    <circle
                                       class="opacity-25"
                                       cx="12"
                                       cy="12"
                                       r="10"
                                       stroke="currentColor"
                                       stroke-width="4"
                                    ></circle>
                                    <path
                                       class="opacity-75"
                                       fill="currentColor"
                                       d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                                    ></path>
                                 </svg>
                                 <span class="font-medium text-blue-700"
                                    >Loading map data...</span
                                 >
                              </div>
                           </div>
                        </transition>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </AppLocalLayout>
</template>

<script setup lang="ts">
import AppLocalLayout from '@/layouts/AppLocalLayout.vue';
import { Head } from '@inertiajs/vue3';
import { nextTick, onMounted, ref, watch } from 'vue';

// Reactive data
const selectedYear = ref('2023');
const selectedProvince = ref('all');
const selectedCity = ref('all');
const selectedMetric = ref('cases');

// Loading state for map
const isMapLoading = ref(false);

// Statistics data - will be updated from API
const statistics = ref({
   newPatients: 0,
   newPatientsGrowth: 15,
   lossToFollowUp: 0,
   lossToFollowUpGrowth: -8,
   recoveredPatients: 0,
   recoveredPatientsGrowth: 23,
   successRate: 78,
   activeCases: 125430,
   completedTreatment: 89560,
   underTreatment: 35870,
});

// Update statistics from API data
const updateStatistics = () => {
   const indonesiaData = apiData.value.find(
      (item) => item.province === 'INDONESIA',
   );
   if (indonesiaData) {
      statistics.value.newPatients = indonesiaData.cases;
      statistics.value.lossToFollowUp = indonesiaData.loss_to_follow_up;
      statistics.value.recoveredPatients = indonesiaData.cured;
   }
};

// Map instance
let map = null;
let currentGeoJSONLayer = null;
let currentLegend = null;
let hotspotMarkers = [];

// Reactive data from API
const apiData = ref([]);
const provinceData = ref({});

// Fetch data from API
const fetchTBData = async () => {
   isMapLoading.value = true;
   try {
      const response = await fetch(`/pengobatan_so_2023`);
      const result = await response.json();
      if (result) {
         apiData.value = result;
         processProvinceData();
      }
   } catch (error) {
      console.error('Error fetching TB data:', error);
      // Fallback to dummy data if API fails
      loadFallbackData();
   } finally {
      isMapLoading.value = false;
   }
};

// Process API data into provinceData format
const processProvinceData = () => {
   const processed = {};

   apiData.value.forEach((item) => {
      if (item.province !== 'INDONESIA') {
         // Skip Indonesia total row
         processed[item.province] = {
            cases: item.cases,
            cured: item.cured,
            mortality_rate: item.mortality_rate,
            incident_rate: item.incident_rate,
            population: item.population,
            deaths: item.deaths,
            success_rate: item.success_rate,
            loss_to_follow_up: item.loss_to_follow_up,
            hotspot_average_quadran: item.hotspot_average_quadran,
         };
      }
   });

   provinceData.value = processed;
   updateStatistics(); // Update statistics cards

   console.log(map, currentGeoJSONLayer);
   // If map is already initialized but no choropleth layer, reload it
   if (map && !currentGeoJSONLayer) {
      setTimeout(async () => {
         await loadIndonesiaChoropleth();
         updateLegend();

         setTimeout(() => {
            map.invalidateSize(true);
         }, 300);
      }, 100);
   }
};

// Fallback data if API fails
const loadFallbackData = () => {
   provinceData.value = {
      ACEH: {
         cases: 10933,
         cured: 1320,
         mortality_rate: 6,
         incident_rate: 242,
      },
      'SUMATERA UTARA': {
         cases: 34981,
         cured: 6787,
         mortality_rate: 8,
         incident_rate: 79,
      },
      'SUMATERA BARAT': {
         cases: 13173,
         cured: 3546,
         mortality_rate: 10,
         incident_rate: 157,
      },
      // Add more fallback data as needed...
   };
};

// Get metric value for a province
const getMetricValue = (provinceName, metric) => {
   const normalizedName = normalizeProvinceName(provinceName);
   const data = normalizedName ? provinceData.value[normalizedName] : null;

   if (!data) return null;
   return data[metric] || 0;
};

// Get color ranges based on selected metric
const getMetricRanges = (metric) => {
   const allValues = Object.values(provinceData.value)
      .map((data) => data[metric])
      .filter((val) => val != null && val > 0);

   if (allValues.length === 0) return { min: 0, max: 100 };

   const min = Math.min(...allValues);
   const max = Math.max(...allValues);

   return { min, max, values: allValues };
};

// Get color based on metric value
const getColorByMetric = (provinceName, metric) => {
   const value = getMetricValue(provinceName, metric);
   if (value === null || value === 0) {
      return '#f3f4f6'; // Gray for no data
   }

   const ranges = getMetricRanges(metric);
   const normalized = (value - ranges.min) / (ranges.max - ranges.min);

   // Different color schemes for different metrics
   let colorScheme = [];

   switch (metric) {
      case 'cases':
         // Red scale for cases (more cases = darker red)
         colorScheme = [
            '#fef2f2',
            '#fecaca',
            '#f87171',
            '#ef4444',
            '#dc2626',
            '#b91c1c',
            '#991b1b',
         ];
         break;
      case 'cured':
         // Green scale for cured (more cured = darker green)
         colorScheme = [
            '#f0fdf4',
            '#bbf7d0',
            '#86efac',
            '#4ade80',
            '#22c55e',
            '#16a34a',
            '#15803d',
         ];
         break;
      case 'mortality_rate':
         // Dark red scale for mortality (higher rate = darker red)
         colorScheme = [
            '#fef2f2',
            '#fee2e2',
            '#fecaca',
            '#f87171',
            '#ef4444',
            '#dc2626',
            '#7f1d1d',
         ];
         break;
      case 'incident_rate':
         // Blue scale for incident rate
         colorScheme = [
            '#eff6ff',
            '#bfdbfe',
            '#93c5fd',
            '#60a5fa',
            '#3b82f6',
            '#2563eb',
            '#1d4ed8',
         ];
         break;
      default:
         colorScheme = [
            '#f3f4f6',
            '#e5e7eb',
            '#d1d5db',
            '#9ca3af',
            '#6b7280',
            '#4b5563',
            '#374151',
         ];
   }

   const colorIndex = Math.min(
      Math.floor(normalized * colorScheme.length),
      colorScheme.length - 1,
   );
   return colorScheme[colorIndex];
};

// Update legend based on selected metric
const updateLegend = () => {
   if (!map) return;

   // Remove existing legend
   if (currentLegend) {
      map.removeControl(currentLegend);
   }

   const ranges = getMetricRanges(selectedMetric.value);
   const metricLabels = {
      cases: 'TB Cases',
      cured: 'Sembuh',
      mortality_rate: 'Mortality Rate',
      incident_rate: 'Incident Rate',
   };

   const colorSchemes = {
      cases: ['#fef2f2', '#fecaca', '#f87171', '#dc2626', '#991b1b'],
      cured: ['#f0fdf4', '#86efac', '#22c55e', '#16a34a', '#15803d'],
      mortality_rate: ['#fef2f2', '#fecaca', '#f87171', '#dc2626', '#7f1d1d'],
      incident_rate: ['#eff6ff', '#93c5fd', '#3b82f6', '#2563eb', '#1d4ed8'],
   };

   const colors = colorSchemes[selectedMetric.value] || colorSchemes.cases;

   currentLegend = L.control({ position: 'bottomright' });
   currentLegend.onAdd = function () {
      const div = L.DomUtil.create('div', 'legend');
      const step = (ranges.max - ranges.min) / colors.length;

      let legendItems = '';
      colors.forEach((color, index) => {
         const min = Math.round(ranges.min + step * index);
         const max = Math.round(ranges.min + step * (index + 1));
         const suffix = '';

         legendItems += `
        <div class="flex items-center">
          <div class="w-4 h-3 mr-2" style="background: ${color}"></div>
          ${min}${suffix} - ${max}${suffix}
        </div>
      `;
      });

      div.innerHTML = `
      <div class="bg-white p-3 rounded-lg shadow-lg border">
        <h4 class="font-semibold text-sm mb-2">${metricLabels[selectedMetric.value]}</h4>
        <div class="space-y-1 text-xs">
          ${legendItems}
        </div>
        <div class="mt-2 pt-2 border-t text-xs text-gray-500">
          <div class="flex justify-between gap-4">
            <span>Min: ${ranges.min}</span>
            <span>Max: ${ranges.max}</span>
          </div>
        </div>
        <div class="mt-3 pt-2 border-t">
          <div class="flex items-center text-xs">
            <div class="w-3 h-3 rounded-full mr-2 border-2 border-white" style="background: #ff6b6b"></div>
            <span class="text-red-600 font-semibold">Hotspot Area</span>
          </div>
        </div>
      </div>
    `;
      return div;
   };
   currentLegend.addTo(map);
};

// Function to add hotspot markers for provinces with hotspot_average_quadran = 1
const addHotspotMarkers = async () => {
   const L = (await import('leaflet')).default;

   // Clear existing hotspot markers
   hotspotMarkers.forEach((marker) => {
      if (map && map.hasLayer(marker)) {
         map.removeLayer(marker);
      }
   });
   hotspotMarkers = [];

   // Get provinces with hotspot_average_quadran = 1
   const hotspotProvinces = apiData.value.filter(
      (item) =>
         item.province !== 'INDONESIA' && item.hotspot_average_quadran === 1,
   );

   // Add circle markers for hotspot provinces using API coordinates
   hotspotProvinces.forEach((province) => {
      if (province.latitude && province.longitude && map) {
         const marker = L.circleMarker(
            [province.latitude, province.longitude],
            {
               radius: 15,
               fillColor: '#ff4444',
               color: '#ffffff',
               weight: 3,
               opacity: 1,
               fillOpacity: 0.9,
               zIndexOffset: 1000, // Ensure marker appears on top
               pane: 'markerPane', // Use marker pane which has higher z-index than overlay pane
            },
         ).addTo(map);

         // Bring marker to front to ensure it's on top
         marker.bringToFront();

         // Add popup for hotspot marker
         marker.bindPopup(`
        <div class="p-3">
          <h4 class="font-bold text-red-600 flex items-center">
            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
            </svg>
            HOTSPOT AREA
          </h4>
          <p class="font-semibold text-gray-800">${province.province}</p>
          <p class="text-sm text-gray-600 mt-1">High-risk TB transmission area</p>
          <div class="mt-2 text-xs">
            <div class="flex justify-between">
              <span>Cases:</span>
              <span class="font-semibold">${formatNumber(province.cases)}</span>
            </div>
            <div class="flex justify-between">
              <span>Incident Rate:</span>
              <span class="font-semibold text-orange-600">${province.incident_rate}</span>
            </div>
            <div class="flex justify-between">
              <span>Mortality Rate:</span>
              <span class="font-semibold text-red-600">${province.mortality_rate}%</span>
            </div>
            <div class="flex justify-between">
              <span>Hotspot Quadran:</span>
              <span class="font-semibold text-red-600">${province.hotspot_average_quadran}</span>
            </div>
          </div>
        </div>
      `);

         hotspotMarkers.push(marker);
      }
   });

   console.log(
      `Added ${hotspotMarkers.length} hotspot markers using API coordinates`,
   );
};

// Update map when metric changes
const updateMapData = async () => {
   if (currentGeoJSONLayer && map) {
      isMapLoading.value = true;
      // Remove existing layer
      map.removeLayer(currentGeoJSONLayer);
      // Reload choropleth with new metric
      await loadIndonesiaChoropleth();
      // Re-add hotspot markers
      await addHotspotMarkers();
      isMapLoading.value = false;
   }
};

// Province name mapping for different GeoJSON formats
const provinceNameMapping = {
   // Common variations
   JAKARTA: 'DKI JAKARTA',
   'JAKARTA RAYA': 'DKI JAKARTA',
   'DKI JAKARTA': 'DKI JAKARTA',
   'SPECIAL CAPITAL REGION OF JAKARTA': 'DKI JAKARTA',
   'DAERAH KHUSUS IBUKOTA JAKARTA': 'DKI JAKARTA',
   'WEST JAVA': 'JAWA BARAT',
   'JAWA BARAT': 'JAWA BARAT',
   'CENTRAL JAVA': 'JAWA TENGAH',
   'JAWA TENGAH': 'JAWA TENGAH',
   'EAST JAVA': 'JAWA TIMUR',
   'JAWA TIMUR': 'JAWA TIMUR',
   YOGYAKARTA: 'DI YOGYAKARTA',
   'DI YOGYAKARTA': 'DI YOGYAKARTA',
   'SPECIAL REGION OF YOGYAKARTA': 'DI YOGYAKARTA',
   'DAERAH ISTIMEWA YOGYAKARTA': 'DI YOGYAKARTA',
   'NORTH SUMATRA': 'SUMATERA UTARA',
   'SUMATERA UTARA': 'SUMATERA UTARA',
   'WEST SUMATRA': 'SUMATERA BARAT',
   'SUMATERA BARAT': 'SUMATERA BARAT',
   'SOUTH SUMATRA': 'SUMATERA SELATAN',
   'SUMATERA SELATAN': 'SUMATERA SELATAN',
   'WEST KALIMANTAN': 'KALIMANTAN BARAT',
   'KALIMANTAN BARAT': 'KALIMANTAN BARAT',
   'CENTRAL KALIMANTAN': 'KALIMANTAN TENGAH',
   'KALIMANTAN TENGAH': 'KALIMANTAN TENGAH',
   'SOUTH KALIMANTAN': 'KALIMANTAN SELATAN',
   'KALIMANTAN SELATAN': 'KALIMANTAN SELATAN',
   'EAST KALIMANTAN': 'KALIMANTAN TIMUR',
   'KALIMANTAN TIMUR': 'KALIMANTAN TIMUR',
   'NORTH KALIMANTAN': 'KALIMANTAN UTARA',
   'KALIMANTAN UTARA': 'KALIMANTAN UTARA',
   'NORTH SULAWESI': 'SULAWESI UTARA',
   'SULAWESI UTARA': 'SULAWESI UTARA',
   'CENTRAL SULAWESI': 'SULAWESI TENGAH',
   'SULAWESI TENGAH': 'SULAWESI TENGAH',
   'SOUTH SULAWESI': 'SULAWESI SELATAN',
   'SULAWESI SELATAN': 'SULAWESI SELATAN',
   'SOUTHEAST SULAWESI': 'SULAWESI TENGGARA',
   'SULAWESI TENGGARA': 'SULAWESI TENGGARA',
   'WEST SULAWESI': 'SULAWESI BARAT',
   'SULAWESI BARAT': 'SULAWESI BARAT',
   'WEST NUSA TENGGARA': 'NUSA TENGGARA BARAT',
   'NUSA TENGGARA BARAT': 'NUSA TENGGARA BARAT',
   'EAST NUSA TENGGARA': 'NUSA TENGGARA TIMUR',
   'NUSA TENGGARA TIMUR': 'NUSA TENGGARA TIMUR',
   'NORTH MALUKU': 'MALUKU UTARA',
   'MALUKU UTARA': 'MALUKU UTARA',
   'WEST PAPUA': 'PAPUA BARAT',
   'PAPUA BARAT': 'PAPUA BARAT',
   'RIAU ISLANDS': 'KEPULAUAN RIAU',
   'KEPULAUAN RIAU': 'KEPULAUAN RIAU',
   'BANGKA BELITUNG ISLANDS': 'KEPULAUAN BANGKA BELITUNG',
   'BANGKA BELITUNG': 'KEPULAUAN BANGKA BELITUNG',
   'KEP. BANGKA BELITUNG': 'KEPULAUAN BANGKA BELITUNG',
   'KEPULAUAN BANGKA BELITUNG': 'KEPULAUAN BANGKA BELITUNG',
   // Additional common names - exact matches with API data
   ACEH: 'ACEH',
   'DI. ACEH': 'ACEH',
   'NANGGROE ACEH DARUSSALAM': 'ACEH',
   RIAU: 'RIAU',
   JAMBI: 'JAMBI',
   BENGKULU: 'BENGKULU',
   LAMPUNG: 'LAMPUNG',
   BANTEN: 'BANTEN',
   BALI: 'BALI',
   GORONTALO: 'GORONTALO',
   MALUKU: 'MALUKU',
   PAPUA: 'PAPUA',
   'IRIAN JAYA': 'PAPUA',
   // Papua provinces from API
   'PAPUA TENGAH': 'PAPUA TENGAH',
   'PAPUA PEGUNUNGAN': 'PAPUA PEGUNUNGAN',
   'PAPUA SELATAN': 'PAPUA SELATAN',
   'PAPUA BARAT DAYA': 'PAPUA BARAT DAYA',
};

const normalizeProvinceName = (rawName) => {
   if (!rawName) return null;

   const upperName = rawName.toUpperCase().trim();

   // Check direct mapping first
   if (provinceNameMapping[upperName]) {
      return provinceNameMapping[upperName];
   }

   // Check if it exists directly in our data
   if (provinceData.value[upperName]) {
      return upperName;
   }

   // Try removing common prefixes/suffixes
   const cleanName = upperName
      .replace(/^PROVINSI\s+/, '')
      .replace(/^PROV\.\s+/, '')
      .replace(/^PROPINSI\s+/, '')
      .replace(/^PROP\.\s+/, '')
      .trim();

   if (provinceNameMapping[cleanName]) {
      return provinceNameMapping[cleanName];
   }

   if (provinceData.value[cleanName]) {
      return cleanName;
   }

   // Try fuzzy matching for common variations
   for (const key in provinceData.value) {
      if (key.includes(cleanName) || cleanName.includes(key)) {
         return key;
      }
   }

   console.warn(`Could not normalize province name: "${rawName}"`);
   return rawName; // Return original name instead of null for debugging
};

// Function to load and display Indonesia choropleth map
const loadIndonesiaChoropleth = async () => {
   const L = (await import('leaflet')).default;

   // Function to normalize province name

   // Function to get color based on selected metric
   const getColor = (provinceName) => {
      return getColorByMetric(provinceName, selectedMetric.value);
   };

   // Try multiple GeoJSON sources
   const geoJsonSources = [
      // 'https://raw.githubusercontent.com/superpikar/indonesia-geojson/master/indonesia-province-simple.json',
      // 'https://raw.githubusercontent.com/hanchiang/indonesia-json/master/indonesia-province.json',
      // 'https://raw.githubusercontent.com/ans-4175/indonesia-json/master/provinsi/indonesia-prov.geojson',
      'geojson_indonesia.json',
   ];

   for (const source of geoJsonSources) {
      try {
         const response = await fetch(source);
         const indonesiaGeoJSON = await response.json();
         console.log(`Loaded Indonesia GeoJSON from ${source}`);
         // Style function for provinces
         const style = (feature) => {
            const provinceName =
               feature.properties.name ||
               feature.properties.NAME_1 ||
               feature.properties.PROVINSI ||
               feature.properties.PROV_NAME ||
               feature.properties.provinsi ||
               feature.properties.Propinsi ||
               feature.properties.PROVNO ||
               feature.properties.OBJECTID ||
               feature.properties.province ||
               feature.properties.NAMA ||
               feature.properties.NAME;

            const fillColor = getColor(provinceName);

            return {
               fillColor: fillColor,
               weight: 1,
               opacity: 1,
               color: '#ffffff',
               fillOpacity: 0.8,
            };
         };

         // Add interaction handlers
         const onEachFeature = (feature, layer) => {
            // Extract province name from GeoJSON properties
            const provinceName =
               feature.properties.name ||
               feature.properties.NAME_1 ||
               feature.properties.PROVINSI ||
               feature.properties.PROV_NAME ||
               feature.properties.provinsi ||
               feature.properties.Propinsi ||
               feature.properties.PROVNO ||
               feature.properties.OBJECTID ||
               feature.properties.province ||
               feature.properties.NAMA ||
               feature.properties.NAME;

            const normalizedName = normalizeProvinceName(provinceName);
            const data = normalizedName
               ? provinceData.value[normalizedName]
               : null;

            layer.on({
               mouseover: (e) => {
                  const targetLayer = e.target;
                  targetLayer.setStyle({
                     weight: 3,
                     color: '#333',
                     dashArray: '',
                     fillOpacity: 0.9,
                  });
                  targetLayer.bringToFront();
               },
               mouseout: (e) => {
                  const targetLayer = e.target;
                  targetLayer.setStyle(style(feature));
               },
               click: (e) => {
                  map.fitBounds(e.target.getBounds());
               },
            });

            // Add popup with data
            if (data) {
               const currentMetricValue = getMetricValue(
                  normalizedName,
                  selectedMetric.value,
               );
               const metricLabels = {
                  cases: 'TB Cases',
                  cured: 'Cured',
                  mortality_rate: 'Mortality Rate',
                  incident_rate: 'Incident Rate',
               };

               layer.bindPopup(`
            <div class="p-4 min-w-64">
              <h3 class="font-bold text-xl text-gray-800">${normalizedName || provinceName}</h3>
              <div class="mt-3 space-y-2">
                <div class="flex justify-between">
                  <span class="text-gray-600">TB Cases:</span>
                  <span class="font-bold text-red-600">${formatNumber(data.cases || 0)}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-gray-600">Cured:</span>
                  <span class="font-bold text-green-600">${formatNumber(data.cured || 0)}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-gray-600">Mortality Rate:</span>
                  <span class="font-bold text-red-600">${data.mortality_rate || 0}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-gray-600">Incident Rate:</span>
                  <span class="font-bold text-blue-600">${data.incident_rate || 0}</span>
                </div>
                <hr class="my-3">
                <div class="flex justify-between font-semibold">
                  <span class="text-gray-700">${metricLabels[selectedMetric.value]}:</span>
                  <span class="text-purple-600">${
                     selectedMetric.value.includes('rate')
                        ? (currentMetricValue || 0) + '%'
                        : formatNumber(currentMetricValue || 0)
                  }</span>
                </div>
              </div>
            </div>
          `);
            } else {
               // Show debug popup for provinces without data
               layer.bindPopup(`
            <div class="p-3 max-w-xs">
              <h3 class="font-bold text-lg text-gray-800">DEBUG: ${provinceName || 'Unknown'}</h3>
              <p class="text-sm text-red-500">No data match found</p>
              <hr class="my-2">
              <div class="text-xs text-gray-600">
                <strong>Extracted Name:</strong> ${provinceName}<br>
                <strong>Normalized Name:</strong> ${normalizedName}<br>
                <strong>Available in API:</strong> ${Object.keys(provinceData.value).includes(normalizedName) ? 'Yes' : 'No'}
              </div>
            </div>
          `);
            }
         };

         // Add the choropleth layer to overlay pane (lower z-index)
         currentGeoJSONLayer = L.geoJSON(indonesiaGeoJSON, {
            style: style,
            onEachFeature: onEachFeature,
            pane: 'overlayPane', // Explicitly use overlay pane for lower z-index
         }).addTo(map);

         // Add hotspot markers after choropleth layer (will be on marker pane with higher z-index)
         await addHotspotMarkers();

         return; // Success, exit the function
      } catch (error) {
         console.warn(`Failed to load from ${source}:`, error);
         continue; // Try next source
      }
   }

   // If all sources fail, show error message
   console.error('All GeoJSON sources failed to load');
   alert(
      'Unable to load Indonesia map data. Please check your internet connection.',
   );
};

// Initialize map
const initMap = async () => {
   if (true) {
      // Only run on client side
      try {
         // Dynamic import for client-side only
         const L = (await import('leaflet')).default;

         // Fix default markers
         delete L.Icon.Default.prototype._getIconUrl;
         L.Icon.Default.mergeOptions({
            iconRetinaUrl:
               'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-icon-2x.png',
            iconUrl:
               'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-icon.png',
            shadowUrl:
               'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
         });

         // Initialize map centered on Indonesia
         map = L.map('map').setView([-2.5489, 118.0149], 5);

         // Add tile layer with better styling
         L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 18,
         }).addTo(map);

         // Set bounds to Indonesia
         const indonesiaBounds = [
            [-15.0, 90.0], // Southwest coordinates
            [10.0, 151.0], // Northeast coordinates
         ];
         map.setMaxBounds(indonesiaBounds);
         map.on('drag', function () {
            map.panInsideBounds(indonesiaBounds, { animate: true });
         });

         // Load Indonesia provinces GeoJSON and create choropleth map
         // Only load choropleth if we have province data
         if (Object.keys(provinceData.value).length > 0) {
            await loadIndonesiaChoropleth();
            // Add legend
            updateLegend();
         } else {
            console.warn(
               'No province data available, choropleth map not loaded',
            );
         }
      } catch (error) {
         console.error('Error initializing map:', error);
      }
   }
};

// Format number with commas
const formatNumber = (num) => {
   return num.toLocaleString('id-ID');
};

// Watch for metric changes
watch(selectedMetric, () => {
   updateMapData();
   updateLegend();
});

// Lifecycle
onMounted(async () => {
   isMapLoading.value = true;
   await fetchTBData();
   await nextTick();

   setTimeout(() => {
      initMap();
      setTimeout(() => {
         map.invalidateSize();
      }, 300);
   }, 300);
});

window.addEventListener('resize', () => {
   if (map) map.invalidateSize();
});
</script>
<style>
.fade-enter-active,
.fade-leave-active {
   transition: opacity 0.3s;
}
.fade-enter-from,
.fade-leave-to {
   opacity: 0;
}
</style>

<style scoped>
/* Custom styles for the dashboard */
/* .container {
  max-width: 1400px;
} */

/* Ensure map container has proper dimensions */
#map {
   height: 600px;
   width: 100%;
   border-radius: 0.5rem;
}

/* Custom city label styling */
:deep(.custom-city-label) {
   background: transparent !important;
   border: none !important;
}

/* Legend styling */
:deep(.legend) {
   font-family: inherit;
}

/* Leaflet popup styling */
:deep(.leaflet-popup-content-wrapper) {
   border-radius: 0.5rem;
   box-shadow:
      0 10px 15px -3px rgba(0, 0, 0, 0.1),
      0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

:deep(.leaflet-popup-tip) {
   background: white;
}

/* Card hover effects */
.bg-gradient-to-br {
   transition:
      transform 0.2s ease-in-out,
      box-shadow 0.2s ease-in-out;
}

.bg-gradient-to-br:hover {
   transform: translateY(-2px);
   box-shadow:
      0 20px 25px -5px rgba(0, 0, 0, 0.1),
      0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

/* Progress bar animation */
.bg-green-500 {
   transition: width 0.8s ease-in-out;
}

/* Responsive adjustments */
@media (max-width: 1280px) {
   #map {
      height: 500px;
   }
}

@media (max-width: 768px) {
   #map {
      height: 350px;
   }
}

@media (max-width: 640px) {
   #map {
      height: 300px;
   }
}
</style>
