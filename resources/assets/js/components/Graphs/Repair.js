import { Bar } from 'vue-chartjs'
export default {
    props: ['chart'],
    extends: Bar,
    methods: {
        recievedata() {
            // var vm = this.chart;
            // var cr = vm.curr;
            // var pr = vm.prev;
            // var p = vm.p;
            // var y = vm.y;
            this.gradient = this.$refs.canvas.getContext('2d').createLinearGradient(0, 0, 0, 450)
            this.gradient2 = this.$refs.canvas.getContext('2d').createLinearGradient(0, 0, 0, 450)

            this.gradient.addColorStop(0, 'rgb(255, 255, 255)');
            this.gradient.addColorStop(0.5, 'rgb(255, 255, 255)');
            this.gradient.addColorStop(1, 'rgb(255, 255, 255)');
            
            this.gradient2.addColorStop(0, 'rgb(47, 103, 229)')
            this.gradient2.addColorStop(0.5, 'rgb(47, 103, 229)');
            this.gradient2.addColorStop(1, 'rgb(47, 103, 229)');

            this.renderChart({
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [
                    {
                        label: 'Current',
                        borderColor: '#5D6E80',
                        pointBackgroundColor: '#5D6E80',
                        borderWidth: 0,
                        hoverBackgroundColor: '#FEE6D9',
                        barThickness: 0.3,
                        maxBarThickness: 1,
                        pointBorderColor: 'white',
                        backgroundColor: this.gradient2, 
                        data: [12, 19, 3, 5, 2, 3, 8, 10, 5, 8, 2, 3]
                    },
                    {
                        label: 'Previous',
                        borderColor: '#ffffff',
                        pointBackgroundColor: '#ffffff',
                        borderWidth: 0,
                        hoverBackgroundColor: '#E9EDF3',
                        barThickness: 0.3,
                        maxBarThickness: 1,
                        pointBorderColor: 'white',
                        backgroundColor: this.gradient,
                        data: [8, 10, 7, 5, 7, 8, 5, 1, 4, 8, 6, 7]
                    }
                ],
                options: {
                    // This chart will not respond to mousemove, etc
                    events: ['click']
                }
            },
            {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        barPercentage: 0.5,
                        ticks: {
                            // fontSize: 40,
                            fontColor: '#ffffff',
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, 0)",
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            // fontSize: 40,
                            fontColor: '#ffffff',
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, 0)",
                        }
                    }]
                },
                legend: {
                    labels: {
                        fontColor: '#ffffff',
                        boxWidth: 14
                    }
                },
                title: {
                    title: {
                        fontColor: '#ffffff'
                    }
                }
            })
        },
    },
    watch: {
        chart: function() {
            this.recievedata()
        }
    },
    mounted () {
        this.recievedata()
    }
}