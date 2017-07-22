(function (settings) {
    'use strict';
    var mod = angular.module('notifier', []);
    //
    // =========================================================================
    mod.service('notifier.messageCollection', ['$timeout', function ($timeout) {
        var messages = [];
        this.getAll = function () {
            return messages;
        };
        this.add = function (content, level) {
            var newMessage = {
                level: level,
                content: content
            };
            if (settings.timeoutDuration) {
                newMessage.timeout = $timeout(
                    this.remove,
                    settings.timeoutDuration
                );
            }
            messages.unshift(newMessage);
        };
        this.remove = function () {
            messages.pop();
        };
        this.dismiss = function (message) {
            $timeout.cancel(message.timeout);
            messages.splice(messages.indexOf(message), 1);
        };
    }]);
    //
    // =========================================================================
    mod.directive('notifier', [
        'notifier.messageCollection',
        function (messageCollection) {
            return angular.extend({
                scope: {},
                restrict: 'EA',
                link: function ($scope, _, $attrs) {
                    // messages rendered in server-side
                    if ($attrs.hasOwnProperty('level') &&
                        $attrs.hasOwnProperty('content')) {
                        messageCollection.add($attrs.level, $attrs.content);
                    }
                    $scope.$watch(messageCollection.getAll, function (messages) {
                        $scope.messages = messages;
                    });
                    $scope.dismiss = messageCollection.dismiss;
                }
            }, settings.directive);
        }
    ]);
    //
    // =========================================================================
    mod.factory('notify', ['notifier.messageCollection', function (mc) {
        // here you go, flash away
        return mc.add.bind(mc);
    }]);
}({
    timeoutDuration: 10000,
    directive: {
        template:
            '<div class="notifier"><div ng-show="messages.length" ng-repeat="message in messages track by $index">' +
                '<div ng-click="dismiss(message)" class="alert-{{message.level}}">' +
                    '{{message.content}}' +
                '</div>' +
            '</div></div>'
    }
}));