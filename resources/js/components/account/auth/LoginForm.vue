<script setup>
import { Button } from '@/components/ui/button'
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'

import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { Link } from "@inertiajs/vue3"

const form = useForm({
    email: '',
    password: '',
});

const errors = ref({});

const submit = () => {
    form.post('/login', {
        onError: (error) => {
            errors.value = error;
        }
    })
};
</script>

<template>
    <Card class="w-full max-w-sm">
        <CardHeader>
            <CardTitle class="text-2xl">
                {{ $t('account.auth.login') }}
            </CardTitle>
            <CardDescription>
                {{ $t('account.auth.enter_email') }}
            </CardDescription>
        </CardHeader>
        <CardContent>
            <form @submit.prevent="submit">
                <div class="grid gap-4">
                    <div class="grid gap-2">
                        <Label for="email">{{ $t('account.auth.email') }}</Label>
                        <Input id="email" type="email" v-model="form.email" :class="{ 'is-invalid': errors.email }"
                            required />
                        <span v-if="errors.email" class="text-red-600 text-sm">{{ errors.email }}</span>
                    </div>
                    <div class="grid gap-2">
                        <div class="flex items-center">
                            <Label for="password">{{ $t('account.auth.password') }}</Label>
                            <a href="#" class="ml-auto inline-block text-sm a-animate">
                                {{ $t('account.auth.forgot_password') }}
                            </a>
                        </div>
                        <Input id="password" type="password" v-model="form.password" required />
                    </div>
                    <Button type="submit" class="w-full">
                        {{ $t('account.auth.login') }}
                    </Button>
                    <Button variant="outline" class="w-full">
                        {{ $t('account.auth.login_google') }}
                    </Button>
                </div>
                <div class="mt-4 text-center text-sm">
                    {{ $t('account.auth.dont_have_account') }}
                    <Link href="/signup" class="a-animate">
                    {{ $t('account.auth.signup') }}
                    </Link>
                </div>
            </form>
        </CardContent>
    </Card>
</template>
