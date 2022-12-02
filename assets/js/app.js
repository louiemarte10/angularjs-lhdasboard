var app = angular.module('linkedIn', ['ui.router', 'ngRoute', 'ngSanitize', 'angular.filter', 'ngMaterial', 'ngAnimate']);
app.config(['$routeProvider', '$locationProvider', '$controllerProvider',
    function ($routeProvider, $locationProvider, $controllerProvider) {
        app.homeCtrl = $controllerProvider.register;
        $routeProvider.
            // when('/home', {
            //     title: 'home',
            //     templateUrl: 'New folder/index.html'
            //     //controller:'homeCtrl'
            // }).
            when('/debug', {
                title: ' ',
                templateUrl: 'includes/messages/message.php'
                // controller:'homeCtrl'
            }).
            when('/', {
                title: '',
                templateUrl: 'includes/home/home.php',
                onEnter: function () {
                    //write code when you enter that state
                    console.log(window.location);
                },
                onExit: function () {
                    //write code when you exit that state
                }
                // controller:'homeCtrl'
            }).
            when('/page/:pageNo', {
                title: ' ',
                templateUrl: 'includes/home/home.php'
                // controller:'homeCtrl'
            }).
            when('/manage-persona', {
                title: ' ',
                templateUrl: 'includes/home/home.php'
                // controller:'homeCtrl'
            }).
            when('/reports', {
                title: ' ',
                templateUrl: 'includes/reports/index.php'
                // controller:'homeCtrl'
            }).
            when('/contacts/:personaId', {
                title: ' ',
                templateUrl: 'includes/contacts/index.php'
                // controller:'homeCtrl'
            }).
            when('/messages/:personaId', {
                title: ' ',
                templateUrl: 'includes/messages/index.php'
                // controller:'homeCtrl'
            }).
            when('/logout', {
                title: ' ',
                templateUrl: 'includes/internal/logout.php'
                // controller:'homeCtrl'
            }).
            otherwise({
                redirect: "/home"
            })

        $locationProvider.hashPrefix('');
        $locationProvider.html5Mode({
            enabled: true,
            requireBase: true
        });




    }]);
app.filter('pagination', function () {
    return function (input, start) {
        start = +start;
        if (typeof input !== "undefined" && input.length > 0) {
            return input.slice(start);
        }
        // 


    };
});
app.filter('highlight', function ($sce) {
    return function (text, phrase) {
        if (phrase) text = text.replace(new RegExp('(' + phrase + ')', 'gi'),
            '<span class="highlighted">$1</span>')

        return $sce.trustAsHtml(text)
    }
});
app.directive('ngCustomChange', function ($parse) {
    return function (scope, element, attrs) {
        var fn = $parse(attrs.ngCustomChange);
        element.bind('change', function (event) {
            scope.$apply(function () {
                event.preventDefault();
                fn(scope, { $event: event });
            });
        });
    };
});
app.factory('data', ['$rootScope', '$http', '$q', '$log',
    function ($rootScope, $http, $q, $log) {
        return {
            getData: function (method, url, payload) {
                var datatype = (method === "JSONP") ? "jsonp" : "json";
                var defer = $q.defer();
                $http({
                    method: method,
                    url: url,
                    dataType: datatype,
                    data: payload || {}
                }).then(function (response) {
                    defer.resolve(response.data);
                }, function (response) {
                    defer.reject(response);
                });
                // $http.get('xyz.com/abc.php', { cache: 'true' })
                //     .success(function (data) {
                //         defer.resolve(data);
                //     });

                return defer.promise;
            }
        };
    }]);
