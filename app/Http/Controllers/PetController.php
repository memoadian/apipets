<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Pet;

use Illuminate\Support\Str;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pets = Pet::orderBy('id', 'desc')
                    ->with('status')
                    ->with('type')
                    ->paginate(30);

        return $pets;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->has('image')) {
            $image = $request->input('image');
            $image = $image.str_replace('base64', '', $image);
            $image = $image.str_replace('_', '', $image);
            $image = $image.str_replace('\n', '', $image);
    
            $real_image = base64_decode($image);
            $name = Str::random(20).'.'.'jpg';
    
            file_put_contents(public_path().'/uploads/'.$name, $real_image);

            $name = asset('uploads/'.$name);
        } else {
            $name = '';
        }

        $pet = new Pet();
        $pet->name = $request->name;
        $pet->age = $request->age;
        $pet->desc = $request->desc;
        $pet->image = $name;
        $pet->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pet = Pet::where('id', $id)
                    ->with('status')
                    ->with('type')
                    ->first();
        return $pet;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
        if ($request->has('image') && $request->image != '') {
            $image = $request->input('image');
            $image = $image.str_replace('base64', '', $image);
            $image = $image.str_replace('_', '', $image);
            $image = $image.str_replace('\n', '', $image);

            $real_image = base64_decode($image);
            $name = Str::random(20).'.'.'jpg';

            file_put_contents(public_path().'/uploads/'.$name, $real_image);

            $name = asset('uploads/'.$name);
        } else {
            $name = '';
        }

        $pet = Pet::find($id);
        $pet->name = $request->name;
        $pet->age = $request->age;
        $pet->desc = $request->desc;
        if ($name != '') {
            $pet->image = $name;
        }
        $pet->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pet = Pet::find($id);
        $pet->delete();
    }
}
