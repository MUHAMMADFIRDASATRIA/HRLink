import { ref } from 'vue'

interface Toast {
    id: number
    message: string
    type: 'success' | 'error'
}

const toasts = ref<Toast[]>([])
let nextId = 0

export function useToast() {
    const addToast = (message: string, type: 'success' | 'error' = 'success', duration = 3000) => {
        const id = nextId++
        toasts.value.push({ id, message, type })
        setTimeout(() => removeToast(id), duration)
    }

    const removeToast = (id: number) => {
        toasts.value = toasts.value.filter(t => t.id !== id)
    }

    return { toasts, addToast, removeToast }
}