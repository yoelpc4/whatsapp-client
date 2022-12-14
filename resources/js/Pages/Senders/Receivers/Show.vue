<script setup>
import {Link} from '@inertiajs/inertia-vue3';
import {ChevronLeftIcon} from '@heroicons/vue/24/outline'
import {formatDateTime, titleCase} from '@/helpers.js';
import AppLayout from '@/Layouts/AppLayout.vue';
import TableLogMessages from '@/Components/LogMessage/TableLogMessages.vue';

defineProps({
    sender: {
        type: Object,
        required: true
    },
    receiver: {
        type: Object,
        required: true
    },
    logMessages: {
        type: Object,
        required: true
    },
})
</script>

<template>
    <AppLayout title="Senders">
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Receiver
                </h2>

                <Link :href="route('senders.show', sender)" class="flex justify-center items-center">
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
                                    Sender
                                </p>

                                <p class="text-sm text-gray-500 truncate">
                                    {{ sender.name }}
                                </p>
                            </div>
                        </div>
                    </li>

                    <li class="py-3 sm:py-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    Type
                                </p>

                                <p class="text-sm text-gray-500 truncate">
                                    {{ titleCase(receiver.type) }}
                                </p>
                            </div>
                        </div>
                    </li>

                    <li class="py-3 sm:py-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    Name
                                </p>

                                <p class="text-sm text-gray-500 truncate">
                                    {{ receiver.name }}
                                </p>
                            </div>
                        </div>
                    </li>

                    <li class="py-3 sm:py-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    Whatsapp ID
                                </p>

                                <p class="text-sm text-gray-500 truncate">
                                    {{ receiver.whatsapp_id }}
                                </p>
                            </div>
                        </div>
                    </li>

                    <li class="py-3 sm:py-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    Created at
                                </p>

                                <p class="text-sm text-gray-500 truncate">
                                    {{ formatDateTime(receiver.created_at) }}
                                </p>
                            </div>
                        </div>
                    </li>

                    <li class="py-3 sm:py-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    Updated at
                                </p>

                                <p class="text-sm text-gray-500 truncate">
                                    {{ formatDateTime(receiver.updated_at) }}
                                </p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="px-4 py-5 bg-white mb-10 sm:p-6 shadow">
                <div class="flex justify-between items-center mb-5">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Log Messages
                    </h2>
                </div>

                <TableLogMessages :sender="sender" :receiver="receiver" :logMessages="logMessages"/>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
