webpackJsonp([2],{

/***/ 1:
/***/ (function(module, exports) {

/* globals __VUE_SSR_CONTEXT__ */

// IMPORTANT: Do NOT use ES2015 features in this file.
// This module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle.

module.exports = function normalizeComponent (
  rawScriptExports,
  compiledTemplate,
  functionalTemplate,
  injectStyles,
  scopeId,
  moduleIdentifier /* server only */
) {
  var esModule
  var scriptExports = rawScriptExports = rawScriptExports || {}

  // ES6 modules interop
  var type = typeof rawScriptExports.default
  if (type === 'object' || type === 'function') {
    esModule = rawScriptExports
    scriptExports = rawScriptExports.default
  }

  // Vue.extend constructor export interop
  var options = typeof scriptExports === 'function'
    ? scriptExports.options
    : scriptExports

  // render functions
  if (compiledTemplate) {
    options.render = compiledTemplate.render
    options.staticRenderFns = compiledTemplate.staticRenderFns
    options._compiled = true
  }

  // functional template
  if (functionalTemplate) {
    options.functional = true
  }

  // scopedId
  if (scopeId) {
    options._scopeId = scopeId
  }

  var hook
  if (moduleIdentifier) { // server build
    hook = function (context) {
      // 2.3 injection
      context =
        context || // cached call
        (this.$vnode && this.$vnode.ssrContext) || // stateful
        (this.parent && this.parent.$vnode && this.parent.$vnode.ssrContext) // functional
      // 2.2 with runInNewContext: true
      if (!context && typeof __VUE_SSR_CONTEXT__ !== 'undefined') {
        context = __VUE_SSR_CONTEXT__
      }
      // inject component styles
      if (injectStyles) {
        injectStyles.call(this, context)
      }
      // register component module identifier for async chunk inferrence
      if (context && context._registeredComponents) {
        context._registeredComponents.add(moduleIdentifier)
      }
    }
    // used by ssr in case component is cached and beforeCreate
    // never gets called
    options._ssrRegister = hook
  } else if (injectStyles) {
    hook = injectStyles
  }

  if (hook) {
    var functional = options.functional
    var existing = functional
      ? options.render
      : options.beforeCreate

    if (!functional) {
      // inject component registration as beforeCreate hook
      options.beforeCreate = existing
        ? [].concat(existing, hook)
        : [hook]
    } else {
      // for template-only hot-reload because in that case the render fn doesn't
      // go through the normalizer
      options._injectStyles = hook
      // register for functioal component in vue file
      options.render = function renderWithStyleInjection (h, context) {
        hook.call(context)
        return existing(h, context)
      }
    }
  }

  return {
    esModule: esModule,
    exports: scriptExports,
    options: options
  }
}


/***/ }),

/***/ 10:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__modal_vue__ = __webpack_require__(4);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__modal_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__modal_vue__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



/* harmony default export */ __webpack_exports__["default"] = ({
    name: 'ordem-servico-servico',
    components: {
        modal: __WEBPACK_IMPORTED_MODULE_0__modal_vue___default.a
    },
    data: function data() {
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
                inputValorCobradoMsg: ''
            }
        };
    },

    props: ['servicosData', 'oldData'],
    updated: function updated() {
        $(this.$refs.inputServicos).selectpicker('refresh');
    },

    watch: {
        oldData: function oldData() {
            this.$refs.confirmDelete;
        },
        servico_id: function servico_id() {
            var servicoSelecionado = this.getServicoById(this.servico_id);
            if (servicoSelecionado == 0) {
                this.valor_servico = 0;
            } else {
                this.valor_servico = servicoSelecionado.valor_servico;
            }
        },
        valor_servico: function valor_servico() {
            this.calTotalServicoItem();
        },
        valor_acrescimo: function valor_acrescimo() {
            this.calTotalServicoItem();
        },
        valor_desconto: function valor_desconto() {
            this.calTotalServicoItem();
        }
    },
    computed: {
        servicosDisponiveisOrdenados: function servicosDisponiveisOrdenados() {
            function compare(a, b) {
                if (a.servico < b.servico) return -1;
                if (a.servico > b.servico) return 1;
                return 0;
            }

            return this.servicosDisponiveis.sort(compare);
        },
        valor_total_servicos: {
            get: function get() {
                var total = 0;
                for (var i = 0; i < this.servicosSelecionados.length; i++) {
                    total += parseFloat(this.servicosSelecionados[i].valor_cobrado);
                }
                return total;
            }
        }
    },
    mounted: function mounted() {
        this.createFields();
        this.servicosDisponiveis = this.servicosData;
        if (this.oldData !== null) {
            for (var i = 0; i < this.oldData.length; i++) {
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
        editItem: function editItem(index) {
            var item = this.servicosSelecionados[index];
            this.valor_servico = item.valor_servico;
            this.valor_acrescimo = item.valor_acrescimo;
            this.valor_desconto = item.valor_desconto;
            this.valor_cobrado = item.valor_cobrado;
            this.servico_id = item.id;
            this.editing = true;
            this.editingIndex = index;
            this.servicosDisponiveis.push(item);
        },
        confirmDelete: function confirmDelete(index) {
            this.deleteIndex = index;
        },
        cancelDelete: function cancelDelete(index) {
            this.deleteIndex = false;
        },
        deleteItem: function deleteItem() {
            this.removerServico(this.servicosSelecionados[this.deleteIndex].id);
            this.$delete(this.servicosSelecionados, this.deleteIndex);
        },
        removerServico: function removerServico(id) {
            this.servicosDisponiveis.push(this.getServicoSelecionadoById(id));
            this.$delete(this.servicosSelecionados, this.getServicoSelecionadoIndexById(id));
            this.$emit('updateTotalServ', this.valor_total_servicos);
        },
        addServico: function addServico() {
            if (this.validarItem()) {
                this.incluirServico(this.servico_id);
                this.limparFormulario();
            }
        },
        limparFormulario: function limparFormulario() {
            this.servico_id = false;
            this.valor_servico = 0;
            this.valor_acrescimo = 0;
            this.valor_desconto = 0;
            this.valor_cobrado = 0;
            this.$refs.inputServicos.focus();
        },
        getServicoById: function getServicoById(id) {
            var result = 0;
            for (var i = 0; i < this.servicosDisponiveis.length; i++) {
                if (this.servicosDisponiveis[i].id == id) {
                    result = this.servicosDisponiveis[i];
                    break;
                }
            }
            return result;
        },
        getServicoIndexById: function getServicoIndexById(id) {
            var result = 0;
            for (var i = 0; i < this.servicosDisponiveis.length; i++) {
                if (this.servicosDisponiveis[i].id == id) {
                    result = i;
                    break;
                }
            }
            return result;
        },
        getServicoSelecionadoById: function getServicoSelecionadoById(id) {
            var result = 0;
            for (var i = 0; i < this.servicosSelecionados.length; i++) {
                if (this.servicosSelecionados[i].id == id) {
                    result = this.servicosSelecionados[i];
                    break;
                }
            }
            return result;
        },
        getServicoSelecionadoIndexById: function getServicoSelecionadoIndexById(id) {
            var result = 0;
            for (var i = 0; i < this.servicosSelecionados.length; i++) {
                if (this.servicosSelecionados[i].id == id) {
                    result = i;
                    break;
                }
            }
            return result;
        },
        incluirServico: function incluirServico(id) {
            var servicoInserido = this.getServicoById(id);

            servicoInserido.valor_acrescimo = this.valor_acrescimo;
            servicoInserido.valor_desconto = this.valor_desconto;
            servicoInserido.valor_cobrado = this.valor_cobrado;

            this.servicosSelecionados.push(servicoInserido);
            this.$delete(this.servicosDisponiveis, this.getServicoIndexById(id));
            this.$emit('updateTotalServ', this.valor_total_servicos);
        },
        updateServico: function updateServico() {
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
        calTotalServicoItem: function calTotalServicoItem() {
            this.valor_cobrado = parseFloat(isNaN(this.valor_servico) || this.valor_servico == '' ? 0 : this.valor_servico) + parseFloat(isNaN(this.valor_acrescimo) || this.valor_acrescimo == '' ? 0 : this.valor_acrescimo) - parseFloat(isNaN(this.valor_desconto) || this.valor_desconto == '' ? 0 : this.valor_desconto);
        },
        validarItem: function validarItem() {
            return true;
        },
        createFields: function createFields() {
            for (var i = 0; i < this.servicosData.length; i++) {
                this.servicosData[i]['valor_acrescimo'] = 0;
                this.servicosData[i]['valor_desconto'] = 0;
                this.servicosData[i]['valor_cobrado'] = 0;
            }
        }
    }
});
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(2)))

/***/ }),

