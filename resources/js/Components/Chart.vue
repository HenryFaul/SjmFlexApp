<template>
    <div :id="chartId"> </div>
</template>

<script>
import ApexCharts from 'apexcharts';
import { ref, watch } from "vue";

export default {
    data() {
        return {
            myChart: null
        }
    },
    props: {
        chartId: {
            type: String,
            required: true
        },
        title: {
          type: String
        },
        data: {
            type: Object,
            required: true
        }
    },
    mounted() {
        const chartData = JSON.parse(JSON.stringify(this.data.original));
        let totalRatio = 0;
        let count = 0;
        Object.values(chartData).forEach(entry => {
            totalRatio += entry.ratio;
            count++;
        });

        const averageRatio = totalRatio / count;
        const trendlineData = [];
        for (const key in chartData) {
            trendlineData.push({
                x: key,
                y: (averageRatio * 100).toFixed(2)
            });
        }
        const series = [
            {
                name: this.title , // A single series name
                type: 'bar',
                color: '#0000FF',
                data: []
            },
            {
                name: 'Trend',
                type: 'line', // Explicitly set type to 'line'
                color: '#00FFFF',
                data: trendlineData,
            }
        ];
        for (const key in chartData) {
            series[0].data.push({
                x: key,
                y: chartData[key].ratio * 100,
            })
        }

        let zoom = determineZoom(this.data);
        let options = {
            series: series,
            chart: {
                height: 350,
                type: 'bar',
                title: this.title
            },
            plotOptions: {
                bar: {
                    borderRadius: 8,
                    dataLabels: {
                        position: 'top',
                    },
                },
                line: {
                    dataLabels: {
                        total: {
                            enabled: false,
                            style: {
                                fontSize: '12px',
                                colors: ["#304758"]
                            }
                        },
                        position: 'bottom',
                    },
                }
            },
            dataLabels: {
                enabled: true,
                enabledOnSeries: [0],
                formatter: function (val) {
                    return val.toFixed(2) + "%";
                },
                offsetY: -20,
                position: 'bottom',
                style: {
                    fontSize: '12px',
                    colors: ["#304758"]
                }
            },
            legend: {
                show: false,
            },

            xaxis: {
                position: 'bottom',
                axisBorder: {
                    show: true
                },
                axisTicks: {
                    show: true
                },
                tooltip: {
                    enabled: true,
                }
            },
            stroke: {
                curve: 'smooth',
                width: 2,
            },
            yaxis: {
                min: zoom.min, // Adjust as needed
                max: zoom.max,  // Adjust as needed
                axisBorder: {
                    show: true
                },
                axisTicks: {
                    show: true,
                },
                labels: {
                    show: true,
                    formatter: function (val) {
                        return val + "%";
                    }
                }

            },
            title: {
                text: this.title,
                floating: true,
                offsetY: 0,
                align: 'center',
                style: {
                    color: '#444'
                }
            }
        };
        this.myChart = new ApexCharts(document.querySelector(`#${this.chartId}`), options);
        this.myChart.render();
        function determineZoom(data){
            const chartData = JSON.parse(JSON.stringify(data.original));
            let totalRatio = 0;
            let minRatio = 999;
            let maxRatio = 0;
            let count = 0;

            Object.values(chartData).forEach(entry => {
                totalRatio += entry.ratio;
                if(entry.ratio > maxRatio) {
                    maxRatio = entry.ratio
                }

                if(entry.ratio < minRatio) {
                    minRatio = entry.ratio
                }
                count++;
            });

            let min = roundToNearestTen((minRatio * 100) - 2);
            let max = roundToNearestTen((maxRatio * 100) + 2)
            min = min < 0 ? 0 : min
            let zoom = Object
            zoom.min = min
            zoom.max = max
            return zoom
        }
        function roundToNearestTen(value) {
            return Math.round(value / 2) * 2;
        }
    },
    watch: {
        // Watch the 'data' prop
        data(newData) {
            if (this.myChart) { // Check if the chart is initialized
                console.log("Watch detected data change:")
                console.log(newData)
                // let series = prepareSeries(newData);

                const chartData = JSON.parse(JSON.stringify(newData.original));
                let totalRatio = 0;
                let count = 0;
                Object.values(chartData).forEach(entry => {
                    totalRatio += entry.ratio;
                    count++;
                });

                const averageRatio = totalRatio / count;
                const trendlineData = [];
                for (const key in chartData) {
                    trendlineData.push({
                        x: key,
                        y: (averageRatio * 100).toFixed(2)
                    });
                }
                const series = [
                    {
                        name: this.title , // A single series name
                        type: 'bar',
                        color: '#0000FF',
                        data: []
                    },
                    {
                        name: 'Trend',
                        type: 'line', // Explicitly set type to 'line'
                        color: '#00FFFF',
                        data: trendlineData,
                    }
                ];
                for (const key in chartData) {
                    series[0].data.push({
                        x: key,
                        y: chartData[key].ratio * 100,
                    })
                }
                // Update the chart
                this.myChart.updateSeries(series, true);
            }
        }
    }
}
</script>
