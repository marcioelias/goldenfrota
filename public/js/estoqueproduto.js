webpackJsonp([6],{

/***/ 174:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(191);


/***/ }),

/***/ 191:
/***/ (function(module, exports, __webpack_require__) {

var estoque_produto = __webpack_require__(192);

var leads = new Vue({
    el: '#estoqueProdutoComponent',
    components: {
        estoque_produto: estoque_produto
    }
});

/***/ }),

/***/ 192:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(3)
/* script */
var __vue_script__ = __webpack_require__(193)
/* template */
var __vue_template__ = __webpack_require__(194)
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/assets/js/components/EstoqueProdutoComponent.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] EstoqueProdutoComponent.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-3015726c", Component.options)
  } else {
    hotAPI.reload("data-v-3015726c", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 193:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* WEBPACK VAR INJECTION */(function($) {/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__modal_vue__ = __webpack_require__(5);
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



/* harmony default export */ __webpack_exports__["default"] = ({
    name: 'estoque_produto',
    components: {
        modal: __WEBPACK_IMPORTED_MODULE_0__modal_vue___default.a
    },
    data: function data() {
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
                inputEstoqueMinimoMsg: ''
            }
        };
    },

    props: ['estoquesData', 'oldData'],
    watch: {
        oldData: function oldData() {
            this.$refs.confirmDelete;
        }
    },
    computed: {
        estoquesDisponiveisOrdenados: function estoquesDisponiveisOrdenados() {
            function compare(a, b) {
                if (a.estoque < b.estoque) return -1;
                if (a.estoque > b.estoque) return 1;
                return 0;
            }

            return this.estoquesDisponiveis.sort(compare);
        }
    },
    mounted: function mounted() {
        this.estoquesDisponiveis = this.estoquesData;
        if (this.oldData !== null) {
            for (var i = 0; i < this.oldData.length; i++) {
                this.estoques.push({
                    'id': this.oldData[i].estoque_id,
                    'estoque': this.getEstoqueById(this.oldData[i].estoque_id).estoque,
                    'estoque_minimo': Number(this.oldData[i].estoque_minimo)
                });
                this.incluirEstoque(this.oldData[i].estoque_id);
            }
        }
    },
    updated: function updated() {
        $(this.$refs.inputEstoques).selectpicker('refresh');
    },

    methods: {
        validarItem: function validarItem() {
            if (this.estoque_id == '' || this.estoque_id <= 0) {
                this.errors.inputEstoques = true;
                this.errors.inputEstoquesMsg = 'Nenhum Estoque selecionado.';
                return false;
            } else {
                this.errors.inputEstoques = false;
                this.errors.inputEstoquesMsg = '';
            }

            if (this.estoque_minimo == '' || this.estoque_minimo < 0) {
                this.errors.inputEstoqueMinimo = true;
                this.errors.inputEstoqueMinimoMsg = 'Informe o estoque mínimo do produto.';
                return false;
            } else {
                this.errors.inputEstoqueMinimo = false;
                this.errors.inputEstoqueMinimoMsg = '';
            }
            return true;
        },
        confirmDelete: function confirmDelete(index) {
            this.deleteIndex = index;
        },
        cancelDelete: function cancelDelete(index) {
            this.deleteIndex = false;
        },
        addEstoque: function addEstoque() {
            if (this.validarItem()) {
                this.estoques.push({
                    'id': this.estoque_id,
                    'estoque': this.getEstoqueById(this.estoque_id).estoque,
                    'estoque_minimo': this.estoque_minimo
                });
                this.incluirEstoque(this.estoque_id);
                this.limparFormulario();
            }
        },
        editItem: function editItem(index) {
            var item = this.estoques[index];
            this.estoquesDisponiveis.push(this.getEstoqueSelecionadoById(item.id));
            this.estoque_minimo = item.estoque_minimo;
            this.estoque_id = item.id;
            this.editing = true;
            this.editingIndex = index;
        },
        updateEstoque: function updateEstoque() {
            this.estoques[this.editingIndex] = {
                'id': this.estoque_id,
                'estoque': this.getEstoqueById(this.estoque_id).estoque,
                'estoque_minimo': this.estoque_minimo
            };

            this.editing = false;
            this.editingIndex = false;
            this.incluirEstoque(this.estoque_id);
            this.limparFormulario();
        },
        deleteItem: function deleteItem() {
            this.removerEstoque(this.estoques[this.deleteIndex].id);
            this.$delete(this.estoques, this.deleteIndex);
        },
        limparFormulario: function limparFormulario() {
            this.produtoSelecionado = false;
            this.estoque_minimo = '';
            this.$refs.inputEstoques.focus();
        },
        getEstoqueById: function getEstoqueById(id) {
            var result = 0;
            for (var i = 0; i < this.estoquesData.length; i++) {
                if (this.estoquesData[i].id == id) {
                    result = this.estoquesData[i];
                    break;
                }
            }
            return result;
        },
        getEstoqueIndexById: function getEstoqueIndexById(id) {
            var result = 0;
            for (var i = 0; i < this.estoquesData.length; i++) {
                if (this.estoquesData[i].id == id) {
                    result = i;
                    break;
                }
            }
            return result;
        },
        getEstoqueSelecionadoById: function getEstoqueSelecionadoById(id) {
            var result = 0;
            for (var i = 0; i < this.estoquesSelecionados.length; i++) {
                if (this.estoquesSelecionados[i].id == id) {
                    result = this.estoquesSelecionados[i];
                    break;
                }
            }
            return result;
        },
        getEstoqueSelecionadoIndexById: function getEstoqueSelecionadoIndexById(id) {
            var result = 0;
            for (var i = 0; i < this.estoquesSelecionados.length; i++) {
                if (this.estoquesSelecionados[i].id == id) {
                    result = i;
                    break;
                }
            }
            return result;
        },
        incluirEstoque: function incluirEstoque(id) {
            this.estoquesSelecionados.push(this.getEstoqueById(id));
            this.$delete(this.estoquesDisponiveis, this.getEstoqueIndexById(id));
        },
        removerEstoque: function removerEstoque(id) {
            this.estoquesDisponiveis.push(this.getEstoqueSelecionadoById(id));
            this.$delete(this.estoquesSelecionados, this.getEstoqueSelecionadoIndexById(id));
        }
    }
});
/* WEBPACK VAR INJECTION */}.call(__webpack_exports__, __webpack_require__(2)))

