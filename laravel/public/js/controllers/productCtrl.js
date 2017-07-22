var app = angular.module('productCtrl', ['ngRoute'])

app.config(['$routeProvider', function ($routeProvider) {
        $routeProvider
            .when('/add_product/:id', {
                templateUrl: 'views/product.php',
                controller: 'addProductController'
            })
             .when('/show-products', {
                templateUrl: 'views/product.php',
                controller: 'allProductsController'
             })
            .when('/show-items/:id', {
                templateUrl: 'views/productlist.php',
                controller: 'productsController'
            });
         
   }]);

/*------------------- PRODUCT ----------------------------*/

/*
* Hakee kaikki tuotteet
* Palauttaa json muodossa taulukon
*/

app.controller('allProductsController', function AllProductsController ($scope, $location, Auth, Product, tokenStore, $routeParams) {

   
    //haetaan token
    var token = tokenStore.get();

    $scope.user = tokenStore.getClaimsFromToken();

    Product.get(token).then(function (serverResponse) {
        $scope.items = serverResponse.data.data.data;

    }, function (serverResponse) {
        console.error('Toiminto epäonnistui. Serveri palautti ' +
        erverResponse.status + ' ' + serverResponse.statusText);
    });

});

/*
* Lisää joko uuden tuotteen tai päivittää vanhaa tuotetta
* Tarvitsee shop_id ja tokenin
* Palauttaa viestin onnistuneestä tai epäonnistuneesta lisäyksestä
*/
app.controller('addProductController', function AddProductController($scope, $location, Auth, Product, tokenStore, notify, $routeParams) {
     //haetaan token
    var token = tokenStore.get();
    $scope.user = tokenStore.getClaimsFromToken();

    $scope.reset = function() {
        $scope.item = {};
        $location.path('/show-products');

    }
    $scope.add = function () {
        //console.log("NIMI " + $scope.item.id+ ' ' +$scope.item.nimi + ' ' +$scope.item.koko+ ' ' +$scope.item.valmistaja + '' + token)
        //jos on id niin muokataan tuotetta
        if ($scope.item.id){
        //console.log("PÄIVITETÄÄN TUOTETTA");
             $params = {
                        "id": $scope.item.id,
                        "nimi": $scope.item.nimi,
                        "valmistaja": $scope.item.valmistaja,
                        "koko": $scope.item.koko
                    };

            // lähettää pyynnön REST-apille käyttäen Product factorya
            return Product.update($scope.item.id, $scope.item.nimi, $scope.item.valmistaja, $scope.item.koko, token).then(function (serverResponse) {
                // notifier lisää viestin näkymään
                notify('Tuote päivitetty', 'success');

                $location.path('/');
            }, function (serverResponse) {
                 notify('Tuotteen päivitys epäonnistui ' + JSON.stringify(serverResponse.data.error.message) , 'danger');
            });

        }
        else{
        //luodaan uusi tuote tarvittavista tiedoista json objekti    
        $params = {
                    "nimi": $scope.item.nimi,
                    "koko": $scope.item.koko,
                    "valmistaja": $scope.item.valmistaja
                };
        // lähettää pyynnön REST-apille käyttäen product factorya
        return Product.save($params, token).then(function (serverResponse) {
            // notifier lisää viestin näkymään
            notify('Tuote lisätty', 'success');
        
            $location.path('/');
        }, function (serverResponse) {
             notify('Tuotteen lisääminen listaan epäonnistui ' + JSON.stringify(serverResponse.data.error.message) , 'danger');
            /*console.log('Kaupan lisäys epäonnistui'+
            serverResponse.status + ' ' + serverResponse.statusText + ' ' + JSON.stringify(serverResponse.data.error.message));*/
        });
        }//else loppuu
    }; //add loppuu

    // kutsuu basekontrolleia, joka hakee id:tä vastaavan tuotteen
        // backendiltä ja asettaa sen $scopeen
    BaseController.apply(null, [$scope, $routeParams, token, Product]);
        
    });

 /**
     * Kontrolleri joka voi sisältää yhteisiä toiminnallisuuksia
     * Palauttaa yhden tuotteen
     * Tarvitsee tuote_id ja tokenin, jollei ole tuote_id:tä palaa takaisin
     */
    function BaseController($scope, $routeParams, token, Product) {
        //jos id on tyhjä eli on saavuttu vasta sivulle, eikä ole valittu tuotetta
        if (! $routeParams.id){
            return;
        }
       
        Product.getOne($routeParams.id, token).then(function (serverResponse) {
            $scope.item = serverResponse.data.data;
        }, function (serverResponse) {
            console.error('Toiminto epäonnistui. Serveri palautti ' +
                serverResponse.status + ' ' + serverResponse.statusText);
        });
    };

