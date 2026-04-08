import {LockKeyhole, Sprout} from "lucide-vue-next";

export const adapterNamesConfig = {
    telegram: {
        label: 'Telegram',
        color: 'text-sky-500',
        description: 'Боты и интеграции',
        tagSeverity: 'info',
        borderColor: '!border-sky-500',
        slugs: {
            bot: {
                label: 'Telegram Bot',
                description: 'API интеграция',
            },
            green_api: {
                label: 'Telegram Green API',
                description: 'Green API интеграция',
            }
        }
    },
    whatsapp: {
        label: 'Whatsapp',
        color: 'text-green-500',
        description: 'Business & API',
        tagSeverity: 'success',
        borderColor: '!border-green-500',
        slugs: {
            green_api: {
                label: 'Whatsapp Green API',
                description: 'Green API интеграция'
            }
        }
    }
};

export const adapterTypesConfig = {
    bot: {
        icon: LockKeyhole,
        label: 'Bot',
    },
    green_api: {
        icon: Sprout,
        label: 'Green API',
    }
};
