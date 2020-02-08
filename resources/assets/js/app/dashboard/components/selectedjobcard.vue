<template>
    <div class="mymodal">
        <div class="modalbluepart mr-auto ml-auto">
            <div class="row">
                <div class="col-10 mt-2">
                    <h5 class="text-white ml-3 mt-2">{{data.servicename}}</h5>
                </div>
                <div class="col-2 text-right pt-2">
                    <i @click.prevent="closemodal" class="point text-white icon-close mr-2" style="font-size: 20px;"></i>
                </div>
            </div>
        </div>
        <div class="modalwhitepart mr-auto ml-auto">
            <div class="table-responsive">
                <table class="table table-padded mb-0">
                    <thead>
                        <tr>
                            <th>Job No.</th>
                            <th>Vehicle</th>
                            <th>Start date</th>
                            <th>Service desc</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="cent in data.activedata" :key="cent.id">
                            <td>{{cent.JobNumber}}</td>
                            <td>{{cent.vehiclename}}</td>
                            <td>{{cent.JobStartDate | moment}}</td>
                            <td>{{cent.ServiceDescription}}</td>
                            <td>{{cent.statename}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
    import Bus from '../../../bus'
    import moment from 'moment'
    export default {
        filters:{
            moment: function(date) {
                return moment(date).format('DD MMM YYYY')
            }
        },
        props:{
            data:{
                required: false,
                type: Object
            }
        },
        methods:{
            closemodal: function () {
                Bus.$emit('close-jobcard-modal')
            },
        }
    }
</script>