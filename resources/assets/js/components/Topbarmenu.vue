<template>
    <nav :class="[user.authenticated == true ? '' : 'hider']" class="navbar navbar-light navbar-glass fs--1 font-weight-semi-bold row navbar-top sticky-kit navbar-expand">
        <button
        class="navbar-toggler collapsed"
        type="button"
        data-toggle="collapse"
        data-target="#navbarVerticalCollapse"
        aria-controls="navbarVerticalCollapse"
        aria-expanded="false"
        aria-label="Toggle navigation"
        >
        <span class="navbar-toggler-icon"></span>
        </button>
        <!-- <router-link to="/" class="avbar-brand text-left ml-3">
            Hello, {{user.data.name}}
        </router-link> -->
        <div class="collapse navbar-collapse" id="navbarNavDropdown1">
            <!-- <ul class="navbar-nav align-items-center d-none d-lg-block">
                <li class="nav-item">
                  <form class="form-inline search-box">
                        <input class="form-control rounded-pill search-input" type="search" placeholder="Search..." aria-label="Search">
                  </form>
                </li>
            </ul> -->
            <!-- {{user.data}} -->
            <ul class="navbar-nav align-items-center ml-auto" v-if="user.data">
                <li class="nav-item dropdown">
                    <a class="nav-link pr-0" id="navbarDropdownUser" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="avatar avatar-xl">
                            <img v-if="user.data.avatar != null" class="rounded-circle" :src="user.data.imagelink+'users/'+user.data.avatar" :alt="user.data.name">
                            <img v-else class="rounded-circle" src="/assets/img/team/3.jpg" alt>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right py-0" aria-labelledby="navbarDropdownUser">
                        <div class="bg-white rounded-soft py-2">
                            <a class="dropdown-item" href="#!">Hi, {{user.data.name}}</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Account settings</a>
                            <a @click.prevent="signout" class="dropdown-item" href="javascript:void(0);">Logout</a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
export default {
computed: {
    ...mapGetters({
        user: "auth/user"
    }),
},
methods: {
    ...mapActions({
        logout: "auth/logout"
    }),
    signout() {
        this.logout({
            payload: {
                id: this.user.data.id
                // center: this.user.data.costcenter
            }
        }).then(() => {
            this.$router.replace({ name: "login" });
        });
    },
    filterByDay() {
        if (this.user.data != null) {
            if (this.user.data.theme == 1) {
            return true;
            } else {
            return false;
            }
        }
    }
}
};
</script>
<style scoped>
    .top-bar .top-menu-controls .element-search input {
        padding: 4px 4px 4px 40px;
    }
</style>
