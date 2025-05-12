<script setup>
import { Link } from "@inertiajs/vue3"
</script>
<template>
    <footer id="footer">
        <hr class="w-23/24 mx-auto" />

        <section class="container mx-auto py-20 grid grid-cols-2 md:grid-cols-4 xl:grid-cols-6 gap-x-12 gap-y-8">
            <div class="col-span-full xl:col-span-2">
                <Link rel="noreferrer noopener" href="/" class="ml-2 font-bold text-xl flex">
                <div class="text-2xl font-bold">
                    <h1 class="inline">
                        <span
                            class="inline bg-gradient-to-r from-[#F596D3]  to-[#D247BF] text-transparent bg-clip-text">{{ $t('account.title.rehab') }}</span>
                        <span
                            class="inline bg-gradient-to-r from-[#61DAFB] via-[#1fc0f1] to-[#03a3d7] text-transparent bg-clip-text">{{ $t('account.title.system') }}</span>
                    </h1>
                </div>
                </Link>
            </div>

            <div class="flex flex-col gap-2">
                <h3 class="font-bold text-lg">{{ $t('pages.follow_us') }}</h3>
                <div>
                    <a rel="noreferrer noopener" href="#" class="opacity-60 hover:opacity-100 a-animate">
                        {{ $t('pages.github') }}
                    </a>
                </div>

                <div>
                    <a rel="noreferrer noopener" href="#" class="opacity-60 hover:opacity-100 a-animate">
                        {{ $t('pages.instagram') }}
                    </a>
                </div>

                <div>
                    <a rel="noreferrer noopener" href="#" class="opacity-60 hover:opacity-100 a-animate">
                        {{ $t('pages.telegram') }}
                    </a>
                </div>
            </div>

            <div class="flex flex-col gap-2">
                <h3 class="font-bold text-lg">{{ $t('pages.platforms') }}</h3>
                <div>
                    <a rel="noreferrer noopener" href="#" class="opacity-60 hover:opacity-100 a-animate">
                        {{ $t('pages.web') }}
                    </a>
                </div>

                <div>
                    <a rel="noreferrer noopener" href="#" class="opacity-60 hover:opacity-100 a-animate">
                        {{ $t('pages.mobile') }}
                    </a>
                </div>

                <div>
                    <a rel="noreferrer noopener" href="#" class="opacity-60 hover:opacity-100 a-animate">
                        {{ $t('pages.desktop') }}
                    </a>
                </div>
            </div>

            <div class="flex flex-col gap-2">
                <h3 class="font-bold text-lg">{{ $t('pages.about') }}</h3>
                <div>
                    <a rel="noreferrer noopener" href="#" class="opacity-60 hover:opacity-100 a-animate">
                        {{ $t('pages.features') }}
                    </a>
                </div>

                <div>
                    <a rel="noreferrer noopener" href="#" class="opacity-60 hover:opacity-100 a-animate">
                        {{ $t('pages.pricing') }}
                    </a>
                </div>

                <div>
                    <a rel="noreferrer noopener" href="#" class="opacity-60 hover:opacity-100 a-animate">
                        {{ $t('pages.faq') }}
                    </a>
                </div>
            </div>

            <div class="flex flex-col gap-2">
                <h3 class="font-bold text-lg">{{ $t('pages.community') }}</h3>
                <div>
                    <a rel="noreferrer noopener" href="#" class="opacity-60 hover:opacity-100 a-animate">
                        {{ $t('pages.youtube') }}
                    </a>
                </div>

                <div>
                    <a rel="noreferrer noopener" href="#" class="opacity-60 hover:opacity-100 a-animate">
                        {{ $t('pages.discord') }}
                    </a>
                </div>

                <div>
                    <a rel="noreferrer noopener" href="#" class="opacity-60 hover:opacity-100 a-animate">
                        {{ $t('pages.twitch') }}
                    </a>
                </div>
            </div>
        </section>

        <section class="container pb-14 text-center">
            <h3>
                &copy; 2025 Landing page made by{{ " " }}
                <a rel="noreferrer noopener" target="_blank" href="https://github.com/dEdmishka"
                    class="text-primary transition-all border-primary hover:border-b-2 a-animate">
                    Melnyk Mykhailo
                </a>
            </h3>
        </section>
    </footer>
</template>