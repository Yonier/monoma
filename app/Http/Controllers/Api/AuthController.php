<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

  /**
   * Generar access token
   */
  public function index(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'username' => 'required|string',
      'password' => 'required|string',
    ]);
    if($validator->fails())
      return response()->error(400, $validator->errors());

    if (!$token = Auth::attempt([
      'username' => $request->username,
      'password' => $request->password
    ]))
      return response()->error(401, ['error' => 'Password incorrect for: ' . $request->username]);

    return response()->success(200, [
      'token' => $token,
      'minutes_to_expire' => JWTAuth::factory()->getTTL()
    ]);
  }

}
