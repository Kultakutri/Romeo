var mod = angular.module('listaService', [])

mod.factory('Lista', function($http) {

    return {
        // get all users this shop's lists, params: shop_id, token
        getAll : function(id, token) {
           //http://localhost:8000/api/listas/3?token=
            return $http.get('/api/listas/'+id+'?token=' + token);
        },
      
         update : function(id, nimi, token) {
            return $http.put('/api/listas/id=' + id +'?nimi=' + nimi + '&id=' + id +'&token=' + token);
        },

        // save shop's list
        //http://localhost:8000//api/listas?shop_id=3&token=
        save : function($params) {
            return $http({
                method: 'POST',
                url: '/api/listas?shop_id='+$params.shop_id+'&nimi='+$params.nimi+'&token=' + $params.token,
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                //data: $.param(shop_id, token)
                data: $params
            });
        },
       // destroy user's shop
       //http://localhost:8000/api/listas/3?token=
        destroy : function(lista_id, token) {
            return $http.delete('/api/listas/' + lista_id + '?token=' + token);
        }
    }

});
   