/***/ 11:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "panel panel-default" },
    [
      _vm._m(0),
      _vm._v(" "),
      _c(
        "div",
        { staticClass: "panel-body", staticStyle: { padding: "0 !important" } },
        [
          _c(
            "table",
            {
              staticClass:
                "table table-condensed table-striped table-bordered table-hover",
              staticStyle: { "margin-bottom": "0 !important" }
            },
            [
              _vm._m(1),
              _vm._v(" "),
              _c(
                "transition-group",
                { tag: "tbody", attrs: { name: "fade" } },
                _vm._l(_vm.servicosSelecionados, function(item, index) {
                  return _c("tr", { key: index }, [
                    _c("td", { staticClass: "col-md-1 pool-right" }, [
                      _vm._v(
                        "\n                        " +
                          _vm._s(item.id) +
                          "\n                        "
                      ),
                      _c("input", {
                        attrs: {
                          type: "hidden",
                          name: "servicos[" + index + "][servico_id]"
                        },
                        domProps: { value: item.id }
                      })
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "col-md-4" }, [
                      _vm._v(
                        "\n                        " +
                          _vm._s(item.servico) +
                          "\n                    "
                      )
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "col-md-1 pool-right" }, [
                      _vm._v(
                        "\n                        " +
                          _vm._s(_vm._f("toDecimal3")(item.valor_servico)) +
                          "\n                        "
                      ),
                      _c("input", {
                        attrs: {
                          type: "hidden",
                          name: "servicos[" + index + "][valor_servico]"
                        },
                        domProps: { value: item.valor_servico }
                      })
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "col-md-1 pool-right" }, [
                      _vm._v(
                        "\n                        " +
                          _vm._s(_vm._f("toDecimal3")(item.valor_acrescimo)) +
                          "\n                        "
                      ),
                      _c("input", {
                        attrs: {
                          type: "hidden",
                          name: "servicos[" + index + "][valor_acrescimo]"
                        },
                        domProps: { value: item.valor_acrescimo }
                      })
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "col-md-1 pool-right" }, [
                      _vm._v(
                        "\n                        " +
                          _vm._s(_vm._f("toDecimal3")(item.valor_desconto)) +
                          "\n                        "
                      ),
                      _c("input", {
                        attrs: {
                          type: "hidden",
                          name: "servicos[" + index + "][valor_desconto]"
                        },
                        domProps: { value: item.valor_desconto }
                      })
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "col-md-1 pool-right" }, [
                      _vm._v(
                        "\n                        " +
                          _vm._s(_vm._f("toDecimal3")(item.valor_cobrado)) +
                          "\n                        "
                      ),
                      _c("input", {
                        attrs: {
                          type: "hidden",
                          name: "servicos[" + index + "][valor_cobrado]"
                        },
                        domProps: { value: item.valor_cobrado }
                      })
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "col-md-1" }, [
                      _c(
                        "button",
                        {
                          directives: [
                            {
                              name: "show",
                              rawName: "v-show",
                              value: !_vm.editing,
                              expression: "!editing"
                            }
                          ],
                          staticClass: "btn-xs btn-warning",
                          attrs: { type: "button" },
                          on: {
                            click: function($event) {
                              _vm.editItem(index)
                            }
                          }
                        },
                        [
                          _c("span", {
                            staticClass: "glyphicon glyphicon-edit"
                          })
                        ]
                      ),
                      _vm._v(" "),
                      _c(
                        "button",
                        {
                          directives: [
                            {
                              name: "show",
                              rawName: "v-show",
                              value: !_vm.editing,
                              expression: "!editing"
                            }
                          ],
                          staticClass: "btn-xs btn-danger",
                          attrs: {
                            type: "button",
                            "data-toggle": "modal",
                            "data-target": "#confirmDelete"
                          },
                          on: {
                            click: function($event) {
                              _vm.confirmDelete(index)
                            }
                          }
                        },
                        [
                          _c("span", {
                            staticClass: "glyphicon glyphicon-trash"
                          })
                        ]
                      )
                    ])
                  ])
                })
              )
            ]
          )
        ]
      ),
      _vm._v(" "),
      _c("div", { staticClass: "panel-footer" }, [
        _c("div", { staticClass: "row" }, [
          _c(
            "div",
            {
              class: {
                "col-md-7": true,
                " has-error": this.errors.inputServicos
              },
              staticStyle: {
                "padding-right": "0 !important",
                "padding-left": "0 !important"
              }
            },
            [
              _c(
                "select",
                {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.servico_id,
                      expression: "servico_id"
                    }
                  ],
                  ref: "inputServicos",
                  staticClass: "form-control selectpicker",
                  attrs: {
                    "data-live-search": "true",
                    name: "inputServicos",
                    id: "inputServicos"
                  },
                  on: {
                    change: function($event) {
                      var $$selectedVal = Array.prototype.filter
                        .call($event.target.options, function(o) {
                          return o.selected
                        })
                        .map(function(o) {
                          var val = "_value" in o ? o._value : o.value
                          return val
                        })
                      _vm.servico_id = $event.target.multiple
                        ? $$selectedVal
                        : $$selectedVal[0]
                    }
                  }
                },
                [
                  _c("option", { attrs: { selected: "", value: "false" } }, [
                    _vm._v(" Nada Selecionado ")
                  ]),
                  _vm._v(" "),
                  _vm._l(_vm.servicosDisponiveisOrdenados, function(
                    servico,
                    index
                  ) {
                    return _c(
                      "option",
                      { key: index, domProps: { value: servico.id } },
                      [_vm._v(_vm._s(servico.servico))]
                    )
                  })
                ],
                2
              ),
              _vm._v(" "),
              _c(
                "span",
                {
                  staticClass: "help-block",
                  attrs: { "v-if": this.errors.inputServicos }
                },
                [_c("strong", [_vm._v(_vm._s(this.errors.inputServicosMsg))])]
              )
            ]
          ),
          _vm._v(" "),
          _c(
            "div",
            {
              class: {
                "col-md-1": true,
                " has-error": this.errors.inputValorServico
              },
              staticStyle: {
                "padding-right": "0 !important",
                "padding-left": "0 !important"
              }
            },
            [
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model.number",
                    value: _vm.valor_servico,
                    expression: "valor_servico",
                    modifiers: { number: true }
                  }
                ],
                ref: "inputValorServico",
                staticClass: "form-control",
                attrs: {
                  type: "number",
                  min: "0,000",
                  max: "9999999999,999",
                  step: "any",
                  name: "inputValorServico",
                  id: "inputValorServico",
                  readonly: ""
                },
                domProps: { value: _vm.valor_servico },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.valor_servico = _vm._n($event.target.value)
                  },
                  blur: function($event) {
                    _vm.$forceUpdate()
                  }
                }
              }),
              _vm._v(" "),
              _c(
                "span",
                {
                  staticClass: "help-block",
                  attrs: { "v-if": this.errors.inputValorServico }
                },
                [
                  _c("strong", [
                    _vm._v(_vm._s(this.errors.inputValorServicoMsg))
                  ])
                ]
              )
            ]
          ),
          _vm._v(" "),
          _c(
            "div",
            {
              class: {
                "col-md-1": true,
                " has-error": this.errors.inputValorAcrescimo
              },
              staticStyle: {
                "padding-right": "0 !important",
                "padding-left": "0 !important"
              }
            },
            [
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model.number",
                    value: _vm.valor_acrescimo,
                    expression: "valor_acrescimo",
                    modifiers: { number: true }
                  }
                ],
                ref: "inputValorAcrescimo",
                staticClass: "form-control",
                attrs: {
                  type: "number",
                  min: "0,000",
                  max: "9999999999,999",
                  step: "any",
                  name: "inputValorAcrescimo",
                  id: "inputValorAcrescimo"
                },
                domProps: { value: _vm.valor_acrescimo },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.valor_acrescimo = _vm._n($event.target.value)
                  },
                  blur: function($event) {
                    _vm.$forceUpdate()
                  }
                }
              }),
              _vm._v(" "),
              _c(
                "span",
                {
                  staticClass: "help-block",
                  attrs: { "v-if": this.errors.inputValorAcrescimo }
                },
                [
                  _c("strong", [
                    _vm._v(_vm._s(this.errors.inputValorAcrescimoMsg))
                  ])
                ]
              )
            ]
          ),
          _vm._v(" "),
          _c(
            "div",
            {
              class: {
                "col-md-1": true,
                " has-error": this.errors.inputValorDesconto
              },
              staticStyle: {
                "padding-right": "0 !important",
                "padding-left": "0 !important"
              }
            },
            [
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model.number",
                    value: _vm.valor_desconto,
                    expression: "valor_desconto",
                    modifiers: { number: true }
                  }
                ],
                ref: "inputValorDesconto",
                staticClass: "form-control",
                attrs: {
                  type: "number",
                  min: "0,000",
                  max: "9999999999,999",
                  step: "any",
                  name: "inputValorDesconto",
                  id: "inputValorDesconto"
                },
                domProps: { value: _vm.valor_desconto },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.valor_desconto = _vm._n($event.target.value)
                  },
                  blur: function($event) {
                    _vm.$forceUpdate()
                  }
                }
              }),
              _vm._v(" "),
              _c(
                "span",
                {
                  staticClass: "help-block",
                  attrs: { "v-if": this.errors.inputValorDesconto }
                },
                [
                  _c("strong", [
                    _vm._v(_vm._s(this.errors.inputValorDescontoMsg))
                  ])
                ]
              )
            ]
          ),
          _vm._v(" "),
          _c(
            "div",
            {
              class: {
                "col-md-1": true,
                " has-error": this.errors.inputValorValorCobrado
              },
              staticStyle: {
                "padding-right": "0 !important",
                "padding-left": "0 !important"
              }
            },
            [
              _c("input", {
                directives: [
                  {
                    name: "model",
                    rawName: "v-model.number",
                    value: _vm.valor_cobrado,
                    expression: "valor_cobrado",
                    modifiers: { number: true }
                  }
                ],
                ref: "inputValorValorCobrado",
                staticClass: "form-control",
                attrs: {
                  type: "number",
                  min: "0,000",
                  max: "9999999999,999",
                  step: "any",
                  name: "inputValorValorCobrado",
                  id: "inputValorValorCobrado",
                  readonly: ""
                },
                domProps: { value: _vm.valor_cobrado },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.valor_cobrado = _vm._n($event.target.value)
                  },
                  blur: function($event) {
                    _vm.$forceUpdate()
                  }
                }
              }),
              _vm._v(" "),
              _c(
                "span",
                {
                  staticClass: "help-block",
                  attrs: { "v-if": this.errors.inputValorValorCobrado }
                },
                [
                  _c("strong", [
                    _vm._v(_vm._s(this.errors.inputValorValorCobradoMsg))
                  ])
                ]
              )
            ]
          ),
          _vm._v(" "),
          _c("div", { staticClass: "col-md-1" }, [
            _c(
              "button",
              {
                directives: [
                  {
                    name: "show",
                    rawName: "v-show",
                    value: !_vm.editing,
                    expression: "!editing"
                  }
                ],
                staticClass: "btn btn-success",
                attrs: { type: "button" },
                on: { click: _vm.addServico }
              },
              [_c("span", { staticClass: "glyphicon glyphicon-plus" })]
            ),
            _vm._v(" "),
            _c(
              "button",
              {
                directives: [
                  {
                    name: "show",
                    rawName: "v-show",
                    value: _vm.editing,
                    expression: "editing"
                  }
                ],
                staticClass: "btn btn-success",
                attrs: { type: "button" },
                on: { click: _vm.updateServico }
              },
              [_c("span", { staticClass: "glyphicon glyphicon-ok" })]
            )
          ])
        ])
      ]),
      _vm._v(" "),
      _c("modal", {
        attrs: {
          "modal-title": "Corfirmação",
          "modal-text": "Confirma a remoção deste Item?"
        },
        on: { cancel: _vm.cancelDelete, confirm: _vm.deleteItem }
      })
    ],
    1
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "panel-heading" }, [
      _c("strong", [_vm._v("Servicos")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", { staticClass: "primary" }, [
        _c("th", { staticClass: "col-md-1" }, [_vm._v("Id")]),
        _vm._v(" "),
        _c("th", { staticClass: "col-md-6" }, [_vm._v("Serviço")]),
        _vm._v(" "),
        _c("th", { staticClass: "col-md-1" }, [_vm._v("R$ Serv.")]),
        _vm._v(" "),
        _c("th", { staticClass: "col-md-1" }, [_vm._v("R$ Acrés.")]),
        _vm._v(" "),
        _c("th", { staticClass: "col-md-1" }, [_vm._v("R$ Desc.")]),
        _vm._v(" "),
        _c("th", { staticClass: "col-md-1" }, [_vm._v("R$ Final")]),
        _vm._v(" "),
        _c("th", { staticClass: "col-md-1" }, [_vm._v("Ações")])
      ])
    ])
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-6b37570e", module.exports)
  }
}

