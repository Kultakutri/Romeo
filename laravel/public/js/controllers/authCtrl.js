var app = angular.module('authCtrl', ['ngRoute']);

app.config(['$routeProvider', function ($routeProvider) {
        $routeProvider
             .when('/signin', {
                templateUrl: 'views/auth.php',
                controller: 'loginController'
            })
            .otherwise({
                redirectTo: '/'
             });
   }]);

/*
* Kirjautumissivu. 
* Käy luomassa RESTin avulla backendissä tokenin
* Ohjaa käyttäjän home-sivulle loginfunctioncontrollerin avulla.
*/

// inject the Auth service into our controller
app.controller('loginController', function($scope, $location, Auth, tokenStore, notify) {
    
    $scope.auth={email: ''};
    $scope.login = function () {
         LoginfunctionController.apply(null, [$scope, $location, Auth,tokenStore, notify]);
    }
    $scope.register = function () {
        // if user and password ok, then we get JWT-token
        Auth.register($scope.auth).then(function (serverResponse) {
            $scope.viesti = serverResponse.data.message;
            notify('Rekisteröinti onnistui', 'success');
            console.log("Rekisteröinti: " +$scope.viesti +serverResponse.status + ' ' + serverResponse.statusText);
            LoginfunctionController.apply(null, [$scope, $location, Auth, tokenStore, notify]);
        }, function (serverResponse) {
            console.error('Toiminto epäonnistui. Serveri palautti ' +
            serverResponse.status + ' ' + serverResponse.statusText);
            notify('Rekiströinti epäonnistui ' , 'danger');
        });
    }
});

/*
* Kirjautuminen, käytetään useasti, vaatii emailin ja password
* Palauttaa tokenin jos onnistui
*/
function LoginfunctionController($scope, $location, Auth, tokenStore, notify) {
    Auth.save($scope.auth).then(function (serverResponse) {
               // $scope.viesti = serverResponse.data.message;
                var token = JSON.stringify(serverResponse.data.token);
                //save token 
                tokenStore.save(token);
               // notify('Kirjautuminen onnistui', 'success');
                $scope.$parent.refresh();
                $location.path('/');
               
                //console.log("Listan nimi " + $scope.listas{[]});
            }, function (serverResponse) {
                console.error('Toiminto epäonnistui. Serveri palautti ' +
                    serverResponse.status + ' ' + serverResponse.statusText);
                 notify('Kirjautuminen epäonnistui ' , 'danger');
            });
}
