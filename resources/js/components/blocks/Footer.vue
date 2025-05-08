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
                            class="inline bg-gradient-to-r from-[#F596D3]  to-[#D247BF] text-transparent bg-clip-text">Rehab</span>
                        <span
                            class="inline bg-gradient-to-r from-[#61DAFB] via-[#1fc0f1] to-[#03a3d7] text-transparent bg-clip-text">System</span>
                    </h1>
                </div>
                </Link>
            </div>

            <div class="flex flex-col gap-2">
                <h3 class="font-bold text-lg">Follow US</h3>
                <div>
                    <a rel="noreferrer noopener" href="#" class="opacity-60 hover:opacity-100 a-animate">
                        Github
                    </a>
                </div>

                <div>
                    <a rel="noreferrer noopener" href="#" class="opacity-60 hover:opacity-100 a-animate">
                        Instagram
                    </a>
                </div>

                <div>
                    <a rel="noreferrer noopener" href="#" class="opacity-60 hover:opacity-100 a-animate">
                        Telegram
                    </a>
                </div>
            </div>

            <div class="flex flex-col gap-2">
                <h3 class="font-bold text-lg">Platforms</h3>
                <div>
                    <a rel="noreferrer noopener" href="#" class="opacity-60 hover:opacity-100 a-animate">
                        Web
                    </a>
                </div>

                <div>
                    <a rel="noreferrer noopener" href="#" class="opacity-60 hover:opacity-100 a-animate">
                        Mobile
                    </a>
                </div>

                <div>
                    <a rel="noreferrer noopener" href="#" class="opacity-60 hover:opacity-100 a-animate">
                        Desktop
                    </a>
                </div>
            </div>

            <div class="flex flex-col gap-2">
                <h3 class="font-bold text-lg">About</h3>
                <div>
                    <a rel="noreferrer noopener" href="#" class="opacity-60 hover:opacity-100 a-animate">
                        Features
                    </a>
                </div>

                <div>
                    <a rel="noreferrer noopener" href="#" class="opacity-60 hover:opacity-100 a-animate">
                        Pricing
                    </a>
                </div>

                <div>
                    <a rel="noreferrer noopener" href="#" class="opacity-60 hover:opacity-100 a-animate">
                        FAQ
                    </a>
                </div>
            </div>

            <div class="flex flex-col gap-2">
                <h3 class="font-bold text-lg">Community</h3>
                <div>
                    <a rel="noreferrer noopener" href="#" class="opacity-60 hover:opacity-100 a-animate">
                        Youtube
                    </a>
                </div>

                <div>
                    <a rel="noreferrer noopener" href="#" class="opacity-60 hover:opacity-100 a-animate">
                        Discord
                    </a>
                </div>

                <div>
                    <a rel="noreferrer noopener" href="#" class="opacity-60 hover:opacity-100 a-animate">
                        Twitch
                    </a>
                </div>
            </div>
        </section>

        <section class="container pb-14 text-center">
            <h3>
                &copy; 2025 Landing page made by{{ " " }}
                <a rel="noreferrer noopener" target="_blank" href="https://www.linkedin.com/in/leopoldo-miranda/"
                    class="text-primary transition-all border-primary hover:border-b-2 a-animate">
                    Melnyk Mykhailo
                </a>
            </h3>
        </section>
    </footer>
</template>