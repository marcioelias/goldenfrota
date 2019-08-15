<template>
    <div class="card">
        <div class="card-header">
            <strong>Produtos</strong>
        </div>
        <div class="card-body" style="padding: 0 !important;">
            <table class="table table-sm table-striped table-bordered table-hover" style="margin-bottom:0 !important;">
                <thead class="thead-light">
                    <tr class="row m-0">
                        <th class="col-md-1">Id</th>
                        <th class="col-md-5">Produto</th>
                        <th class="col-md-1">Qtd</th>
                        <th class="col-md-1">Vlr. Un.</th>
                        <th class="col-md-1">Vlr. Desc.</th>
                        <th class="col-md-1">Vlr. Acres.</th>
                        <th class="col-md-1">Total</th>
                        <th class="col-md-1">Ações</th>
                    </tr>
                </thead>
                <tbody name="fade" is="transition-group">
                    <tr class="row m-0" v-for="(item, index) in items" :key="index">
                        <td class="col-md-1 float-right">
                            {{ item.id }}
                            <input type="hidden" :name="'items['+index+'][produto_id]'" :value="item.id">
                        </td>
                        <td class="col-md-5">
                            {{ item.produto_descricao }}
                        </td>
                        <td class="col-md-1 text-right">
                            {{ item.quantidade | toDecimal3 }}
                            <input type="hidden" :name="'items['+index+'][quantidade]'" :value="item.quantidade">    
                        </td>
                        <td class="col-md-1 text-right">
                            {{ item.valor_unitario | toDecimal3 }}
                            <input type="hidden" :name="'items['+index+'][valor_unitario]'" :value="item.valor_unitario">    
                        </td>
                        <td class="col-md-1 text-right">
                            {{ item.valor_desconto | toDecimal3 }}
                            <input type="hidden" :name="'items['+index+'][valor_desconto]'" :value="item.valor_desconto">    
                        </td>
                        <td class="col-md-1 text-right">
                            {{ item.valor_acrescimo | toDecimal3 }}
                            <input type="hidden" :name="'items['+index+'][valor_acrescimo]'" :value="item.valor_acrescimo">    
                        </td>
                        <td class="col-md-1 text-right">
                            {{ item.valor_total_item | toDecimal3 }}                            
                        </td>
                        <td class="col-md-1">
                            <button type="button" class="btn btn-sm btn-warning" @click="editItem(index)" v-show="!editing">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" @click="confirmDelete(index)" data-toggle="modal" data-target="#confirmDelete" v-show="!editing">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
                <tfoot v-if="this.items.length > 0">
                    <tr class="row m-0">
                        <td class="col-md-1"><strong>{{ this.items.length }}</strong></td>
                        <td class="col-md-5"></td>
                        <td class="col-md-1 text-right"><strong>{{ this.totalQuantidade() | toDecimal3 }}</strong></td>
                        <td class="col-md-1 text-right"><strong>{{ this.totalValor() | toDecimal3 }}</strong></td>
                        <td class="col-md-1 text-right"><strong>{{ this.totalDesconto() | toDecimal3 }}</strong></td>
                        <td class="col-md-1 text-right"><strong>{{ this.totalAcrescimo() | toDecimal3 }}</strong></td>
                        <td class="col-md-1 text-right"><strong>{{ this.totalItem() | toDecimal3 }}</strong></td>
                        <td class="col-md-1"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div>
            <div class="row m-0">
                <input type="hidden" name="valor_total" v-model="valor_total">
                <div v-bind:class="{'col-md-6': true, ' has-error': this.errors.inputProdutos}" style="padding-right: 0 !important; padding-left: 0 !important;">
                    <select ref="inputProdutos" data-style="btn-secondary" v-model="produto_id" data-live-search="true" class="form-control selectpicker" name="inputProdutos" id="inputProdutos">
                        <option selected value="false"> Nada Selecionado </option>
                        <option v-for="(produto, index) in produtosDisponiveisOrdenados" :value="produto.id" :key="index">{{ produto.id + ' - ' + produto.produto_descricao }}</option>
                    </select>
                     <span class="help-block" :v-if="this.errors.inputProdutos">
                        <strong>{{ this.errors.inputProdutosMsg }}</strong>
                    </span>
                </div>
                <div v-bind:class="{'col-md-1': true, ' has-error': this.errors.inputQuantidade}" style="padding-right: 0 !important; padding-left: 0 !important;">
                    <input type="number" min="0,000" max="9999999999,999" step="any" ref="inputQuantidade" v-model.number="quantidade" class="form-control" name="inputQuantidade" id="inputQuantidade">
                    <span class="help-block" :v-if="this.errors.inputQuantidade">
                        <strong>{{ this.errors.inputQuantidadeMsg }}</strong>
                    </span>
                </div>
                <div v-bind:class="{'col-md-1': true, ' has-error': this.errors.inputValorUnitario}" style="padding-right: 0 !important; padding-left: 0 !important;">
                    <input type="number" min="0,000" max="9999999999,999" step="any" ref="inputValorUnitario" v-model.number="valorUnitario" class="form-control" name="inputValorUnitario" id="inputValorUnitario">
                    <span class="help-block" :v-if="this.errors.inputValorUnitario">
                        <strong>{{ this.errors.inputValorUnitarioMsg }}</strong>
                    </span>
                </div>
                <div v-bind:class="{'col-md-1': true, ' has-error': this.errors.inputDesconto}" style="padding-right: 0 !important; padding-left: 0 !important;">
                    <input type="number" min="0,000" max="9999999999,999" step="any" ref="inputDesconto" v-model.number="desconto" class="form-control" name="inputDesconto" id="inputDesconto">
                    <span class="help-block" :v-if="this.errors.inputDesconto">
                        <strong>{{ this.errors.inputDescontoMsg }}</strong>
                    </span>
                </div>
                <div v-bind:class="{'col-md-1': true, ' has-error': this.errors.inputAcrescimo}" style="padding-right: 0 !important; padding-left: 0 !important;">
                    <input type="number" min="0,000" max="9999999999,999" step="any" ref="inputAcrescimo" v-model.number="acrescimo" class="form-control" name="inputAcrescimo" id="inputAcrescimo">
                    <span class="help-block" :v-if="this.errors.inputAcrescimo">
                        <strong>{{ this.errors.inputAcrescimoMsg }}</strong>
                    </span>
                </div>
                <div class="col-md-1" style="padding-right: 0 !important; padding-left: 0 !important;">
                    <input type="number" min="0,000" max="9999999999,999" step="any" ref="inputTotalItem" v-model.number="valorTotalItem" class="form-control" name="inputTotalItem" id="inputTotalItem" readonly>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-success" @click="addProduto" v-show="!editing">
                        <i class="fas fa-plus"></i>
                    </button>
                    <button type="button" class="btn btn-success" @click="updateProduto" v-show="editing">
                        <i class="fas fa-check"></i>
                    </button>
                </div>
            </div>
        </div>
        <modal @cancel="cancelDelete" @confirm="deleteItem" :modal-title="'Corfirmação'" :modal-text="'Confirma a remoção deste Item?'" />
    </div>
