var mod = angular.module('authService', [])

mod.factory('Auth', function($http) {

    return {
        // get user information
        get : function(token) {
            return $http.get('http://localhost:8000/api/authenticate/user?token=' + token);
        },

        //login 
        save : function(authData) {
            return $http({
                method: 'POST',
                url: 'http://localhost:8000/api/authenticate?email='+ authData.email+'&password='+ authData.password,
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                data: $.param(authData)
            })},
        //register
        register : function(authData) {
            return $http({
                method: 'POST',
                url: 'http://localhost:8000/api/register?email='+ authData.email+'&password='+ authData.password,
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                data: $.param(authData)
            })

    }
}

});

/*
* CRUD for token
*/

mod.service('tokenStore', 
    function($window, Auth) {
        /**
         * @param string token
         */
        this.save = function (token) {
            //console.log("TALLENNETAAN TOKEN" + token);
            console.log("tokenstore.save");
            $window.sessionStorage.shopiToken = token;
        };
    /**
         * @return string|undefined
         */
        this.get = function () {
             console.log("tokenstore.get");
            return $window.sessionStorage.shopiToken;
        };
         /* poistaa tokenin
        */
        this.remove = function(){
          console.log("tokenstore.remove");
            $window.sessionStorage.removeItem('shopiToken');
        };

        /**
         * Käy katsomassa back-endissä onko token kelvollinen (ja onko se validi?)
         * Jos token oikeanlainen palautetaan token -> käyttäjä voi jatkaa toimiaan
         * Jos token vääränlainen palautetaan false -> käyttäjä ohjetaan kirjautumis sivustolle
         *
         * @return token tai false
         */
        this.isUserMaybeLoggedIn = function () {
            //haetaan käyttäjän käytössä oleva token
            var token = this.get();
            console.log("token  "+ token)
            //käydään katsomassa toimiiko token back-endissä
            var currentToken=Auth.get(token);
            // console.log("token  "+ currentToken);
        
            if (currentToken === undefined) {
                //console.log("token ei ole voimassa ");
                 return false;
             };
            return token !== undefined && this.getClaimsFromJWT(token) !== false;
        };

        this.getClaimsFromJWT = function(token){
            try {
                //var token = this.get();
                // atob == base64Decode
                return JSON.parse(atob(
                    // [0] == headers, [1] == claims, [2] == signature
                    token.split('.')[1]
                ));
            } catch (e) {
                return false;
            }
        };

    /*TOIMII TOKENIN PURKAJASSA*/
        this.urlBase64Decode = function(str) {
           var output = str.replace('-', '+').replace('_', '/');
           switch (output.length % 4) {
               case 0:
                   break;
               case 2:
                   output += '==';
                   break;
               case 3:
                   output += '=';
                   break;
               default:
                   throw 'Illegal base64url string!';
           }
           return window.atob(output);
       }
/*HAKEE TOKENIN JA PARSII SEN USERIKSI*/
         this.getClaimsFromToken = function () {
           //var token = $localStorage.token;
           var token = this.get();
           var user = {};
           if (typeof token !== 'undefined') {
               var encoded = token.split('.')[1];
               user = JSON.parse(this.urlBase64Decode(encoded));
           }
           return user;
       };

          /*hakee parsitun userin*/
        this.getLoggedUserData = function(){
            //haetaan token jotta tiedetään kuka käyttäjä
            var token = this.get();
            //parsii tokenin saadaan id
            var currentUser = this.getClaimsFromJWT(token);
            console.log("menu "+ currentUser);
            //asetetaan userin arvoksi tokenista saatu id
            return {
                //userId: currentUser.userId, 
               // _id: currentUser.userId,
               // email: currentUser.iss};
               id: currentUser.sub};
            };

    });

