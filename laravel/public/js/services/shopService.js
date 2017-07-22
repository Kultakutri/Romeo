var mod = angular.module('shopService', [])

mod.factory('Shop', function($http) {

    return {
        // get all users shop, user_id, token
        getAll : function(id, token) {
            //http://localhost:8000/api/shops?token=e
            return $http.get('/api/shops/'+id+'?token=' + token);
        },
        /*get all shops*/
        get : function(token) {
            return $http.get('/api/shops?token='+ token);
        },
        // get shop by user_id, shop_id, token
        getOne : function(shop_id, token) {
            //http://localhost:8000/api/shops?token=e
            return $http.get('/api/shop/'+shop_id+'?token=' + token);
        },

        // save user's shop 
        save : function($params) {
            return $http({
                method: 'POST',
                url: '/api/usershop?shop_id='+$params.shop_id+'&token=' + $params.token,
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                //data: $.param(shop_id, token)
                data: $params
            });
        },
       // destroy user's shop
        destroy : function(shop_id, token) {
            return $http.delete('/api/usershop/' + shop_id + '?token=' + token);
        }
    }

});
   