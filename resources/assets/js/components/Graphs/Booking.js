import { Line } from 'vue-chartjs'
export default {
    props: ['chart'],
    extends: Line,
    methods: {
        recievedata() {
            var vm = this.chart;
            var cr = vm.curr;
            var pr = vm.prev;
            var y = vm.y;
            var p = vm.p;
            var currentyearlable = [];
            var currentyearvalue = [];

            var preyearlable = [];
            var preyearvalue = [];
            
            for (let i = 0; i < cr.length; i++) {
                currentyearlable.push(cr[i].month);
                currentyearvalue.push(cr[i].Count);
            }

            for (let p = 0; p < pr.length; p++) {
                preyearlable.push(pr[p].month);
                preyearvalue.push(pr[p].Count);
            }

            this.gradient = this.$refs.canvas.getContext('2d').createLinearGradient(0, 0, 0, 450)
            this.gradient2 = this.$refs.canvas.getContext('2d').createLinearGradient(0, 0, 0, 450)

            this.gradient.addColorStop(0, 'rgba(255, 0, 0, 0.7)');
            this.gradient.addColorStop(0.3, 'rgba(255, 0, 0, 0.25)');
            this.gradient.addColorStop(0.6, 'rgba(255, 0, 0, 0)');
            this.gradient.addColorStop(1, 'rgba(255, 0, 0, 0)');
            
            this.gradient2.addColorStop(0, 'rgba(44, 100, 237, 0.7)')
            this.gradient2.addColorStop(0.3, 'rgba(44, 100, 237, 0.25)');
            this.gradient2.addColorStop(0.6, 'rgba(44, 100, 237, 0)');
            this.gradient2.addColorStop(1, 'rgba(44, 100, 237, 0)');

            this.renderChart({
                labels: currentyearlable,
                datasets: [
                    {
                        label: y,
                        borderColor: '#2C64ED',
                        pointBackgroundColor: '#141F3F',
                        borderWidth: 3,
                        pointBorderColor: '#ffffff',
                        backgroundColor: this.gradient2,
                        data: currentyearvalue
                    },
                    {
                        label: p,
                        borderColor: '#FC2525',
                        pointBackgroundColor: '#FC2525',
                        borderWidth: 3,
                        pointBorderColor: 'white',
                        backgroundColor: this.gradient,
                        data: preyearvalue
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
                        barPercentage: 0.7,
                        ticks: {
                            // fontSize: 40,
                            fontColor: '#000000',
                        },
                        gridLines: {
                            color: "rgba(247, 247, 247, 0)",
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            // fontSize: 40,
                            fontColor: '#000000',
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, 0)",
                        }
                    }]
                },
                legend: {
                    labels: {
                        fontColor: '#000000',
                        boxWidth: 14
                    }
                },
                title: {
                    title: {
                        fontColor: '#000000'
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