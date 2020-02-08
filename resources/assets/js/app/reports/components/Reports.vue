<template>
    <div class="content">
        <div class="card-deck">
            <div v-for="rt in data" :key="rt.id" class="card mb-3 overflow-hidden point" @click="openreport(rt)">
                <div class="bg-holder bg-card" style="background-image:url('/assets/img/illustrations/corner-1.png');"></div>
                <!--/.bg-holder-->
                <div class="card-body position-relative">
                <h6>{{rt.title}}</h6>
                <div class="display-4 fs-4 mb-2 font-weight-normal text-sans-serif text-warning" data-countupp='{"count":58386,"format":"alphanumeric"}'>{{rt.number}}</div>
                </div>
            </div>
        </div>


        <modal name="reportModal" classes="animated bounceInDown faster" :clickToClose="true" height="auto" :adaptive="true" :scrollable="true" :pivotY="0.2">
            <reportform :report="report" :state="state" />
        </modal>

        <!-- <footernav/> -->
    </div>
</template>
<script>
import Bus from '../../../bus'
import { mapGetters, mapActions } from 'vuex'
import { isEmpty } from 'lodash'
import moment from 'moment'
export default {
    data () {
        return {
            isGettingMc: false,
            isLoadingMc: false,
            errors: null,
            state: null,
        }
    },
    computed: {
        ...mapGetters({
            data: 'reports/getOffers',
            report: 'reports/getVariation',
        })
    },
    methods: {
        ...mapActions({
            fetchOfers: 'reports/fetchOfers',
            selectedVariation: 'reports/selectedVariation',
        }),
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
        openreport(cnt){
            this.selectedVariation(cnt)
            this.errors = [];
            this.state = 1
            this.$modal.show('reportModal')
        },
    },
    mounted (){
        this.fetchOfers()
        // this.fetchSerciceCountData()
        // this.fetchBookingChart({
        //     payload: {
        //         year: moment().format('YYYY-MM-DD')
        //     }
        // }),
        // this.fetchFuelChat({
        //     payload: {
        //         year: moment().format('YYYY-MM-DD')
        //     }
        // }),
        // this.fetchMechWorks({
        //     payload: {
        //         month: moment().format('YYYY-MM-DD')
        //     }
        // }),
        // this.fetchLeave()
        Bus.$on('close-report-modal', ()=> {
            this.$modal.hide('reportModal');
        })

        Bus.$on('new-offer-data', (data)=> {
            this.data.unshift(data)
        })
    }
}
</script>