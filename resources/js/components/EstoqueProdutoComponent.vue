<template>
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>Estoques</strong>
        </div>
        <div class="panel-body" style="padding: 0 !important;">
            <table class="table table-sm table-striped table-bordered table-hover" style="margin-bottom:0 !important;">
                <thead class="thead-light">
                    <tr class="primary">
                        <th class="col-md-1">Id</th>
                        <th class="col-md-7">Estoque</th>
                        <th class="col-md-2">Est. Mínimo</th>
                        <th class="col-md-1">Ações</th>
                    </tr>
                </thead>
                <tbody name="fade" is="transition-group">
                    <tr class="rom m-0" v-for="(item, index) in estoques" :key="index">
                        <td class="col-md-1 pool-right">
                            {{ item.id }}
                            <input type="hidden" :name="'estoques['+index+'][estoque_id]'" :value="item.id">
                        </td>
                        <td class="col-md-8">
                            {{ item.estoque }}
                        </td>
                        <td class="col-md-2 text-right">
                            {{ item.estoque_minimo }}
                            <input type="hidden" :name="'estoques['+index+'][estoque_minimo]'" :value="item.estoque_minimo">    
                        </td>
                        <td class="col-md-1">
                            <button type="button" class="btn-xs btn-warning" @click="editItem(index)" v-show="!editing">
                                <span class="glyphicon glyphicon-edit"></span>
                            </button>
                            <button type="button" class="btn-xs btn-danger" @click="confirmDelete(index)" data-toggle="modal" data-target="#confirmDelete" v-show="!editing">
                                <span class="glyphicon glyphicon-trash"></span>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div>
            <div class="row m-0">
                <div v-bind:class="{'col-md-9': true, ' has-error': this.errors.inputEstoques}" style="padding-right: 0 !important; padding-left: 0 !important;">
                    <select ref="inputEstoques" v-model="estoque_id" data-live-search="true" class="form-control selectpicker" name="inputEstoques" id="inputEstoques">
                        <option selected value="false"> Nada Selecionado </option>
                        <option v-for="(estoque, index) in estoquesDisponiveisOrdenados" :value="estoque.id" :key="index">{{ estoque.estoque }}</option>
                    </select>
                     <span class="help-block" :v-if="this.errors.inputEstoques">
                        <strong>{{ this.errors.inputEstoquesMsg }}</strong>
                    </span>
                </div>
                <div v-bind:class="{'col-md-2': true, ' has-error': this.errors.inputEstoqueMinimo}" style="padding-right: 0 !important; padding-left: 0 !important;">
                    <input type="number" min="0,000" max="9999999999,999" step="any" ref="inputEstoqueMinimo" v-model.number="estoque_minimo" class="form-control" name="inputEstoqueMinimo" id="inputEstoqueMinimo">
                    <span class="help-block" :v-if="this.errors.inputEstoqueMinimo">
                        <strong>{{ this.errors.inputEstoqueMinimoMsg }}</strong>
                    </span>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-success" @click="addEstoque" v-show="!editing">
                        <span class="glyphicon glyphicon-plus"></span>
                    </button>
                    <button type="button" class="btn btn-success" @click="updateEstoque" v-show="editing">
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
        name: 'estoque_produto',
        components: {
            modal
        },
        data() {
            return {
                editing: false,
                editingIndex: false,
                estoque_id: false,
                estoque_minimo: 0,
                estoques: [],
                isModalVisible: false,
                deleteIndex: false,
                estoquesDisponiveis: [],
                estoquesSelecionados: [],
                errors: {
                    inputEstoques: false,
                    inputEstoquesMsg: '',
                    inputEstoqueMinimo: false,
                    inputEstoqueMinimoMsg: '',
                }
            }
        },
        props: [
            'estoquesData',
            'oldData'
        ],
        watch: {
            oldData: function() {
               this.$refs.confirmDelete
            }
        },
        computed: {
            estoquesDisponiveisOrdenados: function() {
                function compare(a, b) {
                    if (a.estoque < b.estoque)
                    return -1;
                    if (a.estoque > b.estoque)
                    return 1;
                    return 0;
                }

                return this.estoquesDisponiveis.sort(compare);
            }
        },
        mounted() {
            this.estoquesDisponiveis = this.estoquesData;
            if (this.oldData !== null) {
                for (var i=0; i<this.oldData.length; i++) {  
                    this.estoques.push({
                        'id': this.oldData[i].estoque_id,
                        'estoque': this.getEstoqueById(this.oldData[i].estoque_id).estoque,
                        'estoque_minimo': Number(this.oldData[i].estoque_minimo),
                    });
                    this.incluirEstoque(this.oldData[i].estoque_id);
                }
            }
        },
        updated() {
            $(this.$refs.inputEstoques).selectpicker('refresh');
        },
        methods: {
            validarItem() {
                if ((this.estoque_id == '') || (this.estoque_id <= 0)) {
                    this.errors.inputEstoques = true;
                    this.errors.inputEstoquesMsg = 'Nenhum Estoque selecionado.';
                    return false;
                } else {
                    this.errors.inputEstoques = false;
                    this.errors.inputEstoquesMsg = '';
                }
                
                if (Number(this.estoque_minimo) < 0) {
                    this.errors.inputEstoqueMinimo = true;
                    this.errors.inputEstoqueMinimoMsg = 'Informe o estoque mínimo do produto.';
                    return false;
                } else {
                    this.errors.inputEstoqueMinimo = false;
                    this.errors.inputEstoqueMinimoMsg = '';
                }
                return true;
            },
            confirmDelete(index) {
                this.deleteIndex = index;
            },
            cancelDelete(index) {
                this.deleteIndex = false;
            },
            addEstoque() {
                if (this.validarItem()) {
                    this.estoques.push({
                        'id': this.estoque_id,
                        'estoque': this.getEstoqueById(this.estoque_id).estoque,
                        'estoque_minimo': this.estoque_minimo,
                    });
                    this.incluirEstoque(this.estoque_id);
                    this.limparFormulario();
                }
            },
            editItem(index) {
                let item = this.estoques[index];
                this.estoquesDisponiveis.push(this.getEstoqueSelecionadoById(item.id));
                this.estoque_minimo = item.estoque_minimo;
                this.estoque_id = item.id;
                this.editing = true;
                this.editingIndex = index;
            },
            updateEstoque() {
                this.estoques[this.editingIndex] = {
                    'id': this.estoque_id,
                    'estoque': this.getEstoqueById(this.estoque_id).estoque,
                    'estoque_minimo': this.estoque_minimo,
                };

                this.editing = false;
                this.editingIndex = false;
                this.incluirEstoque(this.estoque_id);
                this.limparFormulario();
            },
            deleteItem() {
                this.removerEstoque(this.estoques[this.deleteIndex].id);
                this.$delete(this.estoques, this.deleteIndex);
            },
            limparFormulario() {
                this.produtoSelecionado = false;
                this.estoque_minimo = '';
                this.$refs.inputEstoques.focus();
            },
            getEstoqueById(id) {
                let result = 0;
                for (var i=0; i<this.estoquesData.length; i++) {  
                    if (this.estoquesData[i].id == id) {
                        result = this.estoquesData[i];
                        break;
                    } 
                }
                return result;
            },
            getEstoqueIndexById(id) {
                let result = 0;
                for (var i=0; i<this.estoquesData.length; i++) {  
                    if (this.estoquesData[i].id == id) {
                        result = i;
                        break;
                    } 
                }
                return result;
            },
            getEstoqueSelecionadoById(id) {
                let result = 0;
                for (var i=0; i<this.estoquesSelecionados.length; i++) {  
                    if (this.estoquesSelecionados[i].id == id) {
                        result = this.estoquesSelecionados[i];
                        break;
                    } 
                }
                return result;
            },
            getEstoqueSelecionadoIndexById(id) {
                let result = 0;
                for (var i=0; i<this.estoquesSelecionados.length; i++) {  
                    if (this.estoquesSelecionados[i].id == id) {
                        result = i;
                        break;
                    } 
                }
                return result;
            },
            incluirEstoque(id) {
                this.estoquesSelecionados.push(this.getEstoqueById(id));
                this.$delete(this.estoquesDisponiveis, this.getEstoqueIndexById(id));
            },
            removerEstoque(id) {
                this.estoquesDisponiveis.push(this.getEstoqueSelecionadoById(id));
                this.$delete(this.estoquesSelecionados, this.getEstoqueSelecionadoIndexById(id));
            }
        }
    }
</script>