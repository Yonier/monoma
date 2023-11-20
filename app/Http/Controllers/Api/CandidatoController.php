<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use \App\Models\Candidato;
use App\Repositories\RedisRepository;

class CandidatoController extends Controller
{

  /**
   * Crear un candidato
   */
  public function add(Request $request)
  {
    try {
      $usuario = Auth::userOrFail();

      if ($usuario->role !== 'manager')
        return response()->error(401, 'Unauthorized');

      $validator = Validator::make($request->all(), [
        'name' => 'required|string|min:3|max:255',
        'source' => 'required|string|min:3|max:255',
        'owner' => 'required|integer|exists:App\Models\Usuario,id',
      ]);
      if($validator->fails())
        return response()->error(400, $validator->errors());

      $candidato = Candidato::create([
        'name' => $request->name,
        'source' => $request->source,
        'owner' => $request->owner,
        'created_by' => $usuario->id
      ]);
      RedisRepository::clear(['candidatos', 'candidatos.usuario.*']);

      return response()->success(201, $candidato);
    } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
      return response()->error(401, ['Token expired']);
    }
  }

  /**
   * Obtener candidato por id
   */
  public function id(Request $request, $id)
  {
    try {
      $usuario = Auth::userOrFail();

      $validator = Validator::make([ 'id' => $id ], [
        'id' => 'required|integer',
      ]);
      if($validator->fails())
        return response()->error(400, $validator->errors());

      $candidato = Candidato::where('owner', $usuario->id)->find($id);
      if(!$candidato)
        return response()->error(404, ['No lead found']);

      return response()->success(200, $candidato);
    } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
      return response()->error(401, ['Token expired']);
    }
  }

  /**
   * Obtener todos los candidatos
   */
  public function all(Request $request)
  {
    try {
      $usuario = Auth::userOrFail();

      if ($usuario->role === 'manager') {
        return response()->success(200, RedisRepository::get('candidatos', function () {
          return Candidato::get();
        }, fn($v) => json_decode($v)));
      } else {
        return response()->success(200, RedisRepository::get('candidatos.usuario.'.$usuario->id, function () use ($usuario) {
          return Candidato::where('owner', $usuario->id)->get();
        }, fn($v) => json_decode($v)));
      }
    } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
      return response()->error(401, ['Token expired']);
    }
  }

}
