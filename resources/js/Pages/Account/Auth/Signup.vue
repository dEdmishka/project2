<script setup>
const description
    = 'A sign up form with first name, last name, email and password inside a card. There\'s an option to sign up with GitHub and a link to login if you already have an account'
const iframeHeight = '600px'
const containerClass = 'w-full h-screen flex items-center justify-center px-4'

import SignupForm from '@/components/account/auth/SignupForm.vue'
</script>

<template>
    <div class="flex h-screen w-full mx-auto items-center justify-center px-4">
        <SignupForm />
    </div>
</template>