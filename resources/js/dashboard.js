import DashboardComponent from './components/DashboardComponent.vue';

new Vue({
    el: '#dashboard',
    components: {
        'graphs': DashboardComponent,
    }
})