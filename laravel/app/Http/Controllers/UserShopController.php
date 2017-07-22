<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\Http\Requests;
use Response;


use App\Shop;
Use App\UserShop;
use App\User;

class UserShopController extends Controller
{

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return "usershop index";
    }

    /*
    * Tallentaa uuden kaupan userille
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
        
        /*tarkistetaan onko käyttäjällä jo tätä kauppaa
        $usershop = DB::table('user_shops')->where([
    	['shop_id', '=', $request->shop_id],
    	['user_id', '=', $request->user()->id],
		])->get();*/

		//käydään katsomassa onko käyttäjällä jo tämä kauppa
		$usershop = $this-> isthisshop($request);

        //jos on niin keskeytetään lisäys
        if ($usershop){
        	return Response::json([
                'error' => [
                    'message' => 'You allready have this shop!'
                ]
            ], 422);
        }
       
        //luodaan uusi kauppa käyttäjälle
        $usershop = UserShop::create([
        	'shop_id' => $request->shop_id,
        	'user_id' => $request->user()->id
        	]);
 
        return Response::json([
                'message' => 'Shop Created Succesfully',
                'data' => $this->transform($usershop)
        ]);
    }

    /*
    * Käy katsomassa kannassa vastaako joku arvo annettua paria user_id ja shop_id
    * Palauttaa objektin kokonaisuudessaan
    */
    private function isthisshop(Request $request){
    	 $usershop = DB::table('user_shops')->where([
    	['shop_id', '=', $request->shop_id],
    	['user_id', '=', $request->user()->id],
		])->get();
    	// return $usershop;
    /*return [
           'shop_id' => $usershop['shop_id'],
           'user_id' => $usershop['user_id'],
           'id' => $usershop['id']
        ];*/
	}

    /*
    * Kääntää tiedon haluttuun muotoon ja palauttaa sen
    */
    private function transform($usershop){
    return [
           'shop_id' => $usershop['shop_id'],
           'user_id' => $usershop['user_id'],
           'id' => $usershop['id']
        ];
	}

	/*
	* Poistaa käyttäjältä kaupan
	* Saa user_shops id:n, tutkii onko tämä käyttäjän, jolla token voimassa
	* Palauttaa virheen tai poistaa
	*/
	//public function destroy($id)
	public function destroy(Request $request, $shop_id)
    {
    	//tutkii onko tämä tämä käyttäjän ja kaupan id
    	/*$usershop = DB::table('user_shops')
    	->where([
    	['shop_id', '=', $request->shop_id],
    	['user_id', '=', $request->user()->id]
		])->get();*/
		$usershop = DB::table('user_shops')
    	->where([
    	['shop_id', '=', $shop_id],
    	['user_id', '=', $request->user()->id]
		])->get();

		//dd($usershop[0]->id);

		//käydään katsomassa onko käyttäjällä tämä kauppa
		//$usershop = $this-> isthisshop($request);

    	//jos ei löydy vastaavuutta palautetaan error
    	 if (! $usershop){
        	return Response::json([
                'error' => [
                    'message' => 'Are you deleting your shop ?!'
                ]
            ], 422);
        }
        else{
        	//muuten poistetaan
        	//dd ($usershop[0]->id);
        	//$usershop->destroy($usershop[0]->id);
        //	dd($id);
        	//$id = $usershop->id;
        	UserShop::destroy($usershop[0]->id);
    	}
    }

    /*JWT-auth*/
	public function __construct(){
        $this->middleware('jwt.auth');
	}
}

