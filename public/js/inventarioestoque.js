webpackJsonp([7],{

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

/***/ 188:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(189);


/***/ }),

/***/ 189:
/***/ (function(module, exports, __webpack_require__) {

var inventario_estoque = __webpack_require__(190);

var leads = new Vue({
    el: '#inventario_estoque_items',
    components: {
        inventario_estoque: inventario_estoque
    }
});

/***/ }),

/***/ 190:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(191)
/* template */
var __vue_template__ = __webpack_require__(192)
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
Component.options.__file = "resources/assets/js/components/InventarioItemsComponent.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-d79331b6", Component.options)
  } else {
    hotAPI.reload("data-v-d79331b6", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 191:
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
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    name: 'inventario_estoque',
    components: {},
    data: function data() {
        return {
            items: []
        };
    },

    props: ['itemsData'],
    mounted: function mounted() {
        this.items = this.itemsData;
    }
});

/***/ }),

/***/ 192:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "panel panel-default" }, [
    _vm._m(0),
    _vm._v(" "),
    _c(
      "div",
      {
        staticClass: "panel-body",
        staticStyle: { padding: "0px 15px !important" }
      },
      _vm._l(_vm.items, function(item, index) {
        return _c(
          "div",
          {
            key: index,
            class: ["row", index % 2 === 0 ? "bg-info" : "bg-warning"]
          },
          [
            _c(
              "div",
              {
                staticClass: "col col-xs-1 col-sm-1 col-md-1",
                staticStyle: { "padding-top": "3px" }
              },
              [_vm._v(_vm._s(item.produto.id))]
            ),
            _vm._v(" "),
            _c(
              "div",
              {
                staticClass: "col col-xs-7 col-sm-7 col-md-9",
                staticStyle: { "padding-top": "3px" }
              },
              [_vm._v(_vm._s(item.produto.produto_descricao))]
            ),
            _vm._v(" "),
            _c("div", { staticClass: "col col-xs-4 col-sm-4 col-md-2" }, [
              _c("input", {
                staticClass: "form-control input-sm",
                attrs: {
                  type: "text",
                  name: "items[" + item.id + "][qtd_contada]",
                  readonly: item.ajustado == 1
                }
              })
            ])
          ]
        )
      })
    )
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "panel-heading" }, [
      _c("div", { staticClass: "row" }, [
        _c("div", { staticClass: "col col-xs-1 col-sm-1 col-md-1" }, [
          _vm._v("ID")
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "col col-xs-7 col-sm-7 col-md-9" }, [
          _vm._v("Produto")
        ]),
        _vm._v(" "),
        _c("div", { staticClass: "col col-xs-4 col-sm-4 col-md-2" }, [
          _vm._v("Qtd Contada")
        ])
      ])
    ])
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-d79331b6", module.exports)
  }
}

/***/ })

},[188]);