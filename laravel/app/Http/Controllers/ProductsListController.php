<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
//tietokantakyselyä varten
use Illuminate\Support\Facades\DB;
//tarvitaan palautusta varten
use Response;

use App\ProductList;
Use App\UserShop;
use App\Product;
use App\Lista;


class ProductsListController extends Controller
{


	/*Oikeasti pitäisi käyttää gate, ShopPolicy, AuthServiceProvider
    /*https://laravel.com/docs/5.1/authorization
    /* Tutkitaan ensin onko käyttäjän tokenissa sama id kuin listan omistajan id
    /* -> ellei ole niin estetään näyttäminen
    /* -> jos on niin näytetään käyttäjän listan tuotteet
	/**/

	public function show(Request $request, $list_id){

        //return an instance of authenticated user and params
        //if(! $request->user()->id or ! $request ->list_id){
		if(! $request->user()->id or ! $list_id){
            return Response::json([
                'error' => [
                    'message' => 'Please Provide All Values'
                ]
            ], 422);
        }


		//otetaan arvot muuttujiin niin on selkeämpää koodia
		$user_id=$request->user()->id;

		//tarkistetaan ensin käyttöoikeus
		//palauttaa listan lista_id:n perusteella + user_id+ shop_id
        $lista = DB::table('listas') 
            ->join('user_shops', function($join) use ($list_id ){
            	$join->on('listas.usershops_id', '=', 'user_shops.id');
            	$join->on(function ($query) use ($list_id) {
            			//$query->where('user_shops.user_id' ,'=', $user_id);
            		$query->where('listas.id' ,'=', $list_id);
            	});
            })
            	//->select('listas.*')
            ->get();

        //jos vastaa tokenista saatuun id:hen voidaan lisätä uusi tuote listaan
        if($user_id == $lista[0]->user_id){


	        //palauttaa listan tuotteet
	        $lista = DB::table('products') 
	            ->join('product_lists', function($join) use ($list_id ){
	            	$join->on('products.id', '=', 'product_lists.product_id');
	            	$join->on(function ($query) use ($list_id) {
	            			//$query->where('user_shops.user_id' ,'=', $user_id);
	            		$query->where('product_lists.list_id' ,'=', $list_id);
	            	});
	            })
	            //täytyy palauttaa myös productlist.id, jotta voidaan poistaa sen perusteella
	            	->select('products.*', 'product_lists.*')
	            ->get();

	            //dd($lista);

	        if(!$lista){
	            return Response::json([
	                'error' => [
	                    'message' => 'List does not exist'
	                ]
	            ], 404);
	        }
	        //palautetaan json muodossa userista saatu data
	        return Response::json([
	     //   	'previous_shop_id'=> $previous,
	     //       'next_shop_id'=> $next,
	                'data' => $lista
	            //     'data' => $shop
	      //      'data' => $this->transform($shop)
	        //    'data' => $this->transformUser($user)
	        ], 200);

	    //ei tämän käyttäjän lista
        }else{
        	return Response::json([
	                    'error' => [
	                        'message' => 'This is not YOUR list!'
	                    ]
	                ], 404);

         }
    }

    	/*
	* Poistaa käyttäjältä kaupan
	* Saa user_shops id:n, tutkii onko tämä käyttäjän, jolla token voimassa
	* Palauttaa virheen tai poistaa
	*/
	//public function destroy($id)
	public function destroy(Request $request, $productlist_id)
    {
    	if(! $request->user()->id or ! $productlist_id ){
            return Response::json([
                'error' => [
                    'message' => 'Please Provide All Values'
                ]
            ], 422);
        }

        //käydään etsimässä productlistin kautta list_id
        $productlist = ProductList::find($productlist_id);
        /*tarkistetaan onko käyttäjällä jo tätä kauppaa*/
        /*$productlist = DB::table('product_lists')->where([
    	['product_id', '=', $request->product_id],
    	['list_id', '=', $request->list_id],
		])->get();*/
        //dd($productlist);
        //jos löytyi jatketaan muuten error
        if ($productlist){
        	$list_id = $productlist->list_id;
        //dd($list_id);
		//otetaan arvot muuttujiin niin on selkeämpää koodia
			$user_id=$request->user()->id;

		//tarkistetaan ensin käyttöoikeus
		//palauttaa listan lista_id:n perusteella + user_id+ shop_id
        	$lista = DB::table('listas') 
            	->join('user_shops', function($join) use ($list_id ){
            		$join->on('listas.usershops_id', '=', 'user_shops.id');
            		$join->on(function ($query) use ($list_id) {
            			//$query->where('user_shops.user_id' ,'=', $user_id);
            			$query->where('listas.id' ,'=', $list_id);
            		});
            	})
            	//->select('listas.*')
            	->get();

        	//jos vastaa tokenista saatuun id:hen voidaan lisätä uusi tuote listaan
        	if($user_id == $lista[0]->user_id){
        	//voidaan poistaa
        		ProductList::destroy($productlist_id);

    		}
        	else{
        	//jos ei löydy vastaavuutta palautetaan error
        		return Response::json([
                	'error' => [
                    	'message' => 'Are you deleting your list ?!'
                	]
            	], 422);
        	
    		}
    	}else{
        	//jos ei löydy productlistille vastaavuutta palautetaan error
        	return Response::json([
                'error' => [
                    'message' => 'Productlist not find ?!'
                ]
            ], 422);
    	}
    }





	/*
    * Tallentaa uuden tuotteen userin tiettyyn listaan
    * Saa tiedon paramsina
    * Tarvitaan token, list_id, product_id, -> listas kautta usershop_id, jota kautta selviää user_id
    * Palauttaa onnistuiko ja datan tai virheen 
    */
    public function store(Request $request)
    {
 
     
    	//return an instance of authenticated user and params
        if(! $request->user()->id or ! $request->product_id or ! $request ->list_id){
            return Response::json([
                'error' => [
                    'message' => 'Please Provide All Values'
                ]
            ], 422);
        }


		//otetaan arvot muuttujiin niin on selkeämpää koodia
		$user_id=$request->user()->id;
		$list_id=$request->list_id;

        //palauttaa listan lista_id:n perusteella + user_id+ shop_id
        $lista = DB::table('listas') 
            ->join('user_shops', function($join) use ($list_id ){
            	$join->on('listas.usershops_id', '=', 'user_shops.id');
            	$join->on(function ($query) use ($list_id) {
            			//$query->where('user_shops.user_id' ,'=', $user_id);
            		$query->where('listas.id' ,'=', $list_id);
            	});
            })
            	//->select('listas.*')
            ->get();

        //jos vastaa tokenista saatuun id:hen voidaan lisätä uusi tuote listaan
        if($user_id == $lista[0]->user_id){

        	$productlist = ProductList::create([
        		'list_id' => $request->list_id,
        		'product_id' => $request->product_id
        	]);
 
        	return Response::json([
                'message' => 'Product added in list Succesfully',
                'data' => $this->transform($productlist)
        	]);

        }
        //muuten erroria
        else{
        	return Response::json([
                'error' => [
                    'message' => 'Are you adding this product the list of somebody else !?'
                ]
            ], 422);
        }
    
	}

	/*
	* Kääntää haluttuun muotoon
	*/
	private function transform($productlist){
    	return [
           'product_id' => $productlist['product_id'],
           'list_id' => $productlist['list_id']
          // 'by' =>$shop['users']['name']
        ];
    }


       
        
    


    ///*JWT-auth*/
	public function __construct(){
        $this->middleware('jwt.auth');
	}
}
