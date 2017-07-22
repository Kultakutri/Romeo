<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//tietokantakyselyä varten
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use Response;

use App\Shop;
Use App\UserShop;
use App\User;
use App\Lista;

class ListasController extends Controller
{
    /*Etsitään tietyn käyttäjän tietyn kaupan listat.
    * Oikeasti pitäisi käyttää gate, ShopPolicy, AuthServiceProvider
    /*https://laravel.com/docs/5.1/authorization
    /* Front-endissä kauppaa ladattaessa palauttaa kaikki listat
    /* -> ellei ole niin palautetaan tyhjä array, front-end hoitaa loput
    /* -> jos on niin palautetaan lista käyttäjän kaupoista
	/**/

	public function show(Request $request, $shop_id){

        //useria ei löydy tokenista
        if(! $request->user()->id){
                return Response::json([
                    'error' => [
                        'message' => 'User does not exist'
                    ]
                ], 404);
        }
        //haetaan tokenin userin id
        if($request->user()->id){
            $user_id=$request->user()->id;

       
            //etsii tämän userin tämän kaupan listat
            $lista = DB::table('listas')
            	->join('user_shops', function($join) use ($shop_id, $user_id){
            		$join->on('listas.usershops_id', '=', 'user_shops.id');
                    //suodatetaan user_id:n mukaan, koska se vähentää rivien määrää
            		$join->on(function ($query) use ($shop_id, $user_id) {
            			$query->where('user_shops.user_id' ,'=', $user_id);
                    });
                    //lopuksi suodatetaan kaupan mukaan
                    $join->on(function ($query) use ($shop_id, $user_id) {
                        $query->where('user_shops.shop_id' ,'=', $shop_id);
                    });
            	})
            	->select('listas.*')
            	->get();
            
            	//dd($lista);
           
        //palautetaan json muodossa saatu data
        return Response::json([
     //   	'previous_shop_id'=> $previous,
     //       'next_shop_id'=> $next,
                'data' => $lista
            //     'data' => $shop
      //      'data' => $this->transform($shop)
        //    'data' => $this->transformUser($user)
        ], 200);

         }

	}


	 /*
    * Tallentaa uuden listan kaupalle
    * Saa tiedon paramsina, jossa token ja shop_id
    * Palauttaa onnistuiko ja virheen tai datan user_id ja shop_id 
    */
    public function store(Request $request)
    {
 
      	 //dd($request->user()->id);
    	//dd($request->shop_id);
    	//return an instance of authenticated user
        if(! $request->user()->id or ! $request->shop_id){
            return Response::json([
                'error' => [
                    'message' => 'Please Provide Both Shop and User'
                ]
            ], 422);
        }
        /*tarkistetaan onko käyttäjällä jo tätä kauppaa*/
        $usershop = DB::table('user_shops')->where([
    	['shop_id', '=', $request->shop_id],
    	['user_id', '=', $request->user()->id],
		])->get();

		//käydään katsomassa onko käyttäjällä jo tämä kauppa
		//$usershop = $this-> isthisshop($request);

		//dd($usershop[0]->id);

        //jos on niin keskeytetään lisäys
        /*if ($usershop){
        	return Response::json([
                'error' => [
                    'message' => 'You allready have this shop!'
                ]
            ], 422);
        }*/

        //jos on jo kauppa niin lisätään lista
        if($usershop){
        	//luodaan uusi kauppa käyttäjälle
        	$lista = Lista::create([
        	'usershops_id' => $usershop[0]->id,
        	'nimi' => $request->nimi
        	]);
 
        return Response::json([
                'message' => 'Lista Created Succesfully',
                'data' => $this->transform($lista)
        ]);
        }
       
        //luodaan uusi kaupan lista käyttäjälle
        //täytyy lisätä ensin user_shops, jonka jälkeen lisätään loput tiedot listaan
        /*$id = DB::table('user_shops')->insertGetId(
    	['shop_id' => $request->shop_id, 'user_id' => $request->user()->id]
		);*/


		
    }

    private function transform($lista){
    return [
           //'shop_id' => $shop['id'],
           'nimi' => $lista['nimi']
          // 'by' =>$shop['users']['name']
        ];
    }

    /*
    * Listan nimen päivitys
    * Saa parametrinä listan id
    * Palauttaa viestin onnistuneesta tai epäonnistuneesta päivityksestä
    */

    public function update(Request $request)
    {    
        if(! $request->id or ! $request->nimi){
            return Response::json([
                'error' => [
                    'message' => 'Please Provide List'
                ]
            ], 422);
        }
        
        $lista = DB::table('listas')
            ->where('id', $request->id)
            ->update(['nimi' => $request->nimi]);

        //dd($lista);
        //jos onnistui
        if($lista=1){
            return Response::json([
                    'message' => 'Lista Updated Succesfully'
            ]);
        }
        else{
            return Response::json([
                     'error' => [
                    'message' => 'Database error'
                ]
            ], 422);
        }

    }

	/*
	* Poistetaan lista, saa parametrina listan id:n ja tokenin
	* Poistetaan lista tai palautetaan error
	*/
	public function destroy(Request $request, $lista_id)
    {
    	//etsitään lista ja haetaan sieltä usersshops_id, jotta voidaan käydä katsomassa onko tämän käyttäjän
    	$lista = Lista::find($lista_id);

    	if ($lista){

    		//käydäään katsomassa onko tämä lista tämän käyttäjän usershopista
    		$usershop = DB::table('user_shops')
    		->where([
    		['id', '=', $lista->usershops_id],
    		['user_id', '=', $request->user()->id]
			])->get();
		
			//dd($usershop);

			//jos ei löydy vastaavuutta palautetaan error
    	 	if (! $usershop){
        		return Response::json([
                	'error' => [
                    	'message' => 'Are you deleting your list ?!'
                	]
            	], 422);
        	}
        	//muuten deletoidaan
        	else{
                $hop_id=$usershop[0]->shop_id;
        		Lista::destroy($lista_id);
                return Response::json([
                    'message' => 'Lista deleted Succesfully',
                    'data' => $hop_id
                ]);
    		}
    	//listaa ei löytynyt
    	}
    	else{
    		return Response::json([
                	'error' => [
                    	'message' => 'No list ?!'
                	]
            	], 422);
    	}
	
    }

	/*JWT-auth*/
	public function __construct(){
        $this->middleware('jwt.auth');
	}
}
