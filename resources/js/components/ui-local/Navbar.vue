<script lang="ts" setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <nav class="rounded-b-4xl bg-white shadow-sm">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <div class="text-2xl font-bold text-gray-800">ASKARA</div>

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
                <div class="flex items-center space-x-4">
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
            </div>
        </div>
    </nav>
</template>
