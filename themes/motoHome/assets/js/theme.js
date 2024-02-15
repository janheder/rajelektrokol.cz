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
/******/ 	// identity function for calling harmony imports with the correct context
/******/ 	__webpack_require__.i = function(value) { return value; };
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
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
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 30);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports) {

module.exports = jQuery;

/***/ }),
/* 1 */
/***/ (function(module, exports) {

module.exports = prestashop;

/***/ }),
/* 2 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/**
/**
 * 2007-2020 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */


Object.defineProperty(exports, '__esModule', {
  value: true
});

var _createClass = (function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ('value' in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; })();

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { 'default': obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError('Cannot call a class as a function'); } }

var _jquery = __webpack_require__(0);

var _jquery2 = _interopRequireDefault(_jquery);

var DropDown = (function () {
  function DropDown(el) {
    _classCallCheck(this, DropDown);

    this.el = el;
  }

  _createClass(DropDown, [{
    key: 'init',
    value: function init() {
      this.el.on('show.bs.dropdown', function (e, el) {
        if (el) {
          (0, _jquery2['default'])('#' + el).find('.dropdown-menu').first().stop(true, true).slideDown();
        } else {
          (0, _jquery2['default'])(e.target).find('.dropdown-menu').first().stop(true, true).slideDown();
        }
      });

      this.el.on('hide.bs.dropdown', function (e, el) {
        if (el) {
          (0, _jquery2['default'])('#' + el).find('.dropdown-menu').first().stop(true, true).slideUp();
        } else {
          (0, _jquery2['default'])(e.target).find('.dropdown-menu').first().stop(true, true).slideUp();
        }
      });

      (0, _jquery2['default'])('select.link').each(function () {
        (0, _jquery2['default'])('select.link').on('change', function () {
          window.location = (0, _jquery2['default'])(this).val();
        });
      });
    }
  }]);

  return DropDown;
})();

exports['default'] = DropDown;
module.exports = exports['default'];

/***/ }),
/* 3 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/**
 * 2007-2020 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
*/


Object.defineProperty(exports, '__esModule', {
  value: true
});

var _createClass = (function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ('value' in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; })();

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { 'default': obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError('Cannot call a class as a function'); } }

var _jquery = __webpack_require__(0);

var _jquery2 = _interopRequireDefault(_jquery);

var ProductMinitature = (function () {
  function ProductMinitature() {
    _classCallCheck(this, ProductMinitature);
  }

  _createClass(ProductMinitature, [{
    key: 'init',
    value: function init() {
      (0, _jquery2['default'])('.js-product-miniature').each(function (index, element) {

        if ((0, _jquery2['default'])(element).find('.color').length > 5) {
          (function () {
            var count = 0;

            (0, _jquery2['default'])(element).find('.color').each(function (index, element) {
              if (index > 4) {
                (0, _jquery2['default'])(element).hide();
                count++;
              }
            });

            (0, _jquery2['default'])(element).find('.js-count').append('+' + count);
          })();
        }
      });
    }
  }]);

  return ProductMinitature;
})();

exports['default'] = ProductMinitature;
module.exports = exports['default'];

/***/ }),
/* 4 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_RESULT__;/*! VelocityJS.org (1.5.2). (C) 2014 Julian Shapiro. MIT @license: en.wikipedia.org/wiki/MIT_License */ /*************************
 Velocity jQuery Shim
 *************************/ /*! VelocityJS.org jQuery Shim (1.0.1). (C) 2014 The jQuery Foundation. MIT @license: en.wikipedia.org/wiki/MIT_License. */ /* This file contains the jQuery functions that Velocity relies on, thereby removing Velocity's dependency on a full copy of jQuery, and allowing it to work in any environment. */ /* These shimmed functions are only used if jQuery isn't present. If both this shim and jQuery are loaded, Velocity defaults to jQuery proper. */(function(window){"use strict"; /***************
	 Setup
	 ***************/ /* If jQuery is already loaded, there's no point in loading this shim. */if(window.jQuery){return;} /* jQuery base. */var $=function $(selector,context){return new $.fn.init(selector,context);}; /********************
	 Private Methods
	 ********************/ /* jQuery */$.isWindow = function(obj){ /* jshint eqeqeq: false */return obj && obj === obj.window;}; /* jQuery */$.type = function(obj){if(!obj){return obj + "";}return typeof obj === "object" || typeof obj === "function"?class2type[toString.call(obj)] || "object":typeof obj;}; /* jQuery */$.isArray = Array.isArray || function(obj){return $.type(obj) === "array";}; /* jQuery */function isArraylike(obj){var length=obj.length,type=$.type(obj);if(type === "function" || $.isWindow(obj)){return false;}if(obj.nodeType === 1 && length){return true;}return type === "array" || length === 0 || typeof length === "number" && length > 0 && length - 1 in obj;} /***************
	 $ Methods
	 ***************/ /* jQuery: Support removed for IE<9. */$.isPlainObject = function(obj){var key;if(!obj || $.type(obj) !== "object" || obj.nodeType || $.isWindow(obj)){return false;}try{if(obj.constructor && !hasOwn.call(obj,"constructor") && !hasOwn.call(obj.constructor.prototype,"isPrototypeOf")){return false;}}catch(e) {return false;}for(key in obj) {}return key === undefined || hasOwn.call(obj,key);}; /* jQuery */$.each = function(obj,callback,args){var value,i=0,length=obj.length,isArray=isArraylike(obj);if(args){if(isArray){for(;i < length;i++) {value = callback.apply(obj[i],args);if(value === false){break;}}}else {for(i in obj) {if(!obj.hasOwnProperty(i)){continue;}value = callback.apply(obj[i],args);if(value === false){break;}}}}else {if(isArray){for(;i < length;i++) {value = callback.call(obj[i],i,obj[i]);if(value === false){break;}}}else {for(i in obj) {if(!obj.hasOwnProperty(i)){continue;}value = callback.call(obj[i],i,obj[i]);if(value === false){break;}}}}return obj;}; /* Custom */$.data = function(node,key,value){ /* $.getData() */if(value === undefined){var getId=node[$.expando],store=getId && cache[getId];if(key === undefined){return store;}else if(store){if(key in store){return store[key];}} /* $.setData() */}else if(key !== undefined){var setId=node[$.expando] || (node[$.expando] = ++$.uuid);cache[setId] = cache[setId] || {};cache[setId][key] = value;return value;}}; /* Custom */$.removeData = function(node,keys){var id=node[$.expando],store=id && cache[id];if(store){ // Cleanup the entire store if no keys are provided.
if(!keys){delete cache[id];}else {$.each(keys,function(_,key){delete store[key];});}}}; /* jQuery */$.extend = function(){var src,copyIsArray,copy,name,options,clone,target=arguments[0] || {},i=1,length=arguments.length,deep=false;if(typeof target === "boolean"){deep = target;target = arguments[i] || {};i++;}if(typeof target !== "object" && $.type(target) !== "function"){target = {};}if(i === length){target = this;i--;}for(;i < length;i++) {if(options = arguments[i]){for(name in options) {if(!options.hasOwnProperty(name)){continue;}src = target[name];copy = options[name];if(target === copy){continue;}if(deep && copy && ($.isPlainObject(copy) || (copyIsArray = $.isArray(copy)))){if(copyIsArray){copyIsArray = false;clone = src && $.isArray(src)?src:[];}else {clone = src && $.isPlainObject(src)?src:{};}target[name] = $.extend(deep,clone,copy);}else if(copy !== undefined){target[name] = copy;}}}}return target;}; /* jQuery 1.4.3 */$.queue = function(elem,type,data){function $makeArray(arr,results){var ret=results || [];if(arr){if(isArraylike(Object(arr))){ /* $.merge */(function(first,second){var len=+second.length,j=0,i=first.length;while(j < len) {first[i++] = second[j++];}if(len !== len){while(second[j] !== undefined) {first[i++] = second[j++];}}first.length = i;return first;})(ret,typeof arr === "string"?[arr]:arr);}else {[].push.call(ret,arr);}}return ret;}if(!elem){return;}type = (type || "fx") + "queue";var q=$.data(elem,type);if(!data){return q || [];}if(!q || $.isArray(data)){q = $.data(elem,type,$makeArray(data));}else {q.push(data);}return q;}; /* jQuery 1.4.3 */$.dequeue = function(elems,type){ /* Custom: Embed element iteration. */$.each(elems.nodeType?[elems]:elems,function(i,elem){type = type || "fx";var queue=$.queue(elem,type),fn=queue.shift();if(fn === "inprogress"){fn = queue.shift();}if(fn){if(type === "fx"){queue.unshift("inprogress");}fn.call(elem,function(){$.dequeue(elem,type);});}});}; /******************
	 $.fn Methods
	 ******************/ /* jQuery */$.fn = $.prototype = {init:function init(selector){ /* Just return the element wrapped inside an array; don't proceed with the actual jQuery node wrapping process. */if(selector.nodeType){this[0] = selector;return this;}else {throw new Error("Not a DOM node.");}},offset:function offset(){ /* jQuery altered code: Dropped disconnected DOM node checking. */var box=this[0].getBoundingClientRect?this[0].getBoundingClientRect():{top:0,left:0};return {top:box.top + (window.pageYOffset || document.scrollTop || 0) - (document.clientTop || 0),left:box.left + (window.pageXOffset || document.scrollLeft || 0) - (document.clientLeft || 0)};},position:function position(){ /* jQuery */function offsetParentFn(elem){var offsetParent=elem.offsetParent;while(offsetParent && offsetParent.nodeName.toLowerCase() !== "html" && offsetParent.style && offsetParent.style.position.toLowerCase() === "static") {offsetParent = offsetParent.offsetParent;}return offsetParent || document;} /* Zepto */var elem=this[0],offsetParent=offsetParentFn(elem),offset=this.offset(),parentOffset=/^(?:body|html)$/i.test(offsetParent.nodeName)?{top:0,left:0}:$(offsetParent).offset();offset.top -= parseFloat(elem.style.marginTop) || 0;offset.left -= parseFloat(elem.style.marginLeft) || 0;if(offsetParent.style){parentOffset.top += parseFloat(offsetParent.style.borderTopWidth) || 0;parentOffset.left += parseFloat(offsetParent.style.borderLeftWidth) || 0;}return {top:offset.top - parentOffset.top,left:offset.left - parentOffset.left};}}; /**********************
	 Private Variables
	 **********************/ /* For $.data() */var cache={};$.expando = "velocity" + new Date().getTime();$.uuid = 0; /* For $.queue() */var class2type={},hasOwn=class2type.hasOwnProperty,toString=class2type.toString;var types="Boolean Number String Function Array Date RegExp Object Error".split(" ");for(var i=0;i < types.length;i++) {class2type["[object " + types[i] + "]"] = types[i].toLowerCase();} /* Makes $(node) possible, without having to call init. */$.fn.init.prototype = $.fn; /* Globalize Velocity onto the window, and assign its Utilities property. */window.Velocity = {Utilities:$};})(window); /******************
 Velocity.js
 ******************/(function(factory){"use strict"; /* CommonJS module. */if(typeof module === "object" && typeof module.exports === "object"){module.exports = factory(); /* AMD module. */}else if(true){!(__WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.call(exports, __webpack_require__, exports, module)) :
				__WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__)); /* Browser globals. */}else {factory();}})(function(){"use strict";return (function(global,window,document,undefined){ /***************
		 Summary
		 ***************/ /*
		 - CSS: CSS stack that works independently from the rest of Velocity.
		 - animate(): Core animation method that iterates over the targeted elements and queues the incoming call onto each element individually.
		 - Pre-Queueing: Prepare the element for animation by instantiating its data cache and processing the call's options.
		 - Queueing: The logic that runs once the call has reached its point of execution in the element's $.queue() stack.
		 Most logic is placed here to avoid risking it becoming stale (if the element's properties have changed).
		 - Pushing: Consolidation of the tween data followed by its push onto the global in-progress calls container.
		 - tick(): The single requestAnimationFrame loop responsible for tweening all in-progress calls.
		 - completeCall(): Handles the cleanup process for each Velocity call.
		 */ /*********************
		 Helper Functions
		 *********************/ /* IE detection. Gist: https://gist.github.com/julianshapiro/9098609 */var IE=(function(){if(document.documentMode){return document.documentMode;}else {for(var i=7;i > 4;i--) {var div=document.createElement("div");div.innerHTML = "<!--[if IE " + i + "]><span></span><![endif]-->";if(div.getElementsByTagName("span").length){div = null;return i;}}}return undefined;})(); /* rAF shim. Gist: https://gist.github.com/julianshapiro/9497513 */var rAFShim=(function(){var timeLast=0;return window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || function(callback){var timeCurrent=new Date().getTime(),timeDelta; /* Dynamically set delay on a per-tick basis to match 60fps. */ /* Technique by Erik Moller. MIT license: https://gist.github.com/paulirish/1579671 */timeDelta = Math.max(0,16 - (timeCurrent - timeLast));timeLast = timeCurrent + timeDelta;return setTimeout(function(){callback(timeCurrent + timeDelta);},timeDelta);};})();var performance=(function(){var perf=window.performance || {};if(typeof perf.now !== "function"){var nowOffset=perf.timing && perf.timing.navigationStart?perf.timing.navigationStart:new Date().getTime();perf.now = function(){return new Date().getTime() - nowOffset;};}return perf;})(); /* Array compacting. Copyright Lo-Dash. MIT License: https://github.com/lodash/lodash/blob/master/LICENSE.txt */function compactSparseArray(array){var index=-1,length=array?array.length:0,result=[];while(++index < length) {var value=array[index];if(value){result.push(value);}}return result;} /**
		 * Shim for "fixing" IE's lack of support (IE < 9) for applying slice
		 * on host objects like NamedNodeMap, NodeList, and HTMLCollection
		 * (technically, since host objects have been implementation-dependent,
		 * at least before ES2015, IE hasn't needed to work this way).
		 * Also works on strings, fixes IE < 9 to allow an explicit undefined
		 * for the 2nd argument (as in Firefox), and prevents errors when
		 * called on other DOM objects.
		 */var _slice=(function(){var slice=Array.prototype.slice;try{ // Can't be used with DOM elements in IE < 9
slice.call(document.documentElement);return slice;}catch(e) { // Fails in IE < 9
// This will work for genuine arrays, array-like objects, 
// NamedNodeMap (attributes, entities, notations),
// NodeList (e.g., getElementsByTagName), HTMLCollection (e.g., childNodes),
return function(begin,end){var len=this.length;if(typeof begin !== "number"){begin = 0;} // IE < 9 gets unhappy with an undefined end argument
if(typeof end !== "number"){end = len;} // For native Array objects, we use the native slice function
if(this.slice){return slice.call(this,begin,end);} // For array like object we handle it ourselves.
var i,cloned=[], // Handle negative value for "begin"
start=begin >= 0?begin:Math.max(0,len + begin), // Handle negative value for "end"
upTo=end < 0?len + end:Math.min(end,len), // Actual expected size of the slice
size=upTo - start;if(size > 0){cloned = new Array(size);if(this.charAt){for(i = 0;i < size;i++) {cloned[i] = this.charAt(start + i);}}else {for(i = 0;i < size;i++) {cloned[i] = this[start + i];}}}return cloned;};}})(); /* .indexOf doesn't exist in IE<9 */var _inArray=function _inArray(){if(Array.prototype.includes){return function(arr,val){return arr.includes(val);};}if(Array.prototype.indexOf){return function(arr,val){return arr.indexOf(val) >= 0;};}return function(arr,val){for(var i=0;i < arr.length;i++) {if(arr[i] === val){return true;}}return false;};};function sanitizeElements(elements){ /* Unwrap jQuery/Zepto objects. */if(Type.isWrapped(elements)){elements = _slice.call(elements); /* Wrap a single element in an array so that $.each() can iterate with the element instead of its node's children. */}else if(Type.isNode(elements)){elements = [elements];}return elements;}var Type={isNumber:function isNumber(variable){return typeof variable === "number";},isString:function isString(variable){return typeof variable === "string";},isArray:Array.isArray || function(variable){return Object.prototype.toString.call(variable) === "[object Array]";},isFunction:function isFunction(variable){return Object.prototype.toString.call(variable) === "[object Function]";},isNode:function isNode(variable){return variable && variable.nodeType;}, /* Determine if variable is an array-like wrapped jQuery, Zepto or similar element, or even a NodeList etc. */ /* NOTE: HTMLFormElements also have a length. */isWrapped:function isWrapped(variable){return variable && variable !== window && Type.isNumber(variable.length) && !Type.isString(variable) && !Type.isFunction(variable) && !Type.isNode(variable) && (variable.length === 0 || Type.isNode(variable[0]));},isSVG:function isSVG(variable){return window.SVGElement && variable instanceof window.SVGElement;},isEmptyObject:function isEmptyObject(variable){for(var name in variable) {if(variable.hasOwnProperty(name)){return false;}}return true;}}; /*****************
		 Dependencies
		 *****************/var $,isJQuery=false;if(global.fn && global.fn.jquery){$ = global;isJQuery = true;}else {$ = window.Velocity.Utilities;}if(IE <= 8 && !isJQuery){throw new Error("Velocity: IE8 and below require jQuery to be loaded before Velocity.");}else if(IE <= 7){ /* Revert to jQuery's $.animate(), and lose Velocity's extra features. */jQuery.fn.velocity = jQuery.fn.animate; /* Now that $.fn.velocity is aliased, abort this Velocity declaration. */return;} /*****************
		 Constants
		 *****************/var DURATION_DEFAULT=400,EASING_DEFAULT="swing"; /*************
		 State
		 *************/var Velocity={ /* Container for page-wide Velocity state data. */State:{ /* Detect mobile devices to determine if mobileHA should be turned on. */isMobile:/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(window.navigator.userAgent), /* The mobileHA option's behavior changes on older Android devices (Gingerbread, versions 2.3.3-2.3.7). */isAndroid:/Android/i.test(window.navigator.userAgent),isGingerbread:/Android 2\.3\.[3-7]/i.test(window.navigator.userAgent),isChrome:window.chrome,isFirefox:/Firefox/i.test(window.navigator.userAgent), /* Create a cached element for re-use when checking for CSS property prefixes. */prefixElement:document.createElement("div"), /* Cache every prefix match to avoid repeating lookups. */prefixMatches:{}, /* Cache the anchor used for animating window scrolling. */scrollAnchor:null, /* Cache the browser-specific property names associated with the scroll anchor. */scrollPropertyLeft:null,scrollPropertyTop:null, /* Keep track of whether our RAF tick is running. */isTicking:false, /* Container for every in-progress call to Velocity. */calls:[],delayedElements:{count:0}}, /* Velocity's custom CSS stack. Made global for unit testing. */CSS:{ /* Defined below. */}, /* A shim of the jQuery utility functions used by Velocity -- provided by Velocity's optional jQuery shim. */Utilities:$, /* Container for the user's custom animation redirects that are referenced by name in place of the properties map argument. */Redirects:{ /* Manually registered by the user. */},Easings:{ /* Defined below. */}, /* Attempt to use ES6 Promises by default. Users can override this with a third-party promises library. */Promise:window.Promise, /* Velocity option defaults, which can be overriden by the user. */defaults:{queue:"",duration:DURATION_DEFAULT,easing:EASING_DEFAULT,begin:undefined,complete:undefined,progress:undefined,display:undefined,visibility:undefined,loop:false,delay:false,mobileHA:true, /* Advanced: Set to false to prevent property values from being cached between consecutive Velocity-initiated chain calls. */_cacheValues:true, /* Advanced: Set to false if the promise should always resolve on empty element lists. */promiseRejectEmpty:true}, /* A design goal of Velocity is to cache data wherever possible in order to avoid DOM requerying. Accordingly, each element has a data cache. */init:function init(element){$.data(element,"velocity",{ /* Store whether this is an SVG element, since its properties are retrieved and updated differently than standard HTML elements. */isSVG:Type.isSVG(element), /* Keep track of whether the element is currently being animated by Velocity.
					 This is used to ensure that property values are not transferred between non-consecutive (stale) calls. */isAnimating:false, /* A reference to the element's live computedStyle object. Learn more here: https://developer.mozilla.org/en/docs/Web/API/window.getComputedStyle */computedStyle:null, /* Tween data is cached for each animation on the element so that data can be passed across calls --
					 in particular, end values are used as subsequent start values in consecutive Velocity calls. */tweensContainer:null, /* The full root property values of each CSS hook being animated on this element are cached so that:
					 1) Concurrently-animating hooks sharing the same root can have their root values' merged into one while tweening.
					 2) Post-hook-injection root values can be transferred over to consecutively chained Velocity calls as starting root values. */rootPropertyValueCache:{}, /* A cache for transform updates, which must be manually flushed via CSS.flushTransformCache(). */transformCache:{}});}, /* A parallel to jQuery's $.css(), used for getting/setting Velocity's hooked CSS properties. */hook:null, /* Defined below. */ /* Velocity-wide animation time remapping for testing purposes. */mock:false,version:{major:1,minor:5,patch:2}, /* Set to 1 or 2 (most verbose) to output debug info to console. */debug:false, /* Use rAF high resolution timestamp when available */timestamp:true, /* Pause all animations */pauseAll:function pauseAll(queueName){var currentTime=new Date().getTime();$.each(Velocity.State.calls,function(i,activeCall){if(activeCall){ /* If we have a queueName and this call is not on that queue, skip */if(queueName !== undefined && (activeCall[2].queue !== queueName || activeCall[2].queue === false)){return true;} /* Set call to paused */activeCall[5] = {resume:false};}}); /* Pause timers on any currently delayed calls */$.each(Velocity.State.delayedElements,function(k,element){if(!element){return;}pauseDelayOnElement(element,currentTime);});}, /* Resume all animations */resumeAll:function resumeAll(queueName){var currentTime=new Date().getTime();$.each(Velocity.State.calls,function(i,activeCall){if(activeCall){ /* If we have a queueName and this call is not on that queue, skip */if(queueName !== undefined && (activeCall[2].queue !== queueName || activeCall[2].queue === false)){return true;} /* Set call to resumed if it was paused */if(activeCall[5]){activeCall[5].resume = true;}}}); /* Resume timers on any currently delayed calls */$.each(Velocity.State.delayedElements,function(k,element){if(!element){return;}resumeDelayOnElement(element,currentTime);});}}; /* Retrieve the appropriate scroll anchor and property name for the browser: https://developer.mozilla.org/en-US/docs/Web/API/Window.scrollY */if(window.pageYOffset !== undefined){Velocity.State.scrollAnchor = window;Velocity.State.scrollPropertyLeft = "pageXOffset";Velocity.State.scrollPropertyTop = "pageYOffset";}else {Velocity.State.scrollAnchor = document.documentElement || document.body.parentNode || document.body;Velocity.State.scrollPropertyLeft = "scrollLeft";Velocity.State.scrollPropertyTop = "scrollTop";} /* Shorthand alias for jQuery's $.data() utility. */function Data(element){ /* Hardcode a reference to the plugin name. */var response=$.data(element,"velocity"); /* jQuery <=1.4.2 returns null instead of undefined when no match is found. We normalize this behavior. */return response === null?undefined:response;} /**************
		 Delay Timer
		 **************/function pauseDelayOnElement(element,currentTime){ /* Check for any delay timers, and pause the set timeouts (while preserving time data)
			 to be resumed when the "resume" command is issued */var data=Data(element);if(data && data.delayTimer && !data.delayPaused){data.delayRemaining = data.delay - currentTime + data.delayBegin;data.delayPaused = true;clearTimeout(data.delayTimer.setTimeout);}}function resumeDelayOnElement(element,currentTime){ /* Check for any paused timers and resume */var data=Data(element);if(data && data.delayTimer && data.delayPaused){ /* If the element was mid-delay, re initiate the timeout with the remaining delay */data.delayPaused = false;data.delayTimer.setTimeout = setTimeout(data.delayTimer.next,data.delayRemaining);}} /**************
		 Easing
		 **************/ /* Step easing generator. */function generateStep(steps){return function(p){return Math.round(p * steps) * (1 / steps);};} /* Bezier curve function generator. Copyright Gaetan Renaudeau. MIT License: http://en.wikipedia.org/wiki/MIT_License */function generateBezier(mX1,mY1,mX2,mY2){var NEWTON_ITERATIONS=4,NEWTON_MIN_SLOPE=0.001,SUBDIVISION_PRECISION=0.0000001,SUBDIVISION_MAX_ITERATIONS=10,kSplineTableSize=11,kSampleStepSize=1.0 / (kSplineTableSize - 1.0),float32ArraySupported=("Float32Array" in window); /* Must contain four arguments. */if(arguments.length !== 4){return false;} /* Arguments must be numbers. */for(var i=0;i < 4;++i) {if(typeof arguments[i] !== "number" || isNaN(arguments[i]) || !isFinite(arguments[i])){return false;}} /* X values must be in the [0, 1] range. */mX1 = Math.min(mX1,1);mX2 = Math.min(mX2,1);mX1 = Math.max(mX1,0);mX2 = Math.max(mX2,0);var mSampleValues=float32ArraySupported?new Float32Array(kSplineTableSize):new Array(kSplineTableSize);function A(aA1,aA2){return 1.0 - 3.0 * aA2 + 3.0 * aA1;}function B(aA1,aA2){return 3.0 * aA2 - 6.0 * aA1;}function C(aA1){return 3.0 * aA1;}function calcBezier(aT,aA1,aA2){return ((A(aA1,aA2) * aT + B(aA1,aA2)) * aT + C(aA1)) * aT;}function getSlope(aT,aA1,aA2){return 3.0 * A(aA1,aA2) * aT * aT + 2.0 * B(aA1,aA2) * aT + C(aA1);}function newtonRaphsonIterate(aX,aGuessT){for(var i=0;i < NEWTON_ITERATIONS;++i) {var currentSlope=getSlope(aGuessT,mX1,mX2);if(currentSlope === 0.0){return aGuessT;}var currentX=calcBezier(aGuessT,mX1,mX2) - aX;aGuessT -= currentX / currentSlope;}return aGuessT;}function calcSampleValues(){for(var i=0;i < kSplineTableSize;++i) {mSampleValues[i] = calcBezier(i * kSampleStepSize,mX1,mX2);}}function binarySubdivide(aX,aA,aB){var currentX,currentT,i=0;do {currentT = aA + (aB - aA) / 2.0;currentX = calcBezier(currentT,mX1,mX2) - aX;if(currentX > 0.0){aB = currentT;}else {aA = currentT;}}while(Math.abs(currentX) > SUBDIVISION_PRECISION && ++i < SUBDIVISION_MAX_ITERATIONS);return currentT;}function getTForX(aX){var intervalStart=0.0,currentSample=1,lastSample=kSplineTableSize - 1;for(;currentSample !== lastSample && mSampleValues[currentSample] <= aX;++currentSample) {intervalStart += kSampleStepSize;}--currentSample;var dist=(aX - mSampleValues[currentSample]) / (mSampleValues[currentSample + 1] - mSampleValues[currentSample]),guessForT=intervalStart + dist * kSampleStepSize,initialSlope=getSlope(guessForT,mX1,mX2);if(initialSlope >= NEWTON_MIN_SLOPE){return newtonRaphsonIterate(aX,guessForT);}else if(initialSlope === 0.0){return guessForT;}else {return binarySubdivide(aX,intervalStart,intervalStart + kSampleStepSize);}}var _precomputed=false;function precompute(){_precomputed = true;if(mX1 !== mY1 || mX2 !== mY2){calcSampleValues();}}var f=function f(aX){if(!_precomputed){precompute();}if(mX1 === mY1 && mX2 === mY2){return aX;}if(aX === 0){return 0;}if(aX === 1){return 1;}return calcBezier(getTForX(aX),mY1,mY2);};f.getControlPoints = function(){return [{x:mX1,y:mY1},{x:mX2,y:mY2}];};var str="generateBezier(" + [mX1,mY1,mX2,mY2] + ")";f.toString = function(){return str;};return f;} /* Runge-Kutta spring physics function generator. Adapted from Framer.js, copyright Koen Bok. MIT License: http://en.wikipedia.org/wiki/MIT_License */ /* Given a tension, friction, and duration, a simulation at 60FPS will first run without a defined duration in order to calculate the full path. A second pass
		 then adjusts the time delta -- using the relation between actual time and duration -- to calculate the path for the duration-constrained animation. */var generateSpringRK4=(function(){function springAccelerationForState(state){return -state.tension * state.x - state.friction * state.v;}function springEvaluateStateWithDerivative(initialState,dt,derivative){var state={x:initialState.x + derivative.dx * dt,v:initialState.v + derivative.dv * dt,tension:initialState.tension,friction:initialState.friction};return {dx:state.v,dv:springAccelerationForState(state)};}function springIntegrateState(state,dt){var a={dx:state.v,dv:springAccelerationForState(state)},b=springEvaluateStateWithDerivative(state,dt * 0.5,a),c=springEvaluateStateWithDerivative(state,dt * 0.5,b),d=springEvaluateStateWithDerivative(state,dt,c),dxdt=1.0 / 6.0 * (a.dx + 2.0 * (b.dx + c.dx) + d.dx),dvdt=1.0 / 6.0 * (a.dv + 2.0 * (b.dv + c.dv) + d.dv);state.x = state.x + dxdt * dt;state.v = state.v + dvdt * dt;return state;}return function springRK4Factory(tension,friction,duration){var initState={x:-1,v:0,tension:null,friction:null},path=[0],time_lapsed=0,tolerance=1 / 10000,DT=16 / 1000,have_duration,dt,last_state;tension = parseFloat(tension) || 500;friction = parseFloat(friction) || 20;duration = duration || null;initState.tension = tension;initState.friction = friction;have_duration = duration !== null; /* Calculate the actual time it takes for this animation to complete with the provided conditions. */if(have_duration){ /* Run the simulation without a duration. */time_lapsed = springRK4Factory(tension,friction); /* Compute the adjusted time delta. */dt = time_lapsed / duration * DT;}else {dt = DT;}while(true) { /* Next/step function .*/last_state = springIntegrateState(last_state || initState,dt); /* Store the position. */path.push(1 + last_state.x);time_lapsed += 16; /* If the change threshold is reached, break. */if(!(Math.abs(last_state.x) > tolerance && Math.abs(last_state.v) > tolerance)){break;}} /* If duration is not defined, return the actual time required for completing this animation. Otherwise, return a closure that holds the
				 computed path and returns a snapshot of the position according to a given percentComplete. */return !have_duration?time_lapsed:function(percentComplete){return path[percentComplete * (path.length - 1) | 0];};};})(); /* jQuery easings. */Velocity.Easings = {linear:function linear(p){return p;},swing:function swing(p){return 0.5 - Math.cos(p * Math.PI) / 2;}, /* Bonus "spring" easing, which is a less exaggerated version of easeInOutElastic. */spring:function spring(p){return 1 - Math.cos(p * 4.5 * Math.PI) * Math.exp(-p * 6);}}; /* CSS3 and Robert Penner easings. */$.each([["ease",[0.25,0.1,0.25,1.0]],["ease-in",[0.42,0.0,1.00,1.0]],["ease-out",[0.00,0.0,0.58,1.0]],["ease-in-out",[0.42,0.0,0.58,1.0]],["easeInSine",[0.47,0,0.745,0.715]],["easeOutSine",[0.39,0.575,0.565,1]],["easeInOutSine",[0.445,0.05,0.55,0.95]],["easeInQuad",[0.55,0.085,0.68,0.53]],["easeOutQuad",[0.25,0.46,0.45,0.94]],["easeInOutQuad",[0.455,0.03,0.515,0.955]],["easeInCubic",[0.55,0.055,0.675,0.19]],["easeOutCubic",[0.215,0.61,0.355,1]],["easeInOutCubic",[0.645,0.045,0.355,1]],["easeInQuart",[0.895,0.03,0.685,0.22]],["easeOutQuart",[0.165,0.84,0.44,1]],["easeInOutQuart",[0.77,0,0.175,1]],["easeInQuint",[0.755,0.05,0.855,0.06]],["easeOutQuint",[0.23,1,0.32,1]],["easeInOutQuint",[0.86,0,0.07,1]],["easeInExpo",[0.95,0.05,0.795,0.035]],["easeOutExpo",[0.19,1,0.22,1]],["easeInOutExpo",[1,0,0,1]],["easeInCirc",[0.6,0.04,0.98,0.335]],["easeOutCirc",[0.075,0.82,0.165,1]],["easeInOutCirc",[0.785,0.135,0.15,0.86]]],function(i,easingArray){Velocity.Easings[easingArray[0]] = generateBezier.apply(null,easingArray[1]);}); /* Determine the appropriate easing type given an easing input. */function getEasing(value,duration){var easing=value; /* The easing option can either be a string that references a pre-registered easing,
			 or it can be a two-/four-item array of integers to be converted into a bezier/spring function. */if(Type.isString(value)){ /* Ensure that the easing has been assigned to jQuery's Velocity.Easings object. */if(!Velocity.Easings[value]){easing = false;}}else if(Type.isArray(value) && value.length === 1){easing = generateStep.apply(null,value);}else if(Type.isArray(value) && value.length === 2){ /* springRK4 must be passed the animation's duration. */ /* Note: If the springRK4 array contains non-numbers, generateSpringRK4() returns an easing
				 function generated with default tension and friction values. */easing = generateSpringRK4.apply(null,value.concat([duration]));}else if(Type.isArray(value) && value.length === 4){ /* Note: If the bezier array contains non-numbers, generateBezier() returns false. */easing = generateBezier.apply(null,value);}else {easing = false;} /* Revert to the Velocity-wide default easing type, or fall back to "swing" (which is also jQuery's default)
			 if the Velocity-wide default has been incorrectly modified. */if(easing === false){if(Velocity.Easings[Velocity.defaults.easing]){easing = Velocity.defaults.easing;}else {easing = EASING_DEFAULT;}}return easing;} /*****************
		 CSS Stack
		 *****************/ /* The CSS object is a highly condensed and performant CSS stack that fully replaces jQuery's.
		 It handles the validation, getting, and setting of both standard CSS properties and CSS property hooks. */ /* Note: A "CSS" shorthand is aliased so that our code is easier to read. */var CSS=Velocity.CSS = { /*************
			 RegEx
			 *************/RegEx:{isHex:/^#([A-f\d]{3}){1,2}$/i, /* Unwrap a property value's surrounding text, e.g. "rgba(4, 3, 2, 1)" ==> "4, 3, 2, 1" and "rect(4px 3px 2px 1px)" ==> "4px 3px 2px 1px". */valueUnwrap:/^[A-z]+\((.*)\)$/i,wrappedValueAlreadyExtracted:/[0-9.]+ [0-9.]+ [0-9.]+( [0-9.]+)?/, /* Split a multi-value property into an array of subvalues, e.g. "rgba(4, 3, 2, 1) 4px 3px 2px 1px" ==> [ "rgba(4, 3, 2, 1)", "4px", "3px", "2px", "1px" ]. */valueSplit:/([A-z]+\(.+\))|(([A-z0-9#-.]+?)(?=\s|$))/ig}, /************
			 Lists
			 ************/Lists:{colors:["fill","stroke","stopColor","color","backgroundColor","borderColor","borderTopColor","borderRightColor","borderBottomColor","borderLeftColor","outlineColor"],transformsBase:["translateX","translateY","scale","scaleX","scaleY","skewX","skewY","rotateZ"],transforms3D:["transformPerspective","translateZ","scaleZ","rotateX","rotateY"],units:["%", // relative
"em","ex","ch","rem", // font relative
"vw","vh","vmin","vmax", // viewport relative
"cm","mm","Q","in","pc","pt","px", // absolute lengths
"deg","grad","rad","turn", // angles
"s","ms" // time
],colorNames:{"aliceblue":"240,248,255","antiquewhite":"250,235,215","aquamarine":"127,255,212","aqua":"0,255,255","azure":"240,255,255","beige":"245,245,220","bisque":"255,228,196","black":"0,0,0","blanchedalmond":"255,235,205","blueviolet":"138,43,226","blue":"0,0,255","brown":"165,42,42","burlywood":"222,184,135","cadetblue":"95,158,160","chartreuse":"127,255,0","chocolate":"210,105,30","coral":"255,127,80","cornflowerblue":"100,149,237","cornsilk":"255,248,220","crimson":"220,20,60","cyan":"0,255,255","darkblue":"0,0,139","darkcyan":"0,139,139","darkgoldenrod":"184,134,11","darkgray":"169,169,169","darkgrey":"169,169,169","darkgreen":"0,100,0","darkkhaki":"189,183,107","darkmagenta":"139,0,139","darkolivegreen":"85,107,47","darkorange":"255,140,0","darkorchid":"153,50,204","darkred":"139,0,0","darksalmon":"233,150,122","darkseagreen":"143,188,143","darkslateblue":"72,61,139","darkslategray":"47,79,79","darkturquoise":"0,206,209","darkviolet":"148,0,211","deeppink":"255,20,147","deepskyblue":"0,191,255","dimgray":"105,105,105","dimgrey":"105,105,105","dodgerblue":"30,144,255","firebrick":"178,34,34","floralwhite":"255,250,240","forestgreen":"34,139,34","fuchsia":"255,0,255","gainsboro":"220,220,220","ghostwhite":"248,248,255","gold":"255,215,0","goldenrod":"218,165,32","gray":"128,128,128","grey":"128,128,128","greenyellow":"173,255,47","green":"0,128,0","honeydew":"240,255,240","hotpink":"255,105,180","indianred":"205,92,92","indigo":"75,0,130","ivory":"255,255,240","khaki":"240,230,140","lavenderblush":"255,240,245","lavender":"230,230,250","lawngreen":"124,252,0","lemonchiffon":"255,250,205","lightblue":"173,216,230","lightcoral":"240,128,128","lightcyan":"224,255,255","lightgoldenrodyellow":"250,250,210","lightgray":"211,211,211","lightgrey":"211,211,211","lightgreen":"144,238,144","lightpink":"255,182,193","lightsalmon":"255,160,122","lightseagreen":"32,178,170","lightskyblue":"135,206,250","lightslategray":"119,136,153","lightsteelblue":"176,196,222","lightyellow":"255,255,224","limegreen":"50,205,50","lime":"0,255,0","linen":"250,240,230","magenta":"255,0,255","maroon":"128,0,0","mediumaquamarine":"102,205,170","mediumblue":"0,0,205","mediumorchid":"186,85,211","mediumpurple":"147,112,219","mediumseagreen":"60,179,113","mediumslateblue":"123,104,238","mediumspringgreen":"0,250,154","mediumturquoise":"72,209,204","mediumvioletred":"199,21,133","midnightblue":"25,25,112","mintcream":"245,255,250","mistyrose":"255,228,225","moccasin":"255,228,181","navajowhite":"255,222,173","navy":"0,0,128","oldlace":"253,245,230","olivedrab":"107,142,35","olive":"128,128,0","orangered":"255,69,0","orange":"255,165,0","orchid":"218,112,214","palegoldenrod":"238,232,170","palegreen":"152,251,152","paleturquoise":"175,238,238","palevioletred":"219,112,147","papayawhip":"255,239,213","peachpuff":"255,218,185","peru":"205,133,63","pink":"255,192,203","plum":"221,160,221","powderblue":"176,224,230","purple":"128,0,128","red":"255,0,0","rosybrown":"188,143,143","royalblue":"65,105,225","saddlebrown":"139,69,19","salmon":"250,128,114","sandybrown":"244,164,96","seagreen":"46,139,87","seashell":"255,245,238","sienna":"160,82,45","silver":"192,192,192","skyblue":"135,206,235","slateblue":"106,90,205","slategray":"112,128,144","snow":"255,250,250","springgreen":"0,255,127","steelblue":"70,130,180","tan":"210,180,140","teal":"0,128,128","thistle":"216,191,216","tomato":"255,99,71","turquoise":"64,224,208","violet":"238,130,238","wheat":"245,222,179","whitesmoke":"245,245,245","white":"255,255,255","yellowgreen":"154,205,50","yellow":"255,255,0"}}, /************
			 Hooks
			 ************/ /* Hooks allow a subproperty (e.g. "boxShadowBlur") of a compound-value CSS property
			 (e.g. "boxShadow: X Y Blur Spread Color") to be animated as if it were a discrete property. */ /* Note: Beyond enabling fine-grained property animation, hooking is necessary since Velocity only
			 tweens properties with single numeric values; unlike CSS transitions, Velocity does not interpolate compound-values. */Hooks:{ /********************
				 Registration
				 ********************/ /* Templates are a concise way of indicating which subproperties must be individually registered for each compound-value CSS property. */ /* Each template consists of the compound-value's base name, its constituent subproperty names, and those subproperties' default values. */templates:{"textShadow":["Color X Y Blur","black 0px 0px 0px"],"boxShadow":["Color X Y Blur Spread","black 0px 0px 0px 0px"],"clip":["Top Right Bottom Left","0px 0px 0px 0px"],"backgroundPosition":["X Y","0% 0%"],"transformOrigin":["X Y Z","50% 50% 0px"],"perspectiveOrigin":["X Y","50% 50%"]}, /* A "registered" hook is one that has been converted from its template form into a live,
				 tweenable property. It contains data to associate it with its root property. */registered:{ /* Note: A registered hook looks like this ==> textShadowBlur: [ "textShadow", 3 ],
					 which consists of the subproperty's name, the associated root property's name,
					 and the subproperty's position in the root's value. */}, /* Convert the templates into individual hooks then append them to the registered object above. */register:function register(){ /* Color hooks registration: Colors are defaulted to white -- as opposed to black -- since colors that are
					 currently set to "transparent" default to their respective template below when color-animated,
					 and white is typically a closer match to transparent than black is. An exception is made for text ("color"),
					 which is almost always set closer to black than white. */for(var i=0;i < CSS.Lists.colors.length;i++) {var rgbComponents=CSS.Lists.colors[i] === "color"?"0 0 0 1":"255 255 255 1";CSS.Hooks.templates[CSS.Lists.colors[i]] = ["Red Green Blue Alpha",rgbComponents];}var rootProperty,hookTemplate,hookNames; /* In IE, color values inside compound-value properties are positioned at the end the value instead of at the beginning.
					 Thus, we re-arrange the templates accordingly. */if(IE){for(rootProperty in CSS.Hooks.templates) {if(!CSS.Hooks.templates.hasOwnProperty(rootProperty)){continue;}hookTemplate = CSS.Hooks.templates[rootProperty];hookNames = hookTemplate[0].split(" ");var defaultValues=hookTemplate[1].match(CSS.RegEx.valueSplit);if(hookNames[0] === "Color"){ /* Reposition both the hook's name and its default value to the end of their respective strings. */hookNames.push(hookNames.shift());defaultValues.push(defaultValues.shift()); /* Replace the existing template for the hook's root property. */CSS.Hooks.templates[rootProperty] = [hookNames.join(" "),defaultValues.join(" ")];}}} /* Hook registration. */for(rootProperty in CSS.Hooks.templates) {if(!CSS.Hooks.templates.hasOwnProperty(rootProperty)){continue;}hookTemplate = CSS.Hooks.templates[rootProperty];hookNames = hookTemplate[0].split(" ");for(var j in hookNames) {if(!hookNames.hasOwnProperty(j)){continue;}var fullHookName=rootProperty + hookNames[j],hookPosition=j; /* For each hook, register its full name (e.g. textShadowBlur) with its root property (e.g. textShadow)
							 and the hook's position in its template's default value string. */CSS.Hooks.registered[fullHookName] = [rootProperty,hookPosition];}}}, /*****************************
				 Injection and Extraction
				 *****************************/ /* Look up the root property associated with the hook (e.g. return "textShadow" for "textShadowBlur"). */ /* Since a hook cannot be set directly (the browser won't recognize it), style updating for hooks is routed through the hook's root property. */getRoot:function getRoot(property){var hookData=CSS.Hooks.registered[property];if(hookData){return hookData[0];}else { /* If there was no hook match, return the property name untouched. */return property;}},getUnit:function getUnit(str,start){var unit=(str.substr(start || 0,5).match(/^[a-z%]+/) || [])[0] || "";if(unit && _inArray(CSS.Lists.units,unit)){return unit;}return "";},fixColors:function fixColors(str){return str.replace(/(rgba?\(\s*)?(\b[a-z]+\b)/g,function($0,$1,$2){if(CSS.Lists.colorNames.hasOwnProperty($2)){return ($1?$1:"rgba(") + CSS.Lists.colorNames[$2] + ($1?"":",1)");}return $1 + $2;});}, /* Convert any rootPropertyValue, null or otherwise, into a space-delimited list of hook values so that
				 the targeted hook can be injected or extracted at its standard position. */cleanRootPropertyValue:function cleanRootPropertyValue(rootProperty,rootPropertyValue){ /* If the rootPropertyValue is wrapped with "rgb()", "clip()", etc., remove the wrapping to normalize the value before manipulation. */if(CSS.RegEx.valueUnwrap.test(rootPropertyValue)){rootPropertyValue = rootPropertyValue.match(CSS.RegEx.valueUnwrap)[1];} /* If rootPropertyValue is a CSS null-value (from which there's inherently no hook value to extract),
					 default to the root's default value as defined in CSS.Hooks.templates. */ /* Note: CSS null-values include "none", "auto", and "transparent". They must be converted into their
					 zero-values (e.g. textShadow: "none" ==> textShadow: "0px 0px 0px black") for hook manipulation to proceed. */if(CSS.Values.isCSSNullValue(rootPropertyValue)){rootPropertyValue = CSS.Hooks.templates[rootProperty][1];}return rootPropertyValue;}, /* Extracted the hook's value from its root property's value. This is used to get the starting value of an animating hook. */extractValue:function extractValue(fullHookName,rootPropertyValue){var hookData=CSS.Hooks.registered[fullHookName];if(hookData){var hookRoot=hookData[0],hookPosition=hookData[1];rootPropertyValue = CSS.Hooks.cleanRootPropertyValue(hookRoot,rootPropertyValue); /* Split rootPropertyValue into its constituent hook values then grab the desired hook at its standard position. */return rootPropertyValue.toString().match(CSS.RegEx.valueSplit)[hookPosition];}else { /* If the provided fullHookName isn't a registered hook, return the rootPropertyValue that was passed in. */return rootPropertyValue;}}, /* Inject the hook's value into its root property's value. This is used to piece back together the root property
				 once Velocity has updated one of its individually hooked values through tweening. */injectValue:function injectValue(fullHookName,hookValue,rootPropertyValue){var hookData=CSS.Hooks.registered[fullHookName];if(hookData){var hookRoot=hookData[0],hookPosition=hookData[1],rootPropertyValueParts,rootPropertyValueUpdated;rootPropertyValue = CSS.Hooks.cleanRootPropertyValue(hookRoot,rootPropertyValue); /* Split rootPropertyValue into its individual hook values, replace the targeted value with hookValue,
						 then reconstruct the rootPropertyValue string. */rootPropertyValueParts = rootPropertyValue.toString().match(CSS.RegEx.valueSplit);rootPropertyValueParts[hookPosition] = hookValue;rootPropertyValueUpdated = rootPropertyValueParts.join(" ");return rootPropertyValueUpdated;}else { /* If the provided fullHookName isn't a registered hook, return the rootPropertyValue that was passed in. */return rootPropertyValue;}}}, /*******************
			 Normalizations
			 *******************/ /* Normalizations standardize CSS property manipulation by pollyfilling browser-specific implementations (e.g. opacity)
			 and reformatting special properties (e.g. clip, rgba) to look like standard ones. */Normalizations:{ /* Normalizations are passed a normalization target (either the property's name, its extracted value, or its injected value),
				 the targeted element (which may need to be queried), and the targeted property value. */registered:{clip:function clip(type,element,propertyValue){switch(type){case "name":return "clip"; /* Clip needs to be unwrapped and stripped of its commas during extraction. */case "extract":var extracted; /* If Velocity also extracted this value, skip extraction. */if(CSS.RegEx.wrappedValueAlreadyExtracted.test(propertyValue)){extracted = propertyValue;}else { /* Remove the "rect()" wrapper. */extracted = propertyValue.toString().match(CSS.RegEx.valueUnwrap); /* Strip off commas. */extracted = extracted?extracted[1].replace(/,(\s+)?/g," "):propertyValue;}return extracted; /* Clip needs to be re-wrapped during injection. */case "inject":return "rect(" + propertyValue + ")";}},blur:function blur(type,element,propertyValue){switch(type){case "name":return Velocity.State.isFirefox?"filter":"-webkit-filter";case "extract":var extracted=parseFloat(propertyValue); /* If extracted is NaN, meaning the value isn't already extracted. */if(!(extracted || extracted === 0)){var blurComponent=propertyValue.toString().match(/blur\(([0-9]+[A-z]+)\)/i); /* If the filter string had a blur component, return just the blur value and unit type. */if(blurComponent){extracted = blurComponent[1]; /* If the component doesn't exist, default blur to 0. */}else {extracted = 0;}}return extracted; /* Blur needs to be re-wrapped during injection. */case "inject": /* For the blur effect to be fully de-applied, it needs to be set to "none" instead of 0. */if(!parseFloat(propertyValue)){return "none";}else {return "blur(" + propertyValue + ")";}}}, /* <=IE8 do not support the standard opacity property. They use filter:alpha(opacity=INT) instead. */opacity:function opacity(type,element,propertyValue){if(IE <= 8){switch(type){case "name":return "filter";case "extract": /* <=IE8 return a "filter" value of "alpha(opacity=\d{1,3})".
									 Extract the value and convert it to a decimal value to match the standard CSS opacity property's formatting. */var extracted=propertyValue.toString().match(/alpha\(opacity=(.*)\)/i);if(extracted){ /* Convert to decimal value. */propertyValue = extracted[1] / 100;}else { /* When extracting opacity, default to 1 since a null value means opacity hasn't been set. */propertyValue = 1;}return propertyValue;case "inject": /* Opacified elements are required to have their zoom property set to a non-zero value. */element.style.zoom = 1; /* Setting the filter property on elements with certain font property combinations can result in a
									 highly unappealing ultra-bolding effect. There's no way to remedy this throughout a tween, but dropping the
									 value altogether (when opacity hits 1) at leasts ensures that the glitch is gone post-tweening. */if(parseFloat(propertyValue) >= 1){return "";}else { /* As per the filter property's spec, convert the decimal value to a whole number and wrap the value. */return "alpha(opacity=" + parseInt(parseFloat(propertyValue) * 100,10) + ")";}} /* With all other browsers, normalization is not required; return the same values that were passed in. */}else {switch(type){case "name":return "opacity";case "extract":return propertyValue;case "inject":return propertyValue;}}}}, /*****************************
				 Batched Registrations
				 *****************************/ /* Note: Batched normalizations extend the CSS.Normalizations.registered object. */register:function register(){ /*****************
					 Transforms
					 *****************/ /* Transforms are the subproperties contained by the CSS "transform" property. Transforms must undergo normalization
					 so that they can be referenced in a properties map by their individual names. */ /* Note: When transforms are "set", they are actually assigned to a per-element transformCache. When all transform
					 setting is complete complete, CSS.flushTransformCache() must be manually called to flush the values to the DOM.
					 Transform setting is batched in this way to improve performance: the transform style only needs to be updated
					 once when multiple transform subproperties are being animated simultaneously. */ /* Note: IE9 and Android Gingerbread have support for 2D -- but not 3D -- transforms. Since animating unsupported
					 transform properties results in the browser ignoring the *entire* transform string, we prevent these 3D values
					 from being normalized for these browsers so that tweening skips these properties altogether
					 (since it will ignore them as being unsupported by the browser.) */if((!IE || IE > 9) && !Velocity.State.isGingerbread){ /* Note: Since the standalone CSS "perspective" property and the CSS transform "perspective" subproperty
						 share the same name, the latter is given a unique token within Velocity: "transformPerspective". */CSS.Lists.transformsBase = CSS.Lists.transformsBase.concat(CSS.Lists.transforms3D);}for(var i=0;i < CSS.Lists.transformsBase.length;i++) { /* Wrap the dynamically generated normalization function in a new scope so that transformName's value is
						 paired with its respective function. (Otherwise, all functions would take the final for loop's transformName.) */(function(){var transformName=CSS.Lists.transformsBase[i];CSS.Normalizations.registered[transformName] = function(type,element,propertyValue){switch(type){ /* The normalized property name is the parent "transform" property -- the property that is actually set in CSS. */case "name":return "transform"; /* Transform values are cached onto a per-element transformCache object. */case "extract": /* If this transform has yet to be assigned a value, return its null value. */if(Data(element) === undefined || Data(element).transformCache[transformName] === undefined){ /* Scale CSS.Lists.transformsBase default to 1 whereas all other transform properties default to 0. */return (/^scale/i.test(transformName)?1:0); /* When transform values are set, they are wrapped in parentheses as per the CSS spec.
											 Thus, when extracting their values (for tween calculations), we strip off the parentheses. */}return Data(element).transformCache[transformName].replace(/[()]/g,"");case "inject":var invalid=false; /* If an individual transform property contains an unsupported unit type, the browser ignores the *entire* transform property.
										 Thus, protect users from themselves by skipping setting for transform values supplied with invalid unit types. */ /* Switch on the base transform type; ignore the axis by removing the last letter from the transform's name. */switch(transformName.substr(0,transformName.length - 1)){ /* Whitelist unit types for each transform. */case "translate":invalid = !/(%|px|em|rem|vw|vh|\d)$/i.test(propertyValue);break; /* Since an axis-free "scale" property is supported as well, a little hack is used here to detect it by chopping off its last letter. */case "scal":case "scale": /* Chrome on Android has a bug in which scaled elements blur if their initial scale
												 value is below 1 (which can happen with forcefeeding). Thus, we detect a yet-unset scale property
												 and ensure that its first value is always 1. More info: http://stackoverflow.com/questions/10417890/css3-animations-with-transform-causes-blurred-elements-on-webkit/10417962#10417962 */if(Velocity.State.isAndroid && Data(element).transformCache[transformName] === undefined && propertyValue < 1){propertyValue = 1;}invalid = !/(\d)$/i.test(propertyValue);break;case "skew":invalid = !/(deg|\d)$/i.test(propertyValue);break;case "rotate":invalid = !/(deg|\d)$/i.test(propertyValue);break;}if(!invalid){ /* As per the CSS spec, wrap the value in parentheses. */Data(element).transformCache[transformName] = "(" + propertyValue + ")";} /* Although the value is set on the transformCache object, return the newly-updated value for the calling code to process as normal. */return Data(element).transformCache[transformName];}};})();} /*************
					 Colors
					 *************/ /* Since Velocity only animates a single numeric value per property, color animation is achieved by hooking the individual RGBA components of CSS color properties.
					 Accordingly, color values must be normalized (e.g. "#ff0000", "red", and "rgb(255, 0, 0)" ==> "255 0 0 1") so that their components can be injected/extracted by CSS.Hooks logic. */for(var j=0;j < CSS.Lists.colors.length;j++) { /* Wrap the dynamically generated normalization function in a new scope so that colorName's value is paired with its respective function.
						 (Otherwise, all functions would take the final for loop's colorName.) */(function(){var colorName=CSS.Lists.colors[j]; /* Note: In IE<=8, which support rgb but not rgba, color properties are reverted to rgb by stripping off the alpha component. */CSS.Normalizations.registered[colorName] = function(type,element,propertyValue){switch(type){case "name":return colorName; /* Convert all color values into the rgb format. (Old IE can return hex values and color names instead of rgb/rgba.) */case "extract":var extracted; /* If the color is already in its hookable form (e.g. "255 255 255 1") due to having been previously extracted, skip extraction. */if(CSS.RegEx.wrappedValueAlreadyExtracted.test(propertyValue)){extracted = propertyValue;}else {var converted,colorNames={black:"rgb(0, 0, 0)",blue:"rgb(0, 0, 255)",gray:"rgb(128, 128, 128)",green:"rgb(0, 128, 0)",red:"rgb(255, 0, 0)",white:"rgb(255, 255, 255)"}; /* Convert color names to rgb. */if(/^[A-z]+$/i.test(propertyValue)){if(colorNames[propertyValue] !== undefined){converted = colorNames[propertyValue];}else { /* If an unmatched color name is provided, default to black. */converted = colorNames.black;} /* Convert hex values to rgb. */}else if(CSS.RegEx.isHex.test(propertyValue)){converted = "rgb(" + CSS.Values.hexToRgb(propertyValue).join(" ") + ")"; /* If the provided color doesn't match any of the accepted color formats, default to black. */}else if(!/^rgba?\(/i.test(propertyValue)){converted = colorNames.black;} /* Remove the surrounding "rgb/rgba()" string then replace commas with spaces and strip
											 repeated spaces (in case the value included spaces to begin with). */extracted = (converted || propertyValue).toString().match(CSS.RegEx.valueUnwrap)[1].replace(/,(\s+)?/g," ");} /* So long as this isn't <=IE8, add a fourth (alpha) component if it's missing and default it to 1 (visible). */if((!IE || IE > 8) && extracted.split(" ").length === 3){extracted += " 1";}return extracted;case "inject": /* If we have a pattern then it might already have the right values */if(/^rgb/.test(propertyValue)){return propertyValue;} /* If this is IE<=8 and an alpha component exists, strip it off. */if(IE <= 8){if(propertyValue.split(" ").length === 4){propertyValue = propertyValue.split(/\s+/).slice(0,3).join(" ");} /* Otherwise, add a fourth (alpha) component if it's missing and default it to 1 (visible). */}else if(propertyValue.split(" ").length === 3){propertyValue += " 1";} /* Re-insert the browser-appropriate wrapper("rgb/rgba()"), insert commas, and strip off decimal units
										 on all values but the fourth (R, G, and B only accept whole numbers). */return (IE <= 8?"rgb":"rgba") + "(" + propertyValue.replace(/\s+/g,",").replace(/\.(\d)+(?=,)/g,"") + ")";}};})();} /**************
					 Dimensions
					 **************/function augmentDimension(name,element,wantInner){var isBorderBox=CSS.getPropertyValue(element,"boxSizing").toString().toLowerCase() === "border-box";if(isBorderBox === (wantInner || false)){ /* in box-sizing mode, the CSS width / height accessors already give the outerWidth / outerHeight. */var i,value,augment=0,sides=name === "width"?["Left","Right"]:["Top","Bottom"],fields=["padding" + sides[0],"padding" + sides[1],"border" + sides[0] + "Width","border" + sides[1] + "Width"];for(i = 0;i < fields.length;i++) {value = parseFloat(CSS.getPropertyValue(element,fields[i]));if(!isNaN(value)){augment += value;}}return wantInner?-augment:augment;}return 0;}function getDimension(name,wantInner){return function(type,element,propertyValue){switch(type){case "name":return name;case "extract":return parseFloat(propertyValue) + augmentDimension(name,element,wantInner);case "inject":return parseFloat(propertyValue) - augmentDimension(name,element,wantInner) + "px";}};}CSS.Normalizations.registered.innerWidth = getDimension("width",true);CSS.Normalizations.registered.innerHeight = getDimension("height",true);CSS.Normalizations.registered.outerWidth = getDimension("width");CSS.Normalizations.registered.outerHeight = getDimension("height");}}, /************************
			 CSS Property Names
			 ************************/Names:{ /* Camelcase a property name into its JavaScript notation (e.g. "background-color" ==> "backgroundColor").
				 Camelcasing is used to normalize property names between and across calls. */camelCase:function camelCase(property){return property.replace(/-(\w)/g,function(match,subMatch){return subMatch.toUpperCase();});}, /* For SVG elements, some properties (namely, dimensional ones) are GET/SET via the element's HTML attributes (instead of via CSS styles). */SVGAttribute:function SVGAttribute(property){var SVGAttributes="width|height|x|y|cx|cy|r|rx|ry|x1|x2|y1|y2"; /* Certain browsers require an SVG transform to be applied as an attribute. (Otherwise, application via CSS is preferable due to 3D support.) */if(IE || Velocity.State.isAndroid && !Velocity.State.isChrome){SVGAttributes += "|transform";}return new RegExp("^(" + SVGAttributes + ")$","i").test(property);}, /* Determine whether a property should be set with a vendor prefix. */ /* If a prefixed version of the property exists, return it. Otherwise, return the original property name.
				 If the property is not at all supported by the browser, return a false flag. */prefixCheck:function prefixCheck(property){ /* If this property has already been checked, return the cached value. */if(Velocity.State.prefixMatches[property]){return [Velocity.State.prefixMatches[property],true];}else {var vendors=["","Webkit","Moz","ms","O"];for(var i=0,vendorsLength=vendors.length;i < vendorsLength;i++) {var propertyPrefixed;if(i === 0){propertyPrefixed = property;}else { /* Capitalize the first letter of the property to conform to JavaScript vendor prefix notation (e.g. webkitFilter). */propertyPrefixed = vendors[i] + property.replace(/^\w/,function(match){return match.toUpperCase();});} /* Check if the browser supports this property as prefixed. */if(Type.isString(Velocity.State.prefixElement.style[propertyPrefixed])){ /* Cache the match. */Velocity.State.prefixMatches[property] = propertyPrefixed;return [propertyPrefixed,true];}} /* If the browser doesn't support this property in any form, include a false flag so that the caller can decide how to proceed. */return [property,false];}}}, /************************
			 CSS Property Values
			 ************************/Values:{ /* Hex to RGB conversion. Copyright Tim Down: http://stackoverflow.com/questions/5623838/rgb-to-hex-and-hex-to-rgb */hexToRgb:function hexToRgb(hex){var shortformRegex=/^#?([a-f\d])([a-f\d])([a-f\d])$/i,longformRegex=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i,rgbParts;hex = hex.replace(shortformRegex,function(m,r,g,b){return r + r + g + g + b + b;});rgbParts = longformRegex.exec(hex);return rgbParts?[parseInt(rgbParts[1],16),parseInt(rgbParts[2],16),parseInt(rgbParts[3],16)]:[0,0,0];},isCSSNullValue:function isCSSNullValue(value){ /* The browser defaults CSS values that have not been set to either 0 or one of several possible null-value strings.
					 Thus, we check for both falsiness and these special strings. */ /* Null-value checking is performed to default the special strings to 0 (for the sake of tweening) or their hook
					 templates as defined as CSS.Hooks (for the sake of hook injection/extraction). */ /* Note: Chrome returns "rgba(0, 0, 0, 0)" for an undefined color whereas IE returns "transparent". */return !value || /^(none|auto|transparent|(rgba\(0, ?0, ?0, ?0\)))$/i.test(value);}, /* Retrieve a property's default unit type. Used for assigning a unit type when one is not supplied by the user. */getUnitType:function getUnitType(property){if(/^(rotate|skew)/i.test(property)){return "deg";}else if(/(^(scale|scaleX|scaleY|scaleZ|alpha|flexGrow|flexHeight|zIndex|fontWeight)$)|((opacity|red|green|blue|alpha)$)/i.test(property)){ /* The above properties are unitless. */return "";}else { /* Default to px for all other properties. */return "px";}}, /* HTML elements default to an associated display type when they're not set to display:none. */ /* Note: This function is used for correctly setting the non-"none" display value in certain Velocity redirects, such as fadeIn/Out. */getDisplayType:function getDisplayType(element){var tagName=element && element.tagName.toString().toLowerCase();if(/^(b|big|i|small|tt|abbr|acronym|cite|code|dfn|em|kbd|strong|samp|var|a|bdo|br|img|map|object|q|script|span|sub|sup|button|input|label|select|textarea)$/i.test(tagName)){return "inline";}else if(/^(li)$/i.test(tagName)){return "list-item";}else if(/^(tr)$/i.test(tagName)){return "table-row";}else if(/^(table)$/i.test(tagName)){return "table";}else if(/^(tbody)$/i.test(tagName)){return "table-row-group"; /* Default to "block" when no match is found. */}else {return "block";}}, /* The class add/remove functions are used to temporarily apply a "velocity-animating" class to elements while they're animating. */addClass:function addClass(element,className){if(element){if(element.classList){element.classList.add(className);}else if(Type.isString(element.className)){ // Element.className is around 15% faster then set/getAttribute
element.className += (element.className.length?" ":"") + className;}else { // Work around for IE strict mode animating SVG - and anything else that doesn't behave correctly - the same way jQuery does it
var currentClass=element.getAttribute(IE <= 7?"className":"class") || "";element.setAttribute("class",currentClass + (currentClass?" ":"") + className);}}},removeClass:function removeClass(element,className){if(element){if(element.classList){element.classList.remove(className);}else if(Type.isString(element.className)){ // Element.className is around 15% faster then set/getAttribute
// TODO: Need some jsperf tests on performance - can we get rid of the regex and maybe use split / array manipulation?
element.className = element.className.toString().replace(new RegExp("(^|\\s)" + className.split(" ").join("|") + "(\\s|$)","gi")," ");}else { // Work around for IE strict mode animating SVG - and anything else that doesn't behave correctly - the same way jQuery does it
var currentClass=element.getAttribute(IE <= 7?"className":"class") || "";element.setAttribute("class",currentClass.replace(new RegExp("(^|\s)" + className.split(" ").join("|") + "(\s|$)","gi")," "));}}}}, /****************************
			 Style Getting & Setting
			 ****************************/ /* The singular getPropertyValue, which routes the logic for all normalizations, hooks, and standard CSS properties. */getPropertyValue:function getPropertyValue(element,property,rootPropertyValue,forceStyleLookup){ /* Get an element's computed property value. */ /* Note: Retrieving the value of a CSS property cannot simply be performed by checking an element's
				 style attribute (which only reflects user-defined values). Instead, the browser must be queried for a property's
				 *computed* value. You can read more about getComputedStyle here: https://developer.mozilla.org/en/docs/Web/API/window.getComputedStyle */function computePropertyValue(element,property){ /* When box-sizing isn't set to border-box, height and width style values are incorrectly computed when an
					 element's scrollbars are visible (which expands the element's dimensions). Thus, we defer to the more accurate
					 offsetHeight/Width property, which includes the total dimensions for interior, border, padding, and scrollbar.
					 We subtract border and padding to get the sum of interior + scrollbar. */var computedValue=0; /* IE<=8 doesn't support window.getComputedStyle, thus we defer to jQuery, which has an extensive array
					 of hacks to accurately retrieve IE8 property values. Re-implementing that logic here is not worth bloating the
					 codebase for a dying browser. The performance repercussions of using jQuery here are minimal since
					 Velocity is optimized to rarely (and sometimes never) query the DOM. Further, the $.css() codepath isn't that slow. */if(IE <= 8){computedValue = $.css(element,property); /* GET */ /* All other browsers support getComputedStyle. The returned live object reference is cached onto its
						 associated element so that it does not need to be refetched upon every GET. */}else { /* Browsers do not return height and width values for elements that are set to display:"none". Thus, we temporarily
						 toggle display to the element type's default value. */var toggleDisplay=false;if(/^(width|height)$/.test(property) && CSS.getPropertyValue(element,"display") === 0){toggleDisplay = true;CSS.setPropertyValue(element,"display",CSS.Values.getDisplayType(element));}var revertDisplay=function revertDisplay(){if(toggleDisplay){CSS.setPropertyValue(element,"display","none");}};if(!forceStyleLookup){if(property === "height" && CSS.getPropertyValue(element,"boxSizing").toString().toLowerCase() !== "border-box"){var contentBoxHeight=element.offsetHeight - (parseFloat(CSS.getPropertyValue(element,"borderTopWidth")) || 0) - (parseFloat(CSS.getPropertyValue(element,"borderBottomWidth")) || 0) - (parseFloat(CSS.getPropertyValue(element,"paddingTop")) || 0) - (parseFloat(CSS.getPropertyValue(element,"paddingBottom")) || 0);revertDisplay();return contentBoxHeight;}else if(property === "width" && CSS.getPropertyValue(element,"boxSizing").toString().toLowerCase() !== "border-box"){var contentBoxWidth=element.offsetWidth - (parseFloat(CSS.getPropertyValue(element,"borderLeftWidth")) || 0) - (parseFloat(CSS.getPropertyValue(element,"borderRightWidth")) || 0) - (parseFloat(CSS.getPropertyValue(element,"paddingLeft")) || 0) - (parseFloat(CSS.getPropertyValue(element,"paddingRight")) || 0);revertDisplay();return contentBoxWidth;}}var computedStyle; /* For elements that Velocity hasn't been called on directly (e.g. when Velocity queries the DOM on behalf
						 of a parent of an element its animating), perform a direct getComputedStyle lookup since the object isn't cached. */if(Data(element) === undefined){computedStyle = window.getComputedStyle(element,null); /* GET */ /* If the computedStyle object has yet to be cached, do so now. */}else if(!Data(element).computedStyle){computedStyle = Data(element).computedStyle = window.getComputedStyle(element,null); /* GET */ /* If computedStyle is cached, use it. */}else {computedStyle = Data(element).computedStyle;} /* IE and Firefox do not return a value for the generic borderColor -- they only return individual values for each border side's color.
						 Also, in all browsers, when border colors aren't all the same, a compound value is returned that Velocity isn't setup to parse.
						 So, as a polyfill for querying individual border side colors, we just return the top border's color and animate all borders from that value. */if(property === "borderColor"){property = "borderTopColor";} /* IE9 has a bug in which the "filter" property must be accessed from computedStyle using the getPropertyValue method
						 instead of a direct property lookup. The getPropertyValue method is slower than a direct lookup, which is why we avoid it by default. */if(IE === 9 && property === "filter"){computedValue = computedStyle.getPropertyValue(property); /* GET */}else {computedValue = computedStyle[property];} /* Fall back to the property's style value (if defined) when computedValue returns nothing,
						 which can happen when the element hasn't been painted. */if(computedValue === "" || computedValue === null){computedValue = element.style[property];}revertDisplay();} /* For top, right, bottom, and left (TRBL) values that are set to "auto" on elements of "fixed" or "absolute" position,
					 defer to jQuery for converting "auto" to a numeric value. (For elements with a "static" or "relative" position, "auto" has the same
					 effect as being set to 0, so no conversion is necessary.) */ /* An example of why numeric conversion is necessary: When an element with "position:absolute" has an untouched "left"
					 property, which reverts to "auto", left's value is 0 relative to its parent element, but is often non-zero relative
					 to its *containing* (not parent) element, which is the nearest "position:relative" ancestor or the viewport (and always the viewport in the case of "position:fixed"). */if(computedValue === "auto" && /^(top|right|bottom|left)$/i.test(property)){var position=computePropertyValue(element,"position"); /* GET */ /* For absolute positioning, jQuery's $.position() only returns values for top and left;
						 right and bottom will have their "auto" value reverted to 0. */ /* Note: A jQuery object must be created here since jQuery doesn't have a low-level alias for $.position().
						 Not a big deal since we're currently in a GET batch anyway. */if(position === "fixed" || position === "absolute" && /top|left/i.test(property)){ /* Note: jQuery strips the pixel unit from its returned values; we re-add it here to conform with computePropertyValue's behavior. */computedValue = $(element).position()[property] + "px"; /* GET */}}return computedValue;}var propertyValue; /* If this is a hooked property (e.g. "clipLeft" instead of the root property of "clip"),
				 extract the hook's value from a normalized rootPropertyValue using CSS.Hooks.extractValue(). */if(CSS.Hooks.registered[property]){var hook=property,hookRoot=CSS.Hooks.getRoot(hook); /* If a cached rootPropertyValue wasn't passed in (which Velocity always attempts to do in order to avoid requerying the DOM),
					 query the DOM for the root property's value. */if(rootPropertyValue === undefined){ /* Since the browser is now being directly queried, use the official post-prefixing property name for this lookup. */rootPropertyValue = CSS.getPropertyValue(element,CSS.Names.prefixCheck(hookRoot)[0]); /* GET */} /* If this root has a normalization registered, peform the associated normalization extraction. */if(CSS.Normalizations.registered[hookRoot]){rootPropertyValue = CSS.Normalizations.registered[hookRoot]("extract",element,rootPropertyValue);} /* Extract the hook's value. */propertyValue = CSS.Hooks.extractValue(hook,rootPropertyValue); /* If this is a normalized property (e.g. "opacity" becomes "filter" in <=IE8) or "translateX" becomes "transform"),
					 normalize the property's name and value, and handle the special case of transforms. */ /* Note: Normalizing a property is mutually exclusive from hooking a property since hook-extracted values are strictly
					 numerical and therefore do not require normalization extraction. */}else if(CSS.Normalizations.registered[property]){var normalizedPropertyName,normalizedPropertyValue;normalizedPropertyName = CSS.Normalizations.registered[property]("name",element); /* Transform values are calculated via normalization extraction (see below), which checks against the element's transformCache.
					 At no point do transform GETs ever actually query the DOM; initial stylesheet values are never processed.
					 This is because parsing 3D transform matrices is not always accurate and would bloat our codebase;
					 thus, normalization extraction defaults initial transform values to their zero-values (e.g. 1 for scaleX and 0 for translateX). */if(normalizedPropertyName !== "transform"){normalizedPropertyValue = computePropertyValue(element,CSS.Names.prefixCheck(normalizedPropertyName)[0]); /* GET */ /* If the value is a CSS null-value and this property has a hook template, use that zero-value template so that hooks can be extracted from it. */if(CSS.Values.isCSSNullValue(normalizedPropertyValue) && CSS.Hooks.templates[property]){normalizedPropertyValue = CSS.Hooks.templates[property][1];}}propertyValue = CSS.Normalizations.registered[property]("extract",element,normalizedPropertyValue);} /* If a (numeric) value wasn't produced via hook extraction or normalization, query the DOM. */if(!/^[\d-]/.test(propertyValue)){ /* For SVG elements, dimensional properties (which SVGAttribute() detects) are tweened via
					 their HTML attribute values instead of their CSS style values. */var data=Data(element);if(data && data.isSVG && CSS.Names.SVGAttribute(property)){ /* Since the height/width attribute values must be set manually, they don't reflect computed values.
						 Thus, we use use getBBox() to ensure we always get values for elements with undefined height/width attributes. */if(/^(height|width)$/i.test(property)){ /* Firefox throws an error if .getBBox() is called on an SVG that isn't attached to the DOM. */try{propertyValue = element.getBBox()[property];}catch(error) {propertyValue = 0;} /* Otherwise, access the attribute value directly. */}else {propertyValue = element.getAttribute(property);}}else {propertyValue = computePropertyValue(element,CSS.Names.prefixCheck(property)[0]); /* GET */}} /* Since property lookups are for animation purposes (which entails computing the numeric delta between start and end values),
				 convert CSS null-values to an integer of value 0. */if(CSS.Values.isCSSNullValue(propertyValue)){propertyValue = 0;}if(Velocity.debug >= 2){console.log("Get " + property + ": " + propertyValue);}return propertyValue;}, /* The singular setPropertyValue, which routes the logic for all normalizations, hooks, and standard CSS properties. */setPropertyValue:function setPropertyValue(element,property,propertyValue,rootPropertyValue,scrollData){var propertyName=property; /* In order to be subjected to call options and element queueing, scroll animation is routed through Velocity as if it were a standard CSS property. */if(property === "scroll"){ /* If a container option is present, scroll the container instead of the browser window. */if(scrollData.container){scrollData.container["scroll" + scrollData.direction] = propertyValue; /* Otherwise, Velocity defaults to scrolling the browser window. */}else {if(scrollData.direction === "Left"){window.scrollTo(propertyValue,scrollData.alternateValue);}else {window.scrollTo(scrollData.alternateValue,propertyValue);}}}else { /* Transforms (translateX, rotateZ, etc.) are applied to a per-element transformCache object, which is manually flushed via flushTransformCache().
					 Thus, for now, we merely cache transforms being SET. */if(CSS.Normalizations.registered[property] && CSS.Normalizations.registered[property]("name",element) === "transform"){ /* Perform a normalization injection. */ /* Note: The normalization logic handles the transformCache updating. */CSS.Normalizations.registered[property]("inject",element,propertyValue);propertyName = "transform";propertyValue = Data(element).transformCache[property];}else { /* Inject hooks. */if(CSS.Hooks.registered[property]){var hookName=property,hookRoot=CSS.Hooks.getRoot(property); /* If a cached rootPropertyValue was not provided, query the DOM for the hookRoot's current value. */rootPropertyValue = rootPropertyValue || CSS.getPropertyValue(element,hookRoot); /* GET */propertyValue = CSS.Hooks.injectValue(hookName,propertyValue,rootPropertyValue);property = hookRoot;} /* Normalize names and values. */if(CSS.Normalizations.registered[property]){propertyValue = CSS.Normalizations.registered[property]("inject",element,propertyValue);property = CSS.Normalizations.registered[property]("name",element);} /* Assign the appropriate vendor prefix before performing an official style update. */propertyName = CSS.Names.prefixCheck(property)[0]; /* A try/catch is used for IE<=8, which throws an error when "invalid" CSS values are set, e.g. a negative width.
						 Try/catch is avoided for other browsers since it incurs a performance overhead. */if(IE <= 8){try{element.style[propertyName] = propertyValue;}catch(error) {if(Velocity.debug){console.log("Browser does not support [" + propertyValue + "] for [" + propertyName + "]");}} /* SVG elements have their dimensional properties (width, height, x, y, cx, etc.) applied directly as attributes instead of as styles. */ /* Note: IE8 does not support SVG elements, so it's okay that we skip it for SVG animation. */}else {var data=Data(element);if(data && data.isSVG && CSS.Names.SVGAttribute(property)){ /* Note: For SVG attributes, vendor-prefixed property names are never used. */ /* Note: Not all CSS properties can be animated via attributes, but the browser won't throw an error for unsupported properties. */element.setAttribute(property,propertyValue);}else {element.style[propertyName] = propertyValue;}}if(Velocity.debug >= 2){console.log("Set " + property + " (" + propertyName + "): " + propertyValue);}}} /* Return the normalized property name and value in case the caller wants to know how these values were modified before being applied to the DOM. */return [propertyName,propertyValue];}, /* To increase performance by batching transform updates into a single SET, transforms are not directly applied to an element until flushTransformCache() is called. */ /* Note: Velocity applies transform properties in the same order that they are chronogically introduced to the element's CSS styles. */flushTransformCache:function flushTransformCache(element){var transformString="",data=Data(element); /* Certain browsers require that SVG transforms be applied as an attribute. However, the SVG transform attribute takes a modified version of CSS's transform string
				 (units are dropped and, except for skewX/Y, subproperties are merged into their master property -- e.g. scaleX and scaleY are merged into scale(X Y). */if((IE || Velocity.State.isAndroid && !Velocity.State.isChrome) && data && data.isSVG){ /* Since transform values are stored in their parentheses-wrapped form, we use a helper function to strip out their numeric values.
					 Further, SVG transform properties only take unitless (representing pixels) values, so it's okay that parseFloat() strips the unit suffixed to the float value. */var getTransformFloat=function getTransformFloat(transformProperty){return parseFloat(CSS.getPropertyValue(element,transformProperty));}; /* Create an object to organize all the transforms that we'll apply to the SVG element. To keep the logic simple,
					 we process *all* transform properties -- even those that may not be explicitly applied (since they default to their zero-values anyway). */var SVGTransforms={translate:[getTransformFloat("translateX"),getTransformFloat("translateY")],skewX:[getTransformFloat("skewX")],skewY:[getTransformFloat("skewY")], /* If the scale property is set (non-1), use that value for the scaleX and scaleY values
						 (this behavior mimics the result of animating all these properties at once on HTML elements). */scale:getTransformFloat("scale") !== 1?[getTransformFloat("scale"),getTransformFloat("scale")]:[getTransformFloat("scaleX"),getTransformFloat("scaleY")], /* Note: SVG's rotate transform takes three values: rotation degrees followed by the X and Y values
						 defining the rotation's origin point. We ignore the origin values (default them to 0). */rotate:[getTransformFloat("rotateZ"),0,0]}; /* Iterate through the transform properties in the user-defined property map order.
					 (This mimics the behavior of non-SVG transform animation.) */$.each(Data(element).transformCache,function(transformName){ /* Except for with skewX/Y, revert the axis-specific transform subproperties to their axis-free master
						 properties so that they match up with SVG's accepted transform properties. */if(/^translate/i.test(transformName)){transformName = "translate";}else if(/^scale/i.test(transformName)){transformName = "scale";}else if(/^rotate/i.test(transformName)){transformName = "rotate";} /* Check that we haven't yet deleted the property from the SVGTransforms container. */if(SVGTransforms[transformName]){ /* Append the transform property in the SVG-supported transform format. As per the spec, surround the space-delimited values in parentheses. */transformString += transformName + "(" + SVGTransforms[transformName].join(" ") + ")" + " "; /* After processing an SVG transform property, delete it from the SVGTransforms container so we don't
							 re-insert the same master property if we encounter another one of its axis-specific properties. */delete SVGTransforms[transformName];}});}else {var transformValue,perspective; /* Transform properties are stored as members of the transformCache object. Concatenate all the members into a string. */$.each(Data(element).transformCache,function(transformName){transformValue = Data(element).transformCache[transformName]; /* Transform's perspective subproperty must be set first in order to take effect. Store it temporarily. */if(transformName === "transformPerspective"){perspective = transformValue;return true;} /* IE9 only supports one rotation type, rotateZ, which it refers to as "rotate". */if(IE === 9 && transformName === "rotateZ"){transformName = "rotate";}transformString += transformName + transformValue + " ";}); /* If present, set the perspective subproperty first. */if(perspective){transformString = "perspective" + perspective + " " + transformString;}}CSS.setPropertyValue(element,"transform",transformString);}}; /* Register hooks and normalizations. */CSS.Hooks.register();CSS.Normalizations.register(); /* Allow hook setting in the same fashion as jQuery's $.css(). */Velocity.hook = function(elements,arg2,arg3){var value;elements = sanitizeElements(elements);$.each(elements,function(i,element){ /* Initialize Velocity's per-element data cache if this element hasn't previously been animated. */if(Data(element) === undefined){Velocity.init(element);} /* Get property value. If an element set was passed in, only return the value for the first element. */if(arg3 === undefined){if(value === undefined){value = CSS.getPropertyValue(element,arg2);} /* Set property value. */}else { /* sPV returns an array of the normalized propertyName/propertyValue pair used to update the DOM. */var adjustedSet=CSS.setPropertyValue(element,arg2,arg3); /* Transform properties don't automatically set. They have to be flushed to the DOM. */if(adjustedSet[0] === "transform"){Velocity.CSS.flushTransformCache(element);}value = adjustedSet;}});return value;}; /*****************
		 Animation
		 *****************/var animate=function animate(){var opts; /******************
			 Call Chain
			 ******************/ /* Logic for determining what to return to the call stack when exiting out of Velocity. */function getChain(){ /* If we are using the utility function, attempt to return this call's promise. If no promise library was detected,
				 default to null instead of returning the targeted elements so that utility function's return value is standardized. */if(isUtility){return promiseData.promise || null; /* Otherwise, if we're using $.fn, return the jQuery-/Zepto-wrapped element set. */}else {return elementsWrapped;}} /*************************
			 Arguments Assignment
			 *************************/ /* To allow for expressive CoffeeScript code, Velocity supports an alternative syntax in which "elements" (or "e"), "properties" (or "p"), and "options" (or "o")
			 objects are defined on a container object that's passed in as Velocity's sole argument. */ /* Note: Some browsers automatically populate arguments with a "properties" object. We detect it by checking for its default "names" property. */var syntacticSugar=arguments[0] && (arguments[0].p || $.isPlainObject(arguments[0].properties) && !arguments[0].properties.names || Type.isString(arguments[0].properties)), /* Whether Velocity was called via the utility function (as opposed to on a jQuery/Zepto object). */isUtility, /* When Velocity is called via the utility function ($.Velocity()/Velocity()), elements are explicitly
					 passed in as the first parameter. Thus, argument positioning varies. We normalize them here. */elementsWrapped,argumentIndex;var elements,propertiesMap,options; /* Detect jQuery/Zepto elements being animated via the $.fn method. */if(Type.isWrapped(this)){isUtility = false;argumentIndex = 0;elements = this;elementsWrapped = this; /* Otherwise, raw elements are being animated via the utility function. */}else {isUtility = true;argumentIndex = 1;elements = syntacticSugar?arguments[0].elements || arguments[0].e:arguments[0];} /***************
			 Promises
			 ***************/var promiseData={promise:null,resolver:null,rejecter:null}; /* If this call was made via the utility function (which is the default method of invocation when jQuery/Zepto are not being used), and if
			 promise support was detected, create a promise object for this call and store references to its resolver and rejecter methods. The resolve
			 method is used when a call completes naturally or is prematurely stopped by the user. In both cases, completeCall() handles the associated
			 call cleanup and promise resolving logic. The reject method is used when an invalid set of arguments is passed into a Velocity call. */ /* Note: Velocity employs a call-based queueing architecture, which means that stopping an animating element actually stops the full call that
			 triggered it -- not that one element exclusively. Similarly, there is one promise per call, and all elements targeted by a Velocity call are
			 grouped together for the purposes of resolving and rejecting a promise. */if(isUtility && Velocity.Promise){promiseData.promise = new Velocity.Promise(function(resolve,reject){promiseData.resolver = resolve;promiseData.rejecter = reject;});}if(syntacticSugar){propertiesMap = arguments[0].properties || arguments[0].p;options = arguments[0].options || arguments[0].o;}else {propertiesMap = arguments[argumentIndex];options = arguments[argumentIndex + 1];}elements = sanitizeElements(elements);if(!elements){if(promiseData.promise){if(!propertiesMap || !options || options.promiseRejectEmpty !== false){promiseData.rejecter();}else {promiseData.resolver();}}return;} /* The length of the element set (in the form of a nodeList or an array of elements) is defaulted to 1 in case a
			 single raw DOM element is passed in (which doesn't contain a length property). */var elementsLength=elements.length,elementsIndex=0; /***************************
			 Argument Overloading
			 ***************************/ /* Support is included for jQuery's argument overloading: $.animate(propertyMap [, duration] [, easing] [, complete]).
			 Overloading is detected by checking for the absence of an object being passed into options. */ /* Note: The stop/finish/pause/resume actions do not accept animation options, and are therefore excluded from this check. */if(!/^(stop|finish|finishAll|pause|resume)$/i.test(propertiesMap) && !$.isPlainObject(options)){ /* The utility function shifts all arguments one position to the right, so we adjust for that offset. */var startingArgumentPosition=argumentIndex + 1;options = {}; /* Iterate through all options arguments */for(var i=startingArgumentPosition;i < arguments.length;i++) { /* Treat a number as a duration. Parse it out. */ /* Note: The following RegEx will return true if passed an array with a number as its first item.
					 Thus, arrays are skipped from this check. */if(!Type.isArray(arguments[i]) && (/^(fast|normal|slow)$/i.test(arguments[i]) || /^\d/.test(arguments[i]))){options.duration = arguments[i]; /* Treat strings and arrays as easings. */}else if(Type.isString(arguments[i]) || Type.isArray(arguments[i])){options.easing = arguments[i]; /* Treat a function as a complete callback. */}else if(Type.isFunction(arguments[i])){options.complete = arguments[i];}}} /*********************
			 Action Detection
			 *********************/ /* Velocity's behavior is categorized into "actions": Elements can either be specially scrolled into view,
			 or they can be started, stopped, paused, resumed, or reversed . If a literal or referenced properties map is passed in as Velocity's
			 first argument, the associated action is "start". Alternatively, "scroll", "reverse", "pause", "resume" or "stop" can be passed in 
			 instead of a properties map. */var action;switch(propertiesMap){case "scroll":action = "scroll";break;case "reverse":action = "reverse";break;case "pause": /*******************
					 Action: Pause
					 *******************/var currentTime=new Date().getTime(); /* Handle delay timers */$.each(elements,function(i,element){pauseDelayOnElement(element,currentTime);}); /* Pause and Resume are call-wide (not on a per element basis). Thus, calling pause or resume on a 
					 single element will cause any calls that containt tweens for that element to be paused/resumed
					 as well. */ /* Iterate through all calls and pause any that contain any of our elements */$.each(Velocity.State.calls,function(i,activeCall){var found=false; /* Inactive calls are set to false by the logic inside completeCall(). Skip them. */if(activeCall){ /* Iterate through the active call's targeted elements. */$.each(activeCall[1],function(k,activeElement){var queueName=options === undefined?"":options;if(queueName !== true && activeCall[2].queue !== queueName && !(options === undefined && activeCall[2].queue === false)){return true;} /* Iterate through the calls targeted by the stop command. */$.each(elements,function(l,element){ /* Check that this call was applied to the target element. */if(element === activeElement){ /* Set call to paused */activeCall[5] = {resume:false}; /* Once we match an element, we can bounce out to the next call entirely */found = true;return false;}}); /* Proceed to check next call if we have already matched */if(found){return false;}});}}); /* Since pause creates no new tweens, exit out of Velocity. */return getChain();case "resume": /*******************
					 Action: Resume
					 *******************/ /* Handle delay timers */$.each(elements,function(i,element){resumeDelayOnElement(element,currentTime);}); /* Pause and Resume are call-wide (not on a per elemnt basis). Thus, calling pause or resume on a 
					 single element will cause any calls that containt tweens for that element to be paused/resumed
					 as well. */ /* Iterate through all calls and pause any that contain any of our elements */$.each(Velocity.State.calls,function(i,activeCall){var found=false; /* Inactive calls are set to false by the logic inside completeCall(). Skip them. */if(activeCall){ /* Iterate through the active call's targeted elements. */$.each(activeCall[1],function(k,activeElement){var queueName=options === undefined?"":options;if(queueName !== true && activeCall[2].queue !== queueName && !(options === undefined && activeCall[2].queue === false)){return true;} /* Skip any calls that have never been paused */if(!activeCall[5]){return true;} /* Iterate through the calls targeted by the stop command. */$.each(elements,function(l,element){ /* Check that this call was applied to the target element. */if(element === activeElement){ /* Flag a pause object to be resumed, which will occur during the next tick. In
										 addition, the pause object will at that time be deleted */activeCall[5].resume = true; /* Once we match an element, we can bounce out to the next call entirely */found = true;return false;}}); /* Proceed to check next call if we have already matched */if(found){return false;}});}}); /* Since resume creates no new tweens, exit out of Velocity. */return getChain();case "finish":case "finishAll":case "stop": /*******************
					 Action: Stop
					 *******************/ /* Clear the currently-active delay on each targeted element. */$.each(elements,function(i,element){if(Data(element) && Data(element).delayTimer){ /* Stop the timer from triggering its cached next() function. */clearTimeout(Data(element).delayTimer.setTimeout); /* Manually call the next() function so that the subsequent queue items can progress. */if(Data(element).delayTimer.next){Data(element).delayTimer.next();}delete Data(element).delayTimer;} /* If we want to finish everything in the queue, we have to iterate through it
						 and call each function. This will make them active calls below, which will
						 cause them to be applied via the duration setting. */if(propertiesMap === "finishAll" && (options === true || Type.isString(options))){ /* Iterate through the items in the element's queue. */$.each($.queue(element,Type.isString(options)?options:""),function(_,item){ /* The queue array can contain an "inprogress" string, which we skip. */if(Type.isFunction(item)){item();}}); /* Clearing the $.queue() array is achieved by resetting it to []. */$.queue(element,Type.isString(options)?options:"",[]);}});var callsToStop=[]; /* When the stop action is triggered, the elements' currently active call is immediately stopped. The active call might have
					 been applied to multiple elements, in which case all of the call's elements will be stopped. When an element
					 is stopped, the next item in its animation queue is immediately triggered. */ /* An additional argument may be passed in to clear an element's remaining queued calls. Either true (which defaults to the "fx" queue)
					 or a custom queue string can be passed in. */ /* Note: The stop command runs prior to Velocity's Queueing phase since its behavior is intended to take effect *immediately*,
					 regardless of the element's current queue state. */ /* Iterate through every active call. */$.each(Velocity.State.calls,function(i,activeCall){ /* Inactive calls are set to false by the logic inside completeCall(). Skip them. */if(activeCall){ /* Iterate through the active call's targeted elements. */$.each(activeCall[1],function(k,activeElement){ /* If true was passed in as a secondary argument, clear absolutely all calls on this element. Otherwise, only
								 clear calls associated with the relevant queue. */ /* Call stopping logic works as follows:
								 - options === true --> stop current default queue calls (and queue:false calls), including remaining queued ones.
								 - options === undefined --> stop current queue:"" call and all queue:false calls.
								 - options === false --> stop only queue:false calls.
								 - options === "custom" --> stop current queue:"custom" call, including remaining queued ones (there is no functionality to only clear the currently-running queue:"custom" call). */var queueName=options === undefined?"":options;if(queueName !== true && activeCall[2].queue !== queueName && !(options === undefined && activeCall[2].queue === false)){return true;} /* Iterate through the calls targeted by the stop command. */$.each(elements,function(l,element){ /* Check that this call was applied to the target element. */if(element === activeElement){ /* Optionally clear the remaining queued calls. If we're doing "finishAll" this won't find anything,
										 due to the queue-clearing above. */if(options === true || Type.isString(options)){ /* Iterate through the items in the element's queue. */$.each($.queue(element,Type.isString(options)?options:""),function(_,item){ /* The queue array can contain an "inprogress" string, which we skip. */if(Type.isFunction(item)){ /* Pass the item's callback a flag indicating that we want to abort from the queue call.
													 (Specifically, the queue will resolve the call's associated promise then abort.)  */item(null,true);}}); /* Clearing the $.queue() array is achieved by resetting it to []. */$.queue(element,Type.isString(options)?options:"",[]);}if(propertiesMap === "stop"){ /* Since "reverse" uses cached start values (the previous call's endValues), these values must be
											 changed to reflect the final value that the elements were actually tweened to. */ /* Note: If only queue:false/queue:"custom" animations are currently running on an element, it won't have a tweensContainer
											 object. Also, queue:false/queue:"custom" animations can't be reversed. */var data=Data(element);if(data && data.tweensContainer && (queueName === true || queueName === "")){$.each(data.tweensContainer,function(m,activeTween){activeTween.endValue = activeTween.currentValue;});}callsToStop.push(i);}else if(propertiesMap === "finish" || propertiesMap === "finishAll"){ /* To get active tweens to finish immediately, we forcefully shorten their durations to 1ms so that
											 they finish upon the next rAf tick then proceed with normal call completion logic. */activeCall[2].duration = 1;}}});});}}); /* Prematurely call completeCall() on each matched active call. Pass an additional flag for "stop" to indicate
					 that the complete callback and display:none setting should be skipped since we're completing prematurely. */if(propertiesMap === "stop"){$.each(callsToStop,function(i,j){completeCall(j,true);});if(promiseData.promise){ /* Immediately resolve the promise associated with this stop call since stop runs synchronously. */promiseData.resolver(elements);}} /* Since we're stopping, and not proceeding with queueing, exit out of Velocity. */return getChain();default: /* Treat a non-empty plain object as a literal properties map. */if($.isPlainObject(propertiesMap) && !Type.isEmptyObject(propertiesMap)){action = "start"; /****************
						 Redirects
						 ****************/ /* Check if a string matches a registered redirect (see Redirects above). */}else if(Type.isString(propertiesMap) && Velocity.Redirects[propertiesMap]){opts = $.extend({},options);var durationOriginal=opts.duration,delayOriginal=opts.delay || 0; /* If the backwards option was passed in, reverse the element set so that elements animate from the last to the first. */if(opts.backwards === true){elements = $.extend(true,[],elements).reverse();} /* Individually trigger the redirect for each element in the set to prevent users from having to handle iteration logic in their redirect. */$.each(elements,function(elementIndex,element){ /* If the stagger option was passed in, successively delay each element by the stagger value (in ms). Retain the original delay value. */if(parseFloat(opts.stagger)){opts.delay = delayOriginal + parseFloat(opts.stagger) * elementIndex;}else if(Type.isFunction(opts.stagger)){opts.delay = delayOriginal + opts.stagger.call(element,elementIndex,elementsLength);} /* If the drag option was passed in, successively increase/decrease (depending on the presense of opts.backwards)
							 the duration of each element's animation, using floors to prevent producing very short durations. */if(opts.drag){ /* Default the duration of UI pack effects (callouts and transitions) to 1000ms instead of the usual default duration of 400ms. */opts.duration = parseFloat(durationOriginal) || (/^(callout|transition)/.test(propertiesMap)?1000:DURATION_DEFAULT); /* For each element, take the greater duration of: A) animation completion percentage relative to the original duration,
								 B) 75% of the original duration, or C) a 200ms fallback (in case duration is already set to a low value).
								 The end result is a baseline of 75% of the redirect's duration that increases/decreases as the end of the element set is approached. */opts.duration = Math.max(opts.duration * (opts.backwards?1 - elementIndex / elementsLength:(elementIndex + 1) / elementsLength),opts.duration * 0.75,200);} /* Pass in the call's opts object so that the redirect can optionally extend it. It defaults to an empty object instead of null to
							 reduce the opts checking logic required inside the redirect. */Velocity.Redirects[propertiesMap].call(element,element,opts || {},elementIndex,elementsLength,elements,promiseData.promise?promiseData:undefined);}); /* Since the animation logic resides within the redirect's own code, abort the remainder of this call.
						 (The performance overhead up to this point is virtually non-existant.) */ /* Note: The jQuery call chain is kept intact by returning the complete element set. */return getChain();}else {var abortError="Velocity: First argument (" + propertiesMap + ") was not a property map, a known action, or a registered redirect. Aborting.";if(promiseData.promise){promiseData.rejecter(new Error(abortError));}else if(window.console){console.log(abortError);}return getChain();}} /**************************
			 Call-Wide Variables
			 **************************/ /* A container for CSS unit conversion ratios (e.g. %, rem, and em ==> px) that is used to cache ratios across all elements
			 being animated in a single Velocity call. Calculating unit ratios necessitates DOM querying and updating, and is therefore
			 avoided (via caching) wherever possible. This container is call-wide instead of page-wide to avoid the risk of using stale
			 conversion metrics across Velocity animations that are not immediately consecutively chained. */var callUnitConversionData={lastParent:null,lastPosition:null,lastFontSize:null,lastPercentToPxWidth:null,lastPercentToPxHeight:null,lastEmToPx:null,remToPx:null,vwToPx:null,vhToPx:null}; /* A container for all the ensuing tween data and metadata associated with this call. This container gets pushed to the page-wide
			 Velocity.State.calls array that is processed during animation ticking. */var call=[]; /************************
			 Element Processing
			 ************************/ /* Element processing consists of three parts -- data processing that cannot go stale and data processing that *can* go stale (i.e. third-party style modifications):
			 1) Pre-Queueing: Element-wide variables, including the element's data storage, are instantiated. Call options are prepared. If triggered, the Stop action is executed.
			 2) Queueing: The logic that runs once this call has reached its point of execution in the element's $.queue() stack. Most logic is placed here to avoid risking it becoming stale.
			 3) Pushing: Consolidation of the tween data followed by its push onto the global in-progress calls container.
			 `elementArrayIndex` allows passing index of the element in the original array to value functions.
			 If `elementsIndex` were used instead the index would be determined by the elements' per-element queue.
			 */function processElement(element,elementArrayIndex){ /*************************
				 Part I: Pre-Queueing
				 *************************/ /***************************
				 Element-Wide Variables
				 ***************************/var  /* The runtime opts object is the extension of the current call's options and Velocity's page-wide option defaults. */opts=$.extend({},Velocity.defaults,options), /* A container for the processed data associated with each property in the propertyMap.
						 (Each property in the map produces its own "tween".) */tweensContainer={},elementUnitConversionData; /******************
				 Element Init
				 ******************/if(Data(element) === undefined){Velocity.init(element);} /******************
				 Option: Delay
				 ******************/ /* Since queue:false doesn't respect the item's existing queue, we avoid injecting its delay here (it's set later on). */ /* Note: Velocity rolls its own delay function since jQuery doesn't have a utility alias for $.fn.delay()
				 (and thus requires jQuery element creation, which we avoid since its overhead includes DOM querying). */if(parseFloat(opts.delay) && opts.queue !== false){$.queue(element,opts.queue,function(next,clearQueue){if(clearQueue === true){ /* Do not continue with animation queueing. */return true;} /* This is a flag used to indicate to the upcoming completeCall() function that this queue entry was initiated by Velocity. See completeCall() for further details. */Velocity.velocityQueueEntryFlag = true; /* The ensuing queue item (which is assigned to the "next" argument that $.queue() automatically passes in) will be triggered after a setTimeout delay.
						 The setTimeout is stored so that it can be subjected to clearTimeout() if this animation is prematurely stopped via Velocity's "stop" command, and
						 delayBegin/delayTime is used to ensure we can "pause" and "resume" a tween that is still mid-delay. */ /* Temporarily store delayed elements to facilite access for global pause/resume */var callIndex=Velocity.State.delayedElements.count++;Velocity.State.delayedElements[callIndex] = element;var delayComplete=(function(index){return function(){ /* Clear the temporary element */Velocity.State.delayedElements[index] = false; /* Finally, issue the call */next();};})(callIndex);Data(element).delayBegin = new Date().getTime();Data(element).delay = parseFloat(opts.delay);Data(element).delayTimer = {setTimeout:setTimeout(next,parseFloat(opts.delay)),next:delayComplete};});} /*********************
				 Option: Duration
				 *********************/ /* Support for jQuery's named durations. */switch(opts.duration.toString().toLowerCase()){case "fast":opts.duration = 200;break;case "normal":opts.duration = DURATION_DEFAULT;break;case "slow":opts.duration = 600;break;default: /* Remove the potential "ms" suffix and default to 1 if the user is attempting to set a duration of 0 (in order to produce an immediate style change). */opts.duration = parseFloat(opts.duration) || 1;} /************************
				 Global Option: Mock
				 ************************/if(Velocity.mock !== false){ /* In mock mode, all animations are forced to 1ms so that they occur immediately upon the next rAF tick.
					 Alternatively, a multiplier can be passed in to time remap all delays and durations. */if(Velocity.mock === true){opts.duration = opts.delay = 1;}else {opts.duration *= parseFloat(Velocity.mock) || 1;opts.delay *= parseFloat(Velocity.mock) || 1;}} /*******************
				 Option: Easing
				 *******************/opts.easing = getEasing(opts.easing,opts.duration); /**********************
				 Option: Callbacks
				 **********************/ /* Callbacks must functions. Otherwise, default to null. */if(opts.begin && !Type.isFunction(opts.begin)){opts.begin = null;}if(opts.progress && !Type.isFunction(opts.progress)){opts.progress = null;}if(opts.complete && !Type.isFunction(opts.complete)){opts.complete = null;} /*********************************
				 Option: Display & Visibility
				 *********************************/ /* Refer to Velocity's documentation (VelocityJS.org/#displayAndVisibility) for a description of the display and visibility options' behavior. */ /* Note: We strictly check for undefined instead of falsiness because display accepts an empty string value. */if(opts.display !== undefined && opts.display !== null){opts.display = opts.display.toString().toLowerCase(); /* Users can pass in a special "auto" value to instruct Velocity to set the element to its default display value. */if(opts.display === "auto"){opts.display = Velocity.CSS.Values.getDisplayType(element);}}if(opts.visibility !== undefined && opts.visibility !== null){opts.visibility = opts.visibility.toString().toLowerCase();} /**********************
				 Option: mobileHA
				 **********************/ /* When set to true, and if this is a mobile device, mobileHA automatically enables hardware acceleration (via a null transform hack)
				 on animating elements. HA is removed from the element at the completion of its animation. */ /* Note: Android Gingerbread doesn't support HA. If a null transform hack (mobileHA) is in fact set, it will prevent other tranform subproperties from taking effect. */ /* Note: You can read more about the use of mobileHA in Velocity's documentation: VelocityJS.org/#mobileHA. */opts.mobileHA = opts.mobileHA && Velocity.State.isMobile && !Velocity.State.isGingerbread; /***********************
				 Part II: Queueing
				 ***********************/ /* When a set of elements is targeted by a Velocity call, the set is broken up and each element has the current Velocity call individually queued onto it.
				 In this way, each element's existing queue is respected; some elements may already be animating and accordingly should not have this current Velocity call triggered immediately. */ /* In each queue, tween data is processed for each animating property then pushed onto the call-wide calls array. When the last element in the set has had its tweens processed,
				 the call array is pushed to Velocity.State.calls for live processing by the requestAnimationFrame tick. */function buildQueue(next){var data,lastTweensContainer; /*******************
					 Option: Begin
					 *******************/ /* The begin callback is fired once per call -- not once per elemenet -- and is passed the full raw DOM element set as both its context and its first argument. */if(opts.begin && elementsIndex === 0){ /* We throw callbacks in a setTimeout so that thrown errors don't halt the execution of Velocity itself. */try{opts.begin.call(elements,elements);}catch(error) {setTimeout(function(){throw error;},1);}} /*****************************************
					 Tween Data Construction (for Scroll)
					 *****************************************/ /* Note: In order to be subjected to chaining and animation options, scroll's tweening is routed through Velocity as if it were a standard CSS property animation. */if(action === "scroll"){ /* The scroll action uniquely takes an optional "offset" option -- specified in pixels -- that offsets the targeted scroll position. */var scrollDirection=/^x$/i.test(opts.axis)?"Left":"Top",scrollOffset=parseFloat(opts.offset) || 0,scrollPositionCurrent,scrollPositionCurrentAlternate,scrollPositionEnd; /* Scroll also uniquely takes an optional "container" option, which indicates the parent element that should be scrolled --
						 as opposed to the browser window itself. This is useful for scrolling toward an element that's inside an overflowing parent element. */if(opts.container){ /* Ensure that either a jQuery object or a raw DOM element was passed in. */if(Type.isWrapped(opts.container) || Type.isNode(opts.container)){ /* Extract the raw DOM element from the jQuery wrapper. */opts.container = opts.container[0] || opts.container; /* Note: Unlike other properties in Velocity, the browser's scroll position is never cached since it so frequently changes
								 (due to the user's natural interaction with the page). */scrollPositionCurrent = opts.container["scroll" + scrollDirection]; /* GET */ /* $.position() values are relative to the container's currently viewable area (without taking into account the container's true dimensions
								 -- say, for example, if the container was not overflowing). Thus, the scroll end value is the sum of the child element's position *and*
								 the scroll container's current scroll position. */scrollPositionEnd = scrollPositionCurrent + $(element).position()[scrollDirection.toLowerCase()] + scrollOffset; /* GET */ /* If a value other than a jQuery object or a raw DOM element was passed in, default to null so that this option is ignored. */}else {opts.container = null;}}else { /* If the window itself is being scrolled -- not a containing element -- perform a live scroll position lookup using
							 the appropriate cached property names (which differ based on browser type). */scrollPositionCurrent = Velocity.State.scrollAnchor[Velocity.State["scrollProperty" + scrollDirection]]; /* GET */ /* When scrolling the browser window, cache the alternate axis's current value since window.scrollTo() doesn't let us change only one value at a time. */scrollPositionCurrentAlternate = Velocity.State.scrollAnchor[Velocity.State["scrollProperty" + (scrollDirection === "Left"?"Top":"Left")]]; /* GET */ /* Unlike $.position(), $.offset() values are relative to the browser window's true dimensions -- not merely its currently viewable area --
							 and therefore end values do not need to be compounded onto current values. */scrollPositionEnd = $(element).offset()[scrollDirection.toLowerCase()] + scrollOffset; /* GET */} /* Since there's only one format that scroll's associated tweensContainer can take, we create it manually. */tweensContainer = {scroll:{rootPropertyValue:false,startValue:scrollPositionCurrent,currentValue:scrollPositionCurrent,endValue:scrollPositionEnd,unitType:"",easing:opts.easing,scrollData:{container:opts.container,direction:scrollDirection,alternateValue:scrollPositionCurrentAlternate}},element:element};if(Velocity.debug){console.log("tweensContainer (scroll): ",tweensContainer.scroll,element);} /******************************************
						 Tween Data Construction (for Reverse)
						 ******************************************/ /* Reverse acts like a "start" action in that a property map is animated toward. The only difference is
						 that the property map used for reverse is the inverse of the map used in the previous call. Thus, we manipulate
						 the previous call to construct our new map: use the previous map's end values as our new map's start values. Copy over all other data. */ /* Note: Reverse can be directly called via the "reverse" parameter, or it can be indirectly triggered via the loop option. (Loops are composed of multiple reverses.) */ /* Note: Reverse calls do not need to be consecutively chained onto a currently-animating element in order to operate on cached values;
						 there is no harm to reverse being called on a potentially stale data cache since reverse's behavior is simply defined
						 as reverting to the element's values as they were prior to the previous *Velocity* call. */}else if(action === "reverse"){data = Data(element); /* Abort if there is no prior animation data to reverse to. */if(!data){return;}if(!data.tweensContainer){ /* Dequeue the element so that this queue entry releases itself immediately, allowing subsequent queue entries to run. */$.dequeue(element,opts.queue);return;}else { /*********************
							 Options Parsing
							 *********************/ /* If the element was hidden via the display option in the previous call,
							 revert display to "auto" prior to reversal so that the element is visible again. */if(data.opts.display === "none"){data.opts.display = "auto";}if(data.opts.visibility === "hidden"){data.opts.visibility = "visible";} /* If the loop option was set in the previous call, disable it so that "reverse" calls aren't recursively generated.
							 Further, remove the previous call's callback options; typically, users do not want these to be refired. */data.opts.loop = false;data.opts.begin = null;data.opts.complete = null; /* Since we're extending an opts object that has already been extended with the defaults options object,
							 we remove non-explicitly-defined properties that are auto-assigned values. */if(!options.easing){delete opts.easing;}if(!options.duration){delete opts.duration;} /* The opts object used for reversal is an extension of the options object optionally passed into this
							 reverse call plus the options used in the previous Velocity call. */opts = $.extend({},data.opts,opts); /*************************************
							 Tweens Container Reconstruction
							 *************************************/ /* Create a deepy copy (indicated via the true flag) of the previous call's tweensContainer. */lastTweensContainer = $.extend(true,{},data?data.tweensContainer:null); /* Manipulate the previous tweensContainer by replacing its end values and currentValues with its start values. */for(var lastTween in lastTweensContainer) { /* In addition to tween data, tweensContainers contain an element property that we ignore here. */if(lastTweensContainer.hasOwnProperty(lastTween) && lastTween !== "element"){var lastStartValue=lastTweensContainer[lastTween].startValue;lastTweensContainer[lastTween].startValue = lastTweensContainer[lastTween].currentValue = lastTweensContainer[lastTween].endValue;lastTweensContainer[lastTween].endValue = lastStartValue; /* Easing is the only option that embeds into the individual tween data (since it can be defined on a per-property basis).
									 Accordingly, every property's easing value must be updated when an options object is passed in with a reverse call.
									 The side effect of this extensibility is that all per-property easing values are forcefully reset to the new value. */if(!Type.isEmptyObject(options)){lastTweensContainer[lastTween].easing = opts.easing;}if(Velocity.debug){console.log("reverse tweensContainer (" + lastTween + "): " + JSON.stringify(lastTweensContainer[lastTween]),element);}}}tweensContainer = lastTweensContainer;} /*****************************************
						 Tween Data Construction (for Start)
						 *****************************************/}else if(action === "start"){ /*************************
						 Value Transferring
						 *************************/ /* If this queue entry follows a previous Velocity-initiated queue entry *and* if this entry was created
						 while the element was in the process of being animated by Velocity, then this current call is safe to use
						 the end values from the prior call as its start values. Velocity attempts to perform this value transfer
						 process whenever possible in order to avoid requerying the DOM. */ /* If values aren't transferred from a prior call and start values were not forcefed by the user (more on this below),
						 then the DOM is queried for the element's current values as a last resort. */ /* Note: Conversely, animation reversal (and looping) *always* perform inter-call value transfers; they never requery the DOM. */data = Data(element); /* The per-element isAnimating flag is used to indicate whether it's safe (i.e. the data isn't stale)
						 to transfer over end values to use as start values. If it's set to true and there is a previous
						 Velocity call to pull values from, do so. */if(data && data.tweensContainer && data.isAnimating === true){lastTweensContainer = data.tweensContainer;} /***************************
						 Tween Data Calculation
						 ***************************/ /* This function parses property data and defaults endValue, easing, and startValue as appropriate. */ /* Property map values can either take the form of 1) a single value representing the end value,
						 or 2) an array in the form of [ endValue, [, easing] [, startValue] ].
						 The optional third parameter is a forcefed startValue to be used instead of querying the DOM for
						 the element's current value. Read Velocity's docmentation to learn more about forcefeeding: VelocityJS.org/#forcefeeding */var parsePropertyValue=function parsePropertyValue(valueData,skipResolvingEasing){var endValue,easing,startValue; /* If we have a function as the main argument then resolve it first, in case it returns an array that needs to be split */if(Type.isFunction(valueData)){valueData = valueData.call(element,elementArrayIndex,elementsLength);} /* Handle the array format, which can be structured as one of three potential overloads:
							 A) [ endValue, easing, startValue ], B) [ endValue, easing ], or C) [ endValue, startValue ] */if(Type.isArray(valueData)){ /* endValue is always the first item in the array. Don't bother validating endValue's value now
								 since the ensuing property cycling logic does that. */endValue = valueData[0]; /* Two-item array format: If the second item is a number, function, or hex string, treat it as a
								 start value since easings can only be non-hex strings or arrays. */if(!Type.isArray(valueData[1]) && /^[\d-]/.test(valueData[1]) || Type.isFunction(valueData[1]) || CSS.RegEx.isHex.test(valueData[1])){startValue = valueData[1]; /* Two or three-item array: If the second item is a non-hex string easing name or an array, treat it as an easing. */}else if(Type.isString(valueData[1]) && !CSS.RegEx.isHex.test(valueData[1]) && Velocity.Easings[valueData[1]] || Type.isArray(valueData[1])){easing = skipResolvingEasing?valueData[1]:getEasing(valueData[1],opts.duration); /* Don't bother validating startValue's value now since the ensuing property cycling logic inherently does that. */startValue = valueData[2];}else {startValue = valueData[1] || valueData[2];} /* Handle the single-value format. */}else {endValue = valueData;} /* Default to the call's easing if a per-property easing type was not defined. */if(!skipResolvingEasing){easing = easing || opts.easing;} /* If functions were passed in as values, pass the function the current element as its context,
							 plus the element's index and the element set's size as arguments. Then, assign the returned value. */if(Type.isFunction(endValue)){endValue = endValue.call(element,elementArrayIndex,elementsLength);}if(Type.isFunction(startValue)){startValue = startValue.call(element,elementArrayIndex,elementsLength);} /* Allow startValue to be left as undefined to indicate to the ensuing code that its value was not forcefed. */return [endValue || 0,easing,startValue];};var fixPropertyValue=function fixPropertyValue(property,valueData){ /* In case this property is a hook, there are circumstances where we will intend to work on the hook's root property and not the hooked subproperty. */var rootProperty=CSS.Hooks.getRoot(property),rootPropertyValue=false, /* Parse out endValue, easing, and startValue from the property's data. */endValue=valueData[0],easing=valueData[1],startValue=valueData[2],pattern; /**************************
							 Start Value Sourcing
							 **************************/ /* Other than for the dummy tween property, properties that are not supported by the browser (and do not have an associated normalization) will
							 inherently produce no style changes when set, so they are skipped in order to decrease animation tick overhead.
							 Property support is determined via prefixCheck(), which returns a false flag when no supported is detected. */ /* Note: Since SVG elements have some of their properties directly applied as HTML attributes,
							 there is no way to check for their explicit browser support, and so we skip skip this check for them. */if((!data || !data.isSVG) && rootProperty !== "tween" && CSS.Names.prefixCheck(rootProperty)[1] === false && CSS.Normalizations.registered[rootProperty] === undefined){if(Velocity.debug){console.log("Skipping [" + rootProperty + "] due to a lack of browser support.");}return;} /* If the display option is being set to a non-"none" (e.g. "block") and opacity (filter on IE<=8) is being
							 animated to an endValue of non-zero, the user's intention is to fade in from invisible, thus we forcefeed opacity
							 a startValue of 0 if its startValue hasn't already been sourced by value transferring or prior forcefeeding. */if((opts.display !== undefined && opts.display !== null && opts.display !== "none" || opts.visibility !== undefined && opts.visibility !== "hidden") && /opacity|filter/.test(property) && !startValue && endValue !== 0){startValue = 0;} /* If values have been transferred from the previous Velocity call, extract the endValue and rootPropertyValue
							 for all of the current call's properties that were *also* animated in the previous call. */ /* Note: Value transferring can optionally be disabled by the user via the _cacheValues option. */if(opts._cacheValues && lastTweensContainer && lastTweensContainer[property]){if(startValue === undefined){startValue = lastTweensContainer[property].endValue + lastTweensContainer[property].unitType;} /* The previous call's rootPropertyValue is extracted from the element's data cache since that's the
								 instance of rootPropertyValue that gets freshly updated by the tweening process, whereas the rootPropertyValue
								 attached to the incoming lastTweensContainer is equal to the root property's value prior to any tweening. */rootPropertyValue = data.rootPropertyValueCache[rootProperty]; /* If values were not transferred from a previous Velocity call, query the DOM as needed. */}else { /* Handle hooked properties. */if(CSS.Hooks.registered[property]){if(startValue === undefined){rootPropertyValue = CSS.getPropertyValue(element,rootProperty); /* GET */ /* Note: The following getPropertyValue() call does not actually trigger a DOM query;
										 getPropertyValue() will extract the hook from rootPropertyValue. */startValue = CSS.getPropertyValue(element,property,rootPropertyValue); /* If startValue is already defined via forcefeeding, do not query the DOM for the root property's value;
										 just grab rootProperty's zero-value template from CSS.Hooks. This overwrites the element's actual
										 root property value (if one is set), but this is acceptable since the primary reason users forcefeed is
										 to avoid DOM queries, and thus we likewise avoid querying the DOM for the root property's value. */}else { /* Grab this hook's zero-value template, e.g. "0px 0px 0px black". */rootPropertyValue = CSS.Hooks.templates[rootProperty][1];} /* Handle non-hooked properties that haven't already been defined via forcefeeding. */}else if(startValue === undefined){startValue = CSS.getPropertyValue(element,property); /* GET */}} /**************************
							 Value Data Extraction
							 **************************/var separatedValue,endValueUnitType,startValueUnitType,operator=false; /* Separates a property value into its numeric value and its unit type. */var separateValue=function separateValue(property,value){var unitType,numericValue;numericValue = (value || "0").toString().toLowerCase() /* Match the unit type at the end of the value. */.replace(/[%A-z]+$/,function(match){ /* Grab the unit type. */unitType = match; /* Strip the unit type off of value. */return "";}); /* If no unit type was supplied, assign one that is appropriate for this property (e.g. "deg" for rotateZ or "px" for width). */if(!unitType){unitType = CSS.Values.getUnitType(property);}return [numericValue,unitType];};if(startValue !== endValue && Type.isString(startValue) && Type.isString(endValue)){pattern = "";var iStart=0, // index in startValue
iEnd=0, // index in endValue
aStart=[], // array of startValue numbers
aEnd=[], // array of endValue numbers
inCalc=0, // Keep track of being inside a "calc()" so we don't duplicate it
inRGB=0, // Keep track of being inside an RGB as we can't use fractional values
inRGBA=0; // Keep track of being inside an RGBA as we must pass fractional for the alpha channel
startValue = CSS.Hooks.fixColors(startValue);endValue = CSS.Hooks.fixColors(endValue);while(iStart < startValue.length && iEnd < endValue.length) {var cStart=startValue[iStart],cEnd=endValue[iEnd];if(/[\d\.-]/.test(cStart) && /[\d\.-]/.test(cEnd)){var tStart=cStart, // temporary character buffer
tEnd=cEnd, // temporary character buffer
dotStart=".", // Make sure we can only ever match a single dot in a decimal
dotEnd="."; // Make sure we can only ever match a single dot in a decimal
while(++iStart < startValue.length) {cStart = startValue[iStart];if(cStart === dotStart){dotStart = ".."; // Can never match two characters
}else if(!/\d/.test(cStart)){break;}tStart += cStart;}while(++iEnd < endValue.length) {cEnd = endValue[iEnd];if(cEnd === dotEnd){dotEnd = ".."; // Can never match two characters
}else if(!/\d/.test(cEnd)){break;}tEnd += cEnd;}var uStart=CSS.Hooks.getUnit(startValue,iStart), // temporary unit type
uEnd=CSS.Hooks.getUnit(endValue,iEnd); // temporary unit type
iStart += uStart.length;iEnd += uEnd.length;if(uStart === uEnd){ // Same units
if(tStart === tEnd){ // Same numbers, so just copy over
pattern += tStart + uStart;}else { // Different numbers, so store them
pattern += "{" + aStart.length + (inRGB?"!":"") + "}" + uStart;aStart.push(parseFloat(tStart));aEnd.push(parseFloat(tEnd));}}else { // Different units, so put into a "calc(from + to)" and animate each side to/from zero
var nStart=parseFloat(tStart),nEnd=parseFloat(tEnd);pattern += (inCalc < 5?"calc":"") + "(" + (nStart?"{" + aStart.length + (inRGB?"!":"") + "}":"0") + uStart + " + " + (nEnd?"{" + (aStart.length + (nStart?1:0)) + (inRGB?"!":"") + "}":"0") + uEnd + ")";if(nStart){aStart.push(nStart);aEnd.push(0);}if(nEnd){aStart.push(0);aEnd.push(nEnd);}}}else if(cStart === cEnd){pattern += cStart;iStart++;iEnd++; // Keep track of being inside a calc()
if(inCalc === 0 && cStart === "c" || inCalc === 1 && cStart === "a" || inCalc === 2 && cStart === "l" || inCalc === 3 && cStart === "c" || inCalc >= 4 && cStart === "("){inCalc++;}else if(inCalc && inCalc < 5 || inCalc >= 4 && cStart === ")" && --inCalc < 5){inCalc = 0;} // Keep track of being inside an rgb() / rgba()
if(inRGB === 0 && cStart === "r" || inRGB === 1 && cStart === "g" || inRGB === 2 && cStart === "b" || inRGB === 3 && cStart === "a" || inRGB >= 3 && cStart === "("){if(inRGB === 3 && cStart === "a"){inRGBA = 1;}inRGB++;}else if(inRGBA && cStart === ","){if(++inRGBA > 3){inRGB = inRGBA = 0;}}else if(inRGBA && inRGB < (inRGBA?5:4) || inRGB >= (inRGBA?4:3) && cStart === ")" && --inRGB < (inRGBA?5:4)){inRGB = inRGBA = 0;}}else {inCalc = 0; // TODO: changing units, fixing colours
break;}}if(iStart !== startValue.length || iEnd !== endValue.length){if(Velocity.debug){console.error("Trying to pattern match mis-matched strings [\"" + endValue + "\", \"" + startValue + "\"]");}pattern = undefined;}if(pattern){if(aStart.length){if(Velocity.debug){console.log("Pattern found \"" + pattern + "\" -> ",aStart,aEnd,"[" + startValue + "," + endValue + "]");}startValue = aStart;endValue = aEnd;endValueUnitType = startValueUnitType = "";}else {pattern = undefined;}}}if(!pattern){ /* Separate startValue. */separatedValue = separateValue(property,startValue);startValue = separatedValue[0];startValueUnitType = separatedValue[1]; /* Separate endValue, and extract a value operator (e.g. "+=", "-=") if one exists. */separatedValue = separateValue(property,endValue);endValue = separatedValue[0].replace(/^([+-\/*])=/,function(match,subMatch){operator = subMatch; /* Strip the operator off of the value. */return "";});endValueUnitType = separatedValue[1]; /* Parse float values from endValue and startValue. Default to 0 if NaN is returned. */startValue = parseFloat(startValue) || 0;endValue = parseFloat(endValue) || 0; /***************************************
								 Property-Specific Value Conversion
								 ***************************************/ /* Custom support for properties that don't actually accept the % unit type, but where pollyfilling is trivial and relatively foolproof. */if(endValueUnitType === "%"){ /* A %-value fontSize/lineHeight is relative to the parent's fontSize (as opposed to the parent's dimensions),
									 which is identical to the em unit's behavior, so we piggyback off of that. */if(/^(fontSize|lineHeight)$/.test(property)){ /* Convert % into an em decimal value. */endValue = endValue / 100;endValueUnitType = "em"; /* For scaleX and scaleY, convert the value into its decimal format and strip off the unit type. */}else if(/^scale/.test(property)){endValue = endValue / 100;endValueUnitType = ""; /* For RGB components, take the defined percentage of 255 and strip off the unit type. */}else if(/(Red|Green|Blue)$/i.test(property)){endValue = endValue / 100 * 255;endValueUnitType = "";}}} /***************************
							 Unit Ratio Calculation
							 ***************************/ /* When queried, the browser returns (most) CSS property values in pixels. Therefore, if an endValue with a unit type of
							 %, em, or rem is animated toward, startValue must be converted from pixels into the same unit type as endValue in order
							 for value manipulation logic (increment/decrement) to proceed. Further, if the startValue was forcefed or transferred
							 from a previous call, startValue may also not be in pixels. Unit conversion logic therefore consists of two steps:
							 1) Calculating the ratio of %/em/rem/vh/vw relative to pixels
							 2) Converting startValue into the same unit of measurement as endValue based on these ratios. */ /* Unit conversion ratios are calculated by inserting a sibling node next to the target node, copying over its position property,
							 setting values with the target unit type then comparing the returned pixel value. */ /* Note: Even if only one of these unit types is being animated, all unit ratios are calculated at once since the overhead
							 of batching the SETs and GETs together upfront outweights the potential overhead
							 of layout thrashing caused by re-querying for uncalculated ratios for subsequently-processed properties. */ /* Todo: Shift this logic into the calls' first tick instance so that it's synced with RAF. */var calculateUnitRatios=function calculateUnitRatios(){ /************************
								 Same Ratio Checks
								 ************************/ /* The properties below are used to determine whether the element differs sufficiently from this call's
								 previously iterated element to also differ in its unit conversion ratios. If the properties match up with those
								 of the prior element, the prior element's conversion ratios are used. Like most optimizations in Velocity,
								 this is done to minimize DOM querying. */var sameRatioIndicators={myParent:element.parentNode || document.body, /* GET */position:CSS.getPropertyValue(element,"position"), /* GET */fontSize:CSS.getPropertyValue(element,"fontSize") /* GET */}, /* Determine if the same % ratio can be used. % is based on the element's position value and its parent's width and height dimensions. */samePercentRatio=sameRatioIndicators.position === callUnitConversionData.lastPosition && sameRatioIndicators.myParent === callUnitConversionData.lastParent, /* Determine if the same em ratio can be used. em is relative to the element's fontSize. */sameEmRatio=sameRatioIndicators.fontSize === callUnitConversionData.lastFontSize; /* Store these ratio indicators call-wide for the next element to compare against. */callUnitConversionData.lastParent = sameRatioIndicators.myParent;callUnitConversionData.lastPosition = sameRatioIndicators.position;callUnitConversionData.lastFontSize = sameRatioIndicators.fontSize; /***************************
								 Element-Specific Units
								 ***************************/ /* Note: IE8 rounds to the nearest pixel when returning CSS values, thus we perform conversions using a measurement
								 of 100 (instead of 1) to give our ratios a precision of at least 2 decimal values. */var measurement=100,unitRatios={};if(!sameEmRatio || !samePercentRatio){var dummy=data && data.isSVG?document.createElementNS("http://www.w3.org/2000/svg","rect"):document.createElement("div");Velocity.init(dummy);sameRatioIndicators.myParent.appendChild(dummy); /* To accurately and consistently calculate conversion ratios, the element's cascaded overflow and box-sizing are stripped.
									 Similarly, since width/height can be artificially constrained by their min-/max- equivalents, these are controlled for as well. */ /* Note: Overflow must be also be controlled for per-axis since the overflow property overwrites its per-axis values. */$.each(["overflow","overflowX","overflowY"],function(i,property){Velocity.CSS.setPropertyValue(dummy,property,"hidden");});Velocity.CSS.setPropertyValue(dummy,"position",sameRatioIndicators.position);Velocity.CSS.setPropertyValue(dummy,"fontSize",sameRatioIndicators.fontSize);Velocity.CSS.setPropertyValue(dummy,"boxSizing","content-box"); /* width and height act as our proxy properties for measuring the horizontal and vertical % ratios. */$.each(["minWidth","maxWidth","width","minHeight","maxHeight","height"],function(i,property){Velocity.CSS.setPropertyValue(dummy,property,measurement + "%");}); /* paddingLeft arbitrarily acts as our proxy property for the em ratio. */Velocity.CSS.setPropertyValue(dummy,"paddingLeft",measurement + "em"); /* Divide the returned value by the measurement to get the ratio between 1% and 1px. Default to 1 since working with 0 can produce Infinite. */unitRatios.percentToPxWidth = callUnitConversionData.lastPercentToPxWidth = (parseFloat(CSS.getPropertyValue(dummy,"width",null,true)) || 1) / measurement; /* GET */unitRatios.percentToPxHeight = callUnitConversionData.lastPercentToPxHeight = (parseFloat(CSS.getPropertyValue(dummy,"height",null,true)) || 1) / measurement; /* GET */unitRatios.emToPx = callUnitConversionData.lastEmToPx = (parseFloat(CSS.getPropertyValue(dummy,"paddingLeft")) || 1) / measurement; /* GET */sameRatioIndicators.myParent.removeChild(dummy);}else {unitRatios.emToPx = callUnitConversionData.lastEmToPx;unitRatios.percentToPxWidth = callUnitConversionData.lastPercentToPxWidth;unitRatios.percentToPxHeight = callUnitConversionData.lastPercentToPxHeight;} /***************************
								 Element-Agnostic Units
								 ***************************/ /* Whereas % and em ratios are determined on a per-element basis, the rem unit only needs to be checked
								 once per call since it's exclusively dependant upon document.body's fontSize. If this is the first time
								 that calculateUnitRatios() is being run during this call, remToPx will still be set to its default value of null,
								 so we calculate it now. */if(callUnitConversionData.remToPx === null){ /* Default to browsers' default fontSize of 16px in the case of 0. */callUnitConversionData.remToPx = parseFloat(CSS.getPropertyValue(document.body,"fontSize")) || 16; /* GET */} /* Similarly, viewport units are %-relative to the window's inner dimensions. */if(callUnitConversionData.vwToPx === null){callUnitConversionData.vwToPx = parseFloat(window.innerWidth) / 100; /* GET */callUnitConversionData.vhToPx = parseFloat(window.innerHeight) / 100; /* GET */}unitRatios.remToPx = callUnitConversionData.remToPx;unitRatios.vwToPx = callUnitConversionData.vwToPx;unitRatios.vhToPx = callUnitConversionData.vhToPx;if(Velocity.debug >= 1){console.log("Unit ratios: " + JSON.stringify(unitRatios),element);}return unitRatios;}; /********************
							 Unit Conversion
							 ********************/ /* The * and / operators, which are not passed in with an associated unit, inherently use startValue's unit. Skip value and unit conversion. */if(/[\/*]/.test(operator)){endValueUnitType = startValueUnitType; /* If startValue and endValue differ in unit type, convert startValue into the same unit type as endValue so that if endValueUnitType
								 is a relative unit (%, em, rem), the values set during tweening will continue to be accurately relative even if the metrics they depend
								 on are dynamically changing during the course of the animation. Conversely, if we always normalized into px and used px for setting values, the px ratio
								 would become stale if the original unit being animated toward was relative and the underlying metrics change during the animation. */ /* Since 0 is 0 in any unit type, no conversion is necessary when startValue is 0 -- we just start at 0 with endValueUnitType. */}else if(startValueUnitType !== endValueUnitType && startValue !== 0){ /* Unit conversion is also skipped when endValue is 0, but *startValueUnitType* must be used for tween values to remain accurate. */ /* Note: Skipping unit conversion here means that if endValueUnitType was originally a relative unit, the animation won't relatively
								 match the underlying metrics if they change, but this is acceptable since we're animating toward invisibility instead of toward visibility,
								 which remains past the point of the animation's completion. */if(endValue === 0){endValueUnitType = startValueUnitType;}else { /* By this point, we cannot avoid unit conversion (it's undesirable since it causes layout thrashing).
									 If we haven't already, we trigger calculateUnitRatios(), which runs once per element per call. */elementUnitConversionData = elementUnitConversionData || calculateUnitRatios(); /* The following RegEx matches CSS properties that have their % values measured relative to the x-axis. */ /* Note: W3C spec mandates that all of margin and padding's properties (even top and bottom) are %-relative to the *width* of the parent element. */var axis=/margin|padding|left|right|width|text|word|letter/i.test(property) || /X$/.test(property) || property === "x"?"x":"y"; /* In order to avoid generating n^2 bespoke conversion functions, unit conversion is a two-step process:
									 1) Convert startValue into pixels. 2) Convert this new pixel value into endValue's unit type. */switch(startValueUnitType){case "%": /* Note: translateX and translateY are the only properties that are %-relative to an element's own dimensions -- not its parent's dimensions.
											 Velocity does not include a special conversion process to account for this behavior. Therefore, animating translateX/Y from a % value
											 to a non-% value will produce an incorrect start value. Fortunately, this sort of cross-unit conversion is rarely done by users in practice. */startValue *= axis === "x"?elementUnitConversionData.percentToPxWidth:elementUnitConversionData.percentToPxHeight;break;case "px": /* px acts as our midpoint in the unit conversion process; do nothing. */break;default:startValue *= elementUnitConversionData[startValueUnitType + "ToPx"];} /* Invert the px ratios to convert into to the target unit. */switch(endValueUnitType){case "%":startValue *= 1 / (axis === "x"?elementUnitConversionData.percentToPxWidth:elementUnitConversionData.percentToPxHeight);break;case "px": /* startValue is already in px, do nothing; we're done. */break;default:startValue *= 1 / elementUnitConversionData[endValueUnitType + "ToPx"];}}} /*********************
							 Relative Values
							 *********************/ /* Operator logic must be performed last since it requires unit-normalized start and end values. */ /* Note: Relative *percent values* do not behave how most people think; while one would expect "+=50%"
							 to increase the property 1.5x its current value, it in fact increases the percent units in absolute terms:
							 50 points is added on top of the current % value. */switch(operator){case "+":endValue = startValue + endValue;break;case "-":endValue = startValue - endValue;break;case "*":endValue = startValue * endValue;break;case "/":endValue = startValue / endValue;break;} /**************************
							 tweensContainer Push
							 **************************/ /* Construct the per-property tween object, and push it to the element's tweensContainer. */tweensContainer[property] = {rootPropertyValue:rootPropertyValue,startValue:startValue,currentValue:startValue,endValue:endValue,unitType:endValueUnitType,easing:easing};if(pattern){tweensContainer[property].pattern = pattern;}if(Velocity.debug){console.log("tweensContainer (" + property + "): " + JSON.stringify(tweensContainer[property]),element);}}; /* Create a tween out of each property, and append its associated data to tweensContainer. */for(var property in propertiesMap) {if(!propertiesMap.hasOwnProperty(property)){continue;} /* The original property name's format must be used for the parsePropertyValue() lookup,
							 but we then use its camelCase styling to normalize it for manipulation. */var propertyName=CSS.Names.camelCase(property),valueData=parsePropertyValue(propertiesMap[property]); /* Find shorthand color properties that have been passed a hex string. */ /* Would be quicker to use CSS.Lists.colors.includes() if possible */if(_inArray(CSS.Lists.colors,propertyName)){ /* Parse the value data for each shorthand. */var endValue=valueData[0],easing=valueData[1],startValue=valueData[2];if(CSS.RegEx.isHex.test(endValue)){ /* Convert the hex strings into their RGB component arrays. */var colorComponents=["Red","Green","Blue"],endValueRGB=CSS.Values.hexToRgb(endValue),startValueRGB=startValue?CSS.Values.hexToRgb(startValue):undefined; /* Inject the RGB component tweens into propertiesMap. */for(var i=0;i < colorComponents.length;i++) {var dataArray=[endValueRGB[i]];if(easing){dataArray.push(easing);}if(startValueRGB !== undefined){dataArray.push(startValueRGB[i]);}fixPropertyValue(propertyName + colorComponents[i],dataArray);} /* If we have replaced a shortcut color value then don't update the standard property name */continue;}}fixPropertyValue(propertyName,valueData);} /* Along with its property data, store a reference to the element itself onto tweensContainer. */tweensContainer.element = element;} /*****************
					 Call Push
					 *****************/ /* Note: tweensContainer can be empty if all of the properties in this call's property map were skipped due to not
					 being supported by the browser. The element property is used for checking that the tweensContainer has been appended to. */if(tweensContainer.element){ /* Apply the "velocity-animating" indicator class. */CSS.Values.addClass(element,"velocity-animating"); /* The call array houses the tweensContainers for each element being animated in the current call. */call.push(tweensContainer);data = Data(element);if(data){ /* Store the tweensContainer and options if we're working on the default effects queue, so that they can be used by the reverse command. */if(opts.queue === ""){data.tweensContainer = tweensContainer;data.opts = opts;} /* Switch on the element's animating flag. */data.isAnimating = true;} /* Once the final element in this call's element set has been processed, push the call array onto
						 Velocity.State.calls for the animation tick to immediately begin processing. */if(elementsIndex === elementsLength - 1){ /* Add the current call plus its associated metadata (the element set and the call's options) onto the global call container.
							 Anything on this call container is subjected to tick() processing. */Velocity.State.calls.push([call,elements,opts,null,promiseData.resolver,null,0]); /* If the animation tick isn't running, start it. (Velocity shuts it off when there are no active calls to process.) */if(Velocity.State.isTicking === false){Velocity.State.isTicking = true; /* Start the tick loop. */tick();}}else {elementsIndex++;}}} /* When the queue option is set to false, the call skips the element's queue and fires immediately. */if(opts.queue === false){ /* Since this buildQueue call doesn't respect the element's existing queue (which is where a delay option would have been appended),
					 we manually inject the delay property here with an explicit setTimeout. */if(opts.delay){ /* Temporarily store delayed elements to facilitate access for global pause/resume */var callIndex=Velocity.State.delayedElements.count++;Velocity.State.delayedElements[callIndex] = element;var delayComplete=(function(index){return function(){ /* Clear the temporary element */Velocity.State.delayedElements[index] = false; /* Finally, issue the call */buildQueue();};})(callIndex);Data(element).delayBegin = new Date().getTime();Data(element).delay = parseFloat(opts.delay);Data(element).delayTimer = {setTimeout:setTimeout(buildQueue,parseFloat(opts.delay)),next:delayComplete};}else {buildQueue();} /* Otherwise, the call undergoes element queueing as normal. */ /* Note: To interoperate with jQuery, Velocity uses jQuery's own $.queue() stack for queuing logic. */}else {$.queue(element,opts.queue,function(next,clearQueue){ /* If the clearQueue flag was passed in by the stop command, resolve this call's promise. (Promises can only be resolved once,
						 so it's fine if this is repeatedly triggered for each element in the associated call.) */if(clearQueue === true){if(promiseData.promise){promiseData.resolver(elements);} /* Do not continue with animation queueing. */return true;} /* This flag indicates to the upcoming completeCall() function that this queue entry was initiated by Velocity.
						 See completeCall() for further details. */Velocity.velocityQueueEntryFlag = true;buildQueue(next);});} /*********************
				 Auto-Dequeuing
				 *********************/ /* As per jQuery's $.queue() behavior, to fire the first non-custom-queue entry on an element, the element
				 must be dequeued if its queue stack consists *solely* of the current call. (This can be determined by checking
				 for the "inprogress" item that jQuery prepends to active queue stack arrays.) Regardless, whenever the element's
				 queue is further appended with additional items -- including $.delay()'s or even $.animate() calls, the queue's
				 first entry is automatically fired. This behavior contrasts that of custom queues, which never auto-fire. */ /* Note: When an element set is being subjected to a non-parallel Velocity call, the animation will not begin until
				 each one of the elements in the set has reached the end of its individually pre-existing queue chain. */ /* Note: Unfortunately, most people don't fully grasp jQuery's powerful, yet quirky, $.queue() function.
				 Lean more here: http://stackoverflow.com/questions/1058158/can-somebody-explain-jquery-queue-to-me */if((opts.queue === "" || opts.queue === "fx") && $.queue(element)[0] !== "inprogress"){$.dequeue(element);}} /**************************
			 Element Set Iteration
			 **************************/ /* If the "nodeType" property exists on the elements variable, we're animating a single element.
			 Place it in an array so that $.each() can iterate over it. */$.each(elements,function(i,element){ /* Ensure each element in a set has a nodeType (is a real element) to avoid throwing errors. */if(Type.isNode(element)){processElement(element,i);}}); /******************
			 Option: Loop
			 ******************/ /* The loop option accepts an integer indicating how many times the element should loop between the values in the
			 current call's properties map and the element's property values prior to this call. */ /* Note: The loop option's logic is performed here -- after element processing -- because the current call needs
			 to undergo its queue insertion prior to the loop option generating its series of constituent "reverse" calls,
			 which chain after the current call. Two reverse calls (two "alternations") constitute one loop. */opts = $.extend({},Velocity.defaults,options);opts.loop = parseInt(opts.loop,10);var reverseCallsCount=opts.loop * 2 - 1;if(opts.loop){ /* Double the loop count to convert it into its appropriate number of "reverse" calls.
				 Subtract 1 from the resulting value since the current call is included in the total alternation count. */for(var x=0;x < reverseCallsCount;x++) { /* Since the logic for the reverse action occurs inside Queueing and therefore this call's options object
					 isn't parsed until then as well, the current call's delay option must be explicitly passed into the reverse
					 call so that the delay logic that occurs inside *Pre-Queueing* can process it. */var reverseOptions={delay:opts.delay,progress:opts.progress}; /* If a complete callback was passed into this call, transfer it to the loop redirect's final "reverse" call
					 so that it's triggered when the entire redirect is complete (and not when the very first animation is complete). */if(x === reverseCallsCount - 1){reverseOptions.display = opts.display;reverseOptions.visibility = opts.visibility;reverseOptions.complete = opts.complete;}animate(elements,"reverse",reverseOptions);}} /***************
			 Chaining
			 ***************/ /* Return the elements back to the call chain, with wrapped elements taking precedence in case Velocity was called via the $.fn. extension. */return getChain();}; /* Turn Velocity into the animation function, extended with the pre-existing Velocity object. */Velocity = $.extend(animate,Velocity); /* For legacy support, also expose the literal animate method. */Velocity.animate = animate; /**************
		 Timing
		 **************/ /* Ticker function. */var ticker=window.requestAnimationFrame || rAFShim; /* Inactive browser tabs pause rAF, which results in all active animations immediately sprinting to their completion states when the tab refocuses.
		 To get around this, we dynamically switch rAF to setTimeout (which the browser *doesn't* pause) when the tab loses focus. We skip this for mobile
		 devices to avoid wasting battery power on inactive tabs. */ /* Note: Tab focus detection doesn't work on older versions of IE, but that's okay since they don't support rAF to begin with. */if(!Velocity.State.isMobile && document.hidden !== undefined){var updateTicker=function updateTicker(){ /* Reassign the rAF function (which the global tick() function uses) based on the tab's focus state. */if(document.hidden){ticker = function(callback){ /* The tick function needs a truthy first argument in order to pass its internal timestamp check. */return setTimeout(function(){callback(true);},16);}; /* The rAF loop has been paused by the browser, so we manually restart the tick. */tick();}else {ticker = window.requestAnimationFrame || rAFShim;}}; /* Page could be sitting in the background at this time (i.e. opened as new tab) so making sure we use correct ticker from the start */updateTicker(); /* And then run check again every time visibility changes */document.addEventListener("visibilitychange",updateTicker);} /************
		 Tick
		 ************/ /* Note: All calls to Velocity are pushed to the Velocity.State.calls array, which is fully iterated through upon each tick. */function tick(timestamp){ /* An empty timestamp argument indicates that this is the first tick occurence since ticking was turned on.
			 We leverage this metadata to fully ignore the first tick pass since RAF's initial pass is fired whenever
			 the browser's next tick sync time occurs, which results in the first elements subjected to Velocity
			 calls being animated out of sync with any elements animated immediately thereafter. In short, we ignore
			 the first RAF tick pass so that elements being immediately consecutively animated -- instead of simultaneously animated
			 by the same Velocity call -- are properly batched into the same initial RAF tick and consequently remain in sync thereafter. */if(timestamp){ /* We normally use RAF's high resolution timestamp but as it can be significantly offset when the browser is
				 under high stress we give the option for choppiness over allowing the browser to drop huge chunks of frames.
				 We use performance.now() and shim it if it doesn't exist for when the tab is hidden. */var timeCurrent=Velocity.timestamp && timestamp !== true?timestamp:performance.now(); /********************
				 Call Iteration
				 ********************/var callsLength=Velocity.State.calls.length; /* To speed up iterating over this array, it is compacted (falsey items -- calls that have completed -- are removed)
				 when its length has ballooned to a point that can impact tick performance. This only becomes necessary when animation
				 has been continuous with many elements over a long period of time; whenever all active calls are completed, completeCall() clears Velocity.State.calls. */if(callsLength > 10000){Velocity.State.calls = compactSparseArray(Velocity.State.calls);callsLength = Velocity.State.calls.length;} /* Iterate through each active call. */for(var i=0;i < callsLength;i++) { /* When a Velocity call is completed, its Velocity.State.calls entry is set to false. Continue on to the next call. */if(!Velocity.State.calls[i]){continue;} /************************
					 Call-Wide Variables
					 ************************/var callContainer=Velocity.State.calls[i],call=callContainer[0],opts=callContainer[2],timeStart=callContainer[3],firstTick=!timeStart,tweenDummyValue=null,pauseObject=callContainer[5],millisecondsEllapsed=callContainer[6]; /* If timeStart is undefined, then this is the first time that this call has been processed by tick().
					 We assign timeStart now so that its value is as close to the real animation start time as possible.
					 (Conversely, had timeStart been defined when this call was added to Velocity.State.calls, the delay
					 between that time and now would cause the first few frames of the tween to be skipped since
					 percentComplete is calculated relative to timeStart.) */ /* Further, subtract 16ms (the approximate resolution of RAF) from the current time value so that the
					 first tick iteration isn't wasted by animating at 0% tween completion, which would produce the
					 same style value as the element's current value. */if(!timeStart){timeStart = Velocity.State.calls[i][3] = timeCurrent - 16;} /* If a pause object is present, skip processing unless it has been set to resume */if(pauseObject){if(pauseObject.resume === true){ /* Update the time start to accomodate the paused completion amount */timeStart = callContainer[3] = Math.round(timeCurrent - millisecondsEllapsed - 16); /* Remove pause object after processing */callContainer[5] = null;}else {continue;}}millisecondsEllapsed = callContainer[6] = timeCurrent - timeStart; /* The tween's completion percentage is relative to the tween's start time, not the tween's start value
					 (which would result in unpredictable tween durations since JavaScript's timers are not particularly accurate).
					 Accordingly, we ensure that percentComplete does not exceed 1. */var percentComplete=Math.min(millisecondsEllapsed / opts.duration,1); /**********************
					 Element Iteration
					 **********************/ /* For every call, iterate through each of the elements in its set. */for(var j=0,callLength=call.length;j < callLength;j++) {var tweensContainer=call[j],element=tweensContainer.element; /* Check to see if this element has been deleted midway through the animation by checking for the
						 continued existence of its data cache. If it's gone, or the element is currently paused, skip animating this element. */if(!Data(element)){continue;}var transformPropertyExists=false; /**********************************
						 Display & Visibility Toggling
						 **********************************/ /* If the display option is set to non-"none", set it upfront so that the element can become visible before tweening begins.
						 (Otherwise, display's "none" value is set in completeCall() once the animation has completed.) */if(opts.display !== undefined && opts.display !== null && opts.display !== "none"){if(opts.display === "flex"){var flexValues=["-webkit-box","-moz-box","-ms-flexbox","-webkit-flex"];$.each(flexValues,function(i,flexValue){CSS.setPropertyValue(element,"display",flexValue);});}CSS.setPropertyValue(element,"display",opts.display);} /* Same goes with the visibility option, but its "none" equivalent is "hidden". */if(opts.visibility !== undefined && opts.visibility !== "hidden"){CSS.setPropertyValue(element,"visibility",opts.visibility);} /************************
						 Property Iteration
						 ************************/ /* For every element, iterate through each property. */for(var property in tweensContainer) { /* Note: In addition to property tween data, tweensContainer contains a reference to its associated element. */if(tweensContainer.hasOwnProperty(property) && property !== "element"){var tween=tweensContainer[property],currentValue, /* Easing can either be a pre-genereated function or a string that references a pre-registered easing
										 on the Velocity.Easings object. In either case, return the appropriate easing *function*. */easing=Type.isString(tween.easing)?Velocity.Easings[tween.easing]:tween.easing; /******************************
								 Current Value Calculation
								 ******************************/if(Type.isString(tween.pattern)){var patternReplace=percentComplete === 1?function($0,index,round){var result=tween.endValue[index];return round?Math.round(result):result;}:function($0,index,round){var startValue=tween.startValue[index],tweenDelta=tween.endValue[index] - startValue,result=startValue + tweenDelta * easing(percentComplete,opts,tweenDelta);return round?Math.round(result):result;};currentValue = tween.pattern.replace(/{(\d+)(!)?}/g,patternReplace);}else if(percentComplete === 1){ /* If this is the last tick pass (if we've reached 100% completion for this tween),
									 ensure that currentValue is explicitly set to its target endValue so that it's not subjected to any rounding. */currentValue = tween.endValue;}else { /* Otherwise, calculate currentValue based on the current delta from startValue. */var tweenDelta=tween.endValue - tween.startValue;currentValue = tween.startValue + tweenDelta * easing(percentComplete,opts,tweenDelta); /* If no value change is occurring, don't proceed with DOM updating. */}if(!firstTick && currentValue === tween.currentValue){continue;}tween.currentValue = currentValue; /* If we're tweening a fake 'tween' property in order to log transition values, update the one-per-call variable so that
								 it can be passed into the progress callback. */if(property === "tween"){tweenDummyValue = currentValue;}else { /******************
									 Hooks: Part I
									 ******************/var hookRoot; /* For hooked properties, the newly-updated rootPropertyValueCache is cached onto the element so that it can be used
									 for subsequent hooks in this call that are associated with the same root property. If we didn't cache the updated
									 rootPropertyValue, each subsequent update to the root property in this tick pass would reset the previous hook's
									 updates to rootPropertyValue prior to injection. A nice performance byproduct of rootPropertyValue caching is that
									 subsequently chained animations using the same hookRoot but a different hook can use this cached rootPropertyValue. */if(CSS.Hooks.registered[property]){hookRoot = CSS.Hooks.getRoot(property);var rootPropertyValueCache=Data(element).rootPropertyValueCache[hookRoot];if(rootPropertyValueCache){tween.rootPropertyValue = rootPropertyValueCache;}} /*****************
									 DOM Update
									 *****************/ /* setPropertyValue() returns an array of the property name and property value post any normalization that may have been performed. */ /* Note: To solve an IE<=8 positioning bug, the unit type is dropped when setting a property value of 0. */var adjustedSetData=CSS.setPropertyValue(element, /* SET */property,tween.currentValue + (IE < 9 && parseFloat(currentValue) === 0?"":tween.unitType),tween.rootPropertyValue,tween.scrollData); /*******************
									 Hooks: Part II
									 *******************/ /* Now that we have the hook's updated rootPropertyValue (the post-processed value provided by adjustedSetData), cache it onto the element. */if(CSS.Hooks.registered[property]){ /* Since adjustedSetData contains normalized data ready for DOM updating, the rootPropertyValue needs to be re-extracted from its normalized form. ?? */if(CSS.Normalizations.registered[hookRoot]){Data(element).rootPropertyValueCache[hookRoot] = CSS.Normalizations.registered[hookRoot]("extract",null,adjustedSetData[1]);}else {Data(element).rootPropertyValueCache[hookRoot] = adjustedSetData[1];}} /***************
									 Transforms
									 ***************/ /* Flag whether a transform property is being animated so that flushTransformCache() can be triggered once this tick pass is complete. */if(adjustedSetData[0] === "transform"){transformPropertyExists = true;}}}} /****************
						 mobileHA
						 ****************/ /* If mobileHA is enabled, set the translate3d transform to null to force hardware acceleration.
						 It's safe to override this property since Velocity doesn't actually support its animation (hooks are used in its place). */if(opts.mobileHA){ /* Don't set the null transform hack if we've already done so. */if(Data(element).transformCache.translate3d === undefined){ /* All entries on the transformCache object are later concatenated into a single transform string via flushTransformCache(). */Data(element).transformCache.translate3d = "(0px, 0px, 0px)";transformPropertyExists = true;}}if(transformPropertyExists){CSS.flushTransformCache(element);}} /* The non-"none" display value is only applied to an element once -- when its associated call is first ticked through.
					 Accordingly, it's set to false so that it isn't re-processed by this call in the next tick. */if(opts.display !== undefined && opts.display !== "none"){Velocity.State.calls[i][2].display = false;}if(opts.visibility !== undefined && opts.visibility !== "hidden"){Velocity.State.calls[i][2].visibility = false;} /* Pass the elements and the timing data (percentComplete, msRemaining, timeStart, tweenDummyValue) into the progress callback. */if(opts.progress){opts.progress.call(callContainer[1],callContainer[1],percentComplete,Math.max(0,timeStart + opts.duration - timeCurrent),timeStart,tweenDummyValue);} /* If this call has finished tweening, pass its index to completeCall() to handle call cleanup. */if(percentComplete === 1){completeCall(i);}}} /* Note: completeCall() sets the isTicking flag to false when the last call on Velocity.State.calls has completed. */if(Velocity.State.isTicking){ticker(tick);}} /**********************
		 Call Completion
		 **********************/ /* Note: Unlike tick(), which processes all active calls at once, call completion is handled on a per-call basis. */function completeCall(callIndex,isStopped){ /* Ensure the call exists. */if(!Velocity.State.calls[callIndex]){return false;} /* Pull the metadata from the call. */var call=Velocity.State.calls[callIndex][0],elements=Velocity.State.calls[callIndex][1],opts=Velocity.State.calls[callIndex][2],resolver=Velocity.State.calls[callIndex][4];var remainingCallsExist=false; /*************************
			 Element Finalization
			 *************************/for(var i=0,callLength=call.length;i < callLength;i++) {var element=call[i].element; /* If the user set display to "none" (intending to hide the element), set it now that the animation has completed. */ /* Note: display:none isn't set when calls are manually stopped (via Velocity("stop"). */ /* Note: Display gets ignored with "reverse" calls and infinite loops, since this behavior would be undesirable. */if(!isStopped && !opts.loop){if(opts.display === "none"){CSS.setPropertyValue(element,"display",opts.display);}if(opts.visibility === "hidden"){CSS.setPropertyValue(element,"visibility",opts.visibility);}} /* If the element's queue is empty (if only the "inprogress" item is left at position 0) or if its queue is about to run
				 a non-Velocity-initiated entry, turn off the isAnimating flag. A non-Velocity-initiatied queue entry's logic might alter
				 an element's CSS values and thereby cause Velocity's cached value data to go stale. To detect if a queue entry was initiated by Velocity,
				 we check for the existence of our special Velocity.queueEntryFlag declaration, which minifiers won't rename since the flag
				 is assigned to jQuery's global $ object and thus exists out of Velocity's own scope. */var data=Data(element);if(opts.loop !== true && ($.queue(element)[1] === undefined || !/\.velocityQueueEntryFlag/i.test($.queue(element)[1]))){ /* The element may have been deleted. Ensure that its data cache still exists before acting on it. */if(data){data.isAnimating = false; /* Clear the element's rootPropertyValueCache, which will become stale. */data.rootPropertyValueCache = {};var transformHAPropertyExists=false; /* If any 3D transform subproperty is at its default value (regardless of unit type), remove it. */$.each(CSS.Lists.transforms3D,function(i,transformName){var defaultValue=/^scale/.test(transformName)?1:0,currentValue=data.transformCache[transformName];if(data.transformCache[transformName] !== undefined && new RegExp("^\\(" + defaultValue + "[^.]").test(currentValue)){transformHAPropertyExists = true;delete data.transformCache[transformName];}}); /* Mobile devices have hardware acceleration removed at the end of the animation in order to avoid hogging the GPU's memory. */if(opts.mobileHA){transformHAPropertyExists = true;delete data.transformCache.translate3d;} /* Flush the subproperty removals to the DOM. */if(transformHAPropertyExists){CSS.flushTransformCache(element);} /* Remove the "velocity-animating" indicator class. */CSS.Values.removeClass(element,"velocity-animating");}} /*********************
				 Option: Complete
				 *********************/ /* Complete is fired once per call (not once per element) and is passed the full raw DOM element set as both its context and its first argument. */ /* Note: Callbacks aren't fired when calls are manually stopped (via Velocity("stop"). */if(!isStopped && opts.complete && !opts.loop && i === callLength - 1){ /* We throw callbacks in a setTimeout so that thrown errors don't halt the execution of Velocity itself. */try{opts.complete.call(elements,elements);}catch(error) {setTimeout(function(){throw error;},1);}} /**********************
				 Promise Resolving
				 **********************/ /* Note: Infinite loops don't return promises. */if(resolver && opts.loop !== true){resolver(elements);} /****************************
				 Option: Loop (Infinite)
				 ****************************/if(data && opts.loop === true && !isStopped){ /* If a rotateX/Y/Z property is being animated by 360 deg with loop:true, swap tween start/end values to enable
					 continuous iterative rotation looping. (Otherise, the element would just rotate back and forth.) */$.each(data.tweensContainer,function(propertyName,tweenContainer){if(/^rotate/.test(propertyName) && (parseFloat(tweenContainer.startValue) - parseFloat(tweenContainer.endValue)) % 360 === 0){var oldStartValue=tweenContainer.startValue;tweenContainer.startValue = tweenContainer.endValue;tweenContainer.endValue = oldStartValue;}if(/^backgroundPosition/.test(propertyName) && parseFloat(tweenContainer.endValue) === 100 && tweenContainer.unitType === "%"){tweenContainer.endValue = 0;tweenContainer.startValue = 100;}});Velocity(element,"reverse",{loop:true,delay:opts.delay});} /***************
				 Dequeueing
				 ***************/ /* Fire the next call in the queue so long as this call's queue wasn't set to false (to trigger a parallel animation),
				 which would have already caused the next call to fire. Note: Even if the end of the animation queue has been reached,
				 $.dequeue() must still be called in order to completely clear jQuery's animation queue. */if(opts.queue !== false){$.dequeue(element,opts.queue);}} /************************
			 Calls Array Cleanup
			 ************************/ /* Since this call is complete, set it to false so that the rAF tick skips it. This array is later compacted via compactSparseArray().
			 (For performance reasons, the call is set to false instead of being deleted from the array: http://www.html5rocks.com/en/tutorials/speed/v8/) */Velocity.State.calls[callIndex] = false; /* Iterate through the calls array to determine if this was the final in-progress animation.
			 If so, set a flag to end ticking and clear the calls array. */for(var j=0,callsLength=Velocity.State.calls.length;j < callsLength;j++) {if(Velocity.State.calls[j] !== false){remainingCallsExist = true;break;}}if(remainingCallsExist === false){ /* tick() will detect this flag upon its next iteration and subsequently turn itself off. */Velocity.State.isTicking = false; /* Clear the calls array so that its length is reset. */delete Velocity.State.calls;Velocity.State.calls = [];}} /******************
		 Frameworks
		 ******************/ /* Both jQuery and Zepto allow their $.fn object to be extended to allow wrapped elements to be subjected to plugin calls.
		 If either framework is loaded, register a "velocity" extension pointing to Velocity's core animate() method.  Velocity
		 also registers itself onto a global container (window.jQuery || window.Zepto || window) so that certain features are
		 accessible beyond just a per-element scope. This master object contains an .animate() method, which is later assigned to $.fn
		 (if jQuery or Zepto are present). Accordingly, Velocity can both act on wrapped DOM elements and stand alone for targeting raw DOM elements. */global.Velocity = Velocity;if(global !== window){ /* Assign the element function to Velocity's core animate() method. */global.fn.velocity = animate; /* Assign the object function's defaults to Velocity's global defaults object. */global.fn.velocity.defaults = Velocity.defaults;} /***********************
		 Packaged Redirects
		 ***********************/ /* slideUp, slideDown */$.each(["Down","Up"],function(i,direction){Velocity.Redirects["slide" + direction] = function(element,options,elementsIndex,elementsSize,elements,promiseData){var opts=$.extend({},options),begin=opts.begin,complete=opts.complete,inlineValues={},computedValues={height:"",marginTop:"",marginBottom:"",paddingTop:"",paddingBottom:""};if(opts.display === undefined){ /* Show the element before slideDown begins and hide the element after slideUp completes. */ /* Note: Inline elements cannot have dimensions animated, so they're reverted to inline-block. */opts.display = direction === "Down"?Velocity.CSS.Values.getDisplayType(element) === "inline"?"inline-block":"block":"none";}opts.begin = function(){ /* If the user passed in a begin callback, fire it now. */if(elementsIndex === 0 && begin){begin.call(elements,elements);} /* Cache the elements' original vertical dimensional property values so that we can animate back to them. */for(var property in computedValues) {if(!computedValues.hasOwnProperty(property)){continue;}inlineValues[property] = element.style[property]; /* For slideDown, use forcefeeding to animate all vertical properties from 0. For slideUp,
						 use forcefeeding to start from computed values and animate down to 0. */var propertyValue=CSS.getPropertyValue(element,property);computedValues[property] = direction === "Down"?[propertyValue,0]:[0,propertyValue];} /* Force vertical overflow content to clip so that sliding works as expected. */inlineValues.overflow = element.style.overflow;element.style.overflow = "hidden";};opts.complete = function(){ /* Reset element to its pre-slide inline values once its slide animation is complete. */for(var property in inlineValues) {if(inlineValues.hasOwnProperty(property)){element.style[property] = inlineValues[property];}} /* If the user passed in a complete callback, fire it now. */if(elementsIndex === elementsSize - 1){if(complete){complete.call(elements,elements);}if(promiseData){promiseData.resolver(elements);}}};Velocity(element,computedValues,opts);};}); /* fadeIn, fadeOut */$.each(["In","Out"],function(i,direction){Velocity.Redirects["fade" + direction] = function(element,options,elementsIndex,elementsSize,elements,promiseData){var opts=$.extend({},options),complete=opts.complete,propertiesMap={opacity:direction === "In"?1:0}; /* Since redirects are triggered individually for each element in the animated set, avoid repeatedly triggering
				 callbacks by firing them only when the final element has been reached. */if(elementsIndex !== 0){opts.begin = null;}if(elementsIndex !== elementsSize - 1){opts.complete = null;}else {opts.complete = function(){if(complete){complete.call(elements,elements);}if(promiseData){promiseData.resolver(elements);}};} /* If a display was passed in, use it. Otherwise, default to "none" for fadeOut or the element-specific default for fadeIn. */ /* Note: We allow users to pass in "null" to skip display setting altogether. */if(opts.display === undefined){opts.display = direction === "In"?"auto":"none";}Velocity(this,propertiesMap,opts);};});return Velocity;})(window.jQuery || window.Zepto || window,window,window?window.document:undefined);}); /******************
 Known Issues
 ******************/ /* The CSS spec mandates that the translateX/Y/Z transforms are %-relative to the element itself -- not its parent.
 Velocity, however, doesn't make this distinction. Thus, converting to or from the % unit with these subproperties
 will produce an inaccurate conversion value. The same issue exists with the cx/cy attributes of SVG circles and ellipses. */ /* Browser support: Using this shim instead of jQuery proper removes support for IE8. */ // and will not fail on other DOM objects (as do DOM elements in IE < 9)

/***/ }),
/* 5 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var g;

// This works in non-strict mode
g = (function () {
	return this;
})();

try {
	// This works if eval is allowed (see CSP)
	g = g || Function("return this")() || (1, eval)("this");
} catch (e) {
	// This works if the window reference is available
	if (typeof window === "object") g = window;
}

// g can still be undefined, but nothing to do about it...
// We return undefined, instead of nothing here, so it's
// easier to handle this case. if(!global) { ...}

module.exports = g;

/***/ }),
/* 6 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/**
 * 2007-2020 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */
// import './components/swiper-bundle.min';


function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { 'default': obj }; }

__webpack_require__(14);

__webpack_require__(28);

__webpack_require__(23);

__webpack_require__(25);

__webpack_require__(22);

__webpack_require__(21);

__webpack_require__(9);

__webpack_require__(16);

__webpack_require__(19);

__webpack_require__(20);

__webpack_require__(8);

var _componentsDropDown = __webpack_require__(2);

var _componentsDropDown2 = _interopRequireDefault(_componentsDropDown);

var _componentsForm = __webpack_require__(12);

var _componentsForm2 = _interopRequireDefault(_componentsForm);

var _componentsProductMiniature = __webpack_require__(3);

var _componentsProductMiniature2 = _interopRequireDefault(_componentsProductMiniature);

var _componentsProductSelect = __webpack_require__(13);

var _componentsProductSelect2 = _interopRequireDefault(_componentsProductSelect);

var _componentsTopMenu = __webpack_require__(15);

var _componentsTopMenu2 = _interopRequireDefault(_componentsTopMenu);

var _prestashop = __webpack_require__(1);

var _prestashop2 = _interopRequireDefault(_prestashop);

var _events = __webpack_require__(24);

var _events2 = _interopRequireDefault(_events);

__webpack_require__(17);

__webpack_require__(18);

__webpack_require__(11);

__webpack_require__(10);

var _jquery = __webpack_require__(0);

var _jquery2 = _interopRequireDefault(_jquery);

var _vanillaPicker = __webpack_require__(29);

var _vanillaPicker2 = _interopRequireDefault(_vanillaPicker);

// "inherit" EventEmitter
for (var i in _events2['default'].prototype) {
    _prestashop2['default'][i] = _events2['default'].prototype[i];
}
(0, _jquery2['default'])(document).ready(function () {
    var dropDownEl = (0, _jquery2['default'])('.js-dropdown');
    var form = new _componentsForm2['default']();
    var topMenuEl = (0, _jquery2['default'])('.js-top-menu ul[data-depth="0"]');
    var dropDown = new _componentsDropDown2['default'](dropDownEl);
    var topMenu = new _componentsTopMenu2['default'](topMenuEl);
    var productMinitature = new _componentsProductMiniature2['default']();
    var productSelect = new _componentsProductSelect2['default']();
    dropDown.init();
    form.init();
    addAnimationCustom();
    topMenu.init();
    productMinitature.init();
    productSelect.init();
    bondropDown();
    addIconMenu();
    animateSite();
    addToCartAnimation();
    _prestashop2['default'].on('updateCart', function (event) {
        (0, _jquery2['default'])("#_desktop_cart .icon-text > span").text(this.cart.totals.total.value);
    });
});

function addToCartAnimation() {
    (0, _jquery2['default'])('.ajax_add_to_cart_button').on('click', function () {
        var _this = this;

        (0, _jquery2['default'])(this).addClass("active");
        var btnAnimation = document.querySelector('.ajax_add_to_cart_button.active');
        btnAnimation.onanimationend = function () {
            (0, _jquery2['default'])(_this).removeClass("active");
        };
    });
    (0, _jquery2['default'])('.quick-view').on('click', function () {
        var _this2 = this;

        (0, _jquery2['default'])(this).addClass("active");
        var btnAnimation = document.querySelector('.quick-view.active');
        btnAnimation.onanimationend = function () {
            (0, _jquery2['default'])(_this2).removeClass("active");
        };
    });
}

function addIconMenu() {
    var windowHeight = parseInt((0, _jquery2['default'])(window).width());
    if (windowHeight > 767) {
        (0, _jquery2['default'])('<i class="material-icons current">keyboard_arrow_down</i>').appendTo('#top-menu > li.nav-arrows > a');
    }
}
// $('.block-social').appendTo('.block_newsletter');
(0, _jquery2['default'])("#top-menu li").find('div').parent().addClass('nav-arrows');
(0, _jquery2['default'])(".footer_adsress br").replaceWith("&nbsp;");
(0, _jquery2['default'])('#_desktop_language_selector').appendTo('.setting-header-inner');
(0, _jquery2['default'])('#_desktop_currency_selector').appendTo('.setting-header-inner');
(0, _jquery2['default'])('#search_filters_wrapper .color').parent().parent().parent().addClass('color-boxes');
(0, _jquery2['default'])('.color-boxes').parent().css('overflow', 'hidden');

function bondropDown() {
    var elementClick = '.current';
    var elementSlide = '.bon_drop_down';
    var activeClass = 'active';
    (0, _jquery2['default'])(elementClick).on('click', function (e) {
        (0, _jquery2['default'])('#_desktop_language_selector').show();
        (0, _jquery2['default'])('#_desktop_currency_selector').show();
        var subUl = (0, _jquery2['default'])(this).next(elementSlide);
        if (subUl.is(':hidden')) {
            subUl.fadeIn();
            (0, _jquery2['default'])(this).addClass(activeClass);
        } else {
            subUl.fadeOut();
            (0, _jquery2['default'])(this).removeClass(activeClass);
        }
        (0, _jquery2['default'])(elementClick).not(this).next(elementSlide).slideUp();
        (0, _jquery2['default'])(elementClick).not(this).removeClass(activeClass);
    });
}
new _vanillaPicker2['default']({
    parent: document.querySelector('#custom-toggler'),
    popup: 'left',
    onDone: function onDone(color) {
        MyStyleColor(color);
    }
});
(0, _jquery2['default'])(document).ready(function () {
    (0, _jquery2['default'])("#back-to-top").css('visibility', 'visible');
    (0, _jquery2['default'])("#back-to-top").hide();
    (0, _jquery2['default'])(function () {
        (0, _jquery2['default'])(window).scroll(function () {
            if ((0, _jquery2['default'])(this).scrollTop() > 100) {
                (0, _jquery2['default'])('#back-to-top').fadeIn();
            } else {
                (0, _jquery2['default'])('#back-to-top').fadeOut();
            }
        });
        (0, _jquery2['default'])('#back-to-top').click(function () {
            (0, _jquery2['default'])('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });
    });
});

function animateSite() {
    var $window = (0, _jquery2['default'])(window);
    (0, _jquery2['default'])('.revealOnScroll').addClass('animated');
    $window.on('scroll', revealOnScroll);

    function revealOnScroll() {
        var scrolled = $window.scrollTop(),
            win_height_padded = $window.height() * 1.1;
        (0, _jquery2['default'])(".revealOnScroll:not(.animated)").each(function () {
            var $this = (0, _jquery2['default'])(this),
                offsetTop = $this.offset().top;
            if (scrolled + win_height_padded > offsetTop) {
                if ($this.data('timeout')) {
                    window.setTimeout(function () {
                        $this.addClass('animated ' + $this.data('animation'));
                    }, parseInt($this.data('timeout'), 10));
                } else {
                    $this.addClass('animated ' + $this.data('animation'));
                }
            }
        });
        (0, _jquery2['default'])(".revealOnScroll.animated").each(function () {
            var $this = (0, _jquery2['default'])(this),
                offsetTop = $this.offset().top;
            if (scrolled + win_height_padded < offsetTop) {
                (0, _jquery2['default'])(this).removeClass('animated fadeInUp zoomIn fadeInLeft rollIn rotateInDownRight wobble flash pulse fadeInDown fadeInRight rotateIn rotateInUpLeft tada shake fadeInLeftBig lightSpeedIn slideInUp  flipInY hinge fadeInLeftBig flip rotateInDownLeft  rotateInUpRight slideInLeft slideInRight  flipInX ');
            }
        });
    }
    var count2 = 1;
    (0, _jquery2['default'])('.instagram-carousel-container .instagram-item').each(function () {
        (0, _jquery2['default'])(this).attr('data-timeout', count2 * 120);
        count2++;
    });
    var count = 1;
    (0, _jquery2['default'])('#main .main-animate-product .products article').each(function () {
        (0, _jquery2['default'])(this).attr('data-timeout', count * 120);
        count++;
    });
    var count3 = 1;
    (0, _jquery2['default'])('#main .feature-animate .products article').each(function () {
        (0, _jquery2['default'])(this).attr('data-timeout', count3 * 120);
        count3++;
    });
    var count5 = 1;
    (0, _jquery2['default'])('#product .product-accessories .products article').each(function () {
        (0, _jquery2['default'])(this).attr('data-timeout', count5 * 120);
        count5++;
    });
    var count6 = 1;
    (0, _jquery2['default'])('#product .same-products .products article').each(function () {
        (0, _jquery2['default'])(this).attr('data-timeout', count6 * 120);
        count6++;
    });
    revealOnScroll();
};

function addAnimationCustom() {
    (0, _jquery2['default'])('#bonhtmlcontent .box-htmlcontent .box-icon').addClass('revealOnScroll animated tada');
    (0, _jquery2['default'])('#bonhtmlcontent .box-htmlcontent .box-icon').attr('data-animation', 'tada');
    (0, _jquery2['default'])('#bonhtmlcontent .box-htmlcontent .box-content').addClass('revealOnScroll animated fadeInUp');
    (0, _jquery2['default'])('#bonhtmlcontent .box-htmlcontent .box-content').attr('data-animation', 'fadeInUp');
}

// hover navigation
// let overlay = document.querySelector('header .bon-link-overlay'),
//     navList = document.querySelectorAll('header .menu>.top-menu>li');
// navList.forEach((list, index) => {
//     list.addEventListener('mouseover', () => {
//         let position = list.getBoundingClientRect();
//         overlay.classList.add('active');
//         overlay.style.left = position.x + 2 + 'px';
//         overlay.style.top = 0;
//         overlay.style.height = position.height + 'px';
//         overlay.style.width = position.width - 3 + 'px';
//         if (index == 0) {
//             overlay.style.width = position.width + 'px';
//             overlay.style.left = position.x + 'px';
//         }
//     });
//     list.addEventListener('mouseout', () => {
//         overlay.classList.remove('active');
//     });
// });

/***/ }),
/* 7 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),
/* 8 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/**
 * 2007-2020 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */



function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { 'default': obj }; }

var _jquery = __webpack_require__(0);

var _jquery2 = _interopRequireDefault(_jquery);

var _prestashop = __webpack_require__(1);

var _prestashop2 = _interopRequireDefault(_prestashop);

_prestashop2['default'].cart = _prestashop2['default'].cart || {};

_prestashop2['default'].cart.active_inputs = null;

var spinnerSelector = 'input[name="product-quantity-spin"]';
var hasError = false;
var isUpdateOperation = false;
var errorMsg = '';

/**
 * Attach Bootstrap TouchSpin event handlers
 */
function createSpin() {
  _jquery2['default'].each((0, _jquery2['default'])(spinnerSelector), function (index, spinner) {
    (0, _jquery2['default'])(spinner).TouchSpin({
      verticalbuttons: true,
      verticalupclass: 'material-icons touchspin-up',
      verticaldownclass: 'material-icons touchspin-down',
      buttondown_class: 'btn btn-touchspin js-touchspin js-increase-product-quantity',
      buttonup_class: 'btn btn-touchspin js-touchspin js-decrease-product-quantity',
      min: parseInt((0, _jquery2['default'])(spinner).attr('min'), 10),
      max: 1000000
    });
  });

  CheckUpdateQuantityOperations.switchErrorStat();
}

(0, _jquery2['default'])(document).ready(function () {
  var productLineInCartSelector = '.js-cart-line-product-quantity';
  var promises = [];

  _prestashop2['default'].on('updateCart', function () {
    (0, _jquery2['default'])('.quickview').modal('hide');
  });

  _prestashop2['default'].on('updatedCart', function () {
    createSpin();
  });

  createSpin();

  var $body = (0, _jquery2['default'])('body');

  function isTouchSpin(namespace) {
    return namespace === 'on.startupspin' || namespace === 'on.startdownspin';
  }

  function shouldIncreaseProductQuantity(namespace) {
    return namespace === 'on.startupspin';
  }

  function findCartLineProductQuantityInput($target) {
    var $input = $target.parents('.bootstrap-touchspin').find(productLineInCartSelector);

    if ($input.is(':focus')) {
      return null;
    }

    return $input;
  }

  function camelize(subject) {
    var actionTypeParts = subject.split('-');
    var i = undefined;
    var part = undefined;
    var camelizedSubject = '';

    for (i = 0; i < actionTypeParts.length; i++) {
      part = actionTypeParts[i];

      if (0 !== i) {
        part = part.substring(0, 1).toUpperCase() + part.substring(1);
      }

      camelizedSubject = camelizedSubject + part;
    }

    return camelizedSubject;
  }

  function parseCartAction($target, namespace) {
    if (!isTouchSpin(namespace)) {
      return {
        url: $target.attr('href'),
        type: camelize($target.data('link-action'))
      };
    }

    var $input = findCartLineProductQuantityInput($target);
    if (!$input) {
      return;
    }

    var cartAction = {};
    if (shouldIncreaseProductQuantity(namespace)) {
      cartAction = {
        url: $input.data('up-url'),
        type: 'increaseProductQuantity'
      };
    } else {
      cartAction = {
        url: $input.data('down-url'),
        type: 'decreaseProductQuantity'
      };
    }

    return cartAction;
  }

  var abortPreviousRequests = function abortPreviousRequests() {
    var promise;
    while (promises.length > 0) {
      promise = promises.pop();
      promise.abort();
    }
  };

  var getTouchSpinInput = function getTouchSpinInput($button) {
    return (0, _jquery2['default'])($button.parents('.bootstrap-touchspin').find('input'));
  };

  var handleCartAction = function handleCartAction(event) {
    event.preventDefault();

    var $target = (0, _jquery2['default'])(event.currentTarget);
    var dataset = event.currentTarget.dataset;

    var cartAction = parseCartAction($target, event.namespace);
    var requestData = {
      ajax: '1',
      action: 'update'
    };

    if (!cartAction) {
      return;
    }

    abortPreviousRequests();
    _jquery2['default'].ajax({
      url: cartAction.url,
      method: 'POST',
      data: requestData,
      dataType: 'json',
      beforeSend: function beforeSend(jqXHR) {
        promises.push(jqXHR);
      }
    }).then(function (resp) {
      CheckUpdateQuantityOperations.checkUpdateOpertation(resp);
      var $quantityInput = getTouchSpinInput($target);
      $quantityInput.val(resp.quantity);

      // Refresh cart preview
      _prestashop2['default'].emit('updateCart', {
        reason: dataset,
        resp: resp
      });
    }).fail(function (resp) {
      _prestashop2['default'].emit('handleError', {
        eventType: 'updateProductInCart',
        resp: resp,
        cartAction: cartAction.type
      });
    });
  };

  $body.on('click', '[data-link-action="delete-from-cart"], [data-link-action="remove-voucher"]', handleCartAction);

  $body.on('touchspin.on.startdownspin', spinnerSelector, handleCartAction);
  $body.on('touchspin.on.startupspin', spinnerSelector, handleCartAction);

  function sendUpdateQuantityInCartRequest(updateQuantityInCartUrl, requestData, $target) {
    abortPreviousRequests();

    return _jquery2['default'].ajax({
      url: updateQuantityInCartUrl,
      method: 'POST',
      data: requestData,
      dataType: 'json',
      beforeSend: function beforeSend(jqXHR) {
        promises.push(jqXHR);
      }
    }).then(function (resp) {
      CheckUpdateQuantityOperations.checkUpdateOpertation(resp);
      $target.val(resp.quantity);

      var dataset;
      if ($target && $target.dataset) {
        dataset = $target.dataset;
      } else {
        dataset = resp;
      }

      // Refresh cart preview
      _prestashop2['default'].emit('updateCart', {
        reason: dataset
      });
    }).fail(function (resp) {
      _prestashop2['default'].emit('handleError', { eventType: 'updateProductQuantityInCart', resp: resp });
    });
  }

  function getRequestData(quantity) {
    return {
      ajax: '1',
      qty: Math.abs(quantity),
      action: 'update',
      op: getQuantityChangeType(quantity)
    };
  }

  function getQuantityChangeType($quantity) {
    return $quantity > 0 ? 'up' : 'down';
  }

  function updateProductQuantityInCart(event) {
    var $target = (0, _jquery2['default'])(event.currentTarget);
    var updateQuantityInCartUrl = $target.data('update-url');
    var baseValue = $target.attr('value');

    // There should be a valid product quantity in cart
    var targetValue = $target.val();
    if (targetValue != parseInt(targetValue) || targetValue < 0 || isNaN(targetValue)) {
      $target.val(baseValue);
      return;
    }

    // There should be a new product quantity in cart
    var qty = targetValue - baseValue;
    if (qty === 0) {
      return;
    }

    $target.attr('value', targetValue);
    sendUpdateQuantityInCartRequest(updateQuantityInCartUrl, getRequestData(qty), $target);
  }

  $body.on('focusout keyup', productLineInCartSelector, function (event) {
    if (event.type === 'keyup') {
      if (event.keyCode === 13) {
        updateProductQuantityInCart(event);
      }
      return false;
    }

    updateProductQuantityInCart(event);
  });

  $body.on('click', '.js-discount .code', function (event) {
    event.stopPropagation();

    var $code = (0, _jquery2['default'])(event.currentTarget);
    var $discountInput = (0, _jquery2['default'])('[name=discount_name]');

    $discountInput.val($code.text());

    return false;
  });
});

var CheckUpdateQuantityOperations = {
  'switchErrorStat': function switchErrorStat() {
    /**
     * if errorMsg is not empty or if notifications are shown, we have error to display
     * if hasError is true, quantity was not updated : we don't disable checkout button
     */
    var $checkoutBtn = (0, _jquery2['default'])('.checkout a');
    if ((0, _jquery2['default'])("#notifications article.alert-danger").length || '' !== errorMsg && !hasError) {
      $checkoutBtn.addClass('disabled');
    }

    if ('' !== errorMsg) {
      var strError = ' <article class="alert alert-danger" role="alert" data-alert="danger"><ul><li>' + errorMsg + '</li></ul></article>';
      (0, _jquery2['default'])('#notifications .container').html(strError);
      errorMsg = '';
      isUpdateOperation = false;
      if (hasError) {
        // if hasError is true, quantity was not updated : allow checkout
        $checkoutBtn.removeClass('disabled');
      }
    } else if (!hasError && isUpdateOperation) {
      hasError = false;
      isUpdateOperation = false;
      (0, _jquery2['default'])('#notifications .container').html('');
      $checkoutBtn.removeClass('disabled');
    }
  },
  'checkUpdateOpertation': function checkUpdateOpertation(resp) {
    /**
     * resp.hasError can be not defined but resp.errors not empty: quantity is updated but order cannot be placed
     * when resp.hasError=true, quantity is not updated
     */
    hasError = resp.hasOwnProperty('hasError');
    var errors = resp.errors || "";
    // 1.7.2.x returns errors as string, 1.7.3.x returns array
    if (errors instanceof Array) {
      errorMsg = errors.join(" ");
    } else {
      errorMsg = errors;
    }

    isUpdateOperation = true;
  }
};

/***/ }),
/* 9 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/**
 * 2007-2020 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */



function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { 'default': obj }; }

var _jquery = __webpack_require__(0);

var _jquery2 = _interopRequireDefault(_jquery);

var _prestashop = __webpack_require__(1);

var _prestashop2 = _interopRequireDefault(_prestashop);

function setUpCheckout() {
  if ((0, _jquery2['default'])('.js-cancel-address').length !== 0) {
    (0, _jquery2['default'])('.checkout-step:not(.js-current-step) .step-title').addClass('not-allowed');
  }

  (0, _jquery2['default'])('.js-terms a').on('click', function (event) {
    event.preventDefault();
    var url = (0, _jquery2['default'])(event.target).attr('href');
    if (url) {
      // TODO: Handle request if no pretty URL
      url += '?content_only=1';
      _jquery2['default'].get(url, function (content) {
        (0, _jquery2['default'])('#modal').find('.js-modal-content').html((0, _jquery2['default'])(content).find('.page-cms').contents());
      }).fail(function (resp) {
        _prestashop2['default'].emit('handleError', { eventType: 'clickTerms', resp: resp });
      });
    }

    (0, _jquery2['default'])('#modal').modal('show');
  });

  (0, _jquery2['default'])('.js-gift-checkbox').on('click', function (event) {
    (0, _jquery2['default'])('#gift').collapse('toggle');
  });
}

(0, _jquery2['default'])(document).ready(function () {
  if ((0, _jquery2['default'])('body#checkout').length === 1) {
    setUpCheckout();
  }

  _prestashop2['default'].on('updatedDeliveryForm', function (params) {
    if (typeof params.deliveryOption === 'undefined' || 0 === params.deliveryOption.length) {
      return;
    }
    // Hide all carrier extra content ...
    (0, _jquery2['default'])(".carrier-extra-content").hide();
    // and show the one related to the selected carrier
    params.deliveryOption.next(".carrier-extra-content").show();
  });
});

/***/ }),
/* 10 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/**
 * 2007-2020 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */



document.addEventListener("DOMContentLoaded", aboutAccordion);

function aboutAccordion() {
  var $video = $(".about-us-img-video");
  var $poster = $('.about-us-img-poster');
  $video.on("mouseover", show);
  $video.on("mouseleave", hide);
  delitePoster();

  function show() {
    $(this).attr("controls", "");
  }

  function hide() {
    var isPlaying = false;
    if (!$(".about-us-img-video").get(0).paused) {
      isPlaying = true;
    }
    if (!isPlaying) {
      $(this).removeAttr("controls");
    }
  }

  function delitePoster() {
    $video.click(function () {
      if ($video.pause) {
        $poster.show();
      } else {
        $poster.hide();
      }
    });
  }
  $(function () {
    var Accordion = function Accordion(el, multiple) {
      this.el = el || {};
      this.multiple = multiple || false;
      var links = this.el.find('.link');
      links.on('click', {
        el: this.el,
        multiple: this.multiple
      }, this.dropdown);
    };
    Accordion.prototype.dropdown = function (e) {
      var $el = e.data.el,
          $this = $(this),
          $next = $this.next();
      $next.slideToggle();
      $this.parent().toggleClass('open');
      if (!e.data.multiple) {
        $el.find('.submenu').not($next).slideUp().parent().removeClass('open');
      };
    };
    var accordion = new Accordion($('#accordion'), false);
  });
  $('.about-us-social').append('<ul><li class="facebook"><a href="#" target="_blank"><i class="fl-outicons-facebook7"></i></a></li><li class="twitter"><a href="" target="_blank"><i class="fl-outicons-twitter4"></i></a></li><li class="youtube"><a href="#" target="_blank"><i class="fl-outicons-user189"></i></a></li></ul>');
}

/***/ }),
/* 11 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/**
 * 2007-2020 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */


function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { 'default': obj }; }

var _prestashop = __webpack_require__(1);

var _prestashop2 = _interopRequireDefault(_prestashop);

var _jquery = __webpack_require__(0);

var _jquery2 = _interopRequireDefault(_jquery);

_prestashop2['default'].blockcart = _prestashop2['default'].blockcart || {};

_prestashop2['default'].blockcart.showModal = function (html) {
  function getBlockCartModal() {
    return (0, _jquery2['default'])('#blockcart-modal');
  }

  var $blockCartModal = getBlockCartModal();
  if ($blockCartModal.length) {
    $blockCartModal.remove();
  }
  (0, _jquery2['default'])('body').append(html);

  $blockCartModal = getBlockCartModal();
  $blockCartModal.modal('show').on('hidden.bs.modal', function (event) {
    //prestashop.emit('updateProduct', {
    //reason: event.currentTarget.dataset,
    //event: event
    //});
  });
};

/***/ }),
/* 12 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/**
 * 2007-2020 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */


Object.defineProperty(exports, '__esModule', {
  value: true
});

var _createClass = (function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ('value' in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; })();

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { 'default': obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError('Cannot call a class as a function'); } }

var _jquery = __webpack_require__(0);

var _jquery2 = _interopRequireDefault(_jquery);

var Form = (function () {
  function Form() {
    _classCallCheck(this, Form);
  }

  _createClass(Form, [{
    key: 'init',
    value: function init() {
      this.parentFocus();
      this.togglePasswordVisibility();
    }
  }, {
    key: 'parentFocus',
    value: function parentFocus() {
      (0, _jquery2['default'])('.js-child-focus').focus(function () {
        (0, _jquery2['default'])(this).closest('.js-parent-focus').addClass('focus');
      });
      (0, _jquery2['default'])('.js-child-focus').focusout(function () {
        (0, _jquery2['default'])(this).closest('.js-parent-focus').removeClass('focus');
      });
    }
  }, {
    key: 'togglePasswordVisibility',
    value: function togglePasswordVisibility() {
      (0, _jquery2['default'])('button[data-action="show-password"]').on('click', function () {
        var elm = (0, _jquery2['default'])(this).closest('.input-group').children('input.js-visible-password');
        if (elm.attr('type') === 'password') {
          elm.attr('type', 'text');
          (0, _jquery2['default'])(this).text((0, _jquery2['default'])(this).data('textHide'));
        } else {
          elm.attr('type', 'password');
          (0, _jquery2['default'])(this).text((0, _jquery2['default'])(this).data('textShow'));
        }
      });
    }
  }]);

  return Form;
})();

exports['default'] = Form;
module.exports = exports['default'];

/***/ }),
/* 13 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/**
 * 2007-2020 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */


Object.defineProperty(exports, '__esModule', {
  value: true
});

var _createClass = (function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ('value' in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; })();

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { 'default': obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError('Cannot call a class as a function'); } }

var _jquery = __webpack_require__(0);

var _jquery2 = _interopRequireDefault(_jquery);

__webpack_require__(4);

var ProductSelect = (function () {
  function ProductSelect() {
    _classCallCheck(this, ProductSelect);
  }

  _createClass(ProductSelect, [{
    key: 'init',
    value: function init() {
      var _this = this;

      var MAX_THUMBS = 5;
      var $arrows = (0, _jquery2['default'])('.js-modal-arrows');
      var $thumbnails = (0, _jquery2['default'])('.js-modal-product-images');

      (0, _jquery2['default'])('body').on('click', '.js-modal-thumb', function (event) {
        if ((0, _jquery2['default'])('.js-modal-thumb').hasClass('selected')) {
          (0, _jquery2['default'])('.js-modal-thumb').removeClass('selected');
        }
        (0, _jquery2['default'])(event.currentTarget).addClass('selected');
        (0, _jquery2['default'])('.js-modal-product-cover').attr('src', (0, _jquery2['default'])(event.target).data('image-large-src'));
        (0, _jquery2['default'])('.js-modal-product-cover').attr('title', (0, _jquery2['default'])(event.target).attr('title'));
        (0, _jquery2['default'])('.js-modal-product-cover').attr('alt', (0, _jquery2['default'])(event.target).attr('alt'));
      }).on('click#product-modal', 'aside#thumbnails', function (event) {
        if (event.target.id == 'thumbnails') {
          (0, _jquery2['default'])('#product-modal').modal('hide');
        }
      });

      if ((0, _jquery2['default'])('.js-modal-product-images li').length <= MAX_THUMBS) {
        $arrows.css('opacity', '.2');
      } else {
        $arrows.on('click', function (event) {
          if ((0, _jquery2['default'])(event.target).hasClass('arrow-up') && $thumbnails.position().top < 0) {
            _this.move('up');
            (0, _jquery2['default'])('.js-modal-arrow-down').css('opacity', '1');
          } else if ((0, _jquery2['default'])(event.target).hasClass('arrow-down') && $thumbnails.position().top + $thumbnails.height() > (0, _jquery2['default'])('.js-modal-mask').height()) {
            _this.move('down');
            (0, _jquery2['default'])('.js-modal-arrow-up').css('opacity', '1');
          }
        });
      }
    }
  }, {
    key: 'move',
    value: function move(direction) {
      var THUMB_MARGIN = 10;
      var $thumbnails = (0, _jquery2['default'])('.js-modal-product-images');
      var thumbHeight = (0, _jquery2['default'])('.js-modal-product-images li img').height() + THUMB_MARGIN;
      var currentPosition = $thumbnails.position().top;
      $thumbnails.velocity({
        translateY: direction === 'up' ? currentPosition + thumbHeight : currentPosition - thumbHeight
      }, function () {
        if ($thumbnails.position().top >= 0) {
          (0, _jquery2['default'])('.js-modal-arrow-up').css('opacity', '.2');
        } else if ($thumbnails.position().top + $thumbnails.height() <= (0, _jquery2['default'])('.js-modal-mask').height()) {
          (0, _jquery2['default'])('.js-modal-arrow-down').css('opacity', '.2');
        }
      });
    }
  }]);

  return ProductSelect;
})();

exports['default'] = ProductSelect;
module.exports = exports['default'];

/***/ }),
/* 14 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;/**
 * 2015-2020 Bonpresta
 *
 * Bonpresta Awesome Image Slider
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the General Public License (GPL 2.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/GPL-2.0
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade the module to newer
 * versions in the future.
 *
 * Version: 1.8.0
 * Author: Ken Wheeler
 * Website: http://kenwheeler.github.io
 * Docs: http://kenwheeler.github.io/slick
 * Repo: http://github.com/kenwheeler/slick
 * Issues: http://github.com/kenwheeler/slick/issues
 */



;(function (factory) {
    'use strict';
    if (true) {
        !(__WEBPACK_AMD_DEFINE_ARRAY__ = [__webpack_require__(0)], __WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
    } else if (typeof exports !== 'undefined') {
        module.exports = factory(require('jquery'));
    } else {
        factory(jQuery);
    }
})(function ($) {
    'use strict';
    var Slick = window.Slick || {};

    Slick = (function () {

        var instanceUid = 0;

        function Slick(element, settings) {

            var _ = this,
                dataSettings;

            _.defaults = {
                accessibility: true,
                adaptiveHeight: false,
                appendArrows: $(element),
                appendDots: $(element),
                arrows: true,
                asNavFor: null,
                prevArrow: '<button class="slick-prev" aria-label="Previous" type="button">Previous</button>',
                nextArrow: '<button class="slick-next" aria-label="Next" type="button">Next</button>',
                autoplay: false,
                autoplaySpeed: 3000,
                centerMode: false,
                centerPadding: '50px',
                cssEase: 'ease',
                customPaging: function customPaging(slider, i) {
                    return $('<button type="button" />').text(i + 1);
                },
                dots: false,
                dotsClass: 'slick-dots',
                draggable: true,
                easing: 'linear',
                edgeFriction: 0.35,
                fade: false,
                focusOnSelect: false,
                focusOnChange: false,
                infinite: true,
                initialSlide: 0,
                lazyLoad: 'ondemand',
                mobileFirst: false,
                pauseOnHover: true,
                pauseOnFocus: true,
                pauseOnDotsHover: false,
                respondTo: 'window',
                responsive: null,
                rows: 1,
                rtl: false,
                slide: '',
                slidesPerRow: 1,
                slidesToShow: 1,
                slidesToScroll: 1,
                speed: 500,
                swipe: true,
                swipeToSlide: false,
                touchMove: true,
                touchThreshold: 5,
                useCSS: true,
                useTransform: true,
                variableWidth: false,
                vertical: false,
                verticalSwiping: false,
                waitForAnimate: true,
                zIndex: 1000
            };

            _.initials = {
                animating: false,
                dragging: false,
                autoPlayTimer: null,
                currentDirection: 0,
                currentLeft: null,
                currentSlide: 0,
                direction: 1,
                $dots: null,
                listWidth: null,
                listHeight: null,
                loadIndex: 0,
                $nextArrow: null,
                $prevArrow: null,
                scrolling: false,
                slideCount: null,
                slideWidth: null,
                $slideTrack: null,
                $slides: null,
                sliding: false,
                slideOffset: 0,
                swipeLeft: null,
                swiping: false,
                $list: null,
                touchObject: {},
                transformsEnabled: false,
                unslicked: false
            };

            $.extend(_, _.initials);

            _.activeBreakpoint = null;
            _.animType = null;
            _.animProp = null;
            _.breakpoints = [];
            _.breakpointSettings = [];
            _.cssTransitions = false;
            _.focussed = false;
            _.interrupted = false;
            _.hidden = 'hidden';
            _.paused = true;
            _.positionProp = null;
            _.respondTo = null;
            _.rowCount = 1;
            _.shouldClick = true;
            _.$slider = $(element);
            _.$slidesCache = null;
            _.transformType = null;
            _.transitionType = null;
            _.visibilityChange = 'visibilitychange';
            _.windowWidth = 0;
            _.windowTimer = null;

            dataSettings = $(element).data('slick') || {};

            _.options = $.extend({}, _.defaults, settings, dataSettings);

            _.currentSlide = _.options.initialSlide;

            _.originalSettings = _.options;

            if (typeof document.mozHidden !== 'undefined') {
                _.hidden = 'mozHidden';
                _.visibilityChange = 'mozvisibilitychange';
            } else if (typeof document.webkitHidden !== 'undefined') {
                _.hidden = 'webkitHidden';
                _.visibilityChange = 'webkitvisibilitychange';
            }

            _.autoPlay = $.proxy(_.autoPlay, _);
            _.autoPlayClear = $.proxy(_.autoPlayClear, _);
            _.autoPlayIterator = $.proxy(_.autoPlayIterator, _);
            _.changeSlide = $.proxy(_.changeSlide, _);
            _.clickHandler = $.proxy(_.clickHandler, _);
            _.selectHandler = $.proxy(_.selectHandler, _);
            _.setPosition = $.proxy(_.setPosition, _);
            _.swipeHandler = $.proxy(_.swipeHandler, _);
            _.dragHandler = $.proxy(_.dragHandler, _);
            _.keyHandler = $.proxy(_.keyHandler, _);

            _.instanceUid = instanceUid++;

            // A simple way to check for HTML strings
            // Strict HTML recognition (must start with <)
            // Extracted from jQuery v1.11 source
            _.htmlExpr = /^(?:\s*(<[\w\W]+>)[^>]*)$/;

            _.registerBreakpoints();
            _.init(true);
        }

        return Slick;
    })();

    Slick.prototype.activateADA = function () {
        var _ = this;

        _.$slideTrack.find('.slick-active').attr({
            'aria-hidden': 'false'
        }).find('a, input, button, select').attr({
            'tabindex': '0'
        });
    };

    Slick.prototype.addSlide = Slick.prototype.slickAdd = function (markup, index, addBefore) {

        var _ = this;

        if (typeof index === 'boolean') {
            addBefore = index;
            index = null;
        } else if (index < 0 || index >= _.slideCount) {
            return false;
        }

        _.unload();

        if (typeof index === 'number') {
            if (index === 0 && _.$slides.length === 0) {
                $(markup).appendTo(_.$slideTrack);
            } else if (addBefore) {
                $(markup).insertBefore(_.$slides.eq(index));
            } else {
                $(markup).insertAfter(_.$slides.eq(index));
            }
        } else {
            if (addBefore === true) {
                $(markup).prependTo(_.$slideTrack);
            } else {
                $(markup).appendTo(_.$slideTrack);
            }
        }

        _.$slides = _.$slideTrack.children(this.options.slide);

        _.$slideTrack.children(this.options.slide).detach();

        _.$slideTrack.append(_.$slides);

        _.$slides.each(function (index, element) {
            $(element).attr('data-slick-index', index);
        });

        _.$slidesCache = _.$slides;

        _.reinit();
    };

    Slick.prototype.animateHeight = function () {
        var _ = this;
        if (_.options.slidesToShow === 1 && _.options.adaptiveHeight === true && _.options.vertical === false) {
            var targetHeight = _.$slides.eq(_.currentSlide).outerHeight(true);
            _.$list.animate({
                height: targetHeight
            }, _.options.speed);
        }
    };

    Slick.prototype.animateSlide = function (targetLeft, callback) {

        var animProps = {},
            _ = this;

        _.animateHeight();

        if (_.options.rtl === true && _.options.vertical === false) {
            targetLeft = -targetLeft;
        }
        if (_.transformsEnabled === false) {
            if (_.options.vertical === false) {
                _.$slideTrack.animate({
                    left: targetLeft
                }, _.options.speed, _.options.easing, callback);
            } else {
                _.$slideTrack.animate({
                    top: targetLeft
                }, _.options.speed, _.options.easing, callback);
            }
        } else {

            if (_.cssTransitions === false) {
                if (_.options.rtl === true) {
                    _.currentLeft = -_.currentLeft;
                }
                $({
                    animStart: _.currentLeft
                }).animate({
                    animStart: targetLeft
                }, {
                    duration: _.options.speed,
                    easing: _.options.easing,
                    step: function step(now) {
                        now = Math.ceil(now);
                        if (_.options.vertical === false) {
                            animProps[_.animType] = 'translate(' + now + 'px, 0px)';
                            _.$slideTrack.css(animProps);
                        } else {
                            animProps[_.animType] = 'translate(0px,' + now + 'px)';
                            _.$slideTrack.css(animProps);
                        }
                    },
                    complete: function complete() {
                        if (callback) {
                            callback.call();
                        }
                    }
                });
            } else {

                _.applyTransition();
                targetLeft = Math.ceil(targetLeft);

                if (_.options.vertical === false) {
                    animProps[_.animType] = 'translate3d(' + targetLeft + 'px, 0px, 0px)';
                } else {
                    animProps[_.animType] = 'translate3d(0px,' + targetLeft + 'px, 0px)';
                }
                _.$slideTrack.css(animProps);

                if (callback) {
                    setTimeout(function () {

                        _.disableTransition();

                        callback.call();
                    }, _.options.speed);
                }
            }
        }
    };

    Slick.prototype.getNavTarget = function () {

        var _ = this,
            asNavFor = _.options.asNavFor;

        if (asNavFor && asNavFor !== null) {
            asNavFor = $(asNavFor).not(_.$slider);
        }

        return asNavFor;
    };

    Slick.prototype.asNavFor = function (index) {

        var _ = this,
            asNavFor = _.getNavTarget();

        if (asNavFor !== null && typeof asNavFor === 'object') {
            asNavFor.each(function () {
                var target = $(this).slick('getSlick');
                if (!target.unslicked) {
                    target.slideHandler(index, true);
                }
            });
        }
    };

    Slick.prototype.applyTransition = function (slide) {

        var _ = this,
            transition = {};

        if (_.options.fade === false) {
            transition[_.transitionType] = _.transformType + ' ' + _.options.speed + 'ms ' + _.options.cssEase;
        } else {
            transition[_.transitionType] = 'opacity ' + _.options.speed + 'ms ' + _.options.cssEase;
        }

        if (_.options.fade === false) {
            _.$slideTrack.css(transition);
        } else {
            _.$slides.eq(slide).css(transition);
        }
    };

    Slick.prototype.autoPlay = function () {

        var _ = this;

        _.autoPlayClear();

        if (_.slideCount > _.options.slidesToShow) {
            _.autoPlayTimer = setInterval(_.autoPlayIterator, _.options.autoplaySpeed);
        }
    };

    Slick.prototype.autoPlayClear = function () {

        var _ = this;

        if (_.autoPlayTimer) {
            clearInterval(_.autoPlayTimer);
        }
    };

    Slick.prototype.autoPlayIterator = function () {

        var _ = this,
            slideTo = _.currentSlide + _.options.slidesToScroll;

        if (!_.paused && !_.interrupted && !_.focussed) {

            if (_.options.infinite === false) {

                if (_.direction === 1 && _.currentSlide + 1 === _.slideCount - 1) {
                    _.direction = 0;
                } else if (_.direction === 0) {

                    slideTo = _.currentSlide - _.options.slidesToScroll;

                    if (_.currentSlide - 1 === 0) {
                        _.direction = 1;
                    }
                }
            }

            _.slideHandler(slideTo);
        }
    };

    Slick.prototype.buildArrows = function () {

        var _ = this;

        if (_.options.arrows === true) {

            _.$prevArrow = $(_.options.prevArrow).addClass('slick-arrow');
            _.$nextArrow = $(_.options.nextArrow).addClass('slick-arrow');

            if (_.slideCount > _.options.slidesToShow) {

                _.$prevArrow.removeClass('slick-hidden').removeAttr('aria-hidden tabindex');
                _.$nextArrow.removeClass('slick-hidden').removeAttr('aria-hidden tabindex');

                if (_.htmlExpr.test(_.options.prevArrow)) {
                    _.$prevArrow.prependTo(_.options.appendArrows);
                }

                if (_.htmlExpr.test(_.options.nextArrow)) {
                    _.$nextArrow.appendTo(_.options.appendArrows);
                }

                if (_.options.infinite !== true) {
                    _.$prevArrow.addClass('slick-disabled').attr('aria-disabled', 'true');
                }
            } else {

                _.$prevArrow.add(_.$nextArrow).addClass('slick-hidden').attr({
                    'aria-disabled': 'true',
                    'tabindex': '-1'
                });
            }
        }
    };

    Slick.prototype.buildDots = function () {

        var _ = this,
            i,
            dot;

        if (_.options.dots === true) {

            _.$slider.addClass('slick-dotted');

            dot = $('<ul />').addClass(_.options.dotsClass);

            for (i = 0; i <= _.getDotCount(); i += 1) {
                dot.append($('<li />').append(_.options.customPaging.call(this, _, i)));
            }

            _.$dots = dot.appendTo(_.options.appendDots);

            _.$dots.find('li').first().addClass('slick-active');
        }
    };

    Slick.prototype.buildOut = function () {

        var _ = this;

        _.$slides = _.$slider.children(_.options.slide + ':not(.slick-cloned)').addClass('slick-slide');

        _.slideCount = _.$slides.length;

        _.$slides.each(function (index, element) {
            $(element).attr('data-slick-index', index).data('originalStyling', $(element).attr('style') || '');
        });

        _.$slider.addClass('slick-slider');

        _.$slideTrack = _.slideCount === 0 ? $('<div class="slick-track"/>').appendTo(_.$slider) : _.$slides.wrapAll('<div class="slick-track"/>').parent();

        _.$list = _.$slideTrack.wrap('<div class="slick-list"/>').parent();
        _.$slideTrack.css('opacity', 0);

        if (_.options.centerMode === true || _.options.swipeToSlide === true) {
            _.options.slidesToScroll = 1;
        }

        $('img[data-lazy]', _.$slider).not('[src]').addClass('slick-loading');

        _.setupInfinite();

        _.buildArrows();

        _.buildDots();

        _.updateDots();

        _.setSlideClasses(typeof _.currentSlide === 'number' ? _.currentSlide : 0);

        if (_.options.draggable === true) {
            _.$list.addClass('draggable');
        }
    };

    Slick.prototype.buildRows = function () {

        var _ = this,
            a,
            b,
            c,
            newSlides,
            numOfSlides,
            originalSlides,
            slidesPerSection;

        newSlides = document.createDocumentFragment();
        originalSlides = _.$slider.children();

        if (_.options.rows > 1) {

            slidesPerSection = _.options.slidesPerRow * _.options.rows;
            numOfSlides = Math.ceil(originalSlides.length / slidesPerSection);

            for (a = 0; a < numOfSlides; a++) {
                var slide = document.createElement('div');
                for (b = 0; b < _.options.rows; b++) {
                    var row = document.createElement('div');
                    for (c = 0; c < _.options.slidesPerRow; c++) {
                        var target = a * slidesPerSection + (b * _.options.slidesPerRow + c);
                        if (originalSlides.get(target)) {
                            row.appendChild(originalSlides.get(target));
                        }
                    }
                    slide.appendChild(row);
                }
                newSlides.appendChild(slide);
            }

            _.$slider.empty().append(newSlides);
            _.$slider.children().children().children().css({
                'width': 100 / _.options.slidesPerRow + '%',
                'display': 'inline-block'
            });
        }
    };

    Slick.prototype.checkResponsive = function (initial, forceUpdate) {

        var _ = this,
            breakpoint,
            targetBreakpoint,
            respondToWidth,
            triggerBreakpoint = false;
        var sliderWidth = _.$slider.width();
        var windowWidth = window.innerWidth || $(window).width();

        if (_.respondTo === 'window') {
            respondToWidth = windowWidth;
        } else if (_.respondTo === 'slider') {
            respondToWidth = sliderWidth;
        } else if (_.respondTo === 'min') {
            respondToWidth = Math.min(windowWidth, sliderWidth);
        }

        if (_.options.responsive && _.options.responsive.length && _.options.responsive !== null) {

            targetBreakpoint = null;

            for (breakpoint in _.breakpoints) {
                if (_.breakpoints.hasOwnProperty(breakpoint)) {
                    if (_.originalSettings.mobileFirst === false) {
                        if (respondToWidth < _.breakpoints[breakpoint]) {
                            targetBreakpoint = _.breakpoints[breakpoint];
                        }
                    } else {
                        if (respondToWidth > _.breakpoints[breakpoint]) {
                            targetBreakpoint = _.breakpoints[breakpoint];
                        }
                    }
                }
            }

            if (targetBreakpoint !== null) {
                if (_.activeBreakpoint !== null) {
                    if (targetBreakpoint !== _.activeBreakpoint || forceUpdate) {
                        _.activeBreakpoint = targetBreakpoint;
                        if (_.breakpointSettings[targetBreakpoint] === 'unslick') {
                            _.unslick(targetBreakpoint);
                        } else {
                            _.options = $.extend({}, _.originalSettings, _.breakpointSettings[targetBreakpoint]);
                            if (initial === true) {
                                _.currentSlide = _.options.initialSlide;
                            }
                            _.refresh(initial);
                        }
                        triggerBreakpoint = targetBreakpoint;
                    }
                } else {
                    _.activeBreakpoint = targetBreakpoint;
                    if (_.breakpointSettings[targetBreakpoint] === 'unslick') {
                        _.unslick(targetBreakpoint);
                    } else {
                        _.options = $.extend({}, _.originalSettings, _.breakpointSettings[targetBreakpoint]);
                        if (initial === true) {
                            _.currentSlide = _.options.initialSlide;
                        }
                        _.refresh(initial);
                    }
                    triggerBreakpoint = targetBreakpoint;
                }
            } else {
                if (_.activeBreakpoint !== null) {
                    _.activeBreakpoint = null;
                    _.options = _.originalSettings;
                    if (initial === true) {
                        _.currentSlide = _.options.initialSlide;
                    }
                    _.refresh(initial);
                    triggerBreakpoint = targetBreakpoint;
                }
            }

            // only trigger breakpoints during an actual break. not on initialize.
            if (!initial && triggerBreakpoint !== false) {
                _.$slider.trigger('breakpoint', [_, triggerBreakpoint]);
            }
        }
    };

    Slick.prototype.changeSlide = function (event, dontAnimate) {

        var _ = this,
            $target = $(event.currentTarget),
            indexOffset,
            slideOffset,
            unevenOffset;

        // If target is a link, prevent default action.
        if ($target.is('a')) {
            event.preventDefault();
        }

        // If target is not the <li> element (ie: a child), find the <li>.
        if (!$target.is('li')) {
            $target = $target.closest('li');
        }

        unevenOffset = _.slideCount % _.options.slidesToScroll !== 0;
        indexOffset = unevenOffset ? 0 : (_.slideCount - _.currentSlide) % _.options.slidesToScroll;

        switch (event.data.message) {

            case 'previous':
                slideOffset = indexOffset === 0 ? _.options.slidesToScroll : _.options.slidesToShow - indexOffset;
                if (_.slideCount > _.options.slidesToShow) {
                    _.slideHandler(_.currentSlide - slideOffset, false, dontAnimate);
                }
                break;

            case 'next':
                slideOffset = indexOffset === 0 ? _.options.slidesToScroll : indexOffset;
                if (_.slideCount > _.options.slidesToShow) {
                    _.slideHandler(_.currentSlide + slideOffset, false, dontAnimate);
                }
                break;

            case 'index':
                var index = event.data.index === 0 ? 0 : event.data.index || $target.index() * _.options.slidesToScroll;

                _.slideHandler(_.checkNavigable(index), false, dontAnimate);
                $target.children().trigger('focus');
                break;

            default:
                return;
        }
    };

    Slick.prototype.checkNavigable = function (index) {

        var _ = this,
            navigables,
            prevNavigable;

        navigables = _.getNavigableIndexes();
        prevNavigable = 0;
        if (index > navigables[navigables.length - 1]) {
            index = navigables[navigables.length - 1];
        } else {
            for (var n in navigables) {
                if (index < navigables[n]) {
                    index = prevNavigable;
                    break;
                }
                prevNavigable = navigables[n];
            }
        }

        return index;
    };

    Slick.prototype.cleanUpEvents = function () {

        var _ = this;

        if (_.options.dots && _.$dots !== null) {

            $('li', _.$dots).off('click.slick', _.changeSlide).off('mouseenter.slick', $.proxy(_.interrupt, _, true)).off('mouseleave.slick', $.proxy(_.interrupt, _, false));

            if (_.options.accessibility === true) {
                _.$dots.off('keydown.slick', _.keyHandler);
            }
        }

        _.$slider.off('focus.slick blur.slick');

        if (_.options.arrows === true && _.slideCount > _.options.slidesToShow) {
            _.$prevArrow && _.$prevArrow.off('click.slick', _.changeSlide);
            _.$nextArrow && _.$nextArrow.off('click.slick', _.changeSlide);

            if (_.options.accessibility === true) {
                _.$prevArrow && _.$prevArrow.off('keydown.slick', _.keyHandler);
                _.$nextArrow && _.$nextArrow.off('keydown.slick', _.keyHandler);
            }
        }

        _.$list.off('touchstart.slick mousedown.slick', _.swipeHandler);
        _.$list.off('touchmove.slick mousemove.slick', _.swipeHandler);
        _.$list.off('touchend.slick mouseup.slick', _.swipeHandler);
        _.$list.off('touchcancel.slick mouseleave.slick', _.swipeHandler);

        _.$list.off('click.slick', _.clickHandler);

        $(document).off(_.visibilityChange, _.visibility);

        _.cleanUpSlideEvents();

        if (_.options.accessibility === true) {
            _.$list.off('keydown.slick', _.keyHandler);
        }

        if (_.options.focusOnSelect === true) {
            $(_.$slideTrack).children().off('click.slick', _.selectHandler);
        }

        $(window).off('orientationchange.slick.slick-' + _.instanceUid, _.orientationChange);

        $(window).off('resize.slick.slick-' + _.instanceUid, _.resize);

        $('[draggable!=true]', _.$slideTrack).off('dragstart', _.preventDefault);

        $(window).off('load.slick.slick-' + _.instanceUid, _.setPosition);
    };

    Slick.prototype.cleanUpSlideEvents = function () {

        var _ = this;

        _.$list.off('mouseenter.slick', $.proxy(_.interrupt, _, true));
        _.$list.off('mouseleave.slick', $.proxy(_.interrupt, _, false));
    };

    Slick.prototype.cleanUpRows = function () {

        var _ = this,
            originalSlides;

        if (_.options.rows > 1) {
            originalSlides = _.$slides.children().children();
            originalSlides.removeAttr('style');
            _.$slider.empty().append(originalSlides);
        }
    };

    Slick.prototype.clickHandler = function (event) {

        var _ = this;

        if (_.shouldClick === false) {
            event.stopImmediatePropagation();
            event.stopPropagation();
            event.preventDefault();
        }
    };

    Slick.prototype.destroy = function (refresh) {

        var _ = this;

        _.autoPlayClear();

        _.touchObject = {};

        _.cleanUpEvents();

        $('.slick-cloned', _.$slider).detach();

        if (_.$dots) {
            _.$dots.remove();
        }

        if (_.$prevArrow && _.$prevArrow.length) {

            _.$prevArrow.removeClass('slick-disabled slick-arrow slick-hidden').removeAttr('aria-hidden aria-disabled tabindex').css('display', '');

            if (_.htmlExpr.test(_.options.prevArrow)) {
                _.$prevArrow.remove();
            }
        }

        if (_.$nextArrow && _.$nextArrow.length) {

            _.$nextArrow.removeClass('slick-disabled slick-arrow slick-hidden').removeAttr('aria-hidden aria-disabled tabindex').css('display', '');

            if (_.htmlExpr.test(_.options.nextArrow)) {
                _.$nextArrow.remove();
            }
        }

        if (_.$slides) {

            _.$slides.removeClass('slick-slide slick-active slick-center slick-visible slick-current').removeAttr('aria-hidden').removeAttr('data-slick-index').each(function () {
                $(this).attr('style', $(this).data('originalStyling'));
            });

            _.$slideTrack.children(this.options.slide).detach();

            _.$slideTrack.detach();

            _.$list.detach();

            _.$slider.append(_.$slides);
        }

        _.cleanUpRows();

        _.$slider.removeClass('slick-slider');
        _.$slider.removeClass('slick-initialized');
        _.$slider.removeClass('slick-dotted');

        _.unslicked = true;

        if (!refresh) {
            _.$slider.trigger('destroy', [_]);
        }
    };

    Slick.prototype.disableTransition = function (slide) {

        var _ = this,
            transition = {};

        transition[_.transitionType] = '';

        if (_.options.fade === false) {
            _.$slideTrack.css(transition);
        } else {
            _.$slides.eq(slide).css(transition);
        }
    };

    Slick.prototype.fadeSlide = function (slideIndex, callback) {

        var _ = this;

        if (_.cssTransitions === false) {

            _.$slides.eq(slideIndex).css({
                zIndex: _.options.zIndex
            });

            _.$slides.eq(slideIndex).animate({
                opacity: 1
            }, _.options.speed, _.options.easing, callback);
        } else {

            _.applyTransition(slideIndex);

            _.$slides.eq(slideIndex).css({
                opacity: 1,
                zIndex: _.options.zIndex
            });

            if (callback) {
                setTimeout(function () {

                    _.disableTransition(slideIndex);

                    callback.call();
                }, _.options.speed);
            }
        }
    };

    Slick.prototype.fadeSlideOut = function (slideIndex) {

        var _ = this;

        if (_.cssTransitions === false) {

            _.$slides.eq(slideIndex).animate({
                opacity: 0,
                zIndex: _.options.zIndex - 2
            }, _.options.speed, _.options.easing);
        } else {

            _.applyTransition(slideIndex);

            _.$slides.eq(slideIndex).css({
                opacity: 0,
                zIndex: _.options.zIndex - 2
            });
        }
    };

    Slick.prototype.filterSlides = Slick.prototype.slickFilter = function (filter) {

        var _ = this;

        if (filter !== null) {

            _.$slidesCache = _.$slides;

            _.unload();

            _.$slideTrack.children(this.options.slide).detach();

            _.$slidesCache.filter(filter).appendTo(_.$slideTrack);

            _.reinit();
        }
    };

    Slick.prototype.focusHandler = function () {

        var _ = this;

        _.$slider.off('focus.slick blur.slick').on('focus.slick blur.slick', '*', function (event) {

            event.stopImmediatePropagation();
            var $sf = $(this);

            setTimeout(function () {

                if (_.options.pauseOnFocus) {
                    _.focussed = $sf.is(':focus');
                    _.autoPlay();
                }
            }, 0);
        });
    };

    Slick.prototype.getCurrent = Slick.prototype.slickCurrentSlide = function () {

        var _ = this;
        return _.currentSlide;
    };

    Slick.prototype.getDotCount = function () {

        var _ = this;

        var breakPoint = 0;
        var counter = 0;
        var pagerQty = 0;

        if (_.options.infinite === true) {
            if (_.slideCount <= _.options.slidesToShow) {
                ++pagerQty;
            } else {
                while (breakPoint < _.slideCount) {
                    ++pagerQty;
                    breakPoint = counter + _.options.slidesToScroll;
                    counter += _.options.slidesToScroll <= _.options.slidesToShow ? _.options.slidesToScroll : _.options.slidesToShow;
                }
            }
        } else if (_.options.centerMode === true) {
            pagerQty = _.slideCount;
        } else if (!_.options.asNavFor) {
            pagerQty = 1 + Math.ceil((_.slideCount - _.options.slidesToShow) / _.options.slidesToScroll);
        } else {
            while (breakPoint < _.slideCount) {
                ++pagerQty;
                breakPoint = counter + _.options.slidesToScroll;
                counter += _.options.slidesToScroll <= _.options.slidesToShow ? _.options.slidesToScroll : _.options.slidesToShow;
            }
        }

        return pagerQty - 1;
    };

    Slick.prototype.getLeft = function (slideIndex) {

        var _ = this,
            targetLeft,
            verticalHeight,
            verticalOffset = 0,
            targetSlide,
            coef;

        _.slideOffset = 0;
        verticalHeight = _.$slides.first().outerHeight(true);

        if (_.options.infinite === true) {
            if (_.slideCount > _.options.slidesToShow) {
                _.slideOffset = _.slideWidth * _.options.slidesToShow * -1;
                coef = -1;

                if (_.options.vertical === true && _.options.centerMode === true) {
                    if (_.options.slidesToShow === 2) {
                        coef = -1.5;
                    } else if (_.options.slidesToShow === 1) {
                        coef = -2;
                    }
                }
                verticalOffset = verticalHeight * _.options.slidesToShow * coef;
            }
            if (_.slideCount % _.options.slidesToScroll !== 0) {
                if (slideIndex + _.options.slidesToScroll > _.slideCount && _.slideCount > _.options.slidesToShow) {
                    if (slideIndex > _.slideCount) {
                        _.slideOffset = (_.options.slidesToShow - (slideIndex - _.slideCount)) * _.slideWidth * -1;
                        verticalOffset = (_.options.slidesToShow - (slideIndex - _.slideCount)) * verticalHeight * -1;
                    } else {
                        _.slideOffset = _.slideCount % _.options.slidesToScroll * _.slideWidth * -1;
                        verticalOffset = _.slideCount % _.options.slidesToScroll * verticalHeight * -1;
                    }
                }
            }
        } else {
            if (slideIndex + _.options.slidesToShow > _.slideCount) {
                _.slideOffset = (slideIndex + _.options.slidesToShow - _.slideCount) * _.slideWidth;
                verticalOffset = (slideIndex + _.options.slidesToShow - _.slideCount) * verticalHeight;
            }
        }

        if (_.slideCount <= _.options.slidesToShow) {
            _.slideOffset = 0;
            verticalOffset = 0;
        }

        if (_.options.centerMode === true && _.slideCount <= _.options.slidesToShow) {
            _.slideOffset = _.slideWidth * Math.floor(_.options.slidesToShow) / 2 - _.slideWidth * _.slideCount / 2;
        } else if (_.options.centerMode === true && _.options.infinite === true) {
            _.slideOffset += _.slideWidth * Math.floor(_.options.slidesToShow / 2) - _.slideWidth;
        } else if (_.options.centerMode === true) {
            _.slideOffset = 0;
            _.slideOffset += _.slideWidth * Math.floor(_.options.slidesToShow / 2);
        }

        if (_.options.vertical === false) {
            targetLeft = slideIndex * _.slideWidth * -1 + _.slideOffset;
        } else {
            targetLeft = slideIndex * verticalHeight * -1 + verticalOffset;
        }

        if (_.options.variableWidth === true) {

            if (_.slideCount <= _.options.slidesToShow || _.options.infinite === false) {
                targetSlide = _.$slideTrack.children('.slick-slide').eq(slideIndex);
            } else {
                targetSlide = _.$slideTrack.children('.slick-slide').eq(slideIndex + _.options.slidesToShow);
            }

            if (_.options.rtl === true) {
                if (targetSlide[0]) {
                    targetLeft = (_.$slideTrack.width() - targetSlide[0].offsetLeft - targetSlide.width()) * -1;
                } else {
                    targetLeft = 0;
                }
            } else {
                targetLeft = targetSlide[0] ? targetSlide[0].offsetLeft * -1 : 0;
            }

            if (_.options.centerMode === true) {
                if (_.slideCount <= _.options.slidesToShow || _.options.infinite === false) {
                    targetSlide = _.$slideTrack.children('.slick-slide').eq(slideIndex);
                } else {
                    targetSlide = _.$slideTrack.children('.slick-slide').eq(slideIndex + _.options.slidesToShow + 1);
                }

                if (_.options.rtl === true) {
                    if (targetSlide[0]) {
                        targetLeft = (_.$slideTrack.width() - targetSlide[0].offsetLeft - targetSlide.width()) * -1;
                    } else {
                        targetLeft = 0;
                    }
                } else {
                    targetLeft = targetSlide[0] ? targetSlide[0].offsetLeft * -1 : 0;
                }

                targetLeft += (_.$list.width() - targetSlide.outerWidth()) / 2;
            }
        }

        return targetLeft;
    };

    Slick.prototype.getOption = Slick.prototype.slickGetOption = function (option) {

        var _ = this;

        return _.options[option];
    };

    Slick.prototype.getNavigableIndexes = function () {

        var _ = this,
            breakPoint = 0,
            counter = 0,
            indexes = [],
            max;

        if (_.options.infinite === false) {
            max = _.slideCount;
        } else {
            breakPoint = _.options.slidesToScroll * -1;
            counter = _.options.slidesToScroll * -1;
            max = _.slideCount * 2;
        }

        while (breakPoint < max) {
            indexes.push(breakPoint);
            breakPoint = counter + _.options.slidesToScroll;
            counter += _.options.slidesToScroll <= _.options.slidesToShow ? _.options.slidesToScroll : _.options.slidesToShow;
        }

        return indexes;
    };

    Slick.prototype.getSlick = function () {

        return this;
    };

    Slick.prototype.getSlideCount = function () {

        var _ = this,
            slidesTraversed,
            swipedSlide,
            centerOffset;

        centerOffset = _.options.centerMode === true ? _.slideWidth * Math.floor(_.options.slidesToShow / 2) : 0;

        if (_.options.swipeToSlide === true) {
            _.$slideTrack.find('.slick-slide').each(function (index, slide) {
                if (slide.offsetLeft - centerOffset + $(slide).outerWidth() / 2 > _.swipeLeft * -1) {
                    swipedSlide = slide;
                    return false;
                }
            });

            slidesTraversed = Math.abs($(swipedSlide).attr('data-slick-index') - _.currentSlide) || 1;

            return slidesTraversed;
        } else {
            return _.options.slidesToScroll;
        }
    };

    Slick.prototype.goTo = Slick.prototype.slickGoTo = function (slide, dontAnimate) {

        var _ = this;

        _.changeSlide({
            data: {
                message: 'index',
                index: parseInt(slide)
            }
        }, dontAnimate);
    };

    Slick.prototype.init = function (creation) {

        var _ = this;

        if (!$(_.$slider).hasClass('slick-initialized')) {

            $(_.$slider).addClass('slick-initialized');

            _.buildRows();
            _.buildOut();
            _.setProps();
            _.startLoad();
            _.loadSlider();
            _.initializeEvents();
            _.updateArrows();
            _.updateDots();
            _.checkResponsive(true);
            _.focusHandler();
        }

        if (creation) {
            _.$slider.trigger('init', [_]);
        }

        if (_.options.accessibility === true) {
            _.initADA();
        }

        if (_.options.autoplay) {

            _.paused = false;
            _.autoPlay();
        }
    };

    Slick.prototype.initADA = function () {
        var _ = this,
            numDotGroups = Math.ceil(_.slideCount / _.options.slidesToShow),
            tabControlIndexes = _.getNavigableIndexes().filter(function (val) {
            return val >= 0 && val < _.slideCount;
        });

        _.$slides.add(_.$slideTrack.find('.slick-cloned')).attr({
            'aria-hidden': 'true',
            'tabindex': '-1'
        }).find('a, input, button, select').attr({
            'tabindex': '-1'
        });

        if (_.$dots !== null) {
            _.$slides.not(_.$slideTrack.find('.slick-cloned')).each(function (i) {
                var slideControlIndex = tabControlIndexes.indexOf(i);

                $(this).attr({
                    'role': 'tabpanel',
                    'id': 'slick-slide' + _.instanceUid + i,
                    'tabindex': -1
                });

                if (slideControlIndex !== -1) {
                    $(this).attr({
                        'aria-describedby': 'slick-slide-control' + _.instanceUid + slideControlIndex
                    });
                }
            });

            _.$dots.attr('role', 'tablist').find('li').each(function (i) {
                var mappedSlideIndex = tabControlIndexes[i];

                $(this).attr({
                    'role': 'presentation'
                });

                $(this).find('button').first().attr({
                    'role': 'tab',
                    'id': 'slick-slide-control' + _.instanceUid + i,
                    'aria-controls': 'slick-slide' + _.instanceUid + mappedSlideIndex,
                    'aria-label': i + 1 + ' of ' + numDotGroups,
                    'aria-selected': null,
                    'tabindex': '-1'
                });
            }).eq(_.currentSlide).find('button').attr({
                'aria-selected': 'true',
                'tabindex': '0'
            }).end();
        }

        for (var i = _.currentSlide, max = i + _.options.slidesToShow; i < max; i++) {
            _.$slides.eq(i).attr('tabindex', 0);
        }

        _.activateADA();
    };

    Slick.prototype.initArrowEvents = function () {

        var _ = this;

        if (_.options.arrows === true && _.slideCount > _.options.slidesToShow) {
            _.$prevArrow.off('click.slick').on('click.slick', {
                message: 'previous'
            }, _.changeSlide);
            _.$nextArrow.off('click.slick').on('click.slick', {
                message: 'next'
            }, _.changeSlide);

            if (_.options.accessibility === true) {
                _.$prevArrow.on('keydown.slick', _.keyHandler);
                _.$nextArrow.on('keydown.slick', _.keyHandler);
            }
        }
    };

    Slick.prototype.initDotEvents = function () {

        var _ = this;

        if (_.options.dots === true) {
            $('li', _.$dots).on('click.slick', {
                message: 'index'
            }, _.changeSlide);

            if (_.options.accessibility === true) {
                _.$dots.on('keydown.slick', _.keyHandler);
            }
        }

        if (_.options.dots === true && _.options.pauseOnDotsHover === true) {

            $('li', _.$dots).on('mouseenter.slick', $.proxy(_.interrupt, _, true)).on('mouseleave.slick', $.proxy(_.interrupt, _, false));
        }
    };

    Slick.prototype.initSlideEvents = function () {

        var _ = this;

        if (_.options.pauseOnHover) {

            _.$list.on('mouseenter.slick', $.proxy(_.interrupt, _, true));
            _.$list.on('mouseleave.slick', $.proxy(_.interrupt, _, false));
        }
    };

    Slick.prototype.initializeEvents = function () {

        var _ = this;

        _.initArrowEvents();

        _.initDotEvents();
        _.initSlideEvents();

        _.$list.on('touchstart.slick mousedown.slick', {
            action: 'start'
        }, _.swipeHandler);
        _.$list.on('touchmove.slick mousemove.slick', {
            action: 'move'
        }, _.swipeHandler);
        _.$list.on('touchend.slick mouseup.slick', {
            action: 'end'
        }, _.swipeHandler);
        _.$list.on('touchcancel.slick mouseleave.slick', {
            action: 'end'
        }, _.swipeHandler);

        _.$list.on('click.slick', _.clickHandler);

        $(document).on(_.visibilityChange, $.proxy(_.visibility, _));

        if (_.options.accessibility === true) {
            _.$list.on('keydown.slick', _.keyHandler);
        }

        if (_.options.focusOnSelect === true) {
            $(_.$slideTrack).children().on('click.slick', _.selectHandler);
        }

        $(window).on('orientationchange.slick.slick-' + _.instanceUid, $.proxy(_.orientationChange, _));

        $(window).on('resize.slick.slick-' + _.instanceUid, $.proxy(_.resize, _));

        $('[draggable!=true]', _.$slideTrack).on('dragstart', _.preventDefault);

        $(window).on('load.slick.slick-' + _.instanceUid, _.setPosition);
        $(_.setPosition);
    };

    Slick.prototype.initUI = function () {

        var _ = this;

        if (_.options.arrows === true && _.slideCount > _.options.slidesToShow) {

            _.$prevArrow.show();
            _.$nextArrow.show();
        }

        if (_.options.dots === true && _.slideCount > _.options.slidesToShow) {

            _.$dots.show();
        }
    };

    Slick.prototype.keyHandler = function (event) {

        var _ = this;
        //Dont slide if the cursor is inside the form fields and arrow keys are pressed
        if (!event.target.tagName.match('TEXTAREA|INPUT|SELECT')) {
            if (event.keyCode === 37 && _.options.accessibility === true) {
                _.changeSlide({
                    data: {
                        message: _.options.rtl === true ? 'next' : 'previous'
                    }
                });
            } else if (event.keyCode === 39 && _.options.accessibility === true) {
                _.changeSlide({
                    data: {
                        message: _.options.rtl === true ? 'previous' : 'next'
                    }
                });
            }
        }
    };

    Slick.prototype.lazyLoad = function () {

        var _ = this,
            loadRange,
            cloneRange,
            rangeStart,
            rangeEnd;

        function loadImages(imagesScope) {

            $('img[data-lazy]', imagesScope).each(function () {

                var image = $(this),
                    imageSource = $(this).attr('data-lazy'),
                    imageSrcSet = $(this).attr('data-srcset'),
                    imageSizes = $(this).attr('data-sizes') || _.$slider.attr('data-sizes'),
                    imageToLoad = document.createElement('img');

                imageToLoad.onload = function () {

                    image.animate({ opacity: 0 }, 100, function () {

                        if (imageSrcSet) {
                            image.attr('srcset', imageSrcSet);

                            if (imageSizes) {
                                image.attr('sizes', imageSizes);
                            }
                        }

                        image.attr('src', imageSource).animate({ opacity: 1 }, 200, function () {
                            image.removeAttr('data-lazy data-srcset data-sizes').removeClass('slick-loading');
                        });
                        _.$slider.trigger('lazyLoaded', [_, image, imageSource]);
                    });
                };

                imageToLoad.onerror = function () {

                    image.removeAttr('data-lazy').removeClass('slick-loading').addClass('slick-lazyload-error');

                    _.$slider.trigger('lazyLoadError', [_, image, imageSource]);
                };

                imageToLoad.src = imageSource;
            });
        }

        if (_.options.centerMode === true) {
            if (_.options.infinite === true) {
                rangeStart = _.currentSlide + (_.options.slidesToShow / 2 + 1);
                rangeEnd = rangeStart + _.options.slidesToShow + 2;
            } else {
                rangeStart = Math.max(0, _.currentSlide - (_.options.slidesToShow / 2 + 1));
                rangeEnd = 2 + (_.options.slidesToShow / 2 + 1) + _.currentSlide;
            }
        } else {
            rangeStart = _.options.infinite ? _.options.slidesToShow + _.currentSlide : _.currentSlide;
            rangeEnd = Math.ceil(rangeStart + _.options.slidesToShow);
            if (_.options.fade === true) {
                if (rangeStart > 0) rangeStart--;
                if (rangeEnd <= _.slideCount) rangeEnd++;
            }
        }

        loadRange = _.$slider.find('.slick-slide').slice(rangeStart, rangeEnd);

        if (_.options.lazyLoad === 'anticipated') {
            var prevSlide = rangeStart - 1,
                nextSlide = rangeEnd,
                $slides = _.$slider.find('.slick-slide');

            for (var i = 0; i < _.options.slidesToScroll; i++) {
                if (prevSlide < 0) prevSlide = _.slideCount - 1;
                loadRange = loadRange.add($slides.eq(prevSlide));
                loadRange = loadRange.add($slides.eq(nextSlide));
                prevSlide--;
                nextSlide++;
            }
        }

        loadImages(loadRange);

        if (_.slideCount <= _.options.slidesToShow) {
            cloneRange = _.$slider.find('.slick-slide');
            loadImages(cloneRange);
        } else if (_.currentSlide >= _.slideCount - _.options.slidesToShow) {
            cloneRange = _.$slider.find('.slick-cloned').slice(0, _.options.slidesToShow);
            loadImages(cloneRange);
        } else if (_.currentSlide === 0) {
            cloneRange = _.$slider.find('.slick-cloned').slice(_.options.slidesToShow * -1);
            loadImages(cloneRange);
        }
    };

    Slick.prototype.loadSlider = function () {

        var _ = this;

        _.setPosition();

        _.$slideTrack.css({
            opacity: 1
        });

        _.$slider.removeClass('slick-loading');

        _.initUI();

        if (_.options.lazyLoad === 'progressive') {
            _.progressiveLazyLoad();
        }
    };

    Slick.prototype.next = Slick.prototype.slickNext = function () {

        var _ = this;

        _.changeSlide({
            data: {
                message: 'next'
            }
        });
    };

    Slick.prototype.orientationChange = function () {

        var _ = this;

        _.checkResponsive();
        _.setPosition();
    };

    Slick.prototype.pause = Slick.prototype.slickPause = function () {

        var _ = this;

        _.autoPlayClear();
        _.paused = true;
    };

    Slick.prototype.play = Slick.prototype.slickPlay = function () {

        var _ = this;

        _.autoPlay();
        _.options.autoplay = true;
        _.paused = false;
        _.focussed = false;
        _.interrupted = false;
    };

    Slick.prototype.postSlide = function (index) {

        var _ = this;

        if (!_.unslicked) {

            _.$slider.trigger('afterChange', [_, index]);

            _.animating = false;

            if (_.slideCount > _.options.slidesToShow) {
                _.setPosition();
            }

            _.swipeLeft = null;

            if (_.options.autoplay) {
                _.autoPlay();
            }

            if (_.options.accessibility === true) {
                _.initADA();

                if (_.options.focusOnChange) {
                    var $currentSlide = $(_.$slides.get(_.currentSlide));
                    $currentSlide.attr('tabindex', 0).focus();
                }
            }
        }
    };

    Slick.prototype.prev = Slick.prototype.slickPrev = function () {

        var _ = this;

        _.changeSlide({
            data: {
                message: 'previous'
            }
        });
    };

    Slick.prototype.preventDefault = function (event) {

        event.preventDefault();
    };

    Slick.prototype.progressiveLazyLoad = function (tryCount) {

        tryCount = tryCount || 1;

        var _ = this,
            $imgsToLoad = $('img[data-lazy]', _.$slider),
            image,
            imageSource,
            imageSrcSet,
            imageSizes,
            imageToLoad;

        if ($imgsToLoad.length) {

            image = $imgsToLoad.first();
            imageSource = image.attr('data-lazy');
            imageSrcSet = image.attr('data-srcset');
            imageSizes = image.attr('data-sizes') || _.$slider.attr('data-sizes');
            imageToLoad = document.createElement('img');

            imageToLoad.onload = function () {

                if (imageSrcSet) {
                    image.attr('srcset', imageSrcSet);

                    if (imageSizes) {
                        image.attr('sizes', imageSizes);
                    }
                }

                image.attr('src', imageSource).removeAttr('data-lazy data-srcset data-sizes').removeClass('slick-loading');

                if (_.options.adaptiveHeight === true) {
                    _.setPosition();
                }

                _.$slider.trigger('lazyLoaded', [_, image, imageSource]);
                _.progressiveLazyLoad();
            };

            imageToLoad.onerror = function () {

                if (tryCount < 3) {

                    /**
                     * try to load the image 3 times,
                     * leave a slight delay so we don't get
                     * servers blocking the request.
                     */
                    setTimeout(function () {
                        _.progressiveLazyLoad(tryCount + 1);
                    }, 500);
                } else {

                    image.removeAttr('data-lazy').removeClass('slick-loading').addClass('slick-lazyload-error');

                    _.$slider.trigger('lazyLoadError', [_, image, imageSource]);

                    _.progressiveLazyLoad();
                }
            };

            imageToLoad.src = imageSource;
        } else {

            _.$slider.trigger('allImagesLoaded', [_]);
        }
    };

    Slick.prototype.refresh = function (initializing) {

        var _ = this,
            currentSlide,
            lastVisibleIndex;

        lastVisibleIndex = _.slideCount - _.options.slidesToShow;

        // in non-infinite sliders, we don't want to go past the
        // last visible index.
        if (!_.options.infinite && _.currentSlide > lastVisibleIndex) {
            _.currentSlide = lastVisibleIndex;
        }

        // if less slides than to show, go to start.
        if (_.slideCount <= _.options.slidesToShow) {
            _.currentSlide = 0;
        }

        currentSlide = _.currentSlide;

        _.destroy(true);

        $.extend(_, _.initials, { currentSlide: currentSlide });

        _.init();

        if (!initializing) {

            _.changeSlide({
                data: {
                    message: 'index',
                    index: currentSlide
                }
            }, false);
        }
    };

    Slick.prototype.registerBreakpoints = function () {

        var _ = this,
            breakpoint,
            currentBreakpoint,
            l,
            responsiveSettings = _.options.responsive || null;

        if ($.type(responsiveSettings) === 'array' && responsiveSettings.length) {

            _.respondTo = _.options.respondTo || 'window';

            for (breakpoint in responsiveSettings) {

                l = _.breakpoints.length - 1;

                if (responsiveSettings.hasOwnProperty(breakpoint)) {
                    currentBreakpoint = responsiveSettings[breakpoint].breakpoint;

                    // loop through the breakpoints and cut out any existing
                    // ones with the same breakpoint number, we don't want dupes.
                    while (l >= 0) {
                        if (_.breakpoints[l] && _.breakpoints[l] === currentBreakpoint) {
                            _.breakpoints.splice(l, 1);
                        }
                        l--;
                    }

                    _.breakpoints.push(currentBreakpoint);
                    _.breakpointSettings[currentBreakpoint] = responsiveSettings[breakpoint].settings;
                }
            }

            _.breakpoints.sort(function (a, b) {
                return _.options.mobileFirst ? a - b : b - a;
            });
        }
    };

    Slick.prototype.reinit = function () {

        var _ = this;

        _.$slides = _.$slideTrack.children(_.options.slide).addClass('slick-slide');

        _.slideCount = _.$slides.length;

        if (_.currentSlide >= _.slideCount && _.currentSlide !== 0) {
            _.currentSlide = _.currentSlide - _.options.slidesToScroll;
        }

        if (_.slideCount <= _.options.slidesToShow) {
            _.currentSlide = 0;
        }

        _.registerBreakpoints();

        _.setProps();
        _.setupInfinite();
        _.buildArrows();
        _.updateArrows();
        _.initArrowEvents();
        _.buildDots();
        _.updateDots();
        _.initDotEvents();
        _.cleanUpSlideEvents();
        _.initSlideEvents();

        _.checkResponsive(false, true);

        if (_.options.focusOnSelect === true) {
            $(_.$slideTrack).children().on('click.slick', _.selectHandler);
        }

        _.setSlideClasses(typeof _.currentSlide === 'number' ? _.currentSlide : 0);

        _.setPosition();
        _.focusHandler();

        _.paused = !_.options.autoplay;
        _.autoPlay();

        _.$slider.trigger('reInit', [_]);
    };

    Slick.prototype.resize = function () {

        var _ = this;

        if ($(window).width() !== _.windowWidth) {
            clearTimeout(_.windowDelay);
            _.windowDelay = window.setTimeout(function () {
                _.windowWidth = $(window).width();
                _.checkResponsive();
                if (!_.unslicked) {
                    _.setPosition();
                }
            }, 50);
        }
    };

    Slick.prototype.removeSlide = Slick.prototype.slickRemove = function (index, removeBefore, removeAll) {

        var _ = this;

        if (typeof index === 'boolean') {
            removeBefore = index;
            index = removeBefore === true ? 0 : _.slideCount - 1;
        } else {
            index = removeBefore === true ? --index : index;
        }

        if (_.slideCount < 1 || index < 0 || index > _.slideCount - 1) {
            return false;
        }

        _.unload();

        if (removeAll === true) {
            _.$slideTrack.children().remove();
        } else {
            _.$slideTrack.children(this.options.slide).eq(index).remove();
        }

        _.$slides = _.$slideTrack.children(this.options.slide);

        _.$slideTrack.children(this.options.slide).detach();

        _.$slideTrack.append(_.$slides);

        _.$slidesCache = _.$slides;

        _.reinit();
    };

    Slick.prototype.setCSS = function (position) {

        var _ = this,
            positionProps = {},
            x,
            y;

        if (_.options.rtl === true) {
            position = -position;
        }
        x = _.positionProp == 'left' ? Math.ceil(position) + 'px' : '0px';
        y = _.positionProp == 'top' ? Math.ceil(position) + 'px' : '0px';

        positionProps[_.positionProp] = position;

        if (_.transformsEnabled === false) {
            _.$slideTrack.css(positionProps);
        } else {
            positionProps = {};
            if (_.cssTransitions === false) {
                positionProps[_.animType] = 'translate(' + x + ', ' + y + ')';
                _.$slideTrack.css(positionProps);
            } else {
                positionProps[_.animType] = 'translate3d(' + x + ', ' + y + ', 0px)';
                _.$slideTrack.css(positionProps);
            }
        }
    };

    Slick.prototype.setDimensions = function () {

        var _ = this;

        if (_.options.vertical === false) {
            if (_.options.centerMode === true) {
                _.$list.css({
                    padding: '0px ' + _.options.centerPadding
                });
            }
        } else {
            _.$list.height(_.$slides.first().outerHeight(true) * _.options.slidesToShow);
            if (_.options.centerMode === true) {
                _.$list.css({
                    padding: _.options.centerPadding + ' 0px'
                });
            }
        }

        _.listWidth = _.$list.width();
        _.listHeight = _.$list.height();

        if (_.options.vertical === false && _.options.variableWidth === false) {
            _.slideWidth = Math.ceil(_.listWidth / _.options.slidesToShow);
            _.$slideTrack.width(Math.ceil(_.slideWidth * _.$slideTrack.children('.slick-slide').length));
        } else if (_.options.variableWidth === true) {
            _.$slideTrack.width(5000 * _.slideCount);
        } else {
            _.slideWidth = Math.ceil(_.listWidth);
            _.$slideTrack.height(Math.ceil(_.$slides.first().outerHeight(true) * _.$slideTrack.children('.slick-slide').length));
        }

        var offset = _.$slides.first().outerWidth(true) - _.$slides.first().width();
        if (_.options.variableWidth === false) _.$slideTrack.children('.slick-slide').width(_.slideWidth - offset);
    };

    Slick.prototype.setFade = function () {

        var _ = this,
            targetLeft;

        _.$slides.each(function (index, element) {
            targetLeft = _.slideWidth * index * -1;
            if (_.options.rtl === true) {
                $(element).css({
                    position: 'relative',
                    right: targetLeft,
                    top: 0,
                    zIndex: _.options.zIndex - 2,
                    opacity: 0
                });
            } else {
                $(element).css({
                    position: 'relative',
                    left: targetLeft,
                    top: 0,
                    zIndex: _.options.zIndex - 2,
                    opacity: 0
                });
            }
        });

        _.$slides.eq(_.currentSlide).css({
            zIndex: _.options.zIndex - 1,
            opacity: 1
        });
    };

    Slick.prototype.setHeight = function () {

        var _ = this;

        if (_.options.slidesToShow === 1 && _.options.adaptiveHeight === true && _.options.vertical === false) {
            var targetHeight = _.$slides.eq(_.currentSlide).outerHeight(true);
            _.$list.css('height', targetHeight);
        }
    };

    Slick.prototype.setOption = Slick.prototype.slickSetOption = function () {

        /**
         * accepts arguments in format of:
         *
         *  - for changing a single option's value:
         *     .slick("setOption", option, value, refresh )
         *
         *  - for changing a set of responsive options:
         *     .slick("setOption", 'responsive', [{}, ...], refresh )
         *
         *  - for updating multiple values at once (not responsive)
         *     .slick("setOption", { 'option': value, ... }, refresh )
         */

        var _ = this,
            l,
            item,
            option,
            value,
            refresh = false,
            type;

        if ($.type(arguments[0]) === 'object') {

            option = arguments[0];
            refresh = arguments[1];
            type = 'multiple';
        } else if ($.type(arguments[0]) === 'string') {

            option = arguments[0];
            value = arguments[1];
            refresh = arguments[2];

            if (arguments[0] === 'responsive' && $.type(arguments[1]) === 'array') {

                type = 'responsive';
            } else if (typeof arguments[1] !== 'undefined') {

                type = 'single';
            }
        }

        if (type === 'single') {

            _.options[option] = value;
        } else if (type === 'multiple') {

            $.each(option, function (opt, val) {

                _.options[opt] = val;
            });
        } else if (type === 'responsive') {

            for (item in value) {

                if ($.type(_.options.responsive) !== 'array') {

                    _.options.responsive = [value[item]];
                } else {

                    l = _.options.responsive.length - 1;

                    // loop through the responsive object and splice out duplicates.
                    while (l >= 0) {

                        if (_.options.responsive[l].breakpoint === value[item].breakpoint) {

                            _.options.responsive.splice(l, 1);
                        }

                        l--;
                    }

                    _.options.responsive.push(value[item]);
                }
            }
        }

        if (refresh) {

            _.unload();
            _.reinit();
        }
    };

    Slick.prototype.setPosition = function () {

        var _ = this;

        _.setDimensions();

        _.setHeight();

        if (_.options.fade === false) {
            _.setCSS(_.getLeft(_.currentSlide));
        } else {
            _.setFade();
        }

        _.$slider.trigger('setPosition', [_]);
    };

    Slick.prototype.setProps = function () {

        var _ = this,
            bodyStyle = document.body.style;

        _.positionProp = _.options.vertical === true ? 'top' : 'left';

        if (_.positionProp === 'top') {
            _.$slider.addClass('slick-vertical');
        } else {
            _.$slider.removeClass('slick-vertical');
        }

        if (bodyStyle.WebkitTransition !== undefined || bodyStyle.MozTransition !== undefined || bodyStyle.msTransition !== undefined) {
            if (_.options.useCSS === true) {
                _.cssTransitions = true;
            }
        }

        if (_.options.fade) {
            if (typeof _.options.zIndex === 'number') {
                if (_.options.zIndex < 3) {
                    _.options.zIndex = 3;
                }
            } else {
                _.options.zIndex = _.defaults.zIndex;
            }
        }

        if (bodyStyle.OTransform !== undefined) {
            _.animType = 'OTransform';
            _.transformType = '-o-transform';
            _.transitionType = 'OTransition';
            if (bodyStyle.perspectiveProperty === undefined && bodyStyle.webkitPerspective === undefined) _.animType = false;
        }
        if (bodyStyle.MozTransform !== undefined) {
            _.animType = 'MozTransform';
            _.transformType = '-moz-transform';
            _.transitionType = 'MozTransition';
            if (bodyStyle.perspectiveProperty === undefined && bodyStyle.MozPerspective === undefined) _.animType = false;
        }
        if (bodyStyle.webkitTransform !== undefined) {
            _.animType = 'webkitTransform';
            _.transformType = '-webkit-transform';
            _.transitionType = 'webkitTransition';
            if (bodyStyle.perspectiveProperty === undefined && bodyStyle.webkitPerspective === undefined) _.animType = false;
        }
        if (bodyStyle.msTransform !== undefined) {
            _.animType = 'msTransform';
            _.transformType = '-ms-transform';
            _.transitionType = 'msTransition';
            if (bodyStyle.msTransform === undefined) _.animType = false;
        }
        if (bodyStyle.transform !== undefined && _.animType !== false) {
            _.animType = 'transform';
            _.transformType = 'transform';
            _.transitionType = 'transition';
        }
        _.transformsEnabled = _.options.useTransform && _.animType !== null && _.animType !== false;
    };

    Slick.prototype.setSlideClasses = function (index) {

        var _ = this,
            centerOffset,
            allSlides,
            indexOffset,
            remainder;

        allSlides = _.$slider.find('.slick-slide').removeClass('slick-active slick-center slick-current').attr('aria-hidden', 'true');

        _.$slides.eq(index).addClass('slick-current');

        if (_.options.centerMode === true) {

            var evenCoef = _.options.slidesToShow % 2 === 0 ? 1 : 0;

            centerOffset = Math.floor(_.options.slidesToShow / 2);

            if (_.options.infinite === true) {

                if (index >= centerOffset && index <= _.slideCount - 1 - centerOffset) {
                    _.$slides.slice(index - centerOffset + evenCoef, index + centerOffset + 1).addClass('slick-active').attr('aria-hidden', 'false');
                } else {

                    indexOffset = _.options.slidesToShow + index;
                    allSlides.slice(indexOffset - centerOffset + 1 + evenCoef, indexOffset + centerOffset + 2).addClass('slick-active').attr('aria-hidden', 'false');
                }

                if (index === 0) {

                    allSlides.eq(allSlides.length - 1 - _.options.slidesToShow).addClass('slick-center');
                } else if (index === _.slideCount - 1) {

                    allSlides.eq(_.options.slidesToShow).addClass('slick-center');
                }
            }

            _.$slides.eq(index).addClass('slick-center');
        } else {

            if (index >= 0 && index <= _.slideCount - _.options.slidesToShow) {

                _.$slides.slice(index, index + _.options.slidesToShow).addClass('slick-active').attr('aria-hidden', 'false');
            } else if (allSlides.length <= _.options.slidesToShow) {

                allSlides.addClass('slick-active').attr('aria-hidden', 'false');
            } else {

                remainder = _.slideCount % _.options.slidesToShow;
                indexOffset = _.options.infinite === true ? _.options.slidesToShow + index : index;

                if (_.options.slidesToShow == _.options.slidesToScroll && _.slideCount - index < _.options.slidesToShow) {

                    allSlides.slice(indexOffset - (_.options.slidesToShow - remainder), indexOffset + remainder).addClass('slick-active').attr('aria-hidden', 'false');
                } else {

                    allSlides.slice(indexOffset, indexOffset + _.options.slidesToShow).addClass('slick-active').attr('aria-hidden', 'false');
                }
            }
        }

        if (_.options.lazyLoad === 'ondemand' || _.options.lazyLoad === 'anticipated') {
            _.lazyLoad();
        }
    };

    Slick.prototype.setupInfinite = function () {

        var _ = this,
            i,
            slideIndex,
            infiniteCount;

        if (_.options.fade === true) {
            _.options.centerMode = false;
        }

        if (_.options.infinite === true && _.options.fade === false) {

            slideIndex = null;

            if (_.slideCount > _.options.slidesToShow) {

                if (_.options.centerMode === true) {
                    infiniteCount = _.options.slidesToShow + 1;
                } else {
                    infiniteCount = _.options.slidesToShow;
                }

                for (i = _.slideCount; i > _.slideCount - infiniteCount; i -= 1) {
                    slideIndex = i - 1;
                    $(_.$slides[slideIndex]).clone(true).attr('id', '').attr('data-slick-index', slideIndex - _.slideCount).prependTo(_.$slideTrack).addClass('slick-cloned');
                }
                for (i = 0; i < infiniteCount + _.slideCount; i += 1) {
                    slideIndex = i;
                    $(_.$slides[slideIndex]).clone(true).attr('id', '').attr('data-slick-index', slideIndex + _.slideCount).appendTo(_.$slideTrack).addClass('slick-cloned');
                }
                _.$slideTrack.find('.slick-cloned').find('[id]').each(function () {
                    $(this).attr('id', '');
                });
            }
        }
    };

    Slick.prototype.interrupt = function (toggle) {

        var _ = this;

        if (!toggle) {
            _.autoPlay();
        }
        _.interrupted = toggle;
    };

    Slick.prototype.selectHandler = function (event) {

        var _ = this;

        var targetElement = $(event.target).is('.slick-slide') ? $(event.target) : $(event.target).parents('.slick-slide');

        var index = parseInt(targetElement.attr('data-slick-index'));

        if (!index) index = 0;

        if (_.slideCount <= _.options.slidesToShow) {

            _.slideHandler(index, false, true);
            return;
        }

        _.slideHandler(index);
    };

    Slick.prototype.slideHandler = function (index, sync, dontAnimate) {

        var targetSlide,
            animSlide,
            oldSlide,
            slideLeft,
            targetLeft = null,
            _ = this,
            navTarget;

        sync = sync || false;

        if (_.animating === true && _.options.waitForAnimate === true) {
            return;
        }

        if (_.options.fade === true && _.currentSlide === index) {
            return;
        }

        if (sync === false) {
            _.asNavFor(index);
        }

        targetSlide = index;
        targetLeft = _.getLeft(targetSlide);
        slideLeft = _.getLeft(_.currentSlide);

        _.currentLeft = _.swipeLeft === null ? slideLeft : _.swipeLeft;

        if (_.options.infinite === false && _.options.centerMode === false && (index < 0 || index > _.getDotCount() * _.options.slidesToScroll)) {
            if (_.options.fade === false) {
                targetSlide = _.currentSlide;
                if (dontAnimate !== true) {
                    _.animateSlide(slideLeft, function () {
                        _.postSlide(targetSlide);
                    });
                } else {
                    _.postSlide(targetSlide);
                }
            }
            return;
        } else if (_.options.infinite === false && _.options.centerMode === true && (index < 0 || index > _.slideCount - _.options.slidesToScroll)) {
            if (_.options.fade === false) {
                targetSlide = _.currentSlide;
                if (dontAnimate !== true) {
                    _.animateSlide(slideLeft, function () {
                        _.postSlide(targetSlide);
                    });
                } else {
                    _.postSlide(targetSlide);
                }
            }
            return;
        }

        if (_.options.autoplay) {
            clearInterval(_.autoPlayTimer);
        }

        if (targetSlide < 0) {
            if (_.slideCount % _.options.slidesToScroll !== 0) {
                animSlide = _.slideCount - _.slideCount % _.options.slidesToScroll;
            } else {
                animSlide = _.slideCount + targetSlide;
            }
        } else if (targetSlide >= _.slideCount) {
            if (_.slideCount % _.options.slidesToScroll !== 0) {
                animSlide = 0;
            } else {
                animSlide = targetSlide - _.slideCount;
            }
        } else {
            animSlide = targetSlide;
        }

        _.animating = true;

        _.$slider.trigger('beforeChange', [_, _.currentSlide, animSlide]);

        oldSlide = _.currentSlide;
        _.currentSlide = animSlide;

        _.setSlideClasses(_.currentSlide);

        if (_.options.asNavFor) {

            navTarget = _.getNavTarget();
            navTarget = navTarget.slick('getSlick');

            if (navTarget.slideCount <= navTarget.options.slidesToShow) {
                navTarget.setSlideClasses(_.currentSlide);
            }
        }

        _.updateDots();
        _.updateArrows();

        if (_.options.fade === true) {
            if (dontAnimate !== true) {

                _.fadeSlideOut(oldSlide);

                _.fadeSlide(animSlide, function () {
                    _.postSlide(animSlide);
                });
            } else {
                _.postSlide(animSlide);
            }
            _.animateHeight();
            return;
        }

        if (dontAnimate !== true) {
            _.animateSlide(targetLeft, function () {
                _.postSlide(animSlide);
            });
        } else {
            _.postSlide(animSlide);
        }
    };

    Slick.prototype.startLoad = function () {

        var _ = this;

        if (_.options.arrows === true && _.slideCount > _.options.slidesToShow) {

            _.$prevArrow.hide();
            _.$nextArrow.hide();
        }

        if (_.options.dots === true && _.slideCount > _.options.slidesToShow) {

            _.$dots.hide();
        }

        _.$slider.addClass('slick-loading');
    };

    Slick.prototype.swipeDirection = function () {

        var xDist,
            yDist,
            r,
            swipeAngle,
            _ = this;

        xDist = _.touchObject.startX - _.touchObject.curX;
        yDist = _.touchObject.startY - _.touchObject.curY;
        r = Math.atan2(yDist, xDist);

        swipeAngle = Math.round(r * 180 / Math.PI);
        if (swipeAngle < 0) {
            swipeAngle = 360 - Math.abs(swipeAngle);
        }

        if (swipeAngle <= 45 && swipeAngle >= 0) {
            return _.options.rtl === false ? 'left' : 'right';
        }
        if (swipeAngle <= 360 && swipeAngle >= 315) {
            return _.options.rtl === false ? 'left' : 'right';
        }
        if (swipeAngle >= 135 && swipeAngle <= 225) {
            return _.options.rtl === false ? 'right' : 'left';
        }
        if (_.options.verticalSwiping === true) {
            if (swipeAngle >= 35 && swipeAngle <= 135) {
                return 'down';
            } else {
                return 'up';
            }
        }

        return 'vertical';
    };

    Slick.prototype.swipeEnd = function (event) {

        var _ = this,
            slideCount,
            direction;

        _.dragging = false;
        _.swiping = false;

        if (_.scrolling) {
            _.scrolling = false;
            return false;
        }

        _.interrupted = false;
        _.shouldClick = _.touchObject.swipeLength > 10 ? false : true;

        if (_.touchObject.curX === undefined) {
            return false;
        }

        if (_.touchObject.edgeHit === true) {
            _.$slider.trigger('edge', [_, _.swipeDirection()]);
        }

        if (_.touchObject.swipeLength >= _.touchObject.minSwipe) {

            direction = _.swipeDirection();

            switch (direction) {

                case 'left':
                case 'down':

                    slideCount = _.options.swipeToSlide ? _.checkNavigable(_.currentSlide + _.getSlideCount()) : _.currentSlide + _.getSlideCount();

                    _.currentDirection = 0;

                    break;

                case 'right':
                case 'up':

                    slideCount = _.options.swipeToSlide ? _.checkNavigable(_.currentSlide - _.getSlideCount()) : _.currentSlide - _.getSlideCount();

                    _.currentDirection = 1;

                    break;

                default:

            }

            if (direction != 'vertical') {

                _.slideHandler(slideCount);
                _.touchObject = {};
                _.$slider.trigger('swipe', [_, direction]);
            }
        } else {

            if (_.touchObject.startX !== _.touchObject.curX) {

                _.slideHandler(_.currentSlide);
                _.touchObject = {};
            }
        }
    };

    Slick.prototype.swipeHandler = function (event) {

        var _ = this;

        if (_.options.swipe === false || 'ontouchend' in document && _.options.swipe === false) {
            return;
        } else if (_.options.draggable === false && event.type.indexOf('mouse') !== -1) {
            return;
        }

        _.touchObject.fingerCount = event.originalEvent && event.originalEvent.touches !== undefined ? event.originalEvent.touches.length : 1;

        _.touchObject.minSwipe = _.listWidth / _.options.touchThreshold;

        if (_.options.verticalSwiping === true) {
            _.touchObject.minSwipe = _.listHeight / _.options.touchThreshold;
        }

        switch (event.data.action) {

            case 'start':
                _.swipeStart(event);
                break;

            case 'move':
                _.swipeMove(event);
                break;

            case 'end':
                _.swipeEnd(event);
                break;

        }
    };

    Slick.prototype.swipeMove = function (event) {

        var _ = this,
            edgeWasHit = false,
            curLeft,
            swipeDirection,
            swipeLength,
            positionOffset,
            touches,
            verticalSwipeLength;

        touches = event.originalEvent !== undefined ? event.originalEvent.touches : null;

        if (!_.dragging || _.scrolling || touches && touches.length !== 1) {
            return false;
        }

        curLeft = _.getLeft(_.currentSlide);

        _.touchObject.curX = touches !== undefined ? touches[0].pageX : event.clientX;
        _.touchObject.curY = touches !== undefined ? touches[0].pageY : event.clientY;

        _.touchObject.swipeLength = Math.round(Math.sqrt(Math.pow(_.touchObject.curX - _.touchObject.startX, 2)));

        verticalSwipeLength = Math.round(Math.sqrt(Math.pow(_.touchObject.curY - _.touchObject.startY, 2)));

        if (!_.options.verticalSwiping && !_.swiping && verticalSwipeLength > 4) {
            _.scrolling = true;
            return false;
        }

        if (_.options.verticalSwiping === true) {
            _.touchObject.swipeLength = verticalSwipeLength;
        }

        swipeDirection = _.swipeDirection();

        if (event.originalEvent !== undefined && _.touchObject.swipeLength > 4) {
            _.swiping = true;
            event.preventDefault();
        }

        positionOffset = (_.options.rtl === false ? 1 : -1) * (_.touchObject.curX > _.touchObject.startX ? 1 : -1);
        if (_.options.verticalSwiping === true) {
            positionOffset = _.touchObject.curY > _.touchObject.startY ? 1 : -1;
        }

        swipeLength = _.touchObject.swipeLength;

        _.touchObject.edgeHit = false;

        if (_.options.infinite === false) {
            if (_.currentSlide === 0 && swipeDirection === 'right' || _.currentSlide >= _.getDotCount() && swipeDirection === 'left') {
                swipeLength = _.touchObject.swipeLength * _.options.edgeFriction;
                _.touchObject.edgeHit = true;
            }
        }

        if (_.options.vertical === false) {
            _.swipeLeft = curLeft + swipeLength * positionOffset;
        } else {
            _.swipeLeft = curLeft + swipeLength * (_.$list.height() / _.listWidth) * positionOffset;
        }
        if (_.options.verticalSwiping === true) {
            _.swipeLeft = curLeft + swipeLength * positionOffset;
        }

        if (_.options.fade === true || _.options.touchMove === false) {
            return false;
        }

        if (_.animating === true) {
            _.swipeLeft = null;
            return false;
        }

        _.setCSS(_.swipeLeft);
    };

    Slick.prototype.swipeStart = function (event) {

        var _ = this,
            touches;

        _.interrupted = true;

        if (_.touchObject.fingerCount !== 1 || _.slideCount <= _.options.slidesToShow) {
            _.touchObject = {};
            return false;
        }

        if (event.originalEvent !== undefined && event.originalEvent.touches !== undefined) {
            touches = event.originalEvent.touches[0];
        }

        _.touchObject.startX = _.touchObject.curX = touches !== undefined ? touches.pageX : event.clientX;
        _.touchObject.startY = _.touchObject.curY = touches !== undefined ? touches.pageY : event.clientY;

        _.dragging = true;
    };

    Slick.prototype.unfilterSlides = Slick.prototype.slickUnfilter = function () {

        var _ = this;

        if (_.$slidesCache !== null) {

            _.unload();

            _.$slideTrack.children(this.options.slide).detach();

            _.$slidesCache.appendTo(_.$slideTrack);

            _.reinit();
        }
    };

    Slick.prototype.unload = function () {

        var _ = this;

        $('.slick-cloned', _.$slider).remove();

        if (_.$dots) {
            _.$dots.remove();
        }

        if (_.$prevArrow && _.htmlExpr.test(_.options.prevArrow)) {
            _.$prevArrow.remove();
        }

        if (_.$nextArrow && _.htmlExpr.test(_.options.nextArrow)) {
            _.$nextArrow.remove();
        }

        _.$slides.removeClass('slick-slide slick-active slick-visible slick-current').attr('aria-hidden', 'true').css('width', '');
    };

    Slick.prototype.unslick = function (fromBreakpoint) {

        var _ = this;
        _.$slider.trigger('unslick', [_, fromBreakpoint]);
        _.destroy();
    };

    Slick.prototype.updateArrows = function () {

        var _ = this,
            centerOffset;

        centerOffset = Math.floor(_.options.slidesToShow / 2);

        if (_.options.arrows === true && _.slideCount > _.options.slidesToShow && !_.options.infinite) {

            _.$prevArrow.removeClass('slick-disabled').attr('aria-disabled', 'false');
            _.$nextArrow.removeClass('slick-disabled').attr('aria-disabled', 'false');

            if (_.currentSlide === 0) {

                _.$prevArrow.addClass('slick-disabled').attr('aria-disabled', 'true');
                _.$nextArrow.removeClass('slick-disabled').attr('aria-disabled', 'false');
            } else if (_.currentSlide >= _.slideCount - _.options.slidesToShow && _.options.centerMode === false) {

                _.$nextArrow.addClass('slick-disabled').attr('aria-disabled', 'true');
                _.$prevArrow.removeClass('slick-disabled').attr('aria-disabled', 'false');
            } else if (_.currentSlide >= _.slideCount - 1 && _.options.centerMode === true) {

                _.$nextArrow.addClass('slick-disabled').attr('aria-disabled', 'true');
                _.$prevArrow.removeClass('slick-disabled').attr('aria-disabled', 'false');
            }
        }
    };

    Slick.prototype.updateDots = function () {

        var _ = this;

        if (_.$dots !== null) {

            _.$dots.find('li').removeClass('slick-active').end();

            _.$dots.find('li').eq(Math.floor(_.currentSlide / _.options.slidesToScroll)).addClass('slick-active');
        }
    };

    Slick.prototype.visibility = function () {

        var _ = this;

        if (_.options.autoplay) {

            if (document[_.hidden]) {

                _.interrupted = true;
            } else {

                _.interrupted = false;
            }
        }
    };

    $.fn.slick = function () {
        var _ = this,
            opt = arguments[0],
            args = Array.prototype.slice.call(arguments, 1),
            l = _.length,
            i,
            ret;
        for (i = 0; i < l; i++) {
            if (typeof opt == 'object' || typeof opt == 'undefined') _[i].slick = new Slick(_[i], opt);else ret = _[i].slick[opt].apply(_[i].slick, args);
            if (typeof ret != 'undefined') return ret;
        }
        return _;
    };
});

/***/ }),
/* 15 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/**
 * 2007-2020 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */


Object.defineProperty(exports, '__esModule', {
  value: true
});

var _createClass = (function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ('value' in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; })();

var _get = function get(_x, _x2, _x3) { var _again = true; _function: while (_again) { var object = _x, property = _x2, receiver = _x3; _again = false; if (object === null) object = Function.prototype; var desc = Object.getOwnPropertyDescriptor(object, property); if (desc === undefined) { var parent = Object.getPrototypeOf(object); if (parent === null) { return undefined; } else { _x = parent; _x2 = property; _x3 = receiver; _again = true; desc = parent = undefined; continue _function; } } else if ('value' in desc) { return desc.value; } else { var getter = desc.get; if (getter === undefined) { return undefined; } return getter.call(receiver); } } };

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { 'default': obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError('Cannot call a class as a function'); } }

function _inherits(subClass, superClass) { if (typeof superClass !== 'function' && superClass !== null) { throw new TypeError('Super expression must either be null or a function, not ' + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var _jquery = __webpack_require__(0);

var _jquery2 = _interopRequireDefault(_jquery);

var _dropDown = __webpack_require__(2);

var _dropDown2 = _interopRequireDefault(_dropDown);

var TopMenu = (function (_DropDown) {
  _inherits(TopMenu, _DropDown);

  function TopMenu() {
    _classCallCheck(this, TopMenu);

    _get(Object.getPrototypeOf(TopMenu.prototype), 'constructor', this).apply(this, arguments);
  }

  _createClass(TopMenu, [{
    key: 'init',
    value: function init() {
      var _this = this;

      var elmId = undefined;
      var self = this;
      this.el.find('li').hover(function (e) {
        if (_this.el.parent().hasClass('mobile')) {
          return;
        }
      });

      /* add custom script */
      (0, _jquery2['default'])('.sub-menu').mouseenter(function () {
        var prevParent = (0, _jquery2['default'])(this).prev().parent();
        prevParent.addClass("sfHover");
      });

      (0, _jquery2['default'])('.sub-menu').mouseleave(function () {
        var prevParent = (0, _jquery2['default'])(this).prev().parent();
        prevParent.removeClass("sfHover");
      });
      /* and custom script */

      (0, _jquery2['default'])('.js-top-menu .category').mouseleave(function () {
        if (_this.el.parent().hasClass('mobile')) {
          return;
        }
      });

      this.el.on('click', function (e) {
        if (_this.el.parent().hasClass('mobile')) {
          return;
        }
        e.stopPropagation();
      });
      prestashop.on('responsive update', function (event) {
        (0, _jquery2['default'])('.js-sub-menu').removeAttr('style');
      });
      _get(Object.getPrototypeOf(TopMenu.prototype), 'init', this).call(this);
    }
  }]);

  return TopMenu;
})(_dropDown2['default']);

exports['default'] = TopMenu;
module.exports = exports['default'];

/***/ }),
/* 16 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/**
 * 2007-2020 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */


function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { 'default': obj }; }

var _jquery = __webpack_require__(0);

var _jquery2 = _interopRequireDefault(_jquery);

function initRmaItemSelector() {
  (0, _jquery2['default'])('#order-return-form table thead input[type=checkbox]').on('click', function () {
    var checked = (0, _jquery2['default'])(this).prop('checked');
    (0, _jquery2['default'])('#order-return-form table tbody input[type=checkbox]').each(function (_, checkbox) {
      (0, _jquery2['default'])(checkbox).prop('checked', checked);
    });
  });
}

function setupCustomerScripts() {
  if ((0, _jquery2['default'])('body#order-detail')) {
    initRmaItemSelector();
  }
}

(0, _jquery2['default'])(document).ready(setupCustomerScripts);

/***/ }),
/* 17 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/**
 * 2007-2020 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */


(function ($) {
  var nextId = 0;var Filestyle = function Filestyle(element, options) {
    this.options = options;this.$elementFilestyle = [];this.$element = $(element);
  };Filestyle.prototype = { clear: function clear() {
      this.$element.val("");this.$elementFilestyle.find(":text").val("");this.$elementFilestyle.find(".badge").remove();
    }, destroy: function destroy() {
      this.$element.removeAttr("style").removeData("filestyle");this.$elementFilestyle.remove();
    }, disabled: function disabled(value) {
      if (value === true) {
        if (!this.options.disabled) {
          this.$element.attr("disabled", "true");this.$elementFilestyle.find("label").attr("disabled", "true");this.options.disabled = true;
        }
      } else {
        if (value === false) {
          if (this.options.disabled) {
            this.$element.removeAttr("disabled");this.$elementFilestyle.find("label").removeAttr("disabled");this.options.disabled = false;
          }
        } else {
          return this.options.disabled;
        }
      }
    }, buttonBefore: function buttonBefore(value) {
      if (value === true) {
        if (!this.options.buttonBefore) {
          this.options.buttonBefore = true;if (this.options.input) {
            this.$elementFilestyle.remove();this.constructor();this.pushNameFiles();
          }
        }
      } else {
        if (value === false) {
          if (this.options.buttonBefore) {
            this.options.buttonBefore = false;if (this.options.input) {
              this.$elementFilestyle.remove();this.constructor();this.pushNameFiles();
            }
          }
        } else {
          return this.options.buttonBefore;
        }
      }
    }, icon: function icon(value) {
      if (value === true) {
        if (!this.options.icon) {
          this.options.icon = true;this.$elementFilestyle.find("label").prepend(this.htmlIcon());
        }
      } else {
        if (value === false) {
          if (this.options.icon) {
            this.options.icon = false;this.$elementFilestyle.find(".icon-span-filestyle").remove();
          }
        } else {
          return this.options.icon;
        }
      }
    }, input: function input(value) {
      if (value === true) {
        if (!this.options.input) {
          this.options.input = true;if (this.options.buttonBefore) {
            this.$elementFilestyle.append(this.htmlInput());
          } else {
            this.$elementFilestyle.prepend(this.htmlInput());
          }this.$elementFilestyle.find(".badge").remove();this.pushNameFiles();this.$elementFilestyle.find(".group-span-filestyle").addClass("input-group-btn");
        }
      } else {
        if (value === false) {
          if (this.options.input) {
            this.options.input = false;this.$elementFilestyle.find(":text").remove();var files = this.pushNameFiles();if (files.length > 0 && this.options.badge) {
              this.$elementFilestyle.find("label").append(' <span class="badge">' + files.length + "</span>");
            }this.$elementFilestyle.find(".group-span-filestyle").removeClass("input-group-btn");
          }
        } else {
          return this.options.input;
        }
      }
    }, size: function size(value) {
      if (value !== undefined) {
        var btn = this.$elementFilestyle.find("label"),
            input = this.$elementFilestyle.find("input");btn.removeClass("btn-lg btn-sm");input.removeClass("input-lg input-sm");if (value != "nr") {
          btn.addClass("btn-" + value);input.addClass("input-" + value);
        }
      } else {
        return this.options.size;
      }
    }, placeholder: function placeholder(value) {
      if (value !== undefined) {
        this.options.placeholder = value;this.$elementFilestyle.find("input").attr("placeholder", value);
      } else {
        return this.options.placeholder;
      }
    }, buttonText: function buttonText(value) {
      if (value !== undefined) {
        this.options.buttonText = value;this.$elementFilestyle.find("label .buttonText").html(this.options.buttonText);
      } else {
        return this.options.buttonText;
      }
    }, buttonName: function buttonName(value) {
      if (value !== undefined) {
        this.options.buttonName = value;this.$elementFilestyle.find("label").attr({ "class": "btn " + this.options.buttonName });
      } else {
        return this.options.buttonName;
      }
    }, iconName: function iconName(value) {
      if (value !== undefined) {
        this.$elementFilestyle.find(".icon-span-filestyle").attr({ "class": "icon-span-filestyle " + this.options.iconName });
      } else {
        return this.options.iconName;
      }
    }, htmlIcon: function htmlIcon() {
      if (this.options.icon) {
        return '<span class="icon-span-filestyle ' + this.options.iconName + '"></span> ';
      } else {
        return "";
      }
    }, htmlInput: function htmlInput() {
      if (this.options.input) {
        return '<input type="text" class="form-control ' + (this.options.size == "nr" ? "" : "input-" + this.options.size) + '" placeholder="' + this.options.placeholder + '" disabled> ';
      } else {
        return "";
      }
    }, pushNameFiles: function pushNameFiles() {
      var content = "",
          files = [];if (this.$element[0].files === undefined) {
        files[0] = { name: this.$element[0] && this.$element[0].value };
      } else {
        files = this.$element[0].files;
      }for (var i = 0; i < files.length; i++) {
        content += files[i].name.split("\\").pop() + ", ";
      }if (content !== "") {
        this.$elementFilestyle.find(":text").val(content.replace(/\, $/g, ""));
      } else {
        this.$elementFilestyle.find(":text").val("");
      }return files;
    }, constructor: function constructor() {
      var _self = this,
          html = "",
          id = _self.$element.attr("id"),
          files = [],
          btn = "",
          $label;if (id === "" || !id) {
        id = "filestyle-" + nextId;_self.$element.attr({ id: id });nextId++;
      }btn = '<span class="group-span-filestyle ' + (_self.options.input ? "input-group-btn" : "") + '"><label for="' + id + '" class="btn ' + _self.options.buttonName + " " + (_self.options.size == "nr" ? "" : "btn-" + _self.options.size) + '" ' + (_self.options.disabled ? 'disabled="true"' : "") + ">" + _self.htmlIcon() + '<span class="buttonText">' + _self.options.buttonText + "</span></label></span>";html = _self.options.buttonBefore ? btn + _self.htmlInput() : _self.htmlInput() + btn;_self.$elementFilestyle = $('<div class="bootstrap-filestyle input-group">' + html + "</div>");_self.$elementFilestyle.find(".group-span-filestyle").attr("tabindex", "0").keypress(function (e) {
        if (e.keyCode === 13 || e.charCode === 32) {
          _self.$elementFilestyle.find("label").click();return false;
        }
      });_self.$element.css({ position: "absolute", clip: "rect(0px 0px 0px 0px)" }).attr("tabindex", "-1").after(_self.$elementFilestyle);if (_self.options.disabled) {
        _self.$element.attr("disabled", "true");
      }_self.$element.change(function () {
        var files = _self.pushNameFiles();if (_self.options.input == false && _self.options.badge) {
          if (_self.$elementFilestyle.find(".badge").length == 0) {
            _self.$elementFilestyle.find("label").append(' <span class="badge">' + files.length + "</span>");
          } else {
            if (files.length == 0) {
              _self.$elementFilestyle.find(".badge").remove();
            } else {
              _self.$elementFilestyle.find(".badge").html(files.length);
            }
          }
        } else {
          _self.$elementFilestyle.find(".badge").remove();
        }
      });if (window.navigator.userAgent.search(/firefox/i) > -1) {
        _self.$elementFilestyle.find("label").click(function () {
          _self.$element.click();return false;
        });
      }
    } };var old = $.fn.filestyle;$.fn.filestyle = function (option, value) {
    var get = "",
        element = this.each(function () {
      if ($(this).attr("type") === "file") {
        var $this = $(this),
            data = $this.data("filestyle"),
            options = $.extend({}, $.fn.filestyle.defaults, option, typeof option === "object" && option);if (!data) {
          $this.data("filestyle", data = new Filestyle(this, options));data.constructor();
        }if (typeof option === "string") {
          get = data[option](value);
        }
      }
    });if (typeof get !== undefined) {
      return get;
    } else {
      return element;
    }
  };$.fn.filestyle.defaults = { buttonText: "Choose file", iconName: "glyphicon glyphicon-folder-open", buttonName: "btn-default", size: "nr", input: true, badge: true, icon: true, buttonBefore: false, disabled: false, placeholder: "" };$.fn.filestyle.noConflict = function () {
    $.fn.filestyle = old;return this;
  };$(function () {
    $(".filestyle").each(function () {
      var $this = $(this),
          options = { input: $this.attr("data-input") === "false" ? false : true, icon: $this.attr("data-icon") === "false" ? false : true, buttonBefore: $this.attr("data-buttonBefore") === "true" ? true : false, disabled: $this.attr("data-disabled") === "true" ? true : false, size: $this.attr("data-size"), buttonText: $this.attr("data-buttonText"), buttonName: $this.attr("data-buttonName"), iconName: $this.attr("data-iconName"), badge: $this.attr("data-badge") === "false" ? false : true, placeholder: $this.attr("data-placeholder") };$this.filestyle(options);
    });
  });
})(window.jQuery);

/***/ }),
/* 18 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/**
 * 2007-2020 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */


(function ($) {
  $.fn.scrollbox = function (config) {
    var defConfig = { linear: false, startDelay: 2, delay: 3, step: 5, speed: 32, switchItems: 1, direction: "vertical", distance: "auto", autoPlay: true, onMouseOverPause: true, paused: false, queue: null, listElement: "ul", listItemElement: "li", infiniteLoop: true, switchAmount: 0, afterForward: null, afterBackward: null, triggerStackable: false };config = $.extend(defConfig, config);config.scrollOffset = config.direction === "vertical" ? "scrollTop" : "scrollLeft";if (config.queue) {
      config.queue = $("#" + config.queue);
    }return this.each(function () {
      var container = $(this),
          containerUL,
          scrollingId = null,
          nextScrollId = null,
          paused = false,
          releaseStack,
          backward,
          forward,
          resetClock,
          scrollForward,
          scrollBackward,
          forwardHover,
          pauseHover,
          switchCount = 0,
          stackedTriggerIndex = 0;if (config.onMouseOverPause) {
        container.bind("mouseover", function () {
          paused = true;
        });container.bind("mouseout", function () {
          paused = false;
        });
      }containerUL = container.children(config.listElement + ":first-child");if (config.infiniteLoop === false && config.switchAmount === 0) {
        config.switchAmount = containerUL.children().length;
      }scrollForward = function () {
        if (paused) {
          return;
        }var curLi, i, newScrollOffset, scrollDistance, theStep;curLi = containerUL.children(config.listItemElement + ":first-child");scrollDistance = config.distance !== "auto" ? config.distance : config.direction === "vertical" ? curLi.outerHeight(true) : curLi.outerWidth(true);if (!config.linear) {
          theStep = Math.max(3, parseInt((scrollDistance - container[0][config.scrollOffset]) * .3, 10));newScrollOffset = Math.min(container[0][config.scrollOffset] + theStep, scrollDistance);
        } else {
          newScrollOffset = Math.min(container[0][config.scrollOffset] + config.step, scrollDistance);
        }container[0][config.scrollOffset] = newScrollOffset;if (newScrollOffset >= scrollDistance) {
          for (i = 0; i < config.switchItems; i++) {
            if (config.queue && config.queue.find(config.listItemElement).length > 0) {
              containerUL.append(config.queue.find(config.listItemElement)[0]);containerUL.children(config.listItemElement + ":first-child").remove();
            } else {
              containerUL.append(containerUL.children(config.listItemElement + ":first-child"));
            }++switchCount;
          }container[0][config.scrollOffset] = 0;clearInterval(scrollingId);scrollingId = null;if ($.isFunction(config.afterForward)) {
            config.afterForward.call(container, { switchCount: switchCount, currentFirstChild: containerUL.children(config.listItemElement + ":first-child") });
          }if (config.triggerStackable && stackedTriggerIndex !== 0) {
            releaseStack();return;
          }if (config.infiniteLoop === false && switchCount >= config.switchAmount) {
            return;
          }if (config.autoPlay) {
            nextScrollId = setTimeout(forward, config.delay * 1e3);
          }
        }
      };scrollBackward = function () {
        if (paused) {
          return;
        }var curLi, i, newScrollOffset, scrollDistance, theStep;if (container[0][config.scrollOffset] === 0) {
          for (i = 0; i < config.switchItems; i++) {
            containerUL.children(config.listItemElement + ":last-child").insertBefore(containerUL.children(config.listItemElement + ":first-child"));
          }curLi = containerUL.children(config.listItemElement + ":first-child");scrollDistance = config.distance !== "auto" ? config.distance : config.direction === "vertical" ? curLi.height() : curLi.width();container[0][config.scrollOffset] = scrollDistance;
        }if (!config.linear) {
          theStep = Math.max(3, parseInt(container[0][config.scrollOffset] * .3, 10));newScrollOffset = Math.max(container[0][config.scrollOffset] - theStep, 0);
        } else {
          newScrollOffset = Math.max(container[0][config.scrollOffset] - config.step, 0);
        }container[0][config.scrollOffset] = newScrollOffset;if (newScrollOffset === 0) {
          --switchCount;clearInterval(scrollingId);scrollingId = null;if ($.isFunction(config.afterBackward)) {
            config.afterBackward.call(container, { switchCount: switchCount, currentFirstChild: containerUL.children(config.listItemElement + ":first-child") });
          }if (config.triggerStackable && stackedTriggerIndex !== 0) {
            releaseStack();return;
          }if (config.autoPlay) {
            nextScrollId = setTimeout(forward, config.delay * 1e3);
          }
        }
      };releaseStack = function () {
        if (stackedTriggerIndex === 0) {
          return;
        }if (stackedTriggerIndex > 0) {
          stackedTriggerIndex--;nextScrollId = setTimeout(forward, 0);
        } else {
          stackedTriggerIndex++;nextScrollId = setTimeout(backward, 0);
        }
      };forward = function () {
        clearInterval(scrollingId);scrollingId = setInterval(scrollForward, config.speed);
      };backward = function () {
        clearInterval(scrollingId);scrollingId = setInterval(scrollBackward, config.speed);
      };forwardHover = function () {
        config.autoPlay = true;paused = false;clearInterval(scrollingId);scrollingId = setInterval(scrollForward, config.speed);
      };pauseHover = function () {
        paused = true;
      };resetClock = function (delay) {
        config.delay = delay || config.delay;clearTimeout(nextScrollId);if (config.autoPlay) {
          nextScrollId = setTimeout(forward, config.delay * 1e3);
        }
      };if (config.autoPlay) {
        nextScrollId = setTimeout(forward, config.startDelay * 1e3);
      }container.bind("resetClock", function (delay) {
        resetClock(delay);
      });container.bind("forward", function () {
        if (config.triggerStackable) {
          if (scrollingId !== null) {
            stackedTriggerIndex++;
          } else {
            forward();
          }
        } else {
          clearTimeout(nextScrollId);forward();
        }
      });container.bind("backward", function () {
        if (config.triggerStackable) {
          if (scrollingId !== null) {
            stackedTriggerIndex--;
          } else {
            backward();
          }
        } else {
          clearTimeout(nextScrollId);backward();
        }
      });container.bind("pauseHover", function () {
        pauseHover();
      });container.bind("forwardHover", function () {
        forwardHover();
      });container.bind("speedUp", function (event, speed) {
        if (speed === "undefined") {
          speed = Math.max(1, parseInt(config.speed / 2, 10));
        }config.speed = speed;
      });container.bind("speedDown", function (event, speed) {
        if (speed === "undefined") {
          speed = config.speed * 2;
        }config.speed = speed;
      });container.bind("updateConfig", function (event, options) {
        config = $.extend(config, options);
      });
    });
  };
})(jQuery);

/***/ }),
/* 19 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/**
 * 2007-2020 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */


function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { 'default': obj }; }

var _jquery = __webpack_require__(0);

var _jquery2 = _interopRequireDefault(_jquery);

var _prestashop = __webpack_require__(1);

var _prestashop2 = _interopRequireDefault(_prestashop);

__webpack_require__(4);

var _componentsProductMiniature = __webpack_require__(3);

var _componentsProductMiniature2 = _interopRequireDefault(_componentsProductMiniature);

function quickviewSlick() {

  (0, _jquery2['default'])('.quickview .product-images').slick({
    dots: false,
    arrows: true,
    vertical: true,
    slidesToShow: 4,
    slidesToScroll: 1,
    infinite: false
  });

  (0, _jquery2['default'])('.quickview .slick-list').wrap('<div class="slick-list-wrap"></div>');
}

(0, _jquery2['default'])(document).ready(function () {
  _prestashop2['default'].on('clickQuickView', function (elm) {
    var data = {
      'action': 'quickview',
      'id_product': elm.dataset.idProduct,
      'id_product_attribute': elm.dataset.idProductAttribute
    };
    _jquery2['default'].post(_prestashop2['default'].urls.pages.product, data, null, 'json').then(function (resp) {
      (0, _jquery2['default'])('body').append(resp.quickview_html);
      var productModal = (0, _jquery2['default'])('#quickview-modal-' + resp.product.id + '-' + resp.product.id_product_attribute);
      productModal.modal('show');
      coverImage();
      quickviewSlick();
      updateCountdown();
      productConfig(productModal);
      productModal.on('hidden.bs.modal', function () {
        productModal.remove();
      });
    }).fail(function (resp) {
      _prestashop2['default'].emit('handleError', { eventType: 'clickQuickView', resp: resp });
    });
  });

  _prestashop2['default'].on('updatedProduct', function (event) {
    quickviewSlick();
    coverImage();
    (0, _jquery2['default'])('.quickview .slick-prev').trigger('click');
  });

  var productConfig = function productConfig(qv) {
    var MAX_THUMBS = 4;
    var $arrows = (0, _jquery2['default'])('.js-arrows');
    var $thumbnails = qv.find('.js-qv-product-images');
    (0, _jquery2['default'])('.js-thumb').on('click', function (event) {
      if ((0, _jquery2['default'])('.js-thumb').hasClass('selected')) {
        (0, _jquery2['default'])('.js-thumb').removeClass('selected');
      }
      (0, _jquery2['default'])(event.currentTarget).addClass('selected');
      (0, _jquery2['default'])('.js-qv-product-cover').attr('src', (0, _jquery2['default'])(event.target).data('image-large-src'));
    });
    if ($thumbnails.find('li').length <= MAX_THUMBS) {
      $arrows.hide();
    } else {
      $arrows.on('click', function (event) {
        if ((0, _jquery2['default'])(event.target).hasClass('arrow-up') && (0, _jquery2['default'])('.js-qv-product-images').position().top < 0) {
          move('up');
          (0, _jquery2['default'])('.arrow-down').css('opacity', '1');
        } else if ((0, _jquery2['default'])(event.target).hasClass('arrow-down') && $thumbnails.position().top + $thumbnails.height() > (0, _jquery2['default'])('.js-qv-mask').height()) {
          move('down');
          (0, _jquery2['default'])('.arrow-up').css('opacity', '1');
        }
      });
    }
    qv.find('#quantity_wanted').TouchSpin({
      verticalbuttons: true,
      verticalupclass: 'material-icons touchspin-up',
      verticaldownclass: 'material-icons touchspin-down',
      buttondown_class: 'btn btn-touchspin js-touchspin',
      buttonup_class: 'btn btn-touchspin js-touchspin',
      min: 1,
      max: 1000000
    });
  };

  var move = function move(direction) {
    var THUMB_MARGIN = 20;
    var $thumbnails = (0, _jquery2['default'])('.js-qv-product-images');
    var thumbHeight = (0, _jquery2['default'])('.js-qv-product-images li img').height() + THUMB_MARGIN;
    var currentPosition = $thumbnails.position().top;
    $thumbnails.velocity({
      translateY: direction === 'up' ? currentPosition + thumbHeight : currentPosition - thumbHeight
    }, function () {
      if ($thumbnails.position().top >= 0) {
        (0, _jquery2['default'])('.arrow-up').css('opacity', '.2');
      } else if ($thumbnails.position().top + $thumbnails.height() <= (0, _jquery2['default'])('.js-qv-mask').height()) {
        (0, _jquery2['default'])('.arrow-down').css('opacity', '.2');
      }
    });
  };

  (0, _jquery2['default'])('body').on('click', '#search_filter_toggler', function () {
    (0, _jquery2['default'])('#search_filters_wrapper').removeClass('d-none d-md-block');
    (0, _jquery2['default'])('#js-product-list, #js-product-list-top, #js-active-search-filters').addClass('d-none d-md-block');
    (0, _jquery2['default'])('#footer').addClass('d-none d-md-block');
  });
  (0, _jquery2['default'])('#search_filter_controls .clear').on('click', function () {
    (0, _jquery2['default'])('#search_filters_wrapper').addClass('d-none d-md-block');
    (0, _jquery2['default'])('#content-wrapper').removeClass('d-none d-md-block');
    (0, _jquery2['default'])('#footer').removeClass('d-none d-md-block');
  });
  (0, _jquery2['default'])('#search_filter_controls .ok').on('click', function () {
    (0, _jquery2['default'])('#search_filters_wrapper').addClass('d-none d-md-block');
    (0, _jquery2['default'])('#js-product-list, #js-product-list-top, #js-active-search-filters').removeClass('d-none d-md-block');
    (0, _jquery2['default'])('#footer').removeClass('d-none d-md-block');
  });

  function coverImage() {
    (0, _jquery2['default'])('.thumb-container').on('click', function (event) {
      (0, _jquery2['default'])('.js-modal-thumb').attr('src', (0, _jquery2['default'])(event.target).data('image-large-src'));
      (0, _jquery2['default'])('.selected').removeClass('selected');
      (0, _jquery2['default'])(event.target).addClass('selected');
      (0, _jquery2['default'])('.js-qv-product-cover').attr('src', (0, _jquery2['default'])(event.target).data('image-large-src'));
    });
  }

  var parseSearchUrl = function parseSearchUrl(event) {
    if (event.target.dataset.searchUrl !== undefined) {
      return event.target.dataset.searchUrl;
    }

    if ((0, _jquery2['default'])(event.target).parent()[0].dataset.searchUrl === undefined) {
      throw new Error('Can not parse search URL');
    }

    return (0, _jquery2['default'])(event.target).parent()[0].dataset.searchUrl;
  };

  (0, _jquery2['default'])('body').on('change', '#search_filters input[data-search-url]', function (event) {
    _prestashop2['default'].emit('updateFacets', parseSearchUrl(event));
  });

  (0, _jquery2['default'])('body').on('click', '.js-search-filters-clear-all', function (event) {
    _prestashop2['default'].emit('updateFacets', parseSearchUrl(event));
  });

  (0, _jquery2['default'])('body').on('click', '.js-search-link', function (event) {
    event.preventDefault();
    _prestashop2['default'].emit('updateFacets', (0, _jquery2['default'])(event.target).closest('a').get(0).href);
  });

  (0, _jquery2['default'])('body').on('change', '#search_filters select', function (event) {
    var form = (0, _jquery2['default'])(event.target).closest('form');
    _prestashop2['default'].emit('updateFacets', '?' + form.serialize());
  });
  _prestashop2['default'].on('updateProductList', function (data) {
    updateProductListDOM(data);
    hideFilterMobile();
    (0, _jquery2['default'])('#search_filters_wrapper .color').parent().parent().parent().addClass('color-boxes');
    (0, _jquery2['default'])('.color-boxes').parent().css('overflow', 'hidden');
  });
});

function hideFilterMobile() {
  if ((0, _jquery2['default'])(window).width() < 768) {
    (0, _jquery2['default'])('#search_filters_wrapper').addClass('d-none d-md-block');
    (0, _jquery2['default'])('#js-product-list, #js-product-list-top, #js-active-search-filters').removeClass('d-none d-md-block');
    (0, _jquery2['default'])('#footer').removeClass('d-none d-md-block');
  }
}

function updateProductListDOM(data) {
  (0, _jquery2['default'])('.quickview .slick-list').wrap('<div class="slick-list-wrap"></div>');
  (0, _jquery2['default'])('#search_filters').replaceWith(data.rendered_facets);
  (0, _jquery2['default'])('#js-active-search-filters').replaceWith(data.rendered_active_filters);
  (0, _jquery2['default'])('#js-product-list-top').replaceWith(data.rendered_products_top);
  (0, _jquery2['default'])('#js-product-list').replaceWith(data.rendered_products);
  (0, _jquery2['default'])('#js-product-list-bottom').replaceWith(data.rendered_products_bottom);
  if (data.rendered_products_header) {
    (0, _jquery2['default'])('#js-product-list-header').replaceWith(data.rendered_products_header);
  }
  var productMinitature = new _componentsProductMiniature2['default']();
  productMinitature.init();
}

function updateCountdown() {

  (0, _jquery2['default'])('#bon-stick-cart .bon-stock-countdown').remove();
  var maxQuantity = parseInt((0, _jquery2['default'])('.bon-stock-countdown').attr("data-max"));
  var quantityProduct = parseInt((0, _jquery2['default'])('.bon-stock-countdown-counter').attr('data-value'));
  var progressBar = (0, _jquery2['default'])('.bon-stock-countdown-progress');

  if (quantityProduct < maxQuantity) {
    if (quantityProduct > 0) {
      (0, _jquery2['default'])(progressBar).css('width', quantityProduct * 100 / maxQuantity + '%');
    }
  }

  if (quantityProduct > maxQuantity) {
    (0, _jquery2['default'])(progressBar).css('width', '100%');
  }

  if (quantityProduct <= 0) {
    (0, _jquery2['default'])('.bon-stock-countdown-title').html('<span>No product available!</span>');
    (0, _jquery2['default'])(progressBar).css('width', '0');
  }
}

/***/ }),
/* 20 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/**
 * 2007-2020 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */


function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { 'default': obj }; }

var _jquery = __webpack_require__(0);

var _jquery2 = _interopRequireDefault(_jquery);

var _prestashop = __webpack_require__(1);

var _prestashop2 = _interopRequireDefault(_prestashop);

function miniatureSlider() {
    var swiper = new Swiper(".featured-products.featured-products-swiper", {
        speed: 1100,
        preloadImages: false,
        loop: false,
        grid: {
            rows: 2
        },
        pagination: {
            el: ".featured-products.bonswiper-pagination",
            clickable: true
        },
        navigation: {
            nextEl: ".featured-products .bonswiper-button-next",
            prevEl: ".featured-products .bonswiper-button-prev"
        },
        breakpoints: {
            // when window width is >= 320px
            320: {
                slidesPerView: 1
            },
            // when window width is >= 576px
            570: {
                slidesPerView: 2
            },
            // when window width is >= 991px
            991: {
                slidesPerView: 4
            }
        },
        on: {
            init: function init() {
                (0, _jquery2['default'])('.featured-products.featured-products-swiper').css({ 'opacity': '1', 'visibility': 'visible' });
            }
        }
    });
}
function productSlick() {
    (0, _jquery2['default'])('#content-wrapper .js-qv-mask ul').slick({
        dots: false,
        arrows: true,
        vertical: false,
        slidesToShow: 4,
        slidesToScroll: 1,
        infinite: true
    });
}

(0, _jquery2['default'])('#content-wrapper .js-qv-mask ul').on('init', function (event, slick) {
    (0, _jquery2['default'])('#main .images-container .js-qv-mask').css('display', 'block');
});
(0, _jquery2['default'])(window).resize(function () {
    if ((0, _jquery2['default'])(window).width() >= 1200) {
        (0, _jquery2['default'])('.slick-next').trigger("click");
        (0, _jquery2['default'])('#product .product-cover').on('click', function () {
            if ((0, _jquery2['default'])('.modal-gallery.js-product-images-modal').css('display') === 'block') {
                (0, _jquery2['default'])('.modal-gallery .modal-content .modal-body #thumbnails .js-modal-mask ul').not('.slick-initialized').slick({
                    dots: false,
                    arrows: true,
                    vertical: false,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    infinite: true
                });
            }
        });
    }
});

function createGalery() {
    if ((0, _jquery2['default'])(window).width() >= 300) {

        (0, _jquery2['default'])('#product .product-cover').on('click', function () {

            if ((0, _jquery2['default'])('.modal-gallery.js-product-images-modal').css('display') == 'none') {

                (0, _jquery2['default'])('.modal-gallery.js-product-images-modal').css('display', 'block');

                (0, _jquery2['default'])('.modal-gallery .modal-content .modal-body #thumbnails .js-modal-mask ul').not('.slick-initialized').slick({
                    dots: false,
                    arrows: true,
                    vertical: false,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    infinite: true
                });
            } else {
                (0, _jquery2['default'])('.modal-gallery.js-product-images-modal').css('display', 'none');
            }
        });
    }
}

(0, _jquery2['default'])(document).ready(function () {
    createProductSpin();
    createInputFile();
    updateCountdown();
    closeGallery();
    createGalery();
    coverImage();
    openReviewTab();
    miniatureSlider();
    productSlick();

    _prestashop2['default'].on('updatedProduct', function (event) {
        createInputFile();
        createGalery();
        coverImage();
        productSlick();
        updateCountdown();
        applyElevateZoom();
        (0, _jquery2['default'])('.thumb-container').click(function () {
            restartElevateZoom();
        });
        (0, _jquery2['default'])('.color-boxes').parent().css('overflow', 'hidden');
        if (event && event.product_minimal_quantity) {
            var minimalProductQuantity = parseInt(event.product_minimal_quantity, 10);
            var quantityInputSelector = '#quantity_wanted';
            var quantityInput = (0, _jquery2['default'])(quantityInputSelector);
            // @see http://www.virtuosoft.eu/code/bootstrap-touchspin/ about Bootstrap TouchSpin
            quantityInput.trigger('touchspin.updatesettings', { min: minimalProductQuantity });
        }

        (0, _jquery2['default'])((0, _jquery2['default'])('.tabs .nav-link.active').attr('href')).addClass('active').removeClass('fade');
        (0, _jquery2['default'])('.js-product-images-modal').replaceWith(event.product_images_modal);
    });
});

function closeGallery() {
    (0, _jquery2['default'])(document).mouseup(function (e) {
        var gallery = (0, _jquery2['default'])(".modal-gallery");
        if (gallery.is(e.target) && gallery.has(e.target).length === 0) {
            gallery.hide();
        }
        (0, _jquery2['default'])('.gallery-close').on('click', function () {
            gallery.hide();
        });
    });
}

function updateCountdown() {

    (0, _jquery2['default'])('#bon-stick-cart .bon-stock-countdown').remove();
    var maxQuantity = parseInt((0, _jquery2['default'])('.bon-stock-countdown').attr("data-max"));
    var quantityProduct = parseInt((0, _jquery2['default'])('.bon-stock-countdown-counter').attr('data-value'));
    var progressBar = (0, _jquery2['default'])('.bon-stock-countdown-progress');

    if (quantityProduct < maxQuantity) {
        if (quantityProduct > 0) {
            (0, _jquery2['default'])(progressBar).css('width', quantityProduct * 100 / maxQuantity + '%');
        }
    }

    if (quantityProduct > maxQuantity) {
        (0, _jquery2['default'])(progressBar).css('width', '100%');
    }

    if (quantityProduct <= 0) {
        (0, _jquery2['default'])('.bon-stock-countdown-title').html('<span>No product available!</span>');
        (0, _jquery2['default'])(progressBar).css('width', '0');
    }
}

function openReviewTab() {
    var tabs = (0, _jquery2['default'])('.nav-item a');
    (0, _jquery2['default'])('.bon-review-button').on('click', function () {
        if ((0, _jquery2['default'])(tabs).hasClass('active')) {
            (0, _jquery2['default'])(tabs).removeClass('active');
            (0, _jquery2['default'])('.nav-item .reviewtab').trigger('click');
        } else {
            (0, _jquery2['default'])('.nav-item .reviewtab').removeClass('active');
        }
    });
}

function coverImage() {
    (0, _jquery2['default'])('.thumb-container').on('click', function (event) {
        (0, _jquery2['default'])('.js-modal-product-cover').attr('src', (0, _jquery2['default'])(event.target).data('image-large-src'));
        (0, _jquery2['default'])('.selected').removeClass('selected');
        (0, _jquery2['default'])(event.target).addClass('selected');
        (0, _jquery2['default'])('.js-qv-product-cover').attr('src', (0, _jquery2['default'])(event.target).data('image-large-src'));
    });
}

function createInputFile() {
    (0, _jquery2['default'])('.js-file-input').on('change', function (event) {
        var target = undefined,
            file = undefined;

        if ((target = (0, _jquery2['default'])(event.currentTarget)[0]) && (file = target.files[0])) {
            (0, _jquery2['default'])(target).prev().text(file.name);
        }
    });
}

function createProductSpin() {
    var $quantityInput = (0, _jquery2['default'])('#quantity_wanted');

    $quantityInput.TouchSpin({
        buttondown_class: 'btn btn-touchspin js-touchspin',
        buttonup_class: 'btn btn-touchspin js-touchspin',
        verticalbuttons: true,
        min: parseInt($quantityInput.attr('min'), 10),
        max: 1000000
    });
}

/***/ }),
/* 21 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/**
 * 2007-2020 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */


function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { 'default': obj }; }

var _jquery = __webpack_require__(0);

var _jquery2 = _interopRequireDefault(_jquery);

var _prestashop = __webpack_require__(1);

var _prestashop2 = _interopRequireDefault(_prestashop);

_prestashop2['default'].responsive = _prestashop2['default'].responsive || {};

_prestashop2['default'].responsive.current_width = window.innerWidth;
_prestashop2['default'].responsive.min_width = 992;
_prestashop2['default'].responsive.mobile = _prestashop2['default'].responsive.current_width < _prestashop2['default'].responsive.min_width;

function swapChildren(obj1, obj2) {
	var temp = obj2.children().detach();
	obj2.empty().append(obj1.children().detach());
	obj1.append(temp);
}

function toggleMobileStyles() {
	if (_prestashop2['default'].responsive.mobile) {
		(0, _jquery2['default'])("*[id^='_desktop_']").each(function (idx, el) {
			var target = (0, _jquery2['default'])('#' + el.id.replace('_desktop_', '_mobile_'));
			if (target.length) {
				swapChildren((0, _jquery2['default'])(el), target);
			}
		});
	} else {
		(0, _jquery2['default'])("*[id^='_mobile_']").each(function (idx, el) {
			var target = (0, _jquery2['default'])('#' + el.id.replace('_mobile_', '_desktop_'));
			if (target.length) {
				swapChildren((0, _jquery2['default'])(el), target);
			}
		});
	}
	_prestashop2['default'].emit('responsive update', {
		mobile: _prestashop2['default'].responsive.mobile
	});
}

(0, _jquery2['default'])(window).on('resize', function () {
	// (0, _jquery2['default'])('#mobile_top_menu_wrapper').css('top', (0, _jquery2['default'])("#header").height()).css('height', 'calc(100vh - ' + (0, _jquery2['default'])('#header').height() + 'px');
	var _cw = _prestashop2['default'].responsive.current_width;
	var _mw = _prestashop2['default'].responsive.min_width;
	var _w = window.innerWidth;
	var _toggle = _cw >= _mw && _w < _mw || _cw < _mw && _w >= _mw;
	_prestashop2['default'].responsive.current_width = _w;
	_prestashop2['default'].responsive.mobile = _prestashop2['default'].responsive.current_width < _prestashop2['default'].responsive.min_width;

	if (_toggle) {
		toggleMobileStyles();
	}
});

(0, _jquery2['default'])(document).ready(function () {
	if (_prestashop2['default'].responsive.mobile) {
		toggleMobileStyles();
	}
	// openMobileMenu();
});
// (0, _jquery2['default'])('#menu-icon').on('click', function () {
// 	if ((0, _jquery2['default'])('#menu-icon').hasClass('active')) {
// 		(0, _jquery2['default'])('#menu-icon').removeClass('active');
// 		(0, _jquery2['default'])("#mobile_top_menu_wrapper").removeClass('active');
// 		(0, _jquery2['default'])('#wrapper').removeClass('active');
// 		(0, _jquery2['default'])('#mobile_top_menu_wrapper').css('transition', 'all 0.2s linear');
// 	} else {
// 		(0, _jquery2['default'])('#menu-icon').addClass('active');
// 		(0, _jquery2['default'])("#mobile_top_menu_wrapper").addClass('active');
// 		(0, _jquery2['default'])('#wrapper').addClass('active');
// 		(0, _jquery2['default'])('#mobile_top_menu_wrapper').css('transition', 'all 0.2s linear');
// 	}
// });
// function openMobileMenu() {
// 	if ((0, _jquery2['default'])(window).width() < 992) {
// 		(0, _jquery2['default'])("#mobile_top_menu_wrapper").append((0, _jquery2['default'])('.header-contact.left-block'));
// 	} else {
// 		(0, _jquery2['default'])('.header-contact-info').prepend((0, _jquery2['default'])('.header-contact.left-block'));
// 	}
// 	setTimeout(function () {
// 		(0, _jquery2['default'])('#mobile_top_menu_wrapper').css('top', (0, _jquery2['default'])("#header").height()).css('height', 'calc(100vh - ' + (0, _jquery2['default'])('#header').height() + 'px');
// 	}, 400);
// }

/***/ }),
/* 22 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;/*
 *  Bootstrap TouchSpin - v4.3.0
 *  A mobile and touch friendly input spinner component for Bootstrap 3 & 4.
 *  http://www.virtuosoft.eu/code/bootstrap-touchspin/
 *
 *  Made by István Ujj-Mészáros
 *  Under Apache License v2.0 License
 */


(function (factory) {
  if (true) {
    !(__WEBPACK_AMD_DEFINE_ARRAY__ = [__webpack_require__(0)], __WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
  } else if (typeof module === 'object' && module.exports) {
    module.exports = function (root, jQuery) {
      if (jQuery === undefined) {
        if (typeof window !== 'undefined') {
          jQuery = require('jquery');
        } else {
          jQuery = require('jquery')(root);
        }
      }
      factory(jQuery);
      return jQuery;
    };
  } else {
    factory(jQuery);
  }
})(function ($) {
  'use strict';

  var _currentSpinnerId = 0;

  $.fn.TouchSpin = function (options) {

    var defaults = {
      min: 0, // If null, there is no minimum enforced
      max: 100, // If null, there is no maximum enforced
      initval: '',
      replacementval: '',
      firstclickvalueifempty: null,
      step: 1,
      decimals: 0,
      stepinterval: 100,
      forcestepdivisibility: 'round', // none | floor | round | ceil
      stepintervaldelay: 500,
      verticalbuttons: false,
      verticalup: '+',
      verticaldown: '-',
      verticalupclass: '',
      verticaldownclass: '',
      prefix: '',
      postfix: '',
      prefix_extraclass: '',
      postfix_extraclass: '',
      booster: true,
      boostat: 10,
      maxboostedstep: false,
      mousewheel: true,
      buttondown_class: 'btn btn-primary',
      buttonup_class: 'btn btn-primary',
      buttondown_txt: '-',
      buttonup_txt: '+',
      callback_before_calculation: function callback_before_calculation(value) {
        return value;
      },
      callback_after_calculation: function callback_after_calculation(value) {
        return value;
      }
    };

    var attributeMap = {
      min: 'min',
      max: 'max',
      initval: 'init-val',
      replacementval: 'replacement-val',
      firstclickvalueifempty: 'first-click-value-if-empty',
      step: 'step',
      decimals: 'decimals',
      stepinterval: 'step-interval',
      verticalbuttons: 'vertical-buttons',
      verticalupclass: 'vertical-up-class',
      verticaldownclass: 'vertical-down-class',
      forcestepdivisibility: 'force-step-divisibility',
      stepintervaldelay: 'step-interval-delay',
      prefix: 'prefix',
      postfix: 'postfix',
      prefix_extraclass: 'prefix-extra-class',
      postfix_extraclass: 'postfix-extra-class',
      booster: 'booster',
      boostat: 'boostat',
      maxboostedstep: 'max-boosted-step',
      mousewheel: 'mouse-wheel',
      buttondown_class: 'button-down-class',
      buttonup_class: 'button-up-class',
      buttondown_txt: 'button-down-txt',
      buttonup_txt: 'button-up-txt'
    };

    return this.each(function () {

      var settings,
          originalinput = $(this),
          originalinput_data = originalinput.data(),
          _detached_prefix,
          _detached_postfix,
          container,
          elements,
          value,
          downSpinTimer,
          upSpinTimer,
          downDelayTimeout,
          upDelayTimeout,
          spincount = 0,
          spinning = false;

      init();

      function init() {
        if (originalinput.data('alreadyinitialized')) {
          return;
        }

        originalinput.data('alreadyinitialized', true);
        _currentSpinnerId += 1;
        originalinput.data('spinnerid', _currentSpinnerId);

        if (!originalinput.is('input')) {
          console.log('Must be an input.');
          return;
        }

        _initSettings();
        _setInitval();
        _checkValue();
        _buildHtml();
        _initElements();
        _hideEmptyPrefixPostfix();
        _bindEvents();
        _bindEventsInterface();
      }

      function _setInitval() {
        if (settings.initval !== '' && originalinput.val() === '') {
          originalinput.val(settings.initval);
        }
      }

      function changeSettings(newsettings) {
        _updateSettings(newsettings);
        _checkValue();

        var value = elements.input.val();

        if (value !== '') {
          value = Number(settings.callback_before_calculation(elements.input.val()));
          elements.input.val(settings.callback_after_calculation(Number(value).toFixed(settings.decimals)));
        }
      }

      function _initSettings() {
        settings = $.extend({}, defaults, originalinput_data, _parseAttributes(), options);
      }

      function _parseAttributes() {
        var data = {};
        $.each(attributeMap, function (key, value) {
          var attrName = 'bts-' + value + '';
          if (originalinput.is('[data-' + attrName + ']')) {
            data[key] = originalinput.data(attrName);
          }
        });
        return data;
      }

      function _destroy() {
        var $parent = originalinput.parent();

        stopSpin();

        originalinput.off('.touchspin');

        if ($parent.hasClass('bootstrap-touchspin-injected')) {
          originalinput.siblings().remove();
          originalinput.unwrap();
        } else {
          $('.bootstrap-touchspin-injected', $parent).remove();
          $parent.removeClass('bootstrap-touchspin');
        }

        originalinput.data('alreadyinitialized', false);
      }

      function _updateSettings(newsettings) {
        settings = $.extend({}, settings, newsettings);

        // Update postfix and prefix texts if those settings were changed.
        if (newsettings.postfix) {
          var $postfix = originalinput.parent().find('.bootstrap-touchspin-postfix');

          if ($postfix.length === 0) {
            _detached_postfix.insertAfter(originalinput);
          }

          originalinput.parent().find('.bootstrap-touchspin-postfix .input-group-text').text(newsettings.postfix);
        }

        if (newsettings.prefix) {
          var $prefix = originalinput.parent().find('.bootstrap-touchspin-prefix');

          if ($prefix.length === 0) {
            _detached_prefix.insertBefore(originalinput);
          }

          originalinput.parent().find('.bootstrap-touchspin-prefix .input-group-text').text(newsettings.prefix);
        }

        _hideEmptyPrefixPostfix();
      }

      function _buildHtml() {
        var initval = originalinput.val(),
            parentelement = originalinput.parent();

        if (initval !== '') {
          initval = settings.callback_after_calculation(Number(initval).toFixed(settings.decimals));
        }

        originalinput.data('initvalue', initval).val(initval);
        originalinput.addClass('form-control');

        if (parentelement.hasClass('input-group')) {
          _advanceInputGroup(parentelement);
        } else {
          _buildInputGroup();
        }
      }

      function _advanceInputGroup(parentelement) {
        parentelement.addClass('bootstrap-touchspin');

        var prev = originalinput.prev(),
            next = originalinput.next();

        var downhtml,
            uphtml,
            prefixhtml = '<span class="input-group-addon input-group-prepend bootstrap-touchspin-prefix input-group-prepend bootstrap-touchspin-injected"><span class="input-group-text">' + settings.prefix + '</span></span>',
            postfixhtml = '<span class="input-group-addon input-group-append bootstrap-touchspin-postfix input-group-append bootstrap-touchspin-injected"><span class="input-group-text">' + settings.postfix + '</span></span>';

        if (prev.hasClass('input-group-btn') || prev.hasClass('input-group-prepend')) {
          downhtml = '<button class="' + settings.buttondown_class + ' bootstrap-touchspin-down bootstrap-touchspin-injected" type="button">' + settings.buttondown_txt + '</button>';
          prev.append(downhtml);
        } else {
          downhtml = '<span class="input-group-btn input-group-prepend bootstrap-touchspin-injected"><button class="' + settings.buttondown_class + ' bootstrap-touchspin-down" type="button">' + settings.buttondown_txt + '</button></span>';
          $(downhtml).insertBefore(originalinput);
        }

        if (next.hasClass('input-group-btn') || next.hasClass('input-group-append')) {
          uphtml = '<button class="' + settings.buttonup_class + ' bootstrap-touchspin-up bootstrap-touchspin-injected" type="button">' + settings.buttonup_txt + '</button>';
          next.prepend(uphtml);
        } else {
          uphtml = '<span class="input-group-btn input-group-append bootstrap-touchspin-injected"><button class="' + settings.buttonup_class + ' bootstrap-touchspin-up" type="button">' + settings.buttonup_txt + '</button></span>';
          $(uphtml).insertAfter(originalinput);
        }

        $(prefixhtml).insertBefore(originalinput);
        $(postfixhtml).insertAfter(originalinput);

        container = parentelement;
      }

      function _buildInputGroup() {
        var html;

        var inputGroupSize = '';
        if (originalinput.hasClass('input-sm')) {
          inputGroupSize = 'input-group-sm';
        }

        if (originalinput.hasClass('input-lg')) {
          inputGroupSize = 'input-group-lg';
        }

        if (settings.verticalbuttons) {
          html = '<div class="input-group ' + inputGroupSize + ' bootstrap-touchspin bootstrap-touchspin-injected"><span class="input-group-addon input-group-prepend bootstrap-touchspin-prefix"><span class="input-group-text">' + settings.prefix + '</span></span><span class="input-group-addon bootstrap-touchspin-postfix input-group-append"><span class="input-group-text">' + settings.postfix + '</span></span><span class="input-group-btn-vertical"><button class="' + settings.buttondown_class + ' bootstrap-touchspin-up ' + settings.verticalupclass + '" type="button">' + settings.verticalup + '</button><button class="' + settings.buttonup_class + ' bootstrap-touchspin-down ' + settings.verticaldownclass + '" type="button">' + settings.verticaldown + '</button></span></div>';
        } else {
          html = '<div class="input-group bootstrap-touchspin bootstrap-touchspin-injected"><span class="input-group-btn input-group-prepend"><button class="' + settings.buttondown_class + ' bootstrap-touchspin-down" type="button">' + settings.buttondown_txt + '</button></span><span class="input-group-addon bootstrap-touchspin-prefix input-group-prepend"><span class="input-group-text">' + settings.prefix + '</span></span><span class="input-group-addon bootstrap-touchspin-postfix input-group-append"><span class="input-group-text">' + settings.postfix + '</span></span><span class="input-group-btn input-group-append"><button class="' + settings.buttonup_class + ' bootstrap-touchspin-up" type="button">' + settings.buttonup_txt + '</button></span></div>';
        }

        container = $(html).insertBefore(originalinput);

        $('.bootstrap-touchspin-prefix', container).after(originalinput);

        if (originalinput.hasClass('input-sm')) {
          container.addClass('input-group-sm');
        } else if (originalinput.hasClass('input-lg')) {
          container.addClass('input-group-lg');
        }
      }

      function _initElements() {
        elements = {
          down: $('.bootstrap-touchspin-down', container),
          up: $('.bootstrap-touchspin-up', container),
          input: $('input', container),
          prefix: $('.bootstrap-touchspin-prefix', container).addClass(settings.prefix_extraclass),
          postfix: $('.bootstrap-touchspin-postfix', container).addClass(settings.postfix_extraclass)
        };
      }

      function _hideEmptyPrefixPostfix() {
        if (settings.prefix === '') {
          _detached_prefix = elements.prefix.detach();
        }

        if (settings.postfix === '') {
          _detached_postfix = elements.postfix.detach();
        }
      }

      function _bindEvents() {
        originalinput.on('keydown.touchspin', function (ev) {
          var code = ev.keyCode || ev.which;

          if (code === 38) {
            if (spinning !== 'up') {
              upOnce();
              startUpSpin();
            }
            ev.preventDefault();
          } else if (code === 40) {
            if (spinning !== 'down') {
              downOnce();
              startDownSpin();
            }
            ev.preventDefault();
          }
        });

        originalinput.on('keyup.touchspin', function (ev) {
          var code = ev.keyCode || ev.which;

          if (code === 38) {
            stopSpin();
          } else if (code === 40) {
            stopSpin();
          }
        });

        originalinput.on('blur.touchspin', function () {
          _checkValue();
          originalinput.val(settings.callback_after_calculation(originalinput.val()));
        });

        elements.down.on('keydown', function (ev) {
          var code = ev.keyCode || ev.which;

          if (code === 32 || code === 13) {
            if (spinning !== 'down') {
              downOnce();
              startDownSpin();
            }
            ev.preventDefault();
          }
        });

        elements.down.on('keyup.touchspin', function (ev) {
          var code = ev.keyCode || ev.which;

          if (code === 32 || code === 13) {
            stopSpin();
          }
        });

        elements.up.on('keydown.touchspin', function (ev) {
          var code = ev.keyCode || ev.which;

          if (code === 32 || code === 13) {
            if (spinning !== 'up') {
              upOnce();
              startUpSpin();
            }
            ev.preventDefault();
          }
        });

        elements.up.on('keyup.touchspin', function (ev) {
          var code = ev.keyCode || ev.which;

          if (code === 32 || code === 13) {
            stopSpin();
          }
        });

        elements.down.on('mousedown.touchspin', function (ev) {
          elements.down.off('touchstart.touchspin'); // android 4 workaround

          if (originalinput.is(':disabled')) {
            return;
          }

          downOnce();
          startDownSpin();

          ev.preventDefault();
          ev.stopPropagation();
        });

        elements.down.on('touchstart.touchspin', function (ev) {
          elements.down.off('mousedown.touchspin'); // android 4 workaround

          if (originalinput.is(':disabled')) {
            return;
          }

          downOnce();
          startDownSpin();

          ev.preventDefault();
          ev.stopPropagation();
        });

        elements.up.on('mousedown.touchspin', function (ev) {
          elements.up.off('touchstart.touchspin'); // android 4 workaround

          if (originalinput.is(':disabled')) {
            return;
          }

          upOnce();
          startUpSpin();

          ev.preventDefault();
          ev.stopPropagation();
        });

        elements.up.on('touchstart.touchspin', function (ev) {
          elements.up.off('mousedown.touchspin'); // android 4 workaround

          if (originalinput.is(':disabled')) {
            return;
          }

          upOnce();
          startUpSpin();

          ev.preventDefault();
          ev.stopPropagation();
        });

        elements.up.on('mouseup.touchspin mouseout.touchspin touchleave.touchspin touchend.touchspin touchcancel.touchspin', function (ev) {
          if (!spinning) {
            return;
          }

          ev.stopPropagation();
          stopSpin();
        });

        elements.down.on('mouseup.touchspin mouseout.touchspin touchleave.touchspin touchend.touchspin touchcancel.touchspin', function (ev) {
          if (!spinning) {
            return;
          }

          ev.stopPropagation();
          stopSpin();
        });

        elements.down.on('mousemove.touchspin touchmove.touchspin', function (ev) {
          if (!spinning) {
            return;
          }

          ev.stopPropagation();
          ev.preventDefault();
        });

        elements.up.on('mousemove.touchspin touchmove.touchspin', function (ev) {
          if (!spinning) {
            return;
          }

          ev.stopPropagation();
          ev.preventDefault();
        });

        originalinput.on('mousewheel.touchspin DOMMouseScroll.touchspin', function (ev) {
          if (!settings.mousewheel || !originalinput.is(':focus')) {
            return;
          }

          var delta = ev.originalEvent.wheelDelta || -ev.originalEvent.deltaY || -ev.originalEvent.detail;

          ev.stopPropagation();
          ev.preventDefault();

          if (delta < 0) {
            downOnce();
          } else {
            upOnce();
          }
        });
      }

      function _bindEventsInterface() {
        originalinput.on('touchspin.destroy', function () {
          _destroy();
        });

        originalinput.on('touchspin.uponce', function () {
          stopSpin();
          upOnce();
        });

        originalinput.on('touchspin.downonce', function () {
          stopSpin();
          downOnce();
        });

        originalinput.on('touchspin.startupspin', function () {
          startUpSpin();
        });

        originalinput.on('touchspin.startdownspin', function () {
          startDownSpin();
        });

        originalinput.on('touchspin.stopspin', function () {
          stopSpin();
        });

        originalinput.on('touchspin.updatesettings', function (e, newsettings) {
          changeSettings(newsettings);
        });
      }

      function _forcestepdivisibility(value) {
        switch (settings.forcestepdivisibility) {
          case 'round':
            return (Math.round(value / settings.step) * settings.step).toFixed(settings.decimals);
          case 'floor':
            return (Math.floor(value / settings.step) * settings.step).toFixed(settings.decimals);
          case 'ceil':
            return (Math.ceil(value / settings.step) * settings.step).toFixed(settings.decimals);
          default:
            return value.toFixed(settings.decimals);
        }
      }

      function _checkValue() {
        var val, parsedval, returnval;

        val = settings.callback_before_calculation(originalinput.val());

        if (val === '') {
          if (settings.replacementval !== '') {
            originalinput.val(settings.replacementval);
            originalinput.trigger('change');
          }
          return;
        }

        if (settings.decimals > 0 && val === '.') {
          return;
        }

        parsedval = parseFloat(val);

        if (isNaN(parsedval)) {
          if (settings.replacementval !== '') {
            parsedval = settings.replacementval;
          } else {
            parsedval = 0;
          }
        }

        returnval = parsedval;

        if (parsedval.toString() !== val) {
          returnval = parsedval;
        }

        if (settings.min !== null && parsedval < settings.min) {
          returnval = settings.min;
        }

        if (settings.max !== null && parsedval > settings.max) {
          returnval = settings.max;
        }

        returnval = _forcestepdivisibility(returnval);

        if (Number(val).toString() !== returnval.toString()) {
          originalinput.val(returnval);
          originalinput.trigger('change');
        }
      }

      function _getBoostedStep() {
        if (!settings.booster) {
          return settings.step;
        } else {
          var boosted = Math.pow(2, Math.floor(spincount / settings.boostat)) * settings.step;

          if (settings.maxboostedstep) {
            if (boosted > settings.maxboostedstep) {
              boosted = settings.maxboostedstep;
              value = Math.round(value / boosted) * boosted;
            }
          }

          return Math.max(settings.step, boosted);
        }
      }

      function valueIfIsNaN() {
        if (typeof settings.firstclickvalueifempty === 'number') {
          return settings.firstclickvalueifempty;
        } else {
          return (settings.min + settings.max) / 2;
        }
      }

      function upOnce() {
        _checkValue();

        value = parseFloat(settings.callback_before_calculation(elements.input.val()));

        var initvalue = value;
        var boostedstep;

        if (isNaN(value)) {
          value = valueIfIsNaN();
        } else {
          boostedstep = _getBoostedStep();
          value = value + boostedstep;
        }

        if (settings.max !== null && value > settings.max) {
          value = settings.max;
          originalinput.trigger('touchspin.on.max');
          stopSpin();
        }

        elements.input.val(settings.callback_after_calculation(Number(value).toFixed(settings.decimals)));

        if (initvalue !== value) {
          originalinput.trigger('change');
        }
      }

      function downOnce() {
        _checkValue();

        value = parseFloat(settings.callback_before_calculation(elements.input.val()));

        var initvalue = value;
        var boostedstep;

        if (isNaN(value)) {
          value = valueIfIsNaN();
        } else {
          boostedstep = _getBoostedStep();
          value = value - boostedstep;
        }

        if (settings.min !== null && value < settings.min) {
          value = settings.min;
          originalinput.trigger('touchspin.on.min');
          stopSpin();
        }

        elements.input.val(settings.callback_after_calculation(Number(value).toFixed(settings.decimals)));

        if (initvalue !== value) {
          originalinput.trigger('change');
        }
      }

      function startDownSpin() {
        stopSpin();

        spincount = 0;
        spinning = 'down';

        originalinput.trigger('touchspin.on.startspin');
        originalinput.trigger('touchspin.on.startdownspin');

        downDelayTimeout = setTimeout(function () {
          downSpinTimer = setInterval(function () {
            spincount++;
            downOnce();
          }, settings.stepinterval);
        }, settings.stepintervaldelay);
      }

      function startUpSpin() {
        stopSpin();

        spincount = 0;
        spinning = 'up';

        originalinput.trigger('touchspin.on.startspin');
        originalinput.trigger('touchspin.on.startupspin');

        upDelayTimeout = setTimeout(function () {
          upSpinTimer = setInterval(function () {
            spincount++;
            upOnce();
          }, settings.stepinterval);
        }, settings.stepintervaldelay);
      }

      function stopSpin() {
        clearTimeout(downDelayTimeout);
        clearTimeout(upDelayTimeout);
        clearInterval(downSpinTimer);
        clearInterval(upSpinTimer);

        switch (spinning) {
          case 'up':
            originalinput.trigger('touchspin.on.stopupspin');
            originalinput.trigger('touchspin.on.stopspin');
            break;
          case 'down':
            originalinput.trigger('touchspin.on.stopdownspin');
            originalinput.trigger('touchspin.on.stopspin');
            break;
        }

        spincount = 0;
        spinning = false;
      }
    });
  };
});

/***/ }),
/* 23 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/*!
  * Bootstrap v4.5.2 (https://getbootstrap.com/)
  * Copyright 2011-2020 The Bootstrap Authors (https://github.com/twbs/bootstrap/graphs/contributors)
  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
  */


!(function (t, e) {
   true ? e(exports, __webpack_require__(0), __webpack_require__(26)) : "function" == typeof define && define.amd ? define(["exports", "jquery", "popper.js"], e) : e((t = "undefined" != typeof globalThis ? globalThis : t || self).bootstrap = {}, t.jQuery, t.Popper);
})(undefined, function (t, e, n) {
  "use strict";function i(t, e) {
    for (var n = 0; n < e.length; n++) {
      var i = e[n];i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), Object.defineProperty(t, i.key, i);
    }
  }function o(t, e, n) {
    return e && i(t.prototype, e), n && i(t, n), t;
  }function s() {
    return (s = Object.assign || function (t) {
      for (var e = 1; e < arguments.length; e++) {
        var n = arguments[e];for (var i in n) Object.prototype.hasOwnProperty.call(n, i) && (t[i] = n[i]);
      }return t;
    }).apply(this, arguments);
  }e = e && Object.prototype.hasOwnProperty.call(e, "default") ? e["default"] : e, n = n && Object.prototype.hasOwnProperty.call(n, "default") ? n["default"] : n;function r(t) {
    var n = this,
        i = !1;return e(this).one(a.TRANSITION_END, function () {
      i = !0;
    }), setTimeout(function () {
      i || a.triggerTransitionEnd(n);
    }, t), this;
  }var a = { TRANSITION_END: "bsTransitionEnd", getUID: function getUID(t) {
      do {
        t += ~ ~(1e6 * Math.random());
      } while (document.getElementById(t));return t;
    }, getSelectorFromElement: function getSelectorFromElement(t) {
      var e = t.getAttribute("data-target");if (!e || "#" === e) {
        var n = t.getAttribute("href");e = n && "#" !== n ? n.trim() : "";
      }try {
        return document.querySelector(e) ? e : null;
      } catch (t) {
        return null;
      }
    }, getTransitionDurationFromElement: function getTransitionDurationFromElement(t) {
      if (!t) return 0;var n = e(t).css("transition-duration"),
          i = e(t).css("transition-delay"),
          o = parseFloat(n),
          s = parseFloat(i);return o || s ? (n = n.split(",")[0], i = i.split(",")[0], 1e3 * (parseFloat(n) + parseFloat(i))) : 0;
    }, reflow: function reflow(t) {
      return t.offsetHeight;
    }, triggerTransitionEnd: function triggerTransitionEnd(t) {
      e(t).trigger("transitionend");
    }, supportsTransitionEnd: function supportsTransitionEnd() {
      return Boolean("transitionend");
    }, isElement: function isElement(t) {
      return (t[0] || t).nodeType;
    }, typeCheckConfig: function typeCheckConfig(t, e, n) {
      for (var i in n) if (Object.prototype.hasOwnProperty.call(n, i)) {
        var o = n[i],
            s = e[i],
            r = s && a.isElement(s) ? "element" : null === (l = s) || "undefined" == typeof l ? "" + l : ({}).toString.call(l).match(/\s([a-z]+)/i)[1].toLowerCase();if (!new RegExp(o).test(r)) throw new Error(t.toUpperCase() + ': Option "' + i + '" provided type "' + r + '" but expected type "' + o + '".');
      }var l;
    }, findShadowRoot: function findShadowRoot(t) {
      if (!document.documentElement.attachShadow) return null;if ("function" == typeof t.getRootNode) {
        var e = t.getRootNode();return e instanceof ShadowRoot ? e : null;
      }return t instanceof ShadowRoot ? t : t.parentNode ? a.findShadowRoot(t.parentNode) : null;
    }, jQueryDetection: function jQueryDetection() {
      if ("undefined" == typeof e) throw new TypeError("Bootstrap's JavaScript requires jQuery. jQuery must be included before Bootstrap's JavaScript.");var t = e.fn.jquery.split(" ")[0].split(".");if (t[0] < 2 && t[1] < 9 || 1 === t[0] && 9 === t[1] && t[2] < 1 || t[0] >= 4) throw new Error("Bootstrap's JavaScript requires at least jQuery v1.9.1 but less than v4.0.0");
    } };a.jQueryDetection(), e.fn.emulateTransitionEnd = r, e.event.special[a.TRANSITION_END] = { bindType: "transitionend", delegateType: "transitionend", handle: function handle(t) {
      if (e(t.target).is(this)) return t.handleObj.handler.apply(this, arguments);
    } };var l = "alert",
      c = e.fn[l],
      h = (function () {
    function t(t) {
      this._element = t;
    }var n = t.prototype;return n.close = function (t) {
      var e = this._element;t && (e = this._getRootElement(t)), this._triggerCloseEvent(e).isDefaultPrevented() || this._removeElement(e);
    }, n.dispose = function () {
      e.removeData(this._element, "bs.alert"), this._element = null;
    }, n._getRootElement = function (t) {
      var n = a.getSelectorFromElement(t),
          i = !1;return n && (i = document.querySelector(n)), i || (i = e(t).closest(".alert")[0]), i;
    }, n._triggerCloseEvent = function (t) {
      var n = e.Event("close.bs.alert");return e(t).trigger(n), n;
    }, n._removeElement = function (t) {
      var n = this;if ((e(t).removeClass("show"), e(t).hasClass("fade"))) {
        var i = a.getTransitionDurationFromElement(t);e(t).one(a.TRANSITION_END, function (e) {
          return n._destroyElement(t, e);
        }).emulateTransitionEnd(i);
      } else this._destroyElement(t);
    }, n._destroyElement = function (t) {
      e(t).detach().trigger("closed.bs.alert").remove();
    }, t._jQueryInterface = function (n) {
      return this.each(function () {
        var i = e(this),
            o = i.data("bs.alert");o || (o = new t(this), i.data("bs.alert", o)), "close" === n && o[n](this);
      });
    }, t._handleDismiss = function (t) {
      return function (e) {
        e && e.preventDefault(), t.close(this);
      };
    }, o(t, null, [{ key: "VERSION", get: function get() {
        return "4.5.2";
      } }]), t;
  })();e(document).on("click.bs.alert.data-api", '[data-dismiss="alert"]', h._handleDismiss(new h())), e.fn[l] = h._jQueryInterface, e.fn[l].Constructor = h, e.fn[l].noConflict = function () {
    return e.fn[l] = c, h._jQueryInterface;
  };var u = e.fn.button,
      d = (function () {
    function t(t) {
      this._element = t;
    }var n = t.prototype;return n.toggle = function () {
      var t = !0,
          n = !0,
          i = e(this._element).closest('[data-toggle="buttons"]')[0];if (i) {
        var o = this._element.querySelector('input:not([type="hidden"])');if (o) {
          if ("radio" === o.type) if (o.checked && this._element.classList.contains("active")) t = !1;else {
            var s = i.querySelector(".active");s && e(s).removeClass("active");
          }t && ("checkbox" !== o.type && "radio" !== o.type || (o.checked = !this._element.classList.contains("active")), e(o).trigger("change")), o.focus(), n = !1;
        }
      }this._element.hasAttribute("disabled") || this._element.classList.contains("disabled") || (n && this._element.setAttribute("aria-pressed", !this._element.classList.contains("active")), t && e(this._element).toggleClass("active"));
    }, n.dispose = function () {
      e.removeData(this._element, "bs.button"), this._element = null;
    }, t._jQueryInterface = function (n) {
      return this.each(function () {
        var i = e(this).data("bs.button");i || (i = new t(this), e(this).data("bs.button", i)), "toggle" === n && i[n]();
      });
    }, o(t, null, [{ key: "VERSION", get: function get() {
        return "4.5.2";
      } }]), t;
  })();e(document).on("click.bs.button.data-api", '[data-toggle^="button"]', function (t) {
    var n = t.target,
        i = n;if ((e(n).hasClass("btn") || (n = e(n).closest(".btn")[0]), !n || n.hasAttribute("disabled") || n.classList.contains("disabled"))) t.preventDefault();else {
      var o = n.querySelector('input:not([type="hidden"])');if (o && (o.hasAttribute("disabled") || o.classList.contains("disabled"))) return void t.preventDefault();("LABEL" !== i.tagName || o && "checkbox" !== o.type) && d._jQueryInterface.call(e(n), "toggle");
    }
  }).on("focus.bs.button.data-api blur.bs.button.data-api", '[data-toggle^="button"]', function (t) {
    var n = e(t.target).closest(".btn")[0];e(n).toggleClass("focus", /^focus(in)?$/.test(t.type));
  }), e(window).on("load.bs.button.data-api", function () {
    for (var t = [].slice.call(document.querySelectorAll('[data-toggle="buttons"] .btn')), e = 0, n = t.length; e < n; e++) {
      var i = t[e],
          o = i.querySelector('input:not([type="hidden"])');o.checked || o.hasAttribute("checked") ? i.classList.add("active") : i.classList.remove("active");
    }for (var s = 0, r = (t = [].slice.call(document.querySelectorAll('[data-toggle="button"]'))).length; s < r; s++) {
      var a = t[s];"true" === a.getAttribute("aria-pressed") ? a.classList.add("active") : a.classList.remove("active");
    }
  }), e.fn.button = d._jQueryInterface, e.fn.button.Constructor = d, e.fn.button.noConflict = function () {
    return e.fn.button = u, d._jQueryInterface;
  };var f = "carousel",
      g = ".bs.carousel",
      m = e.fn[f],
      p = { interval: 5e3, keyboard: !0, slide: !1, pause: "hover", wrap: !0, touch: !0 },
      _ = { interval: "(number|boolean)", keyboard: "boolean", slide: "(boolean|string)", pause: "(string|boolean)", wrap: "boolean", touch: "boolean" },
      v = { TOUCH: "touch", PEN: "pen" },
      b = (function () {
    function t(t, e) {
      this._items = null, this._interval = null, this._activeElement = null, this._isPaused = !1, this._isSliding = !1, this.touchTimeout = null, this.touchStartX = 0, this.touchDeltaX = 0, this._config = this._getConfig(e), this._element = t, this._indicatorsElement = this._element.querySelector(".carousel-indicators"), this._touchSupported = "ontouchstart" in document.documentElement || navigator.maxTouchPoints > 0, this._pointerEvent = Boolean(window.PointerEvent || window.MSPointerEvent), this._addEventListeners();
    }var n = t.prototype;return n.next = function () {
      this._isSliding || this._slide("next");
    }, n.nextWhenVisible = function () {
      !document.hidden && e(this._element).is(":visible") && "hidden" !== e(this._element).css("visibility") && this.next();
    }, n.prev = function () {
      this._isSliding || this._slide("prev");
    }, n.pause = function (t) {
      t || (this._isPaused = !0), this._element.querySelector(".carousel-item-next, .carousel-item-prev") && (a.triggerTransitionEnd(this._element), this.cycle(!0)), clearInterval(this._interval), this._interval = null;
    }, n.cycle = function (t) {
      t || (this._isPaused = !1), this._interval && (clearInterval(this._interval), this._interval = null), this._config.interval && !this._isPaused && (this._interval = setInterval((document.visibilityState ? this.nextWhenVisible : this.next).bind(this), this._config.interval));
    }, n.to = function (t) {
      var n = this;this._activeElement = this._element.querySelector(".active.carousel-item");var i = this._getItemIndex(this._activeElement);if (!(t > this._items.length - 1 || t < 0)) if (this._isSliding) e(this._element).one("slid.bs.carousel", function () {
        return n.to(t);
      });else {
        if (i === t) return this.pause(), void this.cycle();var o = t > i ? "next" : "prev";this._slide(o, this._items[t]);
      }
    }, n.dispose = function () {
      e(this._element).off(g), e.removeData(this._element, "bs.carousel"), this._items = null, this._config = null, this._element = null, this._interval = null, this._isPaused = null, this._isSliding = null, this._activeElement = null, this._indicatorsElement = null;
    }, n._getConfig = function (t) {
      return t = s({}, p, t), a.typeCheckConfig(f, t, _), t;
    }, n._handleSwipe = function () {
      var t = Math.abs(this.touchDeltaX);if (!(t <= 40)) {
        var e = t / this.touchDeltaX;this.touchDeltaX = 0, e > 0 && this.prev(), e < 0 && this.next();
      }
    }, n._addEventListeners = function () {
      var t = this;this._config.keyboard && e(this._element).on("keydown.bs.carousel", function (e) {
        return t._keydown(e);
      }), "hover" === this._config.pause && e(this._element).on("mouseenter.bs.carousel", function (e) {
        return t.pause(e);
      }).on("mouseleave.bs.carousel", function (e) {
        return t.cycle(e);
      }), this._config.touch && this._addTouchEventListeners();
    }, n._addTouchEventListeners = function () {
      var t = this;if (this._touchSupported) {
        var n = function n(e) {
          t._pointerEvent && v[e.originalEvent.pointerType.toUpperCase()] ? t.touchStartX = e.originalEvent.clientX : t._pointerEvent || (t.touchStartX = e.originalEvent.touches[0].clientX);
        },
            i = function i(e) {
          t._pointerEvent && v[e.originalEvent.pointerType.toUpperCase()] && (t.touchDeltaX = e.originalEvent.clientX - t.touchStartX), t._handleSwipe(), "hover" === t._config.pause && (t.pause(), t.touchTimeout && clearTimeout(t.touchTimeout), t.touchTimeout = setTimeout(function (e) {
            return t.cycle(e);
          }, 500 + t._config.interval));
        };e(this._element.querySelectorAll(".carousel-item img")).on("dragstart.bs.carousel", function (t) {
          return t.preventDefault();
        }), this._pointerEvent ? (e(this._element).on("pointerdown.bs.carousel", function (t) {
          return n(t);
        }), e(this._element).on("pointerup.bs.carousel", function (t) {
          return i(t);
        }), this._element.classList.add("pointer-event")) : (e(this._element).on("touchstart.bs.carousel", function (t) {
          return n(t);
        }), e(this._element).on("touchmove.bs.carousel", function (e) {
          return (function (e) {
            e.originalEvent.touches && e.originalEvent.touches.length > 1 ? t.touchDeltaX = 0 : t.touchDeltaX = e.originalEvent.touches[0].clientX - t.touchStartX;
          })(e);
        }), e(this._element).on("touchend.bs.carousel", function (t) {
          return i(t);
        }));
      }
    }, n._keydown = function (t) {
      if (!/input|textarea/i.test(t.target.tagName)) switch (t.which) {case 37:
          t.preventDefault(), this.prev();break;case 39:
          t.preventDefault(), this.next();}
    }, n._getItemIndex = function (t) {
      return this._items = t && t.parentNode ? [].slice.call(t.parentNode.querySelectorAll(".carousel-item")) : [], this._items.indexOf(t);
    }, n._getItemByDirection = function (t, e) {
      var n = "next" === t,
          i = "prev" === t,
          o = this._getItemIndex(e),
          s = this._items.length - 1;if ((i && 0 === o || n && o === s) && !this._config.wrap) return e;var r = (o + ("prev" === t ? -1 : 1)) % this._items.length;return -1 === r ? this._items[this._items.length - 1] : this._items[r];
    }, n._triggerSlideEvent = function (t, n) {
      var i = this._getItemIndex(t),
          o = this._getItemIndex(this._element.querySelector(".active.carousel-item")),
          s = e.Event("slide.bs.carousel", { relatedTarget: t, direction: n, from: o, to: i });return e(this._element).trigger(s), s;
    }, n._setActiveIndicatorElement = function (t) {
      if (this._indicatorsElement) {
        var n = [].slice.call(this._indicatorsElement.querySelectorAll(".active"));e(n).removeClass("active");var i = this._indicatorsElement.children[this._getItemIndex(t)];i && e(i).addClass("active");
      }
    }, n._slide = function (t, n) {
      var i,
          o,
          s,
          r = this,
          l = this._element.querySelector(".active.carousel-item"),
          c = this._getItemIndex(l),
          h = n || l && this._getItemByDirection(t, l),
          u = this._getItemIndex(h),
          d = Boolean(this._interval);if (("next" === t ? (i = "carousel-item-left", o = "carousel-item-next", s = "left") : (i = "carousel-item-right", o = "carousel-item-prev", s = "right"), h && e(h).hasClass("active"))) this._isSliding = !1;else if (!this._triggerSlideEvent(h, s).isDefaultPrevented() && l && h) {
        this._isSliding = !0, d && this.pause(), this._setActiveIndicatorElement(h);var f = e.Event("slid.bs.carousel", { relatedTarget: h, direction: s, from: c, to: u });if (e(this._element).hasClass("slide")) {
          e(h).addClass(o), a.reflow(h), e(l).addClass(i), e(h).addClass(i);var g = parseInt(h.getAttribute("data-interval"), 10);g ? (this._config.defaultInterval = this._config.defaultInterval || this._config.interval, this._config.interval = g) : this._config.interval = this._config.defaultInterval || this._config.interval;var m = a.getTransitionDurationFromElement(l);e(l).one(a.TRANSITION_END, function () {
            e(h).removeClass(i + " " + o).addClass("active"), e(l).removeClass("active " + o + " " + i), r._isSliding = !1, setTimeout(function () {
              return e(r._element).trigger(f);
            }, 0);
          }).emulateTransitionEnd(m);
        } else e(l).removeClass("active"), e(h).addClass("active"), this._isSliding = !1, e(this._element).trigger(f);d && this.cycle();
      }
    }, t._jQueryInterface = function (n) {
      return this.each(function () {
        var i = e(this).data("bs.carousel"),
            o = s({}, p, e(this).data());"object" == typeof n && (o = s({}, o, n));var r = "string" == typeof n ? n : o.slide;if ((i || (i = new t(this, o), e(this).data("bs.carousel", i)), "number" == typeof n)) i.to(n);else if ("string" == typeof r) {
          if ("undefined" == typeof i[r]) throw new TypeError('No method named "' + r + '"');i[r]();
        } else o.interval && o.ride && (i.pause(), i.cycle());
      });
    }, t._dataApiClickHandler = function (n) {
      var i = a.getSelectorFromElement(this);if (i) {
        var o = e(i)[0];if (o && e(o).hasClass("carousel")) {
          var r = s({}, e(o).data(), e(this).data()),
              l = this.getAttribute("data-slide-to");l && (r.interval = !1), t._jQueryInterface.call(e(o), r), l && e(o).data("bs.carousel").to(l), n.preventDefault();
        }
      }
    }, o(t, null, [{ key: "VERSION", get: function get() {
        return "4.5.2";
      } }, { key: "Default", get: function get() {
        return p;
      } }]), t;
  })();e(document).on("click.bs.carousel.data-api", "[data-slide], [data-slide-to]", b._dataApiClickHandler), e(window).on("load.bs.carousel.data-api", function () {
    for (var t = [].slice.call(document.querySelectorAll('[data-ride="carousel"]')), n = 0, i = t.length; n < i; n++) {
      var o = e(t[n]);b._jQueryInterface.call(o, o.data());
    }
  }), e.fn[f] = b._jQueryInterface, e.fn[f].Constructor = b, e.fn[f].noConflict = function () {
    return e.fn[f] = m, b._jQueryInterface;
  };var y = "collapse",
      E = e.fn[y],
      w = { toggle: !0, parent: "" },
      T = { toggle: "boolean", parent: "(string|element)" },
      C = (function () {
    function t(t, e) {
      this._isTransitioning = !1, this._element = t, this._config = this._getConfig(e), this._triggerArray = [].slice.call(document.querySelectorAll('[data-toggle="collapse"][href="#' + t.id + '"],[data-toggle="collapse"][data-target="#' + t.id + '"]'));for (var n = [].slice.call(document.querySelectorAll('[data-toggle="collapse"]')), i = 0, o = n.length; i < o; i++) {
        var s = n[i],
            r = a.getSelectorFromElement(s),
            l = [].slice.call(document.querySelectorAll(r)).filter(function (e) {
          return e === t;
        });null !== r && l.length > 0 && (this._selector = r, this._triggerArray.push(s));
      }this._parent = this._config.parent ? this._getParent() : null, this._config.parent || this._addAriaAndCollapsedClass(this._element, this._triggerArray), this._config.toggle && this.toggle();
    }var n = t.prototype;return n.toggle = function () {
      e(this._element).hasClass("show") ? this.hide() : this.show();
    }, n.show = function () {
      var n,
          i,
          o = this;if (!this._isTransitioning && !e(this._element).hasClass("show") && (this._parent && 0 === (n = [].slice.call(this._parent.querySelectorAll(".show, .collapsing")).filter(function (t) {
        return "string" == typeof o._config.parent ? t.getAttribute("data-parent") === o._config.parent : t.classList.contains("collapse");
      })).length && (n = null), !(n && (i = e(n).not(this._selector).data("bs.collapse")) && i._isTransitioning))) {
        var s = e.Event("show.bs.collapse");if ((e(this._element).trigger(s), !s.isDefaultPrevented())) {
          n && (t._jQueryInterface.call(e(n).not(this._selector), "hide"), i || e(n).data("bs.collapse", null));var r = this._getDimension();e(this._element).removeClass("collapse").addClass("collapsing"), this._element.style[r] = 0, this._triggerArray.length && e(this._triggerArray).removeClass("collapsed").attr("aria-expanded", !0), this.setTransitioning(!0);var l = "scroll" + (r[0].toUpperCase() + r.slice(1)),
              c = a.getTransitionDurationFromElement(this._element);e(this._element).one(a.TRANSITION_END, function () {
            e(o._element).removeClass("collapsing").addClass("collapse show"), o._element.style[r] = "", o.setTransitioning(!1), e(o._element).trigger("shown.bs.collapse");
          }).emulateTransitionEnd(c), this._element.style[r] = this._element[l] + "px";
        }
      }
    }, n.hide = function () {
      var t = this;if (!this._isTransitioning && e(this._element).hasClass("show")) {
        var n = e.Event("hide.bs.collapse");if ((e(this._element).trigger(n), !n.isDefaultPrevented())) {
          var i = this._getDimension();this._element.style[i] = this._element.getBoundingClientRect()[i] + "px", a.reflow(this._element), e(this._element).addClass("collapsing").removeClass("collapse show");var o = this._triggerArray.length;if (o > 0) for (var s = 0; s < o; s++) {
            var r = this._triggerArray[s],
                l = a.getSelectorFromElement(r);if (null !== l) e([].slice.call(document.querySelectorAll(l))).hasClass("show") || e(r).addClass("collapsed").attr("aria-expanded", !1);
          }this.setTransitioning(!0);this._element.style[i] = "";var c = a.getTransitionDurationFromElement(this._element);e(this._element).one(a.TRANSITION_END, function () {
            t.setTransitioning(!1), e(t._element).removeClass("collapsing").addClass("collapse").trigger("hidden.bs.collapse");
          }).emulateTransitionEnd(c);
        }
      }
    }, n.setTransitioning = function (t) {
      this._isTransitioning = t;
    }, n.dispose = function () {
      e.removeData(this._element, "bs.collapse"), this._config = null, this._parent = null, this._element = null, this._triggerArray = null, this._isTransitioning = null;
    }, n._getConfig = function (t) {
      return (t = s({}, w, t)).toggle = Boolean(t.toggle), a.typeCheckConfig(y, t, T), t;
    }, n._getDimension = function () {
      return e(this._element).hasClass("width") ? "width" : "height";
    }, n._getParent = function () {
      var n,
          i = this;a.isElement(this._config.parent) ? (n = this._config.parent, "undefined" != typeof this._config.parent.jquery && (n = this._config.parent[0])) : n = document.querySelector(this._config.parent);var o = '[data-toggle="collapse"][data-parent="' + this._config.parent + '"]',
          s = [].slice.call(n.querySelectorAll(o));return e(s).each(function (e, n) {
        i._addAriaAndCollapsedClass(t._getTargetFromElement(n), [n]);
      }), n;
    }, n._addAriaAndCollapsedClass = function (t, n) {
      var i = e(t).hasClass("show");n.length && e(n).toggleClass("collapsed", !i).attr("aria-expanded", i);
    }, t._getTargetFromElement = function (t) {
      var e = a.getSelectorFromElement(t);return e ? document.querySelector(e) : null;
    }, t._jQueryInterface = function (n) {
      return this.each(function () {
        var i = e(this),
            o = i.data("bs.collapse"),
            r = s({}, w, i.data(), "object" == typeof n && n ? n : {});if ((!o && r.toggle && "string" == typeof n && /show|hide/.test(n) && (r.toggle = !1), o || (o = new t(this, r), i.data("bs.collapse", o)), "string" == typeof n)) {
          if ("undefined" == typeof o[n]) throw new TypeError('No method named "' + n + '"');o[n]();
        }
      });
    }, o(t, null, [{ key: "VERSION", get: function get() {
        return "4.5.2";
      } }, { key: "Default", get: function get() {
        return w;
      } }]), t;
  })();e(document).on("click.bs.collapse.data-api", '[data-toggle="collapse"]', function (t) {
    "A" === t.currentTarget.tagName && t.preventDefault();var n = e(this),
        i = a.getSelectorFromElement(this),
        o = [].slice.call(document.querySelectorAll(i));e(o).each(function () {
      var t = e(this),
          i = t.data("bs.collapse") ? "toggle" : n.data();C._jQueryInterface.call(t, i);
    });
  }), e.fn[y] = C._jQueryInterface, e.fn[y].Constructor = C, e.fn[y].noConflict = function () {
    return e.fn[y] = E, C._jQueryInterface;
  };var S = "dropdown",
      k = e.fn[S],
      D = new RegExp("38|40|27"),
      N = { offset: 0, flip: !0, boundary: "scrollParent", reference: "toggle", display: "dynamic", popperConfig: null },
      A = { offset: "(number|string|function)", flip: "boolean", boundary: "(string|element)", reference: "(string|element)", display: "string", popperConfig: "(null|object)" },
      I = (function () {
    function t(t, e) {
      this._element = t, this._popper = null, this._config = this._getConfig(e), this._menu = this._getMenuElement(), this._inNavbar = this._detectNavbar(), this._addEventListeners();
    }var i = t.prototype;return i.toggle = function () {
      if (!this._element.disabled && !e(this._element).hasClass("disabled")) {
        var n = e(this._menu).hasClass("show");t._clearMenus(), n || this.show(!0);
      }
    }, i.show = function (i) {
      if ((void 0 === i && (i = !1), !(this._element.disabled || e(this._element).hasClass("disabled") || e(this._menu).hasClass("show")))) {
        var o = { relatedTarget: this._element },
            s = e.Event("show.bs.dropdown", o),
            r = t._getParentFromElement(this._element);if ((e(r).trigger(s), !s.isDefaultPrevented())) {
          if (!this._inNavbar && i) {
            if ("undefined" == typeof n) throw new TypeError("Bootstrap's dropdowns require Popper.js (https://popper.js.org/)");var l = this._element;"parent" === this._config.reference ? l = r : a.isElement(this._config.reference) && (l = this._config.reference, "undefined" != typeof this._config.reference.jquery && (l = this._config.reference[0])), "scrollParent" !== this._config.boundary && e(r).addClass("position-static"), this._popper = new n(l, this._menu, this._getPopperConfig());
          }"ontouchstart" in document.documentElement && 0 === e(r).closest(".navbar-nav").length && e(document.body).children().on("mouseover", null, e.noop), this._element.focus(), this._element.setAttribute("aria-expanded", !0), e(this._menu).toggleClass("show"), e(r).toggleClass("show").trigger(e.Event("shown.bs.dropdown", o));
        }
      }
    }, i.hide = function () {
      if (!this._element.disabled && !e(this._element).hasClass("disabled") && e(this._menu).hasClass("show")) {
        var n = { relatedTarget: this._element },
            i = e.Event("hide.bs.dropdown", n),
            o = t._getParentFromElement(this._element);e(o).trigger(i), i.isDefaultPrevented() || (this._popper && this._popper.destroy(), e(this._menu).toggleClass("show"), e(o).toggleClass("show").trigger(e.Event("hidden.bs.dropdown", n)));
      }
    }, i.dispose = function () {
      e.removeData(this._element, "bs.dropdown"), e(this._element).off(".bs.dropdown"), this._element = null, this._menu = null, null !== this._popper && (this._popper.destroy(), this._popper = null);
    }, i.update = function () {
      this._inNavbar = this._detectNavbar(), null !== this._popper && this._popper.scheduleUpdate();
    }, i._addEventListeners = function () {
      var t = this;e(this._element).on("click.bs.dropdown", function (e) {
        e.preventDefault(), e.stopPropagation(), t.toggle();
      });
    }, i._getConfig = function (t) {
      return t = s({}, this.constructor.Default, e(this._element).data(), t), a.typeCheckConfig(S, t, this.constructor.DefaultType), t;
    }, i._getMenuElement = function () {
      if (!this._menu) {
        var e = t._getParentFromElement(this._element);e && (this._menu = e.querySelector(".dropdown-menu"));
      }return this._menu;
    }, i._getPlacement = function () {
      var t = e(this._element.parentNode),
          n = "bottom-start";return t.hasClass("dropup") ? n = e(this._menu).hasClass("dropdown-menu-right") ? "top-end" : "top-start" : t.hasClass("dropright") ? n = "right-start" : t.hasClass("dropleft") ? n = "left-start" : e(this._menu).hasClass("dropdown-menu-right") && (n = "bottom-end"), n;
    }, i._detectNavbar = function () {
      return e(this._element).closest(".navbar").length > 0;
    }, i._getOffset = function () {
      var t = this,
          e = {};return "function" == typeof this._config.offset ? e.fn = function (e) {
        return e.offsets = s({}, e.offsets, t._config.offset(e.offsets, t._element) || {}), e;
      } : e.offset = this._config.offset, e;
    }, i._getPopperConfig = function () {
      var t = { placement: this._getPlacement(), modifiers: { offset: this._getOffset(), flip: { enabled: this._config.flip }, preventOverflow: { boundariesElement: this._config.boundary } } };return "static" === this._config.display && (t.modifiers.applyStyle = { enabled: !1 }), s({}, t, this._config.popperConfig);
    }, t._jQueryInterface = function (n) {
      return this.each(function () {
        var i = e(this).data("bs.dropdown");if ((i || (i = new t(this, "object" == typeof n ? n : null), e(this).data("bs.dropdown", i)), "string" == typeof n)) {
          if ("undefined" == typeof i[n]) throw new TypeError('No method named "' + n + '"');i[n]();
        }
      });
    }, t._clearMenus = function (n) {
      if (!n || 3 !== n.which && ("keyup" !== n.type || 9 === n.which)) for (var i = [].slice.call(document.querySelectorAll('[data-toggle="dropdown"]')), o = 0, s = i.length; o < s; o++) {
        var r = t._getParentFromElement(i[o]),
            a = e(i[o]).data("bs.dropdown"),
            l = { relatedTarget: i[o] };if ((n && "click" === n.type && (l.clickEvent = n), a)) {
          var c = a._menu;if (e(r).hasClass("show") && !(n && ("click" === n.type && /input|textarea/i.test(n.target.tagName) || "keyup" === n.type && 9 === n.which) && e.contains(r, n.target))) {
            var h = e.Event("hide.bs.dropdown", l);e(r).trigger(h), h.isDefaultPrevented() || ("ontouchstart" in document.documentElement && e(document.body).children().off("mouseover", null, e.noop), i[o].setAttribute("aria-expanded", "false"), a._popper && a._popper.destroy(), e(c).removeClass("show"), e(r).removeClass("show").trigger(e.Event("hidden.bs.dropdown", l)));
          }
        }
      }
    }, t._getParentFromElement = function (t) {
      var e,
          n = a.getSelectorFromElement(t);return n && (e = document.querySelector(n)), e || t.parentNode;
    }, t._dataApiKeydownHandler = function (n) {
      if (!(/input|textarea/i.test(n.target.tagName) ? 32 === n.which || 27 !== n.which && (40 !== n.which && 38 !== n.which || e(n.target).closest(".dropdown-menu").length) : !D.test(n.which)) && !this.disabled && !e(this).hasClass("disabled")) {
        var i = t._getParentFromElement(this),
            o = e(i).hasClass("show");if (o || 27 !== n.which) {
          if ((n.preventDefault(), n.stopPropagation(), !o || o && (27 === n.which || 32 === n.which))) return 27 === n.which && e(i.querySelector('[data-toggle="dropdown"]')).trigger("focus"), void e(this).trigger("click");var s = [].slice.call(i.querySelectorAll(".dropdown-menu .dropdown-item:not(.disabled):not(:disabled)")).filter(function (t) {
            return e(t).is(":visible");
          });if (0 !== s.length) {
            var r = s.indexOf(n.target);38 === n.which && r > 0 && r--, 40 === n.which && r < s.length - 1 && r++, r < 0 && (r = 0), s[r].focus();
          }
        }
      }
    }, o(t, null, [{ key: "VERSION", get: function get() {
        return "4.5.2";
      } }, { key: "Default", get: function get() {
        return N;
      } }, { key: "DefaultType", get: function get() {
        return A;
      } }]), t;
  })();e(document).on("keydown.bs.dropdown.data-api", '[data-toggle="dropdown"]', I._dataApiKeydownHandler).on("keydown.bs.dropdown.data-api", ".dropdown-menu", I._dataApiKeydownHandler).on("click.bs.dropdown.data-api keyup.bs.dropdown.data-api", I._clearMenus).on("click.bs.dropdown.data-api", '[data-toggle="dropdown"]', function (t) {
    t.preventDefault(), t.stopPropagation(), I._jQueryInterface.call(e(this), "toggle");
  }).on("click.bs.dropdown.data-api", ".dropdown form", function (t) {
    t.stopPropagation();
  }), e.fn[S] = I._jQueryInterface, e.fn[S].Constructor = I, e.fn[S].noConflict = function () {
    return e.fn[S] = k, I._jQueryInterface;
  };var O = e.fn.modal,
      j = { backdrop: !0, keyboard: !0, focus: !0, show: !0 },
      x = { backdrop: "(boolean|string)", keyboard: "boolean", focus: "boolean", show: "boolean" },
      P = (function () {
    function t(t, e) {
      this._config = this._getConfig(e), this._element = t, this._dialog = t.querySelector(".modal-dialog"), this._backdrop = null, this._isShown = !1, this._isBodyOverflowing = !1, this._ignoreBackdropClick = !1, this._isTransitioning = !1, this._scrollbarWidth = 0;
    }var n = t.prototype;return n.toggle = function (t) {
      return this._isShown ? this.hide() : this.show(t);
    }, n.show = function (t) {
      var n = this;if (!this._isShown && !this._isTransitioning) {
        e(this._element).hasClass("fade") && (this._isTransitioning = !0);var i = e.Event("show.bs.modal", { relatedTarget: t });e(this._element).trigger(i), this._isShown || i.isDefaultPrevented() || (this._isShown = !0, this._checkScrollbar(), this._setScrollbar(), this._adjustDialog(), this._setEscapeEvent(), this._setResizeEvent(), e(this._element).on("click.dismiss.bs.modal", '[data-dismiss="modal"]', function (t) {
          return n.hide(t);
        }), e(this._dialog).on("mousedown.dismiss.bs.modal", function () {
          e(n._element).one("mouseup.dismiss.bs.modal", function (t) {
            e(t.target).is(n._element) && (n._ignoreBackdropClick = !0);
          });
        }), this._showBackdrop(function () {
          return n._showElement(t);
        }));
      }
    }, n.hide = function (t) {
      var n = this;if ((t && t.preventDefault(), this._isShown && !this._isTransitioning)) {
        var i = e.Event("hide.bs.modal");if ((e(this._element).trigger(i), this._isShown && !i.isDefaultPrevented())) {
          this._isShown = !1;var o = e(this._element).hasClass("fade");if ((o && (this._isTransitioning = !0), this._setEscapeEvent(), this._setResizeEvent(), e(document).off("focusin.bs.modal"), e(this._element).removeClass("show"), e(this._element).off("click.dismiss.bs.modal"), e(this._dialog).off("mousedown.dismiss.bs.modal"), o)) {
            var s = a.getTransitionDurationFromElement(this._element);e(this._element).one(a.TRANSITION_END, function (t) {
              return n._hideModal(t);
            }).emulateTransitionEnd(s);
          } else this._hideModal();
        }
      }
    }, n.dispose = function () {
      [window, this._element, this._dialog].forEach(function (t) {
        return e(t).off(".bs.modal");
      }), e(document).off("focusin.bs.modal"), e.removeData(this._element, "bs.modal"), this._config = null, this._element = null, this._dialog = null, this._backdrop = null, this._isShown = null, this._isBodyOverflowing = null, this._ignoreBackdropClick = null, this._isTransitioning = null, this._scrollbarWidth = null;
    }, n.handleUpdate = function () {
      this._adjustDialog();
    }, n._getConfig = function (t) {
      return t = s({}, j, t), a.typeCheckConfig("modal", t, x), t;
    }, n._triggerBackdropTransition = function () {
      var t = this;if ("static" === this._config.backdrop) {
        var n = e.Event("hidePrevented.bs.modal");if ((e(this._element).trigger(n), n.defaultPrevented)) return;var i = this._element.scrollHeight > document.documentElement.clientHeight;i || (this._element.style.overflowY = "hidden"), this._element.classList.add("modal-static");var o = a.getTransitionDurationFromElement(this._dialog);e(this._element).off(a.TRANSITION_END), e(this._element).one(a.TRANSITION_END, function () {
          t._element.classList.remove("modal-static"), i || e(t._element).one(a.TRANSITION_END, function () {
            t._element.style.overflowY = "";
          }).emulateTransitionEnd(t._element, o);
        }).emulateTransitionEnd(o), this._element.focus();
      } else this.hide();
    }, n._showElement = function (t) {
      var n = this,
          i = e(this._element).hasClass("fade"),
          o = this._dialog ? this._dialog.querySelector(".modal-body") : null;this._element.parentNode && this._element.parentNode.nodeType === Node.ELEMENT_NODE || document.body.appendChild(this._element), this._element.style.display = "block", this._element.removeAttribute("aria-hidden"), this._element.setAttribute("aria-modal", !0), this._element.setAttribute("role", "dialog"), e(this._dialog).hasClass("modal-dialog-scrollable") && o ? o.scrollTop = 0 : this._element.scrollTop = 0, i && a.reflow(this._element), e(this._element).addClass("show"), this._config.focus && this._enforceFocus();var s = e.Event("shown.bs.modal", { relatedTarget: t }),
          r = function r() {
        n._config.focus && n._element.focus(), n._isTransitioning = !1, e(n._element).trigger(s);
      };if (i) {
        var l = a.getTransitionDurationFromElement(this._dialog);e(this._dialog).one(a.TRANSITION_END, r).emulateTransitionEnd(l);
      } else r();
    }, n._enforceFocus = function () {
      var t = this;e(document).off("focusin.bs.modal").on("focusin.bs.modal", function (n) {
        document !== n.target && t._element !== n.target && 0 === e(t._element).has(n.target).length && t._element.focus();
      });
    }, n._setEscapeEvent = function () {
      var t = this;this._isShown ? e(this._element).on("keydown.dismiss.bs.modal", function (e) {
        t._config.keyboard && 27 === e.which ? (e.preventDefault(), t.hide()) : t._config.keyboard || 27 !== e.which || t._triggerBackdropTransition();
      }) : this._isShown || e(this._element).off("keydown.dismiss.bs.modal");
    }, n._setResizeEvent = function () {
      var t = this;this._isShown ? e(window).on("resize.bs.modal", function (e) {
        return t.handleUpdate(e);
      }) : e(window).off("resize.bs.modal");
    }, n._hideModal = function () {
      var t = this;this._element.style.display = "none", this._element.setAttribute("aria-hidden", !0), this._element.removeAttribute("aria-modal"), this._element.removeAttribute("role"), this._isTransitioning = !1, this._showBackdrop(function () {
        e(document.body).removeClass("modal-open"), t._resetAdjustments(), t._resetScrollbar(), e(t._element).trigger("hidden.bs.modal");
      });
    }, n._removeBackdrop = function () {
      this._backdrop && (e(this._backdrop).remove(), this._backdrop = null);
    }, n._showBackdrop = function (t) {
      var n = this,
          i = e(this._element).hasClass("fade") ? "fade" : "";if (this._isShown && this._config.backdrop) {
        if ((this._backdrop = document.createElement("div"), this._backdrop.className = "modal-backdrop", i && this._backdrop.classList.add(i), e(this._backdrop).appendTo(document.body), e(this._element).on("click.dismiss.bs.modal", function (t) {
          n._ignoreBackdropClick ? n._ignoreBackdropClick = !1 : t.target === t.currentTarget && n._triggerBackdropTransition();
        }), i && a.reflow(this._backdrop), e(this._backdrop).addClass("show"), !t)) return;if (!i) return void t();var o = a.getTransitionDurationFromElement(this._backdrop);e(this._backdrop).one(a.TRANSITION_END, t).emulateTransitionEnd(o);
      } else if (!this._isShown && this._backdrop) {
        e(this._backdrop).removeClass("show");var s = function s() {
          n._removeBackdrop(), t && t();
        };if (e(this._element).hasClass("fade")) {
          var r = a.getTransitionDurationFromElement(this._backdrop);e(this._backdrop).one(a.TRANSITION_END, s).emulateTransitionEnd(r);
        } else s();
      } else t && t();
    }, n._adjustDialog = function () {
      var t = this._element.scrollHeight > document.documentElement.clientHeight;!this._isBodyOverflowing && t && (this._element.style.paddingLeft = this._scrollbarWidth + "px"), this._isBodyOverflowing && !t && (this._element.style.paddingRight = this._scrollbarWidth + "px");
    }, n._resetAdjustments = function () {
      this._element.style.paddingLeft = "", this._element.style.paddingRight = "";
    }, n._checkScrollbar = function () {
      var t = document.body.getBoundingClientRect();this._isBodyOverflowing = Math.round(t.left + t.right) < window.innerWidth, this._scrollbarWidth = this._getScrollbarWidth();
    }, n._setScrollbar = function () {
      var t = this;if (this._isBodyOverflowing) {
        var n = [].slice.call(document.querySelectorAll(".fixed-top, .fixed-bottom, .is-fixed, .sticky-top")),
            i = [].slice.call(document.querySelectorAll(".sticky-top"));e(n).each(function (n, i) {
          var o = i.style.paddingRight,
              s = e(i).css("padding-right");e(i).data("padding-right", o).css("padding-right", parseFloat(s) + t._scrollbarWidth + "px");
        }), e(i).each(function (n, i) {
          var o = i.style.marginRight,
              s = e(i).css("margin-right");e(i).data("margin-right", o).css("margin-right", parseFloat(s) - t._scrollbarWidth + "px");
        });var o = document.body.style.paddingRight,
            s = e(document.body).css("padding-right");e(document.body).data("padding-right", o).css("padding-right", parseFloat(s) + this._scrollbarWidth + "px");
      }e(document.body).addClass("modal-open");
    }, n._resetScrollbar = function () {
      var t = [].slice.call(document.querySelectorAll(".fixed-top, .fixed-bottom, .is-fixed, .sticky-top"));e(t).each(function (t, n) {
        var i = e(n).data("padding-right");e(n).removeData("padding-right"), n.style.paddingRight = i || "";
      });var n = [].slice.call(document.querySelectorAll(".sticky-top"));e(n).each(function (t, n) {
        var i = e(n).data("margin-right");"undefined" != typeof i && e(n).css("margin-right", i).removeData("margin-right");
      });var i = e(document.body).data("padding-right");e(document.body).removeData("padding-right"), document.body.style.paddingRight = i || "";
    }, n._getScrollbarWidth = function () {
      var t = document.createElement("div");t.className = "modal-scrollbar-measure", document.body.appendChild(t);var e = t.getBoundingClientRect().width - t.clientWidth;return document.body.removeChild(t), e;
    }, t._jQueryInterface = function (n, i) {
      return this.each(function () {
        var o = e(this).data("bs.modal"),
            r = s({}, j, e(this).data(), "object" == typeof n && n ? n : {});if ((o || (o = new t(this, r), e(this).data("bs.modal", o)), "string" == typeof n)) {
          if ("undefined" == typeof o[n]) throw new TypeError('No method named "' + n + '"');o[n](i);
        } else r.show && o.show(i);
      });
    }, o(t, null, [{ key: "VERSION", get: function get() {
        return "4.5.2";
      } }, { key: "Default", get: function get() {
        return j;
      } }]), t;
  })();e(document).on("click.bs.modal.data-api", '[data-toggle="modal"]', function (t) {
    var n,
        i = this,
        o = a.getSelectorFromElement(this);o && (n = document.querySelector(o));var r = e(n).data("bs.modal") ? "toggle" : s({}, e(n).data(), e(this).data());"A" !== this.tagName && "AREA" !== this.tagName || t.preventDefault();var l = e(n).one("show.bs.modal", function (t) {
      t.isDefaultPrevented() || l.one("hidden.bs.modal", function () {
        e(i).is(":visible") && i.focus();
      });
    });P._jQueryInterface.call(e(n), r, this);
  }), e.fn.modal = P._jQueryInterface, e.fn.modal.Constructor = P, e.fn.modal.noConflict = function () {
    return e.fn.modal = O, P._jQueryInterface;
  };var R = ["background", "cite", "href", "itemtype", "longdesc", "poster", "src", "xlink:href"],
      L = { "*": ["class", "dir", "id", "lang", "role", /^aria-[\w-]*$/i], a: ["target", "href", "title", "rel"], area: [], b: [], br: [], col: [], code: [], div: [], em: [], hr: [], h1: [], h2: [], h3: [], h4: [], h5: [], h6: [], i: [], img: ["src", "srcset", "alt", "title", "width", "height"], li: [], ol: [], p: [], pre: [], s: [], small: [], span: [], sub: [], sup: [], strong: [], u: [], ul: [] },
      q = /^(?:(?:https?|mailto|ftp|tel|file):|[^#&/:?]*(?:[#/?]|$))/gi,
      F = /^data:(?:image\/(?:bmp|gif|jpeg|jpg|png|tiff|webp)|video\/(?:mpeg|mp4|ogg|webm)|audio\/(?:mp3|oga|ogg|opus));base64,[\d+/a-z]+=*$/i;function Q(t, e, n) {
    if (0 === t.length) return t;if (n && "function" == typeof n) return n(t);for (var i = new window.DOMParser().parseFromString(t, "text/html"), o = Object.keys(e), s = [].slice.call(i.body.querySelectorAll("*")), r = function r(t, n) {
      var i = s[t],
          r = i.nodeName.toLowerCase();if (-1 === o.indexOf(i.nodeName.toLowerCase())) return i.parentNode.removeChild(i), "continue";var a = [].slice.call(i.attributes),
          l = [].concat(e["*"] || [], e[r] || []);a.forEach(function (t) {
        (function (t, e) {
          var n = t.nodeName.toLowerCase();if (-1 !== e.indexOf(n)) return -1 === R.indexOf(n) || Boolean(t.nodeValue.match(q) || t.nodeValue.match(F));for (var i = e.filter(function (t) {
            return t instanceof RegExp;
          }), o = 0, s = i.length; o < s; o++) if (n.match(i[o])) return !0;return !1;
        })(t, l) || i.removeAttribute(t.nodeName);
      });
    }, a = 0, l = s.length; a < l; a++) r(a);return i.body.innerHTML;
  }var B = "tooltip",
      H = e.fn[B],
      U = new RegExp("(^|\\s)bs-tooltip\\S+", "g"),
      M = ["sanitize", "whiteList", "sanitizeFn"],
      W = { animation: "boolean", template: "string", title: "(string|element|function)", trigger: "string", delay: "(number|object)", html: "boolean", selector: "(string|boolean)", placement: "(string|function)", offset: "(number|string|function)", container: "(string|element|boolean)", fallbackPlacement: "(string|array)", boundary: "(string|element)", sanitize: "boolean", sanitizeFn: "(null|function)", whiteList: "object", popperConfig: "(null|object)" },
      V = { AUTO: "auto", TOP: "top", RIGHT: "right", BOTTOM: "bottom", LEFT: "left" },
      z = { animation: !0, template: '<div class="tooltip" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>', trigger: "hover focus", title: "", delay: 0, html: !1, selector: !1, placement: "top", offset: 0, container: !1, fallbackPlacement: "flip", boundary: "scrollParent", sanitize: !0, sanitizeFn: null, whiteList: L, popperConfig: null },
      K = { HIDE: "hide.bs.tooltip", HIDDEN: "hidden.bs.tooltip", SHOW: "show.bs.tooltip", SHOWN: "shown.bs.tooltip", INSERTED: "inserted.bs.tooltip", CLICK: "click.bs.tooltip", FOCUSIN: "focusin.bs.tooltip", FOCUSOUT: "focusout.bs.tooltip", MOUSEENTER: "mouseenter.bs.tooltip", MOUSELEAVE: "mouseleave.bs.tooltip" },
      X = (function () {
    function t(t, e) {
      if ("undefined" == typeof n) throw new TypeError("Bootstrap's tooltips require Popper.js (https://popper.js.org/)");this._isEnabled = !0, this._timeout = 0, this._hoverState = "", this._activeTrigger = {}, this._popper = null, this.element = t, this.config = this._getConfig(e), this.tip = null, this._setListeners();
    }var i = t.prototype;return i.enable = function () {
      this._isEnabled = !0;
    }, i.disable = function () {
      this._isEnabled = !1;
    }, i.toggleEnabled = function () {
      this._isEnabled = !this._isEnabled;
    }, i.toggle = function (t) {
      if (this._isEnabled) if (t) {
        var n = this.constructor.DATA_KEY,
            i = e(t.currentTarget).data(n);i || (i = new this.constructor(t.currentTarget, this._getDelegateConfig()), e(t.currentTarget).data(n, i)), i._activeTrigger.click = !i._activeTrigger.click, i._isWithActiveTrigger() ? i._enter(null, i) : i._leave(null, i);
      } else {
        if (e(this.getTipElement()).hasClass("show")) return void this._leave(null, this);this._enter(null, this);
      }
    }, i.dispose = function () {
      clearTimeout(this._timeout), e.removeData(this.element, this.constructor.DATA_KEY), e(this.element).off(this.constructor.EVENT_KEY), e(this.element).closest(".modal").off("hide.bs.modal", this._hideModalHandler), this.tip && e(this.tip).remove(), this._isEnabled = null, this._timeout = null, this._hoverState = null, this._activeTrigger = null, this._popper && this._popper.destroy(), this._popper = null, this.element = null, this.config = null, this.tip = null;
    }, i.show = function () {
      var t = this;if ("none" === e(this.element).css("display")) throw new Error("Please use show on visible elements");var i = e.Event(this.constructor.Event.SHOW);if (this.isWithContent() && this._isEnabled) {
        e(this.element).trigger(i);var o = a.findShadowRoot(this.element),
            s = e.contains(null !== o ? o : this.element.ownerDocument.documentElement, this.element);if (i.isDefaultPrevented() || !s) return;var r = this.getTipElement(),
            l = a.getUID(this.constructor.NAME);r.setAttribute("id", l), this.element.setAttribute("aria-describedby", l), this.setContent(), this.config.animation && e(r).addClass("fade");var c = "function" == typeof this.config.placement ? this.config.placement.call(this, r, this.element) : this.config.placement,
            h = this._getAttachment(c);this.addAttachmentClass(h);var u = this._getContainer();e(r).data(this.constructor.DATA_KEY, this), e.contains(this.element.ownerDocument.documentElement, this.tip) || e(r).appendTo(u), e(this.element).trigger(this.constructor.Event.INSERTED), this._popper = new n(this.element, r, this._getPopperConfig(h)), e(r).addClass("show"), "ontouchstart" in document.documentElement && e(document.body).children().on("mouseover", null, e.noop);var d = function d() {
          t.config.animation && t._fixTransition();var n = t._hoverState;t._hoverState = null, e(t.element).trigger(t.constructor.Event.SHOWN), "out" === n && t._leave(null, t);
        };if (e(this.tip).hasClass("fade")) {
          var f = a.getTransitionDurationFromElement(this.tip);e(this.tip).one(a.TRANSITION_END, d).emulateTransitionEnd(f);
        } else d();
      }
    }, i.hide = function (t) {
      var n = this,
          i = this.getTipElement(),
          o = e.Event(this.constructor.Event.HIDE),
          s = function s() {
        "show" !== n._hoverState && i.parentNode && i.parentNode.removeChild(i), n._cleanTipClass(), n.element.removeAttribute("aria-describedby"), e(n.element).trigger(n.constructor.Event.HIDDEN), null !== n._popper && n._popper.destroy(), t && t();
      };if ((e(this.element).trigger(o), !o.isDefaultPrevented())) {
        if ((e(i).removeClass("show"), "ontouchstart" in document.documentElement && e(document.body).children().off("mouseover", null, e.noop), this._activeTrigger.click = !1, this._activeTrigger.focus = !1, this._activeTrigger.hover = !1, e(this.tip).hasClass("fade"))) {
          var r = a.getTransitionDurationFromElement(i);e(i).one(a.TRANSITION_END, s).emulateTransitionEnd(r);
        } else s();this._hoverState = "";
      }
    }, i.update = function () {
      null !== this._popper && this._popper.scheduleUpdate();
    }, i.isWithContent = function () {
      return Boolean(this.getTitle());
    }, i.addAttachmentClass = function (t) {
      e(this.getTipElement()).addClass("bs-tooltip-" + t);
    }, i.getTipElement = function () {
      return this.tip = this.tip || e(this.config.template)[0], this.tip;
    }, i.setContent = function () {
      var t = this.getTipElement();this.setElementContent(e(t.querySelectorAll(".tooltip-inner")), this.getTitle()), e(t).removeClass("fade show");
    }, i.setElementContent = function (t, n) {
      "object" != typeof n || !n.nodeType && !n.jquery ? this.config.html ? (this.config.sanitize && (n = Q(n, this.config.whiteList, this.config.sanitizeFn)), t.html(n)) : t.text(n) : this.config.html ? e(n).parent().is(t) || t.empty().append(n) : t.text(e(n).text());
    }, i.getTitle = function () {
      var t = this.element.getAttribute("data-original-title");return t || (t = "function" == typeof this.config.title ? this.config.title.call(this.element) : this.config.title), t;
    }, i._getPopperConfig = function (t) {
      var e = this;return s({}, { placement: t, modifiers: { offset: this._getOffset(), flip: { behavior: this.config.fallbackPlacement }, arrow: { element: ".arrow" }, preventOverflow: { boundariesElement: this.config.boundary } }, onCreate: function onCreate(t) {
          t.originalPlacement !== t.placement && e._handlePopperPlacementChange(t);
        }, onUpdate: function onUpdate(t) {
          return e._handlePopperPlacementChange(t);
        } }, this.config.popperConfig);
    }, i._getOffset = function () {
      var t = this,
          e = {};return "function" == typeof this.config.offset ? e.fn = function (e) {
        return e.offsets = s({}, e.offsets, t.config.offset(e.offsets, t.element) || {}), e;
      } : e.offset = this.config.offset, e;
    }, i._getContainer = function () {
      return !1 === this.config.container ? document.body : a.isElement(this.config.container) ? e(this.config.container) : e(document).find(this.config.container);
    }, i._getAttachment = function (t) {
      return V[t.toUpperCase()];
    }, i._setListeners = function () {
      var t = this;this.config.trigger.split(" ").forEach(function (n) {
        if ("click" === n) e(t.element).on(t.constructor.Event.CLICK, t.config.selector, function (e) {
          return t.toggle(e);
        });else if ("manual" !== n) {
          var i = "hover" === n ? t.constructor.Event.MOUSEENTER : t.constructor.Event.FOCUSIN,
              o = "hover" === n ? t.constructor.Event.MOUSELEAVE : t.constructor.Event.FOCUSOUT;e(t.element).on(i, t.config.selector, function (e) {
            return t._enter(e);
          }).on(o, t.config.selector, function (e) {
            return t._leave(e);
          });
        }
      }), this._hideModalHandler = function () {
        t.element && t.hide();
      }, e(this.element).closest(".modal").on("hide.bs.modal", this._hideModalHandler), this.config.selector ? this.config = s({}, this.config, { trigger: "manual", selector: "" }) : this._fixTitle();
    }, i._fixTitle = function () {
      var t = typeof this.element.getAttribute("data-original-title");(this.element.getAttribute("title") || "string" !== t) && (this.element.setAttribute("data-original-title", this.element.getAttribute("title") || ""), this.element.setAttribute("title", ""));
    }, i._enter = function (t, n) {
      var i = this.constructor.DATA_KEY;(n = n || e(t.currentTarget).data(i)) || (n = new this.constructor(t.currentTarget, this._getDelegateConfig()), e(t.currentTarget).data(i, n)), t && (n._activeTrigger["focusin" === t.type ? "focus" : "hover"] = !0), e(n.getTipElement()).hasClass("show") || "show" === n._hoverState ? n._hoverState = "show" : (clearTimeout(n._timeout), n._hoverState = "show", n.config.delay && n.config.delay.show ? n._timeout = setTimeout(function () {
        "show" === n._hoverState && n.show();
      }, n.config.delay.show) : n.show());
    }, i._leave = function (t, n) {
      var i = this.constructor.DATA_KEY;(n = n || e(t.currentTarget).data(i)) || (n = new this.constructor(t.currentTarget, this._getDelegateConfig()), e(t.currentTarget).data(i, n)), t && (n._activeTrigger["focusout" === t.type ? "focus" : "hover"] = !1), n._isWithActiveTrigger() || (clearTimeout(n._timeout), n._hoverState = "out", n.config.delay && n.config.delay.hide ? n._timeout = setTimeout(function () {
        "out" === n._hoverState && n.hide();
      }, n.config.delay.hide) : n.hide());
    }, i._isWithActiveTrigger = function () {
      for (var t in this._activeTrigger) if (this._activeTrigger[t]) return !0;return !1;
    }, i._getConfig = function (t) {
      var n = e(this.element).data();return Object.keys(n).forEach(function (t) {
        -1 !== M.indexOf(t) && delete n[t];
      }), "number" == typeof (t = s({}, this.constructor.Default, n, "object" == typeof t && t ? t : {})).delay && (t.delay = { show: t.delay, hide: t.delay }), "number" == typeof t.title && (t.title = t.title.toString()), "number" == typeof t.content && (t.content = t.content.toString()), a.typeCheckConfig(B, t, this.constructor.DefaultType), t.sanitize && (t.template = Q(t.template, t.whiteList, t.sanitizeFn)), t;
    }, i._getDelegateConfig = function () {
      var t = {};if (this.config) for (var e in this.config) this.constructor.Default[e] !== this.config[e] && (t[e] = this.config[e]);return t;
    }, i._cleanTipClass = function () {
      var t = e(this.getTipElement()),
          n = t.attr("class").match(U);null !== n && n.length && t.removeClass(n.join(""));
    }, i._handlePopperPlacementChange = function (t) {
      this.tip = t.instance.popper, this._cleanTipClass(), this.addAttachmentClass(this._getAttachment(t.placement));
    }, i._fixTransition = function () {
      var t = this.getTipElement(),
          n = this.config.animation;null === t.getAttribute("x-placement") && (e(t).removeClass("fade"), this.config.animation = !1, this.hide(), this.show(), this.config.animation = n);
    }, t._jQueryInterface = function (n) {
      return this.each(function () {
        var i = e(this).data("bs.tooltip"),
            o = "object" == typeof n && n;if ((i || !/dispose|hide/.test(n)) && (i || (i = new t(this, o), e(this).data("bs.tooltip", i)), "string" == typeof n)) {
          if ("undefined" == typeof i[n]) throw new TypeError('No method named "' + n + '"');i[n]();
        }
      });
    }, o(t, null, [{ key: "VERSION", get: function get() {
        return "4.5.2";
      } }, { key: "Default", get: function get() {
        return z;
      } }, { key: "NAME", get: function get() {
        return B;
      } }, { key: "DATA_KEY", get: function get() {
        return "bs.tooltip";
      } }, { key: "Event", get: function get() {
        return K;
      } }, { key: "EVENT_KEY", get: function get() {
        return ".bs.tooltip";
      } }, { key: "DefaultType", get: function get() {
        return W;
      } }]), t;
  })();e.fn[B] = X._jQueryInterface, e.fn[B].Constructor = X, e.fn[B].noConflict = function () {
    return e.fn[B] = H, X._jQueryInterface;
  };var Y = "popover",
      $ = e.fn[Y],
      J = new RegExp("(^|\\s)bs-popover\\S+", "g"),
      G = s({}, X.Default, { placement: "right", trigger: "click", content: "", template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>' }),
      Z = s({}, X.DefaultType, { content: "(string|element|function)" }),
      tt = { HIDE: "hide.bs.popover", HIDDEN: "hidden.bs.popover", SHOW: "show.bs.popover", SHOWN: "shown.bs.popover", INSERTED: "inserted.bs.popover", CLICK: "click.bs.popover", FOCUSIN: "focusin.bs.popover", FOCUSOUT: "focusout.bs.popover", MOUSEENTER: "mouseenter.bs.popover", MOUSELEAVE: "mouseleave.bs.popover" },
      et = (function (t) {
    var n, i;function s() {
      return t.apply(this, arguments) || this;
    }i = t, (n = s).prototype = Object.create(i.prototype), n.prototype.constructor = n, n.__proto__ = i;var r = s.prototype;return r.isWithContent = function () {
      return this.getTitle() || this._getContent();
    }, r.addAttachmentClass = function (t) {
      e(this.getTipElement()).addClass("bs-popover-" + t);
    }, r.getTipElement = function () {
      return this.tip = this.tip || e(this.config.template)[0], this.tip;
    }, r.setContent = function () {
      var t = e(this.getTipElement());this.setElementContent(t.find(".popover-header"), this.getTitle());var n = this._getContent();"function" == typeof n && (n = n.call(this.element)), this.setElementContent(t.find(".popover-body"), n), t.removeClass("fade show");
    }, r._getContent = function () {
      return this.element.getAttribute("data-content") || this.config.content;
    }, r._cleanTipClass = function () {
      var t = e(this.getTipElement()),
          n = t.attr("class").match(J);null !== n && n.length > 0 && t.removeClass(n.join(""));
    }, s._jQueryInterface = function (t) {
      return this.each(function () {
        var n = e(this).data("bs.popover"),
            i = "object" == typeof t ? t : null;if ((n || !/dispose|hide/.test(t)) && (n || (n = new s(this, i), e(this).data("bs.popover", n)), "string" == typeof t)) {
          if ("undefined" == typeof n[t]) throw new TypeError('No method named "' + t + '"');n[t]();
        }
      });
    }, o(s, null, [{ key: "VERSION", get: function get() {
        return "4.5.2";
      } }, { key: "Default", get: function get() {
        return G;
      } }, { key: "NAME", get: function get() {
        return Y;
      } }, { key: "DATA_KEY", get: function get() {
        return "bs.popover";
      } }, { key: "Event", get: function get() {
        return tt;
      } }, { key: "EVENT_KEY", get: function get() {
        return ".bs.popover";
      } }, { key: "DefaultType", get: function get() {
        return Z;
      } }]), s;
  })(X);e.fn[Y] = et._jQueryInterface, e.fn[Y].Constructor = et, e.fn[Y].noConflict = function () {
    return e.fn[Y] = $, et._jQueryInterface;
  };var nt = "scrollspy",
      it = e.fn[nt],
      ot = { offset: 10, method: "auto", target: "" },
      st = { offset: "number", method: "string", target: "(string|element)" },
      rt = (function () {
    function t(t, n) {
      var i = this;this._element = t, this._scrollElement = "BODY" === t.tagName ? window : t, this._config = this._getConfig(n), this._selector = this._config.target + " .nav-link," + this._config.target + " .list-group-item," + this._config.target + " .dropdown-item", this._offsets = [], this._targets = [], this._activeTarget = null, this._scrollHeight = 0, e(this._scrollElement).on("scroll.bs.scrollspy", function (t) {
        return i._process(t);
      }), this.refresh(), this._process();
    }var n = t.prototype;return n.refresh = function () {
      var t = this,
          n = this._scrollElement === this._scrollElement.window ? "offset" : "position",
          i = "auto" === this._config.method ? n : this._config.method,
          o = "position" === i ? this._getScrollTop() : 0;this._offsets = [], this._targets = [], this._scrollHeight = this._getScrollHeight(), [].slice.call(document.querySelectorAll(this._selector)).map(function (t) {
        var n,
            s = a.getSelectorFromElement(t);if ((s && (n = document.querySelector(s)), n)) {
          var r = n.getBoundingClientRect();if (r.width || r.height) return [e(n)[i]().top + o, s];
        }return null;
      }).filter(function (t) {
        return t;
      }).sort(function (t, e) {
        return t[0] - e[0];
      }).forEach(function (e) {
        t._offsets.push(e[0]), t._targets.push(e[1]);
      });
    }, n.dispose = function () {
      e.removeData(this._element, "bs.scrollspy"), e(this._scrollElement).off(".bs.scrollspy"), this._element = null, this._scrollElement = null, this._config = null, this._selector = null, this._offsets = null, this._targets = null, this._activeTarget = null, this._scrollHeight = null;
    }, n._getConfig = function (t) {
      if ("string" != typeof (t = s({}, ot, "object" == typeof t && t ? t : {})).target && a.isElement(t.target)) {
        var n = e(t.target).attr("id");n || (n = a.getUID(nt), e(t.target).attr("id", n)), t.target = "#" + n;
      }return a.typeCheckConfig(nt, t, st), t;
    }, n._getScrollTop = function () {
      return this._scrollElement === window ? this._scrollElement.pageYOffset : this._scrollElement.scrollTop;
    }, n._getScrollHeight = function () {
      return this._scrollElement.scrollHeight || Math.max(document.body.scrollHeight, document.documentElement.scrollHeight);
    }, n._getOffsetHeight = function () {
      return this._scrollElement === window ? window.innerHeight : this._scrollElement.getBoundingClientRect().height;
    }, n._process = function () {
      var t = this._getScrollTop() + this._config.offset,
          e = this._getScrollHeight(),
          n = this._config.offset + e - this._getOffsetHeight();if ((this._scrollHeight !== e && this.refresh(), t >= n)) {
        var i = this._targets[this._targets.length - 1];this._activeTarget !== i && this._activate(i);
      } else {
        if (this._activeTarget && t < this._offsets[0] && this._offsets[0] > 0) return this._activeTarget = null, void this._clear();for (var o = this._offsets.length; o--;) {
          this._activeTarget !== this._targets[o] && t >= this._offsets[o] && ("undefined" == typeof this._offsets[o + 1] || t < this._offsets[o + 1]) && this._activate(this._targets[o]);
        }
      }
    }, n._activate = function (t) {
      this._activeTarget = t, this._clear();var n = this._selector.split(",").map(function (e) {
        return e + '[data-target="' + t + '"],' + e + '[href="' + t + '"]';
      }),
          i = e([].slice.call(document.querySelectorAll(n.join(","))));i.hasClass("dropdown-item") ? (i.closest(".dropdown").find(".dropdown-toggle").addClass("active"), i.addClass("active")) : (i.addClass("active"), i.parents(".nav, .list-group").prev(".nav-link, .list-group-item").addClass("active"), i.parents(".nav, .list-group").prev(".nav-item").children(".nav-link").addClass("active")), e(this._scrollElement).trigger("activate.bs.scrollspy", { relatedTarget: t });
    }, n._clear = function () {
      [].slice.call(document.querySelectorAll(this._selector)).filter(function (t) {
        return t.classList.contains("active");
      }).forEach(function (t) {
        return t.classList.remove("active");
      });
    }, t._jQueryInterface = function (n) {
      return this.each(function () {
        var i = e(this).data("bs.scrollspy");if ((i || (i = new t(this, "object" == typeof n && n), e(this).data("bs.scrollspy", i)), "string" == typeof n)) {
          if ("undefined" == typeof i[n]) throw new TypeError('No method named "' + n + '"');i[n]();
        }
      });
    }, o(t, null, [{ key: "VERSION", get: function get() {
        return "4.5.2";
      } }, { key: "Default", get: function get() {
        return ot;
      } }]), t;
  })();e(window).on("load.bs.scrollspy.data-api", function () {
    for (var t = [].slice.call(document.querySelectorAll('[data-spy="scroll"]')), n = t.length; n--;) {
      var i = e(t[n]);rt._jQueryInterface.call(i, i.data());
    }
  }), e.fn[nt] = rt._jQueryInterface, e.fn[nt].Constructor = rt, e.fn[nt].noConflict = function () {
    return e.fn[nt] = it, rt._jQueryInterface;
  };var at = e.fn.tab,
      lt = (function () {
    function t(t) {
      this._element = t;
    }var n = t.prototype;return n.show = function () {
      var t = this;if (!(this._element.parentNode && this._element.parentNode.nodeType === Node.ELEMENT_NODE && e(this._element).hasClass("active") || e(this._element).hasClass("disabled"))) {
        var n,
            i,
            o = e(this._element).closest(".nav, .list-group")[0],
            s = a.getSelectorFromElement(this._element);if (o) {
          var r = "UL" === o.nodeName || "OL" === o.nodeName ? "> li > .active" : ".active";i = (i = e.makeArray(e(o).find(r)))[i.length - 1];
        }var l = e.Event("hide.bs.tab", { relatedTarget: this._element }),
            c = e.Event("show.bs.tab", { relatedTarget: i });if ((i && e(i).trigger(l), e(this._element).trigger(c), !c.isDefaultPrevented() && !l.isDefaultPrevented())) {
          s && (n = document.querySelector(s)), this._activate(this._element, o);var h = function h() {
            var n = e.Event("hidden.bs.tab", { relatedTarget: t._element }),
                o = e.Event("shown.bs.tab", { relatedTarget: i });e(i).trigger(n), e(t._element).trigger(o);
          };n ? this._activate(n, n.parentNode, h) : h();
        }
      }
    }, n.dispose = function () {
      e.removeData(this._element, "bs.tab"), this._element = null;
    }, n._activate = function (t, n, i) {
      var o = this,
          s = (!n || "UL" !== n.nodeName && "OL" !== n.nodeName ? e(n).children(".active") : e(n).find("> li > .active"))[0],
          r = i && s && e(s).hasClass("fade"),
          l = function l() {
        return o._transitionComplete(t, s, i);
      };if (s && r) {
        var c = a.getTransitionDurationFromElement(s);e(s).removeClass("show").one(a.TRANSITION_END, l).emulateTransitionEnd(c);
      } else l();
    }, n._transitionComplete = function (t, n, i) {
      if (n) {
        e(n).removeClass("active");var o = e(n.parentNode).find("> .dropdown-menu .active")[0];o && e(o).removeClass("active"), "tab" === n.getAttribute("role") && n.setAttribute("aria-selected", !1);
      }if ((e(t).addClass("active"), "tab" === t.getAttribute("role") && t.setAttribute("aria-selected", !0), a.reflow(t), t.classList.contains("fade") && t.classList.add("show"), t.parentNode && e(t.parentNode).hasClass("dropdown-menu"))) {
        var s = e(t).closest(".dropdown")[0];if (s) {
          var r = [].slice.call(s.querySelectorAll(".dropdown-toggle"));e(r).addClass("active");
        }t.setAttribute("aria-expanded", !0);
      }i && i();
    }, t._jQueryInterface = function (n) {
      return this.each(function () {
        var i = e(this),
            o = i.data("bs.tab");if ((o || (o = new t(this), i.data("bs.tab", o)), "string" == typeof n)) {
          if ("undefined" == typeof o[n]) throw new TypeError('No method named "' + n + '"');o[n]();
        }
      });
    }, o(t, null, [{ key: "VERSION", get: function get() {
        return "4.5.2";
      } }]), t;
  })();e(document).on("click.bs.tab.data-api", '[data-toggle="tab"], [data-toggle="pill"], [data-toggle="list"]', function (t) {
    t.preventDefault(), lt._jQueryInterface.call(e(this), "show");
  }), e.fn.tab = lt._jQueryInterface, e.fn.tab.Constructor = lt, e.fn.tab.noConflict = function () {
    return e.fn.tab = at, lt._jQueryInterface;
  };var ct = e.fn.toast,
      ht = { animation: "boolean", autohide: "boolean", delay: "number" },
      ut = { animation: !0, autohide: !0, delay: 500 },
      dt = (function () {
    function t(t, e) {
      this._element = t, this._config = this._getConfig(e), this._timeout = null, this._setListeners();
    }var n = t.prototype;return n.show = function () {
      var t = this,
          n = e.Event("show.bs.toast");if ((e(this._element).trigger(n), !n.isDefaultPrevented())) {
        this._clearTimeout(), this._config.animation && this._element.classList.add("fade");var i = function i() {
          t._element.classList.remove("showing"), t._element.classList.add("show"), e(t._element).trigger("shown.bs.toast"), t._config.autohide && (t._timeout = setTimeout(function () {
            t.hide();
          }, t._config.delay));
        };if ((this._element.classList.remove("hide"), a.reflow(this._element), this._element.classList.add("showing"), this._config.animation)) {
          var o = a.getTransitionDurationFromElement(this._element);e(this._element).one(a.TRANSITION_END, i).emulateTransitionEnd(o);
        } else i();
      }
    }, n.hide = function () {
      if (this._element.classList.contains("show")) {
        var t = e.Event("hide.bs.toast");e(this._element).trigger(t), t.isDefaultPrevented() || this._close();
      }
    }, n.dispose = function () {
      this._clearTimeout(), this._element.classList.contains("show") && this._element.classList.remove("show"), e(this._element).off("click.dismiss.bs.toast"), e.removeData(this._element, "bs.toast"), this._element = null, this._config = null;
    }, n._getConfig = function (t) {
      return t = s({}, ut, e(this._element).data(), "object" == typeof t && t ? t : {}), a.typeCheckConfig("toast", t, this.constructor.DefaultType), t;
    }, n._setListeners = function () {
      var t = this;e(this._element).on("click.dismiss.bs.toast", '[data-dismiss="toast"]', function () {
        return t.hide();
      });
    }, n._close = function () {
      var t = this,
          n = function n() {
        t._element.classList.add("hide"), e(t._element).trigger("hidden.bs.toast");
      };if ((this._element.classList.remove("show"), this._config.animation)) {
        var i = a.getTransitionDurationFromElement(this._element);e(this._element).one(a.TRANSITION_END, n).emulateTransitionEnd(i);
      } else n();
    }, n._clearTimeout = function () {
      clearTimeout(this._timeout), this._timeout = null;
    }, t._jQueryInterface = function (n) {
      return this.each(function () {
        var i = e(this),
            o = i.data("bs.toast");if ((o || (o = new t(this, "object" == typeof n && n), i.data("bs.toast", o)), "string" == typeof n)) {
          if ("undefined" == typeof o[n]) throw new TypeError('No method named "' + n + '"');o[n](this);
        }
      });
    }, o(t, null, [{ key: "VERSION", get: function get() {
        return "4.5.2";
      } }, { key: "DefaultType", get: function get() {
        return ht;
      } }, { key: "Default", get: function get() {
        return ut;
      } }]), t;
  })();e.fn.toast = dt._jQueryInterface, e.fn.toast.Constructor = dt, e.fn.toast.noConflict = function () {
    return e.fn.toast = ct, dt._jQueryInterface;
  }, t.Alert = h, t.Button = d, t.Carousel = b, t.Collapse = C, t.Dropdown = I, t.Modal = P, t.Popover = et, t.Scrollspy = rt, t.Tab = lt, t.Toast = dt, t.Tooltip = X, t.Util = a, Object.defineProperty(t, "__esModule", { value: !0 });
});
//# sourceMappingURL=bootstrap.min.js.map

/***/ }),
/* 24 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
// Copyright Joyent, Inc. and other Node contributors.
//
// Permission is hereby granted, free of charge, to any person obtaining a
// copy of this software and associated documentation files (the
// "Software"), to deal in the Software without restriction, including
// without limitation the rights to use, copy, modify, merge, publish,
// distribute, sublicense, and/or sell copies of the Software, and to permit
// persons to whom the Software is furnished to do so, subject to the
// following conditions:
//
// The above copyright notice and this permission notice shall be included
// in all copies or substantial portions of the Software.
//
// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
// OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
// MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN
// NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
// DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
// OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE
// USE OR OTHER DEALINGS IN THE SOFTWARE.



function EventEmitter() {
  this._events = this._events || {};
  this._maxListeners = this._maxListeners || undefined;
}
module.exports = EventEmitter;

// Backwards-compat with node 0.10.x
EventEmitter.EventEmitter = EventEmitter;

EventEmitter.prototype._events = undefined;
EventEmitter.prototype._maxListeners = undefined;

// By default EventEmitters will print a warning if more than 10 listeners are
// added to it. This is a useful default which helps finding memory leaks.
EventEmitter.defaultMaxListeners = 10;

// Obviously not all Emitters should be limited to 10. This function allows
// that to be increased. Set to zero for unlimited.
EventEmitter.prototype.setMaxListeners = function (n) {
  if (!isNumber(n) || n < 0 || isNaN(n)) throw TypeError('n must be a positive number');
  this._maxListeners = n;
  return this;
};

EventEmitter.prototype.emit = function (type) {
  var er, handler, len, args, i, listeners;

  if (!this._events) this._events = {};

  // If there is no 'error' event listener then throw.
  if (type === 'error') {
    if (!this._events.error || isObject(this._events.error) && !this._events.error.length) {
      er = arguments[1];
      if (er instanceof Error) {
        throw er; // Unhandled 'error' event
      } else {
          // At least give some kind of context to the user
          var err = new Error('Uncaught, unspecified "error" event. (' + er + ')');
          err.context = er;
          throw err;
        }
    }
  }

  handler = this._events[type];

  if (isUndefined(handler)) return false;

  if (isFunction(handler)) {
    switch (arguments.length) {
      // fast cases
      case 1:
        handler.call(this);
        break;
      case 2:
        handler.call(this, arguments[1]);
        break;
      case 3:
        handler.call(this, arguments[1], arguments[2]);
        break;
      // slower
      default:
        args = Array.prototype.slice.call(arguments, 1);
        handler.apply(this, args);
    }
  } else if (isObject(handler)) {
    args = Array.prototype.slice.call(arguments, 1);
    listeners = handler.slice();
    len = listeners.length;
    for (i = 0; i < len; i++) listeners[i].apply(this, args);
  }

  return true;
};

EventEmitter.prototype.addListener = function (type, listener) {
  var m;

  if (!isFunction(listener)) throw TypeError('listener must be a function');

  if (!this._events) this._events = {};

  // To avoid recursion in the case that type === "newListener"! Before
  // adding it to the listeners, first emit "newListener".
  if (this._events.newListener) this.emit('newListener', type, isFunction(listener.listener) ? listener.listener : listener);

  if (!this._events[type])
    // Optimize the case of one listener. Don't need the extra array object.
    this._events[type] = listener;else if (isObject(this._events[type]))
    // If we've already got an array, just append.
    this._events[type].push(listener);else
    // Adding the second element, need to change to array.
    this._events[type] = [this._events[type], listener];

  // Check for listener leak
  if (isObject(this._events[type]) && !this._events[type].warned) {
    if (!isUndefined(this._maxListeners)) {
      m = this._maxListeners;
    } else {
      m = EventEmitter.defaultMaxListeners;
    }

    if (m && m > 0 && this._events[type].length > m) {
      this._events[type].warned = true;
      console.error('(node) warning: possible EventEmitter memory ' + 'leak detected. %d listeners added. ' + 'Use emitter.setMaxListeners() to increase limit.', this._events[type].length);
      if (typeof console.trace === 'function') {
        // not supported in IE 10
        console.trace();
      }
    }
  }

  return this;
};

EventEmitter.prototype.on = EventEmitter.prototype.addListener;

EventEmitter.prototype.once = function (type, listener) {
  if (!isFunction(listener)) throw TypeError('listener must be a function');

  var fired = false;

  function g() {
    this.removeListener(type, g);

    if (!fired) {
      fired = true;
      listener.apply(this, arguments);
    }
  }

  g.listener = listener;
  this.on(type, g);

  return this;
};

// emits a 'removeListener' event iff the listener was removed
EventEmitter.prototype.removeListener = function (type, listener) {
  var list, position, length, i;

  if (!isFunction(listener)) throw TypeError('listener must be a function');

  if (!this._events || !this._events[type]) return this;

  list = this._events[type];
  length = list.length;
  position = -1;

  if (list === listener || isFunction(list.listener) && list.listener === listener) {
    delete this._events[type];
    if (this._events.removeListener) this.emit('removeListener', type, listener);
  } else if (isObject(list)) {
    for (i = length; i-- > 0;) {
      if (list[i] === listener || list[i].listener && list[i].listener === listener) {
        position = i;
        break;
      }
    }

    if (position < 0) return this;

    if (list.length === 1) {
      list.length = 0;
      delete this._events[type];
    } else {
      list.splice(position, 1);
    }

    if (this._events.removeListener) this.emit('removeListener', type, listener);
  }

  return this;
};

EventEmitter.prototype.removeAllListeners = function (type) {
  var key, listeners;

  if (!this._events) return this;

  // not listening for removeListener, no need to emit
  if (!this._events.removeListener) {
    if (arguments.length === 0) this._events = {};else if (this._events[type]) delete this._events[type];
    return this;
  }

  // emit removeListener for all listeners on all events
  if (arguments.length === 0) {
    for (key in this._events) {
      if (key === 'removeListener') continue;
      this.removeAllListeners(key);
    }
    this.removeAllListeners('removeListener');
    this._events = {};
    return this;
  }

  listeners = this._events[type];

  if (isFunction(listeners)) {
    this.removeListener(type, listeners);
  } else if (listeners) {
    // LIFO order
    while (listeners.length) this.removeListener(type, listeners[listeners.length - 1]);
  }
  delete this._events[type];

  return this;
};

EventEmitter.prototype.listeners = function (type) {
  var ret;
  if (!this._events || !this._events[type]) ret = [];else if (isFunction(this._events[type])) ret = [this._events[type]];else ret = this._events[type].slice();
  return ret;
};

EventEmitter.prototype.listenerCount = function (type) {
  if (this._events) {
    var evlistener = this._events[type];

    if (isFunction(evlistener)) return 1;else if (evlistener) return evlistener.length;
  }
  return 0;
};

EventEmitter.listenerCount = function (emitter, type) {
  return emitter.listenerCount(type);
};

function isFunction(arg) {
  return typeof arg === 'function';
}

function isNumber(arg) {
  return typeof arg === 'number';
}

function isObject(arg) {
  return typeof arg === 'object' && arg !== null;
}

function isUndefined(arg) {
  return arg === void 0;
}

/***/ }),
/* 25 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
var require;var require;

!(function (e) {
  if (true) module.exports = e();else if ("function" == typeof define && define.amd) define([], e);else {
    var t;t = "undefined" != typeof window ? window : "undefined" != typeof global ? global : "undefined" != typeof self ? self : this, t.flexibility = e();
  }
})(function () {
  return (function e(t, r, l) {
    function n(o, i) {
      if (!r[o]) {
        if (!t[o]) {
          var s = "function" == typeof require && require;if (!i && s) return require(o, !0);if (f) return f(o, !0);var a = new Error("Cannot find module '" + o + "'");throw (a.code = "MODULE_NOT_FOUND", a);
        }var c = r[o] = { exports: {} };t[o][0].call(c.exports, function (e) {
          var r = t[o][1][e];return n(r ? r : e);
        }, c, c.exports, e, t, r, l);
      }return r[o].exports;
    }for (var f = "function" == typeof require && require, o = 0; o < l.length; o++) n(l[o]);return n;
  })({ 1: [function (e, t, r) {
      t.exports = function (e) {
        var t,
            r,
            l,
            n = -1;if (e.lines.length > 1 && "flex-start" === e.style.alignContent) for (t = 0; l = e.lines[++n];) l.crossStart = t, t += l.cross;else if (e.lines.length > 1 && "flex-end" === e.style.alignContent) for (t = e.flexStyle.crossSpace; l = e.lines[++n];) l.crossStart = t, t += l.cross;else if (e.lines.length > 1 && "center" === e.style.alignContent) for (t = e.flexStyle.crossSpace / 2; l = e.lines[++n];) l.crossStart = t, t += l.cross;else if (e.lines.length > 1 && "space-between" === e.style.alignContent) for (r = e.flexStyle.crossSpace / (e.lines.length - 1), t = 0; l = e.lines[++n];) l.crossStart = t, t += l.cross + r;else if (e.lines.length > 1 && "space-around" === e.style.alignContent) for (r = 2 * e.flexStyle.crossSpace / (2 * e.lines.length), t = r / 2; l = e.lines[++n];) l.crossStart = t, t += l.cross + r;else for (r = e.flexStyle.crossSpace / e.lines.length, t = e.flexStyle.crossInnerBefore; l = e.lines[++n];) l.crossStart = t, l.cross += r, t += l.cross;
      };
    }, {}], 2: [function (e, t, r) {
      t.exports = function (e) {
        for (var t, r = -1; line = e.lines[++r];) for (t = -1; child = line.children[++t];) {
          var l = child.style.alignSelf;"auto" === l && (l = e.style.alignItems), "flex-start" === l ? child.flexStyle.crossStart = line.crossStart : "flex-end" === l ? child.flexStyle.crossStart = line.crossStart + line.cross - child.flexStyle.crossOuter : "center" === l ? child.flexStyle.crossStart = line.crossStart + (line.cross - child.flexStyle.crossOuter) / 2 : (child.flexStyle.crossStart = line.crossStart, child.flexStyle.crossOuter = line.cross, child.flexStyle.cross = child.flexStyle.crossOuter - child.flexStyle.crossBefore - child.flexStyle.crossAfter);
        }
      };
    }, {}], 3: [function (e, t, r) {
      t.exports = function l(e, l) {
        var t = "row" === l || "row-reverse" === l,
            r = e.mainAxis;if (r) {
          var n = t && "inline" === r || !t && "block" === r;n || (e.flexStyle = { main: e.flexStyle.cross, cross: e.flexStyle.main, mainOffset: e.flexStyle.crossOffset, crossOffset: e.flexStyle.mainOffset, mainBefore: e.flexStyle.crossBefore, mainAfter: e.flexStyle.crossAfter, crossBefore: e.flexStyle.mainBefore, crossAfter: e.flexStyle.mainAfter, mainInnerBefore: e.flexStyle.crossInnerBefore, mainInnerAfter: e.flexStyle.crossInnerAfter, crossInnerBefore: e.flexStyle.mainInnerBefore, crossInnerAfter: e.flexStyle.mainInnerAfter, mainBorderBefore: e.flexStyle.crossBorderBefore, mainBorderAfter: e.flexStyle.crossBorderAfter, crossBorderBefore: e.flexStyle.mainBorderBefore, crossBorderAfter: e.flexStyle.mainBorderAfter });
        } else t ? e.flexStyle = { main: e.style.width, cross: e.style.height, mainOffset: e.style.offsetWidth, crossOffset: e.style.offsetHeight, mainBefore: e.style.marginLeft, mainAfter: e.style.marginRight, crossBefore: e.style.marginTop, crossAfter: e.style.marginBottom, mainInnerBefore: e.style.paddingLeft, mainInnerAfter: e.style.paddingRight, crossInnerBefore: e.style.paddingTop, crossInnerAfter: e.style.paddingBottom, mainBorderBefore: e.style.borderLeftWidth, mainBorderAfter: e.style.borderRightWidth, crossBorderBefore: e.style.borderTopWidth, crossBorderAfter: e.style.borderBottomWidth } : e.flexStyle = { main: e.style.height, cross: e.style.width, mainOffset: e.style.offsetHeight, crossOffset: e.style.offsetWidth, mainBefore: e.style.marginTop, mainAfter: e.style.marginBottom, crossBefore: e.style.marginLeft, crossAfter: e.style.marginRight, mainInnerBefore: e.style.paddingTop, mainInnerAfter: e.style.paddingBottom, crossInnerBefore: e.style.paddingLeft, crossInnerAfter: e.style.paddingRight, mainBorderBefore: e.style.borderTopWidth, mainBorderAfter: e.style.borderBottomWidth, crossBorderBefore: e.style.borderLeftWidth, crossBorderAfter: e.style.borderRightWidth }, "content-box" === e.style.boxSizing && ("number" == typeof e.flexStyle.main && (e.flexStyle.main += e.flexStyle.mainInnerBefore + e.flexStyle.mainInnerAfter + e.flexStyle.mainBorderBefore + e.flexStyle.mainBorderAfter), "number" == typeof e.flexStyle.cross && (e.flexStyle.cross += e.flexStyle.crossInnerBefore + e.flexStyle.crossInnerAfter + e.flexStyle.crossBorderBefore + e.flexStyle.crossBorderAfter));e.mainAxis = t ? "inline" : "block", e.crossAxis = t ? "block" : "inline", "number" == typeof e.style.flexBasis && (e.flexStyle.main = e.style.flexBasis + e.flexStyle.mainInnerBefore + e.flexStyle.mainInnerAfter + e.flexStyle.mainBorderBefore + e.flexStyle.mainBorderAfter), e.flexStyle.mainOuter = e.flexStyle.main, e.flexStyle.crossOuter = e.flexStyle.cross, "auto" === e.flexStyle.mainOuter && (e.flexStyle.mainOuter = e.flexStyle.mainOffset), "auto" === e.flexStyle.crossOuter && (e.flexStyle.crossOuter = e.flexStyle.crossOffset), "number" == typeof e.flexStyle.mainBefore && (e.flexStyle.mainOuter += e.flexStyle.mainBefore), "number" == typeof e.flexStyle.mainAfter && (e.flexStyle.mainOuter += e.flexStyle.mainAfter), "number" == typeof e.flexStyle.crossBefore && (e.flexStyle.crossOuter += e.flexStyle.crossBefore), "number" == typeof e.flexStyle.crossAfter && (e.flexStyle.crossOuter += e.flexStyle.crossAfter);
      };
    }, {}], 4: [function (e, t, r) {
      var l = e("../reduce");t.exports = function (e) {
        if (e.mainSpace > 0) {
          var t = l(e.children, function (e, t) {
            return e + parseFloat(t.style.flexGrow);
          }, 0);t > 0 && (e.main = l(e.children, function (r, l) {
            return "auto" === l.flexStyle.main ? l.flexStyle.main = l.flexStyle.mainOffset + parseFloat(l.style.flexGrow) / t * e.mainSpace : l.flexStyle.main += parseFloat(l.style.flexGrow) / t * e.mainSpace, l.flexStyle.mainOuter = l.flexStyle.main + l.flexStyle.mainBefore + l.flexStyle.mainAfter, r + l.flexStyle.mainOuter;
          }, 0), e.mainSpace = 0);
        }
      };
    }, { "../reduce": 12 }], 5: [function (e, t, r) {
      var l = e("../reduce");t.exports = function (e) {
        if (e.mainSpace < 0) {
          var t = l(e.children, function (e, t) {
            return e + parseFloat(t.style.flexShrink);
          }, 0);t > 0 && (e.main = l(e.children, function (r, l) {
            return l.flexStyle.main += parseFloat(l.style.flexShrink) / t * e.mainSpace, l.flexStyle.mainOuter = l.flexStyle.main + l.flexStyle.mainBefore + l.flexStyle.mainAfter, r + l.flexStyle.mainOuter;
          }, 0), e.mainSpace = 0);
        }
      };
    }, { "../reduce": 12 }], 6: [function (e, t, r) {
      var l = e("../reduce");t.exports = function (e) {
        var t;e.lines = [t = { main: 0, cross: 0, children: [] }];for (var r, n = -1; r = e.children[++n];) "nowrap" === e.style.flexWrap || 0 === t.children.length || "auto" === e.flexStyle.main || e.flexStyle.main - e.flexStyle.mainInnerBefore - e.flexStyle.mainInnerAfter - e.flexStyle.mainBorderBefore - e.flexStyle.mainBorderAfter >= t.main + r.flexStyle.mainOuter ? (t.main += r.flexStyle.mainOuter, t.cross = Math.max(t.cross, r.flexStyle.crossOuter)) : e.lines.push(t = { main: r.flexStyle.mainOuter, cross: r.flexStyle.crossOuter, children: [] }), t.children.push(r);e.flexStyle.mainLines = l(e.lines, function (e, t) {
          return Math.max(e, t.main);
        }, 0), e.flexStyle.crossLines = l(e.lines, function (e, t) {
          return e + t.cross;
        }, 0), "auto" === e.flexStyle.main && (e.flexStyle.main = Math.max(e.flexStyle.mainOffset, e.flexStyle.mainLines + e.flexStyle.mainInnerBefore + e.flexStyle.mainInnerAfter + e.flexStyle.mainBorderBefore + e.flexStyle.mainBorderAfter)), "auto" === e.flexStyle.cross && (e.flexStyle.cross = Math.max(e.flexStyle.crossOffset, e.flexStyle.crossLines + e.flexStyle.crossInnerBefore + e.flexStyle.crossInnerAfter + e.flexStyle.crossBorderBefore + e.flexStyle.crossBorderAfter)), e.flexStyle.crossSpace = e.flexStyle.cross - e.flexStyle.crossInnerBefore - e.flexStyle.crossInnerAfter - e.flexStyle.crossBorderBefore - e.flexStyle.crossBorderAfter - e.flexStyle.crossLines, e.flexStyle.mainOuter = e.flexStyle.main + e.flexStyle.mainBefore + e.flexStyle.mainAfter, e.flexStyle.crossOuter = e.flexStyle.cross + e.flexStyle.crossBefore + e.flexStyle.crossAfter;
      };
    }, { "../reduce": 12 }], 7: [function (e, t, r) {
      function l(t) {
        for (var r, l = -1; r = t.children[++l];) e("./flex-direction")(r, t.style.flexDirection);e("./flex-direction")(t, t.style.flexDirection), e("./order")(t), e("./flexbox-lines")(t), e("./align-content")(t), l = -1;for (var n; n = t.lines[++l];) n.mainSpace = t.flexStyle.main - t.flexStyle.mainInnerBefore - t.flexStyle.mainInnerAfter - t.flexStyle.mainBorderBefore - t.flexStyle.mainBorderAfter - n.main, e("./flex-grow")(n), e("./flex-shrink")(n), e("./margin-main")(n), e("./margin-cross")(n), e("./justify-content")(n, t.style.justifyContent, t);e("./align-items")(t);
      }t.exports = l;
    }, { "./align-content": 1, "./align-items": 2, "./flex-direction": 3, "./flex-grow": 4, "./flex-shrink": 5, "./flexbox-lines": 6, "./justify-content": 8, "./margin-cross": 9, "./margin-main": 10, "./order": 11 }], 8: [function (e, t, r) {
      t.exports = function (e, t, r) {
        var l,
            n,
            f,
            o = r.flexStyle.mainInnerBefore,
            i = -1;if ("flex-end" === t) for (l = e.mainSpace, l += o; f = e.children[++i];) f.flexStyle.mainStart = l, l += f.flexStyle.mainOuter;else if ("center" === t) for (l = e.mainSpace / 2, l += o; f = e.children[++i];) f.flexStyle.mainStart = l, l += f.flexStyle.mainOuter;else if ("space-between" === t) for (n = e.mainSpace / (e.children.length - 1), l = 0, l += o; f = e.children[++i];) f.flexStyle.mainStart = l, l += f.flexStyle.mainOuter + n;else if ("space-around" === t) for (n = 2 * e.mainSpace / (2 * e.children.length), l = n / 2, l += o; f = e.children[++i];) f.flexStyle.mainStart = l, l += f.flexStyle.mainOuter + n;else for (l = 0, l += o; f = e.children[++i];) f.flexStyle.mainStart = l, l += f.flexStyle.mainOuter;
      };
    }, {}], 9: [function (e, t, r) {
      t.exports = function (e) {
        for (var t, r = -1; t = e.children[++r];) {
          var l = 0;"auto" === t.flexStyle.crossBefore && ++l, "auto" === t.flexStyle.crossAfter && ++l;var n = e.cross - t.flexStyle.crossOuter;"auto" === t.flexStyle.crossBefore && (t.flexStyle.crossBefore = n / l), "auto" === t.flexStyle.crossAfter && (t.flexStyle.crossAfter = n / l), "auto" === t.flexStyle.cross ? t.flexStyle.crossOuter = t.flexStyle.crossOffset + t.flexStyle.crossBefore + t.flexStyle.crossAfter : t.flexStyle.crossOuter = t.flexStyle.cross + t.flexStyle.crossBefore + t.flexStyle.crossAfter;
        }
      };
    }, {}], 10: [function (e, t, r) {
      t.exports = function (e) {
        for (var t, r = 0, l = -1; t = e.children[++l];) "auto" === t.flexStyle.mainBefore && ++r, "auto" === t.flexStyle.mainAfter && ++r;if (r > 0) {
          for (l = -1; t = e.children[++l];) "auto" === t.flexStyle.mainBefore && (t.flexStyle.mainBefore = e.mainSpace / r), "auto" === t.flexStyle.mainAfter && (t.flexStyle.mainAfter = e.mainSpace / r), "auto" === t.flexStyle.main ? t.flexStyle.mainOuter = t.flexStyle.mainOffset + t.flexStyle.mainBefore + t.flexStyle.mainAfter : t.flexStyle.mainOuter = t.flexStyle.main + t.flexStyle.mainBefore + t.flexStyle.mainAfter;e.mainSpace = 0;
        }
      };
    }, {}], 11: [function (e, t, r) {
      var l = /^(column|row)-reverse$/;t.exports = function (e) {
        e.children.sort(function (e, t) {
          return e.style.order - t.style.order || e.index - t.index;
        }), l.test(e.style.flexDirection) && e.children.reverse();
      };
    }, {}], 12: [function (e, t, r) {
      function l(e, t, r) {
        for (var l = e.length, n = -1; ++n < l;) n in e && (r = t(r, e[n], n));return r;
      }t.exports = l;
    }, {}], 13: [function (e, t, r) {
      function l(e) {
        i(o(e));
      }var n = e("./read"),
          f = e("./write"),
          o = e("./readAll"),
          i = e("./writeAll");t.exports = l, t.exports.read = n, t.exports.write = f, t.exports.readAll = o, t.exports.writeAll = i;
    }, { "./read": 15, "./readAll": 16, "./write": 17, "./writeAll": 18 }], 14: [function (e, t, r) {
      function l(e, t) {
        var r = String(e).match(f);if (!r) return e;var l = r[1],
            o = r[2];return "px" === o ? 1 * l : "cm" === o ? .3937 * l * 96 : "in" === o ? 96 * l : "mm" === o ? .3937 * l * 96 / 10 : "pc" === o ? 12 * l * 96 / 72 : "pt" === o ? 96 * l / 72 : "rem" === o ? 16 * l : n(e, t);
      }function n(e, t) {
        o.style.cssText = "border:none!important;clip:rect(0 0 0 0)!important;display:block!important;font-size:1em!important;height:0!important;margin:0!important;padding:0!important;position:relative!important;width:" + e + "!important", t.parentNode.insertBefore(o, t.nextSibling);var r = o.offsetWidth;return t.parentNode.removeChild(o), r;
      }t.exports = l;var f = /^([-+]?\d*\.?\d+)(%|[a-z]+)$/,
          o = document.createElement("div");
    }, {}], 15: [function (e, t, r) {
      function l(e) {
        var t = { alignContent: "stretch", alignItems: "stretch", alignSelf: "auto", borderBottomWidth: 0, borderLeftWidth: 0, borderRightWidth: 0, borderTopWidth: 0, boxSizing: "content-box", display: "inline", flexBasis: "auto", flexDirection: "row", flexGrow: 0, flexShrink: 1, flexWrap: "nowrap", justifyContent: "flex-start", height: "auto", marginTop: 0, marginRight: 0, marginLeft: 0, marginBottom: 0, paddingTop: 0, paddingRight: 0, paddingLeft: 0, paddingBottom: 0, maxHeight: "none", maxWidth: "none", minHeight: 0, minWidth: 0, order: 0, position: "static", width: "auto" },
            r = e instanceof Element;if (r) {
          var l = e.hasAttribute("data-style"),
              i = l ? e.getAttribute("data-style") : e.getAttribute("style") || "";l || e.setAttribute("data-style", i);var a = window.getComputedStyle && getComputedStyle(e) || {};o(t, a);var c = e.currentStyle || {};n(t, c), f(t, i);for (var y in t) t[y] = s(t[y], e);var x = e.getBoundingClientRect();t.offsetHeight = x.height || e.offsetHeight, t.offsetWidth = x.width || e.offsetWidth;
        }var S = { element: e, style: t };return S;
      }function n(e, t) {
        for (var r in e) {
          var l = (r in t);if (l) e[r] = t[r];else {
            var n = r.replace(/[A-Z]/g, "-$&").toLowerCase(),
                f = (n in t);f && (e[r] = t[n]);
          }
        }var o = ("-js-display" in t);o && (e.display = t["-js-display"]);
      }function f(e, t) {
        for (var r; r = i.exec(t);) {
          var l = r[1].toLowerCase().replace(/-[a-z]/g, function (e) {
            return e.slice(1).toUpperCase();
          });e[l] = r[2];
        }
      }function o(e, t) {
        for (var r in e) {
          var l = (r in t);l && !/^(alignSelf|height|width)$/.test(r) && (e[r] = t[r]);
        }
      }t.exports = l;var i = /([^\s:;]+)\s*:\s*([^;]+?)\s*(;|$)/g,
          s = e("./getComputedLength");
    }, { "./getComputedLength": 14 }], 16: [function (e, t, r) {
      function l(e) {
        var t = [];return n(e, t), t;
      }function n(e, t) {
        for (var r, l = f(e), i = [], s = -1; r = e.childNodes[++s];) {
          var a = 3 === r.nodeType && !/^\s*$/.test(r.nodeValue);if (l && a) {
            var c = r;r = e.insertBefore(document.createElement("flex-item"), c), r.appendChild(c);
          }var y = r instanceof Element;if (y) {
            var x = n(r, t);if (l) {
              var S = r.style;S.display = "inline-block", S.position = "absolute", x.style = o(r).style, i.push(x);
            }
          }
        }var m = { element: e, children: i };return l && (m.style = o(e).style, t.push(m)), m;
      }function f(e) {
        var t = e instanceof Element,
            r = t && e.getAttribute("data-style"),
            l = t && e.currentStyle && e.currentStyle["-js-display"],
            n = i.test(r) || s.test(l);return n;
      }t.exports = l;var o = e("../read"),
          i = /(^|;)\s*display\s*:\s*(inline-)?flex\s*(;|$)/i,
          s = /^(inline-)?flex$/i;
    }, { "../read": 15 }], 17: [function (e, t, r) {
      function l(e) {
        f(e);var t = e.element.style,
            r = "inline" === e.mainAxis ? ["main", "cross"] : ["cross", "main"];t.boxSizing = "content-box", t.display = "block", t.position = "relative", t.width = n(e.flexStyle[r[0]] - e.flexStyle[r[0] + "InnerBefore"] - e.flexStyle[r[0] + "InnerAfter"] - e.flexStyle[r[0] + "BorderBefore"] - e.flexStyle[r[0] + "BorderAfter"]), t.height = n(e.flexStyle[r[1]] - e.flexStyle[r[1] + "InnerBefore"] - e.flexStyle[r[1] + "InnerAfter"] - e.flexStyle[r[1] + "BorderBefore"] - e.flexStyle[r[1] + "BorderAfter"]);for (var l, o = -1; l = e.children[++o];) {
          var i = l.element.style,
              s = "inline" === l.mainAxis ? ["main", "cross"] : ["cross", "main"];i.boxSizing = "content-box", i.display = "block", i.position = "absolute", "auto" !== l.flexStyle[s[0]] && (i.width = n(l.flexStyle[s[0]] - l.flexStyle[s[0] + "InnerBefore"] - l.flexStyle[s[0] + "InnerAfter"] - l.flexStyle[s[0] + "BorderBefore"] - l.flexStyle[s[0] + "BorderAfter"])), "auto" !== l.flexStyle[s[1]] && (i.height = n(l.flexStyle[s[1]] - l.flexStyle[s[1] + "InnerBefore"] - l.flexStyle[s[1] + "InnerAfter"] - l.flexStyle[s[1] + "BorderBefore"] - l.flexStyle[s[1] + "BorderAfter"])), i.top = n(l.flexStyle[s[1] + "Start"]), i.left = n(l.flexStyle[s[0] + "Start"]), i.marginTop = n(l.flexStyle[s[1] + "Before"]), i.marginRight = n(l.flexStyle[s[0] + "After"]), i.marginBottom = n(l.flexStyle[s[1] + "After"]), i.marginLeft = n(l.flexStyle[s[0] + "Before"]);
        }
      }function n(e) {
        return "string" == typeof e ? e : Math.max(e, 0) + "px";
      }t.exports = l;var f = e("../flexbox");
    }, { "../flexbox": 7 }], 18: [function (e, t, r) {
      function l(e) {
        for (var t, r = -1; t = e[++r];) n(t);
      }t.exports = l;var n = e("../write");
    }, { "../write": 17 }] }, {}, [13])(13);
});

/***/ }),
/* 26 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* WEBPACK VAR INJECTION */(function(global) {/**!
 * @fileOverview Kickass library to create and place poppers near their reference elements.
 * @version 1.16.1
 * @license
 * Copyright (c) 2016 Federico Zivolo and contributors
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */


Object.defineProperty(exports, '__esModule', {
  value: true
});
var isBrowser = typeof window !== 'undefined' && typeof document !== 'undefined' && typeof navigator !== 'undefined';

var timeoutDuration = (function () {
  var longerTimeoutBrowsers = ['Edge', 'Trident', 'Firefox'];
  for (var i = 0; i < longerTimeoutBrowsers.length; i += 1) {
    if (isBrowser && navigator.userAgent.indexOf(longerTimeoutBrowsers[i]) >= 0) {
      return 1;
    }
  }
  return 0;
})();

function microtaskDebounce(fn) {
  var called = false;
  return function () {
    if (called) {
      return;
    }
    called = true;
    window.Promise.resolve().then(function () {
      called = false;
      fn();
    });
  };
}

function taskDebounce(fn) {
  var scheduled = false;
  return function () {
    if (!scheduled) {
      scheduled = true;
      setTimeout(function () {
        scheduled = false;
        fn();
      }, timeoutDuration);
    }
  };
}

var supportsMicroTasks = isBrowser && window.Promise;

/**
* Create a debounced version of a method, that's asynchronously deferred
* but called in the minimum time possible.
*
* @method
* @memberof Popper.Utils
* @argument {Function} fn
* @returns {Function}
*/
var debounce = supportsMicroTasks ? microtaskDebounce : taskDebounce;

/**
 * Check if the given variable is a function
 * @method
 * @memberof Popper.Utils
 * @argument {Any} functionToCheck - variable to check
 * @returns {Boolean} answer to: is a function?
 */
function isFunction(functionToCheck) {
  var getType = {};
  return functionToCheck && getType.toString.call(functionToCheck) === '[object Function]';
}

/**
 * Get CSS computed property of the given element
 * @method
 * @memberof Popper.Utils
 * @argument {Eement} element
 * @argument {String} property
 */
function getStyleComputedProperty(element, property) {
  if (element.nodeType !== 1) {
    return [];
  }
  // NOTE: 1 DOM access here
  var window = element.ownerDocument.defaultView;
  var css = window.getComputedStyle(element, null);
  return property ? css[property] : css;
}

/**
 * Returns the parentNode or the host of the element
 * @method
 * @memberof Popper.Utils
 * @argument {Element} element
 * @returns {Element} parent
 */
function getParentNode(element) {
  if (element.nodeName === 'HTML') {
    return element;
  }
  return element.parentNode || element.host;
}

/**
 * Returns the scrolling parent of the given element
 * @method
 * @memberof Popper.Utils
 * @argument {Element} element
 * @returns {Element} scroll parent
 */
function getScrollParent(_x) {
  var _again = true;

  _function: while (_again) {
    var element = _x;
    _again = false;

    // Return body, `getScroll` will take care to get the correct `scrollTop` from it
    if (!element) {
      return document.body;
    }

    switch (element.nodeName) {
      case 'HTML':
      case 'BODY':
        return element.ownerDocument.body;
      case '#document':
        return element.body;
    }

    // Firefox want us to check `-x` and `-y` variations as well

    var _getStyleComputedProp = getStyleComputedProperty(element),
        overflow = _getStyleComputedProp.overflow,
        overflowX = _getStyleComputedProp.overflowX,
        overflowY = _getStyleComputedProp.overflowY;

    if (/(auto|scroll|overlay)/.test(overflow + overflowY + overflowX)) {
      return element;
    }

    _x = getParentNode(element);
    _again = true;
    _getStyleComputedProp = overflow = overflowX = overflowY = undefined;
    continue _function;
  }
}

/**
 * Returns the reference node of the reference object, or the reference object itself.
 * @method
 * @memberof Popper.Utils
 * @param {Element|Object} reference - the reference element (the popper will be relative to this)
 * @returns {Element} parent
 */
function getReferenceNode(reference) {
  return reference && reference.referenceNode ? reference.referenceNode : reference;
}

var isIE11 = isBrowser && !!(window.MSInputMethodContext && document.documentMode);
var isIE10 = isBrowser && /MSIE 10/.test(navigator.userAgent);

/**
 * Determines if the browser is Internet Explorer
 * @method
 * @memberof Popper.Utils
 * @param {Number} version to check
 * @returns {Boolean} isIE
 */
function isIE(version) {
  if (version === 11) {
    return isIE11;
  }
  if (version === 10) {
    return isIE10;
  }
  return isIE11 || isIE10;
}

/**
 * Returns the offset parent of the given element
 * @method
 * @memberof Popper.Utils
 * @argument {Element} element
 * @returns {Element} offset parent
 */
function getOffsetParent(_x2) {
  var _again2 = true;

  _function2: while (_again2) {
    var element = _x2;
    _again2 = false;

    if (!element) {
      return document.documentElement;
    }

    var noOffsetParent = isIE(10) ? document.body : null;

    // NOTE: 1 DOM access here
    var offsetParent = element.offsetParent || null;
    // Skip hidden elements which don't have an offsetParent
    while (offsetParent === noOffsetParent && element.nextElementSibling) {
      offsetParent = (element = element.nextElementSibling).offsetParent;
    }

    var nodeName = offsetParent && offsetParent.nodeName;

    if (!nodeName || nodeName === 'BODY' || nodeName === 'HTML') {
      return element ? element.ownerDocument.documentElement : document.documentElement;
    }

    // .offsetParent will return the closest TH, TD or TABLE in case
    // no offsetParent is present, I hate this job...
    if (['TH', 'TD', 'TABLE'].indexOf(offsetParent.nodeName) !== -1 && getStyleComputedProperty(offsetParent, 'position') === 'static') {
      _x2 = offsetParent;
      _again2 = true;
      noOffsetParent = offsetParent = nodeName = undefined;
      continue _function2;
    }

    return offsetParent;
  }
}

function isOffsetContainer(element) {
  var nodeName = element.nodeName;

  if (nodeName === 'BODY') {
    return false;
  }
  return nodeName === 'HTML' || getOffsetParent(element.firstElementChild) === element;
}

/**
 * Finds the root node (document, shadowDOM root) of the given element
 * @method
 * @memberof Popper.Utils
 * @argument {Element} node
 * @returns {Element} root node
 */
function getRoot(_x3) {
  var _again3 = true;

  _function3: while (_again3) {
    var node = _x3;
    _again3 = false;

    if (node.parentNode !== null) {
      _x3 = node.parentNode;
      _again3 = true;
      continue _function3;
    }

    return node;
  }
}

/**
 * Finds the offset parent common to the two provided nodes
 * @method
 * @memberof Popper.Utils
 * @argument {Element} element1
 * @argument {Element} element2
 * @returns {Element} common offset parent
 */
function findCommonOffsetParent(_x4, _x5) {
  var _again4 = true;

  _function4: while (_again4) {
    var element1 = _x4,
        element2 = _x5;
    _again4 = false;

    // This check is needed to avoid errors in case one of the elements isn't defined for any reason
    if (!element1 || !element1.nodeType || !element2 || !element2.nodeType) {
      return document.documentElement;
    }

    // Here we make sure to give as "start" the element that comes first in the DOM
    var order = element1.compareDocumentPosition(element2) & Node.DOCUMENT_POSITION_FOLLOWING;
    var start = order ? element1 : element2;
    var end = order ? element2 : element1;

    // Get common ancestor container
    var range = document.createRange();
    range.setStart(start, 0);
    range.setEnd(end, 0);
    var commonAncestorContainer = range.commonAncestorContainer;

    // Both nodes are inside #document

    if (element1 !== commonAncestorContainer && element2 !== commonAncestorContainer || start.contains(end)) {
      if (isOffsetContainer(commonAncestorContainer)) {
        return commonAncestorContainer;
      }

      return getOffsetParent(commonAncestorContainer);
    }

    // one of the nodes is inside shadowDOM, find which one
    var element1root = getRoot(element1);
    if (element1root.host) {
      _x4 = element1root.host;
      _x5 = element2;
      _again4 = true;
      order = start = end = range = commonAncestorContainer = element1root = undefined;
      continue _function4;
    } else {
      _x4 = element1;
      _x5 = getRoot(element2).host;
      _again4 = true;
      order = start = end = range = commonAncestorContainer = element1root = undefined;
      continue _function4;
    }
  }
}

/**
 * Gets the scroll value of the given element in the given side (top and left)
 * @method
 * @memberof Popper.Utils
 * @argument {Element} element
 * @argument {String} side `top` or `left`
 * @returns {number} amount of scrolled pixels
 */
function getScroll(element) {
  var side = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'top';

  var upperSide = side === 'top' ? 'scrollTop' : 'scrollLeft';
  var nodeName = element.nodeName;

  if (nodeName === 'BODY' || nodeName === 'HTML') {
    var html = element.ownerDocument.documentElement;
    var scrollingElement = element.ownerDocument.scrollingElement || html;
    return scrollingElement[upperSide];
  }

  return element[upperSide];
}

/*
 * Sum or subtract the element scroll values (left and top) from a given rect object
 * @method
 * @memberof Popper.Utils
 * @param {Object} rect - Rect object you want to change
 * @param {HTMLElement} element - The element from the function reads the scroll values
 * @param {Boolean} subtract - set to true if you want to subtract the scroll values
 * @return {Object} rect - The modifier rect object
 */
function includeScroll(rect, element) {
  var subtract = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;

  var scrollTop = getScroll(element, 'top');
  var scrollLeft = getScroll(element, 'left');
  var modifier = subtract ? -1 : 1;
  rect.top += scrollTop * modifier;
  rect.bottom += scrollTop * modifier;
  rect.left += scrollLeft * modifier;
  rect.right += scrollLeft * modifier;
  return rect;
}

/*
 * Helper to detect borders of a given element
 * @method
 * @memberof Popper.Utils
 * @param {CSSStyleDeclaration} styles
 * Result of `getStyleComputedProperty` on the given element
 * @param {String} axis - `x` or `y`
 * @return {number} borders - The borders size of the given axis
 */

function getBordersSize(styles, axis) {
  var sideA = axis === 'x' ? 'Left' : 'Top';
  var sideB = sideA === 'Left' ? 'Right' : 'Bottom';

  return parseFloat(styles['border' + sideA + 'Width']) + parseFloat(styles['border' + sideB + 'Width']);
}

function getSize(axis, body, html, computedStyle) {
  return Math.max(body['offset' + axis], body['scroll' + axis], html['client' + axis], html['offset' + axis], html['scroll' + axis], isIE(10) ? parseInt(html['offset' + axis]) + parseInt(computedStyle['margin' + (axis === 'Height' ? 'Top' : 'Left')]) + parseInt(computedStyle['margin' + (axis === 'Height' ? 'Bottom' : 'Right')]) : 0);
}

function getWindowSizes(document) {
  var body = document.body;
  var html = document.documentElement;
  var computedStyle = isIE(10) && getComputedStyle(html);

  return {
    height: getSize('Height', body, html, computedStyle),
    width: getSize('Width', body, html, computedStyle)
  };
}

var classCallCheck = function classCallCheck(instance, Constructor) {
  if (!(instance instanceof Constructor)) {
    throw new TypeError("Cannot call a class as a function");
  }
};

var createClass = (function () {
  function defineProperties(target, props) {
    for (var i = 0; i < props.length; i++) {
      var descriptor = props[i];
      descriptor.enumerable = descriptor.enumerable || false;
      descriptor.configurable = true;
      if ("value" in descriptor) descriptor.writable = true;
      Object.defineProperty(target, descriptor.key, descriptor);
    }
  }

  return function (Constructor, protoProps, staticProps) {
    if (protoProps) defineProperties(Constructor.prototype, protoProps);
    if (staticProps) defineProperties(Constructor, staticProps);
    return Constructor;
  };
})();

var defineProperty = function defineProperty(obj, key, value) {
  if (key in obj) {
    Object.defineProperty(obj, key, {
      value: value,
      enumerable: true,
      configurable: true,
      writable: true
    });
  } else {
    obj[key] = value;
  }

  return obj;
};

var _extends = Object.assign || function (target) {
  for (var i = 1; i < arguments.length; i++) {
    var source = arguments[i];

    for (var key in source) {
      if (Object.prototype.hasOwnProperty.call(source, key)) {
        target[key] = source[key];
      }
    }
  }

  return target;
};

/**
 * Given element offsets, generate an output similar to getBoundingClientRect
 * @method
 * @memberof Popper.Utils
 * @argument {Object} offsets
 * @returns {Object} ClientRect like output
 */
function getClientRect(offsets) {
  return _extends({}, offsets, {
    right: offsets.left + offsets.width,
    bottom: offsets.top + offsets.height
  });
}

/**
 * Get bounding client rect of given element
 * @method
 * @memberof Popper.Utils
 * @param {HTMLElement} element
 * @return {Object} client rect
 */
function getBoundingClientRect(element) {
  var rect = {};

  // IE10 10 FIX: Please, don't ask, the element isn't
  // considered in DOM in some circumstances...
  // This isn't reproducible in IE10 compatibility mode of IE11
  try {
    if (isIE(10)) {
      rect = element.getBoundingClientRect();
      var scrollTop = getScroll(element, 'top');
      var scrollLeft = getScroll(element, 'left');
      rect.top += scrollTop;
      rect.left += scrollLeft;
      rect.bottom += scrollTop;
      rect.right += scrollLeft;
    } else {
      rect = element.getBoundingClientRect();
    }
  } catch (e) {}

  var result = {
    left: rect.left,
    top: rect.top,
    width: rect.right - rect.left,
    height: rect.bottom - rect.top
  };

  // subtract scrollbar size from sizes
  var sizes = element.nodeName === 'HTML' ? getWindowSizes(element.ownerDocument) : {};
  var width = sizes.width || element.clientWidth || result.width;
  var height = sizes.height || element.clientHeight || result.height;

  var horizScrollbar = element.offsetWidth - width;
  var vertScrollbar = element.offsetHeight - height;

  // if an hypothetical scrollbar is detected, we must be sure it's not a `border`
  // we make this check conditional for performance reasons
  if (horizScrollbar || vertScrollbar) {
    var styles = getStyleComputedProperty(element);
    horizScrollbar -= getBordersSize(styles, 'x');
    vertScrollbar -= getBordersSize(styles, 'y');

    result.width -= horizScrollbar;
    result.height -= vertScrollbar;
  }

  return getClientRect(result);
}

function getOffsetRectRelativeToArbitraryNode(children, parent) {
  var fixedPosition = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;

  var isIE10 = isIE(10);
  var isHTML = parent.nodeName === 'HTML';
  var childrenRect = getBoundingClientRect(children);
  var parentRect = getBoundingClientRect(parent);
  var scrollParent = getScrollParent(children);

  var styles = getStyleComputedProperty(parent);
  var borderTopWidth = parseFloat(styles.borderTopWidth);
  var borderLeftWidth = parseFloat(styles.borderLeftWidth);

  // In cases where the parent is fixed, we must ignore negative scroll in offset calc
  if (fixedPosition && isHTML) {
    parentRect.top = Math.max(parentRect.top, 0);
    parentRect.left = Math.max(parentRect.left, 0);
  }
  var offsets = getClientRect({
    top: childrenRect.top - parentRect.top - borderTopWidth,
    left: childrenRect.left - parentRect.left - borderLeftWidth,
    width: childrenRect.width,
    height: childrenRect.height
  });
  offsets.marginTop = 0;
  offsets.marginLeft = 0;

  // Subtract margins of documentElement in case it's being used as parent
  // we do this only on HTML because it's the only element that behaves
  // differently when margins are applied to it. The margins are included in
  // the box of the documentElement, in the other cases not.
  if (!isIE10 && isHTML) {
    var marginTop = parseFloat(styles.marginTop);
    var marginLeft = parseFloat(styles.marginLeft);

    offsets.top -= borderTopWidth - marginTop;
    offsets.bottom -= borderTopWidth - marginTop;
    offsets.left -= borderLeftWidth - marginLeft;
    offsets.right -= borderLeftWidth - marginLeft;

    // Attach marginTop and marginLeft because in some circumstances we may need them
    offsets.marginTop = marginTop;
    offsets.marginLeft = marginLeft;
  }

  if (isIE10 && !fixedPosition ? parent.contains(scrollParent) : parent === scrollParent && scrollParent.nodeName !== 'BODY') {
    offsets = includeScroll(offsets, parent);
  }

  return offsets;
}

function getViewportOffsetRectRelativeToArtbitraryNode(element) {
  var excludeScroll = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;

  var html = element.ownerDocument.documentElement;
  var relativeOffset = getOffsetRectRelativeToArbitraryNode(element, html);
  var width = Math.max(html.clientWidth, window.innerWidth || 0);
  var height = Math.max(html.clientHeight, window.innerHeight || 0);

  var scrollTop = !excludeScroll ? getScroll(html) : 0;
  var scrollLeft = !excludeScroll ? getScroll(html, 'left') : 0;

  var offset = {
    top: scrollTop - relativeOffset.top + relativeOffset.marginTop,
    left: scrollLeft - relativeOffset.left + relativeOffset.marginLeft,
    width: width,
    height: height
  };

  return getClientRect(offset);
}

/**
 * Check if the given element is fixed or is inside a fixed parent
 * @method
 * @memberof Popper.Utils
 * @argument {Element} element
 * @argument {Element} customContainer
 * @returns {Boolean} answer to "isFixed?"
 */
function isFixed(_x6) {
  var _again5 = true;

  _function5: while (_again5) {
    var element = _x6;
    _again5 = false;

    var nodeName = element.nodeName;
    if (nodeName === 'BODY' || nodeName === 'HTML') {
      return false;
    }
    if (getStyleComputedProperty(element, 'position') === 'fixed') {
      return true;
    }
    var parentNode = getParentNode(element);
    if (!parentNode) {
      return false;
    }
    _x6 = parentNode;
    _again5 = true;
    nodeName = parentNode = undefined;
    continue _function5;
  }
}

/**
 * Finds the first parent of an element that has a transformed property defined
 * @method
 * @memberof Popper.Utils
 * @argument {Element} element
 * @returns {Element} first transformed parent or documentElement
 */

function getFixedPositionOffsetParent(element) {
  // This check is needed to avoid errors in case one of the elements isn't defined for any reason
  if (!element || !element.parentElement || isIE()) {
    return document.documentElement;
  }
  var el = element.parentElement;
  while (el && getStyleComputedProperty(el, 'transform') === 'none') {
    el = el.parentElement;
  }
  return el || document.documentElement;
}

/**
 * Computed the boundaries limits and return them
 * @method
 * @memberof Popper.Utils
 * @param {HTMLElement} popper
 * @param {HTMLElement} reference
 * @param {number} padding
 * @param {HTMLElement} boundariesElement - Element used to define the boundaries
 * @param {Boolean} fixedPosition - Is in fixed position mode
 * @returns {Object} Coordinates of the boundaries
 */
function getBoundaries(popper, reference, padding, boundariesElement) {
  var fixedPosition = arguments.length > 4 && arguments[4] !== undefined ? arguments[4] : false;

  // NOTE: 1 DOM access here

  var boundaries = { top: 0, left: 0 };
  var offsetParent = fixedPosition ? getFixedPositionOffsetParent(popper) : findCommonOffsetParent(popper, getReferenceNode(reference));

  // Handle viewport case
  if (boundariesElement === 'viewport') {
    boundaries = getViewportOffsetRectRelativeToArtbitraryNode(offsetParent, fixedPosition);
  } else {
    // Handle other cases based on DOM element used as boundaries
    var boundariesNode = void 0;
    if (boundariesElement === 'scrollParent') {
      boundariesNode = getScrollParent(getParentNode(reference));
      if (boundariesNode.nodeName === 'BODY') {
        boundariesNode = popper.ownerDocument.documentElement;
      }
    } else if (boundariesElement === 'window') {
      boundariesNode = popper.ownerDocument.documentElement;
    } else {
      boundariesNode = boundariesElement;
    }

    var offsets = getOffsetRectRelativeToArbitraryNode(boundariesNode, offsetParent, fixedPosition);

    // In case of HTML, we need a different computation
    if (boundariesNode.nodeName === 'HTML' && !isFixed(offsetParent)) {
      var _getWindowSizes = getWindowSizes(popper.ownerDocument),
          height = _getWindowSizes.height,
          width = _getWindowSizes.width;

      boundaries.top += offsets.top - offsets.marginTop;
      boundaries.bottom = height + offsets.top;
      boundaries.left += offsets.left - offsets.marginLeft;
      boundaries.right = width + offsets.left;
    } else {
      // for all the other DOM elements, this one is good
      boundaries = offsets;
    }
  }

  // Add paddings
  padding = padding || 0;
  var isPaddingNumber = typeof padding === 'number';
  boundaries.left += isPaddingNumber ? padding : padding.left || 0;
  boundaries.top += isPaddingNumber ? padding : padding.top || 0;
  boundaries.right -= isPaddingNumber ? padding : padding.right || 0;
  boundaries.bottom -= isPaddingNumber ? padding : padding.bottom || 0;

  return boundaries;
}

function getArea(_ref) {
  var width = _ref.width,
      height = _ref.height;

  return width * height;
}

/**
 * Utility used to transform the `auto` placement to the placement with more
 * available space.
 * @method
 * @memberof Popper.Utils
 * @argument {Object} data - The data object generated by update method
 * @argument {Object} options - Modifiers configuration and options
 * @returns {Object} The data object, properly modified
 */
function computeAutoPlacement(placement, refRect, popper, reference, boundariesElement) {
  var padding = arguments.length > 5 && arguments[5] !== undefined ? arguments[5] : 0;

  if (placement.indexOf('auto') === -1) {
    return placement;
  }

  var boundaries = getBoundaries(popper, reference, padding, boundariesElement);

  var rects = {
    top: {
      width: boundaries.width,
      height: refRect.top - boundaries.top
    },
    right: {
      width: boundaries.right - refRect.right,
      height: boundaries.height
    },
    bottom: {
      width: boundaries.width,
      height: boundaries.bottom - refRect.bottom
    },
    left: {
      width: refRect.left - boundaries.left,
      height: boundaries.height
    }
  };

  var sortedAreas = Object.keys(rects).map(function (key) {
    return _extends({
      key: key
    }, rects[key], {
      area: getArea(rects[key])
    });
  }).sort(function (a, b) {
    return b.area - a.area;
  });

  var filteredAreas = sortedAreas.filter(function (_ref2) {
    var width = _ref2.width,
        height = _ref2.height;
    return width >= popper.clientWidth && height >= popper.clientHeight;
  });

  var computedPlacement = filteredAreas.length > 0 ? filteredAreas[0].key : sortedAreas[0].key;

  var variation = placement.split('-')[1];

  return computedPlacement + (variation ? '-' + variation : '');
}

/**
 * Get offsets to the reference element
 * @method
 * @memberof Popper.Utils
 * @param {Object} state
 * @param {Element} popper - the popper element
 * @param {Element} reference - the reference element (the popper will be relative to this)
 * @param {Element} fixedPosition - is in fixed position mode
 * @returns {Object} An object containing the offsets which will be applied to the popper
 */
function getReferenceOffsets(state, popper, reference) {
  var fixedPosition = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : null;

  var commonOffsetParent = fixedPosition ? getFixedPositionOffsetParent(popper) : findCommonOffsetParent(popper, getReferenceNode(reference));
  return getOffsetRectRelativeToArbitraryNode(reference, commonOffsetParent, fixedPosition);
}

/**
 * Get the outer sizes of the given element (offset size + margins)
 * @method
 * @memberof Popper.Utils
 * @argument {Element} element
 * @returns {Object} object containing width and height properties
 */
function getOuterSizes(element) {
  var window = element.ownerDocument.defaultView;
  var styles = window.getComputedStyle(element);
  var x = parseFloat(styles.marginTop || 0) + parseFloat(styles.marginBottom || 0);
  var y = parseFloat(styles.marginLeft || 0) + parseFloat(styles.marginRight || 0);
  var result = {
    width: element.offsetWidth + y,
    height: element.offsetHeight + x
  };
  return result;
}

/**
 * Get the opposite placement of the given one
 * @method
 * @memberof Popper.Utils
 * @argument {String} placement
 * @returns {String} flipped placement
 */
function getOppositePlacement(placement) {
  var hash = { left: 'right', right: 'left', bottom: 'top', top: 'bottom' };
  return placement.replace(/left|right|bottom|top/g, function (matched) {
    return hash[matched];
  });
}

/**
 * Get offsets to the popper
 * @method
 * @memberof Popper.Utils
 * @param {Object} position - CSS position the Popper will get applied
 * @param {HTMLElement} popper - the popper element
 * @param {Object} referenceOffsets - the reference offsets (the popper will be relative to this)
 * @param {String} placement - one of the valid placement options
 * @returns {Object} popperOffsets - An object containing the offsets which will be applied to the popper
 */
function getPopperOffsets(popper, referenceOffsets, placement) {
  placement = placement.split('-')[0];

  // Get popper node sizes
  var popperRect = getOuterSizes(popper);

  // Add position, width and height to our offsets object
  var popperOffsets = {
    width: popperRect.width,
    height: popperRect.height
  };

  // depending by the popper placement we have to compute its offsets slightly differently
  var isHoriz = ['right', 'left'].indexOf(placement) !== -1;
  var mainSide = isHoriz ? 'top' : 'left';
  var secondarySide = isHoriz ? 'left' : 'top';
  var measurement = isHoriz ? 'height' : 'width';
  var secondaryMeasurement = !isHoriz ? 'height' : 'width';

  popperOffsets[mainSide] = referenceOffsets[mainSide] + referenceOffsets[measurement] / 2 - popperRect[measurement] / 2;
  if (placement === secondarySide) {
    popperOffsets[secondarySide] = referenceOffsets[secondarySide] - popperRect[secondaryMeasurement];
  } else {
    popperOffsets[secondarySide] = referenceOffsets[getOppositePlacement(secondarySide)];
  }

  return popperOffsets;
}

/**
 * Mimics the `find` method of Array
 * @method
 * @memberof Popper.Utils
 * @argument {Array} arr
 * @argument prop
 * @argument value
 * @returns index or -1
 */
function find(arr, check) {
  // use native find if supported
  if (Array.prototype.find) {
    return arr.find(check);
  }

  // use `filter` to obtain the same behavior of `find`
  return arr.filter(check)[0];
}

/**
 * Return the index of the matching object
 * @method
 * @memberof Popper.Utils
 * @argument {Array} arr
 * @argument prop
 * @argument value
 * @returns index or -1
 */
function findIndex(arr, prop, value) {
  // use native findIndex if supported
  if (Array.prototype.findIndex) {
    return arr.findIndex(function (cur) {
      return cur[prop] === value;
    });
  }

  // use `find` + `indexOf` if `findIndex` isn't supported
  var match = find(arr, function (obj) {
    return obj[prop] === value;
  });
  return arr.indexOf(match);
}

/**
 * Loop trough the list of modifiers and run them in order,
 * each of them will then edit the data object.
 * @method
 * @memberof Popper.Utils
 * @param {dataObject} data
 * @param {Array} modifiers
 * @param {String} ends - Optional modifier name used as stopper
 * @returns {dataObject}
 */
function runModifiers(modifiers, data, ends) {
  var modifiersToRun = ends === undefined ? modifiers : modifiers.slice(0, findIndex(modifiers, 'name', ends));

  modifiersToRun.forEach(function (modifier) {
    if (modifier['function']) {
      // eslint-disable-line dot-notation
      console.warn('`modifier.function` is deprecated, use `modifier.fn`!');
    }
    var fn = modifier['function'] || modifier.fn; // eslint-disable-line dot-notation
    if (modifier.enabled && isFunction(fn)) {
      // Add properties to offsets to make them a complete clientRect object
      // we do this before each modifier to make sure the previous one doesn't
      // mess with these values
      data.offsets.popper = getClientRect(data.offsets.popper);
      data.offsets.reference = getClientRect(data.offsets.reference);

      data = fn(data, modifier);
    }
  });

  return data;
}

/**
 * Updates the position of the popper, computing the new offsets and applying
 * the new style.<br />
 * Prefer `scheduleUpdate` over `update` because of performance reasons.
 * @method
 * @memberof Popper
 */
function update() {
  // if popper is destroyed, don't perform any further update
  if (this.state.isDestroyed) {
    return;
  }

  var data = {
    instance: this,
    styles: {},
    arrowStyles: {},
    attributes: {},
    flipped: false,
    offsets: {}
  };

  // compute reference element offsets
  data.offsets.reference = getReferenceOffsets(this.state, this.popper, this.reference, this.options.positionFixed);

  // compute auto placement, store placement inside the data object,
  // modifiers will be able to edit `placement` if needed
  // and refer to originalPlacement to know the original value
  data.placement = computeAutoPlacement(this.options.placement, data.offsets.reference, this.popper, this.reference, this.options.modifiers.flip.boundariesElement, this.options.modifiers.flip.padding);

  // store the computed placement inside `originalPlacement`
  data.originalPlacement = data.placement;

  data.positionFixed = this.options.positionFixed;

  // compute the popper offsets
  data.offsets.popper = getPopperOffsets(this.popper, data.offsets.reference, data.placement);

  data.offsets.popper.position = this.options.positionFixed ? 'fixed' : 'absolute';

  // run the modifiers
  data = runModifiers(this.modifiers, data);

  // the first `update` will call `onCreate` callback
  // the other ones will call `onUpdate` callback
  if (!this.state.isCreated) {
    this.state.isCreated = true;
    this.options.onCreate(data);
  } else {
    this.options.onUpdate(data);
  }
}

/**
 * Helper used to know if the given modifier is enabled.
 * @method
 * @memberof Popper.Utils
 * @returns {Boolean}
 */
function isModifierEnabled(modifiers, modifierName) {
  return modifiers.some(function (_ref) {
    var name = _ref.name,
        enabled = _ref.enabled;
    return enabled && name === modifierName;
  });
}

/**
 * Get the prefixed supported property name
 * @method
 * @memberof Popper.Utils
 * @argument {String} property (camelCase)
 * @returns {String} prefixed property (camelCase or PascalCase, depending on the vendor prefix)
 */
function getSupportedPropertyName(property) {
  var prefixes = [false, 'ms', 'Webkit', 'Moz', 'O'];
  var upperProp = property.charAt(0).toUpperCase() + property.slice(1);

  for (var i = 0; i < prefixes.length; i++) {
    var prefix = prefixes[i];
    var toCheck = prefix ? '' + prefix + upperProp : property;
    if (typeof document.body.style[toCheck] !== 'undefined') {
      return toCheck;
    }
  }
  return null;
}

/**
 * Destroys the popper.
 * @method
 * @memberof Popper
 */
function destroy() {
  this.state.isDestroyed = true;

  // touch DOM only if `applyStyle` modifier is enabled
  if (isModifierEnabled(this.modifiers, 'applyStyle')) {
    this.popper.removeAttribute('x-placement');
    this.popper.style.position = '';
    this.popper.style.top = '';
    this.popper.style.left = '';
    this.popper.style.right = '';
    this.popper.style.bottom = '';
    this.popper.style.willChange = '';
    this.popper.style[getSupportedPropertyName('transform')] = '';
  }

  this.disableEventListeners();

  // remove the popper if user explicitly asked for the deletion on destroy
  // do not use `remove` because IE11 doesn't support it
  if (this.options.removeOnDestroy) {
    this.popper.parentNode.removeChild(this.popper);
  }
  return this;
}

/**
 * Get the window associated with the element
 * @argument {Element} element
 * @returns {Window}
 */
function getWindow(element) {
  var ownerDocument = element.ownerDocument;
  return ownerDocument ? ownerDocument.defaultView : window;
}

function attachToScrollParents(scrollParent, event, callback, scrollParents) {
  var isBody = scrollParent.nodeName === 'BODY';
  var target = isBody ? scrollParent.ownerDocument.defaultView : scrollParent;
  target.addEventListener(event, callback, { passive: true });

  if (!isBody) {
    attachToScrollParents(getScrollParent(target.parentNode), event, callback, scrollParents);
  }
  scrollParents.push(target);
}

/**
 * Setup needed event listeners used to update the popper position
 * @method
 * @memberof Popper.Utils
 * @private
 */
function setupEventListeners(reference, options, state, updateBound) {
  // Resize event listener on window
  state.updateBound = updateBound;
  getWindow(reference).addEventListener('resize', state.updateBound, { passive: true });

  // Scroll event listener on scroll parents
  var scrollElement = getScrollParent(reference);
  attachToScrollParents(scrollElement, 'scroll', state.updateBound, state.scrollParents);
  state.scrollElement = scrollElement;
  state.eventsEnabled = true;

  return state;
}

/**
 * It will add resize/scroll events and start recalculating
 * position of the popper element when they are triggered.
 * @method
 * @memberof Popper
 */
function enableEventListeners() {
  if (!this.state.eventsEnabled) {
    this.state = setupEventListeners(this.reference, this.options, this.state, this.scheduleUpdate);
  }
}

/**
 * Remove event listeners used to update the popper position
 * @method
 * @memberof Popper.Utils
 * @private
 */
function removeEventListeners(reference, state) {
  // Remove resize event listener on window
  getWindow(reference).removeEventListener('resize', state.updateBound);

  // Remove scroll event listener on scroll parents
  state.scrollParents.forEach(function (target) {
    target.removeEventListener('scroll', state.updateBound);
  });

  // Reset state
  state.updateBound = null;
  state.scrollParents = [];
  state.scrollElement = null;
  state.eventsEnabled = false;
  return state;
}

/**
 * It will remove resize/scroll events and won't recalculate popper position
 * when they are triggered. It also won't trigger `onUpdate` callback anymore,
 * unless you call `update` method manually.
 * @method
 * @memberof Popper
 */
function disableEventListeners() {
  if (this.state.eventsEnabled) {
    cancelAnimationFrame(this.scheduleUpdate);
    this.state = removeEventListeners(this.reference, this.state);
  }
}

/**
 * Tells if a given input is a number
 * @method
 * @memberof Popper.Utils
 * @param {*} input to check
 * @return {Boolean}
 */
function isNumeric(n) {
  return n !== '' && !isNaN(parseFloat(n)) && isFinite(n);
}

/**
 * Set the style to the given popper
 * @method
 * @memberof Popper.Utils
 * @argument {Element} element - Element to apply the style to
 * @argument {Object} styles
 * Object with a list of properties and values which will be applied to the element
 */
function setStyles(element, styles) {
  Object.keys(styles).forEach(function (prop) {
    var unit = '';
    // add unit if the value is numeric and is one of the following
    if (['width', 'height', 'top', 'right', 'bottom', 'left'].indexOf(prop) !== -1 && isNumeric(styles[prop])) {
      unit = 'px';
    }
    element.style[prop] = styles[prop] + unit;
  });
}

/**
 * Set the attributes to the given popper
 * @method
 * @memberof Popper.Utils
 * @argument {Element} element - Element to apply the attributes to
 * @argument {Object} styles
 * Object with a list of properties and values which will be applied to the element
 */
function setAttributes(element, attributes) {
  Object.keys(attributes).forEach(function (prop) {
    var value = attributes[prop];
    if (value !== false) {
      element.setAttribute(prop, attributes[prop]);
    } else {
      element.removeAttribute(prop);
    }
  });
}

/**
 * @function
 * @memberof Modifiers
 * @argument {Object} data - The data object generated by `update` method
 * @argument {Object} data.styles - List of style properties - values to apply to popper element
 * @argument {Object} data.attributes - List of attribute properties - values to apply to popper element
 * @argument {Object} options - Modifiers configuration and options
 * @returns {Object} The same data object
 */
function applyStyle(data) {
  // any property present in `data.styles` will be applied to the popper,
  // in this way we can make the 3rd party modifiers add custom styles to it
  // Be aware, modifiers could override the properties defined in the previous
  // lines of this modifier!
  setStyles(data.instance.popper, data.styles);

  // any property present in `data.attributes` will be applied to the popper,
  // they will be set as HTML attributes of the element
  setAttributes(data.instance.popper, data.attributes);

  // if arrowElement is defined and arrowStyles has some properties
  if (data.arrowElement && Object.keys(data.arrowStyles).length) {
    setStyles(data.arrowElement, data.arrowStyles);
  }

  return data;
}

/**
 * Set the x-placement attribute before everything else because it could be used
 * to add margins to the popper margins needs to be calculated to get the
 * correct popper offsets.
 * @method
 * @memberof Popper.modifiers
 * @param {HTMLElement} reference - The reference element used to position the popper
 * @param {HTMLElement} popper - The HTML element used as popper
 * @param {Object} options - Popper.js options
 */
function applyStyleOnLoad(reference, popper, options, modifierOptions, state) {
  // compute reference element offsets
  var referenceOffsets = getReferenceOffsets(state, popper, reference, options.positionFixed);

  // compute auto placement, store placement inside the data object,
  // modifiers will be able to edit `placement` if needed
  // and refer to originalPlacement to know the original value
  var placement = computeAutoPlacement(options.placement, referenceOffsets, popper, reference, options.modifiers.flip.boundariesElement, options.modifiers.flip.padding);

  popper.setAttribute('x-placement', placement);

  // Apply `position` to popper before anything else because
  // without the position applied we can't guarantee correct computations
  setStyles(popper, { position: options.positionFixed ? 'fixed' : 'absolute' });

  return options;
}

/**
 * @function
 * @memberof Popper.Utils
 * @argument {Object} data - The data object generated by `update` method
 * @argument {Boolean} shouldRound - If the offsets should be rounded at all
 * @returns {Object} The popper's position offsets rounded
 *
 * The tale of pixel-perfect positioning. It's still not 100% perfect, but as
 * good as it can be within reason.
 * Discussion here: https://github.com/FezVrasta/popper.js/pull/715
 *
 * Low DPI screens cause a popper to be blurry if not using full pixels (Safari
 * as well on High DPI screens).
 *
 * Firefox prefers no rounding for positioning and does not have blurriness on
 * high DPI screens.
 *
 * Only horizontal placement and left/right values need to be considered.
 */
function getRoundedOffsets(data, shouldRound) {
  var _data$offsets = data.offsets,
      popper = _data$offsets.popper,
      reference = _data$offsets.reference;
  var round = Math.round,
      floor = Math.floor;

  var noRound = function noRound(v) {
    return v;
  };

  var referenceWidth = round(reference.width);
  var popperWidth = round(popper.width);

  var isVertical = ['left', 'right'].indexOf(data.placement) !== -1;
  var isVariation = data.placement.indexOf('-') !== -1;
  var sameWidthParity = referenceWidth % 2 === popperWidth % 2;
  var bothOddWidth = referenceWidth % 2 === 1 && popperWidth % 2 === 1;

  var horizontalToInteger = !shouldRound ? noRound : isVertical || isVariation || sameWidthParity ? round : floor;
  var verticalToInteger = !shouldRound ? noRound : round;

  return {
    left: horizontalToInteger(bothOddWidth && !isVariation && shouldRound ? popper.left - 1 : popper.left),
    top: verticalToInteger(popper.top),
    bottom: verticalToInteger(popper.bottom),
    right: horizontalToInteger(popper.right)
  };
}

var isFirefox = isBrowser && /Firefox/i.test(navigator.userAgent);

/**
 * @function
 * @memberof Modifiers
 * @argument {Object} data - The data object generated by `update` method
 * @argument {Object} options - Modifiers configuration and options
 * @returns {Object} The data object, properly modified
 */
function computeStyle(data, options) {
  var x = options.x,
      y = options.y;
  var popper = data.offsets.popper;

  // Remove this legacy support in Popper.js v2

  var legacyGpuAccelerationOption = find(data.instance.modifiers, function (modifier) {
    return modifier.name === 'applyStyle';
  }).gpuAcceleration;
  if (legacyGpuAccelerationOption !== undefined) {
    console.warn('WARNING: `gpuAcceleration` option moved to `computeStyle` modifier and will not be supported in future versions of Popper.js!');
  }
  var gpuAcceleration = legacyGpuAccelerationOption !== undefined ? legacyGpuAccelerationOption : options.gpuAcceleration;

  var offsetParent = getOffsetParent(data.instance.popper);
  var offsetParentRect = getBoundingClientRect(offsetParent);

  // Styles
  var styles = {
    position: popper.position
  };

  var offsets = getRoundedOffsets(data, window.devicePixelRatio < 2 || !isFirefox);

  var sideA = x === 'bottom' ? 'top' : 'bottom';
  var sideB = y === 'right' ? 'left' : 'right';

  // if gpuAcceleration is set to `true` and transform is supported,
  //  we use `translate3d` to apply the position to the popper we
  // automatically use the supported prefixed version if needed
  var prefixedProperty = getSupportedPropertyName('transform');

  // now, let's make a step back and look at this code closely (wtf?)
  // If the content of the popper grows once it's been positioned, it
  // may happen that the popper gets misplaced because of the new content
  // overflowing its reference element
  // To avoid this problem, we provide two options (x and y), which allow
  // the consumer to define the offset origin.
  // If we position a popper on top of a reference element, we can set
  // `x` to `top` to make the popper grow towards its top instead of
  // its bottom.
  var left = void 0,
      top = void 0;
  if (sideA === 'bottom') {
    // when offsetParent is <html> the positioning is relative to the bottom of the screen (excluding the scrollbar)
    // and not the bottom of the html element
    if (offsetParent.nodeName === 'HTML') {
      top = -offsetParent.clientHeight + offsets.bottom;
    } else {
      top = -offsetParentRect.height + offsets.bottom;
    }
  } else {
    top = offsets.top;
  }
  if (sideB === 'right') {
    if (offsetParent.nodeName === 'HTML') {
      left = -offsetParent.clientWidth + offsets.right;
    } else {
      left = -offsetParentRect.width + offsets.right;
    }
  } else {
    left = offsets.left;
  }
  if (gpuAcceleration && prefixedProperty) {
    styles[prefixedProperty] = 'translate3d(' + left + 'px, ' + top + 'px, 0)';
    styles[sideA] = 0;
    styles[sideB] = 0;
    styles.willChange = 'transform';
  } else {
    // othwerise, we use the standard `top`, `left`, `bottom` and `right` properties
    var invertTop = sideA === 'bottom' ? -1 : 1;
    var invertLeft = sideB === 'right' ? -1 : 1;
    styles[sideA] = top * invertTop;
    styles[sideB] = left * invertLeft;
    styles.willChange = sideA + ', ' + sideB;
  }

  // Attributes
  var attributes = {
    'x-placement': data.placement
  };

  // Update `data` attributes, styles and arrowStyles
  data.attributes = _extends({}, attributes, data.attributes);
  data.styles = _extends({}, styles, data.styles);
  data.arrowStyles = _extends({}, data.offsets.arrow, data.arrowStyles);

  return data;
}

/**
 * Helper used to know if the given modifier depends from another one.<br />
 * It checks if the needed modifier is listed and enabled.
 * @method
 * @memberof Popper.Utils
 * @param {Array} modifiers - list of modifiers
 * @param {String} requestingName - name of requesting modifier
 * @param {String} requestedName - name of requested modifier
 * @returns {Boolean}
 */
function isModifierRequired(modifiers, requestingName, requestedName) {
  var requesting = find(modifiers, function (_ref) {
    var name = _ref.name;
    return name === requestingName;
  });

  var isRequired = !!requesting && modifiers.some(function (modifier) {
    return modifier.name === requestedName && modifier.enabled && modifier.order < requesting.order;
  });

  if (!isRequired) {
    var _requesting = '`' + requestingName + '`';
    var requested = '`' + requestedName + '`';
    console.warn(requested + ' modifier is required by ' + _requesting + ' modifier in order to work, be sure to include it before ' + _requesting + '!');
  }
  return isRequired;
}

/**
 * @function
 * @memberof Modifiers
 * @argument {Object} data - The data object generated by update method
 * @argument {Object} options - Modifiers configuration and options
 * @returns {Object} The data object, properly modified
 */
function arrow(data, options) {
  var _data$offsets$arrow;

  // arrow depends on keepTogether in order to work
  if (!isModifierRequired(data.instance.modifiers, 'arrow', 'keepTogether')) {
    return data;
  }

  var arrowElement = options.element;

  // if arrowElement is a string, suppose it's a CSS selector
  if (typeof arrowElement === 'string') {
    arrowElement = data.instance.popper.querySelector(arrowElement);

    // if arrowElement is not found, don't run the modifier
    if (!arrowElement) {
      return data;
    }
  } else {
    // if the arrowElement isn't a query selector we must check that the
    // provided DOM node is child of its popper node
    if (!data.instance.popper.contains(arrowElement)) {
      console.warn('WARNING: `arrow.element` must be child of its popper element!');
      return data;
    }
  }

  var placement = data.placement.split('-')[0];
  var _data$offsets = data.offsets,
      popper = _data$offsets.popper,
      reference = _data$offsets.reference;

  var isVertical = ['left', 'right'].indexOf(placement) !== -1;

  var len = isVertical ? 'height' : 'width';
  var sideCapitalized = isVertical ? 'Top' : 'Left';
  var side = sideCapitalized.toLowerCase();
  var altSide = isVertical ? 'left' : 'top';
  var opSide = isVertical ? 'bottom' : 'right';
  var arrowElementSize = getOuterSizes(arrowElement)[len];

  //
  // extends keepTogether behavior making sure the popper and its
  // reference have enough pixels in conjunction
  //

  // top/left side
  if (reference[opSide] - arrowElementSize < popper[side]) {
    data.offsets.popper[side] -= popper[side] - (reference[opSide] - arrowElementSize);
  }
  // bottom/right side
  if (reference[side] + arrowElementSize > popper[opSide]) {
    data.offsets.popper[side] += reference[side] + arrowElementSize - popper[opSide];
  }
  data.offsets.popper = getClientRect(data.offsets.popper);

  // compute center of the popper
  var center = reference[side] + reference[len] / 2 - arrowElementSize / 2;

  // Compute the sideValue using the updated popper offsets
  // take popper margin in account because we don't have this info available
  var css = getStyleComputedProperty(data.instance.popper);
  var popperMarginSide = parseFloat(css['margin' + sideCapitalized]);
  var popperBorderSide = parseFloat(css['border' + sideCapitalized + 'Width']);
  var sideValue = center - data.offsets.popper[side] - popperMarginSide - popperBorderSide;

  // prevent arrowElement from being placed not contiguously to its popper
  sideValue = Math.max(Math.min(popper[len] - arrowElementSize, sideValue), 0);

  data.arrowElement = arrowElement;
  data.offsets.arrow = (_data$offsets$arrow = {}, defineProperty(_data$offsets$arrow, side, Math.round(sideValue)), defineProperty(_data$offsets$arrow, altSide, ''), _data$offsets$arrow);

  return data;
}

/**
 * Get the opposite placement variation of the given one
 * @method
 * @memberof Popper.Utils
 * @argument {String} placement variation
 * @returns {String} flipped placement variation
 */
function getOppositeVariation(variation) {
  if (variation === 'end') {
    return 'start';
  } else if (variation === 'start') {
    return 'end';
  }
  return variation;
}

/**
 * List of accepted placements to use as values of the `placement` option.<br />
 * Valid placements are:
 * - `auto`
 * - `top`
 * - `right`
 * - `bottom`
 * - `left`
 *
 * Each placement can have a variation from this list:
 * - `-start`
 * - `-end`
 *
 * Variations are interpreted easily if you think of them as the left to right
 * written languages. Horizontally (`top` and `bottom`), `start` is left and `end`
 * is right.<br />
 * Vertically (`left` and `right`), `start` is top and `end` is bottom.
 *
 * Some valid examples are:
 * - `top-end` (on top of reference, right aligned)
 * - `right-start` (on right of reference, top aligned)
 * - `bottom` (on bottom, centered)
 * - `auto-end` (on the side with more space available, alignment depends by placement)
 *
 * @static
 * @type {Array}
 * @enum {String}
 * @readonly
 * @method placements
 * @memberof Popper
 */
var placements = ['auto-start', 'auto', 'auto-end', 'top-start', 'top', 'top-end', 'right-start', 'right', 'right-end', 'bottom-end', 'bottom', 'bottom-start', 'left-end', 'left', 'left-start'];

// Get rid of `auto` `auto-start` and `auto-end`
var validPlacements = placements.slice(3);

/**
 * Given an initial placement, returns all the subsequent placements
 * clockwise (or counter-clockwise).
 *
 * @method
 * @memberof Popper.Utils
 * @argument {String} placement - A valid placement (it accepts variations)
 * @argument {Boolean} counter - Set to true to walk the placements counterclockwise
 * @returns {Array} placements including their variations
 */
function clockwise(placement) {
  var counter = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;

  var index = validPlacements.indexOf(placement);
  var arr = validPlacements.slice(index + 1).concat(validPlacements.slice(0, index));
  return counter ? arr.reverse() : arr;
}

var BEHAVIORS = {
  FLIP: 'flip',
  CLOCKWISE: 'clockwise',
  COUNTERCLOCKWISE: 'counterclockwise'
};

/**
 * @function
 * @memberof Modifiers
 * @argument {Object} data - The data object generated by update method
 * @argument {Object} options - Modifiers configuration and options
 * @returns {Object} The data object, properly modified
 */
function flip(data, options) {
  // if `inner` modifier is enabled, we can't use the `flip` modifier
  if (isModifierEnabled(data.instance.modifiers, 'inner')) {
    return data;
  }

  if (data.flipped && data.placement === data.originalPlacement) {
    // seems like flip is trying to loop, probably there's not enough space on any of the flippable sides
    return data;
  }

  var boundaries = getBoundaries(data.instance.popper, data.instance.reference, options.padding, options.boundariesElement, data.positionFixed);

  var placement = data.placement.split('-')[0];
  var placementOpposite = getOppositePlacement(placement);
  var variation = data.placement.split('-')[1] || '';

  var flipOrder = [];

  switch (options.behavior) {
    case BEHAVIORS.FLIP:
      flipOrder = [placement, placementOpposite];
      break;
    case BEHAVIORS.CLOCKWISE:
      flipOrder = clockwise(placement);
      break;
    case BEHAVIORS.COUNTERCLOCKWISE:
      flipOrder = clockwise(placement, true);
      break;
    default:
      flipOrder = options.behavior;
  }

  flipOrder.forEach(function (step, index) {
    if (placement !== step || flipOrder.length === index + 1) {
      return data;
    }

    placement = data.placement.split('-')[0];
    placementOpposite = getOppositePlacement(placement);

    var popperOffsets = data.offsets.popper;
    var refOffsets = data.offsets.reference;

    // using floor because the reference offsets may contain decimals we are not going to consider here
    var floor = Math.floor;
    var overlapsRef = placement === 'left' && floor(popperOffsets.right) > floor(refOffsets.left) || placement === 'right' && floor(popperOffsets.left) < floor(refOffsets.right) || placement === 'top' && floor(popperOffsets.bottom) > floor(refOffsets.top) || placement === 'bottom' && floor(popperOffsets.top) < floor(refOffsets.bottom);

    var overflowsLeft = floor(popperOffsets.left) < floor(boundaries.left);
    var overflowsRight = floor(popperOffsets.right) > floor(boundaries.right);
    var overflowsTop = floor(popperOffsets.top) < floor(boundaries.top);
    var overflowsBottom = floor(popperOffsets.bottom) > floor(boundaries.bottom);

    var overflowsBoundaries = placement === 'left' && overflowsLeft || placement === 'right' && overflowsRight || placement === 'top' && overflowsTop || placement === 'bottom' && overflowsBottom;

    // flip the variation if required
    var isVertical = ['top', 'bottom'].indexOf(placement) !== -1;

    // flips variation if reference element overflows boundaries
    var flippedVariationByRef = !!options.flipVariations && (isVertical && variation === 'start' && overflowsLeft || isVertical && variation === 'end' && overflowsRight || !isVertical && variation === 'start' && overflowsTop || !isVertical && variation === 'end' && overflowsBottom);

    // flips variation if popper content overflows boundaries
    var flippedVariationByContent = !!options.flipVariationsByContent && (isVertical && variation === 'start' && overflowsRight || isVertical && variation === 'end' && overflowsLeft || !isVertical && variation === 'start' && overflowsBottom || !isVertical && variation === 'end' && overflowsTop);

    var flippedVariation = flippedVariationByRef || flippedVariationByContent;

    if (overlapsRef || overflowsBoundaries || flippedVariation) {
      // this boolean to detect any flip loop
      data.flipped = true;

      if (overlapsRef || overflowsBoundaries) {
        placement = flipOrder[index + 1];
      }

      if (flippedVariation) {
        variation = getOppositeVariation(variation);
      }

      data.placement = placement + (variation ? '-' + variation : '');

      // this object contains `position`, we want to preserve it along with
      // any additional property we may add in the future
      data.offsets.popper = _extends({}, data.offsets.popper, getPopperOffsets(data.instance.popper, data.offsets.reference, data.placement));

      data = runModifiers(data.instance.modifiers, data, 'flip');
    }
  });
  return data;
}

/**
 * @function
 * @memberof Modifiers
 * @argument {Object} data - The data object generated by update method
 * @argument {Object} options - Modifiers configuration and options
 * @returns {Object} The data object, properly modified
 */
function keepTogether(data) {
  var _data$offsets = data.offsets,
      popper = _data$offsets.popper,
      reference = _data$offsets.reference;

  var placement = data.placement.split('-')[0];
  var floor = Math.floor;
  var isVertical = ['top', 'bottom'].indexOf(placement) !== -1;
  var side = isVertical ? 'right' : 'bottom';
  var opSide = isVertical ? 'left' : 'top';
  var measurement = isVertical ? 'width' : 'height';

  if (popper[side] < floor(reference[opSide])) {
    data.offsets.popper[opSide] = floor(reference[opSide]) - popper[measurement];
  }
  if (popper[opSide] > floor(reference[side])) {
    data.offsets.popper[opSide] = floor(reference[side]);
  }

  return data;
}

/**
 * Converts a string containing value + unit into a px value number
 * @function
 * @memberof {modifiers~offset}
 * @private
 * @argument {String} str - Value + unit string
 * @argument {String} measurement - `height` or `width`
 * @argument {Object} popperOffsets
 * @argument {Object} referenceOffsets
 * @returns {Number|String}
 * Value in pixels, or original string if no values were extracted
 */
function toValue(str, measurement, popperOffsets, referenceOffsets) {
  // separate value from unit
  var split = str.match(/((?:\-|\+)?\d*\.?\d*)(.*)/);
  var value = +split[1];
  var unit = split[2];

  // If it's not a number it's an operator, I guess
  if (!value) {
    return str;
  }

  if (unit.indexOf('%') === 0) {
    var element = void 0;
    switch (unit) {
      case '%p':
        element = popperOffsets;
        break;
      case '%':
      case '%r':
      default:
        element = referenceOffsets;
    }

    var rect = getClientRect(element);
    return rect[measurement] / 100 * value;
  } else if (unit === 'vh' || unit === 'vw') {
    // if is a vh or vw, we calculate the size based on the viewport
    var size = void 0;
    if (unit === 'vh') {
      size = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
    } else {
      size = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
    }
    return size / 100 * value;
  } else {
    // if is an explicit pixel unit, we get rid of the unit and keep the value
    // if is an implicit unit, it's px, and we return just the value
    return value;
  }
}

/**
 * Parse an `offset` string to extrapolate `x` and `y` numeric offsets.
 * @function
 * @memberof {modifiers~offset}
 * @private
 * @argument {String} offset
 * @argument {Object} popperOffsets
 * @argument {Object} referenceOffsets
 * @argument {String} basePlacement
 * @returns {Array} a two cells array with x and y offsets in numbers
 */
function parseOffset(offset, popperOffsets, referenceOffsets, basePlacement) {
  var offsets = [0, 0];

  // Use height if placement is left or right and index is 0 otherwise use width
  // in this way the first offset will use an axis and the second one
  // will use the other one
  var useHeight = ['right', 'left'].indexOf(basePlacement) !== -1;

  // Split the offset string to obtain a list of values and operands
  // The regex addresses values with the plus or minus sign in front (+10, -20, etc)
  var fragments = offset.split(/(\+|\-)/).map(function (frag) {
    return frag.trim();
  });

  // Detect if the offset string contains a pair of values or a single one
  // they could be separated by comma or space
  var divider = fragments.indexOf(find(fragments, function (frag) {
    return frag.search(/,|\s/) !== -1;
  }));

  if (fragments[divider] && fragments[divider].indexOf(',') === -1) {
    console.warn('Offsets separated by white space(s) are deprecated, use a comma (,) instead.');
  }

  // If divider is found, we divide the list of values and operands to divide
  // them by ofset X and Y.
  var splitRegex = /\s*,\s*|\s+/;
  var ops = divider !== -1 ? [fragments.slice(0, divider).concat([fragments[divider].split(splitRegex)[0]]), [fragments[divider].split(splitRegex)[1]].concat(fragments.slice(divider + 1))] : [fragments];

  // Convert the values with units to absolute pixels to allow our computations
  ops = ops.map(function (op, index) {
    // Most of the units rely on the orientation of the popper
    var measurement = (index === 1 ? !useHeight : useHeight) ? 'height' : 'width';
    var mergeWithPrevious = false;
    return op
    // This aggregates any `+` or `-` sign that aren't considered operators
    // e.g.: 10 + +5 => [10, +, +5]
    .reduce(function (a, b) {
      if (a[a.length - 1] === '' && ['+', '-'].indexOf(b) !== -1) {
        a[a.length - 1] = b;
        mergeWithPrevious = true;
        return a;
      } else if (mergeWithPrevious) {
        a[a.length - 1] += b;
        mergeWithPrevious = false;
        return a;
      } else {
        return a.concat(b);
      }
    }, [])
    // Here we convert the string values into number values (in px)
    .map(function (str) {
      return toValue(str, measurement, popperOffsets, referenceOffsets);
    });
  });

  // Loop trough the offsets arrays and execute the operations
  ops.forEach(function (op, index) {
    op.forEach(function (frag, index2) {
      if (isNumeric(frag)) {
        offsets[index] += frag * (op[index2 - 1] === '-' ? -1 : 1);
      }
    });
  });
  return offsets;
}

/**
 * @function
 * @memberof Modifiers
 * @argument {Object} data - The data object generated by update method
 * @argument {Object} options - Modifiers configuration and options
 * @argument {Number|String} options.offset=0
 * The offset value as described in the modifier description
 * @returns {Object} The data object, properly modified
 */
function offset(data, _ref) {
  var offset = _ref.offset;
  var placement = data.placement,
      _data$offsets = data.offsets,
      popper = _data$offsets.popper,
      reference = _data$offsets.reference;

  var basePlacement = placement.split('-')[0];

  var offsets = void 0;
  if (isNumeric(+offset)) {
    offsets = [+offset, 0];
  } else {
    offsets = parseOffset(offset, popper, reference, basePlacement);
  }

  if (basePlacement === 'left') {
    popper.top += offsets[0];
    popper.left -= offsets[1];
  } else if (basePlacement === 'right') {
    popper.top += offsets[0];
    popper.left += offsets[1];
  } else if (basePlacement === 'top') {
    popper.left += offsets[0];
    popper.top -= offsets[1];
  } else if (basePlacement === 'bottom') {
    popper.left += offsets[0];
    popper.top += offsets[1];
  }

  data.popper = popper;
  return data;
}

/**
 * @function
 * @memberof Modifiers
 * @argument {Object} data - The data object generated by `update` method
 * @argument {Object} options - Modifiers configuration and options
 * @returns {Object} The data object, properly modified
 */
function preventOverflow(data, options) {
  var boundariesElement = options.boundariesElement || getOffsetParent(data.instance.popper);

  // If offsetParent is the reference element, we really want to
  // go one step up and use the next offsetParent as reference to
  // avoid to make this modifier completely useless and look like broken
  if (data.instance.reference === boundariesElement) {
    boundariesElement = getOffsetParent(boundariesElement);
  }

  // NOTE: DOM access here
  // resets the popper's position so that the document size can be calculated excluding
  // the size of the popper element itself
  var transformProp = getSupportedPropertyName('transform');
  var popperStyles = data.instance.popper.style; // assignment to help minification
  var top = popperStyles.top,
      left = popperStyles.left,
      transform = popperStyles[transformProp];

  popperStyles.top = '';
  popperStyles.left = '';
  popperStyles[transformProp] = '';

  var boundaries = getBoundaries(data.instance.popper, data.instance.reference, options.padding, boundariesElement, data.positionFixed);

  // NOTE: DOM access here
  // restores the original style properties after the offsets have been computed
  popperStyles.top = top;
  popperStyles.left = left;
  popperStyles[transformProp] = transform;

  options.boundaries = boundaries;

  var order = options.priority;
  var popper = data.offsets.popper;

  var check = {
    primary: function primary(placement) {
      var value = popper[placement];
      if (popper[placement] < boundaries[placement] && !options.escapeWithReference) {
        value = Math.max(popper[placement], boundaries[placement]);
      }
      return defineProperty({}, placement, value);
    },
    secondary: function secondary(placement) {
      var mainSide = placement === 'right' ? 'left' : 'top';
      var value = popper[mainSide];
      if (popper[placement] > boundaries[placement] && !options.escapeWithReference) {
        value = Math.min(popper[mainSide], boundaries[placement] - (placement === 'right' ? popper.width : popper.height));
      }
      return defineProperty({}, mainSide, value);
    }
  };

  order.forEach(function (placement) {
    var side = ['left', 'top'].indexOf(placement) !== -1 ? 'primary' : 'secondary';
    popper = _extends({}, popper, check[side](placement));
  });

  data.offsets.popper = popper;

  return data;
}

/**
 * @function
 * @memberof Modifiers
 * @argument {Object} data - The data object generated by `update` method
 * @argument {Object} options - Modifiers configuration and options
 * @returns {Object} The data object, properly modified
 */
function shift(data) {
  var placement = data.placement;
  var basePlacement = placement.split('-')[0];
  var shiftvariation = placement.split('-')[1];

  // if shift shiftvariation is specified, run the modifier
  if (shiftvariation) {
    var _data$offsets = data.offsets,
        reference = _data$offsets.reference,
        popper = _data$offsets.popper;

    var isVertical = ['bottom', 'top'].indexOf(basePlacement) !== -1;
    var side = isVertical ? 'left' : 'top';
    var measurement = isVertical ? 'width' : 'height';

    var shiftOffsets = {
      start: defineProperty({}, side, reference[side]),
      end: defineProperty({}, side, reference[side] + reference[measurement] - popper[measurement])
    };

    data.offsets.popper = _extends({}, popper, shiftOffsets[shiftvariation]);
  }

  return data;
}

/**
 * @function
 * @memberof Modifiers
 * @argument {Object} data - The data object generated by update method
 * @argument {Object} options - Modifiers configuration and options
 * @returns {Object} The data object, properly modified
 */
function hide(data) {
  if (!isModifierRequired(data.instance.modifiers, 'hide', 'preventOverflow')) {
    return data;
  }

  var refRect = data.offsets.reference;
  var bound = find(data.instance.modifiers, function (modifier) {
    return modifier.name === 'preventOverflow';
  }).boundaries;

  if (refRect.bottom < bound.top || refRect.left > bound.right || refRect.top > bound.bottom || refRect.right < bound.left) {
    // Avoid unnecessary DOM access if visibility hasn't changed
    if (data.hide === true) {
      return data;
    }

    data.hide = true;
    data.attributes['x-out-of-boundaries'] = '';
  } else {
    // Avoid unnecessary DOM access if visibility hasn't changed
    if (data.hide === false) {
      return data;
    }

    data.hide = false;
    data.attributes['x-out-of-boundaries'] = false;
  }

  return data;
}

/**
 * @function
 * @memberof Modifiers
 * @argument {Object} data - The data object generated by `update` method
 * @argument {Object} options - Modifiers configuration and options
 * @returns {Object} The data object, properly modified
 */
function inner(data) {
  var placement = data.placement;
  var basePlacement = placement.split('-')[0];
  var _data$offsets = data.offsets,
      popper = _data$offsets.popper,
      reference = _data$offsets.reference;

  var isHoriz = ['left', 'right'].indexOf(basePlacement) !== -1;

  var subtractLength = ['top', 'left'].indexOf(basePlacement) === -1;

  popper[isHoriz ? 'left' : 'top'] = reference[basePlacement] - (subtractLength ? popper[isHoriz ? 'width' : 'height'] : 0);

  data.placement = getOppositePlacement(placement);
  data.offsets.popper = getClientRect(popper);

  return data;
}

/**
 * Modifier function, each modifier can have a function of this type assigned
 * to its `fn` property.<br />
 * These functions will be called on each update, this means that you must
 * make sure they are performant enough to avoid performance bottlenecks.
 *
 * @function ModifierFn
 * @argument {dataObject} data - The data object generated by `update` method
 * @argument {Object} options - Modifiers configuration and options
 * @returns {dataObject} The data object, properly modified
 */

/**
 * Modifiers are plugins used to alter the behavior of your poppers.<br />
 * Popper.js uses a set of 9 modifiers to provide all the basic functionalities
 * needed by the library.
 *
 * Usually you don't want to override the `order`, `fn` and `onLoad` props.
 * All the other properties are configurations that could be tweaked.
 * @namespace modifiers
 */
var modifiers = {
  /**
   * Modifier used to shift the popper on the start or end of its reference
   * element.<br />
   * It will read the variation of the `placement` property.<br />
   * It can be one either `-end` or `-start`.
   * @memberof modifiers
   * @inner
   */
  shift: {
    /** @prop {number} order=100 - Index used to define the order of execution */
    order: 100,
    /** @prop {Boolean} enabled=true - Whether the modifier is enabled or not */
    enabled: true,
    /** @prop {ModifierFn} */
    fn: shift
  },

  /**
   * The `offset` modifier can shift your popper on both its axis.
   *
   * It accepts the following units:
   * - `px` or unit-less, interpreted as pixels
   * - `%` or `%r`, percentage relative to the length of the reference element
   * - `%p`, percentage relative to the length of the popper element
   * - `vw`, CSS viewport width unit
   * - `vh`, CSS viewport height unit
   *
   * For length is intended the main axis relative to the placement of the popper.<br />
   * This means that if the placement is `top` or `bottom`, the length will be the
   * `width`. In case of `left` or `right`, it will be the `height`.
   *
   * You can provide a single value (as `Number` or `String`), or a pair of values
   * as `String` divided by a comma or one (or more) white spaces.<br />
   * The latter is a deprecated method because it leads to confusion and will be
   * removed in v2.<br />
   * Additionally, it accepts additions and subtractions between different units.
   * Note that multiplications and divisions aren't supported.
   *
   * Valid examples are:
   * ```
   * 10
   * '10%'
   * '10, 10'
   * '10%, 10'
   * '10 + 10%'
   * '10 - 5vh + 3%'
   * '-10px + 5vh, 5px - 6%'
   * ```
   * > **NB**: If you desire to apply offsets to your poppers in a way that may make them overlap
   * > with their reference element, unfortunately, you will have to disable the `flip` modifier.
   * > You can read more on this at this [issue](https://github.com/FezVrasta/popper.js/issues/373).
   *
   * @memberof modifiers
   * @inner
   */
  offset: {
    /** @prop {number} order=200 - Index used to define the order of execution */
    order: 200,
    /** @prop {Boolean} enabled=true - Whether the modifier is enabled or not */
    enabled: true,
    /** @prop {ModifierFn} */
    fn: offset,
    /** @prop {Number|String} offset=0
     * The offset value as described in the modifier description
     */
    offset: 0
  },

  /**
   * Modifier used to prevent the popper from being positioned outside the boundary.
   *
   * A scenario exists where the reference itself is not within the boundaries.<br />
   * We can say it has "escaped the boundaries" — or just "escaped".<br />
   * In this case we need to decide whether the popper should either:
   *
   * - detach from the reference and remain "trapped" in the boundaries, or
   * - if it should ignore the boundary and "escape with its reference"
   *
   * When `escapeWithReference` is set to`true` and reference is completely
   * outside its boundaries, the popper will overflow (or completely leave)
   * the boundaries in order to remain attached to the edge of the reference.
   *
   * @memberof modifiers
   * @inner
   */
  preventOverflow: {
    /** @prop {number} order=300 - Index used to define the order of execution */
    order: 300,
    /** @prop {Boolean} enabled=true - Whether the modifier is enabled or not */
    enabled: true,
    /** @prop {ModifierFn} */
    fn: preventOverflow,
    /**
     * @prop {Array} [priority=['left','right','top','bottom']]
     * Popper will try to prevent overflow following these priorities by default,
     * then, it could overflow on the left and on top of the `boundariesElement`
     */
    priority: ['left', 'right', 'top', 'bottom'],
    /**
     * @prop {number} padding=5
     * Amount of pixel used to define a minimum distance between the boundaries
     * and the popper. This makes sure the popper always has a little padding
     * between the edges of its container
     */
    padding: 5,
    /**
     * @prop {String|HTMLElement} boundariesElement='scrollParent'
     * Boundaries used by the modifier. Can be `scrollParent`, `window`,
     * `viewport` or any DOM element.
     */
    boundariesElement: 'scrollParent'
  },

  /**
   * Modifier used to make sure the reference and its popper stay near each other
   * without leaving any gap between the two. Especially useful when the arrow is
   * enabled and you want to ensure that it points to its reference element.
   * It cares only about the first axis. You can still have poppers with margin
   * between the popper and its reference element.
   * @memberof modifiers
   * @inner
   */
  keepTogether: {
    /** @prop {number} order=400 - Index used to define the order of execution */
    order: 400,
    /** @prop {Boolean} enabled=true - Whether the modifier is enabled or not */
    enabled: true,
    /** @prop {ModifierFn} */
    fn: keepTogether
  },

  /**
   * This modifier is used to move the `arrowElement` of the popper to make
   * sure it is positioned between the reference element and its popper element.
   * It will read the outer size of the `arrowElement` node to detect how many
   * pixels of conjunction are needed.
   *
   * It has no effect if no `arrowElement` is provided.
   * @memberof modifiers
   * @inner
   */
  arrow: {
    /** @prop {number} order=500 - Index used to define the order of execution */
    order: 500,
    /** @prop {Boolean} enabled=true - Whether the modifier is enabled or not */
    enabled: true,
    /** @prop {ModifierFn} */
    fn: arrow,
    /** @prop {String|HTMLElement} element='[x-arrow]' - Selector or node used as arrow */
    element: '[x-arrow]'
  },

  /**
   * Modifier used to flip the popper's placement when it starts to overlap its
   * reference element.
   *
   * Requires the `preventOverflow` modifier before it in order to work.
   *
   * **NOTE:** this modifier will interrupt the current update cycle and will
   * restart it if it detects the need to flip the placement.
   * @memberof modifiers
   * @inner
   */
  flip: {
    /** @prop {number} order=600 - Index used to define the order of execution */
    order: 600,
    /** @prop {Boolean} enabled=true - Whether the modifier is enabled or not */
    enabled: true,
    /** @prop {ModifierFn} */
    fn: flip,
    /**
     * @prop {String|Array} behavior='flip'
     * The behavior used to change the popper's placement. It can be one of
     * `flip`, `clockwise`, `counterclockwise` or an array with a list of valid
     * placements (with optional variations)
     */
    behavior: 'flip',
    /**
     * @prop {number} padding=5
     * The popper will flip if it hits the edges of the `boundariesElement`
     */
    padding: 5,
    /**
     * @prop {String|HTMLElement} boundariesElement='viewport'
     * The element which will define the boundaries of the popper position.
     * The popper will never be placed outside of the defined boundaries
     * (except if `keepTogether` is enabled)
     */
    boundariesElement: 'viewport',
    /**
     * @prop {Boolean} flipVariations=false
     * The popper will switch placement variation between `-start` and `-end` when
     * the reference element overlaps its boundaries.
     *
     * The original placement should have a set variation.
     */
    flipVariations: false,
    /**
     * @prop {Boolean} flipVariationsByContent=false
     * The popper will switch placement variation between `-start` and `-end` when
     * the popper element overlaps its reference boundaries.
     *
     * The original placement should have a set variation.
     */
    flipVariationsByContent: false
  },

  /**
   * Modifier used to make the popper flow toward the inner of the reference element.
   * By default, when this modifier is disabled, the popper will be placed outside
   * the reference element.
   * @memberof modifiers
   * @inner
   */
  inner: {
    /** @prop {number} order=700 - Index used to define the order of execution */
    order: 700,
    /** @prop {Boolean} enabled=false - Whether the modifier is enabled or not */
    enabled: false,
    /** @prop {ModifierFn} */
    fn: inner
  },

  /**
   * Modifier used to hide the popper when its reference element is outside of the
   * popper boundaries. It will set a `x-out-of-boundaries` attribute which can
   * be used to hide with a CSS selector the popper when its reference is
   * out of boundaries.
   *
   * Requires the `preventOverflow` modifier before it in order to work.
   * @memberof modifiers
   * @inner
   */
  hide: {
    /** @prop {number} order=800 - Index used to define the order of execution */
    order: 800,
    /** @prop {Boolean} enabled=true - Whether the modifier is enabled or not */
    enabled: true,
    /** @prop {ModifierFn} */
    fn: hide
  },

  /**
   * Computes the style that will be applied to the popper element to gets
   * properly positioned.
   *
   * Note that this modifier will not touch the DOM, it just prepares the styles
   * so that `applyStyle` modifier can apply it. This separation is useful
   * in case you need to replace `applyStyle` with a custom implementation.
   *
   * This modifier has `850` as `order` value to maintain backward compatibility
   * with previous versions of Popper.js. Expect the modifiers ordering method
   * to change in future major versions of the library.
   *
   * @memberof modifiers
   * @inner
   */
  computeStyle: {
    /** @prop {number} order=850 - Index used to define the order of execution */
    order: 850,
    /** @prop {Boolean} enabled=true - Whether the modifier is enabled or not */
    enabled: true,
    /** @prop {ModifierFn} */
    fn: computeStyle,
    /**
     * @prop {Boolean} gpuAcceleration=true
     * If true, it uses the CSS 3D transformation to position the popper.
     * Otherwise, it will use the `top` and `left` properties
     */
    gpuAcceleration: true,
    /**
     * @prop {string} [x='bottom']
     * Where to anchor the X axis (`bottom` or `top`). AKA X offset origin.
     * Change this if your popper should grow in a direction different from `bottom`
     */
    x: 'bottom',
    /**
     * @prop {string} [x='left']
     * Where to anchor the Y axis (`left` or `right`). AKA Y offset origin.
     * Change this if your popper should grow in a direction different from `right`
     */
    y: 'right'
  },

  /**
   * Applies the computed styles to the popper element.
   *
   * All the DOM manipulations are limited to this modifier. This is useful in case
   * you want to integrate Popper.js inside a framework or view library and you
   * want to delegate all the DOM manipulations to it.
   *
   * Note that if you disable this modifier, you must make sure the popper element
   * has its position set to `absolute` before Popper.js can do its work!
   *
   * Just disable this modifier and define your own to achieve the desired effect.
   *
   * @memberof modifiers
   * @inner
   */
  applyStyle: {
    /** @prop {number} order=900 - Index used to define the order of execution */
    order: 900,
    /** @prop {Boolean} enabled=true - Whether the modifier is enabled or not */
    enabled: true,
    /** @prop {ModifierFn} */
    fn: applyStyle,
    /** @prop {Function} */
    onLoad: applyStyleOnLoad,
    /**
     * @deprecated since version 1.10.0, the property moved to `computeStyle` modifier
     * @prop {Boolean} gpuAcceleration=true
     * If true, it uses the CSS 3D transformation to position the popper.
     * Otherwise, it will use the `top` and `left` properties
     */
    gpuAcceleration: undefined
  }
};

/**
 * The `dataObject` is an object containing all the information used by Popper.js.
 * This object is passed to modifiers and to the `onCreate` and `onUpdate` callbacks.
 * @name dataObject
 * @property {Object} data.instance The Popper.js instance
 * @property {String} data.placement Placement applied to popper
 * @property {String} data.originalPlacement Placement originally defined on init
 * @property {Boolean} data.flipped True if popper has been flipped by flip modifier
 * @property {Boolean} data.hide True if the reference element is out of boundaries, useful to know when to hide the popper
 * @property {HTMLElement} data.arrowElement Node used as arrow by arrow modifier
 * @property {Object} data.styles Any CSS property defined here will be applied to the popper. It expects the JavaScript nomenclature (eg. `marginBottom`)
 * @property {Object} data.arrowStyles Any CSS property defined here will be applied to the popper arrow. It expects the JavaScript nomenclature (eg. `marginBottom`)
 * @property {Object} data.boundaries Offsets of the popper boundaries
 * @property {Object} data.offsets The measurements of popper, reference and arrow elements
 * @property {Object} data.offsets.popper `top`, `left`, `width`, `height` values
 * @property {Object} data.offsets.reference `top`, `left`, `width`, `height` values
 * @property {Object} data.offsets.arrow] `top` and `left` offsets, only one of them will be different from 0
 */

/**
 * Default options provided to Popper.js constructor.<br />
 * These can be overridden using the `options` argument of Popper.js.<br />
 * To override an option, simply pass an object with the same
 * structure of the `options` object, as the 3rd argument. For example:
 * ```
 * new Popper(ref, pop, {
 *   modifiers: {
 *     preventOverflow: { enabled: false }
 *   }
 * })
 * ```
 * @type {Object}
 * @static
 * @memberof Popper
 */
var Defaults = {
  /**
   * Popper's placement.
   * @prop {Popper.placements} placement='bottom'
   */
  placement: 'bottom',

  /**
   * Set this to true if you want popper to position it self in 'fixed' mode
   * @prop {Boolean} positionFixed=false
   */
  positionFixed: false,

  /**
   * Whether events (resize, scroll) are initially enabled.
   * @prop {Boolean} eventsEnabled=true
   */
  eventsEnabled: true,

  /**
   * Set to true if you want to automatically remove the popper when
   * you call the `destroy` method.
   * @prop {Boolean} removeOnDestroy=false
   */
  removeOnDestroy: false,

  /**
   * Callback called when the popper is created.<br />
   * By default, it is set to no-op.<br />
   * Access Popper.js instance with `data.instance`.
   * @prop {onCreate}
   */
  onCreate: function onCreate() {},

  /**
   * Callback called when the popper is updated. This callback is not called
   * on the initialization/creation of the popper, but only on subsequent
   * updates.<br />
   * By default, it is set to no-op.<br />
   * Access Popper.js instance with `data.instance`.
   * @prop {onUpdate}
   */
  onUpdate: function onUpdate() {},

  /**
   * List of modifiers used to modify the offsets before they are applied to the popper.
   * They provide most of the functionalities of Popper.js.
   * @prop {modifiers}
   */
  modifiers: modifiers
};

/**
 * @callback onCreate
 * @param {dataObject} data
 */

/**
 * @callback onUpdate
 * @param {dataObject} data
 */

// Utils
// Methods
var Popper = (function () {
  /**
   * Creates a new Popper.js instance.
   * @class Popper
   * @param {Element|referenceObject} reference - The reference element used to position the popper
   * @param {Element} popper - The HTML / XML element used as the popper
   * @param {Object} options - Your custom options to override the ones defined in [Defaults](#defaults)
   * @return {Object} instance - The generated Popper.js instance
   */
  function Popper(reference, popper) {
    var _this = this;

    var options = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};
    classCallCheck(this, Popper);

    this.scheduleUpdate = function () {
      return requestAnimationFrame(_this.update);
    };

    // make update() debounced, so that it only runs at most once-per-tick
    this.update = debounce(this.update.bind(this));

    // with {} we create a new object with the options inside it
    this.options = _extends({}, Popper.Defaults, options);

    // init state
    this.state = {
      isDestroyed: false,
      isCreated: false,
      scrollParents: []
    };

    // get reference and popper elements (allow jQuery wrappers)
    this.reference = reference && reference.jquery ? reference[0] : reference;
    this.popper = popper && popper.jquery ? popper[0] : popper;

    // Deep merge modifiers options
    this.options.modifiers = {};
    Object.keys(_extends({}, Popper.Defaults.modifiers, options.modifiers)).forEach(function (name) {
      _this.options.modifiers[name] = _extends({}, Popper.Defaults.modifiers[name] || {}, options.modifiers ? options.modifiers[name] : {});
    });

    // Refactoring modifiers' list (Object => Array)
    this.modifiers = Object.keys(this.options.modifiers).map(function (name) {
      return _extends({
        name: name
      }, _this.options.modifiers[name]);
    })
    // sort the modifiers by order
    .sort(function (a, b) {
      return a.order - b.order;
    });

    // modifiers have the ability to execute arbitrary code when Popper.js get inited
    // such code is executed in the same order of its modifier
    // they could add new properties to their options configuration
    // BE AWARE: don't add options to `options.modifiers.name` but to `modifierOptions`!
    this.modifiers.forEach(function (modifierOptions) {
      if (modifierOptions.enabled && isFunction(modifierOptions.onLoad)) {
        modifierOptions.onLoad(_this.reference, _this.popper, _this.options, modifierOptions, _this.state);
      }
    });

    // fire the first update to position the popper in the right place
    this.update();

    var eventsEnabled = this.options.eventsEnabled;
    if (eventsEnabled) {
      // setup event listeners, they will take care of update the position in specific situations
      this.enableEventListeners();
    }

    this.state.eventsEnabled = eventsEnabled;
  }

  // We can't use class properties because they don't get listed in the
  // class prototype and break stuff like Sinon stubs

  createClass(Popper, [{
    key: 'update',
    value: function update$$1() {
      return update.call(this);
    }
  }, {
    key: 'destroy',
    value: function destroy$$1() {
      return destroy.call(this);
    }
  }, {
    key: 'enableEventListeners',
    value: function enableEventListeners$$1() {
      return enableEventListeners.call(this);
    }
  }, {
    key: 'disableEventListeners',
    value: function disableEventListeners$$1() {
      return disableEventListeners.call(this);
    }

    /**
     * Schedules an update. It will run on the next UI update available.
     * @method scheduleUpdate
     * @memberof Popper
     */

    /**
     * Collection of utilities useful when writing custom modifiers.
     * Starting from version 1.7, this method is available only if you
     * include `popper-utils.js` before `popper.js`.
     *
     * **DEPRECATION**: This way to access PopperUtils is deprecated
     * and will be removed in v2! Use the PopperUtils module directly instead.
     * Due to the high instability of the methods contained in Utils, we can't
     * guarantee them to follow semver. Use them at your own risk!
     * @static
     * @private
     * @type {Object}
     * @deprecated since version 1.8
     * @member Utils
     * @memberof Popper
     */

  }]);
  return Popper;
})();

/**
 * The `referenceObject` is an object that provides an interface compatible with Popper.js
 * and lets you use it as replacement of a real DOM node.<br />
 * You can use this method to position a popper relatively to a set of coordinates
 * in case you don't have a DOM node to use as reference.
 *
 * ```
 * new Popper(referenceObject, popperNode);
 * ```
 *
 * NB: This feature isn't supported in Internet Explorer 10.
 * @name referenceObject
 * @property {Function} data.getBoundingClientRect
 * A function that returns a set of coordinates compatible with the native `getBoundingClientRect` method.
 * @property {number} data.clientWidth
 * An ES6 getter that will return the width of the virtual reference element.
 * @property {number} data.clientHeight
 * An ES6 getter that will return the height of the virtual reference element.
 */

Popper.Utils = (typeof window !== 'undefined' ? window : global).PopperUtils;
Popper.placements = placements;
Popper.Defaults = Defaults;

exports['default'] = Popper;

//# sourceMappingURL=popper.js.map
module.exports = exports['default'];
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(5)))

/***/ }),
/* 27 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;/*! tether 1.4.7 */



(function (root, factory) {
  if (true) {
    !(__WEBPACK_AMD_DEFINE_ARRAY__ = [], __WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
  } else if (typeof exports === 'object') {
    module.exports = factory();
  } else {
    root.Tether = factory();
  }
})(undefined, function () {

  'use strict';

  var _createClass = (function () {
    function defineProperties(target, props) {
      for (var i = 0; i < props.length; i++) {
        var descriptor = props[i];descriptor.enumerable = descriptor.enumerable || false;descriptor.configurable = true;if ('value' in descriptor) descriptor.writable = true;Object.defineProperty(target, descriptor.key, descriptor);
      }
    }return function (Constructor, protoProps, staticProps) {
      if (protoProps) defineProperties(Constructor.prototype, protoProps);if (staticProps) defineProperties(Constructor, staticProps);return Constructor;
    };
  })();

  function _classCallCheck(instance, Constructor) {
    if (!(instance instanceof Constructor)) {
      throw new TypeError('Cannot call a class as a function');
    }
  }

  var TetherBase = undefined;
  if (typeof TetherBase === 'undefined') {
    TetherBase = { modules: [] };
  }

  var zeroElement = null;

  // Same as native getBoundingClientRect, except it takes into account parent <frame> offsets
  // if the element lies within a nested document (<frame> or <iframe>-like).
  function getActualBoundingClientRect(node) {
    var boundingRect = node.getBoundingClientRect();

    // The original object returned by getBoundingClientRect is immutable, so we clone it
    // We can't use extend because the properties are not considered part of the object by hasOwnProperty in IE9
    var rect = {};
    for (var k in boundingRect) {
      rect[k] = boundingRect[k];
    }

    try {
      if (node.ownerDocument !== document) {
        var _frameElement = node.ownerDocument.defaultView.frameElement;
        if (_frameElement) {
          var frameRect = getActualBoundingClientRect(_frameElement);
          rect.top += frameRect.top;
          rect.bottom += frameRect.top;
          rect.left += frameRect.left;
          rect.right += frameRect.left;
        }
      }
    } catch (err) {
      // Ignore "Access is denied" in IE11/Edge
    }

    return rect;
  }

  function getScrollParents(el) {
    // In firefox if the el is inside an iframe with display: none; window.getComputedStyle() will return null;
    // https://bugzilla.mozilla.org/show_bug.cgi?id=548397
    var computedStyle = getComputedStyle(el) || {};
    var position = computedStyle.position;
    var parents = [];

    if (position === 'fixed') {
      return [el];
    }

    var parent = el;
    while ((parent = parent.parentNode) && parent && parent.nodeType === 1) {
      var style = undefined;
      try {
        style = getComputedStyle(parent);
      } catch (err) {}

      if (typeof style === 'undefined' || style === null) {
        parents.push(parent);
        return parents;
      }

      var _style = style;
      var overflow = _style.overflow;
      var overflowX = _style.overflowX;
      var overflowY = _style.overflowY;

      if (/(auto|scroll|overlay)/.test(overflow + overflowY + overflowX)) {
        if (position !== 'absolute' || ['relative', 'absolute', 'fixed'].indexOf(style.position) >= 0) {
          parents.push(parent);
        }
      }
    }

    parents.push(el.ownerDocument.body);

    // If the node is within a frame, account for the parent window scroll
    if (el.ownerDocument !== document) {
      parents.push(el.ownerDocument.defaultView);
    }

    return parents;
  }

  var uniqueId = (function () {
    var id = 0;
    return function () {
      return ++id;
    };
  })();

  var zeroPosCache = {};
  var getOrigin = function getOrigin() {
    // getBoundingClientRect is unfortunately too accurate.  It introduces a pixel or two of
    // jitter as the user scrolls that messes with our ability to detect if two positions
    // are equivilant or not.  We place an element at the top left of the page that will
    // get the same jitter, so we can cancel the two out.
    var node = zeroElement;
    if (!node || !document.body.contains(node)) {
      node = document.createElement('div');
      node.setAttribute('data-tether-id', uniqueId());
      extend(node.style, {
        top: 0,
        left: 0,
        position: 'absolute'
      });

      document.body.appendChild(node);

      zeroElement = node;
    }

    var id = node.getAttribute('data-tether-id');
    if (typeof zeroPosCache[id] === 'undefined') {
      zeroPosCache[id] = getActualBoundingClientRect(node);

      // Clear the cache when this position call is done
      defer(function () {
        delete zeroPosCache[id];
      });
    }

    return zeroPosCache[id];
  };

  function removeUtilElements() {
    if (zeroElement) {
      document.body.removeChild(zeroElement);
    }
    zeroElement = null;
  };

  function getBounds(el) {
    var doc = undefined;
    if (el === document) {
      doc = document;
      el = document.documentElement;
    } else {
      doc = el.ownerDocument;
    }

    var docEl = doc.documentElement;

    var box = getActualBoundingClientRect(el);

    var origin = getOrigin();

    box.top -= origin.top;
    box.left -= origin.left;

    if (typeof box.width === 'undefined') {
      box.width = document.body.scrollWidth - box.left - box.right;
    }
    if (typeof box.height === 'undefined') {
      box.height = document.body.scrollHeight - box.top - box.bottom;
    }

    box.top = box.top - docEl.clientTop;
    box.left = box.left - docEl.clientLeft;
    box.right = doc.body.clientWidth - box.width - box.left;
    box.bottom = doc.body.clientHeight - box.height - box.top;

    return box;
  }

  function getOffsetParent(el) {
    return el.offsetParent || document.documentElement;
  }

  var _scrollBarSize = null;
  function getScrollBarSize() {
    if (_scrollBarSize) {
      return _scrollBarSize;
    }
    var inner = document.createElement('div');
    inner.style.width = '100%';
    inner.style.height = '200px';

    var outer = document.createElement('div');
    extend(outer.style, {
      position: 'absolute',
      top: 0,
      left: 0,
      pointerEvents: 'none',
      visibility: 'hidden',
      width: '200px',
      height: '150px',
      overflow: 'hidden'
    });

    outer.appendChild(inner);

    document.body.appendChild(outer);

    var widthContained = inner.offsetWidth;
    outer.style.overflow = 'scroll';
    var widthScroll = inner.offsetWidth;

    if (widthContained === widthScroll) {
      widthScroll = outer.clientWidth;
    }

    document.body.removeChild(outer);

    var width = widthContained - widthScroll;

    _scrollBarSize = { width: width, height: width };
    return _scrollBarSize;
  }

  function extend() {
    var out = arguments.length <= 0 || arguments[0] === undefined ? {} : arguments[0];

    var args = [];

    Array.prototype.push.apply(args, arguments);

    args.slice(1).forEach(function (obj) {
      if (obj) {
        for (var key in obj) {
          if (({}).hasOwnProperty.call(obj, key)) {
            out[key] = obj[key];
          }
        }
      }
    });

    return out;
  }

  function removeClass(el, name) {
    if (typeof el.classList !== 'undefined') {
      name.split(' ').forEach(function (cls) {
        if (cls.trim()) {
          el.classList.remove(cls);
        }
      });
    } else {
      var regex = new RegExp('(^| )' + name.split(' ').join('|') + '( |$)', 'gi');
      var className = getClassName(el).replace(regex, ' ');
      setClassName(el, className);
    }
  }

  function addClass(el, name) {
    if (typeof el.classList !== 'undefined') {
      name.split(' ').forEach(function (cls) {
        if (cls.trim()) {
          el.classList.add(cls);
        }
      });
    } else {
      removeClass(el, name);
      var cls = getClassName(el) + (' ' + name);
      setClassName(el, cls);
    }
  }

  function hasClass(el, name) {
    if (typeof el.classList !== 'undefined') {
      return el.classList.contains(name);
    }
    var className = getClassName(el);
    return new RegExp('(^| )' + name + '( |$)', 'gi').test(className);
  }

  function getClassName(el) {
    // Can't use just SVGAnimatedString here since nodes within a Frame in IE have
    // completely separately SVGAnimatedString base classes
    if (el.className instanceof el.ownerDocument.defaultView.SVGAnimatedString) {
      return el.className.baseVal;
    }
    return el.className;
  }

  function setClassName(el, className) {
    el.setAttribute('class', className);
  }

  function updateClasses(el, add, all) {
    // Of the set of 'all' classes, we need the 'add' classes, and only the
    // 'add' classes to be set.
    all.forEach(function (cls) {
      if (add.indexOf(cls) === -1 && hasClass(el, cls)) {
        removeClass(el, cls);
      }
    });

    add.forEach(function (cls) {
      if (!hasClass(el, cls)) {
        addClass(el, cls);
      }
    });
  }

  var deferred = [];

  var defer = function defer(fn) {
    deferred.push(fn);
  };

  var flush = function flush() {
    var fn = undefined;
    while (fn = deferred.pop()) {
      fn();
    }
  };

  var Evented = (function () {
    function Evented() {
      _classCallCheck(this, Evented);
    }

    _createClass(Evented, [{
      key: 'on',
      value: function on(event, handler, ctx) {
        var once = arguments.length <= 3 || arguments[3] === undefined ? false : arguments[3];

        if (typeof this.bindings === 'undefined') {
          this.bindings = {};
        }
        if (typeof this.bindings[event] === 'undefined') {
          this.bindings[event] = [];
        }
        this.bindings[event].push({ handler: handler, ctx: ctx, once: once });
      }
    }, {
      key: 'once',
      value: function once(event, handler, ctx) {
        this.on(event, handler, ctx, true);
      }
    }, {
      key: 'off',
      value: function off(event, handler) {
        if (typeof this.bindings === 'undefined' || typeof this.bindings[event] === 'undefined') {
          return;
        }

        if (typeof handler === 'undefined') {
          delete this.bindings[event];
        } else {
          var i = 0;
          while (i < this.bindings[event].length) {
            if (this.bindings[event][i].handler === handler) {
              this.bindings[event].splice(i, 1);
            } else {
              ++i;
            }
          }
        }
      }
    }, {
      key: 'trigger',
      value: function trigger(event) {
        if (typeof this.bindings !== 'undefined' && this.bindings[event]) {
          var i = 0;

          for (var _len = arguments.length, args = Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
            args[_key - 1] = arguments[_key];
          }

          while (i < this.bindings[event].length) {
            var _bindings$event$i = this.bindings[event][i];
            var handler = _bindings$event$i.handler;
            var ctx = _bindings$event$i.ctx;
            var once = _bindings$event$i.once;

            var context = ctx;
            if (typeof context === 'undefined') {
              context = this;
            }

            handler.apply(context, args);

            if (once) {
              this.bindings[event].splice(i, 1);
            } else {
              ++i;
            }
          }
        }
      }
    }]);

    return Evented;
  })();

  TetherBase.Utils = {
    getActualBoundingClientRect: getActualBoundingClientRect,
    getScrollParents: getScrollParents,
    getBounds: getBounds,
    getOffsetParent: getOffsetParent,
    extend: extend,
    addClass: addClass,
    removeClass: removeClass,
    hasClass: hasClass,
    updateClasses: updateClasses,
    defer: defer,
    flush: flush,
    uniqueId: uniqueId,
    Evented: Evented,
    getScrollBarSize: getScrollBarSize,
    removeUtilElements: removeUtilElements
  };
  /* globals TetherBase, performance */

  'use strict';

  var _slicedToArray = (function () {
    function sliceIterator(arr, i) {
      var _arr = [];var _n = true;var _d = false;var _e = undefined;try {
        for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) {
          _arr.push(_s.value);if (i && _arr.length === i) break;
        }
      } catch (err) {
        _d = true;_e = err;
      } finally {
        try {
          if (!_n && _i['return']) _i['return']();
        } finally {
          if (_d) throw _e;
        }
      }return _arr;
    }return function (arr, i) {
      if (Array.isArray(arr)) {
        return arr;
      } else if (Symbol.iterator in Object(arr)) {
        return sliceIterator(arr, i);
      } else {
        throw new TypeError('Invalid attempt to destructure non-iterable instance');
      }
    };
  })();

  var _createClass = (function () {
    function defineProperties(target, props) {
      for (var i = 0; i < props.length; i++) {
        var descriptor = props[i];descriptor.enumerable = descriptor.enumerable || false;descriptor.configurable = true;if ('value' in descriptor) descriptor.writable = true;Object.defineProperty(target, descriptor.key, descriptor);
      }
    }return function (Constructor, protoProps, staticProps) {
      if (protoProps) defineProperties(Constructor.prototype, protoProps);if (staticProps) defineProperties(Constructor, staticProps);return Constructor;
    };
  })();

  var _get = function get(_x6, _x7, _x8) {
    var _again = true;_function: while (_again) {
      var object = _x6,
          property = _x7,
          receiver = _x8;_again = false;if (object === null) object = Function.prototype;var desc = Object.getOwnPropertyDescriptor(object, property);if (desc === undefined) {
        var parent = Object.getPrototypeOf(object);if (parent === null) {
          return undefined;
        } else {
          _x6 = parent;_x7 = property;_x8 = receiver;_again = true;desc = parent = undefined;continue _function;
        }
      } else if ('value' in desc) {
        return desc.value;
      } else {
        var getter = desc.get;if (getter === undefined) {
          return undefined;
        }return getter.call(receiver);
      }
    }
  };

  function _classCallCheck(instance, Constructor) {
    if (!(instance instanceof Constructor)) {
      throw new TypeError('Cannot call a class as a function');
    }
  }

  function _inherits(subClass, superClass) {
    if (typeof superClass !== 'function' && superClass !== null) {
      throw new TypeError('Super expression must either be null or a function, not ' + typeof superClass);
    }subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } });if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass;
  }

  if (typeof TetherBase === 'undefined') {
    throw new Error('You must include the utils.js file before tether.js');
  }

  var _TetherBase$Utils = TetherBase.Utils;
  var getScrollParents = _TetherBase$Utils.getScrollParents;
  var getBounds = _TetherBase$Utils.getBounds;
  var getOffsetParent = _TetherBase$Utils.getOffsetParent;
  var extend = _TetherBase$Utils.extend;
  var addClass = _TetherBase$Utils.addClass;
  var removeClass = _TetherBase$Utils.removeClass;
  var updateClasses = _TetherBase$Utils.updateClasses;
  var defer = _TetherBase$Utils.defer;
  var flush = _TetherBase$Utils.flush;
  var getScrollBarSize = _TetherBase$Utils.getScrollBarSize;
  var removeUtilElements = _TetherBase$Utils.removeUtilElements;

  function within(a, b) {
    var diff = arguments.length <= 2 || arguments[2] === undefined ? 1 : arguments[2];

    return a + diff >= b && b >= a - diff;
  }

  var transformKey = (function () {
    if (typeof document === 'undefined') {
      return '';
    }
    var el = document.createElement('div');

    var transforms = ['transform', 'WebkitTransform', 'OTransform', 'MozTransform', 'msTransform'];
    for (var i = 0; i < transforms.length; ++i) {
      var key = transforms[i];
      if (el.style[key] !== undefined) {
        return key;
      }
    }
  })();

  var tethers = [];

  var position = function position() {
    tethers.forEach(function (tether) {
      tether.position(false);
    });
    flush();
  };

  function now() {
    if (typeof performance === 'object' && typeof performance.now === 'function') {
      return performance.now();
    }
    return +new Date();
  }

  (function () {
    var lastCall = null;
    var lastDuration = null;
    var pendingTimeout = null;

    var tick = function tick() {
      if (typeof lastDuration !== 'undefined' && lastDuration > 16) {
        // We voluntarily throttle ourselves if we can't manage 60fps
        lastDuration = Math.min(lastDuration - 16, 250);

        // Just in case this is the last event, remember to position just once more
        pendingTimeout = setTimeout(tick, 250);
        return;
      }

      if (typeof lastCall !== 'undefined' && now() - lastCall < 10) {
        // Some browsers call events a little too frequently, refuse to run more than is reasonable
        return;
      }

      if (pendingTimeout != null) {
        clearTimeout(pendingTimeout);
        pendingTimeout = null;
      }

      lastCall = now();
      position();
      lastDuration = now() - lastCall;
    };

    if (typeof window !== 'undefined' && typeof window.addEventListener !== 'undefined') {
      ['resize', 'scroll', 'touchmove'].forEach(function (event) {
        window.addEventListener(event, tick);
      });
    }
  })();

  var MIRROR_LR = {
    center: 'center',
    left: 'right',
    right: 'left'
  };

  var MIRROR_TB = {
    middle: 'middle',
    top: 'bottom',
    bottom: 'top'
  };

  var OFFSET_MAP = {
    top: 0,
    left: 0,
    middle: '50%',
    center: '50%',
    bottom: '100%',
    right: '100%'
  };

  var autoToFixedAttachment = function autoToFixedAttachment(attachment, relativeToAttachment) {
    var left = attachment.left;
    var top = attachment.top;

    if (left === 'auto') {
      left = MIRROR_LR[relativeToAttachment.left];
    }

    if (top === 'auto') {
      top = MIRROR_TB[relativeToAttachment.top];
    }

    return { left: left, top: top };
  };

  var attachmentToOffset = function attachmentToOffset(attachment) {
    var left = attachment.left;
    var top = attachment.top;

    if (typeof OFFSET_MAP[attachment.left] !== 'undefined') {
      left = OFFSET_MAP[attachment.left];
    }

    if (typeof OFFSET_MAP[attachment.top] !== 'undefined') {
      top = OFFSET_MAP[attachment.top];
    }

    return { left: left, top: top };
  };

  function addOffset() {
    var out = { top: 0, left: 0 };

    for (var _len = arguments.length, offsets = Array(_len), _key = 0; _key < _len; _key++) {
      offsets[_key] = arguments[_key];
    }

    offsets.forEach(function (_ref) {
      var top = _ref.top;
      var left = _ref.left;

      if (typeof top === 'string') {
        top = parseFloat(top, 10);
      }
      if (typeof left === 'string') {
        left = parseFloat(left, 10);
      }

      out.top += top;
      out.left += left;
    });

    return out;
  }

  function offsetToPx(offset, size) {
    if (typeof offset.left === 'string' && offset.left.indexOf('%') !== -1) {
      offset.left = parseFloat(offset.left, 10) / 100 * size.width;
    }
    if (typeof offset.top === 'string' && offset.top.indexOf('%') !== -1) {
      offset.top = parseFloat(offset.top, 10) / 100 * size.height;
    }

    return offset;
  }

  var parseOffset = function parseOffset(value) {
    var _value$split = value.split(' ');

    var _value$split2 = _slicedToArray(_value$split, 2);

    var top = _value$split2[0];
    var left = _value$split2[1];

    return { top: top, left: left };
  };
  var parseAttachment = parseOffset;

  var TetherClass = (function (_Evented) {
    _inherits(TetherClass, _Evented);

    function TetherClass(options) {
      var _this = this;

      _classCallCheck(this, TetherClass);

      _get(Object.getPrototypeOf(TetherClass.prototype), 'constructor', this).call(this);
      this.position = this.position.bind(this);

      tethers.push(this);

      this.history = [];

      this.setOptions(options, false);

      TetherBase.modules.forEach(function (module) {
        if (typeof module.initialize !== 'undefined') {
          module.initialize.call(_this);
        }
      });

      this.position();
    }

    _createClass(TetherClass, [{
      key: 'getClass',
      value: function getClass() {
        var key = arguments.length <= 0 || arguments[0] === undefined ? '' : arguments[0];
        var classes = this.options.classes;

        if (typeof classes !== 'undefined' && classes[key]) {
          return this.options.classes[key];
        } else if (this.options.classPrefix) {
          return this.options.classPrefix + '-' + key;
        } else {
          return key;
        }
      }
    }, {
      key: 'setOptions',
      value: function setOptions(options) {
        var _this2 = this;

        var pos = arguments.length <= 1 || arguments[1] === undefined ? true : arguments[1];

        var defaults = {
          offset: '0 0',
          targetOffset: '0 0',
          targetAttachment: 'auto auto',
          classPrefix: 'tether'
        };

        this.options = extend(defaults, options);

        var _options = this.options;
        var element = _options.element;
        var target = _options.target;
        var targetModifier = _options.targetModifier;

        this.element = element;
        this.target = target;
        this.targetModifier = targetModifier;

        if (this.target === 'viewport') {
          this.target = document.body;
          this.targetModifier = 'visible';
        } else if (this.target === 'scroll-handle') {
          this.target = document.body;
          this.targetModifier = 'scroll-handle';
        }

        ['element', 'target'].forEach(function (key) {
          if (typeof _this2[key] === 'undefined') {
            throw new Error('Tether Error: Both element and target must be defined');
          }

          if (typeof _this2[key].jquery !== 'undefined') {
            _this2[key] = _this2[key][0];
          } else if (typeof _this2[key] === 'string') {
            _this2[key] = document.querySelector(_this2[key]);
          }
        });

        addClass(this.element, this.getClass('element'));
        if (!(this.options.addTargetClasses === false)) {
          addClass(this.target, this.getClass('target'));
        }

        if (!this.options.attachment) {
          throw new Error('Tether Error: You must provide an attachment');
        }

        this.targetAttachment = parseAttachment(this.options.targetAttachment);
        this.attachment = parseAttachment(this.options.attachment);
        this.offset = parseOffset(this.options.offset);
        this.targetOffset = parseOffset(this.options.targetOffset);

        if (typeof this.scrollParents !== 'undefined') {
          this.disable();
        }

        if (this.targetModifier === 'scroll-handle') {
          this.scrollParents = [this.target];
        } else {
          this.scrollParents = getScrollParents(this.target);
        }

        if (!(this.options.enabled === false)) {
          this.enable(pos);
        }
      }
    }, {
      key: 'getTargetBounds',
      value: function getTargetBounds() {
        if (typeof this.targetModifier !== 'undefined') {
          if (this.targetModifier === 'visible') {
            if (this.target === document.body) {
              return { top: pageYOffset, left: pageXOffset, height: innerHeight, width: innerWidth };
            } else {
              var bounds = getBounds(this.target);

              var out = {
                height: bounds.height,
                width: bounds.width,
                top: bounds.top,
                left: bounds.left
              };

              out.height = Math.min(out.height, bounds.height - (pageYOffset - bounds.top));
              out.height = Math.min(out.height, bounds.height - (bounds.top + bounds.height - (pageYOffset + innerHeight)));
              out.height = Math.min(innerHeight, out.height);
              out.height -= 2;

              out.width = Math.min(out.width, bounds.width - (pageXOffset - bounds.left));
              out.width = Math.min(out.width, bounds.width - (bounds.left + bounds.width - (pageXOffset + innerWidth)));
              out.width = Math.min(innerWidth, out.width);
              out.width -= 2;

              if (out.top < pageYOffset) {
                out.top = pageYOffset;
              }
              if (out.left < pageXOffset) {
                out.left = pageXOffset;
              }

              return out;
            }
          } else if (this.targetModifier === 'scroll-handle') {
            var bounds = undefined;
            var target = this.target;
            if (target === document.body) {
              target = document.documentElement;

              bounds = {
                left: pageXOffset,
                top: pageYOffset,
                height: innerHeight,
                width: innerWidth
              };
            } else {
              bounds = getBounds(target);
            }

            var style = getComputedStyle(target);

            var hasBottomScroll = target.scrollWidth > target.clientWidth || [style.overflow, style.overflowX].indexOf('scroll') >= 0 || this.target !== document.body;

            var scrollBottom = 0;
            if (hasBottomScroll) {
              scrollBottom = 15;
            }

            var height = bounds.height - parseFloat(style.borderTopWidth) - parseFloat(style.borderBottomWidth) - scrollBottom;

            var out = {
              width: 15,
              height: height * 0.975 * (height / target.scrollHeight),
              left: bounds.left + bounds.width - parseFloat(style.borderLeftWidth) - 15
            };

            var fitAdj = 0;
            if (height < 408 && this.target === document.body) {
              fitAdj = -0.00011 * Math.pow(height, 2) - 0.00727 * height + 22.58;
            }

            if (this.target !== document.body) {
              out.height = Math.max(out.height, 24);
            }

            var scrollPercentage = this.target.scrollTop / (target.scrollHeight - height);
            out.top = scrollPercentage * (height - out.height - fitAdj) + bounds.top + parseFloat(style.borderTopWidth);

            if (this.target === document.body) {
              out.height = Math.max(out.height, 24);
            }

            return out;
          }
        } else {
          return getBounds(this.target);
        }
      }
    }, {
      key: 'clearCache',
      value: function clearCache() {
        this._cache = {};
      }
    }, {
      key: 'cache',
      value: function cache(k, getter) {
        // More than one module will often need the same DOM info, so
        // we keep a cache which is cleared on each position call
        if (typeof this._cache === 'undefined') {
          this._cache = {};
        }

        if (typeof this._cache[k] === 'undefined') {
          this._cache[k] = getter.call(this);
        }

        return this._cache[k];
      }
    }, {
      key: 'enable',
      value: function enable() {
        var _this3 = this;

        var pos = arguments.length <= 0 || arguments[0] === undefined ? true : arguments[0];

        if (!(this.options.addTargetClasses === false)) {
          addClass(this.target, this.getClass('enabled'));
        }
        addClass(this.element, this.getClass('enabled'));
        this.enabled = true;

        this.scrollParents.forEach(function (parent) {
          if (parent !== _this3.target.ownerDocument) {
            parent.addEventListener('scroll', _this3.position);
          }
        });

        if (pos) {
          this.position();
        }
      }
    }, {
      key: 'disable',
      value: function disable() {
        var _this4 = this;

        removeClass(this.target, this.getClass('enabled'));
        removeClass(this.element, this.getClass('enabled'));
        this.enabled = false;

        if (typeof this.scrollParents !== 'undefined') {
          this.scrollParents.forEach(function (parent) {
            parent.removeEventListener('scroll', _this4.position);
          });
        }
      }
    }, {
      key: 'destroy',
      value: function destroy() {
        var _this5 = this;

        this.disable();

        tethers.forEach(function (tether, i) {
          if (tether === _this5) {
            tethers.splice(i, 1);
          }
        });

        // Remove any elements we were using for convenience from the DOM
        if (tethers.length === 0) {
          removeUtilElements();
        }
      }
    }, {
      key: 'updateAttachClasses',
      value: function updateAttachClasses(elementAttach, targetAttach) {
        var _this6 = this;

        elementAttach = elementAttach || this.attachment;
        targetAttach = targetAttach || this.targetAttachment;
        var sides = ['left', 'top', 'bottom', 'right', 'middle', 'center'];

        if (typeof this._addAttachClasses !== 'undefined' && this._addAttachClasses.length) {
          // updateAttachClasses can be called more than once in a position call, so
          // we need to clean up after ourselves such that when the last defer gets
          // ran it doesn't add any extra classes from previous calls.
          this._addAttachClasses.splice(0, this._addAttachClasses.length);
        }

        if (typeof this._addAttachClasses === 'undefined') {
          this._addAttachClasses = [];
        }
        var add = this._addAttachClasses;

        if (elementAttach.top) {
          add.push(this.getClass('element-attached') + '-' + elementAttach.top);
        }
        if (elementAttach.left) {
          add.push(this.getClass('element-attached') + '-' + elementAttach.left);
        }
        if (targetAttach.top) {
          add.push(this.getClass('target-attached') + '-' + targetAttach.top);
        }
        if (targetAttach.left) {
          add.push(this.getClass('target-attached') + '-' + targetAttach.left);
        }

        var all = [];
        sides.forEach(function (side) {
          all.push(_this6.getClass('element-attached') + '-' + side);
          all.push(_this6.getClass('target-attached') + '-' + side);
        });

        defer(function () {
          if (!(typeof _this6._addAttachClasses !== 'undefined')) {
            return;
          }

          updateClasses(_this6.element, _this6._addAttachClasses, all);
          if (!(_this6.options.addTargetClasses === false)) {
            updateClasses(_this6.target, _this6._addAttachClasses, all);
          }

          delete _this6._addAttachClasses;
        });
      }
    }, {
      key: 'position',
      value: function position() {
        var _this7 = this;

        var flushChanges = arguments.length <= 0 || arguments[0] === undefined ? true : arguments[0];

        // flushChanges commits the changes immediately, leave true unless you are positioning multiple
        // tethers (in which case call Tether.Utils.flush yourself when you're done)

        if (!this.enabled) {
          return;
        }

        this.clearCache();

        // Turn 'auto' attachments into the appropriate corner or edge
        var targetAttachment = autoToFixedAttachment(this.targetAttachment, this.attachment);

        this.updateAttachClasses(this.attachment, targetAttachment);

        var elementPos = this.cache('element-bounds', function () {
          return getBounds(_this7.element);
        });

        var width = elementPos.width;
        var height = elementPos.height;

        if (width === 0 && height === 0 && typeof this.lastSize !== 'undefined') {
          var _lastSize = this.lastSize;

          // We cache the height and width to make it possible to position elements that are
          // getting hidden.
          width = _lastSize.width;
          height = _lastSize.height;
        } else {
          this.lastSize = { width: width, height: height };
        }

        var targetPos = this.cache('target-bounds', function () {
          return _this7.getTargetBounds();
        });
        var targetSize = targetPos;

        // Get an actual px offset from the attachment
        var offset = offsetToPx(attachmentToOffset(this.attachment), { width: width, height: height });
        var targetOffset = offsetToPx(attachmentToOffset(targetAttachment), targetSize);

        var manualOffset = offsetToPx(this.offset, { width: width, height: height });
        var manualTargetOffset = offsetToPx(this.targetOffset, targetSize);

        // Add the manually provided offset
        offset = addOffset(offset, manualOffset);
        targetOffset = addOffset(targetOffset, manualTargetOffset);

        // It's now our goal to make (element position + offset) == (target position + target offset)
        var left = targetPos.left + targetOffset.left - offset.left;
        var top = targetPos.top + targetOffset.top - offset.top;

        for (var i = 0; i < TetherBase.modules.length; ++i) {
          var _module2 = TetherBase.modules[i];
          var ret = _module2.position.call(this, {
            left: left,
            top: top,
            targetAttachment: targetAttachment,
            targetPos: targetPos,
            elementPos: elementPos,
            offset: offset,
            targetOffset: targetOffset,
            manualOffset: manualOffset,
            manualTargetOffset: manualTargetOffset,
            scrollbarSize: scrollbarSize,
            attachment: this.attachment
          });

          if (ret === false) {
            return false;
          } else if (typeof ret === 'undefined' || typeof ret !== 'object') {
            continue;
          } else {
            top = ret.top;
            left = ret.left;
          }
        }

        // We describe the position three different ways to give the optimizer
        // a chance to decide the best possible way to position the element
        // with the fewest repaints.
        var next = {
          // It's position relative to the page (absolute positioning when
          // the element is a child of the body)
          page: {
            top: top,
            left: left
          },

          // It's position relative to the viewport (fixed positioning)
          viewport: {
            top: top - pageYOffset,
            bottom: pageYOffset - top - height + innerHeight,
            left: left - pageXOffset,
            right: pageXOffset - left - width + innerWidth
          }
        };

        var doc = this.target.ownerDocument;
        var win = doc.defaultView;

        var scrollbarSize = undefined;
        if (win.innerHeight > doc.documentElement.clientHeight) {
          scrollbarSize = this.cache('scrollbar-size', getScrollBarSize);
          next.viewport.bottom -= scrollbarSize.height;
        }

        if (win.innerWidth > doc.documentElement.clientWidth) {
          scrollbarSize = this.cache('scrollbar-size', getScrollBarSize);
          next.viewport.right -= scrollbarSize.width;
        }

        if (['', 'static'].indexOf(doc.body.style.position) === -1 || ['', 'static'].indexOf(doc.body.parentElement.style.position) === -1) {
          // Absolute positioning in the body will be relative to the page, not the 'initial containing block'
          next.page.bottom = doc.body.scrollHeight - top - height;
          next.page.right = doc.body.scrollWidth - left - width;
        }

        if (typeof this.options.optimizations !== 'undefined' && this.options.optimizations.moveElement !== false && !(typeof this.targetModifier !== 'undefined')) {
          (function () {
            var offsetParent = _this7.cache('target-offsetparent', function () {
              return getOffsetParent(_this7.target);
            });
            var offsetPosition = _this7.cache('target-offsetparent-bounds', function () {
              return getBounds(offsetParent);
            });
            var offsetParentStyle = getComputedStyle(offsetParent);
            var offsetParentSize = offsetPosition;

            var offsetBorder = {};
            ['Top', 'Left', 'Bottom', 'Right'].forEach(function (side) {
              offsetBorder[side.toLowerCase()] = parseFloat(offsetParentStyle['border' + side + 'Width']);
            });

            offsetPosition.right = doc.body.scrollWidth - offsetPosition.left - offsetParentSize.width + offsetBorder.right;
            offsetPosition.bottom = doc.body.scrollHeight - offsetPosition.top - offsetParentSize.height + offsetBorder.bottom;

            if (next.page.top >= offsetPosition.top + offsetBorder.top && next.page.bottom >= offsetPosition.bottom) {
              if (next.page.left >= offsetPosition.left + offsetBorder.left && next.page.right >= offsetPosition.right) {
                // We're within the visible part of the target's scroll parent
                var scrollTop = offsetParent.scrollTop;
                var scrollLeft = offsetParent.scrollLeft;

                // It's position relative to the target's offset parent (absolute positioning when
                // the element is moved to be a child of the target's offset parent).
                next.offset = {
                  top: next.page.top - offsetPosition.top + scrollTop - offsetBorder.top,
                  left: next.page.left - offsetPosition.left + scrollLeft - offsetBorder.left
                };
              }
            }
          })();
        }

        // We could also travel up the DOM and try each containing context, rather than only
        // looking at the body, but we're gonna get diminishing returns.

        this.move(next);

        this.history.unshift(next);

        if (this.history.length > 3) {
          this.history.pop();
        }

        if (flushChanges) {
          flush();
        }

        return true;
      }

      // THE ISSUE
    }, {
      key: 'move',
      value: function move(pos) {
        var _this8 = this;

        if (!(typeof this.element.parentNode !== 'undefined')) {
          return;
        }

        var same = {};

        for (var type in pos) {
          same[type] = {};

          for (var key in pos[type]) {
            var found = false;

            for (var i = 0; i < this.history.length; ++i) {
              var point = this.history[i];
              if (typeof point[type] !== 'undefined' && !within(point[type][key], pos[type][key])) {
                found = true;
                break;
              }
            }

            if (!found) {
              same[type][key] = true;
            }
          }
        }

        var css = { top: '', left: '', right: '', bottom: '' };

        var transcribe = function transcribe(_same, _pos) {
          var hasOptimizations = typeof _this8.options.optimizations !== 'undefined';
          var gpu = hasOptimizations ? _this8.options.optimizations.gpu : null;
          if (gpu !== false) {
            var yPos = undefined,
                xPos = undefined;
            if (_same.top) {
              css.top = 0;
              yPos = _pos.top;
            } else {
              css.bottom = 0;
              yPos = -_pos.bottom;
            }

            if (_same.left) {
              css.left = 0;
              xPos = _pos.left;
            } else {
              css.right = 0;
              xPos = -_pos.right;
            }

            if (typeof window.devicePixelRatio === 'number' && devicePixelRatio % 1 === 0) {
              xPos = Math.round(xPos * devicePixelRatio) / devicePixelRatio;
              yPos = Math.round(yPos * devicePixelRatio) / devicePixelRatio;
            }

            css[transformKey] = 'translateX(' + xPos + 'px) translateY(' + yPos + 'px)';

            if (transformKey !== 'msTransform') {
              // The Z transform will keep this in the GPU (faster, and prevents artifacts),
              // but IE9 doesn't support 3d transforms and will choke.
              css[transformKey] += " translateZ(0)";
            }
          } else {
            if (_same.top) {
              css.top = _pos.top + 'px';
            } else {
              css.bottom = _pos.bottom + 'px';
            }

            if (_same.left) {
              css.left = _pos.left + 'px';
            } else {
              css.right = _pos.right + 'px';
            }
          }
        };

        var moved = false;
        if ((same.page.top || same.page.bottom) && (same.page.left || same.page.right)) {
          css.position = 'absolute';
          transcribe(same.page, pos.page);
        } else if ((same.viewport.top || same.viewport.bottom) && (same.viewport.left || same.viewport.right)) {
          css.position = 'fixed';
          transcribe(same.viewport, pos.viewport);
        } else if (typeof same.offset !== 'undefined' && same.offset.top && same.offset.left) {
          (function () {
            css.position = 'absolute';
            var offsetParent = _this8.cache('target-offsetparent', function () {
              return getOffsetParent(_this8.target);
            });

            if (getOffsetParent(_this8.element) !== offsetParent) {
              defer(function () {
                _this8.element.parentNode.removeChild(_this8.element);
                offsetParent.appendChild(_this8.element);
              });
            }

            transcribe(same.offset, pos.offset);
            moved = true;
          })();
        } else {
          css.position = 'absolute';
          transcribe({ top: true, left: true }, pos.page);
        }

        if (!moved) {
          if (this.options.bodyElement) {
            if (this.element.parentNode !== this.options.bodyElement) {
              this.options.bodyElement.appendChild(this.element);
            }
          } else {
            var isFullscreenElement = function isFullscreenElement(e) {
              var d = e.ownerDocument;
              var fe = d.fullscreenElement || d.webkitFullscreenElement || d.mozFullScreenElement || d.msFullscreenElement;
              return fe === e;
            };

            var offsetParentIsBody = true;

            var currentNode = this.element.parentNode;
            while (currentNode && currentNode.nodeType === 1 && currentNode.tagName !== 'BODY' && !isFullscreenElement(currentNode)) {
              if (getComputedStyle(currentNode).position !== 'static') {
                offsetParentIsBody = false;
                break;
              }

              currentNode = currentNode.parentNode;
            }

            if (!offsetParentIsBody) {
              this.element.parentNode.removeChild(this.element);
              this.element.ownerDocument.body.appendChild(this.element);
            }
          }
        }

        // Any css change will trigger a repaint, so let's avoid one if nothing changed
        var writeCSS = {};
        var write = false;
        for (var key in css) {
          var val = css[key];
          var elVal = this.element.style[key];

          if (elVal !== val) {
            write = true;
            writeCSS[key] = val;
          }
        }

        if (write) {
          defer(function () {
            extend(_this8.element.style, writeCSS);
            _this8.trigger('repositioned');
          });
        }
      }
    }]);

    return TetherClass;
  })(Evented);

  TetherClass.modules = [];

  TetherBase.position = position;

  var Tether = extend(TetherClass, TetherBase);
  /* globals TetherBase */

  'use strict';

  var _slicedToArray = (function () {
    function sliceIterator(arr, i) {
      var _arr = [];var _n = true;var _d = false;var _e = undefined;try {
        for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) {
          _arr.push(_s.value);if (i && _arr.length === i) break;
        }
      } catch (err) {
        _d = true;_e = err;
      } finally {
        try {
          if (!_n && _i['return']) _i['return']();
        } finally {
          if (_d) throw _e;
        }
      }return _arr;
    }return function (arr, i) {
      if (Array.isArray(arr)) {
        return arr;
      } else if (Symbol.iterator in Object(arr)) {
        return sliceIterator(arr, i);
      } else {
        throw new TypeError('Invalid attempt to destructure non-iterable instance');
      }
    };
  })();

  var _TetherBase$Utils = TetherBase.Utils;
  var getBounds = _TetherBase$Utils.getBounds;
  var extend = _TetherBase$Utils.extend;
  var updateClasses = _TetherBase$Utils.updateClasses;
  var defer = _TetherBase$Utils.defer;

  var BOUNDS_FORMAT = ['left', 'top', 'right', 'bottom'];

  function getBoundingRect(tether, to) {
    if (to === 'scrollParent') {
      to = tether.scrollParents[0];
    } else if (to === 'window') {
      to = [pageXOffset, pageYOffset, innerWidth + pageXOffset, innerHeight + pageYOffset];
    }

    if (to === document) {
      to = to.documentElement;
    }

    if (typeof to.nodeType !== 'undefined') {
      (function () {
        var node = to;
        var size = getBounds(to);
        var pos = size;
        var style = getComputedStyle(to);

        to = [pos.left, pos.top, size.width + pos.left, size.height + pos.top];

        // Account any parent Frames scroll offset
        if (node.ownerDocument !== document) {
          var win = node.ownerDocument.defaultView;
          to[0] += win.pageXOffset;
          to[1] += win.pageYOffset;
          to[2] += win.pageXOffset;
          to[3] += win.pageYOffset;
        }

        BOUNDS_FORMAT.forEach(function (side, i) {
          side = side[0].toUpperCase() + side.substr(1);
          if (side === 'Top' || side === 'Left') {
            to[i] += parseFloat(style['border' + side + 'Width']);
          } else {
            to[i] -= parseFloat(style['border' + side + 'Width']);
          }
        });
      })();
    }

    return to;
  }

  TetherBase.modules.push({
    position: function position(_ref) {
      var _this = this;

      var top = _ref.top;
      var left = _ref.left;
      var targetAttachment = _ref.targetAttachment;

      if (!this.options.constraints) {
        return true;
      }

      var _cache = this.cache('element-bounds', function () {
        return getBounds(_this.element);
      });

      var height = _cache.height;
      var width = _cache.width;

      if (width === 0 && height === 0 && typeof this.lastSize !== 'undefined') {
        var _lastSize = this.lastSize;

        // Handle the item getting hidden as a result of our positioning without glitching
        // the classes in and out
        width = _lastSize.width;
        height = _lastSize.height;
      }

      var targetSize = this.cache('target-bounds', function () {
        return _this.getTargetBounds();
      });

      var targetHeight = targetSize.height;
      var targetWidth = targetSize.width;

      var allClasses = [this.getClass('pinned'), this.getClass('out-of-bounds')];

      this.options.constraints.forEach(function (constraint) {
        var outOfBoundsClass = constraint.outOfBoundsClass;
        var pinnedClass = constraint.pinnedClass;

        if (outOfBoundsClass) {
          allClasses.push(outOfBoundsClass);
        }
        if (pinnedClass) {
          allClasses.push(pinnedClass);
        }
      });

      allClasses.forEach(function (cls) {
        ['left', 'top', 'right', 'bottom'].forEach(function (side) {
          allClasses.push(cls + '-' + side);
        });
      });

      var addClasses = [];

      var tAttachment = extend({}, targetAttachment);
      var eAttachment = extend({}, this.attachment);

      this.options.constraints.forEach(function (constraint) {
        var to = constraint.to;
        var attachment = constraint.attachment;
        var pin = constraint.pin;

        if (typeof attachment === 'undefined') {
          attachment = '';
        }

        var changeAttachX = undefined,
            changeAttachY = undefined;
        if (attachment.indexOf(' ') >= 0) {
          var _attachment$split = attachment.split(' ');

          var _attachment$split2 = _slicedToArray(_attachment$split, 2);

          changeAttachY = _attachment$split2[0];
          changeAttachX = _attachment$split2[1];
        } else {
          changeAttachX = changeAttachY = attachment;
        }

        var bounds = getBoundingRect(_this, to);

        if (changeAttachY === 'target' || changeAttachY === 'both') {
          if (top < bounds[1] && tAttachment.top === 'top') {
            top += targetHeight;
            tAttachment.top = 'bottom';
          }

          if (top + height > bounds[3] && tAttachment.top === 'bottom') {
            top -= targetHeight;
            tAttachment.top = 'top';
          }
        }

        if (changeAttachY === 'together') {
          if (tAttachment.top === 'top') {
            if (eAttachment.top === 'bottom' && top < bounds[1]) {
              top += targetHeight;
              tAttachment.top = 'bottom';

              top += height;
              eAttachment.top = 'top';
            } else if (eAttachment.top === 'top' && top + height > bounds[3] && top - (height - targetHeight) >= bounds[1]) {
              top -= height - targetHeight;
              tAttachment.top = 'bottom';

              eAttachment.top = 'bottom';
            }
          }

          if (tAttachment.top === 'bottom') {
            if (eAttachment.top === 'top' && top + height > bounds[3]) {
              top -= targetHeight;
              tAttachment.top = 'top';

              top -= height;
              eAttachment.top = 'bottom';
            } else if (eAttachment.top === 'bottom' && top < bounds[1] && top + (height * 2 - targetHeight) <= bounds[3]) {
              top += height - targetHeight;
              tAttachment.top = 'top';

              eAttachment.top = 'top';
            }
          }

          if (tAttachment.top === 'middle') {
            if (top + height > bounds[3] && eAttachment.top === 'top') {
              top -= height;
              eAttachment.top = 'bottom';
            } else if (top < bounds[1] && eAttachment.top === 'bottom') {
              top += height;
              eAttachment.top = 'top';
            }
          }
        }

        if (changeAttachX === 'target' || changeAttachX === 'both') {
          if (left < bounds[0] && tAttachment.left === 'left') {
            left += targetWidth;
            tAttachment.left = 'right';
          }

          if (left + width > bounds[2] && tAttachment.left === 'right') {
            left -= targetWidth;
            tAttachment.left = 'left';
          }
        }

        if (changeAttachX === 'together') {
          if (left < bounds[0] && tAttachment.left === 'left') {
            if (eAttachment.left === 'right') {
              left += targetWidth;
              tAttachment.left = 'right';

              left += width;
              eAttachment.left = 'left';
            } else if (eAttachment.left === 'left') {
              left += targetWidth;
              tAttachment.left = 'right';

              left -= width;
              eAttachment.left = 'right';
            }
          } else if (left + width > bounds[2] && tAttachment.left === 'right') {
            if (eAttachment.left === 'left') {
              left -= targetWidth;
              tAttachment.left = 'left';

              left -= width;
              eAttachment.left = 'right';
            } else if (eAttachment.left === 'right') {
              left -= targetWidth;
              tAttachment.left = 'left';

              left += width;
              eAttachment.left = 'left';
            }
          } else if (tAttachment.left === 'center') {
            if (left + width > bounds[2] && eAttachment.left === 'left') {
              left -= width;
              eAttachment.left = 'right';
            } else if (left < bounds[0] && eAttachment.left === 'right') {
              left += width;
              eAttachment.left = 'left';
            }
          }
        }

        if (changeAttachY === 'element' || changeAttachY === 'both') {
          if (top < bounds[1] && eAttachment.top === 'bottom') {
            top += height;
            eAttachment.top = 'top';
          }

          if (top + height > bounds[3] && eAttachment.top === 'top') {
            top -= height;
            eAttachment.top = 'bottom';
          }
        }

        if (changeAttachX === 'element' || changeAttachX === 'both') {
          if (left < bounds[0]) {
            if (eAttachment.left === 'right') {
              left += width;
              eAttachment.left = 'left';
            } else if (eAttachment.left === 'center') {
              left += width / 2;
              eAttachment.left = 'left';
            }
          }

          if (left + width > bounds[2]) {
            if (eAttachment.left === 'left') {
              left -= width;
              eAttachment.left = 'right';
            } else if (eAttachment.left === 'center') {
              left -= width / 2;
              eAttachment.left = 'right';
            }
          }
        }

        if (typeof pin === 'string') {
          pin = pin.split(',').map(function (p) {
            return p.trim();
          });
        } else if (pin === true) {
          pin = ['top', 'left', 'right', 'bottom'];
        }

        pin = pin || [];

        var pinned = [];
        var oob = [];

        if (top < bounds[1]) {
          if (pin.indexOf('top') >= 0) {
            top = bounds[1];
            pinned.push('top');
          } else {
            oob.push('top');
          }
        }

        if (top + height > bounds[3]) {
          if (pin.indexOf('bottom') >= 0) {
            top = bounds[3] - height;
            pinned.push('bottom');
          } else {
            oob.push('bottom');
          }
        }

        if (left < bounds[0]) {
          if (pin.indexOf('left') >= 0) {
            left = bounds[0];
            pinned.push('left');
          } else {
            oob.push('left');
          }
        }

        if (left + width > bounds[2]) {
          if (pin.indexOf('right') >= 0) {
            left = bounds[2] - width;
            pinned.push('right');
          } else {
            oob.push('right');
          }
        }

        if (pinned.length) {
          (function () {
            var pinnedClass = undefined;
            if (typeof _this.options.pinnedClass !== 'undefined') {
              pinnedClass = _this.options.pinnedClass;
            } else {
              pinnedClass = _this.getClass('pinned');
            }

            addClasses.push(pinnedClass);
            pinned.forEach(function (side) {
              addClasses.push(pinnedClass + '-' + side);
            });
          })();
        }

        if (oob.length) {
          (function () {
            var oobClass = undefined;
            if (typeof _this.options.outOfBoundsClass !== 'undefined') {
              oobClass = _this.options.outOfBoundsClass;
            } else {
              oobClass = _this.getClass('out-of-bounds');
            }

            addClasses.push(oobClass);
            oob.forEach(function (side) {
              addClasses.push(oobClass + '-' + side);
            });
          })();
        }

        if (pinned.indexOf('left') >= 0 || pinned.indexOf('right') >= 0) {
          eAttachment.left = tAttachment.left = false;
        }
        if (pinned.indexOf('top') >= 0 || pinned.indexOf('bottom') >= 0) {
          eAttachment.top = tAttachment.top = false;
        }

        if (tAttachment.top !== targetAttachment.top || tAttachment.left !== targetAttachment.left || eAttachment.top !== _this.attachment.top || eAttachment.left !== _this.attachment.left) {
          _this.updateAttachClasses(eAttachment, tAttachment);
          _this.trigger('update', {
            attachment: eAttachment,
            targetAttachment: tAttachment
          });
        }
      });

      defer(function () {
        if (!(_this.options.addTargetClasses === false)) {
          updateClasses(_this.target, addClasses, allClasses);
        }
        updateClasses(_this.element, addClasses, allClasses);
      });

      return { top: top, left: left };
    }
  });
  /* globals TetherBase */

  'use strict';

  var _TetherBase$Utils = TetherBase.Utils;
  var getBounds = _TetherBase$Utils.getBounds;
  var updateClasses = _TetherBase$Utils.updateClasses;
  var defer = _TetherBase$Utils.defer;

  TetherBase.modules.push({
    position: function position(_ref) {
      var _this = this;

      var top = _ref.top;
      var left = _ref.left;

      var _cache = this.cache('element-bounds', function () {
        return getBounds(_this.element);
      });

      var height = _cache.height;
      var width = _cache.width;

      var targetPos = this.getTargetBounds();

      var bottom = top + height;
      var right = left + width;

      var abutted = [];
      if (top <= targetPos.bottom && bottom >= targetPos.top) {
        ['left', 'right'].forEach(function (side) {
          var targetPosSide = targetPos[side];
          if (targetPosSide === left || targetPosSide === right) {
            abutted.push(side);
          }
        });
      }

      if (left <= targetPos.right && right >= targetPos.left) {
        ['top', 'bottom'].forEach(function (side) {
          var targetPosSide = targetPos[side];
          if (targetPosSide === top || targetPosSide === bottom) {
            abutted.push(side);
          }
        });
      }

      var allClasses = [];
      var addClasses = [];

      var sides = ['left', 'top', 'right', 'bottom'];
      allClasses.push(this.getClass('abutted'));
      sides.forEach(function (side) {
        allClasses.push(_this.getClass('abutted') + '-' + side);
      });

      if (abutted.length) {
        addClasses.push(this.getClass('abutted'));
      }

      abutted.forEach(function (side) {
        addClasses.push(_this.getClass('abutted') + '-' + side);
      });

      defer(function () {
        if (!(_this.options.addTargetClasses === false)) {
          updateClasses(_this.target, addClasses, allClasses);
        }
        updateClasses(_this.element, addClasses, allClasses);
      });

      return true;
    }
  });
  /* globals TetherBase */

  'use strict';

  var _slicedToArray = (function () {
    function sliceIterator(arr, i) {
      var _arr = [];var _n = true;var _d = false;var _e = undefined;try {
        for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) {
          _arr.push(_s.value);if (i && _arr.length === i) break;
        }
      } catch (err) {
        _d = true;_e = err;
      } finally {
        try {
          if (!_n && _i['return']) _i['return']();
        } finally {
          if (_d) throw _e;
        }
      }return _arr;
    }return function (arr, i) {
      if (Array.isArray(arr)) {
        return arr;
      } else if (Symbol.iterator in Object(arr)) {
        return sliceIterator(arr, i);
      } else {
        throw new TypeError('Invalid attempt to destructure non-iterable instance');
      }
    };
  })();

  TetherBase.modules.push({
    position: function position(_ref) {
      var top = _ref.top;
      var left = _ref.left;

      if (!this.options.shift) {
        return;
      }

      var shift = this.options.shift;
      if (typeof this.options.shift === 'function') {
        shift = this.options.shift.call(this, { top: top, left: left });
      }

      var shiftTop = undefined,
          shiftLeft = undefined;
      if (typeof shift === 'string') {
        shift = shift.split(' ');
        shift[1] = shift[1] || shift[0];

        var _shift = shift;

        var _shift2 = _slicedToArray(_shift, 2);

        shiftTop = _shift2[0];
        shiftLeft = _shift2[1];

        shiftTop = parseFloat(shiftTop, 10);
        shiftLeft = parseFloat(shiftLeft, 10);
      } else {
        shiftTop = shift.top;
        shiftLeft = shift.left;
      }

      top += shiftTop;
      left += shiftLeft;

      return { top: top, left: left };
    }
  });
  return Tether;
});

/***/ }),
/* 28 */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(global) {module.exports = global["Tether"] = __webpack_require__(27);
/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(5)))

/***/ }),
/* 29 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
var classCallCheck = function (instance, Constructor) {
  if (!(instance instanceof Constructor)) {
    throw new TypeError("Cannot call a class as a function");
  }
};

var createClass = function () {
  function defineProperties(target, props) {
    for (var i = 0; i < props.length; i++) {
      var descriptor = props[i];
      descriptor.enumerable = descriptor.enumerable || false;
      descriptor.configurable = true;
      if ("value" in descriptor) descriptor.writable = true;
      Object.defineProperty(target, descriptor.key, descriptor);
    }
  }

  return function (Constructor, protoProps, staticProps) {
    if (protoProps) defineProperties(Constructor.prototype, protoProps);
    if (staticProps) defineProperties(Constructor, staticProps);
    return Constructor;
  };
}();

var slicedToArray = function () {
  function sliceIterator(arr, i) {
    var _arr = [];
    var _n = true;
    var _d = false;
    var _e = undefined;

    try {
      for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) {
        _arr.push(_s.value);

        if (i && _arr.length === i) break;
      }
    } catch (err) {
      _d = true;
      _e = err;
    } finally {
      try {
        if (!_n && _i["return"]) _i["return"]();
      } finally {
        if (_d) throw _e;
      }
    }

    return _arr;
  }

  return function (arr, i) {
    if (Array.isArray(arr)) {
      return arr;
    } else if (Symbol.iterator in Object(arr)) {
      return sliceIterator(arr, i);
    } else {
      throw new TypeError("Invalid attempt to destructure non-iterable instance");
    }
  };
}();

String.prototype.startsWith = String.prototype.startsWith || function (needle) {
    return this.indexOf(needle) === 0;
};
String.prototype.padStart = String.prototype.padStart || function (len, pad) {
    var str = this;while (str.length < len) {
        str = pad + str;
    }return str;
};

var colorNames = { cb: '0f8ff', tqw: 'aebd7', q: '-ffff', qmrn: '7fffd4', zr: '0ffff', bg: '5f5dc', bsq: 'e4c4', bck: '---', nch: 'ebcd', b: '--ff', bvt: '8a2be2', brwn: 'a52a2a', brw: 'deb887', ctb: '5f9ea0', hrt: '7fff-', chcT: 'd2691e', cr: '7f50', rnw: '6495ed', crns: '8dc', crms: 'dc143c', cn: '-ffff', Db: '--8b', Dcn: '-8b8b', Dgnr: 'b8860b', Dgr: 'a9a9a9', Dgrn: '-64-', Dkhk: 'bdb76b', Dmgn: '8b-8b', Dvgr: '556b2f', Drng: '8c-', Drch: '9932cc', Dr: '8b--', Dsmn: 'e9967a', Dsgr: '8fbc8f', DsTb: '483d8b', DsTg: '2f4f4f', Dtrq: '-ced1', Dvt: '94-d3', ppnk: '1493', pskb: '-bfff', mgr: '696969', grb: '1e90ff', rbrc: 'b22222', rwht: 'af0', stg: '228b22', chs: '-ff', gnsb: 'dcdcdc', st: '8f8ff', g: 'd7-', gnr: 'daa520', gr: '808080', grn: '-8-0', grnw: 'adff2f', hnw: '0fff0', htpn: '69b4', nnr: 'cd5c5c', ng: '4b-82', vr: '0', khk: '0e68c', vnr: 'e6e6fa', nrb: '0f5', wngr: '7cfc-', mnch: 'acd', Lb: 'add8e6', Lcr: '08080', Lcn: 'e0ffff', Lgnr: 'afad2', Lgr: 'd3d3d3', Lgrn: '90ee90', Lpnk: 'b6c1', Lsmn: 'a07a', Lsgr: '20b2aa', Lskb: '87cefa', LsTg: '778899', Lstb: 'b0c4de', Lw: 'e0', m: '-ff-', mgrn: '32cd32', nn: 'af0e6', mgnt: '-ff', mrn: '8--0', mqm: '66cdaa', mmb: '--cd', mmrc: 'ba55d3', mmpr: '9370db', msg: '3cb371', mmsT: '7b68ee', '': '-fa9a', mtr: '48d1cc', mmvt: 'c71585', mnLb: '191970', ntc: '5fffa', mstr: 'e4e1', mccs: 'e4b5', vjw: 'dead', nv: '--80', c: 'df5e6', v: '808-0', vrb: '6b8e23', rng: 'a5-', rngr: '45-', rch: 'da70d6', pgnr: 'eee8aa', pgrn: '98fb98', ptrq: 'afeeee', pvtr: 'db7093', ppwh: 'efd5', pchp: 'dab9', pr: 'cd853f', pnk: 'c0cb', pm: 'dda0dd', pwrb: 'b0e0e6', prp: '8-080', cc: '663399', r: '--', sbr: 'bc8f8f', rb: '4169e1', sbrw: '8b4513', smn: 'a8072', nbr: '4a460', sgrn: '2e8b57', ssh: '5ee', snn: 'a0522d', svr: 'c0c0c0', skb: '87ceeb', sTb: '6a5acd', sTgr: '708090', snw: 'afa', n: '-ff7f', stb: '4682b4', tn: 'd2b48c', t: '-8080', thst: 'd8bfd8', tmT: '6347', trqs: '40e0d0', vt: 'ee82ee', whT: '5deb3', wht: '', hts: '5f5f5', w: '-', wgrn: '9acd32' };

function printNum(num) {
    var decs = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 1;

    var str = decs > 0 ? num.toFixed(decs).replace(/0+$/, '').replace(/\.$/, '') : num.toString();
    return str || '0';
}

var Color = function () {
    function Color(r, g, b, a) {
        classCallCheck(this, Color);


        var that = this;
        function parseString(input) {

            if (input.startsWith('hsl')) {
                var _input$match$map = input.match(/([\-\d\.e]+)/g).map(Number),
                    _input$match$map2 = slicedToArray(_input$match$map, 4),
                    h = _input$match$map2[0],
                    s = _input$match$map2[1],
                    l = _input$match$map2[2],
                    _a = _input$match$map2[3];

                if (_a === undefined) {
                    _a = 1;
                }

                h /= 360;
                s /= 100;
                l /= 100;
                that.hsla = [h, s, l, _a];
            } else if (input.startsWith('rgb')) {
                var _input$match$map3 = input.match(/([\-\d\.e]+)/g).map(Number),
                    _input$match$map4 = slicedToArray(_input$match$map3, 4),
                    _r = _input$match$map4[0],
                    _g = _input$match$map4[1],
                    _b = _input$match$map4[2],
                    _a2 = _input$match$map4[3];

                if (_a2 === undefined) {
                    _a2 = 1;
                }

                that.rgba = [_r, _g, _b, _a2];
            } else {
                if (input.startsWith('#')) {
                    that.rgba = Color.hexToRgb(input);
                } else {
                    that.rgba = Color.nameToRgb(input) || Color.hexToRgb(input);
                }
            }
        }

        if (r === undefined) ; else if (Array.isArray(r)) {
            this.rgba = r;
        } else if (b === undefined) {
            var color = r && '' + r;
            if (color) {
                parseString(color.toLowerCase());
            }
        } else {
            this.rgba = [r, g, b, a === undefined ? 1 : a];
        }
    }

    createClass(Color, [{
        key: 'printRGB',
        value: function printRGB(alpha) {
            var rgb = alpha ? this.rgba : this.rgba.slice(0, 3),
                vals = rgb.map(function (x, i) {
                return printNum(x, i === 3 ? 3 : 0);
            });

            return alpha ? 'rgba(' + vals + ')' : 'rgb(' + vals + ')';
        }
    }, {
        key: 'printHSL',
        value: function printHSL(alpha) {
            var mults = [360, 100, 100, 1],
                suff = ['', '%', '%', ''];

            var hsl = alpha ? this.hsla : this.hsla.slice(0, 3),
                vals = hsl.map(function (x, i) {
                return printNum(x * mults[i], i === 3 ? 3 : 1) + suff[i];
            });

            return alpha ? 'hsla(' + vals + ')' : 'hsl(' + vals + ')';
        }
    }, {
        key: 'printHex',
        value: function printHex(alpha) {
            var hex = this.hex;
            return alpha ? hex : hex.substring(0, 7);
        }
    }, {
        key: 'rgba',
        get: function get$$1() {
            if (this._rgba) {
                return this._rgba;
            }
            if (!this._hsla) {
                throw new Error('No color is set');
            }

            return this._rgba = Color.hslToRgb(this._hsla);
        },
        set: function set$$1(rgb) {
            if (rgb.length === 3) {
                rgb[3] = 1;
            }

            this._rgba = rgb;
            this._hsla = null;
        }
    }, {
        key: 'rgbString',
        get: function get$$1() {
            return this.printRGB();
        }
    }, {
        key: 'rgbaString',
        get: function get$$1() {
            return this.printRGB(true);
        }
    }, {
        key: 'hsla',
        get: function get$$1() {
            if (this._hsla) {
                return this._hsla;
            }
            if (!this._rgba) {
                throw new Error('No color is set');
            }

            return this._hsla = Color.rgbToHsl(this._rgba);
        },
        set: function set$$1(hsl) {
            if (hsl.length === 3) {
                hsl[3] = 1;
            }

            this._hsla = hsl;
            this._rgba = null;
        }
    }, {
        key: 'hslString',
        get: function get$$1() {
            return this.printHSL();
        }
    }, {
        key: 'hslaString',
        get: function get$$1() {
            return this.printHSL(true);
        }
    }, {
        key: 'hex',
        get: function get$$1() {
            var rgb = this.rgba,
                hex = rgb.map(function (x, i) {
                return i < 3 ? x.toString(16) : Math.round(x * 255).toString(16);
            });

            return '#' + hex.map(function (x) {
                return x.padStart(2, '0');
            }).join('');
        },
        set: function set$$1(hex) {
            this.rgba = Color.hexToRgb(hex);
        }
    }], [{
        key: 'hexToRgb',
        value: function hexToRgb(input) {

            var hex = (input.startsWith('#') ? input.slice(1) : input).replace(/^(\w{3})$/, '$1F').replace(/^(\w)(\w)(\w)(\w)$/, '$1$1$2$2$3$3$4$4').replace(/^(\w{6})$/, '$1FF');

            if (!hex.match(/^([0-9a-fA-F]{8})$/)) {
                throw new Error('Unknown hex color; ' + input);
            }

            var rgba = hex.match(/^(\w\w)(\w\w)(\w\w)(\w\w)$/).slice(1).map(function (x) {
                return parseInt(x, 16);
            });

            rgba[3] = rgba[3] / 255;
            return rgba;
        }
    }, {
        key: 'nameToRgb',
        value: function nameToRgb(input) {

            var hash = input.toLowerCase().replace('at', 'T').replace(/[aeiouyldf]/g, '').replace('ght', 'L').replace('rk', 'D').slice(-5, 4),
                hex = colorNames[hash];
            return hex === undefined ? hex : Color.hexToRgb(hex.replace(/\-/g, '00').padStart(6, 'f'));
        }
    }, {
        key: 'rgbToHsl',
        value: function rgbToHsl(_ref) {
            var _ref2 = slicedToArray(_ref, 4),
                r = _ref2[0],
                g = _ref2[1],
                b = _ref2[2],
                a = _ref2[3];

            r /= 255;
            g /= 255;
            b /= 255;

            var max = Math.max(r, g, b),
                min = Math.min(r, g, b);
            var h = void 0,
                s = void 0,
                l = (max + min) / 2;

            if (max === min) {
                h = s = 0;
            } else {
                var d = max - min;
                s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
                switch (max) {
                    case r:
                        h = (g - b) / d + (g < b ? 6 : 0);break;
                    case g:
                        h = (b - r) / d + 2;break;
                    case b:
                        h = (r - g) / d + 4;break;
                }

                h /= 6;
            }

            return [h, s, l, a];
        }
    }, {
        key: 'hslToRgb',
        value: function hslToRgb(_ref3) {
            var _ref4 = slicedToArray(_ref3, 4),
                h = _ref4[0],
                s = _ref4[1],
                l = _ref4[2],
                a = _ref4[3];

            var r = void 0,
                g = void 0,
                b = void 0;

            if (s === 0) {
                r = g = b = l;
            } else {
                var hue2rgb = function hue2rgb(p, q, t) {
                    if (t < 0) t += 1;
                    if (t > 1) t -= 1;
                    if (t < 1 / 6) return p + (q - p) * 6 * t;
                    if (t < 1 / 2) return q;
                    if (t < 2 / 3) return p + (q - p) * (2 / 3 - t) * 6;
                    return p;
                };

                var q = l < 0.5 ? l * (1 + s) : l + s - l * s,
                    p = 2 * l - q;

                r = hue2rgb(p, q, h + 1 / 3);
                g = hue2rgb(p, q, h);
                b = hue2rgb(p, q, h - 1 / 3);
            }

            var rgba = [r * 255, g * 255, b * 255].map(Math.round);
            rgba[3] = a;

            return rgba;
        }
    }]);
    return Color;
}();

var EventBucket = function () {
    function EventBucket() {
        classCallCheck(this, EventBucket);

        this._events = [];
    }

    createClass(EventBucket, [{
        key: 'add',
        value: function add(target, type, handler) {
            target.addEventListener(type, handler, false);
            this._events.push({
                target: target,
                type: type,
                handler: handler
            });
        }
    }, {
        key: 'remove',
        value: function remove(target, type, handler) {
            this._events = this._events.filter(function (e) {
                var isMatch = true;
                if (target && target !== e.target) {
                    isMatch = false;
                }
                if (type && type !== e.type) {
                    isMatch = false;
                }
                if (handler && handler !== e.handler) {
                    isMatch = false;
                }

                if (isMatch) {
                    EventBucket._doRemove(e.target, e.type, e.handler);
                }
                return !isMatch;
            });
        }
    }, {
        key: 'destroy',
        value: function destroy() {
            this._events.forEach(function (e) {
                return EventBucket._doRemove(e.target, e.type, e.handler);
            });
            this._events = [];
        }
    }], [{
        key: '_doRemove',
        value: function _doRemove(target, type, handler) {
            target.removeEventListener(type, handler, false);
        }
    }]);
    return EventBucket;
}();

function parseHTML(htmlString) {

    var div = document.createElement('div');
    div.innerHTML = htmlString;
    return div.firstElementChild;
}

function dragTrack(eventBucket, area, callback) {
    var dragging = false;

    function clamp(val, min, max) {
        return Math.max(min, Math.min(val, max));
    }

    function onMove(e, info, starting) {
        if (starting) {
            dragging = true;
        }
        if (!dragging) {
            return;
        }

        e.preventDefault();

        var bounds = area.getBoundingClientRect(),
            w = bounds.width,
            h = bounds.height,
            x = info.clientX,
            y = info.clientY;

        var relX = clamp(x - bounds.left, 0, w),
            relY = clamp(y - bounds.top, 0, h);

        callback(relX / w, relY / h);
    }

    function onMouse(e, starting) {
        var button = e.buttons === undefined ? e.which : e.buttons;
        if (button === 1) {
            onMove(e, e, starting);
        } else {
            dragging = false;
        }
    }

    function onTouch(e, starting) {
        if (e.touches.length === 1) {
            onMove(e, e.touches[0], starting);
        } else {
            dragging = false;
        }
    }

    eventBucket.add(area, 'mousedown', function (e) {
        onMouse(e, true);
    });
    eventBucket.add(area, 'touchstart', function (e) {
        onTouch(e, true);
    });
    eventBucket.add(window, 'mousemove', onMouse);
    eventBucket.add(area, 'touchmove', onTouch);
    eventBucket.add(window, 'mouseup', function (e) {
        dragging = false;
    });
    eventBucket.add(area, 'touchend', function (e) {
        dragging = false;
    });
    eventBucket.add(area, 'touchcancel', function (e) {
        dragging = false;
    });
}

var BG_TRANSP = 'url("data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'2\' height=\'2\'%3E%3Cpath d=\'M1,0H0V1H2V2H1\' fill=\'lightgrey\'/%3E%3C/svg%3E")';
var HUES = 360;

var EVENT_KEY = 'keydown',
    EVENT_CLICK_OUTSIDE = 'mousedown',
    EVENT_TAB_MOVE = 'focusin';

function $(selector, context) {
    return (context || document).querySelector(selector);
}

function stopEvent(e) {

    e.preventDefault();
    e.stopPropagation();
}
function onKey(bucket, target, keys, handler, stop) {
    bucket.add(target, EVENT_KEY, function (e) {
        if (keys.indexOf(e.key) >= 0) {
            if (stop) {
                stopEvent(e);
            }
            handler(e);
        }
    });
}

var _style = document.createElement('style');
_style.textContent = '.picker_wrapper.no_alpha .picker_alpha{display:none}.picker_wrapper.no_editor .picker_editor{position:absolute;z-index:-1;opacity:0}.picker_wrapper.no_cancel .picker_cancel{display:none}.layout_default.picker_wrapper{display:-webkit-box;display:flex;-webkit-box-orient:horizontal;-webkit-box-direction:normal;flex-flow:row wrap;-webkit-box-pack:justify;justify-content:space-between;-webkit-box-align:stretch;align-items:stretch;font-size:10px;width:25em;padding:.5em}.layout_default.picker_wrapper input,.layout_default.picker_wrapper button{font-size:1rem}.layout_default.picker_wrapper>*{margin:.5em}.layout_default.picker_wrapper::before{content:\'\';display:block;width:100%;height:0;-webkit-box-ordinal-group:2;order:1}.layout_default .picker_slider,.layout_default .picker_selector{padding:1em}.layout_default .picker_hue{width:100%}.layout_default .picker_sl{-webkit-box-flex:1;flex:1 1 auto}.layout_default .picker_sl::before{content:\'\';display:block;padding-bottom:100%}.layout_default .picker_editor{-webkit-box-ordinal-group:2;order:1;width:6.5rem}.layout_default .picker_editor input{width:100%;height:100%}.layout_default .picker_sample{-webkit-box-ordinal-group:2;order:1;-webkit-box-flex:1;flex:1 1 auto}.layout_default .picker_done,.layout_default .picker_cancel{-webkit-box-ordinal-group:2;order:1}.picker_wrapper{box-sizing:border-box;background:#f2f2f2;box-shadow:0 0 0 1px silver;cursor:default;font-family:sans-serif;color:#444;pointer-events:auto}.picker_wrapper:focus{outline:none}.picker_wrapper button,.picker_wrapper input{box-sizing:border-box;border:none;box-shadow:0 0 0 1px silver;outline:none}.picker_wrapper button:focus,.picker_wrapper button:active,.picker_wrapper input:focus,.picker_wrapper input:active{box-shadow:0 0 2px 1px dodgerblue}.picker_wrapper button{padding:.4em .6em;cursor:pointer;background-color:whitesmoke;background-image:-webkit-gradient(linear, left bottom, left top, from(gainsboro), to(transparent));background-image:-webkit-linear-gradient(bottom, gainsboro, transparent);background-image:linear-gradient(0deg, gainsboro, transparent)}.picker_wrapper button:active{background-image:-webkit-gradient(linear, left bottom, left top, from(transparent), to(gainsboro));background-image:-webkit-linear-gradient(bottom, transparent, gainsboro);background-image:linear-gradient(0deg, transparent, gainsboro)}.picker_wrapper button:hover{background-color:white}.picker_selector{position:absolute;z-index:1;display:block;-webkit-transform:translate(-50%, -50%);transform:translate(-50%, -50%);border:2px solid white;border-radius:100%;box-shadow:0 0 3px 1px #67b9ff;background:currentColor;cursor:pointer}.picker_slider .picker_selector{border-radius:2px}.picker_hue{position:relative;background-image:-webkit-gradient(linear, left top, right top, from(red), color-stop(yellow), color-stop(lime), color-stop(cyan), color-stop(blue), color-stop(magenta), to(red));background-image:-webkit-linear-gradient(left, red, yellow, lime, cyan, blue, magenta, red);background-image:linear-gradient(90deg, red, yellow, lime, cyan, blue, magenta, red);box-shadow:0 0 0 1px silver}.picker_sl{position:relative;box-shadow:0 0 0 1px silver;background-image:-webkit-gradient(linear, left top, left bottom, from(white), color-stop(50%, rgba(255,255,255,0))),-webkit-gradient(linear, left bottom, left top, from(black), color-stop(50%, rgba(0,0,0,0))),-webkit-gradient(linear, left top, right top, from(gray), to(rgba(128,128,128,0)));background-image:-webkit-linear-gradient(top, white, rgba(255,255,255,0) 50%),-webkit-linear-gradient(bottom, black, rgba(0,0,0,0) 50%),-webkit-linear-gradient(left, gray, rgba(128,128,128,0));background-image:linear-gradient(180deg, white, rgba(255,255,255,0) 50%),linear-gradient(0deg, black, rgba(0,0,0,0) 50%),linear-gradient(90deg, gray, rgba(128,128,128,0))}.picker_alpha,.picker_sample{position:relative;background:url("data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'2\' height=\'2\'%3E%3Cpath d=\'M1,0H0V1H2V2H1\' fill=\'lightgrey\'/%3E%3C/svg%3E") left top/contain white;box-shadow:0 0 0 1px silver}.picker_alpha .picker_selector,.picker_sample .picker_selector{background:none}.picker_editor input{font-family:monospace;padding:.2em .4em}.picker_sample::before{content:\'\';position:absolute;display:block;width:100%;height:100%;background:currentColor}.picker_arrow{position:absolute;z-index:-1}.picker_wrapper.popup{position:absolute;z-index:2;margin:1.5em}.picker_wrapper.popup,.picker_wrapper.popup .picker_arrow::before,.picker_wrapper.popup .picker_arrow::after{background:#f2f2f2;box-shadow:0 0 10px 1px rgba(0,0,0,0.4)}.picker_wrapper.popup .picker_arrow{width:3em;height:3em;margin:0}.picker_wrapper.popup .picker_arrow::before,.picker_wrapper.popup .picker_arrow::after{content:"";display:block;position:absolute;top:0;left:0;z-index:-99}.picker_wrapper.popup .picker_arrow::before{width:100%;height:100%;-webkit-transform:skew(45deg);transform:skew(45deg);-webkit-transform-origin:0 100%;transform-origin:0 100%}.picker_wrapper.popup .picker_arrow::after{width:150%;height:150%;box-shadow:none}.popup.popup_top{bottom:100%;left:0}.popup.popup_top .picker_arrow{bottom:0;left:0;-webkit-transform:rotate(-90deg);transform:rotate(-90deg)}.popup.popup_bottom{top:100%;left:0}.popup.popup_bottom .picker_arrow{top:0;left:0;-webkit-transform:rotate(90deg) scale(1, -1);transform:rotate(90deg) scale(1, -1)}.popup.popup_left{top:0;right:100%}.popup.popup_left .picker_arrow{top:0;right:0;-webkit-transform:scale(-1, 1);transform:scale(-1, 1)}.popup.popup_right{top:0;left:100%}.popup.popup_right .picker_arrow{top:0;left:0}';
document.documentElement.firstElementChild.appendChild(_style);

var Picker = function () {
    function Picker(options) {
        classCallCheck(this, Picker);


        this.settings = {

            popup: 'right',
            layout: 'default',
            alpha: true,
            editor: true,
            editorFormat: 'hex',
            cancelButton: false,
            defaultColor: '#0cf'
        };

        this._events = new EventBucket();

        this.onChange = null;

        this.onDone = null;

        this.onOpen = null;

        this.onClose = null;

        this.setOptions(options);
    }

    createClass(Picker, [{
        key: 'setOptions',
        value: function setOptions(options) {
            var _this = this;

            if (!options) {
                return;
            }
            var settings = this.settings;

            function transfer(source, target, skipKeys) {
                for (var key in source) {
                    if (skipKeys && skipKeys.indexOf(key) >= 0) {
                        continue;
                    }

                    target[key] = source[key];
                }
            }

            if (options instanceof HTMLElement) {
                settings.parent = options;
            } else {

                if (settings.parent && options.parent && settings.parent !== options.parent) {
                    this._events.remove(settings.parent);
                    this._popupInited = false;
                }

                transfer(options, settings);

                if (options.onChange) {
                    this.onChange = options.onChange;
                }
                if (options.onDone) {
                    this.onDone = options.onDone;
                }
                if (options.onOpen) {
                    this.onOpen = options.onOpen;
                }
                if (options.onClose) {
                    this.onClose = options.onClose;
                }

                var col = options.color || options.colour;
                if (col) {
                    this._setColor(col);
                }
            }

            var parent = settings.parent;
            if (parent && settings.popup && !this._popupInited) {

                var openProxy = function openProxy(e) {
                    return _this.openHandler(e);
                };

                this._events.add(parent, 'click', openProxy);

                onKey(this._events, parent, [' ', 'Spacebar', 'Enter'], openProxy);

                this._popupInited = true;
            } else if (options.parent && !settings.popup) {
                this.show();
            }
        }
    }, {
        key: 'openHandler',
        value: function openHandler(e) {
            if (this.show()) {

                e && e.preventDefault();

                this.settings.parent.style.pointerEvents = 'none';

                var toFocus = e && e.type === EVENT_KEY ? this._domEdit : this.domElement;
                setTimeout(function () {
                    return toFocus.focus();
                }, 100);

                if (this.onOpen) {
                    this.onOpen(this.colour);
                }
            }
        }
    }, {
        key: 'closeHandler',
        value: function closeHandler(e) {
            var event = e && e.type;
            var doHide = false;

            if (!e) {
                doHide = true;
            } else if (event === EVENT_CLICK_OUTSIDE || event === EVENT_TAB_MOVE) {

                var knownTime = (this.__containedEvent || 0) + 100;
                if (e.timeStamp > knownTime) {
                    doHide = true;
                }
            } else {

                stopEvent(e);

                doHide = true;
            }

            if (doHide && this.hide()) {
                this.settings.parent.style.pointerEvents = '';

                if (event !== EVENT_CLICK_OUTSIDE) {
                    this.settings.parent.focus();
                }

                if (this.onClose) {
                    this.onClose(this.colour);
                }
            }
        }
    }, {
        key: 'movePopup',
        value: function movePopup(options, open) {

            this.closeHandler();

            this.setOptions(options);
            if (open) {
                this.openHandler();
            }
        }
    }, {
        key: 'setColor',
        value: function setColor(color, silent) {
            this._setColor(color, { silent: silent });
        }
    }, {
        key: '_setColor',
        value: function _setColor(color, flags) {
            if (typeof color === 'string') {
                color = color.trim();
            }
            if (!color) {
                return;
            }

            flags = flags || {};
            var c = void 0;
            try {

                c = new Color(color);
            } catch (ex) {
                if (flags.failSilently) {
                    return;
                }
                throw ex;
            }

            if (!this.settings.alpha) {
                var hsla = c.hsla;
                hsla[3] = 1;
                c.hsla = hsla;
            }
            this.colour = this.color = c;
            this._setHSLA(null, null, null, null, flags);
        }
    }, {
        key: 'setColour',
        value: function setColour(colour, silent) {
            this.setColor(colour, silent);
        }
    }, {
        key: 'show',
        value: function show() {
            var parent = this.settings.parent;
            if (!parent) {
                return false;
            }

            if (this.domElement) {
                var toggled = this._toggleDOM(true);

                this._setPosition();

                return toggled;
            }

            var html = this.settings.template || '<div class="picker_wrapper" tabindex="-1"><div class="picker_arrow"></div><div class="picker_hue picker_slider"><div class="picker_selector"></div></div><div class="picker_sl"><div class="picker_selector"></div></div><div class="picker_alpha picker_slider"><div class="picker_selector"></div></div><div class="picker_editor"><input aria-label="Type a color name or hex value"/></div><div class="picker_sample"></div><div class="picker_done"><button>Ok</button></div><div class="picker_cancel"><button>Cancel</button></div></div>';
            var wrapper = parseHTML(html);

            this.domElement = wrapper;
            this._domH = $('.picker_hue', wrapper);
            this._domSL = $('.picker_sl', wrapper);
            this._domA = $('.picker_alpha', wrapper);
            this._domEdit = $('.picker_editor input', wrapper);
            this._domSample = $('.picker_sample', wrapper);
            this._domOkay = $('.picker_done button', wrapper);
            this._domCancel = $('.picker_cancel button', wrapper);

            wrapper.classList.add('layout_' + this.settings.layout);
            if (!this.settings.alpha) {
                wrapper.classList.add('no_alpha');
            }
            if (!this.settings.editor) {
                wrapper.classList.add('no_editor');
            }
            if (!this.settings.cancelButton) {
                wrapper.classList.add('no_cancel');
            }
            this._ifPopup(function () {
                return wrapper.classList.add('popup');
            });

            this._setPosition();

            if (this.colour) {
                this._updateUI();
            } else {
                this._setColor(this.settings.defaultColor);
            }
            this._bindEvents();

            return true;
        }
    }, {
        key: 'hide',
        value: function hide() {
            return this._toggleDOM(false);
        }
    }, {
        key: 'destroy',
        value: function destroy() {
            this._events.destroy();
            if (this.domElement) {
                this.settings.parent.removeChild(this.domElement);
            }
        }
    }, {
        key: '_bindEvents',
        value: function _bindEvents() {
            var _this2 = this;

            var that = this,
                dom = this.domElement,
                events = this._events;

            function addEvent(target, type, handler) {
                events.add(target, type, handler);
            }

            addEvent(dom, 'click', function (e) {
                return e.preventDefault();
            });

            dragTrack(events, this._domH, function (x, y) {
                return that._setHSLA(x);
            });

            dragTrack(events, this._domSL, function (x, y) {
                return that._setHSLA(null, x, 1 - y);
            });

            if (this.settings.alpha) {
                dragTrack(events, this._domA, function (x, y) {
                    return that._setHSLA(null, null, null, 1 - y);
                });
            }

            var editInput = this._domEdit;
            {
                addEvent(editInput, 'input', function (e) {
                    that._setColor(this.value, { fromEditor: true, failSilently: true });
                });

                addEvent(editInput, 'focus', function (e) {
                    var input = this;

                    if (input.selectionStart === input.selectionEnd) {
                        input.select();
                    }
                });
            }

            this._ifPopup(function () {

                var popupCloseProxy = function popupCloseProxy(e) {
                    return _this2.closeHandler(e);
                };

                addEvent(window, EVENT_CLICK_OUTSIDE, popupCloseProxy);
                addEvent(window, EVENT_TAB_MOVE, popupCloseProxy);
                onKey(events, dom, ['Esc', 'Escape'], popupCloseProxy);

                var timeKeeper = function timeKeeper(e) {
                    _this2.__containedEvent = e.timeStamp;
                };
                addEvent(dom, EVENT_CLICK_OUTSIDE, timeKeeper);

                addEvent(dom, EVENT_TAB_MOVE, timeKeeper);

                addEvent(_this2._domCancel, 'click', popupCloseProxy);
            });

            var onDoneProxy = function onDoneProxy(e) {
                _this2._ifPopup(function () {
                    return _this2.closeHandler(e);
                });
                if (_this2.onDone) {
                    _this2.onDone(_this2.colour);
                }
            };
            addEvent(this._domOkay, 'click', onDoneProxy);
            onKey(events, dom, ['Enter'], onDoneProxy);
        }
    }, {
        key: '_setPosition',
        value: function _setPosition() {
            var parent = this.settings.parent,
                elm = this.domElement;

            if (parent !== elm.parentNode) {
                parent.appendChild(elm);
            }

            this._ifPopup(function (popup) {

                if (getComputedStyle(parent).position === 'static') {
                    parent.style.position = 'relative';
                }

                var cssClass = popup === true ? 'popup_right' : 'popup_' + popup;

                ['popup_top', 'popup_bottom', 'popup_left', 'popup_right'].forEach(function (c) {

                    if (c === cssClass) {
                        elm.classList.add(c);
                    } else {
                        elm.classList.remove(c);
                    }
                });

                elm.classList.add(cssClass);
            });
        }
    }, {
        key: '_setHSLA',
        value: function _setHSLA(h, s, l, a, flags) {
            flags = flags || {};

            var col = this.colour,
                hsla = col.hsla;

            [h, s, l, a].forEach(function (x, i) {
                if (x || x === 0) {
                    hsla[i] = x;
                }
            });
            col.hsla = hsla;

            this._updateUI(flags);

            if (this.onChange && !flags.silent) {
                this.onChange(col);
            }
        }
    }, {
        key: '_updateUI',
        value: function _updateUI(flags) {
            if (!this.domElement) {
                return;
            }
            flags = flags || {};

            var col = this.colour,
                hsl = col.hsla,
                cssHue = 'hsl(' + hsl[0] * HUES + ', 100%, 50%)',
                cssHSL = col.hslString,
                cssHSLA = col.hslaString;

            var uiH = this._domH,
                uiSL = this._domSL,
                uiA = this._domA,
                thumbH = $('.picker_selector', uiH),
                thumbSL = $('.picker_selector', uiSL),
                thumbA = $('.picker_selector', uiA);

            function posX(parent, child, relX) {
                child.style.left = relX * 100 + '%';
            }
            function posY(parent, child, relY) {
                child.style.top = relY * 100 + '%';
            }

            posX(uiH, thumbH, hsl[0]);

            this._domSL.style.backgroundColor = this._domH.style.color = cssHue;

            posX(uiSL, thumbSL, hsl[1]);
            posY(uiSL, thumbSL, 1 - hsl[2]);

            uiSL.style.color = cssHSL;

            posY(uiA, thumbA, 1 - hsl[3]);

            var opaque = cssHSL,
                transp = opaque.replace('hsl', 'hsla').replace(')', ', 0)'),
                bg = 'linear-gradient(' + [opaque, transp] + ')';

            this._domA.style.backgroundImage = bg + ', ' + BG_TRANSP;

            if (!flags.fromEditor) {
                var format = this.settings.editorFormat,
                    alpha = this.settings.alpha;

                var value = void 0;
                switch (format) {
                    case 'rgb':
                        value = col.printRGB(alpha);break;
                    case 'hsl':
                        value = col.printHSL(alpha);break;
                    default:
                        value = col.printHex(alpha);
                }
                this._domEdit.value = value;
            }

            this._domSample.style.color = cssHSLA;
        }
    }, {
        key: '_ifPopup',
        value: function _ifPopup(actionIf, actionElse) {
            if (this.settings.parent && this.settings.popup) {
                actionIf && actionIf(this.settings.popup);
            } else {
                actionElse && actionElse();
            }
        }
    }, {
        key: '_toggleDOM',
        value: function _toggleDOM(toVisible) {
            var dom = this.domElement;
            if (!dom) {
                return false;
            }

            var displayStyle = toVisible ? '' : 'none',
                toggle = dom.style.display !== displayStyle;

            if (toggle) {
                dom.style.display = displayStyle;
            }
            return toggle;
        }
    }], [{
        key: 'StyleElement',
        get: function get$$1() {
            return _style;
        }
    }]);
    return Picker;
}();

/* harmony default export */ __webpack_exports__["default"] = (Picker);


/***/ }),
/* 30 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(6);
module.exports = __webpack_require__(7);


/***/ })
/******/ ]);