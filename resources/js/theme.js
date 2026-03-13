import Aura from '@primevue/themes/aura';
import { definePreset } from '@primevue/themes';

const preset = definePreset(Aura, {
    semantic: {
        primary: {
            50: '#fafafa',
            100: '#f4f4f5',
            200: '#e4e4e7',
            300: '#d1d1d6',
            400: '#a1a1aa',
            500: '#71717a',
            600: '#52525b',
            700: '#3f3f46',
            800: '#27272a',
            900: '#18181b',
            950: '#09090b',
        },
        colorScheme: {
            light: {
                primary: {
                    color: '#09090b',
                    hoverColor: '#18181b',
                    activeColor: '#27272a',
                    contrastColor: '#ffffff',
                },
                surface: {
                    0: '#ffffff',
                    50: '#fafafa',
                    100: '#f4f4f5',
                    200: '#e4e4e7',
                    300: '#d4d4d8',
                    400: '#a1a1aa',
                    500: '#71717a',
                    600: '#52525b',
                    700: '#3f3f46',
                    800: '#27272a',
                    900: '#18181b',
                    950: '#09090b',
                }
            },
            dark: {
                primary: {
                    color: '#ffffff',
                    hoverColor: '#f4f4f5',
                    activeColor: '#e4e4e7',
                    contrastColor: '#09090b',
                },
                surface: {
                    0: '#ffffff',
                    50: '#fafafa',
                    100: '#f4f4f5',
                    200: '#e4e4e7',
                    300: '#d4d4d8',
                    400: '#a1a1aa',
                    500: '#71717a',
                    600: '#52525b',
                    700: '#3f3f46',
                    800: '#27272a',
                    900: '#18181b',
                    950: '#09090b',
                }
            }
        }
    }
});

export default preset;
