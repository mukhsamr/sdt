import { usePage } from '@inertiajs/inertia-vue3'
import { defineStore } from 'pinia'

export const useSessionStore = defineStore('session', () => {
    const props = usePage().props.value

    const user = props.user
    const tipe = props.tipe

    return { user, tipe }
})