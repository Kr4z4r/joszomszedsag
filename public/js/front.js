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

/***/ "./resources/js/front.js":
/*!*******************************!*\
  !*** ./resources/js/front.js ***!
  \*******************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  $(document).on('keyup', 'input#postcode.autocomplete, input[id^="area_postcode"].autocomplete', function (e) {
    if (e.which <= 40 && e.which >= 37 || e.which === 13) {
      return;
    }

    var _this = $(this);

    if (!$(this).hasClass('invalid')) {
      $(this).addClass('invalid');
    }

    var ajaxResponse = '',
        parsed = '',
        ac_post_codes = {};

    _this.autocomplete({
      onAutocomplete: function onAutocomplete(elem) {
        var city_name = parsed.map(function (obj) {
          if (parseInt(obj['post_code']) === parseInt(elem)) {
            return obj.name;
          }
        }).filter(function (elem) {
          return elem !== undefined;
        });

        var $parentRow = _this.parent('.input-field').parent('.row, .area-input-group');

        var $cityField = $parentRow.find('input#city, input[id^="area_city"]');

        if (city_name.length === 1) {
          $cityField.val(city_name[0]).addClass('valid');
          $parentRow.find('input#street, input[id^="area_street"]').attr('disabled', false);
          $cityField.attr('disabled', false);
        } else if (city_name.length > 1) {
          var cityNamesObj = {};

          for (var key in city_name) {
            cityNamesObj[city_name[key]] = null;
          }

          $cityField.attr('disabled', false);
          $cityField.addClass('invalid');
          $cityField.val('');
          $cityField.autocomplete({
            data: cityNamesObj,
            onAutocomplete: function onAutocomplete() {
              $cityField.addClass('valid');
              $cityField.removeClass('invalid');
              $parentRow.find('input#street, input[id^="area_street"]').attr('disabled', false);
            }
          });
        }

        _this.addClass('valid');

        _this.removeClass('invalid');

        M.updateTextFields();
      }
    });

    $.ajax({
      beforeSend: function beforeSend(jqXHR, settings) {
        jqXHR.setRequestHeader('X-CSRF-TOKEN', $('meta[name="token"]').attr('content'));
      },
      type: "POST",
      url: '/postcode-autocomplete',
      // This is what I have updated
      data: {
        post_code: _this.val()
      }
    }).done(function (response) {
      ajaxResponse = response;
      parsed = JSON.parse(ajaxResponse);
      ac_post_codes = {};

      for (var key in parsed) {
        if (parsed.hasOwnProperty(key)) {
          ac_post_codes[parsed[key]['post_code']] = null;
        }
      }

      var instance = M.Autocomplete.getInstance(_this);
      instance.updateData(ac_post_codes);
      instance.open();
    });
  }); // Autocomplete for street names

  var streetAutocomplete = function streetAutocomplete(element) {
    try {
      var promise = axios.get('https://nominatim.openstreetmap.org/search?accept-language=hu,en', {
        params: {
          format: 'json',
          city: element.parent('.input-field').prev('.input-field').find('input').val(),
          street: '1 ' + element.val(),
          addressdetails: 1
        }
      }).then(function (response) {
        var helperObj = {};
        Object.keys(response.data).forEach(function (elem) {
          if (helperObj[response.data[elem].address.road] !== 'undefined') {
            helperObj[response.data[elem].address.road] = null;
          }
        });
        element.autocomplete({
          data: helperObj,
          onAutocomplete: function onAutocomplete() {
            element.addClass('valid');
            element.removeClass('invalid');
            var clickedId = element.attr('id').split('_');

            if (clickedId[0] === 'area') {
              var parentRow = element.parents('.area-input-group').parent('.row');
              var inputGroup = parentRow.find('.area-input-group:last-of-type');
              var lastStreetInput = inputGroup.find('input[id*="street"');
              var elemId = lastStreetInput.attr('id').split('_');
            }

            if (clickedId.length && clickedId[0] === 'area' && parseInt(elemId[2]) < 5 && elemId[2] === clickedId[2]) {
              parentRow.append('<div class="area-input-group row">' + inputGroup.html() + '</div>');
              var addedRow = parentRow.find('.area-input-group:last-of-type');
              inputGroup.find('input[id*="house-number"').attr('disabled', false);
              addedRow.find('input').each(function () {
                var idHelper = $(this).attr('id').split('_');
                idHelper[2] = parseInt(idHelper[2]) + 1;
                $(this).attr('id', idHelper.join('_'));
                $(this).parent().find('label').attr('for', idHelper.join('_'));

                if (idHelper[1] === 'street' || idHelper[1] === 'from-house-number') {
                  $(this).val('');

                  if (idHelper[1] === 'street') {
                    $(this).next('ul.autocomplete-content').hide();
                  }

                  $(this).attr('disabled', 'disabled');
                  $(this).removeClass('valid');
                } else if (idHelper[1] === 'postcode') {
                  $(this).removeClass('valid');
                } else {
                  $(this).attr('disabled', 'disabled');
                  $(this).removeClass('valid');
                }
              });
              var idHelper = parseInt(elemId[2]);
              addedRow.find('span[id^=delete_area_address_]').attr('id', 'delete_area_address_' + ++idHelper).show();
            } else {
              var _parentRow = element.parent('.input-field').parent('.row');

              _parentRow.find('input[id="house_number"').attr('disabled', false);
            }
          }
        });
        var instance = M.Autocomplete.getInstance(element);
        instance.open();
      });
    } catch (error) {
      console.error(error);
    }
  };

  var timeout = null;
  $(document).on('keyup', 'input#street, input[id^="area_street_"]', function (e) {
    if (e.which <= 40 && e.which >= 37 || e.which === 13) {
      return;
    }

    if (!$(this).hasClass('invalid')) {
      $(this).addClass('invalid');
    }

    var element = $(this);
    clearTimeout(timeout);
    timeout = setTimeout(function () {
      streetAutocomplete(element);
    }, 500);
  });
  $(document).on('keyup', 'input#house_number, input[id^="area_from-house-number_"], input[id^="area_to-house-number_"]', function () {
    if (validateHouseNumber($(this).val())) {
      if ($(this).hasClass('invalid') || !$(this).hasClass('invalid') && !$(this).hasClass('valid')) {
        $(this).addClass('valid');
        $(this).removeClass('invalid');
      }
    } else {
      if (!$(this).hasClass('invalid') && $(this).hasClass('valid') || !$(this).hasClass('invalid') && !$(this).hasClass('valid')) {
        $(this).addClass('invalid');
        $(this).removeClass('valid');
      }
    }
  });
  $(document).on('click', 'span[id^="delete_area_address_"]', function () {
    var $parentGroup = $(this).parents('.area-input-group');

    if ($parentGroup.find('input[id^="area_street_"]').val().length > 0) {
      if ($parentGroup.is(':last-of-type')) {
        $parentGroup.find('input').each(function () {
          var idHelper = $(this).attr('id').split('_');

          if (idHelper[1] === 'street' || idHelper[1] === 'from-house-number') {
            $(this).val('');
            $(this).attr('disabled', 'disabled');
            $(this).removeClass('invalid');

            if (idHelper[1] === 'street') {
              $(this).next('ul.autocomplete-content').hide();
            }

            $(this).attr('disabled', 'disabled');
            $(this).removeClass('valid');
          } else if (idHelper[1] === 'postcode') {
            $(this).val('');
            $(this).removeClass('valid');
          } else {
            $(this).attr('disabled', 'disabled');
            $(this).removeClass('valid');
            $(this).val('');
          }
        });
      } else {
        $parentGroup.remove();
      }
    }
  }); // Select from and to time in the volunteer form

  $('.timepicker').timepicker({
    twelveHour: false,
    i18n: {
      cancel: 'Mégse',
      clear: 'Törlés',
      done: 'Ok'
    }
  }); // Select initiation

  $('select').formSelect(); // Validation

  $(document).on('change', 'input[name="has_corona"], input[name="in_quarantine"], input[name="has_chronic"]', function () {
    if ($(this).prop('checked') === true) {
      if ($('input[name="is_healthy"]').attr('disabled') !== true) {
        $('input[name="is_healthy"]').attr('disabled', true);
      }
    } else {
      if ($('input[name="is_healthy"]').attr('disabled') !== false && $(this).parents('form').find('input[type="checkbox"]:checked').length === 0) {
        $('input[name="is_healthy"]').attr('disabled', false);
      }
    }
  });
  $(document).on('change', 'input[name="is_healthy"]', function () {
    if ($(this).prop('checked') === true) {
      $('input[name="has_corona"], input[name="in_quarantine"], input[name="has_chronic"]').attr('disabled', true);
    } else {
      $('input[name="has_corona"], input[name="in_quarantine"], input[name="has_chronic"]').attr('disabled', false);
    }
  }); // Help Request form validation

  $(document).on('submit', 'form#helprequest_reg_form', function (e) {
    var error = [],
        selectErr = false;

    if ($(this).find('input.invalid').length > 0) {
      error.push('Kérem töltse ki a pirossal aláhúzott mezőket!');
    }

    $(this).find('select').each(function () {
      if ($(this).val() === null || $(this).val().length === 0) {
        selectErr = true;
      }
    });

    if (selectErr === true) {
      error.push('Kérem ellenőrizze hogy megadta-e születési évét és segítségkérésének okát!');
    }

    if ($(this).find('input[name="phone"]') && !validatePhoneNumber($(this).find('input[name="phone"]').val())) {
      error.push('Kérem adjon meg egy érvényes telefonszámot');
    }

    if ($(this).find('input[name="has_corona"]:checked, input[name="in_quarantine"]:checked, input[name="has_chronic"]:checked, input[name="is_healthy"]:checked').length === 0) {
      error.push('Kérem válassza ki az egészségi státuszát!');
    }

    if (error.length > 0) {
      e.preventDefault();
      var formElement = $(this);
      formElement.find('.form-errors ul').html('');
      $.each(error, function (index, data) {
        formElement.find('.form-errors ul').append('<li>' + data + '</li>');
      });
      $('html, body').animate({
        scrollTop: $(this).offset().top
      }, 250);
    }
  }); // Volunteer registration form validation

  $(document).on('submit', 'form#volunteer_reg_form', function (e) {
    var error = [];

    if ($(this).find('input.invalid').length > 0) {
      error.push('Kérem töltse ki a pirossal aláhúzott mezőket!');
    }

    if ($(this).find('select#birth_year').val() === null) {
      error.push('Kérem adja meg születési évét!');
    } else if (parseInt($(this).find('select#birth_year').val())) if ($(this).find('input[name^="area_street"]').val().length === 0) {
      error.push('Kérem adjon meg legalább egy utcát a vállalt körzetében!');
    }

    if (error.length > 0) {
      e.preventDefault();
      var formElement = $(this);
      formElement.find('.form-errors ul').html('');
      $.each(error, function (index, data) {
        formElement.find('.form-errors ul').append('<li>' + data + '</li>');
      });
      $('html, body').animate({
        scrollTop: $(this).offset().top
      }, 250);
    }
  }); // Mobile menu initialization

  $('.sidenav').sidenav();
  $(document).on('click', 'nav a.sidenav-trigger', function () {
    $(this).toggleClass('active');
    $('.sidenav').toggleClass('sidenav-close');
  });
  $(document).on('click', 'nav a.sidenav-trigger.active', function () {
    $(this).toggleClass('active');
    $('.sidenav').toggleClass('sidenav-close');
    $('.sidenav').sidenav('close');
  }); // Textarea character counter initialization

  $('textarea#situation_desc').characterCounter();

  if ($(this).scrollTop() > 100) {
    $('#toTop').fadeIn();
  } else {
    $('#toTop').fadeOut();
  }

  $(window).scroll(function () {
    if ($(this).scrollTop() > 100) {
      $('#toTop').fadeIn();
    } else {
      $('#toTop').fadeOut();
    }
  });
  $(document).on('click', '#toTop', function () {
    $('html, body').animate({
      scrollTop: 0
    }, 800);
    return false;
  });

  function validatePhoneNumber(phone_number) {
    var regex = /((?:\+?3|0)6)(?:-|\()?(\d{1,2})(?:-|\))?(\d{3})-?(\d{3,4})/i;
    console.log(new RegExp(regex).test(phone_number));
    return new RegExp(regex).test(phone_number);
  }

  function validateHouseNumber(house_number) {
    var regex = /(^[0-9]+)(\/[0-9]*[A-z])*\.?/g;
    return new RegExp(regex).test(house_number);
  }
});
$(window).on('load', function () {
  window.setTimeout(function () {
    $('.preloader').fadeOut(500);
  }, 500);
});

/***/ }),

/***/ 2:
/*!*************************************!*\
  !*** multi ./resources/js/front.js ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/resources/js/front.js */"./resources/js/front.js");


/***/ })

/******/ });