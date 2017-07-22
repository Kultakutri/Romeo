var mod = angular.module('productService', [])

mod.factory('Product', function($http) {

    return {
        // get all product to list, id=list_id
        getAll : function(id, token) {
            //http://localhost:8000/api/shops?token=e
            return $http.get('/api/productlists/'+id+'?token=' + token);
        },
        /*get all producs*/
        get : function(token) {
            return $http.get('/api/products?token='+ token);
        },
        // get product by id
        getOne : function(id, token) {
            //http://localhost:8000/api/shops?token=e
            return $http.get('/api/products/'+id+'?token=' + token);
        },
        //päivitys
        update : function(id, nimi, valmistaja, koko, token) {
            return $http.put('/api/products/id=' + id +'?nimi=' + nimi + '&id=' + id+'&valmistaja=' + valmistaja + '&koko=' + koko+'&token=' + token);
        },

        // save user's shop 
        savelist : function($params, token) {
            return $http({
                method: 'POST',
                url: '/api/productlists?list_id='+$params.list_id+'&product_id='+$params.product_id+'&token=' + token,
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                //data: $.param(shop_id, token)
                data: $params
            });
        },

        // save user's shop 
        save : function($params, token) {
            return $http({
                method: 'POST',
                url: '/api/products?nimi='+$params.nimi+'&valmistaja='+$params.valmistaja+'&koko='+$params.koko+'&token=' + token,
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                //data: $.param(shop_id, token)
                data: $params
            });
        },
       /*destroy product from user's shoplist*/
        destroy : function(productlist_id, token) {
            return $http.delete('/api/productlists/' + productlist_id + '?token=' + token);
        }
    }

});
   