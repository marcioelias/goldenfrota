<template>
    <div class="container">
        <div class="row">
        <div class="col-md-6">
          <chart-card
            :chart-data="barChart.data"
            :chart-options="barChart.options"
            :chart-responsive-options="barChart.responsiveOptions"
            chart-type="Bar">
            <template slot="header">
              <h4 class="card-title">2014 Sales</h4>
              <p class="card-category">All products including Taxes</p>
            </template>
            <template slot="footer">
              <div class="legend">
                <i class="fa fa-circle text-info"></i> Tesla Model S
                <i class="fa fa-circle text-danger"></i> BMW 5 Series
              </div>
              <hr>
              <div class="stats">
                <i class="fa fa-check"></i> Data information certified
              </div>
            </template>
          </chart-card>
        </div>
    </div>
</template>

<script>
import LineChart from './charts/LineChartComponent.vue';
import ChartCard from '../dashboard/UIComponents/Cards/ChartCard';

export default {
    components: {
        LineChart,
        ChartCard
    },
    data: () => ({
        loaded: false,
        chartData: null
    }),
    async mounted() {
        this.loaded = false;
        try {
            const movTanque = await fetch('')
            this.chartData = movTanque;
            this.loaded = true;
        } catch (e) {
            console.log(e);
        }
    }
};
</script>
