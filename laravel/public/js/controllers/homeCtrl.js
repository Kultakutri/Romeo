var app = angular.module('homeCtrl', ['ngRoute'])

app.config(['$routeProvider', function ($routeProvider) {
        $routeProvider
             .when('/', {
                templateUrl: 'views/home.php',
                controller: 'menuController'
            });
        
   }]);

app.controller('menuController', function($scope, $location, Auth, Shop, tokenStore, $anchorScroll) {
        
        //refresh();
        $scope.refresh = refresh;
        // Onko käyttäjä kirjautunut, ja päivittää $scope:n
        function refresh() {
            $scope.userMaybeLoggedIn = tokenStore.isUserMaybeLoggedIn();
            if (!$scope.userMaybeLoggedIn) {
                return false;
            }
            else{
        
            //haetaan token
            var token = tokenStore.get();
            $scope.shop={id: '', shop:''};

            $scope.user = tokenStore.getClaimsFromToken();
           
            Shop.getAll($scope.user.sub, token).then(function (serverResponse) {
                $scope.shops = serverResponse.data.data.shops;

                //jos valitaan joku valikosta
                $scope.scrollToName = function(value){
                    $scope.shop.id=value;
                    if (value==null){ 
                        $location.path('/');
                    }
                    else{
                      $location.path('/showshop/' + $scope.shop.id);   
                    }
                    //refresh();
                    //$anchorScroll();
                    //nollaa valikon
                 
                };

            }, function (serverResponse) {
                console.error('Toiminto epäonnistui. Serveri palautti ' +
                    serverResponse.status + ' ' + serverResponse.statusText);
                    if (serverResponse.status === 401) {
                        temporaryLogoutFn();
                    }
            });

        }
    }
        $scope.temporaryLogoutFn = temporaryLogoutFn;
         function temporaryLogoutFn() {
       // $scope.temporaryLogoutFn = function () {
            tokenStore.remove();
            refresh();
            $location.path('/signin');
    }
});

/*
* Palauttaa kaikki kaupat
* Tarvitsee tokenin, josta selvittää käyttäjän
*/

app.controller('shopsController', function($scope, $route, $location, Auth, Shop, tokenStore) {
    
    //haetaan token
    var token = tokenStore.get();

    if (! token){
       // $scope.$parent.temporaryLogoutFn();
        tokenStore.remove();
        $route.reload();
        $location.path('/signin');
    }else{

    //palauttaa kaikki kaupat
    Shop.get(token).then(function (serverResponse) {
        $scope.shops = serverResponse.data.data.data;
    }, function (serverResponse) {
        console.error('Toiminto epäonnistui. Serveri palautti ' +
        serverResponse.status + ' ' + serverResponse.statusText);
    });
    }
           
});