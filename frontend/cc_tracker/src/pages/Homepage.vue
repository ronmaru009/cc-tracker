<template>
  <div class="min-h-screen relative overflow-hidden">
    <!-- BACKGROUND -->
    <div class="particles">
      <!-- GLOW BLOBS -->

      <div class="blob blob-yellow"></div>
      <div class="blob blob-green"></div>
      <div class="blob blob-emerald"></div>
      <span
        v-for="n in 40"
        :key="n"
        class="particle"
        :style="{
          left: `${Math.random() * 100}%`,

          animationDuration: `${12 + Math.random() * 20}s`,

          animationDelay: `${Math.random() * 8}s`,

          width: `${2 + Math.random() * 6}px`,

          height: `${2 + Math.random() * 6}px`,
        }"
      ></span>
    </div>
    <div
      class="absolute inset-0 bg-cover bg-center scale-110 z-0 brightness-[0.80]"
      style="background-image: url(&quot;/img/forest-bg.jpeg&quot;)"
    ></div>

    <!-- DARK OVERLAY -->

    <div
      class="absolute top-[-200px] right-[-150px] w-[600px] h-[600px] rounded-full bg-yellow-300/20 blur-[140px]"
    ></div>

    <div
      class="absolute bottom-[-200px] left-[-150px] w-[500px] h-[500px] rounded-full bg-green-400/20 blur-[100px]"
    ></div>

    <!-- CONTENT -->

    <div class="relative z-10 p-6">
      <div
        class="min-h-[95vh] rounded-[42px] border border-white/10 bg-black/25 backdrop-blur-[3px] shadow-[0_20px_80px_rgba(0,0,0,0.45)] overflow-hidden p-6"
      >
        <!-- NAVBAR -->

        <nav
          class="flex items-center justify-between px-10 py-6 rounded-[40px] bg-white/[0.03] backdrop-blur-3xl border border-white/10 shadow-[0_8px_32px_rgba(0,0,0,0.35)] text-white"
        >
          <div class="flex items-center gap-3">
            <div
              class="w-12 h-12 rounded-2xl bg-yellow-400/20 flex items-center justify-center"
            >
              ✨
            </div>

            <div>
              <h1 class="font-bold text-xl">RONMAR'S FINANCE HUB</h1>

              <p class="text-white/60 text-sm">Manage. Track. Grow.</p>
            </div>
          </div>

          <div class="flex gap-10 text-lg">
            <router-link
              to="/dashboard"
              class="hover:text-yellow-300 transition-all duration-300"
            >
              Dashboard
            </router-link>

            <button>Cards</button>

            <button>Finance Calendar</button>

            <button>Contact Me</button>
          </div>
        </nav>

        <!-- HERO -->

        <section
          class="mt-10 grid grid-cols-1 lg:grid-cols-2 gap-10 items-center"
        >
          <!-- LEFT -->

          <div class="text-white max-w-[540px] space-y-6 lg:ml-12 lg:-mt-10">
            <div
              class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/10"
            >
              ✨ SMART FINANCE
            </div>

            <h1 class="text-[72px] tracking-[-4px] font-black leading-tight">
              Take Control
              <br />
              of Your Finances
            </h1>

            <p class="text-xl text-white/70 leading-relaxed">
              Track your cards, monitor balances, and manage your financial
              future in one beautiful dashboard.
            </p>

            <div class="flex gap-4">
              <router-link
                to="/dashboard"
                class="px-8 py-4 rounded-full bg-yellow-300/20 border border-yellow-200/20 backdrop-blur-xl hover:scale-105 hover:bg-yellow-300/30 transition-all duration-300 text-white inline-flex items-center justify-center"
              >
                View Dashboard
              </router-link>

              <button
                class="px-8 py-4 rounded-full bg-white/10 border border-white/10"
              >
                See How It Works
              </button>
            </div>
          </div>

          <!-- RIGHT -->

          <div class="relative flex justify-center items-center h-[600px]">
            <!-- CARD STACK -->

            <div class="relative">
              <div class="relative w-[550px] h-[400px] ml-20">
                <TiltCard
                  v-for="(card, index) in heroCards"
                  :key="card.id"
                  @mouseenter="hoveredCardId = card.id"
                  @mouseleave="hoveredCardId = null"
                  :style="{
                    transform: computeTransform(
                      getDisplayIndex(index, card.id),
                    ),
                    zIndex: 100 - getDisplayIndex(index, card.id),
                  }"
                >
                  <div class="absolute card-wrapper">
                    <img
                      :src="getCardImage(card.card_image || card.name)"
                      class="w-[380px] rounded-[28px] shadow-2xl transition-all duration-700"
                    />
                  </div>
                </TiltCard>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
</template>
<script setup>
import TiltCard from "../components/TiltCard.vue";
import { onMounted, computed, ref } from "vue";
import { useCardStore } from "../stores/cardStore";
import { getCardImage } from "../helpers/cardImages";

const cardStore = useCardStore();

const hoveredCardId = ref(null);

const heroCards = computed(() => {
  return cardStore.cards.slice(0, 3);
});

