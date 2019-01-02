let saida_estoque = require('./components/SaidaEstoqueItemsComponent.vue');

const leads = new Vue({
    el: '#saida_estoque_produtos',
    components:{
        'saida-estoque': saida_estoque,
    },
    data() {
        return {
            _estoqueId: null,
            get estoqueId() {
                return this._estoqueId;
            },
            set estoqueId(value) {
                this._estoqueId = value;
            },
        }
    }
});