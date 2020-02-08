import { Line } from 'vue-chartjs'
export default {
    props: ['chart','width','height'],
    extends: Line,
    methods: {
        recievedata() {
            var vm = this.chart;
            var cr = vm.curr;
            var pr = vm.prev;
            var p = vm.p;
            var y = vm.y;

            var currentyearlable = [];
            var currentyearvalue = [];

            var preyearlable = [];
            var preyearvalue = [];

            for (let i = 0; i < cr.length; i++) {
                if (cr[i].total != null) {
                    var data = cr[i].total;
                }else{
                    var data = 0;
                }
                currentyearlable.push(cr[i].month);
                currentyearvalue.push(data);
            }

            for (let p = 0; p < pr.length; p++) {
                if (pr[p].total != null) {
                    var data1 = pr[p].total;
                }else{
                    var data1 = 0;
                }
                preyearlable.push(pr[p].month);
                preyearvalue.push(data1);
            }

            this.gradient = this.$refs.canvas.getContext('2d').createLinearGradient(0, 0, 0, 450)
            this.gradient2 = this.$refs.canvas.getContext('2d').createLinearGradient(0, 0, 0, 450)

            this.gradient.addColorStop(0, 'rgba(255, 255, 255, 0.7)');
            this.gradient.addColorStop(0.3, 'rgba(255, 255, 255, 0.25)');
            this.gradient.addColorStop(0.6, 'rgba(255, 255, 255, 0)');
            this.gradient.addColorStop(1, 'rgba(255, 255, 255, 0)');
            
            this.gradient2.addColorStop(0, 'rgba(93, 110, 128, 0.7)')
            this.gradient2.addColorStop(0.3, 'rgba(93, 110, 128, 0.25)');
            this.gradient2.addColorStop(0.6, 'rgba(93, 110, 128, 0)');
            this.gradient2.addColorStop(1, 'rgba(93, 110, 128, 0)');

            this.renderChart({
                labels: currentyearlable,
                datasets: [
                    {
                        label: 'Year '+y,
                        borderColor: '#5D6E80',
                        pointBackgroundColor: '#5D6E80',
                        borderWidth: 2,
                        pointBorderColor: '#ffffff',
                        backgroundColor: this.gradient2, 
                        data: currentyearvalue
                    },
                    {
                        label: 'Year '+p,
                        borderColor: '#ffffff',
                        pointBackgroundColor: '#ffffff',
                        borderWidth: 2,
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
                            fontColor: '#ffffff',
                        },
                        gridLines: {
                            color: "rgba(247, 247, 247, 0)",
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