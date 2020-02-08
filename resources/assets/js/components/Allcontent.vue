<template>
    <div :class="[user.authenticated == true ? 'content' : 'container-fluid']">
        <topbarmenu></topbarmenu>
        <div class="content">
            <router-view></router-view>
        </div>
        <modal name="swalMessageModal" classes="" :clickToClose="false" height="auto" :adaptive="true" :pivotY="0.2">
            <swal-message-modal
                :title="swalmodaltitle"
                :message="swalmodalmessage"
                :swaltopclass="swalTopclass"
                :swalbottomclass="swalBottomclass"
                :swalicon="swalicon"
            ></swal-message-modal>
        </modal>
        <modal @before-open="beforeOpen" name="qm" classes="" :clickToClose="false" height="auto" :adaptive="true" :pivotY="0.2">
            <qm :qsdata="qsdata"></qm>
        </modal>
        <modal @before-open="bookingOpen" :scrollable="true" name="bookingModal" classes="animated bounceInDown faster" :clickToClose="true" height="auto" :adaptive="true" :pivotY="0.2">
            <bkModal :bkdata="bkdata"></bkModal>
        </modal>
    </div>
</template>

<script>
import Bus from '../bus'
import {mapGetters} from 'vuex'
export default {
    data(){
        return{
            swalmodaltitle: null,
            swalmodalmessage: null,
            swalTopclass: null,
            swalBottomclass: null,
            swalicon: null,
            qsdata: null,
            bkdata: null,
        }
    },
    computed: {
        ...mapGetters({
            user: 'auth/user'
        }),
    },
    methods: {
        beforeOpen(event) {
            this.qsdata = event.params
        },
        bookingOpen(event) {
            this.bkdata = event.params
        }
    },
    mounted (){
        Bus.$on('show-message-swal', (data)=> {
            this.swalmodaltitle = data.title
            this.swalmodalmessage = data.message
            this.swalTopclass = data.topclass
            this.swalBottomclass = data.bottomclass
            this.swalicon = data.swalicon
            this.$modal.show('swalMessageModal');
        })
        Bus.$on('close-message-swal', ()=> {
            this.$modal.hide('swalMessageModal');
        })
        Bus.$on('trigger-close', ()=> {
            this.$modal.hide('qm');
        })
    }
}
</script>