/***/ }),

/***/ 12:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(13)
/* template */
var __vue_template__ = __webpack_require__(17)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/assets/js/components/OsProdutoComponent.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-15e6fa7f", Component.options)
  } else {
    hotAPI.reload("data-v-15e6fa7f", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 13:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__modal2_vue__ = __webpack_require__(14);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__modal2_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__modal2_vue__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



/* harmony default export */ __webpack_exports__["default"] = ({
    name: 'ordem-servico-produto',
    components: {
        modal2: __WEBPACK_IMPORTED_MODULE_0__modal2_vue___default.a
    },
    props: ['oldData', 'estoques', 'oldEstoqueId', 'estoqueError'],
    data: function data() {
        return {
            editing: false,
            editingIndex: false,
            produtos: [],
            quantidade: 1,
            desconto: 0,
            acrescimo: 0,
            valor_cobrado: 0,
            isModalVisible: false,
            deleteIndex: false,
            produtosDisponiveis: [],
            produtosSelecionados: [],
            produtosData: [],
            loadOldDataFlag: true,
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
                inputAcrescimoMsg: '',
                estoqueId: false,
                estoqueIdMsg: ''
            },
            _produto_id: false,
            get produto_id() {
                return this._produto_id;
            },
            set produto_id(value) {
                this._produto_id = value;
            },
            _estoqueId: null,
            get estoqueId() {
                return this._estoqueId;
            },
            set estoqueId(value) {
                this._estoqueId = value;
            }
        };
    },

    watch: {
        oldData: function oldData() {
            //this.$refs.confirmDelete
        },
        estoqueId: function estoqueId() {
            this.getProdutos();
        },
        valor_produto: function valor_produto() {
            this.calcTotalProdutoItem();
        },
        valor_desconto: function valor_desconto() {
            this.calcTotalProdutoItem();
        },
        valor_acrescimo: function valor_acrescimo() {
            this.calcTotalProdutoItem();
        },
        quantidade: function quantidade() {
            this.calcTotalProdutoItem();
        },
        produto_id: function produto_id() {
            this.calcTotalProdutoItem();
        }
    },
    computed: {
        estoque_id: {
            get: function get() {
                return this.estoqueId;
            },
            set: function set(value) {
                this.estoqueId = value;
            }
        },
        valor_total: {
            get: function get() {
                var total = 0;
                for (var i = 0; i < this.produtos.length; i++) {
                    total += this.produtos[i].quantidade * this.produtos[i].valor_produto;
                }
                return parseFloat(total);
            }
        },
        valorUnitario: {
            get: function get() {
                return this.getProdutoById(this.produto_id).valor_venda;
            }
        },
        produtosDisponiveisOrdenados: function produtosDisponiveisOrdenados() {
            function compare(a, b) {
                if (a.produto_descricao < b.produto_descricao) return -1;
                if (a.produto_descricao > b.produto_descricao) return 1;
                return 0;
            }

            return this.produtosDisponiveis.sort(compare);
        }
    },
    mounted: function mounted() {
        if (this.oldEstoqueId !== null) {
            this.estoqueId = this.oldEstoqueId;
            //this.getProdutos();
        }
    },
    updated: function updated() {
        $(this.$refs.inputProdutos).selectpicker('refresh');
        $(this.$refs.estoqueId).selectpicker('refresh');
    },

    methods: {
        getProdutos: function getProdutos() {
            var self = this;
            //if ((this.estoqueId !== null) && (this.estoqueId !== 'false')) {
            if (this.estoqueId > 0) {
                axios.get('/produtos_estoque/' + this.estoqueId + '/json').then(function (response) {
                    self.produtosDisponiveis = response.data;
                    self.produtosData = response.data;
                    self.loadOldData();
                });
            }
        },
        loadOldData: function loadOldData() {
            if (this.oldData !== null && this.loadOldDataFlag == true) {
                this.loadOldDataFlag = false;
                for (var i = 0; i < this.oldData.length; i++) {
                    this.produtos.push({
                        'id': this.oldData[i].produto_id,
                        'produto_descricao': this.getProdutoById(this.oldData[i].produto_id).produto_descricao,
                        'quantidade': Number(this.oldData[i].quantidade),
                        'valor_produto': Number(this.oldData[i].valor_produto),
                        'valor_desconto': Number(this.oldData[i].valor_desconto),
                        'valor_acrescimo': Number(this.oldData[i].valor_acrescimo),
                        'valor_cobrado': Number(this.oldData[i].valor_cobrado)
                    });
                    this.incluirProduto(this.oldData[i].produto_id);
                }
            }
        },
        truncDecimal: function truncDecimal(value, n) {
            x = (value.toString() + ".0").split(".");
            return parseFloat(x[0] + "," + x[1].substr(0, n));
        },
        validarItem: function validarItem() {
            if (this.produto_id == '' || this.produto_id <= 0) {
                this.errors.inputProdutos = true;
                this.errors.inputProdutosMsg = 'Nenhum Produto selecionado.';
                return false;
            } else {
                this.errors.inputProdutos = false;
                this.errors.inputProdutosMsg = '';
            }

            if (this.quantidade == '' || this.quantidade <= 0) {
                this.errors.inputQuantidade = true;
                this.errors.inputQuantidadeMsg = 'Informe a quantidade do produto.';
                return false;
            } else {
                if (!this.getEstoqueById(this.estoqueId).permite_estoque_negativo) {
                    var posicao_estoque_produto = this.getProdutoById(this.produto_id).posicao_estoque;
                    if (this.quantidade > posicao_estoque_produto) {
                        this.errors.inputQuantidade = true;
                        this.errors.inputQuantidadeMsg = 'Quantidade informada execede saldo em estoque (' + this.truncDecimal(posicao_estoque_produto, 3) + ').';
                        return false;
                    }
                }
                this.errors.inputQuantidade = false;
                this.errors.inputQuantidadeMsg = '';
            }

            if (this.valorUnitario == '' || this.valorUnitario <= 0) {
                this.errors.inputValorUnitario = true;
                this.errors.inputValorUnitarioMsg = 'Informe o Valor Unitário do produto.';
                return false;
            } else {
                this.errors.inputValorUnitario = false;
                this.errors.inputValorUnitarioMsg = '';
            }
            return true;
        },
        confirmDeleteProduto: function confirmDeleteProduto(index) {
            this.deleteIndex = index;
        },
        cancelDelete: function cancelDelete(index) {
            this.deleteIndex = false;
        },
        cancelProtuto: function cancelProtuto() {
            console.log('cancel produto');
        },
        confirmProtuto: function confirmProtuto() {
            console.log('confirm produto');
        },
        addProduto: function addProduto() {
            if (this.validarItem()) {
                this.produtos.push({
                    'id': this.produto_id,
                    'produto_descricao': this.getProdutoById(this.produto_id).produto_descricao,
                    'quantidade': this.quantidade,
                    'valor_produto': this.valorUnitario,
                    'valor_desconto': this.desconto,
                    'valor_acrescimo': this.acrescimo,
                    'valor_cobrado': this.valor_cobrado
                });
                this.incluirProduto(this.produto_id);
                this.limparFormulario();
            }
        },
        editItem: function editItem(index) {
            var item = this.produtos[index];
            this.quantidade = item.quantidade;
            this.valorUnitario = item.valor_produto;
            this.desconto = item.valor_desconto;
            this.acrescimo = item.valor_acrescimo;
            this.produto_id = item.id;
            this.editing = true;
            this.editingIndex = index;
        },
        updateProduto: function updateProduto() {
            this.produtos[this.editingIndex] = {
                'id': this.produto_id,
                'produto_descricao': this.getProdutoById(this.produto_id).produto_descricao,
                'quantidade': this.quantidade,
                'valor_produto': this.valorUnitario,
                'valor_desconto': this.desconto,
                'valor_acrescimo': this.acrescimo,
                'valor_cobrado': this.valor_cobrado
            };

            this.editing = false;
            this.editingIndex = false;
            this.limparFormulario();
        },
        deleteProduto: function deleteProduto() {
            console.log('Entrou no deleteProduto: ' + this.deleteIndex);
            this.removerProduto(this.produtos[this.deleteIndex].id);
            this.$delete(this.produtos, this.deleteIndex);
        },
        limparFormulario: function limparFormulario() {
            this.produto_id = null;
            this.produtoSelecionado = false;
            this.quantidade = 1;
            //this.valorUnitario = '';
            this.desconto = 0.00;
            this.acrescimo = 0.00;
            this.valor_cobrado = 0.00;
            this.$refs.inputProdutos.focus();
        },
        totalQuantidade: function totalQuantidade() {
            var result = 0;
            for (var i = 0; i < this.produtos.length; i++) {
                result += this.produtos[i].quantidade;
            }
            return result;
        },
        totalValor: function totalValor() {
            var result = 0;
            for (var i = 0; i < this.produtos.length; i++) {
                result += this.produtos[i].valor_produto;
            }
            return result;
        },
        totalDesconto: function totalDesconto() {
            var result = 0;
            for (var i = 0; i < this.produtos.length; i++) {
                result += this.produtos[i].valor_desconto;
            }
            return result;
        },
        totalAcrescimo: function totalAcrescimo() {
            var result = 0;
            for (var i = 0; i < this.produtos.length; i++) {
                result += this.produtos[i].valor_acrescimo;
            }
            return result;
        },
        totalCobrado: function totalCobrado() {
            var result = 0;
            for (var i = 0; i < this.produtos.length; i++) {
                result += this.produtos[i].valor_cobrado;
            }
            return result;
        },
        getProdutoById: function getProdutoById(id) {
            var result = 0;
            for (var i = 0; i < this.produtosData.length; i++) {
                if (this.produtosData[i].id == id) {
                    result = this.produtosData[i];
                    break;
                }
            }
            return result;
        },
        getEstoqueById: function getEstoqueById(id) {
            var result = 0;
            for (var i = 0; i < this.estoques.length; i++) {
                if (this.estoques[i].id == id) {
                    result = this.estoques[i];
                    break;
                }
            }
            return result;
        },
        getProdutoIndexById: function getProdutoIndexById(id) {
            var result = 0;
            for (var i = 0; i < this.produtosData.length; i++) {
                if (this.produtosData[i].id == id) {
                    result = i;
                    break;
                }
            }
            console.log('index: ' + result);
            return result;
        },
        getProdutoSelecionadoById: function getProdutoSelecionadoById(id) {
            var result = 0;
            for (var i = 0; i < this.produtosSelecionados.length; i++) {
                if (this.produtosSelecionados[i].id == id) {
                    result = this.produtosSelecionados[i];
                    break;
                }
            }
            return result;
        },
        getProdutoSelecionadoIndexById: function getProdutoSelecionadoIndexById(id) {
            var result = 0;
            for (var i = 0; i < this.produtosSelecionados.length; i++) {
                if (this.produtosSelecionados[i].id == id) {
                    result = i;
                    break;
                }
            }
            return result;
        },
        incluirProduto: function incluirProduto(id) {
            this.produtosSelecionados.push(this.getProdutoById(id));
            this.$delete(this.produtosDisponiveis, this.getProdutoIndexById(id));
            this.$emit('updateTotalProd', this.valor_total);
        },
        removerProduto: function removerProduto(id) {
            this.produtosDisponiveis.push(this.getProdutoSelecionadoById(id));
            this.$delete(this.produtosSelecionados, this.getProdutoSelecionadoIndexById(id));
            this.$emit('updateTotalProd', this.valor_total);
        },
        calcTotalProdutoItem: function calcTotalProdutoItem() {
            this.valor_cobrado = (parseFloat(isNaN(this.valorUnitario) || this.valorUnitario == '' ? 0 : this.valorUnitario) + parseFloat(isNaN(this.valor_acrescimo) || this.valor_acrescimo == '' ? 0 : this.valor_acrescimo) - parseFloat(isNaN(this.valor_desconto) || this.valor_desconto == '' ? 0 : this.valor_desconto)) * parseFloat(isNaN(this.quantidade) || this.quantidade == '' ? 1 : this.quantidade);
        }
    }
});
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(2)))

