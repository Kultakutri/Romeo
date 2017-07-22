var app = angular.module('shopCtrl', ['ngRoute'])

app.config(['$routeProvider', function ($routeProvider) {
        $routeProvider
            .when('/add_shop/:id', {
                templateUrl: 'views/shop.php',
                controller: 'addController'
            })
            .when('/del_shop/:id', {
                templateUrl: 'views/shop.php',
                controller: 'delController'
            })
            .when('/showshop/:id', {
                templateUrl: 'views/shop.php',
                controller: 'shopController'
            });
        
   }]);

/*
* Hakee yhden kaupan tiedot, tarvitsee id ja tokenin jolla varmistaa käyttäjän
*/

app.controller('shopController', function($scope, $location, Auth, Shop, tokenStore, $routeParams) {
   
    //haetaan token
    var token = tokenStore.get();

    $scope.user = tokenStore.getClaimsFromToken();

    Shop.getOne($routeParams.id, token).then(function (serverResponse) {
        $scope.shop = serverResponse.data.data;
                
    }, function (serverResponse) {
            console.error('Toiminto epäonnistui. Serveri palautti ' +
            serverResponse.status + ' ' + serverResponse.statusText);
    });
            
});

/*
* Lisää kaupan käyttäjälle
* Tarvitsee shop_id ja tokenin
* Palauttaa viestin onnistuneestä tai epäonnistuneesta lisäyksestä
*/
app.controller('addController', function AddController($scope, $location, Auth, Shop, tokenStore, notify, $routeParams) {
     //haetaan token
    var token = tokenStore.get();

    //luodaan tarvittavista tiedoista json objekti    
    $params = {
                "shop_id": $routeParams.id,
                "token": token
            };
    // lähettää pyynnön REST-apille käyttäen Shop factorya
    return Shop.save($params).then(function (serverResponse) {
        // notifier lisää viestin näkymään
        //$scope.viesti = serverResponse.data.data;
        notify('Kauppa lisätty omaan listaan', 'success');
        // $scope.$parent viittaa home.menuControllerin scopeen
        $scope.$parent.refresh();
        //$router.path('/');
        $location.path('/');
    }, function (serverResponse) {
         notify('Kaupan lisääminen listaan epäonnistui ' + JSON.stringify(serverResponse.data.error.message) , 'danger');
        /*console.log('Kaupan lisäys epäonnistui'+
        serverResponse.status + ' ' + serverResponse.statusText + ' ' + JSON.stringify(serverResponse.data.error.message));*/
    });
      //  };
        
    });

/*
* Poistaa kaupan käyttäjältä
* Tarvitsee shop_id ja tokenin
* Palauttaa viestin onnistuneestä tai epäonnistuneesta poistosta
*/
app.controller('delController', function DelController($scope, $location, Auth, Shop, tokenStore, notify, $routeParams) {
     //haetaan token
    var token = tokenStore.get();
    // lähettää pyynnön REST-apille käyttäen Shop factorya
    return Shop.destroy($routeParams.id, token).then(function (serverResponse) {
        // notifier lisää viestin näkymään
        notify('Kauppa poistettu omasta listasta', 'success');
        $scope.$parent.refresh();
        $location.path('/');
    }, function (serverResponse) {
         notify('Kaupan poisto listasta epäonnistui ' + JSON.stringify(serverResponse.data.error.message) , 'danger');
    });
      //  };
        
    });


 /**
     * Kontrolleri joka sisältää mahdollisesti
     * yhteisiä toiminnallisuuksia
     */
    app.controller('baseController', function BaseController($scope, $routeParams, shopService) {
        shopService.getOne($routeParams.id).then(function (serverResponse) {
            $scope.shop = serverResponse.data;
        }, function (serverResponse) {
        
            console.error('Toiminto epäonnistui. Serveri palautti ' +
                serverResponse.status + ' ' + serverResponse.statusText);
        });
    });