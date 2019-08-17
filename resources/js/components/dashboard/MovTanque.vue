<template>
    <div>
        <line-chart v-if="loaded" :chartData="chartData" :options="options" :height="250"/>
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
        Axios.get("/dashboard/mov_tanque") 
            .then(r => {
                this.chartData = r.data;
                this.loaded = true;
            })
            .catch(e => {
                console.log(e);
            });
    }
};
</script>