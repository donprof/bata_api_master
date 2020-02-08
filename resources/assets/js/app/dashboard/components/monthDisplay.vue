<template>
    <span>
        {{ dateDisplay }}
    </span>
</template>

<script>
import moment from 'moment'
export default {
    props: [ 'fuelmonth' ],
    computed: {

        dateDisplay(){
            var d, display, start, end, month, year

            d = this.fuelmonth

            start = d.startOf('isoWeek').format('MMM DD')
            end = d.endOf('isoWeek').format('MMM DD')
            month = d.format('MMMM')
            year = d.format('YYYY')

            display = month + ", " + year

            return display
        }

    }
}
</script>
