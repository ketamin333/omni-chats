import { z } from 'zod';

export const createUserSchema = z.object({
    username: z.string().min(3, 'Минимум 3 символа').max(255, 'Максимум 255 символов'),
    email: z.string().email('Некорректный email'),
    password: z.string().min(8, 'Минимум 8 символов'),
    password_confirmation: z.string(),
    phone: z.string().optional().or(z.literal('')),
    role: z.enum(['admin', 'manager', 'user'], { message: 'Выберите роль' }),
}).superRefine((data, ctx) => {
    if (data.password !== data.password_confirmation) {
        ctx.addIssue({
            code: z.ZodIssueCode.custom,
            message: 'Пароли не совпадают',
            path: ['password_confirmation'],
        });
    }
});
