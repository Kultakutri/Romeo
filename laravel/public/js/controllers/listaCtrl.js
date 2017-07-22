var app = angular.module('listaCtrl', ['ngRoute'])

app.config(['$routeProvider', function ($routeProvider) {
        $routeProvider
         
            .when('/del_list/:id', {
                templateUrl: 'views/shop.php',
                controller: 'delListController'
            });   
   }]);

app.controller('listaController', function($scope, $location, Auth, Lista, tokenStore, $routeParams, notify) {
   
    //haetaan token
    var token = tokenStore.get();

    $scope.user = tokenStore.getClaimsFromToken();

    Lista.getAll($routeParams.id, token).then(function (serverResponse) {
        $scope.listas = serverResponse.data.data;
                //console.log("Listan nimi " + $scope.listas{[]});
    }, function (serverResponse) {
        console.error('Toiminto epäonnistui. Serveri palautti ' +
                    serverResponse.status + ' ' + serverResponse.statusText);
    });
     
    $scope.updateItem = function ($list_nimi, $list_id, $listas_id) {
           
    //luodaan tarvittavista tiedoista json objekti    
        $params = {
                "id": $list_id,
                "token": token,
                "nimi": $list_nimi
                };

    // lähettää pyynnön REST-apille käyttäen Shop factorya
        return Lista.update($list_id, $list_nimi, token).then(function (serverResponse) {
            // notifier lisää viestin näkymään
            notify('Listan nimi päivitetty', 'success');
             
            //$router.path('/');
            $location.path('/');
        }, function (serverResponse) {
            notify('Listan nimen päivitys epäonnistui ' + JSON.stringify(serverResponse.data.error.message) , 'danger');
                /*console.log('Kaupan lisäys epäonnistui'+
                serverResponse.status + ' ' + serverResponse.statusText + ' ' + JSON.stringify(serverResponse.data.error.message));*/
        });
    };

});

/*
* Lisää kaupan käyttäjälle
* Tarvitsee shop_id ja tokenin
* Palauttaa viestin onnistuneestä tai epäonnistuneesta lisäyksestä
*/
app.controller('addListController', function AddController($scope, $route, $location, Auth, Lista, tokenStore, notify, $routeParams) {
     //haetaan token
    var token = tokenStore.get();
    $scope.list={nimi: ''};
    $scope.add = function () {
    //luodaan tarvittavista tiedoista json objekti    
    $params = {
                "shop_id": $routeParams.id,
                "token": token,
                "nimi": $scope.list.nimi
            };
    // lähettää pyynnön REST-apille käyttäen Shop factorya
    return Lista.save($params).then(function (serverResponse) {
        // notifier lisää viestin näkymään
        notify('Lista lisätty omaan kauppaan', 'success');
        
        Lista.getAll($routeParams.id, token).then(function (serverResponse) {
            $scope.listas = serverResponse.data.data;
                //console.log("Listan nimi " + $scope.listas{[]});
        }, function (serverResponse) {
                console.error('Toiminto epäonnistui. Serveri palautti ' +
                    serverResponse.status + ' ' + serverResponse.statusText);
        });

        $route.reload();
        $location.path('/showshop/'+ $routeParams.id);
    }, function (serverResponse) {
         notify('Listan lisääminen kauppaan epäonnistui ' + JSON.stringify(serverResponse.data.error.message) , 'danger');
        /*console.log('Kaupan lisäys epäonnistui'+
        serverResponse.status + ' ' + serverResponse.statusText + ' ' + JSON.stringify(serverResponse.data.error.message));*/
    });
  };
        
});

/*
* Päivittää listan käyttäjälle
* Tarvitsee listan id, nimen ja tokenin
* Palauttaa viestin onnistuneestä tai epäonnistuneesta lisäyksestä
*/
app.controller('updateListController', function UpdateListController($scope, $route, $location, Auth, Lista, tokenStore, notify, $routeParams) {
    
    var token = tokenStore.get();
    $scope.list={nimi: ''};
    $scope.updateItem = function () {
    //luodaan tarvittavista tiedoista json objekti    
    $params = {
                "id": $routeParams.id,
                "token": token,
                "nimi": $scope.list.nimi
            };
        console.log("NIMI " + $scope.list.nimi);
    // lähettää pyynnön REST-apille käyttäen Shop factorya
    return Lista.update($params).then(function (serverResponse) {
        // notifier lisää viestin näkymään
        notify('Listan nimi päivitetty', 'success');
        $route.reload();
        //$router.path('/');
        $location.path('/');
    }, function (serverResponse) {
         notify('Listan nimen päivitys epäonnistui ' + JSON.stringify(serverResponse.data.error.message) , 'danger');
        /*console.log('Kaupan lisäys epäonnistui'+
        serverResponse.status + ' ' + serverResponse.statusText + ' ' + JSON.stringify(serverResponse.data.error.message));*/
    });
  };
        
});


/*
* Poistaa kaupan käyttäjältä
* Tarvitsee lista_id ja tokenin
* Palauttaa viestin onnistuneestä tai epäonnistuneesta poistosta
*/
app.controller('delListController', function DelController($scope, $route, $location, Auth, Lista, tokenStore, notify, $routeParams) {
     //haetaan token
    var token = tokenStore.get();
    // lähettää pyynnön REST-apille käyttäen Shop factorya
    return Lista.destroy($routeParams.id, token).then(function (serverResponse) {
        // notifier lisää viestin näkymään
        notify('Lista poistettu omasta kaupasta', 'success');
        //haetaan shop_id, jotta voidaan ohjata oikealle sivulle
        $scope.shop_id = serverResponse.data.data;
        RefreshController.apply(null, [$scope, $routeParams, token, Lista]);
        $route.reload();
        //$state.reload();
        //$router.path('/');

        $location.path('/showshop/'+$scope.shop_id);
    }, function (serverResponse) {
         notify('Listan poisto Kaupasta epäonnistui ' + JSON.stringify(serverResponse.data.error.message) , 'danger');
    });
      //  };
        
});

/*
* Päivittää näkymän
*/

function RefreshController($scope, $routeParams, token, Lista) {
    Lista.getAll($routeParams.id, token).then(function (serverResponse) {
                $scope.listas = serverResponse.data.data;
                //console.log("Listan nimi " + $scope.listas{[]});
            }, function (serverResponse) {
                console.error('Toiminto epäonnistui. Serveri palautti ' +
                    serverResponse.status + ' ' + serverResponse.statusText);
            });
}

 /**
     * Kontrolleri joka sisältää detail-, update-, ja delete-kontrollereille
     * yhteisiä toiminnallisuuksia
     */
    app.controller('baseController', function BaseController($scope, $routeParams, shopService) {
        shopService.getOne($routeParams.id).then(function (serverResponse) {
            $scope.shop = serverResponse.data.data;
        }, function (serverResponse) {
            // console errorin tilalle tulisi jokin notifier kirjasto, joka
            // lisäisi viestin näkymään
            console.error('Toiminto epäonnistui. Serveri palautti ' +
                serverResponse.status + ' ' + serverResponse.statusText);
        });
    });