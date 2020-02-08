<template>
    <div class="col-6 col-md-4 col-lg-3 col-xxl-2 mb-1">
        <div class="p-3 h-100">
            <span @click="editaction(user)">
                <img v-if="user.avatar" class="img-thumbnail img-fluid rounded-circle mb-3 shadow-sm" :src="user.imagelink+'users/'+user.avatar" alt="" width="100">
                <img v-else class="img-thumbnail img-fluid rounded-circle mb-3 shadow-sm" src="/assets/img/team/2.jpg" alt="" width="100">
            </span>
            <h6 class="mb-1"><a href="#">{{user.name}}</a></h6>
            <p class="fs--2 mb-1"><a class="text-700" href="#!">{{user.email}}</a></p>
        </div>
    </div>
    <!-- <div class="pipeline-item animated bounceIn faster">
        <div class="pi-controls">
            <div :class="[user.accountstatus == 1 ? 'status-green' : 'status-red']" class="status" data-placement="top" data-toggle="tooltip"
                title="Account Inactive"></div>
        </div>
        <div class="pi-body">
            <div class="avatar">
                <img v-if="user.avatar != null" :src="'assets/img/users/' + user.avatar">
            </div>
            <div class="pi-info">
                <div class="h6 pi-name">{{user.full_name}}</div>
                <div class="pi-sub">{{user.role}}</div>
            </div>
        </div>
        <div class="pi-foot">
            <div class="tags">
                <span v-if="user.accountstatus == 1" @click="accountaction(user)" class="point tag text-danger">Suspend</span>
                <span v-else @click="accountaction(user)" class="point tag text-success">Activate</span>
                <span @click="editaction(user)" class="point tag text-success">Edit</span>
            </div>
            <a class="extra-info">
                <span>{{user.created_at | moment}}</span>
            </a>
        </div>
    </div> -->
</template>
<script>
    import {mapActions} from 'vuex'
    import Bus from '../../../bus'
    import moment from 'moment'
    import isEmpty from 'lodash'
    export default {
        data(){
            return{
                isChanging: false,
                errors: [],
                updateuser:[]
            }
        },
        props:{
            user:{
                required: true,
                type: Object
            },
        },
        filters: {
            moment: function(date) {
                return moment(date).format('DD MMM YYYY');
            }
        },
        methods:{
            ...mapActions({
                changestatus: 'users/changestatus'
            }),
            editaction(user){
                Bus.$emit('open-user-modal', user)
            },
            accountaction(usr){
                this.isChanging = true;
                this.errors = [];
                this.changestatus({
                    payload: {
                        id: usr.id,
                        status: usr.accountstatus
                    },
                    context: this
                }).then(() => {
                    this.isChanging = false;
                    if (isEmpty(this.errors)) {
                        usr.accountstatus = this.updateuser.accountstatus
                        if (this.updateuser.accountstatus == 1) {
                            var data = {'title': 'Activated.', 'bottomclass': 'darkerror', 'topclass': 'swalsuccess', 'swalicon': 'icon-like', 'message': `${usr.full_name}'s account activated !`}
                        }else{
                            var data = {'title': 'Deacticated.', 'bottomclass': 'darkerror', 'topclass': 'swalerror', 'swalicon': 'icon-exclamation', 'message': `${usr.full_name}'s account deactivated !`}
                        }
                        Bus.$emit('show-message-swal', data)
                    }
                })
            }
        }
    }
</script>