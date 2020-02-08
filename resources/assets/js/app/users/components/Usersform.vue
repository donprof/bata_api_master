<template>
    <div class="mymodal">
        <div class="modalbluepart mr-auto ml-auto" style="background-color:transparent; box-shadow: none;">
            <div class="row">
                <div class="logged-user-w col-12 text-center">
                    <div class="avatar">
                        <img v-if="state == 1" class="rounded-circle" width="80" :src="user.imagelink+'users/'+user.avatar">
                        <span v-else>
                            <img v-if="avatar == null" class="rounded-circle" width="80" src="assets/img/unkownuser.png">
                            <img v-else class="rounded-circle" width="80" :src="'assets/img/users/'+avatar">
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modalwhitepart mr-auto ml-auto">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label> First name</label>
                        <input v-if="state == 1" type="text" class="form-control" v-model="user.name">
                        <input v-else type="text" class="form-control" v-model="firstName">
                        <formerror v-if="errors.firstName" :error="errors.firstName[0]"></formerror>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label> Email</label>
                        <input v-if="state == 1" type="text" class="form-control" v-model="user.email">
                        <input v-else type="text" class="form-control" v-model="email">
                        <formerror v-if="errors.email" :error="errors.email[0]"></formerror>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group has-error has-danger">
                        <label for=""> Phone number</label>
                        <input v-if="state == 1" type="text" class="form-control" v-model="user.phone">
                        <input v-else v-model="phoneNumber" class="form-control" type="tel">
                        <formerror v-if="errors.phoneNumber" :error="errors.phoneNumber[0]"></formerror>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label> Total loyalty point</label>
                        <input v-if="state == 1" type="text" class="form-control" v-model="user.loyaltypoint">
                        <input v-else type="text" class="form-control" v-model="email">
                        <formerror v-if="errors.email" :error="errors.email[0]"></formerror>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group has-error has-danger">
                        <label for=""> Earned points</label>
                        <input v-if="state == 1" type="text" class="form-control" v-model="user.earnedpoints">
                        <input v-else v-model="phoneNumber" class="form-control" type="tel">
                        <formerror v-if="errors.phoneNumber" :error="errors.phoneNumber[0]"></formerror>
                    </div>
                </div>
            </div>
            <div class="row" v-if="state == 1">
                <div class="col-md-6 text-left">
                    <span class="lablevalue">{{user.created_at | moment}}</span>
                </div>
                <div class="col-md-6 text-right">
                    <button @click.prevent="closemodal" class="btn btn-sm btn-danger btn-rounded">Close</button>
                </div>
            </div>
            <!-- <div class="row">
                <div class="col-md-6 text-right">
                    <button @click.prevent="closemodal" class="btn btn-sm btn-danger btn-rounded">Close</button>
                </div>
                <div class="col-md-6">
                    <button v-if="state == 1" @click.prevent="update" :disabled="isUpdating" class="btn btn-sm btn-outline-success btn-rounded">
                        <i v-if="isUpdating" class="fa os-icon os-icon-grid-18 fa-spin"></i>
                        <span v-else>Update</span>
                    </button>
                    <button v-else @click.prevent="newuser" :disabled="isSubmitting" class="btn btn-sm btn-outline-success btn-rounded">
                        <i v-if="isSubmitting" class="fa os-icon os-icon-grid-18 fa-spin"></i>
                        <span v-else>Save</span>
                    </button>
                </div>
            </div> -->
        </div>
    </div>
</template>
<script>
    import Bus from '../../../bus'
    import { mapGetters, mapActions } from 'vuex'
    import { isEmpty } from 'lodash'
    import vSelect from "vue-select"
    import moment from 'moment'
    export default {
        components: {
            vSelect,
        },
        data(){
            return{
                firstName: null,
                lastName: null,
                email: null,
                costCenter: null,
                phoneNumber: null,
                theme:null,
                role: null,
                password: null,
                password_confirmation: null,
                avatar: null,
                oldAvatar: null,
                userroles: [{lable: 1, value: 'Normal user'},{lable: 2, value: 'Adminisrator'},{lable: 3, value: 'Super admin'}],
                usertheme: [{lable: 1, value: 'Light'},{lable: 2, value: 'Dark'}],
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
            user:{
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
                createuser: 'users/createuser',
                updateUser: 'users/updateUser',
            }),
            roleUpdateCallback(role){
                if (role.lable != null) {
                    this.user.roleid = role.lable
                }
            },
            roleCallback(role){
                if (role != null) {
                    this.role = role.lable
                }
            },

            themeUpdateCallback(theme){
                if (theme.lable != null) {
                    this.user.theme = theme.lable
                }
            },
            themeCallback(theme){
                if (theme != null) {
                    this.theme = theme.lable
                }
            },

            centerCallback(ct){
                if (ct != null) {
                    this.costCenter = ct.lable
                }
            },
            closemodal: function () {
                Bus.$emit('close-usr-modal')
            },
            newuser(){
                this.isSubmitting = true;
                this.errors = [];
                this.createuser({
                    payload: {
                        firstName: this.firstName,
                        lastName: this.lastName,
                        email: this.email,
                        costCenter: this.costCenter,
                        phoneNumber: this.phoneNumber,
                        role: this.role,
                        avatar: this.avatar,
                        password: this.password,
                        theme: this.theme,
                        password_confirmation: this.password_confirmation,
                    },
                    context: this
                })
                .then(() => {
                    this.isSubmitting = false;
                    if (isEmpty(this.errors)) {
                        let data = {'title': 'Created.', 'bottomclass': 'darkerror', 'topclass': 'swalsuccess', 'swalicon': 'icon-emotsmile', 'message': `${this.firstName}'s account created !`}
                        Bus.$emit('close-usr-modal')
                        Bus.$emit('show-message-swal', data)
                        Bus.$emit('new-usr-data', this.newdata)
                    }
                })
            },
            update: function(){
                this.isUpdating = true;
                var vm = this;
                this.errors = [];
                this.updateUser({
                    payload: {
                        id: this.user.id,
                        firstName: this.user.firstname,
                        lastName: this.user.lastname,
                        email: this.user.email,
                        costCenter: this.user.costCenter,
                        phoneNumber: this.user.phone,
                        role: this.user.roleid,
                        avatar: this.user.avatar,
                        theme: this.user.theme,
                        oldAvatar: this.oldAvatar,
                    },
                    context: this
                }).then(() => {
                    this.isUpdating = false;
                    if (isEmpty(this.errors)) {
                        this.oldAvatar = null
                        let data = {'title': 'Updated.', 'bottomclass': 'darkerror', 'topclass': 'swalsuccess', 'swalicon': 'icon-emotsmile', 'message': `${this.user.firstname}'s account updated !`}
                        Bus.$emit('close-usr-modal')
                        Bus.$emit('show-message-swal', data)
                    }
                })
            }
        },
        mounted (){
            Bus.$on('image-upload-switchuser', (data)=> {
                if (this.state == 1) {
                    this.oldAvatar = this.user.avatar
                    this.user.avatar = data
                }else{
                    this.avatar = data
                }
            })
        }
    }
</script>
<style scoped>
.logged-user-w .avatar-w{
    border: 2px solid #ffffff;
}
.logged-user-w{
    padding: .2rem 1rem;
}
.avatar-w:before{
    content: "";
    position: absolute;
    width: 20px;
    height: 20px;
    left: 48.3%;
    bottom: -2px;
    border-left: 10px solid transparent;
    border-right: 10px solid transparent;
    border-bottom: 12px solid white;
}
</style>
