<template>
  <div class="relative">
    <!-- TITLE -->

    <div class="mb-10">
      <h2 class="text-white text-4xl font-bold">Choose Your Bank</h2>

      <p class="text-white/40 mt-2">
        Select the bank that issued your credit card
      </p>
    </div>

    <!-- CAROUSEL -->

    <Swiper
      :modules="[EffectCoverflow, Mousewheel]"
      effect="coverflow"
      grab-cursor
      centered-slides
      slides-per-view="auto"
      mousewheel
      :coverflow-effect="{
        rotate: 20,
        stretch: 0,
        depth: 150,
        modifier: 1.5,
        slideShadows: false,
      }"
    >
      <SwiperSlide v-for="bank in banks" :key="bank.name">
        <button
          @click="$emit('selected', bank)"
          class="group relative overflow-hidden w-full h-[240px] rounded-[36px] border border-white/10 bg-white/5 backdrop-blur-2xl transition-all duration-500 hover:-translate-y-3 hover:scale-[1.02] hover:bg-white/10 hover:shadow-2xl hover:shadow-violet-500/20"
        >
          <!-- GLOW -->

          <div
            class="absolute top-[-60px] right-[-60px] w-[180px] h-[180px] rounded-full bg-violet-500/10 blur-3xl opacity-0 transition-all duration-500 group-hover:opacity-100"
          ></div>

          <!-- CONTENT -->

          <div
            class="relative z-10 h-full flex flex-col items-center justify-center px-6"
          >
            <!-- LOGO -->

            <div
              class="w-28 h-28 rounded-full bg-white/10 border border-white/10 backdrop-blur-xl flex items-center justify-center mb-8 transition-all duration-500 group-hover:scale-110 group-hover:rotate-3"
            >
              <img :src="bank.logo" class="w-16 h-16 object-contain" />
            </div>

            <!-- NAME -->

            <h2 class="text-white text-2xl font-bold">
              {{ bank.name }}
            </h2>
          </div>
        </button>
      </SwiperSlide>
    </Swiper>
  </div>
</template>

<script setup>
import { Swiper, SwiperSlide } from "swiper/vue";
import { EffectCoverflow, Mousewheel, FreeMode } from "swiper/modules";
import "swiper/css/mousewheel";
import "swiper/css";

defineEmits(["selected"]);

const banks = [
  {
    name: "BPI",
    logo: "/img/Banks/BPI.png",
  },

  {
    name: "Bank Of Commerce",
    logo: "/img/Banks/BOC.jpeg",
  },

  {
    name: "UnionBank",
    logo: "/img/Banks/UB.png",
  },

  {
    name: "RCBC",
    logo: "/img/Banks/RCBC.png",
  },

  {
    name: "EastWest",
    logo: "/img/Banks/EW.png",
  },

  {
    name: "Chinabank",
    logo: "/img/Banks/CBC.png",
  },

  {
    name: "Atome",
    logo: "/img/Banks/atome.png",
  },
];
</script>

<style scoped>
.bank-swiper {
  padding-bottom: 20px;
}

.bank-swiper,
.swiper-wrapper,
.swiper {
  width: 100%;
  padding-top: 40px;
  padding-bottom: 40px;
}

.swiper-slide {
  width: 220px !important;
}

.bank-card {
  width: 220px;
  height: 260px;

  border-radius: 32px;

  background: rgba(255, 255, 255, 0.05);

  border: 1px solid rgba(255, 255, 255, 0.1);

  backdrop-filter: blur(24px);

  display: flex;
  flex-direction: column;

  justify-content: center;
  align-items: center;

  transition: all 0.4s ease;
}

.bank-card img {
  width: 100px;
  height: 100px;

  object-fit: contain;

  margin-bottom: 20px;
}

.bank-card p {
  color: white;

  font-size: 18px;

  font-weight: 700;
}
</style>
