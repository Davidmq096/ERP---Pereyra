// For vendors for example jQuery, Lodash, angular2-jwt just import them here unless you plan on
// chunking vendors files for async loading. You would need to import the async loaded vendors
// at the entry point of the async loaded file. Also see custom-typings.d.ts as you also need to
// run `typings install x` where `x` is your module

// Angular 2
import '@angular/platform-browser';
import '@angular/platform-browser-dynamic';
import '@angular/core';
import '@angular/common';
import '@angular/forms';
import '@angular/http';
import '@angular/router';
import '@angularclass/hmr';

// RxJS
import 'rxjs/add/operator/map';
import 'rxjs/add/operator/mergeMap';

import 'jquery';
import 'tether';
import 'bootstrap';
import 'widgster';
import 'bootstrap-select';
import 'select2';
import 'pace';

import 'jquery-sparkline';
import 'jszip';
import 'messenger/build/js/messenger.js';
import "assets/fileinput/fileinput.min.js"
import "assets/datapicker/bootstrap-material-datetimepicker.js";
import "assets/Semantic/semantic.js";


import "../node_modules/datatables.net/js/jquery.dataTables.js";
import "../node_modules/datatables.net-buttons/js/dataTables.buttons.js";
import "../node_modules/datatables.net-buttons/js/buttons.html5.js";
import "../node_modules/datatables.net-buttons/js/buttons.flash.js";
import "../node_modules/datatables.net-buttons/js/buttons.print.js";

if ('production' === ENV) {
    // Production


} else {
    // Development

}
