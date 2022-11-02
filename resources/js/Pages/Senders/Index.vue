<script setup>
import {ref} from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import FormCreateSender from '@/Components/Sender/FormCreateSender.vue';
import ModalDeleteSender from '@/Components/Sender/ModalDeleteSender.vue';
import ModalViewSender from '@/Components/Sender/ModalViewSender.vue';
import SectionBorder from '@/Components/SectionBorder.vue';
import TableSenders from '@/Components/Sender/TableSenders.vue';

defineProps({
    senders: {
        type: Object,
        required: true
    }
})

const sender = ref(null)

const showModalViewSender = ref(false)

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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Senders
            </h2>
        </template>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <FormCreateSender />

            <SectionBorder />

            <TableSenders :senders="senders" @view="onOpenModalViewSender" @delete="onOpenModalDeleteSender" />
        </div>

        <ModalViewSender :show="showModalViewSender" :sender="sender" @close="onCloseModalViewSender" />

        <ModalDeleteSender :show="showModalDeleteSender" :sender="sender" @close="onCloseModalDeleteSender" />
    </AppLayout>
</template>

<style scoped>

</style>
