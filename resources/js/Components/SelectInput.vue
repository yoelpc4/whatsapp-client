<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: {
        type: [String, Number],
        default: null
    },
    options: {
        type: Array,
        default: []
    },
    placeholder: {
        type: String,
        required: true
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
    <select
        ref="input"
        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        :value="modelValue"
        v-bind="$attrs"
        @change="$emit('update:modelValue', $event.target.value)"
    >
        <option disabled value="" selected>
            {{ placeholder }}
        </option>

        <option v-for="option of options" :key="option.value" :value="option.value">
            {{ option.text }}
        </option>
    </select>

    <div v-if="$slots.help" class="mt-2 text-xs text-gray-600">
        <slot name="help"></slot>
    </div>
</template>
