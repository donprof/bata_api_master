<template>
    <div class="mymodal">
        <div class="modalbluepart mr-auto ml-auto">
            <div class="row">
                <div class="col-10 mt-2">
                    <h5 class="text-white ml-3 mt-2">{{reportdata.number}}</h5>
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
                        <label>Number</label>
                        <input type="text" v-model="reportdata.number" class="form-control">
                        <formerror v-if="errors.number" :error="errors.number[0]"></formerror>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" v-model="reportdata.title" class="form-control">
                        <formerror v-if="errors.title" :error="errors.title[0]"></formerror>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Role</label>
                        <v-select label="value" v-model="reportdata.role" :onChange="roleCallback" :options="userroles"></v-select>
                        <formerror v-if="errors.userRole" :error="errors.userRole[0]"></formerror>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Category</label>
                        <v-select v-if="reporttype == 1" label="value" v-model="reportdata.categoryname" :onChange="categoryCallback" :options="fuelnames"></v-select>
                        <v-select v-else label="value" v-model="reportdata.categoryname" :onChange="categoryCallback" :options="groupingtype"></v-select>
                        <formerror v-if="errors.category" :error="errors.category[0]"></formerror>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" v-model="reportdata.desc" class="form-control">
                        <formerror v-if="errors.description" :error="errors.description[0]"></formerror>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-right">
                    <button @click.prevent="updatereport" :disabled="isUpdating" class="btn btn-sm btn-success btn-rounded">
                        <i v-if="isUpdating" class="fa os-icon os-icon-grid-18 fa-spin"></i>
                        <span v-else>Update</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import vSelect from "vue-select"
    import Bus from '../bus'
    import { mapActions } from "vuex";
    import {isEmpty} from 'lodash'
    export default {
        components: {
            vSelect,
        },
        data (){
            return{
                errors: [],
                isUpdating: false,
                userroles: [{lable: 1, value: 'Normal user'},{lable: 2, value: 'Admin'},{lable: 3, value: 'Super admin'}],
                fuelnames: [{lable: 1, value: 'By distance'},{lable: 2, value: 'Fuel consumption'}],
            }
        },
        props:{
            reportdata:{
                required: true,
                type: Object
            },
            reporttype:{
                required: true,
                type: Number
            },
            groupingtype:{
                required: true,
                type: Array
            }
        },
        methods:{
            ...mapActions({
                update: 'fuelsettings/update',
            }),
            closemodal: function () {
                Bus.$emit('closed-settings-modal')
            },
            roleCallback(role){
                if (role.lable != null) {
                    this.reportdata.user_role = role.lable
                }
            },
            categoryCallback(ct){
                if (ct.lable != null) {
                    this.reportdata.category = ct.lable
                }
            },
            updatereport: function () {
                this.isUpdating = true;
                var vm = this;
                this.errors = [];
                this.update({
                    payload: {
                        id: this.reportdata.id,
                        reporttype: this.reporttype,
                        title: this.reportdata.title,
                        userRole: this.reportdata.user_role,
                        number: this.reportdata.number,
                        category: this.reportdata.category,
                        description: this.reportdata.desc
                    },
                    context: this
                }).then(() => {
                    this.isUpdating = false;
                    if (isEmpty(this.errors)) {
                        let data = {'title': 'Updated.', 'bottomclass': 'darkerror', 'topclass': 'swalsuccess', 'swalicon': 'icon-emotsmile', 'message': `${this.reportdata.number} updated successfully!`}
                        Bus.$emit('closed-settings-modal')
                        Bus.$emit('show-message-swal', data)
                    }
                })
            }
        }
    }
</script>