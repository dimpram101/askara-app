<template>
   <Head title="Hotspot Map" />

   <AppLocalLayout>
      <div class="">
         <!-- Header with Filters -->
         <div class="container mx-auto px-8 py-4 xl:px-4">
            <!-- <div class="grid grid-cols-3 items-center gap-x-8">
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
            </div> -->
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
                        <Icon :icon="userPlus" class="w-6 h-6"/>
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
                        <Icon
                           :icon="exclamationTriangle"
                           class="h-6 w-6"
                        />
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
                        <Icon :icon="heart" class="h-6 w-6" />
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

               <div class="mt-4 flex justify-center sm:justify-start">
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
import { Icon } from '@iconify/vue';
import { Head } from '@inertiajs/vue3';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import { nextTick, onMounted, ref, watch } from 'vue';
import userPlus from '@iconify-icons/heroicons-outline/user-plus';
import heart from '@iconify-icons/heroicons-outline/heart';
import exclamationTriangle from '@iconify-icons/heroicons-solid/exclaimation-triangle';


// Map instance
let map: L.Map | null = null;
let geoJsonLayer: L.GeoJSON | null = null;

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

// Reactive data from API
const apiData = ref<any[]>([]);
const provinceData = ref<Record<string, any>>({});

// Fetch data from API
const fetchTBData = async () => {
   isMapLoading.value = true;
   try {
      const response = await fetch(`/pengobatan_so_2023`);
      const result = await response.json();
      if (result) {
         apiData.value = result;
      }
   } catch (error) {
      console.error('Error fetching TB data:', error);
      // Fallback to dummy data if API fails
      loadFallbackData();
   } finally {
      isMapLoading.value = false;
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

function formatNumber(value: number) {
   return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}

// Initialize the map
const initMap = () => {
   // Create map centered on Indonesia
   map = L.map('map').setView([-2.5, 118], 5);

   // Add OpenStreetMap tiles
   L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution:
         '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
      maxZoom: 18,
   }).addTo(map);

   // Add legend
   addLegend();

   // Load GeoJSON data
   loadGeoJSON();
};

// Add legend to map
const addLegend = () => {
   if (!map) return;

   const legend = new L.Control({ position: 'bottomright' });

   legend.onAdd = function () {
      const div = L.DomUtil.create('div', 'legend');
      div.style.padding = '10px';
      div.style.background = 'white';
      div.style.borderRadius = '5px';
      div.style.boxShadow = '0 0 15px rgba(0,0,0,0.2)';

      const grades =
         selectedMetric.value === 'cases'
            ? [0, 2000, 5000, 10000, 20000, 30000, 50000]
            : selectedMetric.value === 'cured'
              ? [0, 1000, 2000, 5000, 10000]
              : [0, 3, 5, 7, 10, 15];

      div.innerHTML = `<h4 style="margin: 0 0 5px 0; font-weight: bold;">${getMetricLabel()}</h4>`;

      for (let i = 0; i < grades.length; i++) {
         const from = grades[i];
         const to = grades[i + 1];
         const color = getColorForValue(from);

         div.innerHTML += `
            <div style="display: flex; align-items: center; margin: 3px 0;">
               <i style="background:${color}; width: 20px; height: 18px; display: inline-block; margin-right: 5px;"></i>
               <span style="font-size: 12px;">${from}${to ? '&ndash;' + to : '+'}</span>
            </div>
         `;
      }

      return div;
   };

   legend.addTo(map);
};

// Get metric label for legend
const getMetricLabel = () => {
   switch (selectedMetric.value) {
      case 'cases':
         return 'Jumlah Kasus';
      case 'cured':
         return 'Jumlah Sembuh';
      case 'mortality_rate':
         return 'Mortality Rate (%)';
      case 'incident_rate':
         return 'Incident Rate';
      default:
         return 'Data';
   }
};

// Get color for specific value
const getColorForValue = (value: number) => {
   if (selectedMetric.value === 'cases') {
      return value > 50000
         ? '#800026'
         : value > 30000
           ? '#BD0026'
           : value > 20000
             ? '#E31A1C'
             : value > 10000
               ? '#FC4E2A'
               : value > 5000
                 ? '#FD8D3C'
                 : value > 2000
                   ? '#FEB24C'
                   : '#FFEDA0';
   } else if (selectedMetric.value === 'cured') {
      return value > 10000
         ? '#006837'
         : value > 5000
           ? '#31A354'
           : value > 2000
             ? '#78C679'
             : value > 1000
               ? '#ADDD8E'
               : '#D9F0A3';
   } else {
      return value > 15
         ? '#800026'
         : value > 10
           ? '#BD0026'
           : value > 7
             ? '#E31A1C'
             : value > 5
               ? '#FC4E2A'
               : value > 3
                 ? '#FD8D3C'
                 : '#FEB24C';
   }
};

