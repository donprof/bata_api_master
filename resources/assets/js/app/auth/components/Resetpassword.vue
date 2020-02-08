<template>
    <div class="content-box">
        <div class="pipelines-w">
            <div class="loginwrapper ml-auto mr-auto" :class="[user.authenticated == false ? 'topspace' : 'topspacelockscreen']">
                <div class="resetblock animated faster bounceInDown">
                    <div class="resetinner">
                        <div class="fdata">
                            <router-link to="/login">
                                <h3 @click="rotateCard" class="text-dark icon-arrow-up-circle point"></h3>
                            </router-link>
                            <div class="llogin">
                                <img width="120" height="120" src="/assets/img/logo2.png" alt="logo">
                            </div>
                            <div class="row">
                                <div class="col-10 mx-auto text-center">
                                    <h6 class="element-header text-info">Fleet Management Solution</h6>
                                </div>
                            </div>
                            <div class="resetform">
                                <form @submit.prevent="resetaccount">
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <input v-model="email" type="email" placeholder="Email" class="custominput shadow" :class="{'animated shake faster': errors.email}">
                                            <ul class="list-unstyled text-danger" v-if="errors.email">
                                                <li>{{errors.email[0]}}</li>
                                            </ul>
                                        </div>
                                        <div class="col-12 mt-4">
                                            <input v-model="email_confirmation" type="email" placeholder="Retype Email" class="custominput shadow" :class="{'animated shake faster': errors.email_confirmation}">
                                        </div>
                                    </div>
                                    <button type="submit" :disabled="isResetting" class="resetbtn btn-success ctbutton">
                                        <i v-if="isResetting" class="fa os-icon os-icon-grid-18 fa-spin mt-2"></i>
                                        <span v-else>Reset</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {mapActions, mapGetters} from 'vuex'
    import localforage from 'localforage'
    import isEmpty from 'lodash'
    export default {
        data (){
            return {
                email:null,
                useremail: null,
                email_confirmation: null,
                display: false,
                emailReset: null,
                password: null,
                magic_flag: false,
                isResetting: false,
                errors:[]
            }
        },
        computed:{
            ...mapGetters({
                user: 'auth/user'
            }),
        },
        methods:{
            ...mapActions({
                iforgot: 'auth/resetpassword'
            }),
            rotateCard(){
                if(this.magic_flag== true){
                    this.display = false
                    this.magic_flag = false
                }else {
                    this.display = true
                    this.magic_flag = true
                }
            },
            resetaccount () {
                this.isResetting = true;
                this.errors = [];
                this.iforgot({
                    payload: {
                        email: this.email,
                        email_confirmation: this.email_confirmation,
                    },
                    context: this
                }).then(() => {
                   this.isResetting = false;
                   if (isEmpty(this.errors.email) == false) {
                       this.$router.replace({ name: 'login' })
                   }
                })
            },
        }
    }
</script>
<style scoped>
    ul{
        margin-bottom: 0;
    }
</style>