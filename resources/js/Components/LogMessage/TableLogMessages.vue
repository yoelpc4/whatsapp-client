<script setup>
import {HeaderCell, Table} from '@protonemedia/inertiajs-tables-laravel-query-builder';
import {formatDateTime, titleCase} from '@/helpers.js';

defineProps({
    sender: {
        type: Object,
        required: true
    },
    receiver: {
        type: Object,
        required: true
    },
    logMessages: {
        type: Object,
        required: true
    },
})

defineEmits(['delete'])
</script>

<template>
    <Table :meta="logMessages">
        <template #head="{ header }">
            <tr class="font-medium text-xs uppercase text-left tracking-wider text-gray-500 py-3 px-6">
                <HeaderCell :cell="header('index')">
                    #
                </HeaderCell>
                <HeaderCell :cell="header('message')">
                    Message
                </HeaderCell>
                <HeaderCell :cell="header('status')">
                    Status
                </HeaderCell>
                <HeaderCell :cell="header('created_at')">
                    Created at
                </HeaderCell>
                <HeaderCell :cell="header('updated_at')">
                    Updated at
                </HeaderCell>
            </tr>
        </template>

        <template #body="{ show }">
            <tr v-for="(logMessage, index) of logMessages.data" :key="logMessage.id">
                <td>
                    {{ index + 1 }}
                </td>
                <td v-show="show('message')">
                    {{ logMessage.message }}
                </td>
                <td v-show="show('status')">
                    {{ titleCase(logMessage.status) }}
                </td>
                <td v-show="show('created_at')">
                    {{ formatDateTime(logMessage.created_at) }}
                </td>
                <td v-show="show('updated_at')">
                    {{ formatDateTime(logMessage.updated_at) }}
                </td>
            </tr>
        </template>
    </Table>
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