/***/ }),

/***/ 14:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(15)
/* template */
var __vue_template__ = __webpack_require__(16)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/assets/js/components/modal2.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-508e0d08", Component.options)
  } else {
    hotAPI.reload("data-v-508e0d08", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 15:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'modal2',

  methods: {
    cancel2: function cancel2() {
      this.$emit('cancel2');
    },
    confirm2: function confirm2() {
      this.$emit('confirm2');
    }
  },
  props: ['modalTitle', 'modalText']
});

/***/ }),

/***/ 16:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("transition", { attrs: { name: "modal-fade" } }, [
    _c(
      "div",
      {
        staticClass: "modal fade",
        attrs: {
          id: "confirmDelete2",
          role: "dialog",
          "aria-labelledby": "confirmDeleteLabel",
          "aria-hidden": "true"
        }
      },
      [
        _c("div", { staticClass: "modal-dialog" }, [
          _c("div", { staticClass: "modal-content modal-default" }, [
            _c("div", { staticClass: "modal-header" }, [
              _c(
                "button",
                {
                  staticClass: "close",
                  attrs: {
                    type: "button",
                    "data-dismiss": "modal2",
                    "aria-hidden": "true"
                  }
                },
                [_vm._v("×")]
              ),
              _vm._v(" "),
              _c("div", { staticClass: "row" }, [
                _c("div", { staticClass: "col-sm-1" }, [
                  _c("span", { staticClass: "glyphicon glyphicon-alert" })
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col" }, [
                  _c("h4", { staticClass: "modal-title" }, [
                    _c("strong", [_vm._v(_vm._s(this.modalTitle))])
                  ])
                ])
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "modal-body" }, [
              _c("p", [
                _vm._v(
                  "\n              " +
                    _vm._s(this.modalText) +
                    "                  \n            "
                )
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "modal-footer" }, [
              _c(
                "button",
                {
                  staticClass: "btn btn-danger",
                  attrs: {
                    type: "button",
                    "data-dismiss": "modal",
                    id: "confirm2"
                  },
                  on: { click: _vm.confirm2 }
                },
                [_vm._v("Remover")]
              ),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass: "btn btn-primary",
                  attrs: { type: "button", "data-dismiss": "modal" },
                  on: { click: _vm.cancel2 }
                },
                [_vm._v("Cancelar")]
              )
            ])
          ])
        ])
      ]
    )
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-508e0d08", module.exports)
  }
}

/***/ }),

