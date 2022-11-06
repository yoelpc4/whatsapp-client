<script setup>
import {computed, onMounted, ref} from 'vue';

const props = defineProps({
    modelValue: {
        type: [String, Number, Object],
        default: null
    },
    options: {
        type: Array,
        default: []
    },
    disabled: {
        type: Boolean,
        default: false
    },
    textKey: {
        type: String,
        default: 'text'
    },
    valueKey: {
        type: String,
        default: 'value'
    },
    returnObject: {
        type: Boolean,
        default: false
    },
});

const emit = defineEmits(['update:modelValue']);

const input = ref(null);

const selectValue = computed(() => {
    if (props.returnObject) {
        return props.modelValue ? props.modelValue[props.valueKey] : null
    }

    return props.modelValue
})

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });

function onChange(event) {
    if (props.returnObject) {
        const option = props.options.find(option => option[props.valueKey] === event.target.value)

        emit('update:modelValue', option)

        return
    }

    emit('update:modelValue', event.target.value)
}
</script>

<template>
    <select
        ref="input"
        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        :class="{ 'bg-gray-50': disabled }"
        :value="selectValue"
        :disabled="disabled"
        v-bind="$attrs"
        @change="onChange($event)"
    >
        <option value="" disabled>Select one option</option>

        <option v-for="option of options" :key="option[valueKey]" :value="option[valueKey]">
            {{ option[textKey] }}
        </option>
    </select>

    <div v-if="$slots.help" class="mt-2 text-xs text-gray-600">
        <slot name="help"></slot>
    </div>
</template>
