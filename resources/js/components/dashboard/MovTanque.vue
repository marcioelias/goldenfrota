<template>
    <div>
        <line-chart v-if="loaded" :chartData="chartData" :options="options"/>
    </div>
</template>

<script>
import Axios from "axios";
import LineChart from "../charts/LineChartComponent.vue";

export default {
    components: {
        "line-chart": LineChart
    },
    data: () => ({
        loaded: false,
        chartData: null,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 2000
            },
            scales: {
                xAxes: [
                    {
                        gridLines: {
                            display: false
                        }
                    }
                ],
                yAxes: [
                    {
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            // Include a dollar sign in the ticks
                            callback: function(value, index, values) {
                                return value + " Lts";
                            }
                        }
                    }
                ]
            }
        }
    }),
    async mounted() {
        this.loaded = false;
        Axios.get("/dashboard/mov_tanque/3")
            .then(r => {
                this.chartData = r.data; //this.formatDataset(r.data);
                this.loaded = true;
            })
            .catch(e => {
                console.log(e);
            });
    },
    methods: {
      formatDataset(data) {
        data.datasets.forEach(ds => {
          ds.backgroundColor = 'rgba(255, 61, 57, 0.3)';
        });

        return data;
      }
    }
};
</script>