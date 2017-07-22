<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Response;

use App\Product;

//tietokantakyselyä varten
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
     /*Palauttaa kaikki tuotteet
    *
    *
    */
    public function index(Request $request){
    	
    	$products = Product::all();
        return Response::json([
                'data' => $this->transformCollection($products)
        ], 200);

    }

    /*
    * Etsitään tietty tuote
    * Tarvitaan tuotteen id
    * Palautetaan tuote
    */

	public function show(Request $request, $id){

        //etsitään useri jonka id saatu parametrinä
        $product = Product::find($id);

        if($product){
	        return Response::json([
	               'data' => $this->transform($product)
	        ], 200);
        }
        else{
            return Response::json([
                'error' => [
                    'message' => 'Tuotetta ei löytynyt'
                ]
            ], 422);
        }
        

	}
	/*
	* Tallentaa tuotteen
	* Tarvitsee nimi, koko, valmistaja
	* Palauttaa tuotten
	* kuka tahansa voi tallentaa
	*/
	public function store(Request $request)
    {
 
        if(! $request->nimi or ! $request->valmistaja or ! $request->koko){
            return Response::json([
                'error' => [
                    'message' => 'Please Provide Product'
                ]
            ], 422);
        }
        $product = Product::create($request->all());
 
        return Response::json([
                'message' => 'Product Created Succesfully',
                'data' => $this->transform($product)
        ]);
    }

     /*
    * Tuotteen päivitys
    * Saa parametrinä listan id
    * Palauttaa viestin onnistuneesta tai epäonnistuneesta päivityksestä
    */

    public function update(Request $request)
    {    
    	
        if(! $request->id){
            return Response::json([
                'error' => [
                    'message' => 'Please Provide Product'
                ]
            ], 422);
        }
        
        $product = DB::table('products')
            ->where('id', $request->id)
            ->update([
            	'nimi' => $request->nimi,
            	'koko' => $request->koko,
            	'valmistaja' => $request->valmistaja
            	]);

        //dd($lista);
        //jos onnistui
        if($product=1){
            return Response::json([
                    'message' => 'Product Updated Succesfully'
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


   private function transformCollection($products){
  //  return array_map([$this, 'transform'], $shops->toArray());
    $productsArray = $products->toArray();
        return [
           /* 'total' => $shopsArray['total'],
            'per_page' => intval($shopsArray['per_page']),
            'current_page' => $shopsArray['current_page'],
            'last_page' => $shopsArray['last_page'],
            'next_page_url' => $shopsArray['next_page_url'],
            'prev_page_url' => $shopsArray['prev_page_url'],
            'from' => $shopsArray['from'],
            'to' =>$shopsArray['to'],*/
            //'submitted_by' => $shopsArray['users']['user_id'],
          //  'data' => array_map([$this, 'transform'], $shopsArray['data'])
           'data' => array_map([$this, 'transform'], $products->toArray())
        ];
	}

	private function transform($product){
    return [
           'id' => $product['id'],
           'nimi' => $product['nimi'],
           'koko' => $product['koko'],
           'valmistaja' => $product['valmistaja']
          // 'by' =>$shop['users']['name']
        ];
}


    /*JWT-auth*/
	public function __construct(){
        $this->middleware('jwt.auth');
	}
}
