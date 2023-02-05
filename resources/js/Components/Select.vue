<script setup>
import { uniqueId } from "lodash";

defineProps({
    label: String,
    required: Boolean,

    modelValue: String | Number,
})

defineEmits(['update:modelValue'])

const id = uniqueId('input-')

</script>

<template>
    <div>
        <label :for="id" :class="required ? `after:content-['*'] after:ml-1 after:text-red-500` : false" v-if="label">
            {{ label }}
        </label>

        <select
            class="form-select appearance-none block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
            :value="modelValue" :required="required" @input="$emit('update:modelValue', $event.target.value)"
            v-bind="$attrs">
            <slot />
        </select>
    </div>
</template>

<script>
export default {
    inheritAttrs: false,
}
</script>