<script setup>
import { isEmpty } from "lodash";

defineProps({
    items: {
        type: Array,
        default: () => []
    },
    bordered: Boolean,
    center: Boolean
})

</script>

<template>
    <div class="w-full max-h-screen lg:max-h-[30rem] overflow-auto shadow-lg">
        <table class="min-w-full" :class="{ 'text-center': center, '[&_tr>*]:border': bordered }">
            <thead class="bg-slate-100">
                <tr>
                    <slot name="head" />
                </tr>
            </thead>
            <tbody>
                <template v-if="!isEmpty(items)">
                    <tr v-for="(item, key) in items">
                        <slot name="body" :item="item" :key="key"></slot>
                    </tr>
                </template>
                <tr v-else>
                    <td colspan="100%" class="text-slate-400 italic text-center p-4">Tidak ada data</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>