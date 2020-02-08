<template>
    <div @click.prevent="showreportmodal" :class="cardclass">
        <div class="support-ticket">
            <div class="st-body">
                <div class="ticket-content mr-auto">
                    <h6 class="ticket-title">{{carddesc.title}}</h6>
                    <div class="ticket-description">{{carddesc.desc}}</div>
                </div>
                <div class="avatar ml-auto">
                    <h1>{{carddesc.number}}</h1>
                </div>
            </div>
            <div class="st-foot">
                <div class="row">
                    <div class="col-sm-12 text-right pt-1">
                        <div class="row">
                            <div class="col-sm-12 text-right pt-1">
                                <span v-if="carddesc.user_role == 1">
                                    <div class="badge badge-danger-inverted">Normal User</div>
                                    <div class="badge badge-info-inverted">Admin</div>
                                    <div class="badge badge-success-inverted">Super Admin</div>
                                </span>
                                <span v-if="carddesc.user_role == 2">
                                    <div class="badge badge-info-inverted">Admin</div>
                                    <div class="badge badge-success-inverted">Super Admin</div>
                                </span>
                                <span v-if="carddesc.user_role == 3">
                                    <div class="badge badge-success-inverted">Super Admin</div>
                                </span>
                            </div>
                        </div>
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
        props:{
            carddesc:{
                required: true,
                type: Object
            },
            cardclass:{
                required: true,
                type: String
            },
        },
        filters: {
            moment: function(date) {
                return moment(date).format('DD MMM YYYY @ h:mm a');
            }
        },
        methods:{
            showreportmodal(){
                Bus.$emit('show-settings-modal', this.carddesc)
            }
        }
    }
</script>