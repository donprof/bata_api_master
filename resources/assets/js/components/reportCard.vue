<template>
    <div @click.prevent="showreportmodal" :class="cardclass">
        <div class="support-ticket">
            <div class="st-meta">
                <i :class="[carddesc.user_role > user ? 'text-danger os-icon os-icon-ui-09': 'text-success os-icon os-icon-ui-07']"></i>
            </div>
            <div class="st-body">
                <div class="ticket-content mr-auto">
                    <h6 class="ticket-title">{{carddesc.title}}</h6>
                    <div class="ticket-description">{{carddesc.desc}}</div>
                </div>
                <div class="avatar ml-auto">
                    <reptanim v-if="loadingReport == true"></reptanim>
                    <h1 v-else>{{carddesc.number}}</h1>
                </div>
            </div>
            <div class="st-foot">
                <div class="row">
                    <div class="col-sm-6">
                        <span class="value with-avatar">
                            <img v-if="carddesc.userdetail.avatar != null" :src="'assets/img/users/' + carddesc.userdetail.avatar">
                            <span>{{carddesc.userdetail.full_name}}</span>
                        </span>
                    </div>
                    <div class="col-sm-6 text-right pt-1">
                        <span class="label">Last gen:</span>
                        <span class="value">{{carddesc.updated_at | moment}}</span>
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
            carddesc:{
                required: true,
                type: Object
            },
            cardclass:{
                required: true,
                type: String
            },
            user:{
                required: true,
            },
        },
        filters: {
            moment: function(date) {
                return moment(date).format('DD MMM YYYY @ h:mm a');
            }
        },
        methods:{
            showreportmodal(){
                if (this.carddesc.user_role > this.user) {
                    var data = {'title': 'Warning.', 'bottomclass': 'darkerror', 'topclass': 'swalerror', 'swalicon': 'icon-exclamation', 'message': `You need higher privilages to run ${this.carddesc.number}`}
                    Bus.$emit('show-message-swal', data)
                }else{
                    let data = {'carddesc': this.carddesc}
                    Bus.$emit('show-report-modal', data)
                }
            }
        },
        mounted(){
            Bus.$on('show-loading-animation', (data)=> {
                if (this.carddesc.apislug == data.reportnumber) {
                    this.loadingReport = data.state
                }
            })
        }
    }
</script>