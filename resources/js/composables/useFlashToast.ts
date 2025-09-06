import { usePage } from '@inertiajs/vue3'
import { toast } from 'vue-sonner'
import { onMounted, watch } from 'vue'

interface FlashMessage {
    success?: string | null
    error?: string | null
}

export function useFlashToast() {
    const page = usePage<{ flash: FlashMessage }>()

    const showFlash = (flash: FlashMessage) => {
        if (flash.success) {
            console.log("Flash success:", flash.success)
            toast.success(flash.success, {
                style: { background: '#4BB543', color: 'white' },
                action: { label: 'Dismiss' },
            })
            flash.success = null
        }
        if (flash.error) {
            console.log("Flash error:", flash.error)
            toast.error(flash.error, {
                style: { background: '#f87171', color: 'white' },
                action: { label: 'Dismiss' },
            })
            flash.error = null
        }
    }

    onMounted(() => {
        showFlash(page.props.flash)
    })

    watch(
        () => page.props.flash,
        (newFlash) => {
            showFlash(newFlash)
        },
        { deep: true }
    )
}
