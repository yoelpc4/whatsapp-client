<script setup>
import {computed} from 'vue';
import {Link, useForm} from '@inertiajs/inertia-vue3';
import {ChevronLeftIcon} from '@heroicons/vue/24/outline'
import {titleCase} from '@/helpers.js';
import AppLayout from '@/Layouts/AppLayout.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SelectInput from '@/Components/SelectInput.vue';
import TextInput from '@/Components/TextInput.vue';
import WhatsappInternationalPhoneNumberFormatLink
    from '@/Components/WhatsappInternationalPhoneNumberFormatLink.vue';

const props = defineProps({
    sender: {
      type: Object,
      required: true
    },
    types: {
        type: Array,
        required: true
    }
})

const typeOptions = computed(() => props.types.reduce((options, type) => {
    options.push({
        text: titleCase(type),
        value: type,
    })

    return options
}, []))

const formCreateReceiver = useForm({
    type: props.types[0],
    name: null,
    whatsapp_id: null,
})

function onSubmit() {
    formCreateReceiver.post(route('senders.receivers.store', props.sender), {
        preserveScroll: false
    })
}
</script>

<template>
    <AppLayout title="Receivers">
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Create Receiver
                </h2>

                <Link :href="route('senders.show', sender)" class="flex justify-center items-center">
                    <ChevronLeftIcon class="w-3 h-3 mr-2"/>
                    Back
                </Link>
            </div>
        </template>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <FormSection id="form-create-receiver" @submit="onSubmit">
                <template #title>
                    Create Receiver
                </template>

                <template #description>
                    Create a new whatsapp receiver for sender {{ sender.name }}.
                </template>

                <template #form>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="input-type" value="Type*"/>

                        <SelectInput
                            v-model="formCreateReceiver.type"
                            id="input-type"
                            name="type"
                            :options="typeOptions"
                            class="mt-1 block w-full"
                        />

                        <InputError :message="formCreateReceiver.errors.type" class="mt-2"/>
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="input-name" value="Name*"/>

                        <TextInput
                            v-model="formCreateReceiver.name"
                            id="input-name"
                            name="name"
                            maxlength="255"
                            class="mt-1 block w-full"
                        />

                        <InputError :message="formCreateReceiver.errors.name" class="mt-2"/>
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="input-whatsapp-id" value="Whatsapp ID*"/>

                        <TextInput
                            v-model="formCreateReceiver.whatsapp_id"
                            id="input-whatsapp-id"
                            name="whatsapp_id"
                            maxlength="255"
                            class="mt-1 block w-full"
                        >
                            <template #help>
                                When you select type person, please enter the receiver phone number according to the
                                <WhatsappInternationalPhoneNumberFormatLink/>.
                            </template>
                        </TextInput>

                        <InputError :message="formCreateReceiver.errors.whatsapp_id" class="mt-2"/>
                    </div>
                </template>

                <template #actions>
                    <PrimaryButton
                        class="ml-3"
                        :class="{ 'opacity-25': formCreateReceiver.processing }"
                        :disabled="formCreateReceiver.processing"
                        form="form-create-receiver"
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
