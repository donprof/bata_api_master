<template>
    <div class="mymodal">
        <div class="modalbluepart mr-auto ml-auto">
            <div class="row">
                <div class="col-10 mt-2">
                    <h5 class="text-white ml-3 mt-2">{{bkdata.bookinglNumber}}</h5>
                </div>
                <div class="col-2 text-right pt-2">
                    <i @click.prevent="closemodal" class="point text-white icon-close mr-2" style="font-size: 20px;"></i>
                </div>
            </div>
        </div>
        <div class="modalwhitepart mr-auto ml-auto darkerbg">
            <div class="profile-tile">
                <span class="profile-tile-box point">
                    <div class="pt-avatar-w" v-if="bkdata.driverdesc != null"><img :src="'assets/img/users/' + bkdata.driverdesc.avatar"></div>
                    <div class="pt-avatar-w flatradious" v-else><img src="assets/img/unkownuser.png"></div>
                    <div class="pt-user-name" v-if="bkdata.driverdesc != null">{{bkdata.driverdesc.firstName}}</div>
                    <div class="pt-user-name" v-else>Unkown</div>
                </span>
                <div class="profile-tile-meta">
                    <ul v-if="bkdata.driverdesc != null">
                        <li>Name:<strong>{{bkdata.driverdesc.fullnames}}</strong></li>
                        <li>Mobile:<strong>{{bkdata.mobileNumber}}</strong></li>
                        <li>Licence:<strong>{{bkdata.driverdesc.licenceNumber}}</strong></li>
                    </ul>
                    <ul v-else>
                        <li>Name:<strong>Unkown</strong></li>
                        <li>Mobile:<strong>Unkown</strong></li>
                        <li>Licence:<strong>Unkown</strong></li>
                    </ul>

                    <div class="pt-btn">
                        <button type="button" :class="{'btn-success':bkdata.smsstate == null,'btn-warning':bkdata.smsstate == 1}" class="btn btn-sm" @click.prevent="sendSms(bkdata)" :disabled="isSendingSMS">
                            <span v-if="isSendingSMS"><i class="fa os-icon os-icon-grid-18 fa-spin"></i></span>
                            <span v-else>
                                <span v-if="bkdata.smsstate == null">Send Message</span>
                                <span v-else>Update Message</span>
                            </span>
                        </button>
                    </div>

                </div>
                <div class="profile-tile-meta">
                    <div class="pt-btn text-right">
                        <button @click.prevent="updateStatus(bkdata, 2)" class="btn btn-outline-secondary btn-sm">Unbook</button>
                    </div>
                    <div class="pt-btn text-right">
                        <button @click.prevent="updateStatus(bkdata, 3)" class="btn btn-outline-danger btn-sm">Cancel</button>
                    </div>
                </div>
            </div>
            <div class="element-wrapper">
                <div class="element-box">
                    <h6 class="element-header">{{bkdata.vehiclename}}</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="timed-activities compact">
                                <div class="timed-activity">
                                    <div class="ta-date"><span>Dates</span></div>
                                    <div class="ta-record-w">
                                        <div class="ta-record">
                                            <div class="ta-timestamp"><b>Starting</b></div>
                                            <div class="ta-activity">{{bkdata.dateFrom | moment}}</div>
                                        </div>
                                        <div class="ta-record">
                                            <div class="ta-timestamp"><b>Ending</b></div>
                                            <div class="ta-activity">{{bkdata.dateTo | moment}}</div>
                                        </div>
                                        <div class="ta-record">
                                            <div class="ta-timestamp"><b>Destination</b></div>
                                            <div class="ta-activity">{{bkdata.destination}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="timed-activities compact">
                                <div class="timed-activity">
                                    <div class="ta-date"><span>Personel</span></div>
                                    <div class="ta-record-w">
                                        <div class="ta-record">
                                            <div class="ta-timestamp"><b>Person in charge</b></div>
                                            <div class="ta-activity" v-if="bkdata.inchargeName != null">{{bkdata.inchargeName}}</div>
                                            <div class="ta-activity" v-else>Not specified</div>
                                        </div>
                                        <div class="ta-record">
                                            <div class="ta-timestamp"><b>Mobile</b></div>
                                            <div class="ta-activity">{{bkdata.mobileNumber}}</div>
                                        </div>
                                        <div class="ta-record">
                                            <div class="ta-timestamp"><b>Department</b></div>
                                            <div class="ta-activity" v-if="bkdata.deptdesc != null">{{bkdata.deptdesc.description}}</div>
                                            <div class="ta-activity" v-else>Unkown</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import vSelect from "vue-select"
    import Bus from '../bus'
    import moment from 'moment'
    import isEmpty from 'lodash'
    import { mapActions, mapGetters } from 'vuex'
    export default {
        components: {
            vSelect,
        },
        data: ()=>({
            dateFrom: null,
            dateTo: null,
            costCenter: null,
            isSendingSMS: false,
            isUpdating: false,
            smsReturnData: [],
            errors: [],
            smsdata: null
        }),
        props:{
            bkdata:{
                required: true,
                type: Object
            }
        },
        filters:{
            moment: function(date) {
                return moment(date).format('DD MMM YYYY @ H:mm a');
            }
        },
        methods:{
            ...mapActions({
                sendBookingSMS: 'bookings/sendBookingSMS',
                updateBookingState: 'bookings/updateBookingState',
            }),
            datacolected(){
                let data = {'dateFrom': this.dateFormater(this.dateFrom), 'dateTo': this.dateFormater(this.dateTo), 'center': this.costCenter}
                return data;
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
            updateStatus(bk, st){
                if (bk.state == "Booked") {
                    this.isUpdating = true;
                    this.errors = [];
                    this.updateBookingState({
                        payload: {
                            id: bk.id,
                            state: st
                        },
                        context: this
                    })
                    .then(() => {
                        this.isUpdating = false;
                        if (isEmpty(this.errors)) {
                            this.$modal.hide('bookingModal');
                            let data = {'title': 'Suucess!', 'bottomclass': 'darkerror', 'topclass': 'swalsuccess', 'swalicon': 'icon-close', 'message': `${bk.bookinglNumber}`}
                            Bus.$emit('show-message-swal', data)
                        }
                    })
                }
            },
            sendSms: function(bk){
                var vm = this;
                vm.isSendingSMS = true;
                vm.smsReturnData = [];
                vm.errors = [];
                vm.smsdata = null
                vm.sendBookingSMS({
                    payload: {
                        id:             bk.id,
                        bookinglNumber: bk.bookinglNumber,
                        dateFrom:       bk.dateFrom,
                        dateTo:         bk.dateTo,
                        vehicle:        bk.vehicle,
                        driverMobile:   bk.driverMobile,
                        inchergerMobile:bk.mobileNumber,
                        destination:    bk.destination,
                        smsstate:       bk.smsstate,
                    },
                    context: vm
                }).then(() => {
                    if(this.smsdata != null) {
                        vm.isSendingSMS = false;
                        this.$modal.hide('bookingModal');
                        let data = {'title': 'Error!', 'bottomclass': 'darkerror', 'topclass': 'swalerror', 'swalicon': 'icon-close', 'message': `${vm.smsdata}`}
                        Bus.$emit('show-message-swal', data)
                    }else{
                        vm.isSendingSMS = false;
                        if (isEmpty(vm.errors)) {
                            bk.smsstate = vm.smsReturnData.smsstate
                            this.$modal.hide('bookingModal');
                            let data = {'title': 'Sent!', 'bottomclass': 'darkerror', 'topclass': 'swalsuccess', 'swalicon': 'icon-cursor', 'message': `${bk.bookinglNumber} SMS Sent Successfuly!`}
                            Bus.$emit('show-message-swal', data)
                        }
                    }
                })
            },
            closemodal: function () {
                this.$modal.hide('bookingModal');
            }
        }
    }
</script>