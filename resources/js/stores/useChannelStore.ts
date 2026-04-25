import { defineStore } from 'pinia'
import { ref } from 'vue'
import type { Channel } from '@/types/channel'
import { getChannels, deleteChannel } from '@/api/channels'

export const useChannelStore = defineStore('channels', () => {
    const channels = ref<Channel[]>([])
    const total = ref(0)
    const loading = ref(false)
    const page = ref(1)
    const perPage = 25

    const load = async () => {
        loading.value = true
        try {
            const response = (await getChannels(page.value)).data
            channels.value = response.data
            total.value = response.meta.total
        } finally {
            loading.value = false
        }
    }

    const onPage = async (event: { page: number }) => {
        page.value = event.page + 1
        await load()
    }

    const remove = async (channelId: number) => {
        await deleteChannel(channelId)
    }

    return { channels, total, loading, page, perPage, load, onPage, remove }
})
