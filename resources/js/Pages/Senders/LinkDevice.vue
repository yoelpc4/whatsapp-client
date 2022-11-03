<script setup>
import {Link} from '@inertiajs/inertia-vue3';
import {ChevronLeftIcon} from '@heroicons/vue/24/outline'
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    sender: {
        type: Object,
        required: true
    },
    qrCodeDataUrl: {
        type: String,
        required: true
    },
})

setTimeout(() => {
    window.location.reload()
}, 60000)
</script>

<template>
    <AppLayout title="Senders">
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Link Device
                </h2>

                <Link :href="route('senders.index')" class="flex justify-center items-center">
                    <ChevronLeftIcon class="w-3 h-3 mr-2"/>
                    Back
                </Link>
            </div>
        </template>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="px-4 py-5 bg-white sm:p-6 shadow">
                <ul role="list" class="divide-y divide-gray-200">
                    <li class="py-3 sm:py-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    User
                                </p>

                                <p class="text-sm text-gray-500 truncate">
                                    {{ sender.user.name }}
                                </p>
                            </div>
                        </div>
                    </li>

                    <li class="py-3 sm:py-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    Phone
                                </p>

                                <p class="text-sm text-gray-500 truncate">
                                    {{ sender.phone }}
                                </p>
                            </div>
                        </div>
                    </li>

                    <li class="py-3 sm:py-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    QR Code
                                </p>

                                <div>
                                    <img :src="qrCodeDataUrl" alt="QR Code">
                                </div>

                                <p class="text-sm text-gray-500 truncate">
                                    QR code will refresh every 1 minute, you can close this page after scanned the QR code.
                                </p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
