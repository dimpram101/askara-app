<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
   Card,
   CardContent,
   CardDescription,
   CardHeader,
   CardTitle,
} from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import AppLocalLayout from '@/layouts/AppLocalLayout.vue';
import type { User } from '@/types';
import { Head, router, useForm } from '@inertiajs/vue3';
import { Save, User as UserIcon } from 'lucide-vue-next';

interface UserProfile {
   id?: number;
   user_id?: number;
   nik?: string;
   phone_number?: string;
   address?: string;
   date_of_birth?: string;
   gender?: string;
   province?: string;
   city?: string;
}

interface Props {
   user: User & { profile?: UserProfile };
   profile: UserProfile;
}

const props = defineProps<Props>();

const form = useForm({
   nik: props.profile?.nik || '',
   phone_number: props.profile?.phone_number || '',
   address: props.profile?.address || '',
   date_of_birth: props.profile?.date_of_birth || '',
   gender: props.profile?.gender || '',
   province: props.profile?.province || '',
   city: props.profile?.city || '',
});

const submitForm = () => {
   form.put('/profile', {
      preserveScroll: true,
      onSuccess: () => {
         // Form will be automatically updated by Inertia
      },
   });
};

const provinces = [
   'Aceh',
   'Sumatera Utara',
   'Sumatera Barat',
   'Riau',
   'Jambi',
   'Sumatera Selatan',
   'Bengkulu',
   'Lampung',
   'Kepulauan Bangka Belitung',
   'Kepulauan Riau',
   'DKI Jakarta',
   'Jawa Barat',
   'Jawa Tengah',
   'DI Yogyakarta',
   'Jawa Timur',
   'Banten',
   'Bali',
   'Nusa Tenggara Barat',
   'Nusa Tenggara Timur',
   'Kalimantan Barat',
   'Kalimantan Tengah',
   'Kalimantan Selatan',
   'Kalimantan Timur',
   'Kalimantan Utara',
   'Sulawesi Utara',
   'Sulawesi Tengah',
   'Sulawesi Selatan',
   'Sulawesi Tenggara',
   'Gorontalo',
   'Sulawesi Barat',
   'Maluku',
   'Maluku Utara',
   'Papua',
   'Papua Barat',
   'Papua Tengah',
   'Papua Pegunungan',
   'Papua Selatan',
   'Papua Barat Daya',
];
</script>