/*------------------- PRODUCTLIST ----------------------------*/

/*
* Käytetään productlist.php
* Lisää kaikista tuotteista yhden omaan listaan
*/
app.controller('allAddProductsController', function AllAddProductsController ($scope, $route, $location, Auth, Product, tokenStore, $routeParams, notify) {
    
            //haetaan token
        var token = tokenStore.get();

        $scope.user = tokenStore.getClaimsFromToken();

            Product.get(token).then(function (serverResponse) {
                $scope.items = serverResponse.data.data.data;
                
            }, function (serverResponse) {
                console.error('Toiminto epäonnistui. Serveri palautti ' +
                    serverResponse.status + ' ' + serverResponse.statusText);
            });
        
            $scope.addItem = function ($id) {
            
            //luodaan tarvittavista päivitettävistä tiedoista json objekti    
            $params = {
                        "product_id": $id,
                        "token": token,
                        "list_id": $routeParams.id
                       // "shop_id": $routeParams.id
                    };

            // lähettää pyynnön REST-apille käyttäen product factorya
            return Product.savelist($params, token).then(function (serverResponse) {
                // notifier lisää viestin näkymään
                notify('Listaan lisätty tuote', 'success');
                $route.reload();
               
                $location.path('/show-items/'+$routeParams.id);

            }, function (serverResponse) {
                 notify('Tuotteen lisääminen epäonnistui ' + JSON.stringify(serverResponse.data.error.message) , 'danger');
            });
          };
        
});
/*
* Käytetään productlist.php
* Näyttää tuotteet tietystä kaupanlistasta ja poistaa  tuotteen
* Tarvitsee productlist_id, list_id
* Palauttaa tuotelistan ja viestin onnistuiko poisto
*/
app.controller('productsController', function ProductsController ($scope, $location, Auth, Product, tokenStore, $routeParams, notify) {
   
    //haetaan token
    var token = tokenStore.get();

    $scope.user = tokenStore.getClaimsFromToken();

    
    refresh();
    $scope.refresh = refresh;
    //päivitetään myös poiston jälkeen
    function refresh() {
        RefreshController.apply(null, [$scope, $routeParams, token, Product]);
    }
    //poisto
    $scope.delItem = function ($productlist_id, $list_id) {
        //haetaan productlist_id lista_id ja product_id perusteella

            // lähettää pyynnön REST-apille käyttäen product factorya
        return Product.destroy($productlist_id, token).then(function (serverResponse) {
            // notifier lisää viestin näkymään
            notify('Tuote poistettu listasta', 'success');
                   
            refresh();
            //$router.path('/');
            $location.path('/show-items/'+ $list_id);
        }, function (serverResponse) {
            notify('Tuotteen poisto epäonnistui ' + JSON.stringify(serverResponse.data.error.message) , 'danger');
        });
    }

});



/*
* Poistaa listasta tuotteen käyttäjältä
* Tarvitsee productlist_id ja tokenin
* Palauttaa viestin onnistuneestä tai epäonnistuneesta poistosta
*/
app.controller('delProductlistController', function DelProductlistController($scope, $location, Auth, Product, tokenStore, notify, $routeParams) {
     //haetaan token
    var token = tokenStore.get();
    // lähettää pyynnön REST-apille käyttäen Shop factorya
    return Product.destroy($routeParams.id, token).then(function (serverResponse) {
        // notifier lisää viestin näkymään
        notify('Tuote poistettu listasta', 'success');

        //$router.path('/');
        $location.path('#/');
    }, function (serverResponse) {
         notify('Tuotteen poisto epäonnistui ' + JSON.stringify(serverResponse.data.error.message) , 'danger');
    });
      //  };
        
    });

    /*
    * Päivittää näkymän
    */

    function RefreshController($scope, $routeParams, token, Product) {
        Product.getAll($routeParams.id, token).then(function (serverResponse) {
            $scope.items = serverResponse.data.data;
        }, function (serverResponse) {
            console.error('Toiminto epäonnistui. Serveri palautti ' +
                serverResponse.status + ' ' + serverResponse.statusText);
        });

    }
