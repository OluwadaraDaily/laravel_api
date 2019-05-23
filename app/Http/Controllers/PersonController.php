<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Person;
use App\Http\Resources\PersonResource;
use App\Http\Resources\PersonResourceCollection;


class PersonController extends Controller
{	
	//To return data of a particular person from the database
	//Returning a PersonResource helps us to wrap the data inside a "data" array for frontend use.
    public function show(Person $person): PersonResource
    {
    	return new PersonResource($person);
    }

    //Returns the data of everyone in the database wrapped in the "data" array
    public function index(): PersonResourceCollection
    {
    	return new PersonResourceCollection(Person::paginate(10));
    }

    //Storing data into the database using a POST HTTP request
    public function store(Request $request)
    {
    	//Create Person
    		//Validate data first of all
    	$request->validate([
    		'first_name'  => 'required',
    		'last_name'   => 'required',
    		'email'       => 'required',
    		'phone'       => 'required',
    		'city'        => 'required'
    	]);

    	//Create a person variable
    	$person = Person::create($request->all());

    	//Return person
    	return new PersonResource($person);
    }

    public function update(Person $person, Request $request): PersonResource
    {	
    	//Update all fields
    	$person->update($request->all());

    	//Returning a PersonResource
    	return new PersonResource($person);
    }

    public function destroy(Person $person)
    {
    	//Delete person using an Eloquent function of "delete"
    	$person->delete();

    	//Return a message if deleted

    		return response()->json();
	   }
}
