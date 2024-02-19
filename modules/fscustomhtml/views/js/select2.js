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
FSCH.select2 = $({ });

FSCH.select2.escapeMarkup = function(json_string) {
    var entity_map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#39;',
        '/': '&#x2F;',
        '`': '&#x60;',
        '=': '&#x3D;'
    };

    return String(json_string).replace(/[&<>"'`=\/]/g, function (s) {
        return entity_map[s];
    });
};

FSCH.select2.markMatch = function(text, term) {
    var markup=[];
    var match = -1;

    do {
        match = text.toUpperCase().indexOf(term.toUpperCase());
        if (match > -1) {
            markup.push(FSCH.select2.escapeMarkup(text.substring(0, match)));
            markup.push("<span class='select2-match'>");
            markup.push(FSCH.select2.escapeMarkup(text.substring(match, match+term.length)));
            markup.push("</span>");
            text = text.substring(match+term.length, text.length);
        }
    } while (match > -1 && term.length > 0);

    markup.push(FSCH.select2.escapeMarkup(text));
    return markup.join('');
};