/***/ 17:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "form-group" }, [
    _c("div", { staticClass: "row" }, [
      _c("input", {
        directives: [
          {
            name: "model",
            rawName: "v-model",
            value: _vm.estoque_id,
            expression: "estoque_id"
          }
        ],
        attrs: { type: "hidden", name: "estoque_id" },
        domProps: { value: _vm.estoque_id },
        on: {
          input: function($event) {
            if ($event.target.composing) {
              return
            }
            _vm.estoque_id = $event.target.value
          }
        }
      }),
      _vm._v(" "),
      _c("input", {
        directives: [
          {
            name: "model",
            rawName: "v-model",
            value: _vm.valor_total,
            expression: "valor_total"
          }
        ],
        attrs: { type: "hidden", name: "valor_total" },
        domProps: { value: _vm.valor_total },
        on: {
          input: function($event) {
            if ($event.target.composing) {
              return
            }
            _vm.valor_total = $event.target.value
          }
        }
      }),
      _vm._v(" "),
      _c(
        "div",
        { class: { "col-md-7": true, " has-error": this.errors.estoqueId } },
        [
          _c(
            "label",
            { staticClass: "control-label", attrs: { for: "estoqueId" } },
            [_vm._v("Estoque")]
          ),
          _vm._v(" "),
          _c(
            "select",
            {
              directives: [
                {
                  name: "model",
                  rawName: "v-model",
                  value: _vm.estoqueId,
                  expression: "estoqueId"
                }
              ],
              ref: "estoqueId",
              staticClass: "form-control selectpicker",
              attrs: {
                "data-live-search": "true",
                name: "estoqueId",
                id: "estoqueId",
                disabled: _vm.produtosSelecionados.length > 0
              },
              on: {
                change: function($event) {
                  var $$selectedVal = Array.prototype.filter
                    .call($event.target.options, function(o) {
                      return o.selected
                    })
                    .map(function(o) {
                      var val = "_value" in o ? o._value : o.value
                      return val
                    })
                  _vm.estoqueId = $event.target.multiple
                    ? $$selectedVal
                    : $$selectedVal[0]
                }
              }
            },
            [
              _c("option", { attrs: { selected: "", value: "" } }, [
                _vm._v(" Nada Selecionado ")
              ]),
              _vm._v(" "),
              _vm._l(this.estoques, function(estoque, index) {
                return _c(
                  "option",
                  { key: index, domProps: { value: estoque.id } },
                  [_vm._v(_vm._s(estoque.estoque))]
                )
              })
            ],
            2
          ),
          _vm._v(" "),
          _c(
            "span",
            {
              staticClass: "help-block",
              attrs: { "v-if": this.errors.estoqueId }
            },
            [_c("strong", [_vm._v(_vm._s(this.errors.estoqueIdMsg))])]
          )
        ]
      )
    ]),
    _vm._v(" "),
    _c(
      "div",
      { staticClass: "panel panel-default" },
      [
        _vm._m(0),
        _vm._v(" "),
        _c(
          "div",
          {
            staticClass: "panel-body",
            staticStyle: { padding: "0 !important" }
          },
          [
            _c(
              "table",
              {
                staticClass:
                  "table table-condensed table-striped table-bordered table-hover",
                staticStyle: { "margin-bottom": "0 !important" }
              },
              [
                _vm._m(1),
                _vm._v(" "),
                _c(
                  "transition-group",
                  { tag: "tbody", attrs: { name: "fade" } },
                  _vm._l(_vm.produtos, function(item, index) {
                    return _c("tr", { key: index }, [
                      _c("td", { staticClass: "col-md-1 pool-right" }, [
                        _vm._v(
                          "\n                            " +
                            _vm._s(item.id) +
                            "\n                            "
                        ),
                        _c("input", {
                          attrs: {
                            type: "hidden",
                            name: "produtos[" + index + "][produto_id]"
                          },
                          domProps: { value: item.id }
                        })
                      ]),
                      _vm._v(" "),
                      _c("td", { staticClass: "col-md-5" }, [
                        _vm._v(
                          "\n                            " +
                            _vm._s(item.produto_descricao) +
                            "\n                        "
                        )
                      ]),
                      _vm._v(" "),
                      _c("td", { staticClass: "col-md-1 text-right" }, [
                        _vm._v(
                          "\n                            " +
                            _vm._s(_vm._f("toDecimal3")(item.quantidade)) +
                            " \n                            "
                        ),
                        _c("input", {
                          attrs: {
                            type: "hidden",
                            name: "produtos[" + index + "][quantidade]"
                          },
                          domProps: { value: item.quantidade }
                        })
                      ]),
                      _vm._v(" "),
                      _c("td", { staticClass: "col-md-1 text-right" }, [
                        _vm._v(
                          "\n                            " +
                            _vm._s(_vm._f("toDecimal3")(item.valor_produto)) +
                            "\n                            "
                        ),
                        _c("input", {
                          attrs: {
                            type: "hidden",
                            name: "produtos[" + index + "][valor_produto]"
                          },
                          domProps: { value: item.valor_produto }
                        })
                      ]),
                      _vm._v(" "),
                      _c("td", { staticClass: "col-md-1 text-right" }, [
                        _vm._v(
                          "\n                            " +
                            _vm._s(_vm._f("toDecimal3")(item.valor_desconto)) +
                            "\n                            "
                        ),
                        _c("input", {
                          attrs: {
                            type: "hidden",
                            name: "produtos[" + index + "][valor_desconto]"
                          },
                          domProps: { value: item.valor_desconto }
                        })
                      ]),
                      _vm._v(" "),
                      _c("td", { staticClass: "col-md-1 text-right" }, [
                        _vm._v(
                          "\n                            " +
                            _vm._s(_vm._f("toDecimal3")(item.valor_acrescimo)) +
                            "\n                            "
                        ),
                        _c("input", {
                          attrs: {
                            type: "hidden",
                            name: "produtos[" + index + "][valor_acrescimo]"
                          },
                          domProps: { value: item.valor_acrescimo }
                        })
                      ]),
                      _vm._v(" "),
                      _c("td", { staticClass: "col-md-1 text-right" }, [
                        _vm._v(
                          "\n                            " +
                            _vm._s(_vm._f("toDecimal3")(item.valor_cobrado)) +
                            "\n                            "
                        ),
                        _c("input", {
                          attrs: {
                            type: "hidden",
                            name: "produtos[" + index + "][valor_cobrado]"
                          },
                          domProps: { value: item.valor_cobrado }
                        })
                      ]),
                      _vm._v(" "),
                      _c("td", { staticClass: "col-md-1" }, [
                        _c(
                          "button",
                          {
                            directives: [
                              {
                                name: "show",
                                rawName: "v-show",
                                value: !_vm.editing,
                                expression: "!editing"
                              }
                            ],
                            staticClass: "btn-xs btn-warning",
                            attrs: { type: "button" },
                            on: {
                              click: function($event) {
                                _vm.editItem(index)
                              }
                            }
                          },
                          [
                            _c("span", {
                              staticClass: "glyphicon glyphicon-edit"
                            })
                          ]
                        ),
                        _vm._v(" "),
                        _c(
                          "button",
                          {
                            directives: [
                              {
                                name: "show",
                                rawName: "v-show",
                                value: !_vm.editing,
                                expression: "!editing"
                              }
                            ],
                            staticClass: "btn-xs btn-danger",
                            attrs: {
                              type: "button",
                              "data-toggle": "modal",
                              "data-target": "#confirmDelete2"
                            },
                            on: {
                              click: function($event) {
                                _vm.confirmDeleteProduto(index)
                              }
                            }
                          },
                          [
                            _c("span", {
                              staticClass: "glyphicon glyphicon-trash"
                            })
                          ]
                        )
                      ])
                    ])
                  })
                ),
                _vm._v(" "),
                this.produtos.length > 0
                  ? _c("tfoot", [
                      _c("tr", { staticClass: "success" }, [
                        _c("td", { staticClass: "col-md-1" }, [
                          _c("strong", [_vm._v(_vm._s(this.produtos.length))])
                        ]),
                        _vm._v(" "),
                        _c("td", { staticClass: "col-md-5" }),
                        _vm._v(" "),
                        _c("td", { staticClass: "col-md-1 text-right" }, [
                          _c("strong", [
                            _vm._v(
                              _vm._s(
                                _vm._f("toDecimal3")(this.totalQuantidade())
                              )
                            )
                          ])
                        ]),
                        _vm._v(" "),
                        _c("td", { staticClass: "col-md-1 text-right" }, [
                          _c("strong", [
                            _vm._v(
                              _vm._s(_vm._f("toDecimal3")(this.totalValor()))
                            )
                          ])
                        ]),
                        _vm._v(" "),
                        _c("td", { staticClass: "col-md-1 text-right" }, [
                          _c("strong", [
                            _vm._v(
                              _vm._s(_vm._f("toDecimal3")(this.totalDesconto()))
                            )
                          ])
                        ]),
                        _vm._v(" "),
                        _c("td", { staticClass: "col-md-1 text-right" }, [
                          _c("strong", [
                            _vm._v(
                              _vm._s(
                                _vm._f("toDecimal3")(this.totalAcrescimo())
                              )
                            )
                          ])
                        ]),
                        _vm._v(" "),
                        _c("td", { staticClass: "col-md-1 text-right" }, [
                          _c("strong", [
                            _vm._v(
                              _vm._s(_vm._f("toDecimal3")(this.totalCobrado()))
                            )
                          ])
                        ]),
                        _vm._v(" "),
                        _c("td", { staticClass: "col-md-2" })
                      ])
                    ])
                  : _vm._e()
              ]
            )
          ]
        ),
        _vm._v(" "),
        _c("div", { staticClass: "panel-footer" }, [
          _c("div", { staticClass: "row" }, [
            _c(
              "div",
              {
                class: {
                  "col-md-6": true,
                  " has-error": this.errors.inputProdutos
                },
                staticStyle: {
                  "padding-right": "0 !important",
                  "padding-left": "0 !important"
                }
              },
              [
                _c(
                  "select",
                  {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.produto_id,
                        expression: "produto_id"
                      }
                    ],
                    ref: "inputProdutos",
                    staticClass: "form-control selectpicker",
                    attrs: {
                      disabled:
                        _vm.estoqueId == "false" || _vm.estoqueId == null,
                      "data-live-search": "true",
                      name: "inputProdutos",
                      id: "inputProdutos"
                    },
                    on: {
                      change: function($event) {
                        var $$selectedVal = Array.prototype.filter
                          .call($event.target.options, function(o) {
                            return o.selected
                          })
                          .map(function(o) {
                            var val = "_value" in o ? o._value : o.value
                            return val
                          })
                        _vm.produto_id = $event.target.multiple
                          ? $$selectedVal
                          : $$selectedVal[0]
                      }
                    }
                  },
                  [
                    _c("option", { attrs: { selected: "", value: "false" } }, [
                      _vm._v(" Nada Selecionado ")
                    ]),
                    _vm._v(" "),
                    _vm._l(_vm.produtosDisponiveisOrdenados, function(
                      produto,
                      index
                    ) {
                      return _c(
                        "option",
                        { key: index, domProps: { value: produto.id } },
                        [_vm._v(_vm._s(produto.produto_descricao))]
                      )
                    })
                  ],
                  2
                ),
                _vm._v(" "),
                _c(
                  "span",
                  {
                    staticClass: "help-block",
                    attrs: { "v-if": this.errors.inputProdutos }
                  },
                  [_c("strong", [_vm._v(_vm._s(this.errors.inputProdutosMsg))])]
                )
              ]
            ),
            _vm._v(" "),
            _c(
              "div",
              {
                class: {
                  "col-md-1": true,
                  " has-error": this.errors.inputQuantidade
                },
                staticStyle: {
                  "padding-right": "0 !important",
                  "padding-left": "0 !important"
                }
              },
              [
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model.number",
                      value: _vm.quantidade,
                      expression: "quantidade",
                      modifiers: { number: true }
                    }
                  ],
                  ref: "inputQuantidade",
                  staticClass: "form-control",
                  attrs: {
                    disabled: _vm.estoqueId == "false" || _vm.estoqueId == null,
                    type: "number",
                    min: "0,000",
                    max: "9999999999,999",
                    step: "any",
                    name: "inputQuantidade",
                    id: "inputQuantidade"
                  },
                  domProps: { value: _vm.quantidade },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.quantidade = _vm._n($event.target.value)
                    },
                    blur: function($event) {
                      _vm.$forceUpdate()
                    }
                  }
                }),
                _vm._v(" "),
                _c(
                  "span",
                  {
                    staticClass: "help-block",
                    attrs: { "v-if": this.errors.inputQuantidade }
                  },
                  [
                    _c("strong", [
                      _vm._v(_vm._s(this.errors.inputQuantidadeMsg))
                    ])
                  ]
                )
              ]
            ),
            _vm._v(" "),
            _c(
              "div",
              {
                class: {
                  "col-md-1": true,
                  " has-error": this.errors.inputValorUnitario
                },
                staticStyle: {
                  "padding-right": "0 !important",
                  "padding-left": "0 !important"
                }
              },
              [
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model.number",
                      value: _vm.valorUnitario,
                      expression: "valorUnitario",
                      modifiers: { number: true }
                    }
                  ],
                  ref: "inputValorUnitario",
                  staticClass: "form-control",
                  attrs: {
                    disabled: _vm.estoqueId == "false" || _vm.estoqueId == null,
                    type: "number",
                    min: "0,000",
                    max: "9999999999,999",
                    step: "any",
                    name: "inputValorUnitario",
                    id: "inputValorUnitario",
                    readonly: ""
                  },
                  domProps: { value: _vm.valorUnitario },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.valorUnitario = _vm._n($event.target.value)
                    },
                    blur: function($event) {
                      _vm.$forceUpdate()
                    }
                  }
                }),
                _vm._v(" "),
                _c(
                  "span",
                  {
                    staticClass: "help-block",
                    attrs: { "v-if": this.errors.inputValorUnitario }
                  },
                  [
                    _c("strong", [
                      _vm._v(_vm._s(this.errors.inputValorUnitarioMsg))
                    ])
                  ]
                )
              ]
            ),
            _vm._v(" "),
            _c(
              "div",
              {
                class: {
                  "col-md-1": true,
                  " has-error": this.errors.inputDesconto
                },
                staticStyle: {
                  "padding-right": "0 !important",
                  "padding-left": "0 !important"
                }
              },
              [
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model.number",
                      value: _vm.desconto,
                      expression: "desconto",
                      modifiers: { number: true }
                    }
                  ],
                  ref: "inputDesconto",
                  staticClass: "form-control",
                  attrs: {
                    disabled: _vm.estoqueId == "false" || _vm.estoqueId == null,
                    type: "number",
                    min: "0,000",
                    max: "9999999999,999",
                    step: "any",
                    name: "inputDesconto",
                    id: "inputDesconto"
                  },
                  domProps: { value: _vm.desconto },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.desconto = _vm._n($event.target.value)
                    },
                    blur: function($event) {
                      _vm.$forceUpdate()
                    }
                  }
                }),
                _vm._v(" "),
                _c(
                  "span",
                  {
                    staticClass: "help-block",
                    attrs: { "v-if": this.errors.inputDesconto }
                  },
                  [_c("strong", [_vm._v(_vm._s(this.errors.inputDescontoMsg))])]
                )
              ]
            ),
            _vm._v(" "),
            _c(
              "div",
              {
                class: {
                  "col-md-1": true,
                  " has-error": this.errors.inputAcrescimo
                },
                staticStyle: {
                  "padding-right": "0 !important",
                  "padding-left": "0 !important"
                }
              },
              [
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model.number",
                      value: _vm.acrescimo,
                      expression: "acrescimo",
                      modifiers: { number: true }
                    }
                  ],
                  ref: "inputAcrescimo",
                  staticClass: "form-control",
                  attrs: {
                    disabled: _vm.estoqueId == "false" || _vm.estoqueId == null,
                    type: "number",
                    min: "0,000",
                    max: "9999999999,999",
                    step: "any",
                    name: "inputAcrescimo",
                    id: "inputAcrescimo"
                  },
                  domProps: { value: _vm.acrescimo },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.acrescimo = _vm._n($event.target.value)
                    },
                    blur: function($event) {
                      _vm.$forceUpdate()
                    }
                  }
                }),
                _vm._v(" "),
                _c(
                  "span",
                  {
                    staticClass: "help-block",
                    attrs: { "v-if": this.errors.inputAcrescimo }
                  },
                  [
                    _c("strong", [
                      _vm._v(_vm._s(this.errors.inputAcrescimoMsg))
                    ])
                  ]
                )
              ]
            ),
            _vm._v(" "),
            _c(
              "div",
              {
                class: {
                  "col-md-1": true,
                  " has-error": this.errors.inputValorCobrado
                },
                staticStyle: {
                  "padding-right": "0 !important",
                  "padding-left": "0 !important"
                }
              },
              [
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model.number",
                      value: _vm.valor_cobrado,
                      expression: "valor_cobrado",
                      modifiers: { number: true }
                    }
                  ],
                  ref: "inputValorCobrado",
                  staticClass: "form-control",
                  attrs: {
                    disabled: _vm.estoqueId == "false" || _vm.estoqueId == null,
                    type: "number",
                    min: "0,000",
                    max: "9999999999,999",
                    step: "any",
                    name: "inputValorCobrado",
                    id: "inputValorCobrado",
                    readonly: ""
                  },
                  domProps: { value: _vm.valor_cobrado },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.valor_cobrado = _vm._n($event.target.value)
                    },
                    blur: function($event) {
                      _vm.$forceUpdate()
                    }
                  }
                }),
                _vm._v(" "),
                _c(
                  "span",
                  {
                    staticClass: "help-block",
                    attrs: { "v-if": this.errors.inputValorCobrado }
                  },
                  [
                    _c("strong", [
                      _vm._v(_vm._s(this.errors.inputValorCobradoMsg))
                    ])
                  ]
                )
              ]
            ),
            _vm._v(" "),
            _c("div", { staticClass: "col-md-1" }, [
              _c(
                "button",
                {
                  directives: [
                    {
                      name: "show",
                      rawName: "v-show",
                      value: !_vm.editing,
                      expression: "!editing"
                    }
                  ],
                  staticClass: "btn btn-success",
                  attrs: {
                    disabled: _vm.estoqueId == "false" || _vm.estoqueId == null,
                    type: "button"
                  },
                  on: { click: _vm.addProduto }
                },
                [_c("span", { staticClass: "glyphicon glyphicon-plus" })]
              ),
              _vm._v(" "),
              _c(
                "button",
                {
                  directives: [
                    {
                      name: "show",
                      rawName: "v-show",
                      value: _vm.editing,
                      expression: "editing"
                    }
                  ],
                  staticClass: "btn btn-success",
                  attrs: {
                    disabled: _vm.estoqueId == "false" || _vm.estoqueId == null,
                    type: "button"
                  },
                  on: { click: _vm.updateProduto }
                },
                [_c("span", { staticClass: "glyphicon glyphicon-ok" })]
              )
            ])
          ])
        ]),
        _vm._v(" "),
        _c("modal2", {
          attrs: {
            "modal-title": "Corfirmação",
            "modal-text": "Confirma a remoção deste Item?"
          },
          on: { cancel2: _vm.cancelDelete, confirm2: _vm.deleteProduto }
        })
      ],
      1
    )
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "panel-heading" }, [
      _c("strong", [_vm._v("Produtos")])
    ])
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("thead", [
      _c("tr", { staticClass: "primary" }, [
        _c("th", { staticClass: "col-md-1" }, [_vm._v("Id")]),
        _vm._v(" "),
        _c("th", { staticClass: "col-md-5" }, [_vm._v("Produto")]),
        _vm._v(" "),
        _c("th", { staticClass: "col-md-1" }, [_vm._v("Qtd")]),
        _vm._v(" "),
        _c("th", { staticClass: "col-md-1" }, [_vm._v("R$ Un.")]),
        _vm._v(" "),
        _c("th", { staticClass: "col-md-1" }, [_vm._v("R$ Acrés.")]),
        _vm._v(" "),
        _c("th", { staticClass: "col-md-1" }, [_vm._v("R$ Desc.")]),
        _vm._v(" "),
        _c("th", { staticClass: "col-md-1" }, [_vm._v("R$ Final")]),
        _vm._v(" "),
        _c("th", { staticClass: "col-md-1" }, [_vm._v("Ações")])
      ])
    ])
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-15e6fa7f", module.exports)
  }
}

