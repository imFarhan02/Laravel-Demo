<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Holiday;
use App\Http\Resources\HolidayResource;
use Illuminate\Support\Facades\Validator;

class HolidayController extends Controller
{
    public function index()
    {
        $holidays =  Holiday::get();
        if ($holidays ->count()>0) {
            return HolidayResource::collection($holidays);
        } else {
            return response()->json(['message' => 'No Record Found!!'], 200);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required|string|max:255',
            'date' => 'required|date'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'All fields are mandatory',
                'error' => $validator->messages()
            ], 422);
        }

        $holiday = Holiday::create([
            'title' => $request->title,
            'date' => $request->date
        ]);

        return response()->json([
            'message' => 'Holiday created Succesfully!!',
            'data' => new HolidayResource($holiday) 
        ],200);
    }

    public function show() {}

    public function update() {}

    public function destroy() {}
}
