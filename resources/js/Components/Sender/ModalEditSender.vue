<script setup>
import {useForm} from '@inertiajs/inertia-vue3';
import DialogModal from '@/Components/DialogModal.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    sender: {
        type: Object,
        required: true
    },
})

const emit = defineEmits(['close'])

const formEditSender = useForm({
    name: props.sender.name,
    phone: props.sender.phone,
})

function onSubmit() {
    formEditSender.put(route('senders.update', props.sender), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => emit('close')
    })
}
</script>

<template>
    <DialogModal show @close="$emit('close')">
        <template #title>
            Edit Sender
        </template>

        <template #content>
            <form id="form-edit-sender" @submit.prevent="onSubmit">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="input-name" value="Name"/>

                        <TextInput v-model="formEditSender.name" id="input-name" autofocus class="mt-1 block w-full"/>

                        <InputError :message="formEditSender.errors.name" class="mt-2"/>
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="input-phone" value="Phone"/>

                        <TextInput v-model="formEditSender.phone" id="input-phone" class="mt-1 block w-full"
                                   type="tel"/>

                        <InputError :message="formEditSender.errors.phone" class="mt-2"/>
                    </div>
                </div>
            </form>
        </template>

        <template #footer>
            <SecondaryButton @click="$emit('close')">
                Close
            </SecondaryButton>

            <PrimaryButton
                class="ml-3"
                :class="{ 'opacity-25': formEditSender.processing }"
                :disabled="formEditSender.processing"
                form="form-edit-sender"
            >
                Update
            </PrimaryButton>
        </template>
    </DialogModal>
</template>

<style scoped>

</style>
