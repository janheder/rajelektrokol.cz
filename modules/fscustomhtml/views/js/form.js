/**
 * Copyright 2022 ModuleFactory
 *
 * @author    ModuleFactory
 * @copyright ModuleFactory all rights reserved.
 * @license   https://www.apache.org/licenses/LICENSE-2.0
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

var FSCH = FSCH || { };
FSCH.helperForm = $({ });

$(document).ready(function(){
    FSCH.helperForm.on('switch_editor', function(event, params){
        if (params.selector && params.editor) {
            FSCH.helperForm.destroyTinyMCE(params);
            FSCH.helperForm.destroyCodemirror(params);
            if (params.editor == 'tinymce') {
                tinySetup({ selector : params.selector });
            } else if (params.editor == 'tinymceadvanced') {
                FSCH.helperForm.tinySetup(params)
            } else if (params.editor == 'codemirror') {
                FSCH.helperForm.codemirrorSetup(params);
            }
        }
    });
});

FSCH.helperForm.codemirrorCompleteAfter = function(cm, pred) {
    var cur = cm.getCursor();
    if (!pred || pred()) setTimeout(function() {
        if (!cm.state.completionActive)
            cm.showHint({completeSingle: false});
    }, 100);
    return CodeMirror.Pass;
};

FSCH.helperForm.codemirrorCompleteIfAfterLt = function(cm) {
    return completeAfter(cm, function() {
        var cur = cm.getCursor();
        return cm.getRange(CodeMirror.Pos(cur.line, cur.ch - 1), cur) == "<";
    });
};

FSCH.helperForm.codemirrorCompleteIfInTag = function(cm) {
    return completeAfter(cm, function() {
        var tok = cm.getTokenAt(cm.getCursor());
        if (tok.type == "string" && (!/['"]/.test(tok.string.charAt(tok.string.length - 1)) || tok.string.length == 1)) return false;
        var inner = CodeMirror.innerMode(cm.getMode(), tok.state).state;
        return inner.tagName;
    });
};

FSCH.helperForm.codemirrorSetup = function(params) {
    $(params.selector).each(function(){
        var editor = CodeMirror.fromTextArea(document.getElementById($(this).attr('id')), {
            lineNumbers: true,
            mode: params.codemirror.mode,
            theme: 'material',
            tabSize: 2,
            viewportMargin: Infinity,
            styleActiveLine: true,
            matchBrackets: true,
            matchTags: {
                bothTags: true
            },
            extraKeys: {
                "'<'": FSCH.helperForm.codemirrorCompleteAfter,
                "'/'": FSCH.helperForm.codemirrorCompleteIfAfterLt,
                "' '": FSCH.helperForm.codemirrorCompleteIfInTag,
                "'='": FSCH.helperForm.codemirrorCompleteIfInTag,
                "Ctrl-Space": "autocomplete"
            }
        });
        $('#'+$(this).attr('id')).data('CodeMirrorInstance', editor);
    });
};

FSCH.helperForm.refreshCodemirror = function() {
    $('.CodeMirror').each(function(i, el){
        el.CodeMirror.refresh();
    });
};

FSCH.helperForm.destroyCodemirror = function(params) {
    $(params.selector).each(function(){
        var editor = $(this).data('CodeMirrorInstance');
        if (editor) {
            $(this).removeAttr('CodeMirrorInstance');
            editor.toTextArea();
            $(this).trigger('autosize.resize');
        }
    });
};

FSCH.helperForm.languageChanged = function() {
    FSCH.helperForm.refreshCodemirror();
};

FSCH.helperForm.changeToMaterial = function() {
    var materialIconAssoc = {
        'mce-i-code': '<i class="material-icons">code</i>',
        'mce-i-visualblocks': '<i class="material-icons">dashboard</i>',
        'mce-i-charmap': '<i class="material-icons">grade</i>',
        'mce-i-hr': '<i class="material-icons">remove</i>',
        'mce-i-searchreplace': '<i class="material-icons">find_replace</i>',
        'mce-i-none': '<i class="material-icons">format_color_text</i>',
        'mce-i-bold': '<i class="material-icons">format_bold</i>',
        'mce-i-italic': '<i class="material-icons">format_italic</i>',
        'mce-i-underline': '<i class="material-icons">format_underlined</i>',
        'mce-i-strikethrough': '<i class="material-icons">format_strikethrough</i>',
        'mce-i-blockquote': '<i class="material-icons">format_quote</i>',
        'mce-i-link': '<i class="material-icons">link</i>',
        'mce-i-alignleft': '<i class="material-icons">format_align_left</i>',
        'mce-i-aligncenter': '<i class="material-icons">format_align_center</i>',
        'mce-i-alignright': '<i class="material-icons">format_align_right</i>',
        'mce-i-alignjustify': '<i class="material-icons">format_align_justify</i>',
        'mce-i-bullist': '<i class="material-icons">format_list_bulleted</i>',
        'mce-i-numlist': '<i class="material-icons">format_list_numbered</i>',
        'mce-i-image': '<i class="material-icons">image</i>',
        'mce-i-table': '<i class="material-icons">grid_on</i>',
        'mce-i-media': '<i class="material-icons">video_library</i>',
        'mce-i-browse': '<i class="material-icons">attachment</i>',
        'mce-i-checkbox': '<i class="mce-ico mce-i-checkbox"></i>',
        'mce-i-template': '<i class="material-icons">assignment</i>',
    };

    $.each(materialIconAssoc, function (index, value) {
        $('.' + index).replaceWith(value);
    });
};

FSCH.helperForm.tinySetup =  function(params) {
    if (typeof tinyMCE === 'undefined') {
        setTimeout(function() {
            FSCH.helperForm.tinySetup(params);
        }, 100);
        return;
    }

    var config = {
        selector: params.selector,
        plugins : "template visualblocks, preview searchreplace print insertdatetime, hr charmap colorpicker anchor code link image paste pagebreak table contextmenu filemanager table code media autoresize textcolor emoticons",
        toolbar2 : "newdocument,print,|,bold,italic,underline,|,strikethrough,superscript,subscript,|,forecolor,colorpicker,backcolor,|,bullist,numlist,outdent,indent",
        toolbar1 : "styleselect,|,formatselect,|,fontselect,|,fontsizeselect,",
        toolbar3 : "code,|,table,|,cut,copy,paste,searchreplace,|,blockquote,|,undo,redo,|,link,unlink,anchor,|,image,emoticons,media,|,inserttime,|,preview ",
        toolbar4 : "visualblocks,|,charmap,|,hr,",
        external_filemanager_path: baseAdminDir + "filemanager/",
        filemanager_title: "File manager",
        external_plugins: {"filemanager": baseAdminDir + "filemanager/plugin.min.js"},
        language: iso_user,
        skin: "prestashop",
        menubar: true,
        statusbar: true,
        relative_urls: false,
        convert_urls: false,
        entity_encoding: "raw",
        extended_valid_elements: "em[class|name|id],@[role|data-*|aria-*]",
        valid_children: "+*[*]",
        valid_elements: "*[*]",
        init_instance_callback: "FSCH.helperForm.changeToMaterial"
    };

    if (params.tinymce.templates_url) {
        config.templates = params.tinymce.templates_url;
        config.toolbar4 = "visualblocks,|,charmap,|,hr,template,";
    }

    // Change icons in popups
    $('body').on('click', '.mce-btn, .mce-open, .mce-menu-item', function () {
        FSCH.helperForm.changeToMaterial();
    });

    tinyMCE.init(config);
};

FSCH.helperForm.destroyTinyMCE = function(params) {
    if (typeof tinyMCE === 'undefined') {
        return;
    }

    $(params.selector).each(function(){
        var helper = tinyMCE.get($(this).attr('id'));
        if (helper) {
            helper.remove();
            $(this).trigger('autosize.resize');
        }
    });
};