/**
 *  CodeMirror
 *
 *  @author    Marijn Haverbeke and others
 *  @copyright Marijn Haverbeke and others
 *  @license   http://codemirror.net/LICENSE
 */

(function(mod) {
  if (typeof exports == "object" && typeof module == "object") // CommonJS
    mod(require("../../lib/codemirror"));
  else if (typeof define == "function" && define.amd) // AMD
    define(["../../lib/codemirror"], mod);
  else // Plain browser env
    mod(CodeMirror);
})(function(CodeMirror) {
"use strict";

// Depends on js-yaml.js from https://github.com/nodeca/js-yaml

// declare global: jsyaml

CodeMirror.registerHelper("lint", "yaml", function(text) {
  var found = [];
  try { jsyaml.load(text); }
  catch(e) {
      var loc = e.mark,
          // js-yaml YAMLException doesn't always provide an accurate lineno
          // e.g., when there are multiple yaml docs
          // ---
          // ---
          // foo:bar
          from = loc ? CodeMirror.Pos(loc.line, loc.column) : CodeMirror.Pos(0, 0),
          to = from;
      found.push({ from: from, to: to, message: e.message });
  }
  return found;
});

});
