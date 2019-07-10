!function(t){var e={};function s(i){if(e[i])return e[i].exports;var o=e[i]={i:i,l:!1,exports:{}};return t[i].call(o.exports,o,o.exports,s),o.l=!0,o.exports}s.m=t,s.c=e,s.d=function(t,e,i){s.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:i})},s.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},s.t=function(t,e){if(1&e&&(t=s(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var i=Object.create(null);if(s.r(i),Object.defineProperty(i,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var o in t)s.d(i,o,function(e){return t[e]}.bind(null,o));return i},s.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return s.d(e,"a",e),e},s.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},s.p="/",s(s.s=6)}({6:function(t,e,s){t.exports=s("JzCF")},JzCF:function(t,e,s){"use strict";s.r(e);var i={name:"estoque_produto",components:{modal:s("eqUL").a},data:function(){return{editing:!1,editingIndex:!1,estoque_id:!1,estoque_minimo:0,estoques:[],isModalVisible:!1,deleteIndex:!1,estoquesDisponiveis:[],estoquesSelecionados:[],errors:{inputEstoques:!1,inputEstoquesMsg:"",inputEstoqueMinimo:!1,inputEstoqueMinimoMsg:""}}},props:["estoquesData","oldData"],watch:{oldData:function(){this.$refs.confirmDelete}},computed:{estoquesDisponiveisOrdenados:function(){return this.estoquesDisponiveis.sort(function(t,e){return t.estoque<e.estoque?-1:t.estoque>e.estoque?1:0})}},mounted:function(){if(this.estoquesDisponiveis=this.estoquesData,null!==this.oldData)for(var t=0;t<this.oldData.length;t++)this.estoques.push({id:this.oldData[t].estoque_id,estoque:this.getEstoqueById(this.oldData[t].estoque_id).estoque,estoque_minimo:Number(this.oldData[t].estoque_minimo)}),this.incluirEstoque(this.oldData[t].estoque_id)},updated:function(){$(this.$refs.inputEstoques).selectpicker("refresh")},methods:{validarItem:function(){return""==this.estoque_id||this.estoque_id<=0?(this.errors.inputEstoques=!0,this.errors.inputEstoquesMsg="Nenhum Estoque selecionado.",!1):(this.errors.inputEstoques=!1,this.errors.inputEstoquesMsg="",Number(this.estoque_minimo)<0?(this.errors.inputEstoqueMinimo=!0,this.errors.inputEstoqueMinimoMsg="Informe o estoque mínimo do produto.",!1):(this.errors.inputEstoqueMinimo=!1,this.errors.inputEstoqueMinimoMsg="",!0))},confirmDelete:function(t){this.deleteIndex=t},cancelDelete:function(t){this.deleteIndex=!1},addEstoque:function(){this.validarItem()&&(this.estoques.push({id:this.estoque_id,estoque:this.getEstoqueById(this.estoque_id).estoque,estoque_minimo:this.estoque_minimo}),this.incluirEstoque(this.estoque_id),this.limparFormulario())},editItem:function(t){var e=this.estoques[t];this.estoquesDisponiveis.push(this.getEstoqueSelecionadoById(e.id)),this.estoque_minimo=e.estoque_minimo,this.estoque_id=e.id,this.editing=!0,this.editingIndex=t},updateEstoque:function(){this.estoques[this.editingIndex]={id:this.estoque_id,estoque:this.getEstoqueById(this.estoque_id).estoque,estoque_minimo:this.estoque_minimo},this.editing=!1,this.editingIndex=!1,this.incluirEstoque(this.estoque_id),this.limparFormulario()},deleteItem:function(){this.removerEstoque(this.estoques[this.deleteIndex].id),this.$delete(this.estoques,this.deleteIndex)},limparFormulario:function(){this.produtoSelecionado=!1,this.estoque_minimo="",this.$refs.inputEstoques.focus()},getEstoqueById:function(t){for(var e=0,s=0;s<this.estoquesData.length;s++)if(this.estoquesData[s].id==t){e=this.estoquesData[s];break}return e},getEstoqueIndexById:function(t){for(var e=0,s=0;s<this.estoquesData.length;s++)if(this.estoquesData[s].id==t){e=s;break}return e},getEstoqueSelecionadoById:function(t){for(var e=0,s=0;s<this.estoquesSelecionados.length;s++)if(this.estoquesSelecionados[s].id==t){e=this.estoquesSelecionados[s];break}return e},getEstoqueSelecionadoIndexById:function(t){for(var e=0,s=0;s<this.estoquesSelecionados.length;s++)if(this.estoquesSelecionados[s].id==t){e=s;break}return e},incluirEstoque:function(t){this.estoquesSelecionados.push(this.getEstoqueById(t)),this.$delete(this.estoquesDisponiveis,this.getEstoqueIndexById(t))},removerEstoque:function(t){this.estoquesDisponiveis.push(this.getEstoqueSelecionadoById(t)),this.$delete(this.estoquesSelecionados,this.getEstoqueSelecionadoIndexById(t))}}},o=s("KHd+"),n=Object(o.a)(i,function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"card d-block"},[t._m(0),t._v(" "),s("div",{staticClass:"card-body",staticStyle:{padding:"0 !important"}},[s("table",{staticClass:"table table-sm table-striped table-bordered table-hover",staticStyle:{"margin-bottom":"0 !important"}},[t._m(1),t._v(" "),s("transition-group",{tag:"tbody",attrs:{name:"fade"}},t._l(t.estoques,function(e,i){return s("tr",{key:i,staticClass:"row m-0"},[s("td",{staticClass:"col-md-1 pool-right"},[t._v("\n                        "+t._s(e.id)+"\n                        "),s("input",{attrs:{type:"hidden",name:"estoques["+i+"][estoque_id]"},domProps:{value:e.id}})]),t._v(" "),s("td",{staticClass:"col-md-7"},[t._v("\n                        "+t._s(e.estoque)+"\n                    ")]),t._v(" "),s("td",{staticClass:"col-md-2 text-right"},[t._v("\n                        "+t._s(e.estoque_minimo)+"\n                        "),s("input",{attrs:{type:"hidden",name:"estoques["+i+"][estoque_minimo]"},domProps:{value:e.estoque_minimo}})]),t._v(" "),s("td",{staticClass:"col-md-2"},[s("button",{directives:[{name:"show",rawName:"v-show",value:!t.editing,expression:"!editing"}],staticClass:"btn btn-sm btn-warning",attrs:{type:"button"},on:{click:function(e){t.editItem(i)}}},[s("i",{staticClass:"fas fa-edit"})]),t._v(" "),s("button",{directives:[{name:"show",rawName:"v-show",value:!t.editing,expression:"!editing"}],staticClass:"btn btn-sm btn-danger",attrs:{type:"button","data-toggle":"modal","data-target":"#confirmDelete"},on:{click:function(e){t.confirmDelete(i)}}},[s("i",{staticClass:"fas fa-trash-alt"})])])])}))])]),t._v(" "),s("div",[s("div",{staticClass:"row m-0"},[s("div",{class:{"col-md-8":!0," has-error":this.errors.inputEstoques},staticStyle:{"padding-right":"0 !important","padding-left":"0 !important"}},[s("select",{directives:[{name:"model",rawName:"v-model",value:t.estoque_id,expression:"estoque_id"}],ref:"inputEstoques",staticClass:"form-control selectpicker",attrs:{"data-live-search":"true",name:"inputEstoques",id:"inputEstoques"},on:{change:function(e){var s=Array.prototype.filter.call(e.target.options,function(t){return t.selected}).map(function(t){return"_value"in t?t._value:t.value});t.estoque_id=e.target.multiple?s:s[0]}}},[s("option",{attrs:{selected:"",value:"false"}},[t._v(" Nada Selecionado ")]),t._v(" "),t._l(t.estoquesDisponiveisOrdenados,function(e,i){return s("option",{key:i,domProps:{value:e.id}},[t._v(t._s(e.estoque))])})],2),t._v(" "),s("span",{staticClass:"help-block",attrs:{"v-if":this.errors.inputEstoques}},[s("strong",[t._v(t._s(this.errors.inputEstoquesMsg))])])]),t._v(" "),s("div",{class:{"col-md-2":!0," has-error":this.errors.inputEstoqueMinimo},staticStyle:{"padding-right":"0 !important","padding-left":"0 !important"}},[s("input",{directives:[{name:"model",rawName:"v-model.number",value:t.estoque_minimo,expression:"estoque_minimo",modifiers:{number:!0}}],ref:"inputEstoqueMinimo",staticClass:"form-control",attrs:{type:"number",min:"0,000",max:"9999999999,999",step:"any",name:"inputEstoqueMinimo",id:"inputEstoqueMinimo"},domProps:{value:t.estoque_minimo},on:{input:function(e){e.target.composing||(t.estoque_minimo=t._n(e.target.value))},blur:function(e){t.$forceUpdate()}}}),t._v(" "),s("span",{staticClass:"help-block",attrs:{"v-if":this.errors.inputEstoqueMinimo}},[s("strong",[t._v(t._s(this.errors.inputEstoqueMinimoMsg))])])]),t._v(" "),s("div",{staticClass:"col-md-2"},[s("button",{directives:[{name:"show",rawName:"v-show",value:!t.editing,expression:"!editing"}],staticClass:"btn btn-success",attrs:{type:"button"},on:{click:t.addEstoque}},[s("i",{staticClass:"fas fa-check"})]),t._v(" "),s("button",{directives:[{name:"show",rawName:"v-show",value:t.editing,expression:"editing"}],staticClass:"btn btn-success",attrs:{type:"button"},on:{click:t.updateEstoque}},[s("i",{staticClass:"fas fa-check"})])])])]),t._v(" "),s("modal",{attrs:{"modal-title":"Corfirmação","modal-text":"Confirma a remoção deste Item?"},on:{cancel:t.cancelDelete,confirm:t.deleteItem}})],1)},[function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"card-header"},[e("strong",[this._v("Estoques")])])},function(){var t=this.$createElement,e=this._self._c||t;return e("thead",{staticClass:"thead-light"},[e("tr",{staticClass:"row m-0"},[e("th",{staticClass:"col-md-1"},[this._v("Id")]),this._v(" "),e("th",{staticClass:"col-md-7"},[this._v("Estoque")]),this._v(" "),e("th",{staticClass:"col-md-2"},[this._v("Est. Mínimo")]),this._v(" "),e("th",{staticClass:"col-md-2"},[this._v("Ações")])])])}],!1,null,null,null).exports;new Vue({el:"#estoque-produto-component",components:{"estoque-produto":n}})},"KHd+":function(t,e,s){"use strict";function i(t,e,s,i,o,n,a,r){var u,d="function"==typeof t?t.options:t;if(e&&(d.render=e,d.staticRenderFns=s,d._compiled=!0),i&&(d.functional=!0),n&&(d._scopeId="data-v-"+n),a?(u=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),o&&o.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(a)},d._ssrRegister=u):o&&(u=r?function(){o.call(this,this.$root.$options.shadowRoot)}:o),u)if(d.functional){d._injectStyles=u;var l=d.render;d.render=function(t,e){return u.call(e),l(t,e)}}else{var c=d.beforeCreate;d.beforeCreate=c?[].concat(c,u):[u]}return{exports:t,options:d}}s.d(e,"a",function(){return i})},eqUL:function(t,e,s){"use strict";var i={name:"modal",methods:{cancel:function(){this.$emit(this._eventCancel)},confirm:function(){this.$emit(this._eventConfirm)}},props:["modalTitle","modalText","eventCancel","eventConfirm"],computed:{_eventCancel:{get:function(){return null==this.eventCancel?"cancel":this.eventCancel}},_eventConfirm:{get:function(){return null==this.eventConfirm?"confirm":this.eventConfirm}}},mounted:function(){}},o=s("KHd+"),n=Object(o.a)(i,function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("transition",{attrs:{name:"modal-fade"}},[s("div",{staticClass:"modal fade",attrs:{id:"confirmDelete",role:"dialog","aria-labelledby":"confirmDeleteLabel","aria-hidden":"true"}},[s("div",{staticClass:"modal-dialog"},[s("div",{staticClass:"modal-content"},[s("div",{staticClass:"modal-header"},[s("h4",{staticClass:"modal-title"},[s("strong",[t._v(t._s(this.modalTitle))])]),t._v(" "),s("button",{staticClass:"close",attrs:{type:"button","data-dismiss":"modal","aria-label":"Close"}},[s("span",{attrs:{"aria-hidden":"true"}},[t._v("×")])])]),t._v(" "),s("div",{staticClass:"modal-body"},[s("p",[t._v("\n              "+t._s(this.modalText)+"                  \n            ")])]),t._v(" "),s("div",{staticClass:"modal-footer"},[s("button",{staticClass:"btn btn-danger",attrs:{type:"button","data-dismiss":"modal",id:"confirm"},on:{click:t.confirm}},[t._v("Remover")]),t._v(" "),s("button",{staticClass:"btn btn-primary",attrs:{type:"button","data-dismiss":"modal"},on:{click:t.cancel}},[t._v("Cancelar")])])])])])])},[],!1,null,null,null);e.a=n.exports}});