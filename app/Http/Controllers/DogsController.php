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
use DB;
use Response;
use Storage;
use Image;



class DogsController extends Controller
{
    
    /*--------------------------------------------------------------------------
     | Default Class Constructor
     |
     |------------------------------------------------------------------------*/
    public function __construct() {
        // Apply the auth middleware to all DogsController class methods
        $this->middleware('auth');
    }



    /*--------------------------------------------------------------------------
     | Get All Dogs
     |
     |------------------------------------------------------------------------*/
    public function showAllDogs() {
        $dogs = Dog::orderBy('created_at', 'desc')->get();
        return view('dogs.view_all', compact('dogs'));
    }



    /*--------------------------------------------------------------------------
     | New Dogs
     |
     |------------------------------------------------------------------------*/
     // Show new dog view
    public function showNewDog() {
        $breeds = Breed::orderBy('breed', 'asc')->get()->pluck('breed');
        $colors = Color::orderBy('color', 'asc')->get()->pluck('color');
        return view('dogs.new', compact(['breeds', 'colors']));
    }

    // Create new dog
    public function createNewDog(Request $request) {
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
        $image->save(
            public_path('storage/profile_images/' . $file_name)
        );
        $thumbnail->save(
            public_path('storage/profile_images/thumbnails/' . $file_name)
        );
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
    // Show dog overview view
    public function showDogOverview($id) {
        $dog = Dog::find($id);
        // Get 3 most recent health records and total record count
        $healthRecords = HealthRecord::where('dog_id', $id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
        $healthRecordsCount = HealthRecord::where('dog_id', $id)->count();
        // Get 3 most recent grooming records and total record count
        $groomingRecords = GroomingRecord::where('dog_id', $id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
        $groomingRecordsCount = GroomingRecord::where('dog_id', $id)->count();
        // Get 3 most recent exercise records and total record count
        $exerciseRecords = ExerciseRecord::where('dog_id', $id)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
        $exerciseRecordsCount = ExerciseRecord::where('dog_id', $id)->count();
        // Return the view and data
        return view('dogs.overview', compact([
            'dog',
            'healthRecords',
            'healthRecordsCount',
            'groomingRecords',
            'groomingRecordsCount',
            'exerciseRecords',
            'exerciseRecordsCount'
        ]));
    }





    /*--------------------------------------------------------------------------
    | Dog Profile
    |
    |-------------------------------------------------------------------------*/
    // Show dog profile view
    public function showDogProfile($id) {
        $dog = Dog::find($id);
        // Get all breeds and colors
        $breeds = Breed::pluck('breed')->all();
        $colors = Color::pluck('color')->all();
        // Return the view and data
        return view('dogs.profile', compact(['dog', 'breeds', 'colors']));
    }

    // Update dog profile
    public function updateDogProfile(Request $request) {
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
    // Show all health records for a dog
    public function showDogHealth($id) {
        $dog = Dog::find($id);
        // Get dog's health records and paginate the results
        $healthRecords = HealthRecord::where('dog_id', $id)
            ->orderBy('created_at', 'desc')
            ->paginate(5);
        // Return the view and data
        return view('dogs.health_records', compact(['dog', 'healthRecords']));
    }
    // Show new health record for a dog
    public function showNewHealthRecord($id) {
        $dog = Dog::find($id);
        // Get all health attributes
        $healthAttributes = HealthAttributes::all();
        // Return the view and data
        return view('dogs.health_new', compact(['dog', 'healthAttributes']));
    }
    // Create new health record
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
        $exerciseRecords = ExerciseRecord::
        where('dog_id', $id)->paginate(5);
        return view('dogs.exercise_records', compact(['dog', 'exerciseRecords']));
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
        $exerciseRecord->save();
    }



    /*--------------------------------------------------------------------------
    | Dog Abnormalities
    |
    |-------------------------------------------------------------------------*/

   /* public function showDogHealth($id) {
        $dog = Dog::find($id);
        // Get dog's health records and paginate the results
        $healthRecords = HealthRecord::where('dog_id', $id)
            ->orderBy('created_at', 'desc')
            ->paginate(5);
        // Return the view and data
        return view('dogs.health_records', compact(['dog', 'healthRecords']));
    }
   */

    public function createExerciseAbnormalityRecord(Request $request){
        $abnormalityRecord = new AbnormalityRecord;
        $abnormalityRecord->dog_id = $request->id;
        $abnormalityRecord->discovered_at = $request->exercise_type;
        $abnormalityRecord->comments = $request->comments;
        $abnormalityRecord->save();
    }

    public function createHealthAbnormalityRecord(Request $request){
        $abnormalityRecord = new AbnormalityRecord;
        $abnormalityRecord->dog_id = $request->id;
        $abnormalityRecord->discovered_at = $request->attribute;
        $abnormalityRecord->comments = $request->value;
        $abnormalityRecord->save();
    }

    public function createGroomingAbnormalityRecord(Request $request){
        $abnormalityRecord = new AbnormalityRecord;
        $abnormalityRecord->dog_id = $request->id;
        $abnormalityRecord->discovered_at = $request->attribute;
        $abnormalityRecord->comments = $request->value;
        $abnormalityRecord->save();
    }
   /* public function dogAbnormalities($id) {
        $dog = Dog::find($id);
        $abnormalitiesRecords = AbnormalitiesRecords::where('dog_id', $id)->paginate(5);
        return view('dogs.abnormalities', compact(['dog', 'abnormalitiesRecords']));
    }
*/
    public function dogAbnormalities($id) {

        $dog = DB::table('dogs')
            ->join('dog_exercise_records', 'dogs.id', '=', 'dog_exercise_records.dog_id')
            ->join('dog_health_records', 'dogs.id', '=', 'dog_health_records.dog_id')
            ->join('dog_grooming_records', 'dogs.id','=', 'dog_grooming_records.dog_id')


            //->select('users.*', 'contacts.phone', 'orders.price')

            ->get();
        return view('dogs.abnormalities', compact(['dog']));
    }
}
