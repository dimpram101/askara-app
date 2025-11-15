<script setup lang="ts">
import Toast from '@/components/Toast.vue';
import Navbar from '@/components/ui-local/Navbar.vue';
</script>

<template>
   <div class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100">
      <Navbar />

      <slot />
   </div>

   <Toast />
</template>
