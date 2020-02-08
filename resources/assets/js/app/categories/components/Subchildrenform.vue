<template>
    <div class="mymodal">
        <div class="modalbluepart mr-auto ml-auto">
            <div class="row">
                <div class="col-10 mt-2">
                    <h5 v-if="state == 1" class="text-white ml-3 mt-2">{{base.name}}</h5>
                    <h5 v-else class="text-white ml-3 mt-2">New parent category.</h5>
                </div>
                <div class="col-2 text-right pt-2">
                    <i @click.prevent="closemodal" class="point text-white icon-close mr-2" style="font-size: 20px;"></i>
                </div>
            </div>
        </div>
        <div class="modalwhitepart mr-auto ml-auto">
            <!-- Updating sub children that is clicked-->
            <div class="row" v-if="updatingSubDetails">
                <div class="col-md-12 text-right">
                    <span class="badge badge rounded-capsule badge-soft-warning point" @click="cancelEdit">Close edit <i class="fa fa-check"></i> </span>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="updatedetails.name">
                        <formerror v-if="errors.name" :error="errors.name[0]"></formerror>
                    </div>
                </div>
                <div class="col-md-12 text-right">
                    <button v-if="state == 1" @click.prevent="updateSubCategory" :disabled="isUpdating" class="btn btn-sm btn-info btn-rounded">
                        <i v-if="isUpdating" class="fa os-icon os-icon-grid-18 fa-spin"></i>
                        <span v-else>Update</span>
                    </button>
                    <button v-else @click.prevent="newParentCategory" :disabled="isSubmitting" class="btn btn-sm btn-success btn-rounded">
                        <i v-if="isSubmitting" class="fa os-icon os-icon-grid-18 fa-spin"></i>
                        <span v-else>Save</span>
                    </button>
                </div>
            </div>

            <!-- Edit selected child -->
            <div class="row" v-else-if="editingSelectedChild">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="base.name">
                        <formerror v-if="errors.name" :error="errors.name[0]"></formerror>
                    </div>
                </div>
                <div class="col-md-12 text-right">
                    <button @click.prevent="update" :disabled="isUpdating" class="btn btn-sm btn-success btn-rounded">
                        <i v-if="isUpdating" class="fa os-icon os-icon-grid-18 fa-spin"></i>
                        <span v-else>Update</span>
                    </button>
                </div>
            </div>

            <!-- Adding sub category -->
            <div class="row" v-else-if="AddingChildCategory">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Name child category</label>
                        <input type="text" class="form-control" v-model="name">
                        <formerror v-if="errors.name" :error="errors.name[0]"></formerror>
                    </div>
                </div>
                <div class="col-md-12 text-right">
                    <button @click.prevent="newSubChildCategory" :disabled="isSubmitting" class="btn btn-sm btn-success btn-rounded">
                        <i v-if="isSubmitting" class="fa os-icon os-icon-grid-18 fa-spin"></i>
                        <span>Save</span>
                    </button>
                </div>
            </div>

        </div>


        <div class="card mb-3 animated zoomIn faster">
            <div class="card-header">
                <div class="row align-items-center justify-content-between">
                    <div class="col-6 col-sm-auto d-flex align-items-center pr-0">
                        <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0">Variations.</h5>
                    </div>
                    <div class="col-6 col-sm-auto ml-auto text-right pl-0">
                        <div id="dashboard-actions">
                            <button class="btn btn-falcon-default btn-sm" @click="addingNewChild" type="button">
                                <span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span>
                                <span class="d-none d-sm-inline-block ml-1">New Sub category for {{base.name}}</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                <table class="table table-sm mb-0 table-dashboard fs--1">
                    <thead class="bg-200 text-900">
                    <tr>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody id="purchases">
                        <tr class="btn-reveal-trigger" v-for="vr in base.subchildren" :key="vr.id">
                            <td class="align-middle">{{vr.name}}</td>
                            <td class="align-middle white-space-nowrap">
                                <div class="dropdown text-sans-serif">
                                    <button class="btn btn-link text-600 btn-sm btn-reveal mr-3" @click="selectedSubChild(vr)" type="button"><span class="far fa-edit fs--1"></span></button>
                                    <button class="btn btn-link text-600 btn-sm btn-reveal mr-3" type="button"><span class="far fa-trash-alt fs--1"></span></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
                newdata:[],
                isSubmitting: false,
                isUpdating: false,
                updatingSubDetails: false,
                AddingChildCategory: false,
                editingSelectedChild: true,
                updatedetails:null,
                errors: [],
                name: null,
            }
        },
        filters:{
            moment: function(date) {
                return moment(date, 'YYYY-M-D').fromNow()
            }
        },
        props:{
            base:{
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
                updatCategory: 'categories/updatCategory',
                createParentCategory: 'categories/createParentCategory',
            }),
            closemodal: function () {
                Bus.$emit('close-variationtypesform-modal')
            },
            addingNewChild(){
                this.AddingChildCategory = true
                this.editingSelectedChild = false
                this.updatingSubDetails = false
            },
            cancelEdit(){
                this.updatingSubDetails = false
                this.updatedetails = null
            },
            selectedSubChild(val){
                this.updatedetails = val
                this.editingSelectedChild = true
                this.updatingSubDetails = true
            },
            newSubChildCategory(){
                this.isSubmitting = true;
                this.errors = [];
                this.createParentCategory({
                    payload: {
                        name: this.name,
                        childSlug: this.base.slug,
                        subparent: true,
                    },
                    context: this
                })
                .then(() => {
                    this.isSubmitting = false;
                    if (isEmpty(this.errors)) {
                        let data = {'title': 'Created.', 'bottomclass': 'darkerror', 'topclass': 'swalsuccess', 'swalicon': 'icon-like', 'message': `${this.name} created successfully !`}
                        Bus.$emit('close-variationtypesform-modal')
                        Bus.$emit('show-message-swal', data)
                        Bus.$emit('new-category-data', this.newdata)
                    }
                })
            },
            newParentCategory(){
                this.isSubmitting = true;
                this.errors = [];
                if (this.state == 3) {
                    var data = {
                        name: this.name,
                        parentSlug: this.base.slug,
                    }
                }
                this.createParentCategory({
                    payload: data,
                    context: this
                })
                .then(() => {
                    this.isSubmitting = false;
                    if (isEmpty(this.errors)) {
                        let data = {'title': 'Created.', 'bottomclass': 'darkerror', 'topclass': 'swalsuccess', 'swalicon': 'icon-like', 'message': `${this.name} created successfully !`}
                        Bus.$emit('close-variationtypesform-modal')
                        Bus.$emit('show-message-swal', data)
                        Bus.$emit('new-category-data', this.newdata)
                    }
                })
            },
            update(){
                this.isUpdating = true;
                this.errors = [];
                this.updatCategory({
                    payload: {
                        name: this.base.name,
                        id: this.base.id
                    },
                    context: this
                })
                .then(() => {
                    this.isUpdating = false;
                    if (isEmpty(this.errors)) {
                        let data = {'title': 'Updated.', 'bottomclass': 'darkerror', 'topclass': 'swalsuccess', 'swalicon': 'icon-like', 'message': `${this.base.name} updated successfully !`}
                        Bus.$emit('close-variationtypesform-modal')
                        Bus.$emit('show-message-swal', data)
                    }
                })
            },
            updateSubCategory(){
                this.isUpdating = true;
                this.errors = [];
                this.updatCategory({
                    payload: {
                        name: this.updatedetails.name,
                        id: this.updatedetails.id
                    },
                    context: this
                })
                .then(() => {
                    this.isUpdating = false;
                    if (isEmpty(this.errors)) {
                        let data = {'title': 'Updated.', 'bottomclass': 'darkerror', 'topclass': 'swalsuccess', 'swalicon': 'icon-like', 'message': `${this.updatedetails.name} updated successfully !`}
                        Bus.$emit('close-variationtypesform-modal')
                        Bus.$emit('show-message-swal', data)
                    }
                })
            },
            
        }
    }
</script>