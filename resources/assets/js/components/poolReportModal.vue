<template>
    <div class="mymodal">
        <div class="modalbluepart mr-auto ml-auto">
            <div class="row">
                <div class="col-10 mt-2">
                    <h5 class="text-white ml-3 mt-2">{{report.number}} ({{report.title}})</h5>
                </div>
                <div class="col-2 text-right pt-2">
                    <i @click.prevent="closemodal" class="point text-white icon-close mr-2" style="font-size: 20px;"></i>
                </div>
            </div>
        </div>
        <div class="modalwhitepart mr-auto ml-auto">
            <template v-if="report.apislug == 'p01' || report.apislug == 'p02' || report.apislug == 'p03' || report.apislug == 'p04' || report.apislug == 'p05' || report.apislug == 'p07'">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group has-error has-danger">
                            <label> Cost center</label>
                            <v-select label="value" :onChange="centerCallback" :options="costcenters"></v-select>
                            <formerror v-if="errors.center" :error="errors.center[0]"></formerror>
                        </div>
                    </div>
                </div>
            </template>
            <template v-if="report.apislug == 'p02'">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group has-error has-danger">
                            <label> Booking state</label>
                            <v-select label="value" v-model="state" multiple :options="bookingStatus"></v-select>
                            <formerror v-if="errors.center" :error="errors.center[0]"></formerror>
                        </div>
                    </div>
                </div>
            </template>
            <template v-if="report.apislug == 'p06'">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group has-error has-danger">
                            <label> Departments</label>
                            <v-select label="value" v-model="department" multiple :options="departments"></v-select>
                            <formerror v-if="errors.center" :error="errors.center[0]"></formerror>
                        </div>
                    </div>
                </div>
            </template>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label> Date from</label>
                        <el-date-picker v-model="dateFrom" type="date" format="dd-MM-yyyy"></el-date-picker>
                        <formerror v-if="errors.dateFrom" :error="errors.dateFrom[0]"></formerror>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label> Date to</label>
                        <el-date-picker v-model="dateTo" type="date" format="dd-MM-yyyy"></el-date-picker>
                        <formerror v-if="errors.dateTo" :error="errors.dateTo[0]"></formerror>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <button @click.prevent="getReport('pdf')" class="btn btn-sm btn-secondary btn-rounded" :disabled="isLoading">
                        <span v-if="isLoading"><i class="fa fa-spinner fa-spin fa-fw"></i></span>
                        <span v-else>Get PDF</span>
                    </button>
                </div>
                <template v-if="report.apislug != 'p02'">
                    <div class="col-md-6 text-right">
                        <button @click.prevent="getReport('xlsx')" class="btn btn-sm btn-success btn-rounded" :disabled="isLoading">
                            <span v-if="isLoading"><i class="fa fa-spinner fa-spin fa-fw"></i></span>
                            <span v-else>Get Excel</span>
                        </button>
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>
<script>
    import vSelect from "vue-select"
    import { mapGetters, mapActions } from 'vuex'
    import { isEmpty } from 'lodash'
    import Bus from '../bus'
    export default {
        components: {
            vSelect,
        },
        data (){
            return{
                dateFrom: null,
                bookingStatus: [{'lable': 1, 'value': 'Booked'},{'lable': 2, 'value': 'Unbooked'},{'lable': 3, 'value': 'Canceled'}],
                dateTo: null,
                costCenter: null,
                department: null,
                state: null,
                isLoading: false,
                errors: []
            }
        },
        props:{
            report:{
                required: true,
                type: Object
            },
            costcenters:{
                required: true,
                type: Array
            },
            departments:{
                required: false,
                type: Array
            },
        },
        methods:{
            ...mapActions({
                getSelectReport: 'poolreports/getSelectReport',
            }),
            datacolected(type){
                let data = {
                    'dateFrom': this.dateFormater(this.dateFrom),
                    'dateTo': this.dateFormater(this.dateTo),
                    'center': this.costCenter,
                    'apislug': this.report.apislug,
                    'reportnum': this.report.number,
                    'reporttitle': this.report.title,
                    'state': this.state,
                    'department': this.department,
                    'reporttype': type
                }
                return data;
            },
            centerCallback(val){
                if (val.lable != null) {
                    this.costCenter = val.lable
                }
            },
            bookingCallback(val){
                if (val.lable != null) {
                    this.state = val.lable
                }
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
            closemodal: function () {
                Bus.$emit('modal-closed')
            },
            getReport: function (type) {
                this.isLoading = true;
                var loading = {'reportnumber': this.report.apislug, 'state': true}
                Bus.$emit('show-loading-animation', loading)
                this.errors = [];
                this.getSelectReport({
                    payload: {
                        data: this.datacolected(type),
                    },
                    context: this
                })
                .then(() => {
                    this.isLoading = false;
                    var newdata = {'reportnumber': this.report.apislug, 'state': false}
                    Bus.$emit('show-loading-animation', newdata)
                    if (isEmpty(this.errors)) {
                        Bus.$emit('modal-closed')
                        this.costCenter = ""
                        this.dateFrom = ""
                        this.dateTo = ""
                        this.state = ""
                        this.department = ""
                        this.errors = [];
                    }
                })
            }
        }
    }
</script>