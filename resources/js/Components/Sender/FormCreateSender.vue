<script setup>
import FormSection from '@/Components/FormSection.vue';
import {useForm} from '@inertiajs/inertia-vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const formCreateSender = useForm({
    name: null,
    phone: null,
})

function onSubmit() {
    formCreateSender.post(route('senders.store'), {
        preserveScroll: true,
        onSuccess: () => formCreateSender.reset()
    })
}
</script>

<template>
    <FormSection id="form-create-sender" @submit="onSubmit">
        <template #title>
            Create Sender
        </template>

        <template #description>
            Create new whatsapp sender.
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="input-name" value="Name" />

                <TextInput v-model="formCreateSender.name" id="input-name" autofocus class="mt-1 block w-full" />

                <InputError :message="formCreateSender.errors.name" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="input-phone" value="Phone" />

                <TextInput v-model="formCreateSender.phone" id="input-phone" class="mt-1 block w-full" type="tel" />

                <InputError :message="formCreateSender.errors.phone" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <ActionMessage :on="formCreateSender.recentlySuccessful">
                Created.
            </ActionMessage>

            <PrimaryButton
                class="ml-3"
                :class="{ 'opacity-25': formCreateSender.processing }"
                :disabled="formCreateSender.processing"
                form="form-create-sender"
            >
                Create
            </PrimaryButton>
        </template>
    </FormSection>
</template>

<style scoped>

</style>
