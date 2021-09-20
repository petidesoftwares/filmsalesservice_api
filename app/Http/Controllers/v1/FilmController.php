<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FilmController extends Controller
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
            'title'=>$request->input('title'),
            'video' => $request->file('video'),
            'price' => $request->input('price'),
            'available_cps' => $request->input('available_cps'),
            'product' => $request->input('product')
        ];

        /**
         * Make a validation rule that validates user input.
         */
        $validate = Validator::make($inputData,[
            'title' =>'required',
            'video'=>'required|mimes:mp4,x-flv,x-mpegURL,MP2T,3gpp,quicktime,x-msvideo,x-ms-wmv',
            'price'=>'required|max:10|min:4',
            'available_cps' => 'required',
            'product' => 'required'
        ],[
            'title.required' =>'Tile field is required',
            'video.required' => 'Video field is required',
            'video.mimes' => 'Upload a valid video format',
            'price.required' =>'Price field is required',
            'price.max' => 'Price must not be more than 10 digits in decimal format',
            'price.min' => 'Price must not be less than 4 digits in a decimal format',
            'available_cps.required' => 'Available copies is required',
            'product.require' => 'Movie product is required'
        ]);
        $validate->validate();

        $film = Film::create($inputData);

        return response()->json(['message'=>'Film successfully created', 'film'=>$film]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function editFilm(Request $request, $id){

    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Film::findOrFail($id);
        return response()->json(['film'=> $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Film::findOrFail($id);
        return response()->json(['data'=> $data]);
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
            'title' => $request->input('title'),
            'price' => $request->input('price'),
            'available_cps' => $request->input('available_cps'),
            'product' => $request->input('product')
        ];

        /**
         * Make a validation rule that validates user input.
         */
        $validate =Validator::make($inputData,[
            'title' =>'required',
            'price'=>'required|max:10|min:4',
            'available_cps' => 'required',
            'product' => 'required'
        ],[
            'title.required' =>'Tile field is required',
            'price.required' =>'Price field is required',
            'price.max' => 'Price must not be more than 10 digits in decimal format',
            'price.min' => 'Price must not be less than 4 digits in a decimal format',
            'available_cps.required' => 'Available copies is required',
            'product.require' => 'Movie product is required'
        ]);

        /**
         * Validate input
         */
        $validate->validate();
        $updater = Film::where('id', $id)->update($inputData);

        return response()->json(['message'=>'Film successfully edited', 'film'=>$updater]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Film::delete($id);
        return response()->json(['message'=>'Film deleted']);
    }
}
