import Vue from 'vue';
import moment from 'moment';
import DashboardComponent from './components/DashboardComponent.vue';

Vue.use(moment);

Vue.filter('formatDate', (value) => {
    if (value) {
        //moment.defaultFormat = 'YYYY-MM-DD HH:mm:ss'
        return moment(String(value), 'YYYY-MM-DD kk:mm:ss').format('DD/MM/YYYY')
    }
})

new Vue({
    el: '#dashboard',
    components: {
        'graphs': DashboardComponent,
    }
})