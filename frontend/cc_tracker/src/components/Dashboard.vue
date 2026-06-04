<template>
  <div class="dashboard">

    <h1>Debt Dashboard</h1>

    <!-- SUMMARY CARDS -->
    <div class="cards">
      <div class="card">
        <h3>Total Debt</h3>
        <p>₱{{ totalDebt }}</p>
      </div>

      <div class="card">
        <h3>Number of Debts</h3>
        <p>{{ debtStore.debts.length }}</p>
      </div>

      <div class="card">
        <h3>Highest Debt</h3>
        <p>₱{{ highestDebt }}</p>
      </div>
    </div>

    <!-- CHARTS GRID -->
    <div class="charts">

      <div class="chart-box">
        <h3>Debt Breakdown</h3>
        <canvas id="pieChart"></canvas>
      </div>

      <div class="chart-box">
        <h3>Debt Comparison</h3>
        <canvas id="barChart"></canvas>
      </div>

    </div>

  </div>
</template>


<script setup>
import { computed, watch, nextTick } from 'vue'
import { Chart, registerables } from 'chart.js'
import { onMounted } from 'vue'
import { useDebtStore } from '../stores/debtStore'

Chart.register(...registerables)

const debtStore = useDebtStore()

onMounted(() => {
    debtStore.fetchDebts()
})

const props = defineProps({
  debts: Array
})

let pieChartInstance = null
let barChartInstance = null

const totalDebt = computed(() => {
  return debtStore.debts.reduce((sum, d) => sum + Number(d.balance), 0)
})

const highestDebt = computed(() => {
  return Math.max(...debtStore.debts.map(d => Number(d.balance)))
})

function renderCharts() {

  if (!debtStore.debts.length) return

  if (pieChartInstance) pieChartInstance.destroy()
  if (barChartInstance) barChartInstance.destroy()

  const pieCtx = document.getElementById('pieChart')
  const barCtx = document.getElementById('barChart')

  pieChartInstance = new Chart(pieCtx, {
    type: 'pie',
    data: {
      labels: debtStore.debts.map(d => d.name),
      datasets: [{
        data: debtStore.debts.map(d => Number(d.balance))
      }]
    }
  })

  barChartInstance = new Chart(barCtx, {
    type: 'bar',
    data: {
      labels: debtStore.debts.map(d => d.name),
      datasets: [{
        data: debtStore.debts.map(d => Number(d.balance))
      }]
    }
  })
}

watch(
  () => debtStore.debts,
  async () => {
    await nextTick()
     if (!debtStore.debts || debtStore.debts.length === 0) return
    renderCharts()
  },
  { deep: true, immediate: true }
)
</script>

<style scoped>
.dashboard {
    padding: 20px;
}

.cards {
    display: flex;
    gap: 15px;
    margin-bottom: 20px;
}

.card {
    flex: 1;
    padding: 15px;
    background: #f5f5f5;
    border-radius: 10px;
    text-align: center;
}

.charts {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

.chart-box {
    flex: 1;
    min-width: 300px;
    padding: 15px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}
</style>