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
})

const emit = defineEmits(['close'])

const deleteSenderForm = useForm()

function deleteSender() {
    deleteSenderForm.delete(route('senders.destroy', props.sender), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => emit('close')
    })
}
</script>

<template>
    <ConfirmationModal show @close="$emit('close')">
        <template #title>
            Delete Sender
        </template>

        <template #content>
            Are you sure you would like to delete sender {{ sender.name }}?
        </template>

        <template #footer>
            <SecondaryButton @click="$emit('close')">
                Close
            </SecondaryButton>

            <DangerButton
                class="ml-3"
                :class="{ 'opacity-25': deleteSenderForm.processing }"
                :disabled="deleteSenderForm.processing"
                @click="deleteSender"
            >
                Delete
            </DangerButton>
        </template>
    </ConfirmationModal>
</template>

<style scoped>

</style>
