<template>
    <div class="content-box">
        <div class="pipelines-w">
            <div class="row parentrow">
                <div class="col-sm-4">
                    <div class="pipeline white lined-success">
                        <div class="pipeline-header">
                            <h5 class="pipeline-name">All Users</h5>
                            <div class="pipeline-settings os-dropdown-trigger">{{users.length}}</div>
                        </div>
                        <div class="pipeline-body">

                            <div class="support-index">
                                <div class="row">
                                    <div class="col-sm-6 mb-3" v-for="usr in users" :key="usr.id" @click="gettexts(usr)">
                                        <div class="support-ticket" :class="[usr.lable == active ? 'active' : '']">
                                            <div class="st-body">
                                                <div class="avatar ml-auto mr-auto">
                                                    <img :src="'assets/img/users/' + usr.avatar">
                                                </div>
                                            </div>
                                            <div class="st-foot">
                                                <div class="row">
                                                    <div class="col-sm-12 text-center">
                                                        <span class="value with-avatar">
                                                            <span>{{usr.names}}</span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-8">
                    <div class="pipeline white lined-success">
                        <div class="pipeline-body">
                            <div class="full-chat-w">
                                <div class="full-chat-i">
                                    <div class="full-chat-middle">
                                        <div class="chat-head">
                                            <div class="user-info">
                                                To: {{toFullname}}
                                            </div>
                                            <div class="user-actions">
                                                <span href="apps_full_chat.html#">
                                                    <i class="os-icon os-icon-mail-07"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="chat-content-w">
                                            <div class="chat-content">
                                                <div class="chat-message animated faster" v-for="sg in msg" :key="sg.id" :class="[sg.user_id == user.data.id ? 'self slideInLeft' : 'slideInRight']">
                                                    <div class="chat-message-content-w">
                                                        <div class="chat-message-content">{{sg.message}}</div>
                                                    </div>
                                                    <div v-if="sg.user_id == user.data.id" class="chat-message-date">{{sg.created_at | moment}}</div>
                                                    <div class="chat-message-avatar">
                                                        <img v-if="sg.user_id == user.data.id" :src="'assets/img/users/'+user.data.avatar">
                                                        <img v-else :src="'assets/img/users/'+recAvatar">
                                                    </div>
                                                    <div v-if="sg.user_id != user.data.id" class="chat-message-date">{{sg.created_at | moment}}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="chat-controls">
                                            <div class="chat-input-extra">
                                                <form @submit.prevent="submit">
                                                    <div class="chat-extra-actions">
                                                        <div class="chat-input">
                                                            <input v-model="message" placeholder="Type your message here..." type="text">
                                                        </div>
                                                    </div>
                                                    <div class="chat-btn">
                                                        <button type="submit" class="btn btn-primary btn-sm">Reply</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
import moment from 'moment'
import Bus from '../../../bus'
import { isEmpty } from 'lodash'
export default {
    data(){
        return{
            showChats: false,
            showUsers: false,
            isGettingMessage: false,
            isSending: false,
            active: null,
            recAvatar: null,
            toFullname: null,
            message: null,
            newResMsg: []
        }
    },
    filters: {
        moment: function(date) {
            return moment(date).fromNow()
        }
    },
    computed: {
        ...mapGetters({
            users: 'users/getUsersList',
            msg: 'messages/getMessage',
            user: 'auth/user'
        })
    },
    methods: {
        ...mapActions({
            fetchUsersList: 'users/fetchUsersList',
            getMessage: 'messages/getMessage',
            messageClear: 'messages/messageClear',
            newMessage: 'messages/newMessage',
        }),
        submit () {
            if (this.active == null || this.message == null) {
                var data = {'title': 'Warning.', 'bottomclass': 'darkerror', 'topclass': 'swalerror', 'swalicon': 'icon-exclamation', 'message': `Please select the user and type the message.`}
                Bus.$emit('show-message-swal', data)
                return;
            }
            this.isSending = true;
            this.errors = [];
            this.newMessage({
                payload: {
                    message: this.message,
                    to: this.active
                },
                context: this
            })
            .then(() => {
                this.isSending = false;
                if (isEmpty(this.errors)) {
                    this.msg.push(this.newResMsg)
                    this.message = null
                }
            })
        },
        gettexts(user){
            this.messageClear()
            this.isGettingMessage = true
            this.active = null
            this.recAvatar = null
            this.active = user.lable
            this.recAvatar = user.avatar
            this.toFullname = user.value
            this.getMessage({
                payload: {
                    id: user.lable,
                },
                context: this
            })
            .then(() => {
                this.isGettingMessage = false;
            })
        }
    },
     mounted (){
        this.fetchUsersList()
     }
}
</script>
<style scoped>
    .pipeline.white .pipeline-item{
        cursor: auto;
    }
    .support-index .st-body .avatar{
        padding-right: 0;
    }
    .support-index .st-body{
        padding: 10px;
    }
    .support-index{
        display: block;
    }
</style>
