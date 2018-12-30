let estoque_produto = require('./components/EstoqueProdutoComponent.vue');

const leads = new Vue({
    el: '#estoqueProdutoComponent',
    components:{
        estoque_produto,
    }
});
