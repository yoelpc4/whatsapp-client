<script setup>
import {ref} from 'vue';
import {Link} from '@inertiajs/inertia-vue3';
import {PlusIcon} from '@heroicons/vue/24/outline'
import AppLayout from '@/Layouts/AppLayout.vue';
import ModalDeleteSender from '@/Components/Sender/ModalDeleteSender.vue';
import TableSenders from '@/Components/Sender/TableSenders.vue';

defineProps({
    senders: {
        type: Object,
        required: true
    },
})

const sender = ref(null)

const showModalDeleteSender = ref(false)

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
                    <PlusIcon class="w-3 h-3 mr-2"/>
                    Create
                </Link>
            </div>
        </template>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="px-4 py-5 bg-white mb-10 sm:p-6 shadow">
                <TableSenders :senders="senders" @delete="onOpenModalDeleteSender" />
            </div>
        </div>

        <ModalDeleteSender v-if="showModalDeleteSender && sender" :sender="sender" @close="onCloseModalDeleteSender"/>
    </AppLayout>
</template>

<style scoped>

</style>