/***/ }),

/***/ 200:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(201);


/***/ }),

/***/ 201:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__components_OsComponent_vue__ = __webpack_require__(202);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__components_OsComponent_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__components_OsComponent_vue__);


var os = new Vue({
    el: '#ordem_servico',
    components: {
        ordemServico: __WEBPACK_IMPORTED_MODULE_0__components_OsComponent_vue___default.a
    }
});

/***/ }),

/***/ 202:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(203)
/* template */
var __vue_template__ = __webpack_require__(204)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/assets/js/components/OsComponent.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-e2c4c2dc", Component.options)
  } else {
    hotAPI.reload("data-v-e2c4c2dc", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 203:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__OsServicoComponent_vue__ = __webpack_require__(9);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__OsServicoComponent_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__OsServicoComponent_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__OsProdutoComponent_vue__ = __webpack_require__(12);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__OsProdutoComponent_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__OsProdutoComponent_vue__);
//
//
//
//
//
//
//
//
//
//
//
//



/* harmony default export */ __webpack_exports__["default"] = ({
    name: 'ordem-servico',
    components: {
        ordemServicoServico: __WEBPACK_IMPORTED_MODULE_0__OsServicoComponent_vue___default.a,
        ordemServicoProduto: __WEBPACK_IMPORTED_MODULE_1__OsProdutoComponent_vue___default.a
    },
    props: ['servicosData', 'oldServicosData', 'estoques', 'oldEstoqueId', 'oldProdutosData'],
    data: function data() {
        return {
            valor_total_produtos: 0,
            valor_total_servicos: 0
        };
    },

    methods: {
        updateTotalServicos: function updateTotalServicos(value) {
            console.log('updateTotalServicos: ' + value);
            this.valor_total_servicos = value;
        },
        updateTotalProdutos: function updateTotalProdutos(value) {
            console.log('updateTotalProdutos: ' + value);
            this.valor_total_produtos = value;
        }
    },
    computed: {
        valor_total_os: {
            get: function get() {
                /* var formatter = new Intl.NumberFormat('pt-BR', {
                    minimumFractionDigits: 3
                });
                return formatter.format(this.valor_total_produtos + this.valor_total_servicos); */
                return parseFloat(this.valor_total_produtos + this.valor_total_servicos);
            }
        }
    }

});

/***/ }),

