<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CreditCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isNull;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }



    /**
     * Store a newly created cart in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cartInput = [
            'customer_id'=>$request->input('customer_id'),
            'film_id' =>$request->input('film_id'),
            'shopping_id' =>$request->input('shopping_id')
        ];

        $request->validate([
            'customer_id'=>'required',
            'film_id'=>'required',
            'shopping_id'=>'required',
        ]);

        Cart::create($cartInput);
        $cart = Cart::where('customer_id',$cartInput['customer_id'])->with('film')->get();
        return response()->json(['message'=>'Film has been addedd to cart','cart'=>$cart]);
    }

    public function cartTotal($id){
        $total = DB::select("SELECT count(film_id) total FROM carts WHERE customer_id =? AND deleted_at is null",[$id]);
        $shoppingID = DB::select("SELECT shopping_id FROM carts WHERE customer_id =? AND deleted_at is null",[$id]);
        return response()->json(['status'=>200,'cartSum'=>$total,'shoppingID'=>$shoppingID, 'messagge'=>'Item added to your cart']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cart = Cart::where('customer_id',$id)->with('film')->get();
        return response()->json(['status'=>200,'cart'=>$cart]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function clearCart(Request $request){
        $request->validate([
            'customer_id'=>'required',
            'shopping_id'=>'required'
        ]);
        $customer_id = $request->get('customer_id');
        $shopping_id = $request->get('shopping_id');

        $id = DB::select("SELECT id FROM carts WHERE customer_id = ? AND shopping_id =? AND deleted_at is null ",[$customer_id, $shopping_id]);
        $deleted = false;
        for ($i = 0; $i<count($id); $i++){
            $cart = Cart::find($id[$i]->id);
            $delete = $cart->delete();
            if($delete == true || $deleted == 1){
                $deleted = true;
            }
        }
        return response()->json(['status'=>200,'deleted'=>$deleted]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
