<script setup>
import {ref} from 'vue';
import {Link} from '@inertiajs/inertia-vue3';
import {PlusIcon} from '@heroicons/vue/24/outline'
import AppLayout from '@/Layouts/AppLayout.vue';
import ModalDeleteSender from '@/Components/Sender/ModalDeleteSender.vue';
import ModalLinkDevice from '@/Components/Sender/ModalLinkDevice.vue';
import ModalViewSender from '@/Components/Sender/ModalViewSender.vue';
import TableSenders from '@/Components/Sender/TableSenders.vue';

defineProps({
    senders: {
        type: Object,
        required: true
    }
})

const sender = ref(null)

const qrCodeDataUrl = ref(null)

const showModalViewSender = ref(false)

const showModalLinkDevice = ref(false)

const showModalDeleteSender = ref(false)

async function onOpenModalViewSender(data) {
    const response = await axios.get(route('senders.show', data))

    sender.value = response.data

    showModalViewSender.value = true
}

function onCloseModalViewSender() {
    showModalViewSender.value = false

    sender.value = null
}

async function onOpenModalLinkDevice(data) {
    const [showSenderResponse, createSessionResponse] = await Promise.all([
        axios.get(route('senders.show', data)),
        axios.get(route('senders.link_device', data))
    ])

    sender.value = showSenderResponse.data

    qrCodeDataUrl.value = createSessionResponse.data.qr_code_data_url

    showModalLinkDevice.value = true
}

function onCloseModalLinkDevice() {
    showModalLinkDevice.value = false

    sender.value = null

    showModalLinkDevice.value = null
}

function onOpenModalDeleteSender(data) {
    sender.value = data

    showModalDeleteSender.value = true
}

function onCloseModalDeleteSender() {
    showModalDeleteSender.value = false

    sender.value = null
}
</script>

<template>
    <AppLayout title="Senders">
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Senders
                </h2>

                <Link :href="route('senders.create')" class="flex justify-center items-center">
                    <PlusIcon class="w-3 h-3 mr-2" /> Create
                </Link>
            </div>
        </template>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <TableSenders
                :senders="senders"
                @linkDevice="onOpenModalLinkDevice"
                @delete="onOpenModalDeleteSender"
                @view="onOpenModalViewSender"
            />
        </div>

        <ModalViewSender v-if="showModalViewSender && sender" :sender="sender" @close="onCloseModalViewSender"/>

        <ModalLinkDevice
            v-if="showModalLinkDevice && sender && qrCodeDataUrl"
            :sender="sender"
            :qrCodeDataUrl="qrCodeDataUrl"
            @close="onCloseModalLinkDevice"
        />

        <ModalDeleteSender v-if="showModalDeleteSender && sender" :sender="sender" @close="onCloseModalDeleteSender"/>
    </AppLayout>
</template>

<style scoped>

</style>
