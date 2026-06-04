<template>
  <div class="min-h-screen p-8">
    <!-- HEADER -->

    <div class="flex justify-between items-center mb-10">
      <div class="flex items-center gap-4">
        <button
          @click="goBack"
          class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-xl text-white text-xl transition-all duration-300 hover:scale-105 hover:bg-white/10"
        >
          ←
        </button>

        <div>
          <h1 class="text-white text-4xl font-bold">Bills</h1>

          <p class="text-white/40 mt-1">Track recurring bills and payments</p>
        </div>
      </div>

      <button
        @click="showModal = true"
        class="px-5 py-3 rounded-2xl bg-violet-500 text-white font-semibold transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-violet-500/20"
      >
        Add Bill
      </button>
    </div>

    <!-- BILLS GRID -->

    <!-- DASHBOARD LAYOUT -->

    <div class="grid grid-cols-12 gap-6">
      <!-- ACTIVE BILLS -->

      <div class="col-span-8">
        <h2 class="text-white text-2xl font-bold mb-6">Active Bills</h2>

        <div class="grid grid-cols-2 gap-6">
          <div
            v-for="[month, monthBills] in activeMonths"
            :key="month"
            class="relative overflow-hidden rounded-[28px] border border-white/10 bg-white/5 backdrop-blur-2xl shadow-xl shadow-black/20 h-[400px] flex flex-col min-h-0"
          >
            <div
              class="absolute top-[-100px] right-[-100px] w-[220px] h-[220px] rounded-full bg-violet-500/10 blur-3xl"
            ></div>

            <div class="relative z-10 flex flex-col h-full">
              <div class="px-6 py-5 border-b border-white/10">
                <h2 class="text-white text-2xl font-bold">
                  {{ month }}
                </h2>
              </div>

              <div class="divide-y divide-white/5 overflow-y-auto flex-1">
                <div
                  v-for="bill in monthBills"
                  :key="bill.id"
                  class="flex items-center justify-between px-6 py-4 hover:bg-white/5 transition-all"
                >
                  <div>
                    <h3
                      class="text-white font-semibold"
                      :class="
                        bill.is_paid
                          ? 'line-through text-green-400 opacity-60'
                          : ''
                      "
                    >
                      {{ bill.biller?.name }}
                    </h3>

                    <p class="text-white/40 text-sm mt-1">
                      {{ new Date(bill.due_date).toLocaleDateString() }}
                    </p>
                  </div>

                  <div class="flex items-center gap-4">
                    <div class="text-violet-400 font-bold">
                      ₱{{ formatMoney(bill.amount) }}
                    </div>

                    <input
                      type="checkbox"
                      :checked="bill.is_paid"
                      @change="toggleBill(bill.id)"
                      class="w-5 h-5 accent-violet-500"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- COMPLETED MONTHS -->

      <div class="col-span-4">
        <div class="flex items-center justify-between mb-6">
          <h2 class="text-white text-2xl font-bold">Completed</h2>

          <div
            class="px-3 py-1 rounded-full bg-green-500/10 border border-green-500/20 text-green-400 text-sm"
          >
            {{ completedMonths.length }}
          </div>
        </div>

        <div class="space-y-3">
          <div
            v-for="[month, monthBills] in completedMonths"
            :key="month"
            class="rounded-[24px] border border-white/10 bg-white/5 backdrop-blur-xl overflow-hidden"
          >
            <button
              @click="toggleMonth(month)"
              class="w-full flex justify-between items-center px-5 py-4 hover:bg-white/5 transition-all"
            >
              <div>
                <h3 class="text-white font-semibold">
                  {{ month }}
                </h3>

                <p class="text-green-400 text-xs mt-1">✓ Paid</p>
              </div>

              <span class="text-white/50">
                {{ collapsedMonths.includes(month) ? "−" : "+" }}
              </span>
            </button>

            <div
              v-if="collapsedMonths.includes(month)"
              class="border-t border-white/10"
            >
              <div
                v-for="bill in monthBills"
                :key="bill.id"
                class="flex justify-between px-5 py-3"
              >
                <span class="text-green-400 line-through text-sm">
                  {{ bill.biller?.name }}
                </span>

                <span class="text-white/50 text-sm">
                  ₱{{ formatMoney(bill.amount) }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- MODAL -->

    <div
      v-if="showModal"
      class="fixed inset-0 bg-black/40 backdrop-blur-md flex items-center justify-center z-50"
    >
      <div
        class="relative overflow-hidden p-10 w-[720px] rounded-[36px] border border-white/10 bg-black/40 backdrop-blur-3xl shadow-2xl shadow-violet-500/10"
      >
        <!-- GLOW -->

        <div
          class="absolute top-[-120px] left-[-120px] w-[260px] h-[260px] rounded-full bg-violet-500/20 blur-3xl"
        ></div>

        <div
          class="absolute bottom-[-120px] right-[-120px] w-[240px] h-[240px] rounded-full bg-fuchsia-500/20 blur-3xl"
        ></div>

        <div class="relative z-10">
          <!-- HEADER -->

          <div class="flex justify-between items-start mb-8">
            <div>
              <h2 class="text-white text-5xl font-bold">Add Bill</h2>

              <p class="text-white/50 mt-2 text-lg">
                Add a recurring bill and due date
              </p>
            </div>

            <button
              @click="showModal = false"
              class="w-12 h-12 rounded-full bg-white/10 text-white text-2xl hover:bg-white/20 transition-all"
            >
              ×
            </button>
          </div>

          <div class="mb-8">
            <!-- TOGGLE BUTTON -->

            <button
              @click="showBillerForm = !showBillerForm"
              class="px-5 py-3 rounded-2xl bg-white/5 border border-white/10 text-white hover:bg-white/10 transition-all"
            >
              {{ showBillerForm ? "Close Biller Manager" : "+ Add New Biller" }}
            </button>

            <!-- BILLER MANAGER -->

            <div
              v-if="showBillerForm"
              class="mt-5 rounded-3xl border border-white/10 bg-white/5 p-6"
            >
              <!-- CREATE -->

              <div class="flex gap-3 mb-6">
                <input
                  v-model="newBiller"
                  placeholder="
          Enter biller name
        "
                  class="input-modern"
                />

                <button
                  @click="createBiller"
                  class="px-6 rounded-2xl bg-gradient-to-r from-violet-500 to-fuchsia-500 text-white font-semibold"
                >
                  Add
                </button>
              </div>

              <!-- BILLER LIST -->

              <div class="max-h-[220px] overflow-y-auto space-y-3">
                <div
                  v-for="biller in billers"
                  :key="biller.id"
                  class="flex items-center justify-between bg-white/5 rounded-2xl px-4 py-3"
                >
                  <p class="text-white">
                    {{ biller.name }}
                  </p>

                  <button
                    @click="deleteBiller(biller.id)"
                    class="text-red-400 hover:text-red-300 transition-all"
                  >
                    Delete
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- FORM -->

          <div class="space-y-6">
            <!-- BILLER -->

            <div>
              <label class="text-white text-lg font-semibold mb-3 block">
                Select Biller
              </label>

              <select v-model="form.biller_id" class="input-modern">
                <option value="">Choose a biller</option>

                <option
                  v-for="biller in billers"
                  :key="biller.id"
                  :value="biller.id"
                >
                  {{ biller.name }}
                </option>
              </select>
            </div>

            <!-- AMOUNT + DATE -->

            <div class="grid grid-cols-2 gap-5">
              <div>
                <label class="text-white text-lg font-semibold mb-3 block">
                  Bill Amount
                </label>

                <input
                  v-model="form.amount"
                  type="number"
                  placeholder="₱ 0.00"
                  class="input-modern"
                />
              </div>

              <div>
                <label class="text-white text-lg font-semibold mb-3 block">
                  Due Date
                </label>

                <input
                  v-model="form.due_date"
                  type="date"
                  class="input-modern"
                />
              </div>
            </div>
          </div>

          <!-- ACTIONS -->

          <div class="flex justify-end gap-4 mt-10">
            <button
              @click="showModal = false"
              class="px-6 py-3 rounded-2xl bg-white/10 text-white font-semibold hover:bg-white/20 transition-all"
            >
              Cancel
            </button>

            <button
              @click="createBill"
              class="px-8 py-3 rounded-2xl bg-gradient-to-r from-violet-500 to-fuchsia-500 text-white font-semibold shadow-lg shadow-violet-500/20 hover:scale-105 transition-all"
            >
              Save Bill
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref, onMounted, computed } from "vue";
import BillService from "../services/BillService";
import { formatMoney } from "../utils/formatters";
import { useRouter } from "vue-router";