// Load and display GeoJSON
const loadGeoJSON = async () => {
   try {
      const response = await fetch('/geojson_indonesia.json');
      const geoJsonData = await response.json();

      // Remove existing layer if any
      if (geoJsonLayer && map) {
         map.removeLayer(geoJsonLayer);
      }

      // Add GeoJSON layer with styling and interactions
      geoJsonLayer = L.geoJSON(geoJsonData, {
         style: (feature) => {
            return {
               fillColor: getColor(feature),
               weight: 2,
               opacity: 1,
               color: 'white',
               fillOpacity: 0.7,
            };
         },
         onEachFeature: (feature, layer) => {
            // Add hover effect
            layer.on({
               mouseover: highlightFeature,
               mouseout: resetHighlight,
               click: zoomToFeature,
            });

            // Add popup
            if (feature.properties) {
               const props = feature.properties;
               const provinceName =
                  props.state || props.PROVINSI || props.Propinsi || 'Unknown';
               const data = getProvinceData(provinceName);


               let popupContent = `<div class="p-2">
                  <h3 class="font-bold text-lg mb-2">${provinceName}</h3>`;

               if (data) {
                  popupContent += `
                     <div class="space-y-1 text-sm">
                        <div class="flex justify-between">
                           <span>Kasus:</span>
                           <span class="font-semibold">${formatNumber(data.cases)}</span>
                        </div>
                        <div class="flex justify-between">
                           <span>Sembuh:</span>
                           <span class="font-semibold">${formatNumber(data.cured)}</span>
                        </div>
                        <div class="flex justify-between">
                           <span>Mortality Rate:</span>
                           <span class="font-semibold">${data.mortality_rate}%</span>
                        </div>
                        <div class="flex justify-between">
                           <span>Incident Rate:</span>
                           <span class="font-semibold">${data.incident_rate}</span>
                        </div>
                     </div>`;
               } else {
                  popupContent += `<p class="text-sm text-gray-600">Data tidak tersedia</p>`;
               }

               popupContent += `</div>`;
               layer.bindPopup(popupContent);
            }
         },
      });

      if (map) {
         geoJsonLayer.addTo(map);
      }
   } catch (error) {
      console.error('Error loading GeoJSON:', error);
   }
};

// Get color based on metric value
const getColor = (feature: any) => {
   if (!feature.properties) return '#CCCCCC';

   const provinceName =
      feature.properties.state ||
      feature.properties.PROVINSI ||
      feature.properties.Propinsi;
   const data = getProvinceData(provinceName);

   if (!data) {
      return '#CCCCCC';
   }

   const value = data[selectedMetric.value];
   if (!value) return '#CCCCCC';

   // Color scale based on metric
   if (selectedMetric.value === 'cases') {
      return value > 50000
         ? '#800026'
         : value > 30000
           ? '#BD0026'
           : value > 20000
             ? '#E31A1C'
             : value > 10000
               ? '#FC4E2A'
               : value > 5000
                 ? '#FD8D3C'
                 : value > 2000
                   ? '#FEB24C'
                   : '#FFEDA0';
   } else if (selectedMetric.value === 'cured') {
      return value > 10000
         ? '#006837'
         : value > 5000
           ? '#31A354'
           : value > 2000
             ? '#78C679'
             : value > 1000
               ? '#ADDD8E'
               : '#D9F0A3';
   } else {
      // For rates (mortality, incident)
      return value > 15
         ? '#800026'
         : value > 10
           ? '#BD0026'
           : value > 7
             ? '#E31A1C'
             : value > 5
               ? '#FC4E2A'
               : value > 3
                 ? '#FD8D3C'
                 : '#FEB24C';
   }
};

// Normalize province name for matching
const normalizeProvinceName = (name: string): string => {
   if (!name) return '';

   // Remove common prefixes and normalize
   return name
      .toUpperCase()
      .replace(/^PROVINSI\s+/i, '')
      .replace(/^PROV\.\s+/i, '')
      .replace(/^PROP\.\s+/i, '')
      .trim();
};

// Get province data from apiData or provinceData
const getProvinceData = (provinceName: string) => {
   if (!provinceName) return null;

   const normalizedSearch = normalizeProvinceName(provinceName);

   // Try to find in apiData first
   if (apiData.value.length > 0) {
      const found = apiData.value.find((item: any) => {
         if (!item.province) return false;
         const normalizedProvince = normalizeProvinceName(item.province);
         return normalizedProvince === normalizedSearch;
      });

      if (found) {
         return found;
      }
   }

   // Fallback to provinceData
   const fallbackData = provinceData.value[normalizedSearch];
   if (fallbackData) {
      return fallbackData;
   }

   return null;
};

// Highlight feature on hover
const highlightFeature = (e: any) => {
   const layer = e.target;
   layer.setStyle({
      weight: 3,
      color: '#666',
      fillOpacity: 0.9,
   });
   layer.bringToFront();
};

// Reset highlight
const resetHighlight = (e: any) => {
   if (geoJsonLayer) {
      geoJsonLayer.resetStyle(e.target);
   }
};

// Zoom to feature on click
const zoomToFeature = (e: any) => {
   if (map) {
      map.fitBounds(e.target.getBounds());
   }
};

// Update map data when metric changes
const updateMapData = () => {
   if (map) {
      // Remove all controls and re-add
      map.eachLayer((layer) => {
         if (layer instanceof L.GeoJSON) {
            map?.removeLayer(layer);
         }
      });
      // Remove existing controls
      const legends = document.querySelectorAll('.legend');
      legends.forEach((legend) => legend.remove());

      // Re-add legend and GeoJSON
      addLegend();
      loadGeoJSON();
   }
};

// Watch for filter changes
watch([selectedYear, selectedProvince, selectedCity], () => {
   fetchTBData();
});

// Initialize on mount
onMounted(async () => {
   await nextTick();
   await fetchTBData();
   updateStatistics();
   initMap();
});

// Watch for API data changes to update map
watch(apiData, () => {
   if (map && apiData.value.length > 0) {
      updateMapData();
   }
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
