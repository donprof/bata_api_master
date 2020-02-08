<template>
    <div class="content">
        <div class="card mb-3">
            <div class="card-body rounded-soft bg-gradient">
                <div class="row text-white align-items-center no-gutters">
                    <div class="col">
                        <h5 class="text-white mb-0">Annual Sales</h5>
                        <!-- <p class="fs--1 font-weight-semi-bold">Yesterday <span class="text-300">$684.87</span></p> -->
                    </div>
                    <!-- <div class="col-auto d-none d-sm-block"><select class="custom-select custom-select-sm mb-3 shadow" id="dashboard-chart-select">
                        <option value="all">All Payments</option>
                        <option value="successful" selected="selected">Successful Payments</option>
                        <option value="failed">Failed Payments</option>
                        </select>
                    </div> -->
                </div>
                <!-- FuelCost -->
                <total-sales width="1618" :chart="orders" height="500"/>
                <!-- <canvas class="rounded" id="chart-line" width="1618" height="375" aria-label="Line chart" role="img"></canvas> -->
            </div>
        </div>
        <div class="card-deck">
            <div class="card mb-3 overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card" style="background-image:url('/assets/img/illustrations/corner-1.png');"></div>
                <div class="card-body position-relative">
                <h6>Total Customers</h6>
                <div class="display-4 fs-4 mb-2 font-weight-normal text-sans-serif text-warning" data-countupp='{"count":58386,"format":"alphanumeric"}'>{{usercount.count}}</div>
                </div>
            </div>
            <div class="card mb-3 overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card" style="background-image:url('/assets/img/illustrations/corner-2.png');"></div>
                <!--/.bg-holder-->
                <div class="card-body position-relative">
                <h6>Total Orders</h6>
                <div class="display-4 fs-4 mb-2 font-weight-normal text-sans-serif text-info" data-countupp='{"count":23434,"format":"alphanumeric"}'>{{usercount.order}}</div>
                </div>
            </div>
            <div class="card mb-3 overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card" style="background-image:url('/assets/img/illustrations/corner-3.png');"></div>
                <!--/.bg-holder-->
                <div class="card-body position-relative">
                <h6>Total Revenue</h6>
                <div class="display-4 fs-4 mb-2 font-weight-normal text-sans-serif" data-countup='{"count":43594,"format":"comma","prefix":"$"}'>{{usercount.revenue}}</div>
                </div>
            </div>
        </div>

        <div class="card-deck">
            <div class="card mb-3 overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card" style="background-image:url('/assets/img/illustrations/corner-1.png');"></div>
                <div class="card-body position-relative">
                    <h6>Monday</h6>
                    <div class="display-4 fs-4 mb-2 font-weight-normal text-sans-serif text-warning">
                        <div class="inbox-widget nicescroll" tabindex="5001" v-if="monday.length > 0">
                            <weekdata v-for="book in mondaydata" :book="book" :key="book.id"></weekdata>
                        </div>
                        <div v-else class="text-center" style="flex: 1">
                            <h4 class="text-muted noData">No sales</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-3 overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card" style="background-image:url('/assets/img/illustrations/corner-2.png');"></div>
                <!--/.bg-holder-->
                <div class="card-body position-relative">
                    <h6>Tuesday</h6>
                    <div class="display-4 fs-4 mb-2 font-weight-normal text-sans-serif text-warning">
                        <div class="inbox-widget nicescroll" tabindex="5001" v-if="monday.length > 0">
                            <weekdata v-for="book in tuesdaydata" :book="book" :key="book.id"></weekdata>
                        </div>
                        <div v-else class="text-center" style="flex: 1">
                            <h4 class="text-muted noData">No sales</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-3 overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card" style="background-image:url('/assets/img/illustrations/corner-3.png');"></div>
                <!--/.bg-holder-->
                <div class="card-body position-relative">
                <h6>Wednesday</h6>
                    <div class="display-4 fs-4 mb-2 font-weight-normal text-sans-serif text-warning">
                        <div class="inbox-widget nicescroll" tabindex="5001" v-if="monday.length > 0">
                            <weekdata v-for="book in wednesdaydata" :book="book" :key="book.id"></weekdata>
                        </div>
                        <div v-else class="text-center" style="flex: 1">
                            <h4 class="text-muted noData">No sales</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-deck mb-4">
            <div class="card mb-3 overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card" style="background-image:url('/assets/img/illustrations/corner-3.png');"></div>
                <!--/.bg-holder-->
                <div class="card-body position-relative">
                <h6>Thursday</h6>
                    <div class="display-4 fs-4 mb-2 font-weight-normal text-sans-serif text-warning">
                        <div class="inbox-widget nicescroll" tabindex="5001" v-if="monday.length > 0">
                            <weekdata v-for="book in thursdaydata" :book="book" :key="book.id"></weekdata>
                        </div>
                        <div v-else class="text-center" style="flex: 1">
                            <h4 class="text-muted noData">No sales</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-3 overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card" style="background-image:url('/assets/img/illustrations/corner-3.png');"></div>
                <!--/.bg-holder-->
                <div class="card-body position-relative">
                <h6>Friday</h6>
                    <div class="display-4 fs-4 mb-2 font-weight-normal text-sans-serif text-warning">
                        <div class="inbox-widget nicescroll" tabindex="5001" v-if="monday.length > 0">
                            <weekdata v-for="book in fridaydata" :book="book" :key="book.id"></weekdata>
                        </div>
                        <div v-else class="text-center" style="flex: 1">
                            <h4 class="text-muted noData">No sales</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-3 overflow-hidden" style="min-width: 12rem">
                <div class="bg-holder bg-card" style="background-image:url('/assets/img/illustrations/corner-3.png');"></div>
                <!--/.bg-holder-->
                <div class="card-body position-relative">
                <h6>Saturday</h6>
                    <div class="display-4 fs-4 mb-2 font-weight-normal text-sans-serif text-warning">
                        <div class="inbox-widget nicescroll" tabindex="5001" v-if="monday.length > 0">
                            <weekdata v-for="book in saturdaydata" :book="book" :key="book.id"></weekdata>
                        </div>
                        <div v-else class="text-center" style="flex: 1">
                            <h4 class="text-muted noData">No sales</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <div class="row align-items-center justify-content-between">
                    <div class="col-6 col-sm-auto d-flex align-items-center pr-0">
                        <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Product running low in stock.</h5>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                <table class="table table-sm mb-0 table-dashboard fs--1">
                    <thead class="bg-200 text-900">
                    <tr>
                        <th>
                            <div class="custom-control custom-checkbox ml-1 pl-1"></div>
                        </th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Base price</th>
                        <th class="text-center">Status</th>
                        <th class="text-right">Amount</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody id="purchases">
                        <!-- {{weeksales}} -->
                        <tr class="btn-reveal-trigger">
                            <td class="align-middle">
                                <div class="custom-control custom-checkbox ml-1 pl-1"></div>
                            </td>
                            <th class="align-middle"><a href="/pages/customer-details.html">Sylvia Plath</a></th>
                            <td class="align-middle">john@gmail.com</td>
                            <td class="align-middle">Slick - Drag & Drop Bootstrap Generator</td>
                            <td class="align-middle text-center fs-0"><span class="badge badge rounded-capsule badge-soft-success">Success<span class="ml-1 fas fa-check" data-fa-transform="shrink-2"></span></span></td>
                            <td class="align-middle text-right">$99</td>
                            <td class="align-middle white-space-nowrap">
                            <div class="dropdown text-sans-serif"><button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal mr-3" type="button" id="dropdown1" data-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--1"></span></button>
                                <div class="dropdown-menu dropdown-menu-right border py-0" aria-labelledby="dropdown1">
                                <div class="bg-white py-2"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Edit</a><a class="dropdown-item" href="#!">Refund</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item text-warning" href="#!">Archive</a><a class="dropdown-item text-danger" href="#!">Delete</a>
                                </div>
                                </div>
                            </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
        <footernav/>
    </div>
