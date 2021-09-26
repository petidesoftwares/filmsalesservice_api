<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
       return Film::all();
    }

    /**
     * Get film based on a particular genre.
     * @param $genre
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFilmByGenre($genre){
        $film =  Genre::where('genre',$genre)->with('film')->get();
        return  response()->json(['film'=>$film]);
    }

    /**
     * Search for product ending with a particular character
     * @param $char
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProductByChar($char){
        $product = Film::where('product','like','%'.$char)->get('product');
        return response()->json(['product'=>$product]);
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
        $video = $request->file('video');
        $request->validate([
            'video'=>[
                'required', 'mimes:mp4,x-flv,x-mpegURL,MP2T,3gpp,quicktime,x-msvideo,x-ms-wmv'
            ]
        ]);

        $inputData = [
            'price' => $request->input('price'),
            'available_cps' => $request->input('available_cps'),
            'product' => $request->input('product')
        ];

        $genres =[
            'genre1' =>$request->input('genre1'),
            'genre2' =>$request->input('genre2'),
            'genre3' =>$request->input('genre3'),
            'genre4' =>$request->input('genre4'),
            'genre5' =>$request->input('genre5')
        ];

        /**
         * Make a validation rule that validates user input.
         */
        $validate = Validator::make($inputData,[
            'price'=>'required|max:10|min:4',
            'available_cps' => 'required',
            'product' => 'required',
        ],[
            'price.required' =>'Price field is required',
            'price.max' => 'Price must not be more than 10 digits in decimal format',
            'price.min' => 'Price must not be less than 4 digits in a decimal format',
            'available_cps.required' => 'Available copies is required',
            'product.require' => 'Movie product is required'
        ]);
        $validate->validate();

        $filmName = $video->getClientOriginalName();
        $path = $request->video->storeAs('public',$filmName);
        $storagePath = Storage::url($filmName);

        $storageData = [
            'title'=>$filmName,
            'location'=>$storagePath,
            'price'=>$inputData['price'],
            'available_cps'=>$inputData['available_cps'],
            'product' => $inputData['product']
        ];
        $film = Film::create($storageData);

        foreach ($genres as $key=>$datum){
            if($datum !="" || $datum != null){
                $genre = [
                    'film_id' => $film->id,
                    'genre'=>$datum
                ];
                Genre::create($genre);
            }
        }
        $respData = Film::where('id',$film)->with('genre')->get();

        return response()->json([
            'status'=>200,
            'message'=>'Film successfully created', 'path' => $path,'spath'=>$storagePath
            ]);
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
        $data = Film::where('id',$id)->with('genre')->get();
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
            'price' => $request->input('price'),
            'available_cps' => $request->input('available_cps'),
            'product' => $request->input('product'),
            'genre'=>$request->input('genre')
        ];

        /**
         * Make a validation rule that validates user input.
         */
        $validate =Validator::make($inputData,[
            'price'=>'required|max:10|min:4',
            'available_cps' => 'required',
            'product' => 'required',
            'genre' => 'required'
        ],[
            'price.required' =>'Price field is required',
            'price.max' => 'Price must not be more than 10 digits in decimal format',
            'price.min' => 'Price must not be less than 4 digits in a decimal format',
            'available_cps.required' => 'Available copies is required',
            'product.required' => 'Movie product is required',
            'genre.required' => 'Movie genre is required'
        ]);

        /**
         * Validate input
         */
        $validate->validate();

        $updateData = [
            'price'=>$inputData['price'],
            'available_cps' =>$inputData['available_cps'],
            'product' => $inputData['product']
        ];
        $updater = Film::where('id', $id)->update($updateData);
        $genreData = explode('/',$inputData['genre']);
        foreach ($genreData as $key=>$value){
            if($value !=""){
                Genre::updateOrCreate(
                    ['film_id'=>$id,'genre'=>$value],
                    ['genre'=>$value]
                );
            }
        }

        return response()->json([
            'status'=>200,
            'message'=>'Film successfully edited']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $film = Film::find($id);
        $film->delete();
        return response()->json(['message'=>'Film deleted']);
    }
}
