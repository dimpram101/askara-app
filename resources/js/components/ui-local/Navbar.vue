<script lang="ts" setup>
import { logout } from '@/routes';
import { Link, router, usePage } from '@inertiajs/vue3';
import { LogOut } from 'lucide-vue-next';
import { Icon } from '@iconify/vue';
import { ref } from 'vue';

const page = usePage();
const user = page.props.auth.user;
const showDropdown = ref(false);

const handleLogout = () => {
   router.flushAll();
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
                  class="font-medium text-[#76C6D1] transition hover:text-cyan-600"
               >
                  HOME
               </Link>
               <Link
                  href="/dashboard"
                  class="font-medium text-gray-600 transition hover:text-[#76C6D1]"
               >
                  DASHBOARD
               </Link>
               <Link
                  href="/ai-cxr-diagnose"
                  class="font-medium text-gray-600 transition hover:text-[#76C6D1]"
               >
                  AI-CXR DIAGNOSE
               </Link>
            </div>

            <!-- Auth Buttons -->
            <div class="flex items-center space-x-4" v-if="!user">
               <Link
                  href="/login"
                  class="font-medium text-[#76C6D1] transition hover:text-cyan-600"
               >
                  SIGN IN
               </Link>
               <Link
                  href="/register"
                  class="rounded-full bg-yellow-400 px-6 py-2 font-medium text-white shadow-md transition hover:bg-yellow-500"
               >
                  SIGN UP
               </Link>
            </div>

            <!-- User Avatar with Dropdown -->
            <div class="relative" v-else @mouseenter="showDropdown = true" @mouseleave="showDropdown = false">
               <!-- Avatar Circle -->
               <div class="flex items-center cursor-pointer">
                  <div class="h-10 w-10 rounded-full bg-[#76C6D1] flex items-center justify-center text-white shadow-md hover:bg-cyan-600 transition">
                     <Icon icon="mdi:account-circle" class="h-8 w-8" />
                  </div>
               </div>

               <!-- Dropdown Menu -->
               <div
                  v-show="showDropdown"
                  class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50 border border-gray-100"
               >
                  <!-- User Info -->
                  <div class="px-4 py-2 border-b border-gray-100">
                     <p class="text-sm font-semibold text-gray-800">{{ user.name }}</p>
                     <p class="text-xs text-gray-500 truncate">{{ user.email }}</p>
                  </div>

                  <!-- Dashboard Link -->
                  <Link
                     href="/dashboard"
                     class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition"
                  >
                     <Icon icon="mdi:view-dashboard" class="mr-3 h-5 w-5 text-gray-500" />
                     Dashboard
                  </Link>

                  <!-- Logout Button -->
                  <Link
                     :href="logout()"
                     @click="handleLogout"
                     as="button"
                     class="w-full flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition"
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
