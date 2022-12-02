  
 // var app = angular.module("myapp",[]);  
 // app.controller("usercontroller", function($scope, $http){  
   
 //      $scope.displayData = function(){  
 //           $http.get("query.php").success(function(data){  
 //                $scope.names = data;  
 //           });  

 //           alert('test3');
 //      }  
 // });  
 

var app = angular.module('myApp', []);

app.controller('myController', function($scope, $http){
  $scope.fetchData = function(){
  $http.get('query.php').success(function(data){
   $scope.field = data;
  });
 } 
});  