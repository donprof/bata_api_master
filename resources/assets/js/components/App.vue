<template>
    <main class="main" id="top">
        <div class="container">
            <leftmenu/>
            <allcontent/>
        </div>
    </main>
</template>
<script>
    import {mapGetters} from 'vuex'
    export default {
        computed: {
            ...mapGetters({
                user: 'auth/user'
            }),
            theme(){
                return this.filterByDay()
            }
        },
        methods: {
            filterByDay() {
                if (this.user.data != null) {
                     if (this.user.data.theme == 1) { 
                        return true
                    }else{
                        return false
                    }
                }
            },
        },
    }
</script>