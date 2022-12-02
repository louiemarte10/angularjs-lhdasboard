var app = angular.module('linkedIn', ['ngRoute']);
var ctrlProvider;
app.config(function ($routeProvider, $locationProvider, $controllerProvider,$compileProvider) {
	// app.homeCtrl =  $controllerProvider.register;
	app.homeCtrl = $controllerProvider.register,
	$compileProvider.debugInfoEnabled(false);
	// ctrlProvider = $controllerProvider;
	$routeProvider
		.when("/", {
			templateUrl: 'includes/home/home.php'
		})
		.when("/messages", {
			templateUrl: 'includes/reports/index.html'

		})
		.otherwise({ redirectTo: '/' });

	//html5Mode don't need /app/#/ anymore, just /app/
	// $locationProvider.html5Mode(true).hashPrefix('!'); //the hashPrefix is for SEO
	$locationProvider.hashPrefix('');
	$locationProvider.html5Mode(true);


});

