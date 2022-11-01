<script setup>
import {useForm} from '@inertiajs/inertia-vue3';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false
    },
    sender: {
        type: Object,
        default: null
    },
})

const emit = defineEmits(['close'])

const form = useForm()

function deleteSender() {
    form.delete(route('senders.destroy', props.sender), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => emit('close')
    })
}
</script>

<template>
    <ConfirmationModal :show="show" @close="$emit('close')">
        <template #title>
            Delete Sender
        </template>

        <template v-if="sender" #content>
            Are you sure you would like to delete sender {{ sender.name }}?
        </template>

        <template #footer>
            <SecondaryButton @click="$emit('close')">
                Close
            </SecondaryButton>

            <DangerButton
                class="ml-3"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                @click="deleteSender"
            >
                Delete
            </DangerButton>
        </template>
    </ConfirmationModal>
</template>

<style scoped>

</style>
