<script setup>
import {Link} from '@inertiajs/inertia-vue3';
import {HeaderCell, Table} from '@protonemedia/inertiajs-tables-laravel-query-builder';
import {ChatBubbleBottomCenterTextIcon, InformationCircleIcon, PencilIcon, TrashIcon} from '@heroicons/vue/24/outline'
import {formatDateTime, titleCase} from '@/helpers.js';
import Dropdown from '@/Components/Dropdown.vue';

defineProps({
    sender: {
        type: Object,
        required: true
    },
    receivers: {
        type: Object,
        required: true
    }
})

defineEmits(['delete'])
</script>

<template>
    <Table :meta="receivers" preserve-scroll>
        <template #head="{ header }">
            <tr class="font-medium text-xs uppercase text-left tracking-wider text-gray-500 py-3 px-6">
                <HeaderCell :cell="header('index')">
                    #
                </HeaderCell>
                <HeaderCell :cell="header('type')">
                    Type
                </HeaderCell>
                <HeaderCell :cell="header('name')">
                    Name
                </HeaderCell>
                <HeaderCell :cell="header('whatsapp_id')">
                    Whatsapp ID
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
            <tr v-for="(receiver, index) of receivers.data" :key="receiver.id">
                <td>
                    {{ index + 1 }}
                </td>
                <td v-show="show('type')">
                    {{ titleCase(receiver.type) }}
                </td>
                <td v-show="show('name')">
                    {{ receiver.name }}
                </td>
                <td v-show="show('whatsapp_id')">
                    {{ receiver.whatsapp_id }}
                </td>
                <td v-show="show('created_at')">
                    {{ formatDateTime(receiver.created_at) }}
                </td>
                <td>
                    <Dropdown align="left" width="32">
                        <template #trigger>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 text-gray-400 cursor-pointer"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"
                                />
                            </svg>
                        </template>

                        <template #content>
                            <div role="menu" aria-orientation="vertical" aria-labelledby="sort-menu">
                                <div class="px-2">
                                    <ul class="divide-y divide-gray-200">
                                        <Link
                                            :href="route('senders.receivers.show', [sender, receiver])"
                                            class="flex items-center"
                                        >
                                            <li class="py-2 flex items-center cursor-pointer">
                                                <InformationCircleIcon class="w-5 h-5 mr-3"/>
                                                View
                                            </li>
                                        </Link>

                                        <Link
                                            :href="route('senders.receivers.send-message.index', [sender, receiver])"
                                            class="flex items-center"
                                        >
                                            <li class="py-2 flex items-center cursor-pointer">
                                                <ChatBubbleBottomCenterTextIcon class="w-5 h-5 mr-3"/>
                                                Send Message
                                            </li>
                                        </Link>

                                        <Link
                                            v-if="!receiver.log_messages_count"
                                            :href="route('senders.receivers.edit', [sender, receiver])"
                                            class="flex items-center"
                                        >
                                            <li class="py-2 flex items-center cursor-pointer">
                                                <PencilIcon class="w-5 h-5 mr-3"/>
                                                Edit
                                            </li>
                                        </Link>

                                        <li
                                            class="py-2 flex items-center cursor-pointer"
                                            @click.prevent="$emit('delete', receiver)"
                                        >
                                            <TrashIcon class="w-5 h-5 mr-3"/>
                                            Delete
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </template>
                    </Dropdown>
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
