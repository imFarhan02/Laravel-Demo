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
        if ($holidays->count() > 0) {
            return HolidayResource::collection($holidays);
        } else {
            return response()->json(['message' => 'No Record Found!!'], 200);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'date' => 'required|date'
        ]);

        if ($validator->fails()) {
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
            'message' => 'Holiday Created Succesfully!!',
            'data' => new HolidayResource($holiday)
        ], 201);
    }

    public function show(Holiday $holiday)
    {

        // Return the found holiday data
        return response()->json([
            'data' => new HolidayResource($holiday)
        ], 200);
    }


    public function update(Request $request, Holiday $holiday)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        // If validation fails, return an error response
        if ($validator->fails()) {
            return response()->json([
                'message' => 'All fields are mandatory',
                'errors' => $validator->messages()
            ], 422);
        }

        // Update the holiday record
        $holiday->update([
            'title' => $request->title,
            'date' => $request->date,
        ]);

        // Return success response with updated data
        return response()->json([
            'message' => 'Holiday Updated Successfully!!',
            'data' => new HolidayResource($holiday)
        ], 200);
    }

    public function destroy(Holiday $holiday)
    {

        // Delete the holiday
        $holiday->delete();

        // Return success message
        return response()->json([
            'message' => 'Holiday Deleted Successfully!!'
        ], 204);
    }
}
