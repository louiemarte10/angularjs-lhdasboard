(function () {
    var scriptTag = function (src, callback, async) {
        var doc = document,
            head = document.getElementsByName("head")[0],
            s = doc.createElement('script');

        s.type = 'text/' + (src.type || 'javascript');
        s.src = src.src || src;
        s.async = async || true;

        s.onreadystatechange = s.onload = function () {

            var state = s.readyState;

            if (!state || /loaded|complete/.test(state)) {
                callback(arguments);
            }
        };

        // use body if available. more safe in IE
        (doc.body || head).appendChild(s);
    };

    angular.module("green.script", []).service("loadScriptService", [function () {
            var self = this;
            self.loadScript = function (src, callback, async) {
                scriptTag(src, callback, async)
            };

        }]).directive("loadScript", ["$timeout", "loadScriptService", function ($timeout, loadScriptService) {
            return {
                replace: true,
                restrict: 'AE',
                link: function (scope, elm, iAttrs) {

                    var callBack = scope.$eval(iAttrs.callBack);
                    var async = iAttrs.async === false;

                    iAttrs.$observe("src", function (src) {
                        if (src) {
                            loadScriptService.loadScript(scope.$eval(src), function () {
                                $timeout(function () {
                                    callBack();
                                })
                            }, async);
                        }
                    });

                }
            };
        }]);

})(this);