<script setup>
import { Button } from '@/components/ui/button'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'

import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { Link } from "@inertiajs/vue3";

const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const errors = ref({});

const submit = () => {
    form.post('/signup', {
        onError: (error) => {
            errors.value = error;
        }
    });
};
</script>

<template>
    <Card class="mx-auto max-w-sm">
        <CardHeader>
            <CardTitle class="text-xl">
                {{ $t('account.auth.signup') }}
            </CardTitle>
            <CardDescription>
                {{ $t('account.auth.enter_info') }}
            </CardDescription>
        </CardHeader>
        <CardContent>
            <form @submit.prevent="submit">
                <div class="grid gap-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="grid gap-2">
                            <Label for="first-name">{{ $t('account.auth.first_name') }}</Label>
                            <Input id="first-name" v-model="form.first_name"
                                :class="{ 'is-invalid': errors.first_name }" required autocomplete="false" />
                            <span v-if="errors.first_name" class="text-red-600 text-sm">{{ errors.first_name }}</span>
                        </div>
                        <div class="grid gap-2">
                            <Label for="last-name">{{ $t('account.auth.last_name') }}</Label>
                            <Input id="last-name" v-model="form.last_name" :class="{ 'is-invalid': errors.last_name }"
                                required autocomplete="false" />
                            <span v-if="errors.last_name" class="text-red-600 text-sm">{{ errors.last_name }}</span>
                        </div>
                    </div>
                    <div class="grid gap-2">
                        <Label for="email">{{ $t('account.auth.email') }}</Label>
                        <Input id="email" type="email" v-model="form.email" :class="{ 'is-invalid': errors.email }"
                            required autocomplete="false" />
                        <span v-if="errors.email" class="text-red-600 text-sm">{{ errors.email }}</span>
                    </div>
                    <div class="grid gap-2">
                        <Label for="password">{{ $t('account.auth.password') }}</Label>
                        <Input id="password" type="password" v-model="form.password"
                            :class="{ 'is-invalid': errors.password }" required />
                        <span v-if="errors.password" class="text-red-600 text-sm">{{ errors.password }}</span>
                    </div>
                    <div class="grid gap-2">
                        <Label for="password_confirmation">{{ $t('account.auth.confirm_password') }}</Label>
                        <Input id="password_confirmation" type="password" v-model="form.password_confirmation" />
                    </div>
                    <Button type="submit" class="w-full">
                        {{ $t('account.auth.create_account') }}
                    </Button>
                    <Button variant="outline" class="w-full">
                        {{ $t('account.auth.signup_google') }}
                    </Button>
                </div>
                <div class="mt-4 text-center text-sm">
                    {{ $t('account.auth.already_have_account') }}
                    <Link href="/login" class="a-animate">
                    {{ $t('account.auth.signin') }}
                    </Link>
                </div>
            </form>
        </CardContent>
    </Card>
</template>