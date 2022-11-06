import {ref} from 'vue'
import {defineStore} from 'pinia'

export const useBannerStore = defineStore('banner', () => {
    const bannerMessage = ref('')

    const bannerStyle = ref('success')

    function showBanner(message, style) {
        bannerMessage.value = message || ''

        bannerStyle.value = style || 'success'
    }

    function showSuccessBanner(message) {
        showBanner(message, 'success')
    }

    function showDangerBanner(message) {
        showBanner(message, 'danger')
    }

    return {
        bannerMessage,
        bannerStyle,
        showBanner,
        showSuccessBanner,
        showDangerBanner,
    }
})
