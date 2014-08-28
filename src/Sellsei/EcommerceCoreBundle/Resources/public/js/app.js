"use strict";
angular.module("sellseiEcommerceApp", ["ngRoute"])
    .config(['$routeProvider', '$interpolateProvider', function ($routeProvider, $interpolateProvider) {
        $routeProvider.when("/", { templateUrl: Routing.generate('sellsei_ecommerce_core_homepage', {}, true) });
        $interpolateProvider.startSymbol('[[');
        $interpolateProvider.endSymbol(']]');
    }])
;