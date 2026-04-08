import {LockKeyhole, Building} from "lucide-vue-next";

export const providerConfig = {
    telegram: {
        description: 'Боты и интеграции',
        color: 'text-sky-500',
        tagSeverity: 'info',
        borderColor: '!border-sky-500'
    },
    whatsapp: {
        description: 'Business & Green API',
        color: 'text-green-500',
        tagSeverity: 'success',
        borderColor: '!border-green-500'
    },
};

export const typeConfig = {
    bot: { icon: LockKeyhole, description: 'Bot API' },
    business: { icon: Building },
};
