<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Response;

use App\Shop;
//Use App\UserShop;
use App\User;

class ShopController extends Controller
{
    //
    /*Oikeasti pitäisi käyttää gate, ShopPolicy, AuthServiceProvider
    /*https://laravel.com/docs/5.1/authorization
    /* Tutkitaan ensin onko käyttäjän tokenissa sama id sama kuin parametrinä saatu id
    /* -> ellei ole niin estetään näyttäminen
    /* -> jos on niin näytetään tietynkaupan tiedot
    /**/

    public function show(Request $request, $shop_id){


        //etsitään useri jonka id saatu parametrinä
 /*       $user = User::find($id);
        //jos userin id:tä ei ole olemassa
        if (!$user){
            return Response::json([
                'error' => [
                    'message' => 'User does not even exist... do not try hack me'
                ]
            ], 404);
           
        }
        //jos pyynnöstä saatu id sama kuin tokenin id
        if($request->user()->id == $id){
          //  dd("allowed");
            // kysely välitaulun kautta tietokannasta, näytetään vain yksi kappale
           /* $user = User::with(['shops' => function($query){
               $query->distinct('shop');
            }])->find($id);*/
            //etsitään id:n perusteella shop
            $shop = Shop::find($shop_id);
            //etsitään kaikki tämän userin tähän kauppaan liittyvät listat
            //löytyvät userShop kautta etsimällä shop_id ja user_id ja ottamalla siitä lista_id
            

    /*        if(!$user){
                return Response::json([
                    'error' => [
                        'message' => 'User does not exist'
                    ]
                ], 404);
            }*/
        //palautetaan json muodossa shopista saatu data
        return Response::json([
     //     'previous_shop_id'=> $previous,
     //       'next_shop_id'=> $next,
                'data' => $shop
            //     'data' => $shop
      //      'data' => $this->transform($shop)
        //    'data' => $this->transformUser($user)
        ], 200);

        /* }/*
    //jos tokeista saatu id on eri kuin id apista
       else {
            dd("you don't have permission of that operation");
        }*/

	}

	/*JWT-auth*/
	public function __construct(){
	        $this->middleware('jwt.auth');
	}

}
