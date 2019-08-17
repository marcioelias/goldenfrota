import SaidaEstoqueItemsComponent from './components/SaidaEstoqueItemsComponent.vue';

const leads = new Vue({
    el: '#saida_estoque_produtos',
    components:{
        SaidaEstoqueItemsComponent,
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