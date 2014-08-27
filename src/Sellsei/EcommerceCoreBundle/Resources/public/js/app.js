"use strict";
angular.module("sellseiEcommerceApp", ["ngRoute"])
.config(['$routeProvider', '$interpolateProvider', function ($routeProvider, $interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
}])
;