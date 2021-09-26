<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\CreditCard;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CreditCardController extends Controller
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

    function verifyIfUserHasCard($id){
        $cardNumber = CreditCard::where('customer_id',$id)->get('card_number');
        if (count($cardNumber) == 0){
            return response()->json(['cardState'=>false]);
        }
        return response()->json(['cardState'=>true]);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputData = [
            'customer_id' => $request->input('customer_id'),
            'bank_name' => $request->input('bank_name'),
            'card_type' => $request->input('card_type'),
            'card_number' => $request->input('card_number'),
            'cvv' => $request->input('cvv'),
            'expiry_date' => $request->input('expiry_date')
        ];
        $validate = Validator::make($inputData,[
            'bank_name' => 'required',
            'card_type' => 'required',
            'card_number' => 'required|digits:16|unique:credit_cards,card_number',
            'cvv' => 'required',
            'expiry_date' =>'required'
        ]);

        $validate->validate();

        $cardDetails = CreditCard::create($inputData);
        return response()->json([
            'status'=>200,
            'message'=>'Card successfully created',
            'card' => $cardDetails]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cardDetails = CreditCard::where('customer_id',$id)->get();
        return response()->json([
            'status'=>200,
            'cardDetails'=>$cardDetails]);
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
        $inputData = [
            'bank_name' => $request->input('bank_name'),
            'card_type' => $request->input('card_type'),
            'card_number' => $request->input('card_number'),
            'cvv' => $request->input('cvv'),
            'expiry_date' => $request->input('expiry_date')
        ];
        $validate = Validator::make($inputData,[
            'bank_name' => 'required',
            'card_type' => 'required',
            'card_number' => 'required|unique:credit_cards,card_number',
            'cvv' => 'required',
            'expiry_date' =>'required'
        ]);

        $validate->validate();

        $updateData =[
            'bank_name' => $inputData['bank_name'],
            'card_type' => $inputData['card_type'],
            'card_number' => $inputData['card_number'],
            'cvv' => $inputData['cvv'],
            'expiry_date' => $inputData['expiry_date']
        ];

        $updateID = CreditCard::where('id',$id)->update($updateData);

        $details = CreditCard::where('id',$updateID)->get();

        return response()->json(['message'=>'Card details successfully updated','data'=>$details]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
