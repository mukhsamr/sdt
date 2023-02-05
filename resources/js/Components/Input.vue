<script setup>
import { uniqueId } from "lodash";
import { onMounted } from "vue";

const props = defineProps({
    label: String,
    autofocus: Boolean,
    required: Boolean,

    modelValue: String | Number
})

defineEmits(['update:modelValue'])

const id = uniqueId('input-')

onMounted(() => {

    // Autofocus
    if (props.autofocus) {
        const input = document.querySelector('#' + id)
        input.focus()
    }
})

</script>

<template>
    <div class="grow">
        <label :for="id" class="form-label inline-block text-gray-700"
            :class="required ? `after:content-['*'] after:ml-1 after:text-red-500` : false" v-if="label">
            {{ label }}
        </label>
        <input type="text"
            class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none disabled:bg-slate-200"
            :id="id" v-bind="$attrs" @input="$emit('update:modelValue', $event.target.value)" :value="modelValue"
            :required="required" />
    </div>
</template>

<script>
export default {
    inheritAttrs: false
}
</script>