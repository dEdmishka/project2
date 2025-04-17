<script setup>
import Statistics from "@/components/Statistics.vue";
</script>

<template>
    <section
      id="about"
      class="py-24 sm:py-32"
    >
      <div class="bg-muted/50 border rounded-lg py-12">
        <div class="px-6 flex flex-col-reverse md:flex-row gap-8 md:gap-12">
          <img
            src="https://prototypr-media.sfo2.digitaloceanspaces.com/strapi/022144e6bc0a09bc5c9b68c6844f02d8png"
            alt="shadcn-ui"
            class="w-[300px] object-contain rounded-lg"
          />
          <div class="bg-green-0 flex flex-col justify-between">
            <div class="pb-6">
              <h2 class="text-3xl md:text-4xl font-bold">
                <span class="bg-gradient-to-b from-primary/60 to-primary text-transparent bg-clip-text">
                  About{{" "}}
                </span>
                Company
              </h2>
              <p class="text-xl text-muted-foreground mt-4">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                enim ad minim veniam, quis nostrud exercitation ullamco laboris
                nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit
                amet, consectetur adipiscing elit.
              </p>
            </div>

            <Statistics />
          </div>
        </div>
      </div>
    </section>
</template>
