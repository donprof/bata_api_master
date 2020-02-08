<template>
    <div class="mymodal">
        <div class="modalbluepart mr-auto ml-auto">
            <div class="row">
                <div class="col-10 mt-2">
                    <h5 v-if="state == 1" class="text-white ml-3 mt-2">{{cnt.code}}: {{cnt.company}}</h5>
                    <h5 v-else class="text-white ml-3 mt-2">New cost center</h5>
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
                        <label>Name</label>
                        <input v-if="state == 1" type="text" class="form-control" v-model="cnt.company">
                        <input v-else type="text" class="form-control" v-model="company">
                        <formerror v-if="errors.company" :error="errors.company[0]"></formerror>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group has-error has-danger">
                        <label for="">Telephone</label>
                        <input v-if="state == 1" type="text" class="form-control" v-model="cnt.telephone">
                        <input v-else type="text" class="form-control" v-model="telephone">
                        <formerror v-if="errors.companyTelephone" :error="errors.companyTelephone[0]"></formerror>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" v-if="state != 1">
                    <div class="form-group has-error has-danger">
                        <label for="">Code</label>
                        <input type="number" class="form-control" v-model="code">
                        <formerror v-if="errors.companyCode" :error="errors.companyCode[0]"></formerror>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group has-error has-danger">
                        <label for="">Address</label>
                        <input v-if="state == 1" type="text" class="form-control" v-model="cnt.address">
                        <input v-else type="text" class="form-control" v-model="address">
                        <formerror v-if="errors.companyAddress" :error="errors.companyAddress[0]"></formerror>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group has-error has-danger">
                        <label for="">Reports Name</label>
                        <input v-if="state == 1" type="text" class="form-control" v-model="cnt.reportsname">
                        <input v-else type="text" class="form-control" v-model="reportsName">
                        <formerror v-if="errors.reportsName" :error="errors.reportsName[0]"></formerror>
                    </div>
                </div>
            </div>
            <div class="row" v-if="state == 1">
                <div class="col-md-6 text-success">
                    <span class="value with-avatar">
                        <img v-if="cnt.user != null" :src="'assets/img/users/' + cnt.user.avatar">
                        <span>{{cnt.user.full_name}}</span>
                    </span>
                </div>
                <div class="col-md-6 text-right">
                    <span class="lablevalue">{{cnt.created_at | moment}}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-right">
                    <button v-if="state == 1" @click.prevent="update" :disabled="isUpdating" class="btn btn-sm btn-success btn-rounded">
                        <i v-if="isUpdating" class="fa os-icon os-icon-grid-18 fa-spin"></i>
                        <span v-else>Update</span>
                    </button>
                    <button v-else @click.prevent="newcenter" :disabled="isSubmitting" class="btn btn-sm btn-success btn-rounded">
                        <i v-if="isSubmitting" class="fa os-icon os-icon-grid-18 fa-spin"></i>
                        <span v-else>Save</span>
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
                company: null,
                code: null,
                address: null,
                telephone: null,
                reportsName: null,
                newdata:[],
                isSubmitting: false,
                isUpdating: false,
                errors: []
            }
        },
        filters:{
            moment: function(date) {
                return moment(date).fromNow()
            }
        },
        props:{
            cnt:{
                required: false,
                type: Object
            },
            state:{
                required: true,
                type: Number
            }
        },
        methods:{
            ...mapActions({
                updatCenter: 'costcenters/updatCenter',
                createcenter: 'costcenters/createcenter',
            }),
            closemodal: function () {
                Bus.$emit('close-center-modal')
            },
            newcenter(){
                this.isSubmitting = true;
                this.errors = [];
                this.createcenter({
                    payload: {
                        company: this.company,
                        companyCode: this.code,
                        companyAddress: this.address,
                        reportsName: this.reportsName,
                        companyTelephone: this.telephone
                    },
                    context: this
                })
                .then(() => {
                    this.isSubmitting = false;
                    if (isEmpty(this.errors)) {
                        this.$modal.hide('centerModal')
                        let data = {'title': 'Created.', 'bottomclass': 'darkerror', 'topclass': 'swalsuccess', 'swalicon': 'icon-like', 'message': `${this.company} created successfully !`}
                        Bus.$emit('show-message-swal', data)
                        Bus.$emit('new-center-data', this.newdata)
                    }
                })
            },
            update(){
                this.isUpdating = true;
                this.errors = [];
                this.updatCenter({
                    payload: {
                        company: this.cnt.company,
                        companyCode: this.cnt.code,
                        companyAddress: this.cnt.address,
                        reportsName: this.cnt.reportsname,
                        companyTelephone: this.cnt.telephone
                    },
                    context: this
                })
                .then(() => {
                    this.isUpdating = false;
                    if (isEmpty(this.errors)) {
                        this.$modal.hide('centerModal')
                        let data = {'title': 'Updated.', 'bottomclass': 'darkerror', 'topclass': 'swalsuccess', 'swalicon': 'icon-like', 'message': `${this.cnt.company} updated successfully !`}
                        Bus.$emit('show-message-swal', data)
                    }
                })
            },
        }
    }
</script>