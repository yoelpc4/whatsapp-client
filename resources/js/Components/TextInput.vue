<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: {
        type: [String, Number],
        default: null
    },
    type: {
        type: String,
        default: 'text',
    },
    disabled: {
        type: Boolean,
        default: false,
    },
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        ref="input"
        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        :class="{ 'bg-gray-50': disabled }"
        :type="type"
        :value="modelValue"
        :disabled="disabled"
        v-bind="$attrs"
        @input="$emit('update:modelValue', $event.target.value)"
    />

    <div v-if="$slots.help" class="mt-2 text-xs text-gray-600">
        <slot name="help"></slot>
    </div>
</template>