</template>
<script>
import Bus from '../../../bus'
import TotalSales from '../../../components/Graphs/Fuel'
import RepairCost from '../../../components/Graphs/Repair'
import BookingCount from '../../../components/Graphs/Booking'
// weekdata
import { mapGetters, mapActions } from 'vuex'
import { isEmpty } from 'lodash'
import moment from 'moment'
export default {
    components: { TotalSales, RepairCost, BookingCount },
    data () {
        return {
            isGettingMc: false,
            isLoadingMc: false,
        }
    },
    computed: {
        ...mapGetters({
            orders: 'dashboard/getOrdersChart',
            data: 'dashboard/getVehicleJobcardCounter',
            services: 'dashboard/getServicescount',
            jobcarddata: 'dashboard/getOpenJobcards',
            fuelchat: 'dashboard/getFuelChat',
            weeksales: 'dashboard/getWeekSales',
            fuelmonth: 'dashboard/getFuelmonth',
            // bookingmonth: 'dashboard/getBookingmonth',
            mechs: 'dashboard/getMechanicsJob',
            usercount: 'dashboard/getUsercount',
        }),
        mondaydata: function(){
            var monday = [];
            monday = this.weeksales.filter((rpt) => {
                return rpt.dayname == 'Monday'
            })
            return monday;
        },
        tuesdaydata: function(){
            var monday = [];
            monday = this.weeksales.filter((rpt) => {
                return rpt.dayname == 'Tuesday'
            })
            return monday;
        },
        wednesdaydata: function(){
            var monday = [];
            monday = this.weeksales.filter((rpt) => {
                return rpt.dayname == 'Wednesday'
            })
            return monday;
        },
        thursdaydata: function(){
            var monday = [];
            monday = this.weeksales.filter((rpt) => {
                return rpt.dayname == 'Thursday'
            })
            return monday;
        },
        fridaydata: function(){
            var monday = [];
            monday = this.weeksales.filter((rpt) => {
                return rpt.dayname == 'Friday'
            })
            return monday;
        },
        saturdaydata: function(){
            var monday = [];
            monday = this.weeksales.filter((rpt) => {
                return rpt.dayname == 'Saturday'
            })
            return monday;
        },
        sundaydata: function(){
            var monday = [];
            monday = this.weeksales.filter((rpt) => {
                return rpt.dayname == 'Sunday'
            })
            return monday;
        },









        monday() {
            return this.filterByDay('Monday')
        },
        tuesday() {
            return this.filterByDay('Tuesday')
        },
        wednesday() {
            return this.filterByDay('Wednesday')
        },
        thursday() {
            return this.filterByDay('Thursday')
        },
        friday() {
            return this.filterByDay('Friday')
        },
        saturday() {
            return this.filterByDay('Saturday')
        },
        sunday() {
            return this.filterByDay('Sunday')
        },
        currentDay() {
            return (moment().format('dddd'))
        }
    },
    watch: {
        fuelmonth: function() {
            this.isGettingMc = true;
            this.isLoadingMc = true;
            this.fetchFuelChat({
                payload: {
                    year: this.dateFormater(this.fuelmonth)
                },
                context: this
            })
            .then(() => {
                this.isGettingMc = false;
                if (isEmpty(this.errors)) {
                    this.isLoadingMc = false;
                }
            })
        },
        bookingmonth: function() {
            this.isGettingMc = true;
            this.isLoadingMc = true;
            this.fetchOrdersChart({
                payload: {
                    year: this.dateFormater(this.bookingmonth)
                },
                context: this
            })
            .then(() => {
                this.isGettingMc = false;
                if (isEmpty(this.errors)) {
                    this.isLoadingMc = false;
                }
            })
        },
    },
    methods: {
        ...mapActions({
            fetchOrdersChart: 'dashboard/fetchOrdersChart',
            fetchVehicleJobcardData: 'dashboard/fetchVehicleJobcardData',
            fetchSerciceCountData: 'dashboard/fetchSerciceCountData',
            setSelectedService: 'dashboard/setSelectedService',
            fetchFuelChat: 'dashboard/fetchFuelChat',
            fetchWeekSales: 'dashboard/fetchWeekSales',
            changefuelmonth: 'dashboard/changefuelmonth',
            changebookmonth: 'dashboard/changebookmonth',
            fetchMechWorks: 'dashboard/fetchMechWorks',
            fetchTotalusers: 'dashboard/fetchTotalusers',
        }),
        filterByDay(day) {
            var filtered = [];
            filtered = this.weeksales.filter((booking) => {
                return booking.dayname == day
            })
            return filtered;
        },
        dateFormater(date){
            if (date != null && date != "") {
                var today = new Date(date);
                var dd = today.getDate();
                var mm = today.getMonth()+1;
                var yyyy = today.getFullYear();
                var dateIssued = yyyy+'-'+mm+'-'+dd;
                return dateIssued;
            }else {
                return null;
            }
        },
        open(data){
            this.setSelectedService(data)
            this.$modal.show('serviceCounterModal')
        },
        prevyear() {
            this.changefuelmonth(this.fuelmonth.subtract(1, 'Y'))
        },
        nextyear() {
            this.changefuelmonth(this.fuelmonth.add(1, 'Y'))
        },
        now() {
            this.changefuelmonth(moment())
        },
        prevyearbk() {
            this.changebookmonth(this.fuelmonth.subtract(1, 'Y'))
        },
        nextyearbk() {
            this.changebookmonth(this.fuelmonth.add(1, 'Y'))
        },
        nowbk() {
            this.changebookmonth(moment())
        },
    },
    mounted (){
        this.fetchVehicleJobcardData()
        this.fetchSerciceCountData()
        this.fetchTotalusers()
        this.fetchOrdersChart({
            payload: {
                year: this.dateFormater(moment().format('YYYY-MM-DD'))
            }
        }),
        this.fetchFuelChat({
            payload: {
                year: this.dateFormater(moment().format('YYYY-MM-DD'))
            }
        }),
        this.fetchMechWorks({
            payload: {
                month: this.dateFormater(moment().format('YYYY-MM-DD'))
            }
        }),
        this.fetchWeekSales()
        Bus.$on('close-jobcard-modal', ()=> {
            this.$modal.hide('serviceCounterModal');
        })
    }
}
</script>