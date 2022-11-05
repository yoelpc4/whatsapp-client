<script setup>
import {useForm} from '@inertiajs/inertia-vue3';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    sender: {
        type: Object,
        required: true
    },
    receiver: {
        type: Object,
        required: true
    },
})

const emit = defineEmits(['close'])

const deleteReceiverForm = useForm()

function deleteReceiver() {
    deleteReceiverForm.delete(route('senders.receivers.destroy', [props.sender, props.receiver]), {
        preserveScroll: false,
        onSuccess: () => emit('close')
    })
}
</script>

<template>
    <ConfirmationModal show @close="$emit('close')">
        <template #title>
            Delete Receiver
        </template>

        <template #content>
            Are you sure you would like to delete receiver {{ receiver.name }}?
        </template>

        <template #footer>
            <SecondaryButton @click="$emit('close')">
                Close
            </SecondaryButton>

            <DangerButton
                class="ml-3"
                :class="{ 'opacity-25': deleteReceiverForm.processing }"
                :disabled="deleteReceiverForm.processing"
                @click="deleteReceiver"
            >
                Delete
            </DangerButton>
        </template>
    </ConfirmationModal>
</template>

<style scoped>

</style>
