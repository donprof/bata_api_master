<template>
    <div class="content-box">
        <div class="row" v-if="user.data != null">
            <div class="col-sm-4 mb-5">
                <div class="user-profile compact">
                    <div class="up-head-w bgstyle"
                    :style="{ background: 'url(assets/img/users/'+user.data.avatar+')', 'background-size': 'cover' }"
                    >
                        <div class="up-social">
                            <router-link to="/dashboard"><i class="os-icon os-icon-cancel-circle"></i></router-link>
                        </div>
                        <div class="up-main-info">
                            <h2 class="up-header">{{user.data.firstname}} {{user.data.lastname}}</h2>
                            <h6 class="up-sub-header">{{user.data.role}}</h6>
                        </div>
                        <svg class="decor" width="842px" height="219px" viewBox="0 0 842 219" preserveAspectRatio="xMaxYMax meet"
                            version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g transform="translate(-381.000000, -362.000000)" fill="#FFFFFF">
                                <path class="decor-path" d="M1223,362 L1223,581 L381,581 C868.912802,575.666667 1149.57947,502.666667 1223,362 Z"></path>
                            </g>
                        </svg>
                    </div>
                    <div class="up-controls">
                        <div class="row">
                            <div class="col-sm-6 pt-1">
                                <div class="value-pair">
                                    <div class="label">Status:</div>
                                    <div class="badge badge-success-inverted">Active</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="up-contents">
                        <div class="mb-0">
                            <div class="row">
                                <div class="col-sm-6 b-r b-b">
                                    <div class="el-tablo centered padded-v">
                                        <div class="value">0</div>
                                        <div class="label">Edits Count</div>
                                    </div>
                                </div>
                                <div class="col-sm-6 b-b">
                                    <div class="el-tablo centered padded-v">
                                        <div class="value">0</div>
                                        <div class="label">Addings Count</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="element-wrapper">
                    <div class="element-box">
                        <div class="element-info">
                            <div class="element-info-with-icon">
                                <div class="element-info-icon">
                                    <div class="os-icon os-icon-wallet-loaded"></div>
                                </div>
                                <div class="element-info-text">
                                    <h5 class="element-inner-header">Profile Settings</h5>
                                    <div class="element-inner-desc">
                                        You have an Admin account which can only be changed by the system admin.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label> First name</label>
                                    <input class="form-control" type="text" v-model="user.data.firstname">
                                    <formerror v-if="errors.avatar" :error="errors.avatar[0]"></formerror>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Last name</label>
                                    <input class="form-control" type="text" v-model="user.data.lastname">
                                    <formerror v-if="errors.avatar" :error="errors.avatar[0]"></formerror>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label> Theme</label>
                                    <v-select label="value" v-model="user.data.themename" :onChange="themeUpdateCallback" :options="usertheme"></v-select>
                                    <formerror v-if="errors.theme" :error="errors.theme[0]"></formerror>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Phone number</label>
                                    <input class="form-control" type="text" v-model="user.data.phone">
                                    <formerror v-if="errors.phoneNumber" :error="errors.phoneNumber[0]"></formerror>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label> Profile photo</label>
                                    <input style="visibility: hidden;" type="file" ref="fileInput"/>
                                    <div class="logged-user-w avatar-inline px-0 pt-0">
                                        <div class="logged-user-i pl-0">
                                            <div @click="trigger" class="avatar-w point"><img src="assets/img/avatar1.jpg"></div>
                                            <div class="logged-user-info-w">
                                                <div class="logged-user-name">{{user.data.firstname}} {{user.data.lastname}}</div>
                                                <div class="logged-user-role"><small>(Click to change)</small></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <imagerupload user="profile"/> -->
                                    <formerror v-if="errors.avatar" :error="errors.avatar[0]"></formerror>
                                </div>
                            </div>
                        </div>
                        <h6 class="text-primary element-header mb-4">Password changing section</h6>
                        <div class="form-group">
                            <label> Old Password</label>
                            <input class="form-control" v-model="oldpassword" autocomplete="off" type="password">
                            <formerror v-if="errors.oldpassword" :error="errors.oldpassword[0]"></formerror>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label> New Password</label>
                                    <input class="form-control" v-model="password" data-minlength="6" type="password">
                                    <formerror v-if="errors.password" :error="errors.password[0]"></formerror>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input class="form-control" v-model="password_confirmation" type="password">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <button @click.prevent="update" :disabled="isUpdating" class="btn btn-sm btn-outline-success btn-rounded">
                                    <i v-if="isUpdating" class="fa os-icon os-icon-grid-18 fa-spin"></i>
                                    <span v-else>Update</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'
import Bus from '../../../bus'
import { isEmpty } from 'lodash'
import vSelect from "vue-select"
export default {
    data() {
        return {
            usertheme: [{lable: 1, value: 'Light'},{lable: 2, value: 'Dark'}],
            isUpdating: false,
            oldpassword: null,
            password: null,
            password_confirmation: null,
            errors: []
        }
    },
    components: {
        vSelect,
    },
    computed:{
        ...mapGetters({
            user: 'auth/user'
        }),
    },
    methods:{
        ...mapActions({
            updateProfile: 'users/updateProfile',
        }),
        trigger () {
            this.$refs.fileInput.click()
        },
        themeUpdateCallback(theme){
            if (theme.lable != null) {
                this.user.data.theme = theme.lable
            }
        },
        update: function(){
            this.isUpdating = true;
            var vm = this;
            this.errors = [];
            this.updateProfile({
                payload: {
                    id: this.user.data.id,
                    firstName: this.user.data.firstname,
                    lastName: this.user.data.lastname,
                    phoneNumber: this.user.data.phone,
                    avatar: this.user.data.avatar,
                    theme: this.user.data.theme,
                    oldAvatar: this.oldAvatar,
                    oldpassword: this.oldpassword,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                },
                context: this
            }).then(() => {
                this.isUpdating = false;
                if (isEmpty(this.errors)) {
                    this.oldAvatar = null
                    this.oldpassword = null
                    this.password = null
                    this.password_confirmation = null
                    let data = {'title': 'Updated.', 'bottomclass': 'darkerror', 'topclass': 'swalsuccess', 'swalicon': 'icon-emotsmile', 'message': `${this.user.data.firstname}'s account updated !`}
                    Bus.$emit('show-message-swal', data)
                }
            })
            
            Echo.private('App.User.1')
            .notification('themechanged', (data) => {
                console.log(data)
            })
            // .listen('UserEvent', data => this.updates.unshift(data.update))
        }
    },
    mounted (){
        Bus.$on('image-upload-switchprofile', (data)=> {
            this.oldAvatar = this.user.data.avatar
            this.user.data.avatar = data
        })

        Bus.$on('new-update', (data)=> {
             console.log(data)
        })
        

        // Echo.private('users')
        // .listen('themechanged', (e) => {
        //     console.log(e)
        // })
    }
}
</script>

<style>

</style>