/***/ }),

/***/ 194:
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
                _vm._l(_vm.estoques, function(item, index) {
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
                          name: "estoques[" + index + "][estoque_id]"
                        },
                        domProps: { value: item.id }
                      })
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "col-md-8" }, [
                      _vm._v(
                        "\n                        " +
                          _vm._s(item.estoque) +
                          "\n                    "
                      )
                    ]),
                    _vm._v(" "),
                    _c("td", { staticClass: "col-md-2 text-right" }, [
                      _vm._v(
                        "\n                        " +
                          _vm._s(item.estoque_minimo) +
                          "\n                        "
                      ),
                      _c("input", {
                        attrs: {
                          type: "hidden",
                          name: "estoques[" + index + "][estoque_minimo]"
                        },
                        domProps: { value: item.estoque_minimo }
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
                "col-md-9": true,
                " has-error": this.errors.inputEstoques
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
                      value: _vm.estoque_id,
                      expression: "estoque_id"
                    }
                  ],
                  ref: "inputEstoques",
                  staticClass: "form-control selectpicker",
                  attrs: {
                    "data-live-search": "true",
                    name: "inputEstoques",
                    id: "inputEstoques"
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
                      _vm.estoque_id = $event.target.multiple
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
                  _vm._l(_vm.estoquesDisponiveisOrdenados, function(
                    estoque,
                    index
                  ) {
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
                  attrs: { "v-if": this.errors.inputEstoques }
                },
                [_c("strong", [_vm._v(_vm._s(this.errors.inputEstoquesMsg))])]
              )
            ]
          ),
          _vm._v(" "),
          _c(
            "div",
            {
              class: {
                "col-md-2": true,
                " has-error": this.errors.inputEstoqueMinimo
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
                    value: _vm.estoque_minimo,
                    expression: "estoque_minimo",
                    modifiers: { number: true }
                  }
                ],
                ref: "inputEstoqueMinimo",
                staticClass: "form-control",
                attrs: {
                  type: "number",
                  min: "0,000",
                  max: "9999999999,999",
                  step: "any",
                  name: "inputEstoqueMinimo",
                  id: "inputEstoqueMinimo"
                },
                domProps: { value: _vm.estoque_minimo },
                on: {
                  input: function($event) {
                    if ($event.target.composing) {
                      return
                    }
                    _vm.estoque_minimo = _vm._n($event.target.value)
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
                  attrs: { "v-if": this.errors.inputEstoqueMinimo }
                },
                [
                  _c("strong", [
                    _vm._v(_vm._s(this.errors.inputEstoqueMinimoMsg))
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
                on: { click: _vm.addEstoque }
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
                on: { click: _vm.updateEstoque }
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
      _c("strong", [_vm._v("Estoques")])
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
        _c("th", { staticClass: "col-md-7" }, [_vm._v("Estoque")]),
        _vm._v(" "),
        _c("th", { staticClass: "col-md-2" }, [_vm._v("Est. Mínimo")]),
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
     require("vue-hot-reload-api").rerender("data-v-3015726c", module.exports)
  }
}

/***/ }),

/***/ 3:
/***/ (function(module, exports) {

/* globals __VUE_SSR_CONTEXT__ */

// this module is a runtime utility for cleaner component module output and will
// be included in the final webpack user bundle

module.exports = function normalizeComponent (
  rawScriptExports,
  compiledTemplate,
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

/***/ 5:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(3)
/* script */
var __vue_script__ = __webpack_require__(6)
/* template */
var __vue_template__ = __webpack_require__(7)
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/assets/js/components/modal.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key.substr(0, 2) !== "__"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] modal.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-ebcfa3c6", Component.options)
  } else {
    hotAPI.reload("data-v-ebcfa3c6", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 6:
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
      this.$emit('cancel');
    },
    confirm: function confirm() {
      this.$emit('confirm');
    }
  },
  props: ['modalTitle', 'modalText']
});

/***/ }),

/***/ 7:
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
     require("vue-hot-reload-api").rerender("data-v-ebcfa3c6", module.exports)
  }
}

/***/ })

},[174]);