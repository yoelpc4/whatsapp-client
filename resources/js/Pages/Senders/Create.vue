<script setup>
import {Link, useForm} from '@inertiajs/inertia-vue3';
import {ChevronLeftIcon} from '@heroicons/vue/24/outline'
import AppLayout from '@/Layouts/AppLayout.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import WhatsappInternationalPhoneNumberFormatLink
    from '@/Components/WhatsappInternationalPhoneNumberFormatLink.vue';

const formCreateSender = useForm({
    name: null,
    phone: null,
})

function onSubmit() {
    formCreateSender.post(route('senders.store'), {
        preserveScroll: false
    })
}
</script>

<template>
    <AppLayout title="Senders">
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Create Sender
                </h2>

                <Link :href="route('senders.index')" class="flex justify-center items-center">
                    <ChevronLeftIcon class="w-3 h-3 mr-2"/>
                    Back
                </Link>
            </div>
        </template>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <FormSection id="form-create-sender" @submit="onSubmit">
                <template #title>
                    Create Sender
                </template>

                <template #description>
                    Create a new whatsapp sender.
                </template>

                <template #form>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="input-name" value="Name*"/>

                        <TextInput
                            v-model="formCreateSender.name"
                            id="input-name"
                            name="name"
                            maxlength="255"
                            class="mt-1 block w-full"
                        />

                        <InputError :message="formCreateSender.errors.name" class="mt-2"/>
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="input-phone" value="Phone*"/>

                        <TextInput
                            v-model="formCreateSender.phone"
                            id="input-phone"
                            name="phone"
                            type="tel"
                            maxlength="255"
                            class="mt-1 block w-full"
                        >
                            <template #help>
                                Please enter the sender phone number according to the
                                <WhatsappInternationalPhoneNumberFormatLink/>.
                            </template>
                        </TextInput>

                        <InputError :message="formCreateSender.errors.phone" class="mt-2"/>
                    </div>
                </template>

                <template #actions>
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
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
