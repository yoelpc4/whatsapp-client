<script setup>
import DialogModal from '@/Components/DialogModal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

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

defineEmits(['close'])

setTimeout(() => {
    window.location.reload()
}, 20000)
</script>

<template>
    <DialogModal show @close="$emit('close')">
        <template #title>
            Link Device
        </template>

        <template #content>
            <div>
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
                                    QR Code
                                </p>

                                <div>
                                    <img :src="qrCodeDataUrl" alt="QR Code">
                                </div>

                                <p class="text-sm text-gray-500 truncate">
                                    QR Code will refresh every 20 seconds, You do not need to do anything after scanned the QR.
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
