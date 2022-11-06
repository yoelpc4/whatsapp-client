<script setup>
import {computed, nextTick, ref} from 'vue';
import {Link, useForm} from '@inertiajs/inertia-vue3';
import {ChevronLeftIcon} from '@heroicons/vue/24/outline'
import {useBannerStore} from '@/Stores/banner.js';
import {titleCase} from '@/helpers.js';
import AppLayout from '@/Layouts/AppLayout.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SelectInput from '@/Components/SelectInput.vue';
import TextInput from '@/Components/TextInput.vue';
import WhatsappInternationalPhoneNumberFormatLink from '@/Components/WhatsappInternationalPhoneNumberFormatLink.vue';

const props = defineProps({
    sender: {
        type: Object,
        required: true
    },
    receiver: {
        type: Object,
        required: true
    },
    types: {
        type: Array,
        required: true
    }
})

const {showDangerBanner} = useBannerStore()

const typeOptions = computed(() => props.types.reduce((options, type) => {
    options.push({
        text: titleCase(type),
        value: type,
    })

    return options
}, []))

const groups = ref([])

const formEditReceiver = useForm({
    type: props.receiver.type,
    name: props.receiver.name,
    whatsapp_id: props.receiver.whatsapp_id,
    group: null,
})

const isTypeGroup = computed(() => formEditReceiver.type === 'group')

if (isTypeGroup.value) {
    axios.get(route('senders.groups', props.sender))
        .then(({data}) => {
            groups.value = data

            formEditReceiver.group = groups.value.find(group => group.id === props.receiver.whatsapp_id)
        })
        .catch(error => {
            showDangerBanner(error.response.data.message)
        })
}

function onSubmit() {
    formEditReceiver.put(route('senders.receivers.update', [props.sender, props.receiver]), {
        preserveScroll: false
    })
}

async function onChangeType() {
    await nextTick()

    formEditReceiver.name = null

    formEditReceiver.whatsapp_id = null

    formEditReceiver.group = null

    groups.value = []

    if (isTypeGroup.value) {
        try {
            const {data} = await axios.get(route('senders.groups', props.sender))

            groups.value = data
        } catch (error) {
            showDangerBanner(error.response.data.message)
        }
    }
}

async function onChangeGroup() {
    await nextTick()

    formEditReceiver.name = formEditReceiver.group.name

    formEditReceiver.whatsapp_id = formEditReceiver.group.id
}
</script>

<template>
    <AppLayout title="Receivers">
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Edit Receiver
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
                    Edit Receiver
                </template>

                <template #description>
                    Edit existing whatsapp receiver of sender {{ sender.name }}.
                </template>

                <template #form>
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="input-type" value="Type*"/>

                        <SelectInput
                            v-model="formEditReceiver.type"
                            id="input-type"
                            name="type"
                            :options="typeOptions"
                            class="mt-1 block w-full"
                            @change="onChangeType"
                        />

                        <InputError :message="formEditReceiver.errors.type" class="mt-2"/>
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="input-name" value="Name*"/>

                        <SelectInput
                            v-if="isTypeGroup"
                            v-model="formEditReceiver.group"
                            id="input-name"
                            name="name"
                            :options="groups"
                            text-key="name"
                            value-key="id"
                            return-object
                            class="mt-1 block w-full"
                            @change="onChangeGroup"
                        />

                        <TextInput
                            v-else
                            v-model="formEditReceiver.name"
                            id="input-name"
                            name="name"
                            maxlength="255"
                            class="mt-1 block w-full"
                        />

                        <InputError :message="formEditReceiver.errors.name" class="mt-2"/>
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="input-whatsapp-id" value="Whatsapp ID*"/>

                        <TextInput
                            v-model="formEditReceiver.whatsapp_id"
                            id="input-whatsapp-id"
                            name="whatsapp_id"
                            maxlength="255"
                            :disabled="isTypeGroup"
                            class="mt-1 block w-full"
                        >
                            <template v-if="!isTypeGroup" #help>
                                Please enter the receiver phone number according to the
                                <WhatsappInternationalPhoneNumberFormatLink/>
                                .
                            </template>
                        </TextInput>

                        <InputError :message="formEditReceiver.errors.whatsapp_id" class="mt-2"/>
                    </div>
                </template>

                <template #actions>
                    <PrimaryButton
                        class="ml-3"
                        :class="{ 'opacity-25': formEditReceiver.processing }"
                        :disabled="formEditReceiver.processing"
                        form="form-edit-receiver"
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