</template>

<script>
    import modal from './modal.vue';

    export default {
        name: 'entrada_estoque',
        components: {
            modal
        },
        data() {
            return {
                editing: false,
                editingIndex: false,
                items: [],
                produto_id: false,
                quantidade: 1,
                valorUnitario: 0,
                desconto: 0,
                acrescimo: 0,
                isModalVisible: false,
                deleteIndex: false,
                produtosDisponiveis: [],
                produtosSelecionados: [],
                _valorTotalItem: 0,
                get valorTotalItem() {
                    return ((this.valorUnitario-this.desconto)+this.acrescimo)*this.quantidade;
                },
                set valorTotalItem(value) {
                    this._valorTotalItem = value;
                },
                errors: {
                    inputProdutos: false,
                    inputProdutosMsg: '',
                    inputQuantidade: false,
                    inputQuantidadeMsg: '',
                    inputValorUnitario: false,
                    inputValorUnitariodeMsg: '',
                    inputDesconto: false,
                    inputDescontoMsg: '',
                    inputAcrescimo: false,
                    inputAcrescimoMsg: ''
                }
            }
        },
        props: [
            'produtosData',
            'oldData'
        ],
        watch: {
            oldData: function() {
               this.$refs.confirmDelete
            }
        },
        computed: {
            produtosDisponiveisOrdenados: function() {
                function compare(a, b) {
                    if (a.produto_descricao < b.produto_descricao)
                    return -1;
                    if (a.produto_descricao > b.produto_descricao)
                    return 1;
                    return 0;
                }

                return this.produtosDisponiveis.sort(compare);
            },
            valor_total: {
                get() {
                    let total = 0;
                    for (var i = 0; i < this.items.length; i++) {
                        total += this.items[i].quantidade * this.items[i].valor_unitario;
                    }
                    return total;
                }
            },
        },
        mounted() {
            this.produtosDisponiveis = this.produtosData;
            if (this.oldData !== null) {
                for (var i=0; i<this.oldData.length; i++) {  
                    this.items.push({
                        'id': this.oldData[i].produto_id,
                        'produto_descricao': this.getProdutoById(this.oldData[i].produto_id).produto_descricao,
                        'quantidade': Number(this.oldData[i].quantidade),
                        'valor_unitario': Number(this.oldData[i].valor_unitario),
                        'valor_desconto': Number(this.oldData[i].valor_desconto),
                        'valor_acrescimo': Number(this.oldData[i].valor_acrescimo),
                        'valor_total_item': ((Number(this.oldData[i].valor_unitario)-Number(this.oldData[i].valor_desconto))+Number(this.oldData[i].valor_acrescimo))*Number(this.oldData[i].quantidade)
                    });
                    this.incluirProduto(this.oldData[i].produto_id);
                }
            }
        },
        updated() {
            $(this.$refs.inputProdutos).selectpicker('refresh');
        },
        methods: {
            validarItem() {
                if ((this.produto_id == '') || (this.produto_id <= 0)) {
                    this.errors.inputProdutos = true;
                    this.errors.inputProdutosMsg = 'Nenhum Produto selecionado.';
                    return false;
                } else {
                    this.errors.inputProdutos = false;
                    this.errors.inputProdutosMsg = '';
                }
                
                if ((this.quantidade == '') || (this.quantidade <= 0)) {
                    this.errors.inputQuantidade = true;
                    this.errors.inputQuantidadeMsg = 'Informe a quantidade do produto.';
                    return false;
                } else {
                    this.errors.inputQuantidade = false;
                    this.errors.inputQuantidadeMsg = '';
                }

                if ((this.valorUnitario == '') || (this.valorUnitario <= 0)) {
                    this.errors.inputValorUnitario = true;
                    this.errors.inputValorUnitarioMsg = 'Informe o Valor Unitário do produto.';
                    return false;
                } else {
                    this.errors.inputValorUnitario = false;
                    this.errors.inputValorUnitarioMsg = '';
                }

                /* if ((this.desconto == '') || (this.desconto < 0)) {
                    this.errors.inputDesconto = true;
                    this.errors.inputDescontoMsg = 'Informe o Valor de Desconto.';
                    return false;
                } else {
                    this.errors.inputDesconto = false;
                    this.errors.inputDescontoMsg = '';
                }

                if ((this.acrescimo == '') || (this.acrescimo < 0)) {
                    this.errors.inputAcrescimo = true;
                    this.errors.inputAcrescimoMsg = 'Informe o Valor de Acréscimo.';
                    return false;
                } else {
                    this.errors.inputAcrescimo = false;
                    this.errors.inputAcrescimoMsg = '';
                } */
                return true;
            },
            confirmDelete(index) {
                this.deleteIndex = index;
            },
            cancelDelete(index) {
                this.deleteIndex = false;
            },
            addProduto() {
                if (this.validarItem()) {
                    this.items.push({
                        'id': this.produto_id,
                        'produto_descricao': this.getProdutoById(this.produto_id).produto_descricao,
                        'quantidade': this.quantidade,
                        'valor_unitario': this.valorUnitario,
                        'valor_desconto': this.desconto,
                        'valor_acrescimo': this.acrescimo,
                        'valor_total_item': this.valorTotalItem
                    });
                    this.incluirProduto(this.produto_id);
                    this.limparFormulario();
                }
            },
            editItem(index) {
                let item = this.items[index];
                this.quantidade = item.quantidade;
                this.valorUnitario = item.valor_unitario;
                this.desconto = item.valor_desconto;
                this.acrescimo = item.valor_acrescimo;
                this.valorTotalItem = item.valor_total_item;
                this.produto_id = item.id;
                this.editing = true;
                this.editingIndex = index;
                this.produtosDisponiveis.push(item);
            },
            updateProduto() {
                this.items[this.editingIndex] = {
                    'id': this.produto_id,
                    'produto_descricao': this.getProdutoById(this.produto_id).produto_descricao,
                    'quantidade': this.quantidade,
                    'valor_unitario': this.valorUnitario,
                    'valor_desconto': this.desconto,
                    'valor_acrescimo': this.acrescimo,
                    'valor_total_item': this.valorTotalItem
                };

                this.editing = false;
                this.editingIndex = false;
                this.limparFormulario();
                this.$delete(this.produtosDisponiveis, this.getProdutoIndexById(this.produto_id));
            },
            deleteItem() {
                this.removerProduto(this.items[this.deleteIndex].id);
                this.$delete(this.items, this.deleteIndex);
            },
            limparFormulario() {
                this.produto_id = false;
                this.produtoSelecionado = false;
                this.quantidade = 1;
                this.valorUnitario = 0;
                this.desconto = 0;
                this.acrescimo = 0;
                this.$refs.inputProdutos.focus();
            },
            totalQuantidade() {
                let result = 0;
                for (var i=0; i<this.items.length; i++) {  
                    result += this.items[i].quantidade;
                }
                return result;
            },
            totalValor() {
                let result = 0;
                for (var i=0; i<this.items.length; i++) {  
                    result += this.items[i].valor_unitario;
                }
                return result;
            },
            totalDesconto() {
                let result = 0;
                for (var i=0; i<this.items.length; i++) {  
                    result += this.items[i].valor_desconto;
                }
                return result;
            },
            totalAcrescimo() {
                let result = 0;
                for (var i=0; i<this.items.length; i++) {  
                    result += this.items[i].valor_acrescimo;
                }
                return result;
            },
            totalItem() {
                let result = 0;
                for (var i=0; i<this.items.length; i++) {  
                    result += this.items[i].valor_total_item;
                }
                return result;
            },
            getProdutoById(id) {
                let result = 0;
                for (var i=0; i<this.produtosData.length; i++) {  
                    if (this.produtosData[i].id == id) {
                        result = this.produtosData[i];
                        break;
                    } 
                }
                return result;
            },
            getProdutoIndexById(id) {
                let result = 0;
                for (var i=0; i<this.produtosData.length; i++) {  
                    if (this.produtosData[i].id == id) {
                        result = i;
                        break;
                    } 
                }
                return result;
            },
            getProdutoSelecionadoById(id) {
                let result = 0;
                for (var i=0; i<this.produtosSelecionados.length; i++) {  
                    if (this.produtosSelecionados[i].id == id) {
                        result = this.produtosSelecionados[i];
                        break;
                    } 
                }
                return result;
            },
            getProdutoSelecionadoIndexById(id) {
                let result = 0;
                for (var i=0; i<this.produtosSelecionados.length; i++) {  
                    if (this.produtosSelecionados[i].id == id) {
                        result = i;
                        break;
                    } 
                }
                return result;
            },
            incluirProduto(id) {
                this.produtosSelecionados.push(this.getProdutoById(id));
                this.$delete(this.produtosDisponiveis, this.getProdutoIndexById(id));
            },
            removerProduto(id) {
                this.produtosDisponiveis.push(this.getProdutoSelecionadoById(id));
                this.$delete(this.produtosSelecionados, this.getProdutoSelecionadoIndexById(id));
            }
        }
    }
</script>