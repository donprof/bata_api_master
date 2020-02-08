<template>
    <div class="mymodal">
        <div class="modalbluepart mr-auto ml-auto">
            <div class="row">
                <div class="col-10 mt-2">
                    <h5 v-if="state == 1" class="text-white ml-3 mt-2">{{base.name}}</h5>
                    <h5 v-else class="text-white ml-3 mt-2">New variation type.</h5>
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
                        <input v-if="state == 1" type="text" class="form-control" v-model="base.name">
                        <input v-else type="text" class="form-control" v-model="description">
                        <formerror v-if="errors.description" :error="errors.description[0]"></formerror>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="d-flex">Color</label>
                        <el-color-picker size="medium" v-if="state == 1"
                        v-model="base.colorcode"
                        show-alpha
                        :predefine="predefineColors">
                        </el-color-picker>

                        <el-color-picker size="medium" v-else
                        v-model="color"
                        show-alpha
                        :predefine="predefineColors">
                        </el-color-picker>
                        <formerror v-if="errors.colorcode" :error="errors.colorcode[0]"></formerror>
                    </div>
                </div>
            </div>
            <div class="row" v-if="state == 1">
                <div class="col-md-12 text-right">
                    <span class="lablevalue">{{base.created_at | moment}}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-right">
                    <button v-if="state == 1" @click.prevent="update" :disabled="isUpdating" class="btn btn-sm btn-success btn-rounded">
                        <i v-if="isUpdating" class="fa os-icon os-icon-grid-18 fa-spin"></i>
                        <span v-else>Update</span>
                    </button>
                    <button v-else @click.prevent="newbase" :disabled="isSubmitting" class="btn btn-sm btn-success btn-rounded">
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
                newdata:[],
                isSubmitting: false,
                isUpdating: false,
                errors: [],
                color: '#284963',
                description: null,
                predefineColors: [
                    '#ff4500',
                    '#ff8c00',
                    '#ffd700',
                    '#90ee90',
                    '#00ced1',
                    '#1e90ff',
                    '#c71585'
                ]
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
                updatProductVariationType: 'variationtypes/updatProductVariationType',
                createtypes: 'variationtypes/createtypes',
            }),
            closemodal: function () {
                Bus.$emit('close-variationtypesform-modal')
            },
            newbase(){
                this.isSubmitting = true;
                this.errors = [];
                this.createtypes({
                    payload: {
                        colorcode: this.color,
                        description: this.description,
                    },
                    context: this
                })
                .then(() => {
                    this.isSubmitting = false;
                    if (isEmpty(this.errors)) {
                        let data = {'title': 'Created.', 'bottomclass': 'darkerror', 'topclass': 'swalsuccess', 'swalicon': 'icon-like', 'message': `${this.description} created successfully !`}
                        Bus.$emit('close-variationtypesform-modal')
                        Bus.$emit('show-message-swal', data)
                        Bus.$emit('new-base-data', this.newdata)
                    }
                })
            },
            update(){
                this.isUpdating = true;
                this.errors = [];
                this.updatProductVariationType({
                    payload: {
                        description: this.base.name,
                        colorcode: this.base.colorcode,
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
        }
    }
</script>