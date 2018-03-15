<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Dog as Dog;
use App\Models\Breed as Breed;

class DogsController extends Controller
{
    
    /*--------------------------------------------------------------------------
     | Get All Dogs
     |
     |------------------------------------------------------------------------*/
    public function getAllDogs() {
        $dogs = Dog::all();
        return view('dogs.view_all', compact('dogs'));
    }



    /*--------------------------------------------------------------------------
     | New Dogs
     |
     |------------------------------------------------------------------------*/
     // Get New Dog
    public function getNewDog() {
        $breeds = Breed::orderBy('breed', 'asc')->get()->pluck('breed');
        return view('dogs.new', compact('breeds'));
    }

    // Post New Dog
    public function postNewDog(Request $request) {
        
        $dog = new Dog;

        $dog->name = $request->name;
        $dog->sex = $request->sex;
        // $dog->breed = $request->breed;
        // $dog->color = $request->color;
        // $dog->dob = $request->dob;
        // $dog->food = $request->food;
        // $dog->internal_id = $request->internal_id;
        // $dog->microchip_id = $request->microchip_id;
        $dog->save();

    }




     /*--------------------------------------------------------------------------
     | Edit Dogs
     |
     |------------------------------------------------------------------------*/
    public function dogOverview($id) {
        $dog = Dog::find($id);
        return view('dogs.overview', compact('dog'));
    }




}
