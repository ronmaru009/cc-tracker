<template>
  <Teleport to="body">
    <div
      class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/50 backdrop-blur-md p-6"
      @click="$emit('close')"
    >
      <!-- MODAL -->

      <div class="relative max-h-[90vh] overflow-hidden" @click.stop>
        <!-- CLOSE -->

        <button
          @click="$emit('close')"
          class="absolute top-5 right-5 z-50 w-11 h-11 rounded-2xl bg-white/10 border border-white/10 backdrop-blur-xl text-white text-xl transition-all duration-300 hover:scale-105 hover:bg-white/20"
        >
          ×
        </button>

        <!-- CONTENT -->

        <slot />
      </div>
    </div>
  </Teleport>
</template>

<script setup>
defineEmits(["close"]);
</script>
