/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/master.js":
/*!********************************!*\
  !*** ./resources/js/master.js ***!
  \********************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  // index city autocomplete
  $('#city', 'form[name="search_master_form"]').autocomplete({
    minLength: 3,
    source: function source(request, response) {
      $.ajax({
        url: '/ajax/cities',
        method: 'POST',
        dataType: 'json',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          city: request.term
        },
        success: function success(cities) {
          console.log(cities);
          response($.map(cities, function (city) {
            return {
              label: city.name + ', ' + city.county + ', ' + city.state,
              value: city.id
            };
          }));
        }
      });
    },
    focus: function focus(event, ui) {
      $('#city').val(ui.item.label);
    },
    select: function select(event, ui) {
      $('#city').val(ui.item.label);
      $('#city_id').val(ui.item.value);
      $('form[name="search_master_form"]').submit();
      return false;
    }
  });
  $.widget("custom.combobox", {
    options: {
      url: '/ajax/cities',
      disabled: false
    },
    _create: function _create() {
      this.wrapper = $("<span>").addClass("custom-combobox").insertAfter(this.element);
      this.element.hide();

      this._createAutocomplete();
    },
    _createAutocomplete: function _createAutocomplete() {
      this.input = $("<input>").appendTo(this.wrapper).attr("title", "").addClass("custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left").attr('disabled', this.options.disabled).autocomplete({
        delay: 0,
        minLength: 3,
        source: this.options._source ? this.options._source : $.proxy(this, "_source")
      }).tooltip({
        classes: {
          "ui-tooltip": "ui-state-highlight"
        }
      });

      this._on(this.input, {
        autocompleteselect: function autocompleteselect(event, ui) {
          var el = $('<option>').val(ui.item.value).text(ui.item.label);
          this.element.find('option').remove().end().append(el);

          this._trigger("select", event, {
            item: el
          });

          event.target.value = ui.item.label;
          $.ajax({
            url: '/ajax/streets',
            method: 'POST',
            dataType: 'json',
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
              city_id: ui.item.value
            }
          }).done(function (streets) {
            if (streets.length) {
              //console.log(streets);
              $('#street_id').data('custom-combobox').input.autocomplete('option', 'source', function (request, response) {
                var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
                response($.map(streets, function (street) {
                  if (street.name && (!request.term || matcher.test(street.name))) {
                    return {
                      label: street.name,
                      value: street.id
                    };
                  }
                }));
              }).autocomplete('option', 'select', function (event, ui) {
                var el = $('<option>').val(ui.item.value).text(ui.item.label);
                $('#street_id').find('option').remove().end().append(el);
                event.target.value = ui.item.label;
                return false;
              }).attr('disabled', false);
            }
          });
          return false;
        },
        autocompletechange: "_removeIfInvalid"
      });
    },
    _source: function _source(request, response) {
      $.ajax({
        url: this.options.url,
        method: 'POST',
        dataType: 'json',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          city: request.term
        },
        success: function success(cities) {
          /* $.each(cities, function(key, city) {
              console.log(city);
          }); */
          response($.map(cities, function (city) {
            return {
              label: city.name + ', ' + city.county + ', ' + city.state,
              value: city.id
            };
          }));
        }
      });
    },
    enable: function enable() {
      this.input.attr('disabled', false);
      return this;
    },
    _removeIfInvalid: function _removeIfInvalid(event, ui) {
      // Selected an item, nothing to do
      if (ui.item) {
        return;
      } // Search for a match (case-insensitive)


      var value = this.input.val(),
          valueLowerCase = value.toLowerCase(),
          valid = false;
      this.element.children("option").each(function () {
        if ($(this).text().toLowerCase() === valueLowerCase) {
          this.selected = valid = true;
          return false;
        }
      }); // Found a match, nothing to do

      if (valid) {
        return;
      } // Remove invalid value


      this.input.val("").attr("title", value + " didn't match any item").tooltip("open");
      this.element.val("");

      this._delay(function () {
        this.input.tooltip("close").attr("title", "");
      }, 2500);

      this.input.autocomplete("instance").term = "";
    },
    _destroy: function _destroy() {
      this.wrapper.remove();
      this.element.show();
    }
  });
  $('#city_id', 'form[name="create_new_advert"]').combobox();
  $('#street_id').combobox({
    'disabled': true
  });
});

/***/ }),

/***/ 2:
/*!**************************************!*\
  !*** multi ./resources/js/master.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/alez/resources/js/master.js */"./resources/js/master.js");


/***/ })

/******/ });