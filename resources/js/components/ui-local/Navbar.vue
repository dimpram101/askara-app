<script lang="ts" setup>
import { logout } from '@/routes';
import { Icon } from '@iconify/vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import { LogOut } from 'lucide-vue-next';
import { ref } from 'vue';

// 🔥 IMPORT ICONIFY ICONS (local, offline)
import accountCircle from '@iconify-icons/mdi/account-circle';
import viewDashboard from '@iconify-icons/mdi/view-dashboard';
import accountCog from '@iconify-icons/mdi/account-cog';

const page = usePage();
const user = page.props.auth.user;
const showDropdown = ref(false);

const handleLogout = () => {
   router.flushAll();
};

const isActive = (path: string) => {
   return page.url === path;
};
</script>

<template>
   <nav class="rounded-b-4xl bg-white shadow-sm">
      <div class="container mx-auto px-6 py-4">
         <div class="flex items-center justify-between">

            <!-- Logo -->
            <div class="text-2xl font-bold text-gray-800">
               <Link href="/">
                  <img
                     src="/assets/images/askara-logo.png"
                     alt="Askara Logo"
                     class="h-12 w-auto"
                  />
               </Link>
            </div>

            <!-- Navigation Links -->
            <div class="hidden items-center space-x-8 md:flex">
               <Link
                  href="/"
                  :class="isActive('/') ? 'font-medium text-[#76C6D1]' : 'font-medium text-gray-600 hover:text-[#76C6D1]'"
               >
                  HOME
               </Link>

               <Link
                  href="/hotspot-map"
                  :class="isActive('/hotspot-map') ? 'font-medium text-[#76C6D1]' : 'font-medium text-gray-600 hover:text-[#76C6D1]'"
               >
                  DASHBOARD HOTSPOT
               </Link>

               <Link
                  href="/ai-cxr-diagnose"
                  :class="isActive('/ai-cxr-diagnose') ? 'font-medium text-[#76C6D1]' : 'font-medium text-gray-600 hover:text-[#76C6D1]'"
               >
                  AI-CXR DIAGNOSE
               </Link>
            </div>

            <!-- Auth Buttons -->
            <div class="flex items-center space-x-4" v-if="!user">
               <Link href="/login" class="font-medium text-[#76C6D1] transition hover:text-cyan-600">
                  SIGN IN
               </Link>
               <Link href="/register" class="rounded-full bg-yellow-400 px-6 py-2 font-medium text-white shadow-md transition hover:bg-yellow-500">
                  SIGN UP
               </Link>
            </div>

            <!-- User Avatar with Dropdown -->
            <div
               class="relative"
               v-else
               @mouseenter="showDropdown = true"
               @mouseleave="showDropdown = false"
            >
               <!-- Avatar Circle -->
               <div class="flex cursor-pointer items-center">
                  <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#76C6D1] text-white shadow-md transition hover:bg-cyan-600">
                     <Icon :icon="accountCircle" class="h-8 w-8" />
                  </div>
               </div>

               <!-- Dropdown Menu -->
               <div v-show="showDropdown" class="absolute right-0 z-50 mt-2 w-48 rounded-lg border border-gray-100 bg-white py-2 shadow-lg">

                  <!-- User Info -->
                  <div class="border-b border-gray-100 px-4 py-2">
                     <p class="text-sm font-semibold text-gray-800">{{ user.name }}</p>
                     <p class="truncate text-xs text-gray-500">{{ user.email }}</p>
                  </div>

                  <!-- Dashboard Link -->
                  <Link href="/hotspot-map" class="flex items-center px-4 py-2 text-sm text-gray-700 transition hover:bg-gray-50">
                     <Icon :icon="viewDashboard" class="mr-3 h-5 w-5 text-gray-500" />
                     Dashboard Hotspot
                  </Link>

                  <!-- Profile Link -->
                  <Link href="/profile" class="flex items-center px-4 py-2 text-sm text-gray-700 transition hover:bg-gray-50">
                     <Icon :icon="accountCog" class="mr-3 h-5 w-5 text-gray-500" />
                     Profile
                  </Link>

                  <!-- Logout Button -->
                  <Link
                     :href="logout()"
                     @click="handleLogout"
                     as="button"
                     class="flex w-full items-center px-4 py-2 text-sm text-red-600 transition hover:bg-red-50"
                  >
                     <LogOut class="mr-3 h-5 w-5" />
                     Log out
                  </Link>
               </div>
            </div>
         </div>
      </div>
   </nav>
</template>
