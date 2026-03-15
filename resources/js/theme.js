import Aura from '@primevue/themes/aura';
import { definePreset } from '@primevue/themes';

const preset = definePreset(Aura, {
    semantic: {
        colorScheme: {
            light: {
                primary: {
                    color: '#020617',
                    hoverColor: '#1E293b',
                    activeColor: '#334155',
                    contrastColor: '#FFF',
                },
                surface: {
                    0: '#000000',
                    50: '#232323',
                    700: '#94a3b8',
                    800: '#CBD5E1',
                    900: '#F8F8F6',
                    950: '#FFFFFF'
                },
                formField: {
                    color: '{surface.50}',
                    background: '{surface.950}',
                    borderColor: '{surface.800}',
                    hoverBorderColor: '{surface.700}'
                }
            },
            dark: {
                primary: {
                    color: '#FA233B',
                    hoverColor: '#FB394F',
                    activeColor: '#F90722',
                    contrastColor: '#FFF',
                },
                surface: {
                    0: '#FFFFFF',
                    50: '#F1F1F1',
                    700: '#303030',
                    800: '#242424',
                    900: '#121212',
                    950: '#060606',
                },
                formField: {
                    color: '{surface.0}',
                    background: '{surface.900}',
                    borderColor: '{surface.800}',
                    hoverBorderColor: '{surface.700}',
                }
            }
        },
    },
});

export default preset;
