<script setup>
import {HeaderCell, Table} from '@protonemedia/inertiajs-tables-laravel-query-builder';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    senders: {
        type: Object,
        required: true
    }
})
</script>

<template>
    <AppLayout title="Senders">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Senders
            </h2>
        </template>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <Table :meta="senders">
                <template #head="{ header }">
                    <tr class="font-medium text-xs uppercase text-left tracking-wider text-gray-500 py-3 px-6">
                        <HeaderCell :cell="header('index')">
                            #
                        </HeaderCell>
                        <HeaderCell :cell="header('name')">
                            Name
                        </HeaderCell>
                        <HeaderCell :cell="header('phone')">
                            Phone
                        </HeaderCell>
                        <HeaderCell :cell="header('created_at')">
                            Created at
                        </HeaderCell>
                        <HeaderCell :cell="header('actions')">
                            Actions
                        </HeaderCell>
                    </tr>
                </template>

                <template #body="{ show }">
                    <tr v-for="(sender, index) of senders.data" :key="sender.id">
                        <td>
                            {{ index + 1 }}
                        </td>
                        <td v-show="show('name')">
                            {{ sender.name }}
                        </td>
                        <td v-show="show('phone')">
                            {{ sender.phone }}
                        </td>
                        <td v-show="show('created_at')">
                            {{ sender.created_at }}
                        </td>
                        <td></td>
                    </tr>
                </template>
            </Table>
        </div>
    </AppLayout>
</template>

<style scoped>
table td {
    font-size: 0.875rem;
    line-height: 1.25rem;
    padding: 1rem 1.5rem;
    --tw-text-opacity: 1;
    color: rgba(107, 114, 128, var(--tw-text-opacity));
    white-space: nowrap;
}

table tr:hover td {
    --tw-bg-opacity: 1;
    background-color: rgba(249, 250, 251, var(--tw-bg-opacity));
}
</style>
