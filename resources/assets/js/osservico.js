import ordem_servico_servico from './components/OsServicoComponent.vue';
import ordem_servico_produto from './components/OsProdutoComponent.vue';

const os = new Vue({
    el: '#os_servicos',
    components:{
        ordem_servico_servico,
        ordem_servico_produto
    }
});