/***/ 204:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _c("ordem-servico-servico", {
        attrs: {
          "servicos-data": _vm.servicosData,
          "old-data": _vm.oldServicosData
        },
        on: { updateTotalServ: _vm.updateTotalServicos }
      }),
      _vm._v(" "),
      _c("ordem-servico-produto", {
        attrs: {
          estoques: _vm.estoques,
          "old-estoque-id": _vm.oldEstoqueId,
          "old-data": _vm.oldProdutosData
        },
        on: { updateTotalProd: _vm.updateTotalProdutos }
      }),
      _vm._v(" "),
      _c(
        "div",
        {
          staticClass: "col col-sm-4 pull-right",
          staticStyle: { padding: "0px !important" }
        },
        [
          _c(
            "label",
            {
              staticClass: "control-label",
              attrs: { for: "inputValorTotalOs" }
            },
            [_vm._v("Valor Total")]
          ),
          _vm._v(" "),
          _c("div", { staticClass: "form-control" }, [
            _vm._v(_vm._s(_vm._f("toDecimal3")(_vm.valor_total_os)))
          ]),
          _vm._v(" "),
          _c("input", {
            directives: [
              {
                name: "model",
                rawName: "v-model",
                value: _vm.valor_total_os,
                expression: "valor_total_os"
              }
            ],
            ref: "inputValorTotalOs",
            staticClass: "form-control",
            attrs: {
              type: "hidden",
              name: "valor_total",
              id: "valor_total",
              readonly: ""
            },
            domProps: { value: _vm.valor_total_os },
            on: {
              input: function($event) {
                if ($event.target.composing) {
                  return
                }
                _vm.valor_total_os = $event.target.value
              }
            }
          })
        ]
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-e2c4c2dc", module.exports)
  }
}

