/**
 * Created by cshlovjah on 14.04.16.
 */
"use strict";

function createField() {
    var members = new Array('required', 'regexp');
    for(var i = 0; i < arguments.length; i++) {
        this[members[i]] = arguments[i];
    }
}
// absolute regexp
createField.prototype.regexp = /^[A-z0-9-_+. ,@]{1,}$/ig;
createField.prototype.valid = false;
createField.prototype.required = true;
createField.prototype.nullify = function() {
    this.valid = false;
};



