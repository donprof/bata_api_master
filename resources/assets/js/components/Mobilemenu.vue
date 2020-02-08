<template>
    <div class="menu-mobile menu-activated-on-hover color-scheme-light" :class="[user.authenticated == true ? '' : 'hider']">
        <div class="mm-logo-buttons-w">
            <router-link class="mm-logo" to="/">
                <img src="assets/img/logo.png">
                <span>Fleetwise</span>
            </router-link>
            <div class="mm-buttons">
                <div class="mobile-menu-trigger">
                    <div class="os-icon os-icon-hamburger-menu-1"></div>
                </div>
            </div>
        </div>
        <div class="menu-and-user">
            <ul class="main-menu">
                <!-- Dashboard -->
                <li class="sub-menu">
                    <router-link to="/dashboard">
                        <span class="hidden">Dashboard Listing</span>
                        <div class="icon-w">
                            <div class="icon-screen-desktop"></div>
                        </div>
                        <span>Dashboard</span>
                    </router-link>
                </li>
                <!-- Assets -->
                <li class="has-sub-menu">
                    <a href="javascript:void(0);">
                        <div class="icon-w">
                            <div class="icon-plane"></div>
                        </div>
                        <span>Assets</span>
                    </a>
                    <ul class="sub-menu">
                        <li><router-link to="/vehicles">Vehicle <strong class="badge badge-danger">3</strong></router-link></li>
                        <li><router-link to="/makes">Makes</router-link></li>
                        <li><router-link to="/models">Models</router-link></li>
                        <li><router-link to="/bodytypes">Body types</router-link></li>
                        <li><router-link to="/vehicletype">Vehicle types</router-link></li>
                        <li><router-link to="/departments">Departments</router-link></li>
                        <li><router-link to="/bases">Base</router-link></li>
                        <li><router-link to="/badges">Badges</router-link></li>
                        <li><router-link to="/costcenters">Cost center</router-link></li>
                        <li><router-link to="/planner">Work order</router-link></li>
                        <li><router-link to="/vehicle-reports">Asset reports</router-link></li>
                    </ul>
                </li>
                <!-- Pool -->
                <li class="has-sub-menu">
                    <a href="javascript:void(0);">
                        <div class="icon-w">
                            <div class="icon-calendar"></div>
                        </div>
                        <span>Pool</span>
                    </a>
                    <ul class="sub-menu">
                        <li><router-link to="/bookings">Booking <strong class="badge badge-danger">5</strong></router-link></li>
                        <li><router-link to="/planner">Booking planner</router-link></li>
                        <li><router-link to="/returns">Return</router-link></li>
                        <li><router-link to="/contracted">Contracted vehicles</router-link></li>
                        <li><router-link to="/claims">Claims</router-link></li>
                        <li><router-link to="/pool-reports">Pool reports</router-link></li>
                    </ul>
                </li>
                <!-- Costing -->
                <li class="has-sub-menu">
                    <a href="javascript:void(0);">
                        <div class="icon-w">
                            <div class="icon-refresh"></div>
                        </div>
                        <span>Costing</span>
                    </a>
                    <ul class="sub-menu">
                        <li><router-link to="/vehicle-costing">Liters by vehicles</router-link></li>
                        <li><router-link to="/department-costing">Liters by departments</router-link></li>
                        <li><router-link to="/centers-costing">Liters by centers</router-link></li>
                        <li><router-link to="/distance-costing">Distance covered</router-link></li>
                        <li><router-link to="/costing-reports">Costing reports</router-link></li>
                    </ul>
                </li>
                <!-- Fuel issuance -->
                <li class="has-sub-menu">
                    <a href="javascript:void(0);">
                        <div class="icon-w">
                            <div class="icon-drop"></div>
                        </div>
                        <span>Fuel transactions</span>
                    </a>
                    <ul class="sub-menu">
                        <li><router-link to="/allissuance">Fuel Issuance</router-link></li>
                        <li><router-link to="/fuel-types">Fuel Types</router-link></li>
                        <li><router-link to="/locations">Locations</router-link></li>
                        <li><router-link to="/tank-header">Tanks Transaction</router-link></li>
                        <li><router-link to="/tankslevels">Tanks level</router-link></li>
                        <li><router-link to="/fuel-reports">Fuel Reports</router-link></li>
                    </ul>
                </li>
                <!-- Assets repair -->
                <li class="has-sub-menu">
                    <a href="javascript:void(0);">
                        <div class="icon-w">
                            <div class="icon-wrench"></div>
                        </div>
                        <span>Asset repairs</span>
                    </a>
                    <ul class="sub-menu">
                        <li><router-link to="/jobcards">Job Cards</router-link></li>
                        <li><router-link to="/planner">Spare To Other Center</router-link></li>
                        <li><router-link to="/planner">Task Planner <strong class="badge badge-danger">3</strong></router-link></li>
                        <li><router-link to="/planner">Done Task</router-link></li>
                        <li><router-link to="/taskcodes">Task Code</router-link></li>
                        <li><router-link to="/servicetypes">Service Types</router-link></li>
                        <li><router-link to="/maintenancetypes">Maintenance Category</router-link></li>
                        <li><router-link to="/vendors">Vendor</router-link></li>
                        <li><router-link to="/mechanics">Mechanics</router-link></li>
                        <li><router-link to="/maintenance-reports">Maintenance Reports</router-link></li>
                    </ul>
                </li>
                <!-- Workshop -->
                <li class="has-sub-menu">
                    <a href="javascript:void(0);">
                        <div class="icon-w">
                            <div class="icon-layers"></div>
                        </div>
                        <span>Inventory</span>
                    </a>
                    <ul class="sub-menu">
                        <li><router-link to="/items">Items</router-link></li>
                        <li><router-link to="/orders">Items recieving</router-link></li>
                        <li><router-link to="/itemsreturn">Items return</router-link></li>
                        <li><router-link to="/itemscategory">Items category</router-link></li>
                        <li><router-link to="/suppliers">Suppliers</router-link></li>
                        <li><router-link to="/inventory-reports">Inventory reports</router-link></li>
                    </ul>
                </li>

                <!-- Drivers -->
                <li class="has-sub-menu">
                    <a href="javascript:void(0);">
                        <div class="icon-w">
                            <div class="icon-people"></div>
                        </div>
                        <span>Drivers</span>
                    </a>
                    <ul class="sub-menu">
                        <li><router-link to="/drivers">Drivers records <strong class="badge badge-danger">12</strong></router-link></li>
                        <li><router-link to="/violations">Violations</router-link></li>
                        <li><router-link to="/drivers-reports">Drivers Reports</router-link></li>
                    </ul>
                </li>

                <!-- Accidents -->
                <li class="has-sub-menu">
                    <a href="javascript:void(0);">
                        <div class="icon-w">
                            <div class="icon-fire"></div>
                        </div>
                        <span>Leave</span>
                    </a>
                    <ul class="sub-menu">
                        <li><router-link to="/leave-request">Leave request</router-link></li>
                        <li><router-link to="/leavetype">Leave type</router-link></li>
                        <!-- <li><router-link to="/planner">Staff</router-link></li> -->
                        <li><router-link to="/leave-annalysis">Leave analyses</router-link></li>
                        <li><router-link to="/planner">Leave Reports</router-link></li>
                    </ul>
                </li>

                <!-- Accidents -->
                <li class="has-sub-menu">
                    <a href="javascript:void(0);">
                        <div class="icon-w">
                            <div class="icon-fire"></div>
                        </div>
                        <span>Accidents</span>
                    </a>
                    <ul class="sub-menu">
                        <li><router-link to="/accidents">Accident records</router-link></li>
                        <li><router-link to="/accidents-reports">Accident reports</router-link></li>
                    </ul>
                </li>

                <!-- Trips -->
                <li class="has-sub-menu">
                    <a href="javascript:void(0);">
                        <div class="icon-w">
                            <div class="icon-location-pin"></div>
                        </div>
                        <span>Trips</span>
                    </a>
                    <ul class="sub-menu">
                        <li><router-link to="/planner">Trips & loads</router-link></li>
                        <li><router-link to="/planner">Trip type</router-link></li>
                        <li><router-link to="/planner">Cargo type</router-link></li>
                        <li><router-link to="/planner">Consignee</router-link></li>
                        <li><router-link to="/planner">External trip</router-link></li>
                        <li><router-link to="/trips-reports">Trips Report</router-link></li>
                    </ul>
                </li>

                <!-- Messages -->
                <li class="sub-menu">
                    <router-link to="/messages">
                        <span class="hidden">Messages</span>
                        <div class="icon-w">
                            <div class="icon-bubble"></div>
                        </div>
                        <span>Messages</span>
                    </router-link>
                </li>

                <!-- Messages -->
                <li class="sub-menu">
                    <router-link to="/messages">
                        <span class="hidden">Trash</span>
                        <div class="icon-w">
                            <div class="icon-trash"></div>
                        </div>
                        <span>Trash</span>
                    </router-link>
                </li>

                <!-- Utilities -->
                <li class="has-sub-menu">
                    <a href="javascript:void(0);">
                        <div class="icon-w">
                            <div class="icon-settings"></div>
                        </div>
                        <span>Utilities</span>
                    </a>
                    <ul class="sub-menu">
                        <li><router-link to="/users">Users</router-link></li>
                        <li><router-link to="/integration">Integration</router-link></li>
                        <li><router-link to="/logs">Audit log</router-link></li>
                        <li><router-link to="/fuel-report-settings">Fuel reports settings</router-link></li>
                        <li><router-link to="/maintenance-report-settings">Maintenance reports settings</router-link></li>
                        <li><router-link to="/pool-report-settings">Pool reports settings</router-link></li>
                        <li><router-link to="/costing-report-settings">Costing reports settings</router-link></li>
                        <li><router-link to="/inventory-report-settings">Inventory reports settings</router-link></li>
                        <li><router-link to="/driver-report-settings">Driver reports settings</router-link></li>
                        <li><router-link to="/accidents-report-settings">Accident reports settings</router-link></li>
                        <li><router-link to="/trips-report-settings">Trip reports settings</router-link></li>
                        <li><router-link to="/maintenance-report-settings">Leave reports settings</router-link></li>
                        <li><router-link to="/maintenance-report-settings">Auditlog report settings</router-link></li>
                    </ul>
                </li>
                
            </ul>
        </div>
    </div>
</template>
<script>
    import {mapGetters} from 'vuex'
    export default {
        computed: mapGetters({
            user: 'auth/user'
        }),
    }
</script>