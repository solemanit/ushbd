<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    DivisionController,
    DistrictController,
    UpazilaController,
    UnionController
};
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

// Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
//     Route::get('/divisions', [DivisionController::class, 'index']);
//     Route::get('/districts', [DistrictController::class, 'index']);
//     Route::get('/districts/{division_id}', [DistrictController::class, 'byDivision']);
//     Route::get('/upazilas', [UpazilaController::class, 'index']);
//     Route::get('/upazilas/{district_id}', [UpazilaController::class, 'byDistrict']);
//     Route::get('/unions/{upazila_id}', [UnionController::class, 'byUpazila']);
// });


Route::get('/divisions', [DivisionController::class, 'index']);
Route::get('/districts', [DistrictController::class, 'index']);
Route::get('/districts/{division_id}', [DistrictController::class, 'byDivision']);
Route::get('/upazilas', [UpazilaController::class, 'index']);
Route::get('/upazilas/{district_id}', [UpazilaController::class, 'byDistrict']);
Route::get('/unions/{upazila_id}', [UnionController::class, 'byUpazila']);

/*

| Resource              | URL                            | Parameter              |
| --------------------- | ------------------------------ | ---------------------- |
| All Divisions         | `/api/v1/divisions`               | None                   | - lagbe
| All Districts         | `/api/v1/districts`               | None                   |
| Districts by Division | `/api/v1/districts/{division_id}` | `division_id` (number) | - lagbe
| All Upazilas          | `/api/v1/upazilas`                | None                   |
| Upazilas by District  | `/api/v1/upazilas/{district_id}`  | `district_id` (number) |
| Unions by Upazila     | `/api/v1/unions/{upazila_id}`     | `upazila_id` (number)  |

*/

/*
Generate API Token
http://127.0.0.1:8000/api/get-token?email=user@test.com&password=12345678&device_name=web

{
  "token": "1|rhivx4hmq2QgXm1Zam5JOxZh5f1JHxRZk4QfBEpL46943aff​",
  "user": {
    "id": 1,
    "name": "user",
    "email": "user@test.com"
  }
}

*/


Route::get('/get-token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'nullable|string',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    $deviceName = $request->device_name ?? 'default';
    $token = $user->createToken($deviceName)->plainTextToken;

    return response()->json([
        'token' => $token,
        'user'  => $user->only(['id', 'name', 'email']),
    ]);
});
