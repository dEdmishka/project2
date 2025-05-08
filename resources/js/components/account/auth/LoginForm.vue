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
                Login
            </CardTitle>
            <CardDescription>
                Enter your email below to login to your account
            </CardDescription>
        </CardHeader>
        <CardContent>
            <form @submit.prevent="submit">
                <div class="grid gap-4">
                    <div class="grid gap-2">
                        <Label for="email">Email</Label>
                        <Input id="email" type="email" v-model="form.email" :class="{ 'is-invalid': errors.email }"
                            required />
                        <span v-if="errors.email" class="text-red-600 text-sm">{{ errors.email }}</span>
                    </div>
                    <div class="grid gap-2">
                        <div class="flex items-center">
                            <Label for="password">Password</Label>
                            <a href="#" class="ml-auto inline-block text-sm a-animate">
                                Forgot your password?
                            </a>
                        </div>
                        <Input id="password" type="password" v-model="form.password" required />
                    </div>
                    <Button type="submit" class="w-full">
                        Login
                    </Button>
                    <Button variant="outline" class="w-full">
                        Login with Google
                    </Button>
                </div>
                <div class="mt-4 text-center text-sm">
                    Don't have an account?
                    <Link href="/signup" class="a-animate">
                    Sign up
                    </Link>
                </div>
            </form>
        </CardContent>
    </Card>
</template>
