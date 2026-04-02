import Aura from '@primevue/themes/aura';
import { definePreset } from '@primevue/themes';

const preset = definePreset(Aura, {
    semantic: {
        primary: {
            50: '{zinc.50}',
            100: '{zinc.100}',
            200: '{zinc.200}',
            300: '{zinc.300}',
            400: '{zinc.400}',
            500: '{zinc.500}',
            600: '{zinc.600}',
            700: '{zinc.700}',
            800: '{zinc.800}',
            900: '{zinc.900}',
            950: '{zinc.950}',
        },
        colorScheme: {
            light: {
                primary: {
                    color: '{zinc.950}',
                    inverseColor: '#FFFFFF',
                    hoverColor: '{zinc.900}',
                    activeColor: '{zinc.800}',
                    contrastColor: '#FFFFFF',
                },
                surface: {
                    0: '#FFFFFF',
                    50: '#F8F8F6',
                    100: '#ECECEA',
                    200: '{zinc.200}',
                    300: '{zinc.300}',
                    400: '{zinc.400}',
                    500: '#817E78',
                    600: '{zinc.600}',
                    700: '{zinc.700}',
                    800: '{zinc.800}',
                    900: '{zinc.900}',
                    950: '{zinc.950}',
                },
                highlight: {
                    background: '{primary.950}',
                    color: '{primary.50}',
                },
            },
            dark: {
                primary: {
                    color: '{zinc.50}',
                    inverseColor: '{zinc.950}',
                    hoverColor: '{zinc.100}',
                    activeColor: '{zinc.200}',
                    contrastColor: '{zinc.950}',
                },
                surface: {
                    0: '#FFFFFF',
                    50: '{zinc.50}',
                    100: '{zinc.100}',
                    200: '{zinc.200}',
                    300: '{zinc.300}',
                    400: '{zinc.400}',
                    500: '{zinc.500}',
                    600: '{zinc.600}',
                    700: '{zinc.700}',
                    800: '{zinc.800}',
                    900: '{zinc.900}',
                    950: '{zinc.950}',
                },
            }
        }
    },
    components: {
        datatable: {
            headerCell: {},
            header: {
                borderColor: 'transparent'
            },
            bodyCell: {
                borderColor: 'transparent'
            },
            paginatorBottom: {
                borderColor: 'transparent',
            },
        },
        dialog: {
            content: {padding: 0},
            footer: {padding: 0},
            header: {padding: 0},
        },
        paginator: {
            navButton: {
                width: '2rem',
                height: '2rem',
            }
        },
        tabs: {
            tabpanel: { padding: '1.5rem' },
            tab: {
                font: { weight: 500 },
            }
        },
        badge: {
            colorScheme: {
                light: {
                    danger: {
                        background: '{red.100}',
                        color: '{red.500}',
                    },
                    info: {
                        background: '{indigo.100}',
                        color: '{indigo.500}',
                    },
                    secondary: {
                        background: '{neutral.100}',
                        color: '{neutral.500}',
                    }
                }
            }
        },
    }
});

export default preset;
