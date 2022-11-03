<script setup>
import {useForm} from '@inertiajs/inertia-vue3';
import { Link } from '@inertiajs/inertia-vue3';
import {ChevronLeftIcon} from '@heroicons/vue/24/outline'
import AppLayout from '@/Layouts/AppLayout.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    sender: {
        type: Object,
        required: true
    }
})

const formEditSender = useForm({
    name: props.sender.name,
    phone: props.sender.phone,
})

function onSubmit() {
    formEditSender.put(route('senders.update', props.sender), {
        preserveScroll: false
    })
}
</script>

<template>
    <AppLayout title="Senders">
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Edit Sender
                </h2>

                <Link :href="route('senders.index')" class="flex justify-center items-center">
                    <ChevronLeftIcon class="w-3 h-3 mr-2" /> Back
                </Link>
            </div>
        </template>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <FormSection id="form-create-sender" @submit="onSubmit">
                <template #title>
                    Edit Sender
                </template>

                <template #description>
                    Edit existing whatsapp sender.
                </template>

                <template #form>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="input-name" value="Name" />

                        <TextInput v-model="formEditSender.name" id="input-name" autofocus class="mt-1 block w-full" />

                        <InputError :message="formEditSender.errors.name" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="input-phone" value="Phone" />

                        <TextInput v-model="formEditSender.phone" id="input-phone" class="mt-1 block w-full" type="tel" />

                        <InputError :message="formEditSender.errors.phone" class="mt-2" />
                    </div>
                </template>

                <template #actions>
                    <PrimaryButton
                        class="ml-3"
                        :class="{ 'opacity-25': formEditSender.processing }"
                        :disabled="formEditSender.processing"
                        form="form-create-sender"
                    >
                        Update
                    </PrimaryButton>
                </template>
            </FormSection>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
