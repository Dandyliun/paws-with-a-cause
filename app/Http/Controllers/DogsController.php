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
use App\Models\ExerciseRecord;
use App\Models\ExerciseAttributes;
use Response;
use Storage;
use Image;



class DogsController extends Controller
{
    

    public function __construct()
    {
        // Apply the auth middleware to all methods
        $this->middleware('auth');

    }




    /*--------------------------------------------------------------------------
     | Get All Dogs
     |
     |------------------------------------------------------------------------*/
    public function getAllDogs() {
        $dogs = Dog::orderBy('created_at', 'desc')->get();
        return view('dogs.view_all', compact('dogs'));
    }



    /*--------------------------------------------------------------------------
     | New Dogs
     |
     |------------------------------------------------------------------------*/
     // Get New Dog
    public function getNewDog() {
        $breeds = Breed::orderBy('breed', 'asc')->get()->pluck('breed');
        $colors = Color::orderBy('color', 'asc')->get()->pluck('color');
        return view('dogs.new', compact(['breeds', 'colors']));
    }

    // Post New Dog
    public function postNewDog(Request $request) {
        
        $dog = new Dog;

        $dog->name = $request->name;
        $dog->sex = $request->sex;
        $dog->breed = $request->breed;
        $dog->color = $request->color;
        $dog->dob = $request->dob;
        $dog->food_type = $request->food;
        $dog->internal_id = $request->internal_id;
        $dog->microchip_id = $request->microchip_id;
        $dog->save();

    }




    /*--------------------------------------------------------------------------
    | Dog Profie Image
    |
    |-------------------------------------------------------------------------*/
    public function updateDogImage(Request $request) {
        $dog = Dog::find($request->dog_id);

        // Get image and set the file name var
        $image = $request->file('image');
        $file_name = $request->image->hashName();
        $file_extention = pathinfo($file_name, PATHINFO_EXTENSION);
        
        // Instantiate the image class
        // ---------------------------------------------------------------------
        // Note: had to increase server php memory limit to 512MB to handle 
        // larger image file processing
        $thumbnail = Image::make($image->getRealPath());
        $image = Image::make($image->getRealPath());

        // Resize images
        if($image->height() > $image->width()) {
            $image->resize(350, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $thumbnail->resize(60, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        } elseif($image->height() < $image->width()) {
            $image->resize(null, 350, function ($constraint) {
                $constraint->aspectRatio();
            });
            $thumbnail->resize(null, 60, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        // Crop images
        $image->crop(350, 350);
        $thumbnail->crop(60, 60);

        // Save images
        $image->save(public_path('storage/profile_images/' . $file_name));
        $thumbnail->save(public_path('storage/profile_images/thumbnails/' . $file_name));

        // Save image file name to the database
        $dog->profile_image = $file_name;
        $dog->save();

        // Return the generate file name
        return $file_name;
    }





    /*--------------------------------------------------------------------------
    | Dog Overview
    |
    |-------------------------------------------------------------------------*/
    // Get Dog Overview
    public function dogOverview($id) {
        $dog = Dog::find($id);
        $healthRecords = HealthRecord::where('dog_id', $id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
        return view('dogs.overview', compact(['dog', 'healthRecords']));
    }





    /*--------------------------------------------------------------------------
    | Dog Profile
    |
    |-------------------------------------------------------------------------*/
    // Get dog profile
    public function dogProfile($id) {
        $dog = Dog::find($id);
        $breeds = Breed::pluck('breed')->all();
        $colors = Color::pluck('color')->all();
        return view('dogs.profile', compact(['dog', 'breeds', 'colors']));
    }

    // Post dog profile
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
    // Get all health records for a dog
    public function dogHealth($id) {
        $dog = Dog::find($id);
        $healthRecords = HealthRecord::where('dog_id', $id)
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('dogs.health_records', compact(['dog', 'healthRecords']));
    }

    // Get new health record for a dog
    public function newDogHealth($id) {
        $dog = Dog::find($id);
        $healthAttributes = HealthAttributes::all();
        return view('dogs.health_new', compact(['dog', 'healthAttributes']));
    }

    // Post new health record for a dog
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
    | Dog Exercise
    |
    |-------------------------------------------------------------------------*/
    public function dogExercise($id) {
        $dog = Dog::find($id);
        $exerciseRecords = ExerciseRecord::where('dog_id', $id)->paginate(5);
        return view('dogs.exercise_records', compact(['dog', 'exerciseRecords']));
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

    public function newDogExercise($id) {
        $dog = Dog::find($id);
        $exerciseAttributes = ExerciseAttributes::all();
        return view('dogs.exercise_new', compact(['dog', 'exerciseAttributes']));
    }

    public function createExerciseRecord(Request $request){
        $exerciseRecord = new ExerciseRecord;
        $exerciseRecord->dog_id = $request->id;
        $exerciseRecord->exercise_name = $request->exercise_type;
        $exerciseRecord->comments = $request->comments;
        $exerciseRecord->normality = $request->normality;
        $exerciseRecord->save();
    }

}
