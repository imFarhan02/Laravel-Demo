<?php

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HolidayController; //Imported Controller class
use Illuminate\Support\Facades\Hash; // Import Hash facade
use Illuminate\Validation\ValidationException; // Import ValidationException

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->apiResource('holidays',HolidayController::class); 

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'access_token' => $token,
        'token_type' => 'Bearer',
    ]);
});