function getDisplayIndex(originalIndex, id) {
  if (!hoveredCardId.value) return originalIndex;
  const hoveredIdx = heroCards.value.findIndex(
    (c) => c.id === hoveredCardId.value,
  );
  if (hoveredIdx === -1) return originalIndex;
  if (id === hoveredCardId.value) return 0;
  if (originalIndex < hoveredIdx) return originalIndex + 1;
  return originalIndex;
}

function computeTransform(displayIndex) {
  return `rotate(${displayIndex * 6 - 6}deg) translateX(${displayIndex * 35}px) translateY(${displayIndex * 15}px)`;
}

onMounted(async () => {
  await cardStore.fetchCards();
});
</script>

<style scoped>
@keyframes float {
  0%,
  100% {
    transform: translateY(0px) rotate(-8deg);
  }

  50% {
    transform: translateY(-12px) rotate(-8deg);
  }
}

@keyframes floatSlow {
  0%,
  100% {
    transform: translateY(0px) rotate(12deg);
  }

  50% {
    transform: translateY(-18px) rotate(12deg);
  }
}

.animate-float {
  animation: float 4s ease-in-out infinite;
}

.animate-floatSlow {
  animation: floatSlow 6s ease-in-out infinite;
}
.card-wrapper {
  transition:
    transform 360ms cubic-bezier(0.2, 0.8, 0.2, 1),
    opacity 250ms ease;
  will-change: transform;
}
.particle {
  position: absolute;
  bottom: -20px;
  border-radius: 999px;
  background: radial-gradient(
    circle,
    rgba(255, 255, 200, 1) 0%,

    rgba(255, 220, 120, 0.9) 30%,

    rgba(255, 180, 0, 0.2) 70%,

    transparent 100%
  );

  animation:
    rise linear infinite,
    flicker 3s ease-in-out infinite;

  box-shadow:
    0 0 8px rgba(255, 220, 120, 0.8),
    0 0 18px rgba(255, 200, 80, 0.5),
    0 0 28px rgba(255, 180, 0, 0.3);

  opacity: 0.9;
}

/* RANDOM POSITIONS */

.particle:nth-child(1) {
  left: 10%;
  top: 80%;

  animation-duration: 18s;
}

.particle:nth-child(2) {
  left: 25%;
  top: 90%;

  animation-duration: 22s;
}

.particle:nth-child(3) {
  left: 40%;
  top: 70%;

  animation-duration: 16s;
}

.particle:nth-child(4) {
  left: 60%;
  top: 85%;

  animation-duration: 25s;
}

.particle:nth-child(5) {
  left: 75%;
  top: 95%;

  animation-duration: 20s;
}

/* DUPLICATE PATTERN */

.particle:nth-child(n) {
  left: calc(100% * var(--random-x));

  animation-duration: 15s;
}

@keyframes floatParticle {
  from {
    transform: translateY(0px) scale(1);

    opacity: 0;
  }

  10% {
    opacity: 1;
  }

  90% {
    opacity: 1;
  }

  to {
    transform: translateY(-120vh) scale(0.2);

    opacity: 0;
  }
}
.particles {
  position: absolute;

  inset: 0;

  overflow: hidden;

  z-index: 2;
}

.particle {
  position: absolute;

  bottom: -20px;

  width: 6px;

  height: 6px;

  border-radius: 999px;

  background: rgba(255, 255, 255, 0.5);

  animation: rise linear infinite;

  box-shadow: 0 0 12px rgba(255, 255, 255, 0.5);
}

@keyframes rise {
  from {
    transform: translateY(0);

    opacity: 0;
  }

  10% {
    opacity: 1;
  }

  90% {
    opacity: 1;
  }

  to {
    transform: translateY(-120vh) translateX(40px);

    opacity: 0;
  }
}

@keyframes flicker {
  0%,
  100% {
    opacity: 0.7;
  }

  25% {
    opacity: 1;
  }

  50% {
    opacity: 0.5;
  }

  75% {
    opacity: 0.9;
  }
}
.blob {
  position: absolute;

  border-radius: 999px;

  filter: blur(70px);

  opacity: 0.55;

  z-index: 3;

  animation: blobFloat 18s ease-in-out infinite;
}

/* YELLOW */

.blob-yellow {
  width: 500px;
  height: 500px;

  background: rgba(255, 208, 0, 0.45);

  top: -120px;
  right: -120px;
}

/* GREEN */

.blob-green {
  width: 450px;
  height: 450px;

  background: rgba(34, 197, 94, 0.4);

  bottom: -150px;
  left: -100px;

  animation-delay: 4s;
}

/* EMERALD */

.blob-emerald {
  width: 350px;
  height: 350px;

  background: rgba(16, 185, 129, 0.3);

  top: 30%;
  left: 45%;

  animation-delay: 8s;
}

@keyframes blobFloat {
  0%,
  100% {
    transform: translate(0px, 0px) scale(1);
  }

  25% {
    transform: translate(40px, -30px) scale(1.08);
  }

  50% {
    transform: translate(-20px, 40px) scale(0.95);
  }

  75% {
    transform: translate(30px, 20px) scale(1.04);
  }
}
</style>
