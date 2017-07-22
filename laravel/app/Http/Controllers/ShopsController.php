<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests;
use Response;

use App\Shop;
//Use App\UserShop;
use App\User;

use Gate;
//use Illuminate\Support\Facades\Gate;

class ShopsController extends Controller
{
    /*Palauttaa kaikki kaupat
    *
    *
    */
    public function index(Request $request){
    	
    	$shops = Shop::all();
        return Response::json([
                'data' => $this->transformCollection($shops)
        ], 200);

    }
	


    /*Oikeasti pitäisi käyttää gate, ShopPolicy, AuthServiceProvider
    /*https://laravel.com/docs/5.1/authorization
    /* Tutkitaan ensin onko käyttäjän tokenissa sama id sama kuin parametrinä saatu id
    /* -> ellei ole niin estetään näyttäminen
    /* -> jos on niin näytetään lista käyttäjän kaupoista
	/**/

	public function show(Request $request, $id){

        //etsitään useri jonka id saatu parametrinä
        $user = User::find($id);
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
         //   dd("allowed");
            // kysely välitaulun kautta tietokannasta, näytetään vain yksi kappale
         /*   $user = User::with(['shops' => function($query){
        	   $query->distinct('shop');
            }])->find($id);*/
            $user = User::with(['shops' => function($query){
               $query->distinct('shop');
            }])->find($id);

            if(!$user){
                return Response::json([
                    'error' => [
                        'message' => 'User does not exist'
                    ]
                ], 404);
            }
        //palautetaan json muodossa userista saatu data
        return Response::json([
     //   	'previous_shop_id'=> $previous,
     //       'next_shop_id'=> $next,
                'data' => $user
            //     'data' => $shop
      //      'data' => $this->transform($shop)
        //    'data' => $this->transformUser($user)
        ], 200);

         }
    //jos tokeista saatu id on eri kuin id apista
       else {
            dd("you don't have permission of that operation");
        }

}

public function store(Request $request)
    {
 
        if(! $request->shop ){
            return Response::json([
                'error' => [
                    'message' => 'Please Provide Shopname'
                ]
            ], 422);
        }
        $shop = Shop::create($request->all());
 
        return Response::json([
                'message' => 'Shop Created Succesfully',
                'data' => $this->transform($shop)
        ]);
    }

public function update(Request $request, $id)
    {    
        if(! $request->shop){
            return Response::json([
                'error' => [
                    'message' => 'Please Provide Shop'
                ]
            ], 422);
        }
        
        $shop = Shop::find($id);
        $shop->shop = $request->shop;

       // $joke->user_id = $request->user_id;
        $shop->save(); 
 
        return Response::json([
                'message' => 'Shop Updated Succesfully'
        ]);
    }

public function destroy($id)
    {
        Shop::destroy($id);
    }

private function transformCollectionUsers($users){
   return array_map([$this, 'transformUser'], $users->toArray());
/*   $shopsArray = $users->toArray();
        return [
          /*  'total' => $shopsArray['total'],
            'per_page' => intval($shopsArray['per_page']),
            'current_page' => $shopsArray['current_page'],
            'last_page' => $shopsArray['last_page'],
            'next_page_url' => $shopsArray['next_page_url'],
            'prev_page_url' => $shopsArray['prev_page_url'],
            'from' => $shopsArray['from'],
            'to' =>$shopsArray['to'],*/

           // 'data' => array_map([$this, 'transform'], $shopsArray['data'])
 //           'data' => array_map([$this, 'transformUser'], $users->toArray())
/*        ];*/
}

private function transformCollection($shops){
  //  return array_map([$this, 'transform'], $shops->toArray());
    $shopsArray = $shops->toArray();
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
           'data' => array_map([$this, 'transform'], $shops->toArray())
        ];
}
 
private function transform($shop){
    return [
           'shop_id' => $shop['id'],
           'shop' => $shop['shop']
          // 'by' =>$shop['users']['name']
        ];
}

private function transformUser($user){
    return [
    	 'user' => $user['name'],
         'shop' => $user['shops']['shop']
        ];
}

/*JWT-auth*/
public function __construct(){
        $this->middleware('jwt.auth');
}

}
