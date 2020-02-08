<template>
    <div class="card mb-3 animated zoomIn faster">
        <div class="card-header bg-light">
            <div class="row align-items-center">
            <div class="col">
                <h5 class="mb-0" id="followers">Customers <span class="d-none d-sm-inline-block"></span></h5>
            </div>
            <div class="col">
                <form>
                <div class="row no-gutters">
                    <div class="col"><input class="form-control form-control-sm" type="text" placeholder="Search..."></div>
                </div>
                </form>
            </div>
            </div>
        </div>
        <div class="card-body bg-light p-0">
            <div class="row no-gutters text-center fs--1">
                <userdata v-for="user in users" :key="user.id" :user="user"></userdata>
            </div>
        </div>

        <modal name="userDataModal" :scrollable="true" classes="animated bounceInDown faster" :clickToClose="true" height="auto" :adaptive="true" :pivotY="0.2">
            <usersform :user="user" :state="state"></usersform>
        </modal>
    </div>
</template>
<script>
    import Bus from '../../../bus'
    import { mapGetters, mapActions } from 'vuex'
    import { isEmpty } from 'lodash'
    export default {
        data () {
            return {
                errors: [],
                state: null,
                search: null,
                isSearching: false,
                isLoading: false,
                searchSearch:''
            }
        },
        computed: {
            ...mapGetters({
                users: 'users/getusers',
                user: 'users/getUser',
                centers: 'costcenters/getCenterList',
            }),
            normaluser: function(){
                var normaluser = [];
                normaluser = this.users.filter((usr) => {
                    return usr.roleid == '1'
                })
                return normaluser;
            },
            admin: function(){
                var admin = [];
                admin = this.users.filter((usr) => {
                    return usr.roleid == '2'
                })
                return admin;
            },
            superuser: function(){
                var superuser = [];
                superuser = this.users.filter((usr) => {
                    return usr.roleid == '3'
                })
                return superuser;
            },
            userSearch:function(){
                var self = this
                if (this.searchSearch == '') {
                    return this.users
                }
                return this.users.filter(function(user){
                    return user.full_name.toLowerCase().indexOf(self.searchSearch) >=0
                });
            }
        },
        methods: {
            ...mapActions({
                fetchUsers: 'users/fetchUsers',
                fetchCenterList: 'costcenters/fetchCenterList',
                selectedUser: 'users/selectedUser',
            }),
            newcenter(){
                this.selectedUser()
                this.errors = [];
                this.state = 2
                this.$modal.show('userDataModal')
            }
        },
        mounted (){
            this.fetchUsers()
            this.fetchCenterList()
            Bus.$on('open-user-modal', (data)=> {
                this.selectedUser(data)
                this.errors = []
                this.state = 1
                this.$modal.show('userDataModal')
            })
            Bus.$on('close-usr-modal', ()=> {
                this.$modal.hide('userDataModal');
            })
            Bus.$on('new-usr-data', (data)=> {
                this.users.unshift(data)
            })
        }
    }
</script>