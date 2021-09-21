<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
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

    public function getCustomerByAge($age){
        $dob = Carbon::now()->subYear($age);
        $custromers = Customer::where('dob','<',$dob->format('d/m/Y'))->get();
        return response()->json(['customer'=>$custromers]);
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
            'firstname' => $request->input('firstname'),
            'middle_name' => $request->input('middle_name'),
            'surname' => $request->input('surname'),
            'gender' => $request->input('gender'),
            'email' => $request->input('email'),
            'dob' => $request->input('date_of_birth'),
            'phone' => $request->input('phone_number'),
            'password' => Hash::make($request->input('password')),
            'confirm_password' => $request->input('confirm_password')
        ];

        $vaildate = Validator::make($inputData,[
            'firstname' => 'required|max:50|min:2',
            'surname' => 'required|max:50|min:2',
            'gender'=> ['required', 'regex:/^(Male)|(Female)$/'],
            'email'=>'required|email|unique:customers,email',
            'dob' =>'required|max:10|min:10',
            'phone'=>'required|max:15|min:10',
            'password' => 'required',
            'confirm_password' => 'required'
        ],[
            'firstname.required' => 'First name is required for registration',
            'firstname.max' => 'First name must not be lest than 2 characters',
            'firstname.min' => 'First name must not be more than 50 characters',
            'surname.required' => 'Surname is required for registration',
            'surname.max' => 'Surname must not be lest than 2 characters',
            'surname.min' => 'Surname must not be more than 50 characters',
            'gender.required' => 'Customer gender is required for registration',
            'gender.regex' => 'Gender format mut be Male or Female',
            'email.required' => 'Email is required for registration.',
            'email.email' => 'Email must be a valid email formart',
            'email.unique' => 'This email address has already been used',
            'dob.required' => 'Date of birth is required for registration',
            'dob.max' => 'Date of birth must be exactly 10 characters',
            'dob.min' => 'Date of birth must be exactly 10 characters',
            'phone.required' => 'Phone number is required',
            'phone.max' => 'Phone number must not be more than 15 digits',
            'phone.min' => 'Phone number must not be less than 10 digits',
            'password.required' => 'Password is required',
            'confirm_password.required' => 'Confirm password field is required'
        ]);

        $vaildate->validate();

        if(!Hash::check($inputData['confirm_password'], $inputData['password'])){
            return response()->json(['error' => 'Password confirmation failed']);
        }
        $storageData =[
            'firstname' => $inputData['firstname'],
            'middle_name' => $inputData['middle_name'],
            'surname' => $inputData['surname'],
            'gender' => $inputData['gender'],
            'email' => $inputData['email'],
            'dob' => $inputData['dob'],
            'phone' => $inputData['phone'],
            'password' => $inputData['password']
        ];

       $customer =  Customer::create($storageData);

       return response()->json(['message'=>'Customer successfully created', 'customer'=>$customer]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Customer::where('id',$id)->get();
        return response()->json(['data'=>$data]);
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
        $customer = auth()->user();
        $hash = Customer::where('id',$customer)->get(['email','password']);
        if(!Hash::check($request->password,$hash->password )){
            return response()->json(['error'=>'Unauthorized Update. Password provided not match yours']);
        }
        $inputData = [
            'firstname' => $request->input('firstname'),
            'middle_name' => $request->input('middle_name'),
            'surname' => $request->input('surname'),
            'gender' => $request->input('gender'),
            'dob' => $request->input('date_of_birth'),
            'phone' => $request->input('phone_number'),
        ];

        $vaildate = Validator::make($inputData,[
            'firstname' => 'required|max:50|min:2',
            'surname' => 'required|max:50|min:2',
            'gender'=> ['required', 'regex:/^(Male)|(Female)$/'],
            'dob' =>'required|max:10|min:10',
            'phone'=>'required|max:15|min:10',
        ],[
            'firstname.required' => 'First name is required for registration',
            'firstname.max' => 'First name must not be lest than 2 characters',
            'firstname.min' => 'First name must not be more than 50 characters',
            'surname.required' => 'Surname is required for registration',
            'surname.max' => 'Surname must not be lest than 2 characters',
            'surname.min' => 'Surname must not be more than 50 characters',
            'gender.required' => 'Customer gender is required for registration',
            'gender.regex' => 'Gender format mut be Male or Female',
            'dob.required' => 'Date of birth is required for registration',
            'dob.max' => 'Date of birth must be exactly 10 characters',
            'dob.min' => 'Date of birth must be exactly 10 characters',
            'phone.required' => 'Phone number is required',
            'phone.max' => 'Phone number must not be more than 15 digits',
            'phone.min' => 'Phone number must not be less than 10 digits',
        ]);

        $vaildate->validate();

        $storageData =[
            'firstname' => $inputData['firstname'],
            'middle_name' => $inputData['middle_name'],
            'surname' => $inputData['surname'],
            'gender' => $inputData['gender'],
            'dob' => $inputData['dob'],
            'phone' => $inputData['phone']
        ];
        Customer::where('id',$id)->update($storageData);
        $update = Customer::where('id',$id)->get();
        return response()->json(['message'=>'Update Successful','data'=>$update]);
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