const bills = ref([]);
const billers = ref([]);
const showModal = ref(false);
const showBillerForm = ref(false);
const form = ref({
  biller_id: "",

  amount: "",

  due_date: "",
});
const newBiller = ref("");
const router = useRouter();
const collapsedMonths = ref([]);

function goBack() {
  router.push("/dashboard");
}

function toggleMonth(month) {
  if (collapsedMonths.value.includes(month)) {
    collapsedMonths.value = collapsedMonths.value.filter((m) => m !== month);
  } else {
    collapsedMonths.value.push(month);
  }
}

const activeMonths = computed(() => {
  return Object.entries(groupedBills.value).filter(([month, bills]) => {
    return bills.some((bill) => !bill.is_paid);
  });
});

const completedMonths = computed(() => {
  return Object.entries(groupedBills.value).filter(([month, bills]) => {
    return bills.every((bill) => bill.is_paid);
  });
});

const fetchBills = async () => {
  const data = await BillService.getBills();

  bills.value = data;
  console.log(data);
};

const fetchBillers = async () => {
  billers.value = await BillService.getBillers();
};

const createBill = async () => {
  await BillService.createBill(form.value);

  showModal.value = false;

  form.value = {
    biller_id: "",

    amount: "",

    due_date: "",
  };

  await fetchBills();
};

const createBiller = async () => {
  await BillService.createBiller({
    name: newBiller.value,
  });

  newBiller.value = "";

  fetchBillers();
};

const deleteBiller = async (id) => {
  await BillService.deleteBiller(id);

  fetchBillers();
};

const groupedBills = computed(() => {
  const groups = {};

  bills.value.forEach((bill) => {
    const month = new Date(bill.due_date).toLocaleString(
      "default",

      {
        month: "long",
        year: "numeric",
      },
    );

    if (!groups[month]) {
      groups[month] = [];
    }

    groups[month].push(bill);
  });

  return groups;
});

onMounted(() => {
  fetchBills();

  fetchBillers();
});

const toggleBill = async (id) => {
  await BillService.toggleBill(id);

  fetchBills();
};
</script>
