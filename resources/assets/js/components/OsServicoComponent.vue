<template>
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>Servicos</strong>
        </div>
        <div class="panel-body" style="padding: 0 !important;">
            <table class="table table-condensed table-striped table-bordered table-hover" style="margin-bottom:0 !important;">
                <thead>
                    <tr class="primary">
                        <th class="col-md-1">Id</th>
                        <th class="col-md-6">Serviço</th>
                        <th class="col-md-1">R$ Serv.</th>
                        <th class="col-md-1">R$ Acrés.</th>
                        <th class="col-md-1">R$ Desc.</th>
                        <th class="col-md-1">R$ Final</th>
                        <th class="col-md-1">Ações</th>
                    </tr>
                </thead>
                <tbody name="fade" is="transition-group">
                    <tr v-for="(item, index) in servicosSelecionados" :key="index">
                        <td class="col-md-1 pool-right">
                            {{ item.id }}
                            <input type="hidden" :name="'servicos['+index+'][servico_id]'" :value="item.id">
                        </td>
                        <td class="col-md-4">
                            {{ item.servico }}
                        </td>
                        <td class="col-md-1 pool-right">
                            {{ item.valor_servico | toDecimal3 }}
                            <input type="hidden" :name="'servicos['+index+'][valor_servico]'" :value="item.valor_servico">
                        </td>
                        <td class="col-md-1 pool-right">
                            {{ item.valor_acrescimo | toDecimal3 }}
                            <input type="hidden" :name="'servicos['+index+'][valor_acrescimo]'" :value="item.valor_acrescimo">
                        </td>
                        <td class="col-md-1 pool-right">
                            {{ item.valor_desconto | toDecimal3 }}
                            <input type="hidden" :name="'servicos['+index+'][valor_desconto]'" :value="item.valor_desconto">
                        </td>
                        <td class="col-md-1 pool-right">
                            {{ item.valor_cobrado | toDecimal3 }}
                            <input type="hidden" :name="'servicos['+index+'][valor_cobrado]'" :value="item.valor_cobrado">
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
        <div class="panel-footer">
            <div class="row">
                <div v-bind:class="{'col-md-7': true, ' has-error': this.errors.inputServicos}" style="padding-right: 0 !important; padding-left: 0 !important;">
                    <select ref="inputServicos" v-model="servico_id" data-live-search="true" class="form-control selectpicker" name="inputServicos" id="inputServicos">
                        <option selected value="false"> Nada Selecionado </option>
                        <option v-for="(servico, index) in servicosDisponiveisOrdenados" :value="servico.id" :key="index">{{ servico.servico }}</option>
                    </select>
                     <span class="help-block" :v-if="this.errors.inputServicos">
                        <strong>{{ this.errors.inputServicosMsg }}</strong>
                    </span>
                </div>
                <div v-bind:class="{'col-md-1': true, ' has-error': this.errors.inputValorServico}" style="padding-right: 0 !important; padding-left: 0 !important;">
                    <input type="number" min="0,000" max="9999999999,999" step="any" ref="inputValorServico" v-model.number="valor_servico" class="form-control" name="inputValorServico" id="inputValorServico" readonly>
                    <span class="help-block" :v-if="this.errors.inputValorServico">
                        <strong>{{ this.errors.inputValorServicoMsg }}</strong>
                    </span>
                </div>
                <div v-bind:class="{'col-md-1': true, ' has-error': this.errors.inputValorAcrescimo}" style="padding-right: 0 !important; padding-left: 0 !important;">
                    <input type="number" min="0,000" max="9999999999,999" step="any" ref="inputValorAcrescimo" v-model.number="valor_acrescimo" class="form-control" name="inputValorAcrescimo" id="inputValorAcrescimo">
                    <span class="help-block" :v-if="this.errors.inputValorAcrescimo">
                        <strong>{{ this.errors.inputValorAcrescimoMsg }}</strong>
                    </span>
                </div>
                <div v-bind:class="{'col-md-1': true, ' has-error': this.errors.inputValorDesconto}" style="padding-right: 0 !important; padding-left: 0 !important;">
                    <input type="number" min="0,000" max="9999999999,999" step="any" ref="inputValorDesconto" v-model.number="valor_desconto" class="form-control" name="inputValorDesconto" id="inputValorDesconto">
                    <span class="help-block" :v-if="this.errors.inputValorDesconto">
                        <strong>{{ this.errors.inputValorDescontoMsg }}</strong>
                    </span>
                </div>
                <div v-bind:class="{'col-md-1': true, ' has-error': this.errors.inputValorValorCobrado}" style="padding-right: 0 !important; padding-left: 0 !important;">
                    <input type="number" min="0,000" max="9999999999,999" step="any" ref="inputValorValorCobrado" v-model.number="valor_cobrado" class="form-control" name="inputValorValorCobrado" id="inputValorValorCobrado" readonly>
                    <span class="help-block" :v-if="this.errors.inputValorValorCobrado">
                        <strong>{{ this.errors.inputValorValorCobradoMsg }}</strong>
                    </span>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-success" @click="addServico" v-show="!editing">
                        <span class="glyphicon glyphicon-plus"></span>
                    </button>
                    <button type="button" class="btn btn-success" @click="updateServico" v-show="editing">
                        <span class="glyphicon glyphicon-ok"></span>
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
        name: 'ordem-servico-servico',
        components: {
            modal
        },
        data() { 
            return {
                editing: false,
                editingIndex: false,
                servico_id: false,
                valor_servico: 0,
                valor_acrescimo: 0,
                valor_desconto: 0,
                valor_cobrado: 0,
                servicos: [],
                isModalVisible: false,
                deleteIndex: false,
                servicosDisponiveis: [],
                servicosSelecionados: [],
                errors: {
                    inputServicos: false,
                    inputServicosMsg: '',
                    inputValorServico: false,
                    inputValorServicoMsg: '',
                    inputValorAcrescimo: false,
                    inputValorAcrescimoMsg: '',
                    inputValorDesconto: false,
                    inputValorDescontoMsg: '',
                    inputValorCobrado: false,
                    inputValorCobradoMsg: '',
                }
            }
        },
        props: [
            'servicosData',
            'oldData'
        ],
        updated() {
            $(this.$refs.inputServicos).selectpicker('refresh');
        },
        watch: {
            oldData: function() {
               this.$refs.confirmDelete
            },
            servico_id: function() {
                let servicoSelecionado = this.getServicoById(this.servico_id);
                if (servicoSelecionado == 0) {
                    this.valor_servico = 0
                } else {
                    this.valor_servico = servicoSelecionado.valor_servico;
                }
            },
            valor_servico: function () {
                this.calTotalServicoItem();
            },
            valor_acrescimo: function () {
                this.calTotalServicoItem();
            },
            valor_desconto: function () {
                this.calTotalServicoItem();
            }
        },
        computed: {
            servicosDisponiveisOrdenados: function() {
                function compare(a, b) {
                    if (a.servico < b.servico)
                    return -1;
                    if (a.servico > b.servico)
                    return 1;
                    return 0;
                }

                return this.servicosDisponiveis.sort(compare);
            },
            valor_total_servicos: {
                get() {
                    let total = 0;
                    for (var i = 0; i < this.servicosSelecionados.length; i++) {
                        total += parseFloat(this.servicosSelecionados[i].valor_cobrado);
                    }
                    return total;
                }
            }
        },
        mounted() {
            this.createFields();
            this.servicosDisponiveis = this.servicosData;
            if (this.oldData !== null) {
                for (var i=0; i<this.oldData.length; i++) { 
                    console.log(this.oldData[i]);
                    this.valor_servico = parseFloat(this.oldData[i].valor_servico);  
                    this.valor_acrescimo = parseFloat(this.oldData[i].valor_acrescimo);
                    this.valor_desconto = parseFloat(this.oldData[i].valor_desconto);
                    this.valor_cobrado = parseFloat(this.oldData[i].valor_cobrado);
                    this.incluirServico(this.oldData[i].servico_id);
                    this.limparFormulario();
                }
            }
        },
        methods: {
            editItem(index) {  
                let item = this.servicosSelecionados[index];
                this.valor_servico = item.valor_servico;
                this.valor_acrescimo = item.valor_acrescimo;
                this.valor_desconto = item.valor_desconto;
                this.valor_cobrado = item.valor_cobrado;
                this.servico_id = item.id;
                this.editing = true;
                this.editingIndex = index;
                this.servicosDisponiveis.push(item);
            },
            confirmDelete(index) {
                this.deleteIndex = index;
            },
            cancelDelete(index) {
                this.deleteIndex = false;
            },
            deleteItem() {
                this.removerServico(this.servicosSelecionados[this.deleteIndex].id);
                this.$delete(this.servicosSelecionados, this.deleteIndex);
            },
            removerServico(id) {
                this.servicosDisponiveis.push(this.getServicoSelecionadoById(id));
                this.$delete(this.servicosSelecionados, this.getServicoSelecionadoIndexById(id));
                this.$emit('updateTotalServ', this.valor_total_servicos);
            },
            addServico() {
                if (this.validarItem()) {
                    this.incluirServico(this.servico_id);
                    this.limparFormulario();
                }
            },
            limparFormulario() {
                this.servico_id = false;
                this.valor_servico = 0;
                this.valor_acrescimo = 0;
                this.valor_desconto = 0;
                this.valor_cobrado = 0;
                this.$refs.inputServicos.focus();
            },
            getServicoById(id) {
                let result = 0;
                for (var i=0; i<this.servicosDisponiveis.length; i++) {  
                    if (this.servicosDisponiveis[i].id == id) {
                        result = this.servicosDisponiveis[i];
                        break;
                    } 
                }
                return result;
            },
            getServicoIndexById(id) {
                let result = 0;
                for (var i=0; i<this.servicosDisponiveis.length; i++) {  
                    if (this.servicosDisponiveis[i].id == id) {
                        result = i;
                        break;
                    } 
                }
                return result;
            },
            getServicoSelecionadoById(id) {
                let result = 0;
                for (var i=0; i<this.servicosSelecionados.length; i++) {  
                    if (this.servicosSelecionados[i].id == id) {
                        result = this.servicosSelecionados[i];
                        break;
                    } 
                }
                return result;
            },
            getServicoSelecionadoIndexById(id) {
                let result = 0;
                for (var i=0; i<this.servicosSelecionados.length; i++) {  
                    if (this.servicosSelecionados[i].id == id) {
                        result = i;
                        break;
                    } 
                }
                return result;
            },
            incluirServico(id) {
                let servicoInserido = this.getServicoById(id);

                servicoInserido.valor_acrescimo = this.valor_acrescimo;
                servicoInserido.valor_desconto = this.valor_desconto;
                servicoInserido.valor_cobrado = this.valor_cobrado;

                this.servicosSelecionados.push(servicoInserido);
                this.$delete(this.servicosDisponiveis, this.getServicoIndexById(id));
                this.$emit('updateTotalServ', this.valor_total_servicos);
            },
            updateServico() {
                this.servicosSelecionados[this.editingIndex] = {
                    'id': this.servico_id,
                    'servico': this.getServicoById(this.servico_id).servico,
                    'valor_servico': this.valor_servico,
                    'valor_acrescimo': this.valor_acrescimo,
                    'valor_desconto': this.valor_desconto,
                    'valor_cobrado': this.valor_cobrado
                };

                this.editing = false;
                this.editingIndex = false;
                this.limparFormulario();
                this.$delete(this.servicosDisponiveis, this.getServicoIndexById(this.servico_id));
                this.$emit('updateTotalServ', this.valor_total_servicos);
            },
            calTotalServicoItem() {
                this.valor_cobrado = (parseFloat((isNaN(this.valor_servico) || (this.valor_servico == '')) ? 0 : this.valor_servico) +
                                      parseFloat((isNaN(this.valor_acrescimo) || (this.valor_acrescimo == '')) ? 0 : this.valor_acrescimo)) - 
                                      parseFloat((isNaN(this.valor_desconto) || (this.valor_desconto == '')) ? 0 : this.valor_desconto);
            },
            validarItem() {
                return true;
            },
            createFields() {
                for (var i=0; i<this.servicosData.length; i++) {  
                    this.servicosData[i]['valor_acrescimo'] = 0; 
                    this.servicosData[i]['valor_desconto'] = 0;
                    this.servicosData[i]['valor_cobrado'] = 0;
                }
            }
        }
    }
</script>
