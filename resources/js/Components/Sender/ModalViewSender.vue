<script setup>
import {formatDate} from '@/helpers.js';
import DialogModal from '@/Components/DialogModal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

defineProps({
    show: {
        type: Boolean,
        default: false
    },
    sender: {
        type: Object,
        default: null
    },
})

defineEmits(['close'])
</script>

<template>
    <DialogModal :show="show" @close="$emit('close')">
        <template #title>
            View Sender
        </template>

        <template #content>
            <div v-if="sender">
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
                                    {{ formatDate(sender.created_at) }}
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
                                    {{ formatDate(sender.updated_at) }}
                                </p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </template>

        <template #footer>
            <SecondaryButton @click="$emit('close')">
                Close
            </SecondaryButton>
        </template>
    </DialogModal>
</template>

<style scoped>

</style>
