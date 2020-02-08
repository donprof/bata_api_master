<template>
    <div class="mymodal">
        <div class="modalbluepart mr-auto ml-auto">
            <div class="row">
                <div class="col-10 mt-2">
                    <h5 class="text-white ml-3 mt-2">Orders report {{report.number}}</h5>
                </div>
                <div class="col-2 text-right pt-2">
                    <i @click.prevent="closemodal" class="point text-white icon-close mr-2" style="font-size: 20px;"></i>
                </div>
            </div>
        </div>
        <div class="modalwhitepart mr-auto ml-auto">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Date from</label>
                        <el-date-picker v-model="datefrom" type="date" format="dd-MM-yyyy"></el-date-picker>
                        <formerror v-if="errors.datefrom" :error="errors.datefrom[0]"></formerror>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Date to</label>
                        <el-date-picker v-model="dateto" type="date" format="dd-MM-yyyy"></el-date-picker>
                        <formerror v-if="errors.dateto" :error="errors.dateto[0]"></formerror>
                    </div>
                </div>
                <!-- <div class="col-md-12">
                    <div class="form-group">
                        <label>Description</label>
                        <input v-if="state == 1" type="text" class="form-control" v-model="base.description">
                        <input v-else type="text" class="form-control" v-model="description">
                        <formerror v-if="errors.description" :error="errors.description[0]"></formerror>
                    </div>
                </div> -->
            </div>
            <div class="row">
                <div class="col-md-6">
                    <button @click.prevent="getReport('pdf')" :disabled="isSubmitting" class="btn btn-sm btn-success btn-rounded">
                        <i v-if="isSubmitting" class="fa os-icon os-icon-grid-18 fa-spin"></i>
                        <span v-else>Download pdf</span>
                    </button>
                </div>
                <div class="col-md-6 text-right">
                    <button @click.prevent="getReport('xlsx')" :disabled="isSubmitting" class="btn btn-sm btn-success btn-rounded">
                        <i v-if="isSubmitting" class="fa os-icon os-icon-grid-18 fa-spin"></i>
                        <span v-else>Download Excel</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Bus from '../../../bus'
    import { mapGetters, mapActions } from 'vuex'
    import { isEmpty } from 'lodash'
    import moment from 'moment'
    export default {
        data(){
            return{
                datefrom: null,
                dateto: null,
                newdata:[],
                isSubmitting: false,
                errors: [],
            }
        },
        filters:{
            moment: function(date) {
                return moment(date, 'YYYY-M-D').fromNow()
            }
        },
        props:{
            state:{
                required: true,
                type: Number
            },
            report:{
                required: true,
                type: Object
            }
        },
        methods:{
            ...mapActions({
                getSelectReport: 'reports/getSelectReport',
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
            datacolected(type){
                let data = {
                    'datefrom': this.dateFormater(this.datefrom),
                    'dateto': this.dateFormater(this.dateto),
                    'apislug': this.report.apislug,
                    'reportnum': this.report.number,
                    'reporttitle': this.report.title,
                    'reporttype': type
                }
                return data;
            },
            closemodal: function () {
                Bus.$emit('close-report-modal')
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
                        this.dateFrom = ""
                        this.dateTo = ""
                        this.state = ""
                        this.errors = [];
                    }
                })
            }
        },
        mounted() {
            Bus.$on('offer-image-upload', (data)=> {
                if (this.state == 1) {
                    console.log(data)
                    console.log(this.base.image)
                    this.oldImage = this.base.image
                    this.base.image = data
                }else{
                    this.image = data
                }
            })
        }
    }
</script>