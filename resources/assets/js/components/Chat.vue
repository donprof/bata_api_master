<template>
    <div>
        <div class="floated-chat-btn">
            <i class="os-icon os-icon-mail-07"></i>
        </div>
        <div class="floated-chat-w">
            <div class="floated-chat-i">
                <div class="chat-close">
                    <i class="os-icon os-icon-close"></i>
                </div>
                <div class="chat-messages">
                    <!-- <div class="message">
                        <div class="message-content">Hi, how can I help you?</div>
                    </div>
                    <div class="date-break">Mon 10:20am</div>
                    <div class="message">
                        <div class="message-content">{{user}} Hi, my name is Mike, I will be happy to assist you</div>
                    </div>
                    <div class="message self">
                        <div class="message-content">Hi, I tried ordering this product and it keeps showing me error code.</div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {mapGetters} from 'vuex'
    export default {
        props:{
            user:{
                required: true,
                type: Object
            },
        },
    }
</script>