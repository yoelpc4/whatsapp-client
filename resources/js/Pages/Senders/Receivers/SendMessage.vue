<script setup>
import {Link, useForm} from '@inertiajs/inertia-vue3';
import {ChevronLeftIcon} from '@heroicons/vue/24/outline'
import AppLayout from '@/Layouts/AppLayout.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextareaInput from '@/Components/TextareaInput.vue';

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

const formSendMessage = useForm({
    message: null,
    group: null,
})

function onSubmit() {
    formSendMessage.post(route('senders.receivers.send-message.store', [props.sender, props.receiver]), {
        preserveScroll: false
    })
}
</script>

<template>
    <AppLayout title="Receivers">
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Send Message
                </h2>

                <Link :href="route('senders.show', sender)" class="flex justify-center items-center">
                    <ChevronLeftIcon class="w-3 h-3 mr-2"/>
                    Back
                </Link>
            </div>
        </template>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <FormSection id="form-edit-receiver" @submit="onSubmit">
                <template #title>
                    Send Message
                </template>

                <template #description>
                    Send message from sender {{ sender.name }} to receiver {{ receiver.name }}.
                </template>

                <template #form>
                    <div class="py-3 sm:py-4 col-span-6 sm:col-span-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    Sender
                                </p>

                                <p class="text-sm text-gray-500 truncate">
                                    {{ sender.name }}
                                </p>
                            </div>

                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    Receiver
                                </p>

                                <p class="text-sm text-gray-500 truncate">
                                    {{ receiver.name }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="input-message" value="Message*"/>

                        <TextareaInput
                            v-model="formSendMessage.message"
                            id="input-message"
                            name="message"
                            class="mt-1 block w-full"
                        />

                        <InputError :message="formSendMessage.errors.message" class="mt-2"/>
                    </div>
                </template>

                <template #actions>
                    <PrimaryButton
                        class="ml-3"
                        :class="{ 'opacity-25': formSendMessage.processing }"
                        :disabled="formSendMessage.processing"
                        form="form-edit-receiver"
                    >
                        Send
                    </PrimaryButton>
                </template>
            </FormSection>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
