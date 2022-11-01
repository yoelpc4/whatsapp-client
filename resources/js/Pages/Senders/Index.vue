<script setup>
import {ref} from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import ModalViewSender from '@/Components/Sender/ModalViewSender.vue';
import TableSenders from '@/Components/Sender/TableSenders.vue';

defineProps({
    senders: {
        type: Object,
        required: true
    }
})

const sender = ref(null)

const showModalViewSender = ref(false)

async function onOpenModalViewSender(senderId) {
    const response = await axios.get(route('senders.show', senderId))

    sender.value = response.data

    showModalViewSender.value = true
}

function onCloseModalViewSender() {
    showModalViewSender.value = false

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
            <TableSenders :senders="senders" @view="onOpenModalViewSender" />
        </div>
    </AppLayout>

    <ModalViewSender :show="showModalViewSender" :sender="sender" @close="onCloseModalViewSender" />
</template>

<style scoped>

</style>
