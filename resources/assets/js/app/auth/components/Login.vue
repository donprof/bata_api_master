<template>
    <div class="container">
    <div class="row flex-center min-vh-100">
        <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4"><span class="d-flex flex-center mb-4"><img class="mr-2" src="/assets/img/illustrations/Bata-logo.png" alt="" width="150" /></span>
            <div class="card">
                <div class="card-body p-5">
                    <div class="row text-left justify-content-between">
                        <div class="col-auto mb-3">
                            <h5> Log in</h5>
                        </div>
                    </div>
                    <form @submit.prevent="submit">
                        <div class="form-group">
                            <input v-model="email" :class="{'animated shake': errors.email}" class="form-control" type="email" placeholder="Email address" />
                            <ul class="list-unstyled text-danger small" v-if="errors.email">
                                <li>{{errors.email[0]}}</li>
                            </ul>
                        </div>
                        <div class="form-group">
                            <input v-model="password" :class="{'animated shake': errors.password}" class="form-control" type="password" placeholder="Password" />
                            <ul class="list-unstyled text-danger small" v-if="errors.password">
                                <li>{{errors.password[0]}}</li>
                            </ul>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-auto">
                                <div class="custom-control custom-checkbox"></div>
                            </div>
                            <div class="col-auto">
                                <router-link class="fs--1" to="/resetpassword">
                                    Forget Password? <h3 class="point fliparrow text-dark icon-arrow-down-circle"></h3>
                                </router-link>
                            </div>
                        </div>
                        <div class="form-group">
                            <button :disabled="isSubmitting" class="btn btn-primary btn-block mt-3" type="submit">
                                <i v-if="isSubmitting" class="fa os-icon os-icon-grid-18 fa-spin mt-2"></i>
                                <span v-else>Log in</span>
                            </button>
                        </div>
                    </form>
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
                emailconfirmation: null,
                display: false,
                emailReset: null,
                password: null,
                magic_flag: false,
                isSubmitting: false,
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
                login: 'auth/login'
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
            submit () {
                this.isSubmitting = true;
                this.errors = [];
                this.login({
                    payload: {
                        email: this.email,
                        password: this.password
                    },
                    context: this
                }).then(() => {
                    this.isSubmitting = false;
                    localforage.getItem('intended').then((name) => {
                        if (isEmpty(name)) {
                            this.$router.replace({ name: 'dashboard' })
                            return
                        }
                        this.$router.replace({ name: name })
                    })
                })
            }
        }
    }
</script>
<style scoped>
    ul{
        margin-bottom: 0;
    }
</style>