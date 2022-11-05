<script setup>
import {ref} from 'vue';
import {Link} from '@inertiajs/inertia-vue3';
import {PlusIcon} from '@heroicons/vue/24/outline'
import AppLayout from '@/Layouts/AppLayout.vue';
import ModalDeleteReceiver from '@/Components/Receiver/ModalDeleteReceiver.vue';
import TableReceivers from '@/Components/Receiver/TableReceivers.vue';

defineProps({
    receivers: {
        type: Object,
        required: true
    },
})

const receiver = ref(null)

const showModalDeleteReceiver = ref(false)

function onOpenModalDeleteReceiver(data) {
    receiver.value = data

    showModalDeleteReceiver.value = true
}

function onCloseModalDeleteReceiver() {
    showModalDeleteReceiver.value = false

    receiver.value = null
}
</script>

<template>
    <AppLayout title="Receivers">
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Receivers
                </h2>

                <Link :href="route('receivers.create')" class="flex justify-center items-center">
                    <PlusIcon class="w-3 h-3 mr-2"/>
                    Create
                </Link>
            </div>
        </template>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="px-4 py-5 bg-white mb-10 sm:p-6 shadow">
                <TableReceivers :receivers="receivers" @delete="onOpenModalDeleteReceiver" />
            </div>
        </div>

        <ModalDeleteReceiver v-if="showModalDeleteReceiver && receiver" :receiver="receiver" @close="onCloseModalDeleteReceiver"/>
    </AppLayout>
</template>

<style scoped>

</style>