<template>
   <Head title="Edit Profile" />

   <AppLocalLayout>
      <div class="container mx-auto max-w-4xl px-4 py-8">
         <!-- Header -->
         <div class="mb-8">
            <div class="mb-2 flex items-center gap-3">
               <div
                  class="flex h-12 w-12 items-center justify-center rounded-lg bg-primary/10"
               >
                  <UserIcon class="h-6 w-6 text-primary" />
               </div>
               <div>
                  <h1 class="text-3xl font-bold tracking-tight">Profile</h1>
                  <p class="text-muted-foreground">
                     Manage your personal information
                  </p>
               </div>
            </div>
         </div>

         <!-- User Info Card -->
         <Card class="mb-6">
            <CardHeader>
               <CardTitle>Account Information</CardTitle>
               <CardDescription>Your basic account details</CardDescription>
            </CardHeader>
            <CardContent>
               <div class="grid gap-4 md:grid-cols-2">
                  <div>
                     <label class="text-sm font-medium text-muted-foreground"
                        >Name</label
                     >
                     <p class="text-lg font-medium">{{ user.name }}</p>
                  </div>
                  <div>
                     <label class="text-sm font-medium text-muted-foreground"
                        >Email</label
                     >
                     <p class="text-lg font-medium">{{ user.email }}</p>
                  </div>
                  <div v-if="user.roles && user.roles.length > 0">
                     <label class="text-sm font-medium text-muted-foreground"
                        >Role</label
                     >
                     <p class="text-lg font-medium">
                        <span
                           class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium"
                           :class="
                              user.roles[0].name === 'Dinkes'
                                 ? 'bg-purple-100 text-purple-800'
                                 : user.roles[0].name === 'Fasyankes'
                                   ? 'bg-blue-100 text-blue-800'
                                   : 'bg-green-100 text-green-800'
                           "
                        >
                           {{ user.roles[0].name }}
                        </span>
                     </p>
                  </div>
               </div>
            </CardContent>
         </Card>

         <!-- Profile Form -->
         <form @submit.prevent="submitForm">
            <Card>
               <CardHeader>
                  <CardTitle>Personal Information</CardTitle>
                  <CardDescription>
                     Update your personal details and contact information
                  </CardDescription>
               </CardHeader>
               <CardContent class="space-y-6">
                  <!-- NIK -->
                  <div class="space-y-2">
                     <label for="nik" class="text-sm font-medium">
                        NIK (Nomor Induk Kependudukan)
                     </label>
                     <Input
                        id="nik"
                        v-model="form.nik"
                        placeholder="3201234567890123"
                        maxlength="16"
                        :class="{ 'border-red-500': form.errors.nik }"
                     />
                     <p v-if="form.errors.nik" class="text-sm text-red-500">
                        {{ form.errors.nik }}
                     </p>
                  </div>

                  <!-- Phone Number -->
                  <div class="space-y-2">
                     <label for="phone_number" class="text-sm font-medium">
                        Phone Number
                     </label>
                     <Input
                        id="phone_number"
                        v-model="form.phone_number"
                        placeholder="08123456789"
                        type="tel"
                        :class="{ 'border-red-500': form.errors.phone_number }"
                     />
                     <p
                        v-if="form.errors.phone_number"
                        class="text-sm text-red-500"
                     >
                        {{ form.errors.phone_number }}
                     </p>
                  </div>

                  <!-- Date of Birth & Gender -->
                  <div class="grid gap-4 md:grid-cols-2">
                     <div class="space-y-2">
                        <label for="date_of_birth" class="text-sm font-medium">
                           Date of Birth
                        </label>
                        <Input
                           id="date_of_birth"
                           v-model="form.date_of_birth"
                           type="date"
                           :class="{
                              'border-red-500': form.errors.date_of_birth,
                           }"
                        />
                        <p
                           v-if="form.errors.date_of_birth"
                           class="text-sm text-red-500"
                        >
                           {{ form.errors.date_of_birth }}
                        </p>
                     </div>

                     <div class="space-y-2">
                        <label for="gender" class="text-sm font-medium"
                           >Gender</label
                        >
                        <select
                           id="gender"
                           v-model="form.gender"
                           class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:outline-none disabled:cursor-not-allowed disabled:opacity-50"
                           :class="{ 'border-red-500': form.errors.gender }"
                        >
                           <option value="">Select Gender</option>
                           <option value="Laki-laki">Laki-laki</option>
                           <option value="Perempuan">Perempuan</option>
                        </select>
                        <p
                           v-if="form.errors.gender"
                           class="text-sm text-red-500"
                        >
                           {{ form.errors.gender }}
                        </p>
                     </div>
                  </div>

                  <!-- Province & City -->
                  <div class="grid gap-4 md:grid-cols-2">
                     <div class="space-y-2">
                        <label for="province" class="text-sm font-medium"
                           >Province</label
                        >
                        <select
                           id="province"
                           v-model="form.province"
                           class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:outline-none disabled:cursor-not-allowed disabled:opacity-50"
                           :class="{ 'border-red-500': form.errors.province }"
                        >
                           <option value="">Select Province</option>
                           <option
                              v-for="prov in provinces"
                              :key="prov"
                              :value="prov"
                           >
                              {{ prov }}
                           </option>
                        </select>
                        <p
                           v-if="form.errors.province"
                           class="text-sm text-red-500"
                        >
                           {{ form.errors.province }}
                        </p>
                     </div>

                     <div class="space-y-2">
                        <label for="city" class="text-sm font-medium"
                           >City</label
                        >
                        <Input
                           id="city"
                           v-model="form.city"
                           placeholder="Jakarta"
                           :class="{ 'border-red-500': form.errors.city }"
                        />
                        <p v-if="form.errors.city" class="text-sm text-red-500">
                           {{ form.errors.city }}
                        </p>
                     </div>
                  </div>

                  <!-- Address -->
                  <div class="space-y-2">
                     <label for="address" class="text-sm font-medium"
                        >Address</label
                     >
                     <textarea
                        id="address"
                        v-model="form.address"
                        rows="3"
                        placeholder="Jl. Example No. 123, RT/RW 01/02"
                        class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:outline-none disabled:cursor-not-allowed disabled:opacity-50"
                        :class="{ 'border-red-500': form.errors.address }"
                     ></textarea>
                     <p v-if="form.errors.address" class="text-sm text-red-500">
                        {{ form.errors.address }}
                     </p>
                  </div>

                  <!-- Submit Button -->
                  <div class="flex justify-end gap-4 pt-4">
                     <Button
                        type="button"
                        variant="outline"
                        @click="router.visit('/')"
                        :disabled="form.processing"
                     >
                        Cancel
                     </Button>
                     <Button
                        type="submit"
                        :disabled="form.processing"
                        class="gap-2"
                     >
                        <Save class="h-4 w-4" />
                        {{ form.processing ? 'Saving...' : 'Save Changes' }}
                     </Button>
                  </div>
               </CardContent>
            </Card>
         </form>
      </div>
   </AppLocalLayout>
</template>
