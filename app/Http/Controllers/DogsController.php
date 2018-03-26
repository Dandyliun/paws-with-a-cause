<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Dog as Dog;
use App\Models\Breed as Breed;
use App\Models\Color as Color;
use App\Models\HealthAttributes;
use App\Models\HealthRecord;
use App\Models\GroomingAttributes;
use App\Models\GroomingRecord;


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
    | Dog Overview
    |
    |-------------------------------------------------------------------------*/
    
    public function dogOverview($id) {
        $dog = Dog::find($id);
        return view('dogs.overview', compact('dog'));
    }




    /*--------------------------------------------------------------------------
    | Dog Profile
    |
    |-------------------------------------------------------------------------*/
    public function dogProfile($id) {
        $dog = Dog::find($id);
        $breeds = Breed::pluck('breed')->all();
        $colors = Color::pluck('color')->all();
        return view('dogs.profile', compact(['dog', 'breeds', 'colors']));
    }

    public function saveDogProfile(Request $request) {
        $dog = Dog::find($request->id);
        $dog->name = $request->name;
        $dog->sex = $request->gender;
        $dog->breed = $request->breed;
        $dog->color = $request->color;
        $dog->dob = $request->dob;
        $dog->food_type = $request->food;
        $dog->internal_id = $request->internal_id;
        $dog->microchip_id = $request->microchip_id;
        $dog->save();
    }



    /*--------------------------------------------------------------------------
    | Dog Health
    |
    |-------------------------------------------------------------------------*/
    public function dogHealth($id) {
        $dog = Dog::find($id);
        $healthRecords = HealthRecord::where('dog_id', $id)->paginate(5);

        return view('dogs.health_records', compact(['dog', 'healthRecords']));
    }

    public function newDogHealth($id) {
        $dog = Dog::find($id);
        $healthAttributes = HealthAttributes::all();
        return view('dogs.health_new', compact(['dog', 'healthAttributes']));
    }

    public function createHealthRecord(Request $request) {
        $healthRecord = new HealthRecord;
        $healthRecord->dog_id = $request->id;
        $healthRecord->attribute = $request->record_type;
        $healthRecord->performed_by = "test user";
        $healthRecord->normality = $request->normality;
        $healthRecord->value = $request->value;
        $healthRecord->save();

    }


    /*--------------------------------------------------------------------------
    | Dog Grooming
    |
    |-------------------------------------------------------------------------*/
    public function dogGrooming($id) {
        $dog = Dog::find($id);
        $groomingRecords = GroomingRecord::where('dog_id', $id)->paginate(5);
        return view('dogs.grooming', compact(['dog', 'groomingRecords']));
    }

    public function newDogGrooming($id) {
        $dog = Dog::find($id);
        $groomingAttributes = GroomingAttributes::all();
        return view('dogs.grooming_new', compact(['dog', 'groomingAttributes']));
    }

    public function createGroomingRecord(Request $request) {
        $groomingRecord = new GroomingRecord;
        $groomingRecord->dog_id = $request->id;
        $groomingRecord->attribute = $request->record_type;
       // $groomingRecord->performed_by = "test user";
        $groomingRecord->normality = $request->normality;
        $groomingRecord->value = $request->value;
        $groomingRecord->save();
    }

    /*--------------------------------------------------------------------------
    | Dog Abnormalities
    |
    |-------------------------------------------------------------------------*/
    public function dogAbnormalities($id) {
        $dog = Dog::find($id);
        $breeds = Breed::pluck('breed')->all();
        $colors = Color::pluck('color')->all();
        return view('dogs.abnormalities', compact(['dog', 'breeds', 'colors']));
    }


}
