(function(f){if(typeof exports==="object"&&typeof module!=="undefined"){module.exports=f()}else if(typeof define==="function"&&define.amd){define([],f)}else{var g;if(typeof window!=="undefined"){g=window}else if(typeof global!=="undefined"){g=global}else if(typeof self!=="undefined"){g=self}else{g=this}g.Telemetry = f()}})(function(){var define,module,exports;return (function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
    value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var AgreableTelemetryCalendar = function () {
    function AgreableTelemetryCalendar() {
        _classCallCheck(this, AgreableTelemetryCalendar);

        if (!$('body').hasClass('telemetry_page_telemetry-calendar')) {
            return false;
        }

        this.insertDependencies();
    }

    _createClass(AgreableTelemetryCalendar, [{
        key: 'insertDependencies',
        value: function insertDependencies() {
            var fcStyle = document.createElement('link');
            fcStyle.rel = 'stylesheet';
            fcStyle.href = 'https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css';
            var firstStyleTag = document.getElementsByTagName('link')[0];
            firstStyleTag.parentNode.insertBefore(fcStyle, firstStyleTag);

            // add sweet alert to page as it's not an npm package
            $.getScript('https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.2/sweetalert.min.js');
            var saStyle = document.createElement('link');
            saStyle.rel = 'stylesheet';
            saStyle.href = 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css';
            firstStyleTag.parentNode.insertBefore(saStyle, firstStyleTag);

            this.initialize();
        }
    }, {
        key: 'initialize',
        value: function initialize() {
            var _this = this;

            // insert container div
            $('#acf-group_agreable_telemetry_calendar .acf-fields').append($('<div id="calendar" />'));

            // fetch data
            $.ajax({
                url: 'http://local.telemetry.report/api/v1/team/' + telemetry_config.team_id + '/acquisitions?&api_token=' + telemetry_config.token,
                success: function success(data) {
                    _this.initCalendar(data.acquisitions);
                }
            });
        }
    }, {
        key: 'initCalendar',
        value: function initCalendar(data) {
            var _this2 = this;

            $('#calendar').fullCalendar({
                events: data,
                eventClick: function eventClick(calEvent) {
                    _this2.getAcquisitionInformation(calEvent.id);
                }
            });
        }
    }, {
        key: 'getAcquisitionInformation',
        value: function getAcquisitionInformation(id) {
            $.ajax({
                url: 'http://local.telemetry.report/api/v1/acquisitions/' + id + '/promotion/metadata?api_token=' + telemetry_config.token,
                success: function success(data) {
                    sweetAlert({
                        title: '<span style="color:#000">' + data.title + '</span>',
                        text: '<ul style="color:#000;text-align:left;">' + '<li><b>URL:</b> <a href="' + data.url + '">' + data.url + '</a></li>' + '<li><b>Entries:</b> ' + data.totalEntries + '</li>' + (data.corrects ? '<li><b>Correct entries:</b> ' + data.corrects + '</li>' : '') + '<li><b>New subscribers:</b> ' + data.newSubscribers + '</li>' + '</ul>',
                        html: true,
                        type: 'info'
                    });
                }
            });
        }
    }]);

    return AgreableTelemetryCalendar;
}();

exports.default = AgreableTelemetryCalendar;
;

},{}],2:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
    value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var AgreableTelemetryDataExport = function () {
    function AgreableTelemetryDataExport() {
        var _this = this;

        _classCallCheck(this, AgreableTelemetryDataExport);

        var $links = $('#wp-admin-bar-promo-downloads');

        if ($links.length < 1) {
            return false;
        }

        // add sweet alert to page as it's not an npm package
        $.getScript('https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.2/sweetalert.min.js').done(function () {
            $links.on('click', 'a', _this.handleClick.bind(_this));
        });

        var saStyle = document.createElement('link');
        saStyle.rel = 'stylesheet';
        saStyle.href = 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css';
        var firstStyleTag = document.getElementsByTagName('link')[0];
        firstStyleTag.parentNode.insertBefore(saStyle, firstStyleTag);
    }

    _createClass(AgreableTelemetryDataExport, [{
        key: 'handleClick',
        value: function handleClick(e) {
            var _this2 = this;

            e.preventDefault();

            $.ajax({
                url: e.currentTarget.href,
                success: function success(data) {
                    if (data.status === 200) {
                        // show success modal
                        _this2.showSuccessModal(data.data.password);
                    } else {
                        // show error modal
                        _this2.showErrorModal();
                    }
                },
                error: function error(data) {
                    // show error modal
                    _this2.showErrorModal();
                }
            });
        }
    }, {
        key: 'showSuccessModal',
        value: function showSuccessModal(password) {
            sweetAlert({
                title: '<span style="color:#000">Your download request was successful!</span>',
                text: '<p style="color:#000">You\'ll get an email to say it\'s ready. Please make a note of this password as you\'ll need it to open the file:</p><p style="margin-top:20px;color:#000">' + password + '</p>',
                html: true,
                type: 'success'
            });
        }
    }, {
        key: 'showErrorModal',
        value: function showErrorModal() {
            sweetAlert({
                title: '<span style="color:#000">There was a problem with your download request!</span>',
                text: '<span style="color:#000">Something went a bit wrong, but we\'re not sure what. Drop us an email at <a href="mailto:jon.sherrard@shortlist.com">jon.sherrard@shortlist.com</a> and we\'ll take a look into it for you.</span>',
                html: true,
                type: 'warning'
            });
        }
    }]);

    return AgreableTelemetryDataExport;
}();

exports.default = AgreableTelemetryDataExport;
;

},{}],3:[function(require,module,exports){
'use strict';

var _AgreableTelemetryDataExport = require('./AgreableTelemetryDataExport');

var _AgreableTelemetryDataExport2 = _interopRequireDefault(_AgreableTelemetryDataExport);

var _AgreableTelemetryCalendar = require('./AgreableTelemetryCalendar');

var _AgreableTelemetryCalendar2 = _interopRequireDefault(_AgreableTelemetryCalendar);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

window.$ = window.$ || jQuery || window.jQuery;

window.onload = function () {
    var exportPlugin = new _AgreableTelemetryDataExport2.default();

    var acquisitionCalendar = new _AgreableTelemetryCalendar2.default();
};

},{"./AgreableTelemetryCalendar":1,"./AgreableTelemetryDataExport":2}]},{},[3])(3)
});