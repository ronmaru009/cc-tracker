<template>
  <BaseModal @close="$emit('cancel')">
    <div
      class="relative overflow-hidden w-[480px] rounded-[36px] border border-white/10 bg-black/40 backdrop-blur-3xl shadow-2xl shadow-red-500/10 p-8"
    >
      <!-- GLOW -->

      <div
        class="absolute top-[-100px] right-[-100px] w-[220px] h-[220px] rounded-full bg-red-500/10 blur-3xl"
      ></div>

      <!-- CONTENT -->

      <div class="relative z-10 text-center">
        <!-- ICON -->

        <div
          class="mx-auto mb-6 w-20 h-20 rounded-full bg-red-500/10 border border-red-500/20 flex items-center justify-center text-red-400 text-4xl"
        >
          !
        </div>

        <!-- TITLE -->

        <h2 class="text-white text-3xl font-bold mb-4">
          {{ title }}
        </h2>

        <!-- MESSAGE -->

        <p class="text-white/50 leading-relaxed mb-8">
          {{ message }}
        </p>

        <!-- ACTIONS -->

        <div class="flex gap-4">
          <button
            @click="$emit('cancel')"
            class="flex-1 py-4 rounded-2xl bg-white/10 border border-white/10 text-white font-semibold transition-all duration-300 hover:bg-white/20"
          >
            Cancel
          </button>

          <button
            @click="$emit('confirm')"
            class="flex-1 py-4 rounded-2xl bg-gradient-to-r from-red-500 to-rose-500 text-white font-semibold transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl hover:shadow-red-500/20"
          >
            Confirm
          </button>
        </div>
      </div>
    </div>
  </BaseModal>
</template>

<script setup>
import BaseModal from "./BaseModal.vue";

defineProps({
  title: {
    type: String,

    default: "Confirm Action",
  },

  message: {
    type: String,

    default: "Are you sure?",
  },
});

defineEmits(["confirm", "cancel"]);
</script>