/***/ }),

/***/ 4:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(5)
/* template */
var __vue_template__ = __webpack_require__(6)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/assets/js/components/modal.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-514744a6", Component.options)
  } else {
    hotAPI.reload("data-v-514744a6", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 5:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'modal',

  methods: {
    cancel: function cancel() {
      this.$emit(this._eventCancel);
    },
    confirm: function confirm() {
      this.$emit(this._eventConfirm);
    }
  },
  props: ['modalTitle', 'modalText', 'eventCancel', 'eventConfirm'],
  computed: {
    _eventCancel: {
      get: function get() {
        if (this.eventCancel == undefined) {
          return 'cancel';
        } else {
          return this.eventCancel;
        }
      }
    },
    _eventConfirm: {
      get: function get() {
        if (this.eventConfirm == undefined) {
          return 'confirm';
        } else {
          return this.eventConfirm;
        }
      }
    }
  },
  mounted: function mounted() {
    //
  }
});

/***/ }),

/***/ 6:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("transition", { attrs: { name: "modal-fade" } }, [
    _c(
      "div",
      {
        staticClass: "modal fade",
        attrs: {
          id: "confirmDelete",
          role: "dialog",
          "aria-labelledby": "confirmDeleteLabel",
          "aria-hidden": "true"
        }
      },
      [
        _c("div", { staticClass: "modal-dialog" }, [
          _c("div", { staticClass: "modal-content modal-default" }, [
            _c("div", { staticClass: "modal-header" }, [
              _c(
                "button",
                {
                  staticClass: "close",
                  attrs: {
                    type: "button",
                    "data-dismiss": "modal",
                    "aria-hidden": "true"
                  }
                },
                [_vm._v("×")]
              ),
              _vm._v(" "),
              _c("div", { staticClass: "row" }, [
                _c("div", { staticClass: "col-sm-1" }, [
                  _c("span", { staticClass: "glyphicon glyphicon-alert" })
                ]),
                _vm._v(" "),
                _c("div", { staticClass: "col" }, [
                  _c("h4", { staticClass: "modal-title" }, [
                    _c("strong", [_vm._v(_vm._s(this.modalTitle))])
                  ])
                ])
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "modal-body" }, [
              _c("p", [
                _vm._v(
                  "\n              " +
                    _vm._s(this.modalText) +
                    "                  \n            "
                )
              ])
            ]),
            _vm._v(" "),
            _c("div", { staticClass: "modal-footer" }, [
              _c(
                "button",
                {
                  staticClass: "btn btn-danger",
                  attrs: {
                    type: "button",
                    "data-dismiss": "modal",
                    id: "confirm"
                  },
                  on: { click: _vm.confirm }
                },
                [_vm._v("Remover")]
              ),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass: "btn btn-primary",
                  attrs: { type: "button", "data-dismiss": "modal" },
                  on: { click: _vm.cancel }
                },
                [_vm._v("Cancelar")]
              )
            ])
          ])
        ])
      ]
    )
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-514744a6", module.exports)
  }
}

/***/ }),

/***/ 9:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(10)
/* template */
var __vue_template__ = __webpack_require__(11)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/assets/js/components/OsServicoComponent.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-6b37570e", Component.options)
  } else {
    hotAPI.reload("data-v-6b37570e", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ })

},[200]);