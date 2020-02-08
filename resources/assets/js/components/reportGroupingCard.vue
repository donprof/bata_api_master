<template>
    <div class="col-md-12">
        <div class="pipeline white">
            <div class="pipeline-header">
                <h5 class="pipeline-name">{{name}}</h5>
            </div>
            <div class="pipeline-body">
                <div class="support-index">
                    <div class="row">
                        <fuelcard v-for="rpt in listing" :key="rpt.id"
                            :carddesc='rpt'
                            cardclass='col-sm-6 mb-3 col-xxl-4'
                        ></fuelcard>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Bus from '../bus'
    import moment from 'moment'
    export default {
        data(){
            return{
                loadingReport: false,
            }
        },
        props:{
            name:{
                required: true,
                type: String
            },
            listing:{
                required: true,
                type: Array
            },
        },
        // filters: {
        //     moment: function(date) {
        //         return moment(date).format('DD MMM YYYY @ h:mm a');
        //     }
        // },
        // methods:{
        //     showreportmodal(){
        //         if (this.carddesc.user_role > this.user) {
        //             var data = {'title': 'Warning.', 'bottomclass': 'darkerror', 'topclass': 'swalerror', 'swalicon': 'icon-exclamation', 'message': `You need higher privilages to run ${this.carddesc.number}`}
        //             Bus.$emit('show-message-swal', data)
        //         }else{
        //             let data = {'carddesc': this.carddesc}
        //             Bus.$emit('show-report-modal', data)
        //         }
        //     }
        // },
        // mounted(){
        //     Bus.$on('show-loading-animation', (data)=> {
        //         if (this.carddesc.apislug == data.reportnumber) {
        //             this.loadingReport = data.state
        //         }
        //     })
        // }
    }
</script>

<style>

</style>