app.directive('script', function () {
    return {
        restrict: 'E',
        scope: false,
        link: function (scope, elem, attr) {
            if (attr.type === 'text/javascript-lazy') {
                var code = elem.text();
                var f = new Function(code);
                f();
            }
        }
    };
});
app.filter('startFrom', function () {
    return function (input, start) {
        start = +start; //parse to int
        return input.slice(start);
    }
});
app.filter('searchFilter', function ($filter) {
    return function (items, searchfilter) {
        var isSearchFilterEmpty = true;
        angular.forEach(searchfilter, function (searchstring) {
            if (searchstring != null && searchstring != "") {
                isSearchFilterEmpty = false;
            }
        });
        if (!isSearchFilterEmpty) {
            var result = [];
            angular.forEach(items, function (item) {
                var isFound = false;
                angular.forEach(item, function (term, key) {
                    if (term != null && !isFound) {
                        term = term.toString();
                        term = term.toLowerCase();
                        angular.forEach(searchfilter, function (searchstring) {
                            searchstring = searchstring.toLowerCase();
                            if (searchstring != "" && term.indexOf(searchstring) != -1 && !isFound) {
                                result.push(item);
                                isFound = true;
                            }
                        });
                    }
                });
            });
            return result;
        } else {
            return items;
        }
    }
});
app.directive('dateInput', function () {
    return {
        restrict: 'A',
        scope: {
            ngModel: '='
        },
        link: function (scope) {
            if (scope.ngModel) scope.ngModel = new Date(scope.ngModel);
        }
    }
});
app.directive('numericOnly', function () {
    return {
        require: 'ngModel',
        link: function (scope, element, attrs, modelCtrl) {

            modelCtrl.$parsers.push(function (inputValue) {
                var transformedInput = inputValue ? inputValue.replace(/[^0-9]/g, '') : null;

                if (transformedInput != inputValue) {
                    modelCtrl.$setViewValue(transformedInput);
                    modelCtrl.$render();
                }

                return transformedInput;
            });
        }
    };
});
app.directive('ngImageCompress', ['$q',
    function ($q) {


        var URL = window.URL || window.webkitURL;

        var getResizeArea = function () {
            var resizeAreaId = 'fileupload-resize-area';

            var resizeArea = document.getElementById(resizeAreaId);

            if (!resizeArea) {
                resizeArea = document.createElement('canvas');
                resizeArea.id = resizeAreaId;
                resizeArea.style.visibility = 'hidden';
                document.body.appendChild(resizeArea);
            }

            return resizeArea;
        };

        /**
         * Receives an Image Object (can be JPG OR PNG) and returns a new Image Object compressed
         * @param {Image} sourceImgObj The source Image Object
         * @param {Integer} quality The output quality of Image Object
         * @return {Image} result_image_obj The compressed Image Object
         */

        var jicCompress = function (sourceImgObj, options) {
            var outputFormat = options.resizeType;
            var quality = options.resizeQuality * 100 || 70;
            var mimeType = 'image/jpeg';
            if (outputFormat !== undefined && outputFormat === 'png') {
                mimeType = 'image/png';
            }


            var maxHeight = options.resizeMaxHeight || 300;
            var maxWidth = options.resizeMaxWidth || 250;

            var height = sourceImgObj.height;
            var width = sourceImgObj.width;

            // calculate the width and height, constraining the proportions
            if (width > height) {
                if (width > maxWidth) {
                    height = Math.round(height *= maxWidth / width);
                    width = maxWidth;
                }
            }
            else {
                if (height > maxHeight) {
                    width = Math.round(width *= maxHeight / height);
                    height = maxHeight;
                }
            }

            var cvs = document.createElement('canvas');
            cvs.width = width; //sourceImgObj.naturalWidth;
            cvs.height = height; //sourceImgObj.naturalHeight;
            var ctx = cvs.getContext('2d').drawImage(sourceImgObj, 0, 0, width, height);
            var newImageData = cvs.toDataURL(mimeType, quality / 100);
            var resultImageObj = new Image();
            resultImageObj.src = newImageData;
            return resultImageObj.src;

        };

        var resizeImage = function (origImage, options) {
            var maxHeight = options.resizeMaxHeight || 300;
            var maxWidth = options.resizeMaxWidth || 250;
            var quality = options.resizeQuality || 0.7;
            var type = options.resizeType || 'image/jpg';

            var canvas = getResizeArea();

            var height = origImage.height;
            var width = origImage.width;

            // calculate the width and height, constraining the proportions
            if (width > height) {
                if (width > maxWidth) {
                    height = Math.round(height *= maxWidth / width);
                    width = maxWidth;
                }
            }
            else {
                if (height > maxHeight) {
                    width = Math.round(width *= maxHeight / height);
                    height = maxHeight;
                }
            }

            canvas.width = width;
            canvas.height = height;

            //draw image on canvas
            var ctx = canvas.getContext('2d');
            ctx.drawImage(origImage, 0, 0, width, height);

            // get the data from canvas as 70% jpg (or specified type).
            return canvas.toDataURL(type, quality);
        };

        var createImage = function (url, callback) {
            var image = new Image();
            image.onload = function () {
                callback(image);
            };
            image.src = url;
        };

        var fileToDataURL = function (file) {
            var deferred = $q.defer();
            var reader = new FileReader();
            reader.onload = function (e) {
                deferred.resolve(e.target.result);
            };
            reader.readAsDataURL(file);
            return deferred.promise;
        };


        return {
            restrict: 'A',
            scope: {
                image: '=',
                resizeMaxHeight: '@?',
                resizeMaxWidth: '@?',
                resizeQuality: '@?',
                resizeType: '@?'
            },
            link: function postLink(scope, element, attrs) {

                var doResizing = function (imageResult, callback) {
                    createImage(imageResult.url, function (image) {
                        //var dataURL = resizeImage(image, scope);
                        var dataURLcompressed = jicCompress(image, scope);
                        // imageResult.resized = {
                        //  dataURL: dataURL,
                        //  type: dataURL.match(/:(.+\/.+);/)[1]
                        // };
                        imageResult.compressed = {
                            dataURL: dataURLcompressed,
                            type: dataURLcompressed.match(/:(.+\/.+);/)[1]
                        };
                        callback(imageResult);
                    });
                };

                var applyScope = function (imageResult) {
                    scope.$apply(function () {
                        //console.log(imageResult);
                        if (attrs.multiple) {
                            scope.image.push(imageResult);
                        }
                        else {
                            scope.image = imageResult;
                        }
                    });
                };


                element.bind('change', function (evt) {
                    //when multiple always return an array of images
                    if (attrs.multiple) { scope.image = []; }

                    var files = evt.target.files;
                    for (var i = 0; i < files.length; i++) {
                        //create a result object for each file in files
                        var imageResult = {
                            file: files[i],
                            url: URL.createObjectURL(files[i])
                        };

                        fileToDataURL(files[i]).then(function (dataURL) {
                            imageResult.dataURL = dataURL;
                        });

                        if (scope.resizeMaxHeight || scope.resizeMaxWidth) { //resize image
                            doResizing(imageResult, function (imageResult) {
                                applyScope(imageResult);
                            });
                        }
                        else { //no resizing
                            applyScope(imageResult);
                        }
                    }
                });
            }
        };
    }
]);
app.directive('hmAutocomplete', function ($timeout) {
    return {
        scope: {
            selectedIndex: '=',
            hmSuggestions: '=',
            hmDropdownid: '@',
            hmSelect: '&'
        },

        link: function (scope, element) {

            scope.selectedIndex = 0;

            var elem = angular.element(document.getElementById('autotext'));
            var list = angular.element(document.getElementById(scope.hmDropdownid));

            list.css('display', 'none');

            // elem.bind('focus', function () {
            //     scope.selectedIndex = 0;
            //     scope.$apply();
            //     list.css('display', 'block');
            // });

            // elem.bind('blur', function () {
            //     $timeout(
            //         function () {
            //             list.css('display', 'none');
            //         }, 100
            //     )
            // });

            elem.bind("keydown", function (event) {


                if (list.css('display') === 'none') {
                    list.css('display', 'block');
                }

                if (event.keyCode === 40) { //down key, increment selectedIndex
                    event.preventDefault();
                    if (scope.selectedIndex + 1 === scope.hmSuggestions.length) {
                        scope.selectedIndex = 0;
                    } else {
                        scope.selectedIndex++;
                    }
                    scope.$apply();
                } else if (event.keyCode === 38) { //up key, decrement selectedIndex
                    event.preventDefault();

                    if (scope.selectedIndex === 0) {
                        scope.selectedIndex = scope.hmSuggestions.length - 1;
                    } else {
                        scope.selectedIndex--;
                    }
                    scope.$apply();

                } else if (event.keyCode === 13 || event.keyCode === 9) { //enter pressed or tab

                    elem.val(scope.hmSuggestions[scope.selectedIndex].Name);
                    list.css('display', 'none');
                    scope.hmSelect(scope.hmSuggestions[scope.selectedIndex]);
                    scope.$apply();

                } else if (event.keyCode === 27) {
                    list.css('display', 'none');
                }
            });

        }
    };
});
app.directive('hoverClass', function () {
    return {
        restrict: 'A',
        link: function (scope, element, attr) {

            element.on('mouseenter', function () {
                angular.element(document.getElementsByClassName(attr.hoverClass)).removeClass(attr.hoverClass);
                element.addClass(attr.hoverClass);
            });

            element.on('mouseleave', function () {
                element.removeClass(attr.hoverClass);
            });

        }
    };
})

app.directive('hmSelectDown', function () {
    return {
        restrict: 'A',
        scope: {
            hmSelectDown: '&'
        },
        link: function (scope, elem, attr) {
            var list = angular.element(document.getElementById(scope.hmDropdownid));
            elem.bind('click', function () {
                scope.hmSelectDown();
                // list.css('display', 'none');
            });
        }
    };
})

app.filter('highlight', function ($sce) {
    return function (text, phrase) {
        if (phrase)
            text = text.replace(new RegExp('(' + phrase + ')', 'gi'), '<span class="highlighted">$1</span>');
        return $sce.trustAsHtml(text);
    }
})
app.controller('demo', function ($scope) {

    $scope.items = [{
        'Name': 'India'
    }, { 'Name': 'United States' },
    { 'Name': 'England' },
    { 'Name': 'Germany' },
    { 'Name': 'London' }, {
        'Name': 'Pakistan'
    }, {
        'Name': 'Nepal'
    }, {
        'Name': 'Bangladesh'
    }];
    $scope.onselect = function (obj) {
        console.log(obj);
    }

});



