<template>
  <div class="grid grid-cols-2 gap-12 items-start">
    <!-- LEFT -->

    <div>
      <p class="text-violet-400 font-semibold mb-3">Selected Card</p>

      <div
        class="relative overflow-hidden rounded-[36px] border border-white/10 bg-white/5 backdrop-blur-2xl shadow-2xl shadow-black/20 p-6"
      >
        <!-- GLOW -->

        <div
          class="absolute top-[-100px] right-[-100px] w-[220px] h-[220px] rounded-full bg-violet-500/10 blur-3xl"
        ></div>

        <img
          :src="cardImagePreview"
          class="relative z-10 w-full rounded-3xl shadow-2xl shadow-black/30"
        />

        <!-- LAST FOUR -->

        <div
          class="absolute bottom-10 right-10 px-5 py-3 rounded-2xl bg-black/40 backdrop-blur-md border border-white/10 text-white font-semibold"
        >
          ••••
          {{ form.card_last_four || "0000" }}
        </div>
      </div>
    </div>

    <!-- RIGHT -->

    <div>
      <h2 class="text-white text-4xl font-bold mb-2">Card Details</h2>

      <p class="text-white/40 mb-10">Configure your credit card information</p>

      <!-- FORM -->

      <div class="space-y-6">
        <!-- NAME -->

        <div>
          <label class="form-label"> Card Name </label>

          <input
            v-model="form.name"
            class="glass-input"
            placeholder="
            Enter card name
          "
          />
        </div>

        <!-- GRID -->

        <div class="grid grid-cols-2 gap-5">
          <div>
            <label class="form-label"> Last 4 Digits </label>

            <input
              v-model="form.card_last_four"
              maxlength="4"
              class="glass-input"
              placeholder="
              1234
            "
            />
          </div>

          <div>
            <label class="form-label"> Credit Limit </label>

            <input
              v-model="form.credit_limit"
              type="number"
              class="glass-input"
              placeholder="
              ₱ 100000
            "
            />
          </div>
        </div>

        <!-- GRID -->

        <div class="grid grid-cols-2 gap-5">
          <div>
            <label class="form-label"> Interest Rate </label>

            <input
              v-model="form.interest_rate"
              type="number"
              class="glass-input"
              placeholder="
              %
            "
            />
          </div>

          <div>
            <label class="form-label"> Billing Day </label>

            <input
              v-model="form.billing_day"
              type="number"
              class="glass-input"
              placeholder="
              15
            "
            />
          </div>
        </div>

        <!-- DATE -->

        <div>
          <label class="form-label"> Date Received </label>

          <input v-model="form.start_date" type="date" class="glass-input" />
        </div>

        <!-- ACTIONS -->

        <div class="flex items-center justify-between pt-6">
          <button
            @click="emit('back')"
            class="px-6 py-4 rounded-2xl bg-white/10 border border-white/10 text-white transition-all duration-300 hover:bg-white/20"
          >
            ← Back
          </button>

          <button
            @click="submit"
            class="px-8 py-4 rounded-2xl bg-gradient-to-r from-violet-500 to-fuchsia-500 text-white font-semibold transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-violet-500/20"
          >
            {{ form.id ? "Update Card" : "Add Card" }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, computed } from "vue";
import { useCardStore } from "../stores/cardStore";
import { getCardImage } from "../helpers/cardImages";

const props = defineProps({
  card: Object,
});

const emit = defineEmits(["saved", "back"]);

const cardStore = useCardStore();

const form = ref({
  id: null,
  name: "",
  card_last_four: "",
  card_image: "",
  credit_limit: "",
  current_balance: 0,
  interest_rate: "",
  minimum_due: "",
  billing_day: "",
  due_day: "",
  start_date: "",
});

watch(
  () => props.card,
  (val) => {
    if (val) {
      form.value.id = val.id || null;
      form.value.name = val.name || "";
      form.value.card_last_four = val.card_last_four || "";
      form.value.credit_limit = val.credit_limit || "";
      form.value.current_balance = val.current_balance || 0;
      form.value.interest_rate = val.interest_rate || "";
      form.value.minimum_due = val.minimum_due || "";
      form.value.billing_day = val.billing_day || "";
      form.value.due_day = val.due_day || "";
      form.value.start_date = val.start_date || "";
      form.value.card_image = getCardImage(
        val.card_image || val.image || val.name,
      );
    }
  },
  { immediate: true },
);

const cardImagePreview = computed(() =>
  getCardImage(form.value.card_image || form.value.name),
);

async function submit() {
  if (form.value.id) {
    await cardStore.updateCard(form.value.id, form.value);
  } else {
    await cardStore.createCard(form.value);
  }

  emit("saved");
}
</script>
<style scoped>
.form-label {
  display: block;

  color: rgba(255, 255, 255, 0.7);

  margin-bottom: 10px;

  font-weight: 600;
}

.glass-input {
  width: 100%;

  padding: 16px 18px;

  border-radius: 20px;

  background: rgba(255, 255, 255, 0.05);

  border: 1px solid rgba(255, 255, 255, 0.1);

  backdrop-filter: blur(20px);

  color: white;

  outline: none;

  transition: 0.3s;
}

.glass-input:focus {
  border-color: rgba(139, 92, 246, 0.6);

  box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.15);
}

.glass-input::placeholder {
  color: rgba(255, 255, 255, 0.35);
}
</style>
