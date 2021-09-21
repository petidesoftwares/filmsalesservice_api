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
            'customer_id' =>'required',
            'bank_name' => 'required',
            'card_type' => 'required',
            'card_number' => 'required',
            'cvv' => 'required',
            'expiry_date' =>'required'
        ]);

        $validate->validate();

        $cardDetails = CreditCard::create($inputData);
        return response()->json(['card' => $cardDetails]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
            'card_number' => 'required',
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
