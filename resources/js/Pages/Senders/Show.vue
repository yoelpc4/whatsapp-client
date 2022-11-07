<script setup>
import {ref} from 'vue';
import {Link} from '@inertiajs/inertia-vue3';
import {ChevronLeftIcon, PlusIcon} from '@heroicons/vue/24/outline'
import {formatDateTime} from '@/helpers.js';
import AppLayout from '@/Layouts/AppLayout.vue';
import ModalDeleteReceiver from '@/Components/Receiver/ModalDeleteReceiver.vue';
import TableReceivers from '@/Components/Receiver/TableReceivers.vue';

defineProps({
    sender: {
        type: Object,
        required: true
    },
    receivers: {
        type: Object,
        required: true
    },
})

const receiver = ref(null)

const showModalDeleteReceiver = ref(false)

function onOpenModalDeleteReceiver(data) {
    receiver.value = data

    showModalDeleteReceiver.value = true
}

function onCloseModalDeleteReceiver() {
    showModalDeleteReceiver.value = false

    receiver.value = null
}
</script>

<template>
    <AppLayout title="Senders">
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Sender
                </h2>

                <Link :href="route('senders.index')" class="flex justify-center items-center">
                    <ChevronLeftIcon class="w-3 h-3 mr-2"/>
                    Back
                </Link>
            </div>
        </template>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="px-4 py-5 mb-10 bg-white sm:p-6 shadow">
                <ul role="list" class="divide-y divide-gray-200">
                    <li class="py-3 sm:py-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    Name
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
                                    Created at
                                </p>

                                <p class="text-sm text-gray-500 truncate">
                                    {{ formatDateTime(sender.created_at) }}
                                </p>
                            </div>
                        </div>
                    </li>

                    <li class="py-3 sm:py-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    Updated At
                                </p>

                                <p class="text-sm text-gray-500 truncate">
                                    {{ formatDateTime(sender.updated_at) }}
                                </p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="px-4 py-5 bg-white mb-10 sm:p-6 shadow">
                <div class="flex justify-between items-center mb-5">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Receivers
                    </h2>

                    <Link :href="route('senders.receivers.create', sender)" class="flex justify-center items-center">
                        <PlusIcon class="w-3 h-3 mr-2"/>
                        Create
                    </Link>
                </div>

                <TableReceivers :sender="sender" :receivers="receivers" @delete="onOpenModalDeleteReceiver"/>
            </div>
        </div>

        <ModalDeleteReceiver
            v-if="showModalDeleteReceiver && sender && receiver"
            :sender="sender"
            :receiver="receiver"
            @close="onCloseModalDeleteReceiver"
        />
    </AppLayout>
</template>

<style scoped>

</style>
