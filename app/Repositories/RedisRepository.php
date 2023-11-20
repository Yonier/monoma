<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Redis;

class RedisRepository
{
  /**
   * Obtener un valor
   * 
   * @param String $key Llave
   * @param Closure $filler Función de relleno sino existe
   * @param Closure $cast Función de conversión
   */
  public static function get(String $key, $filler, $cast)
  {
    $applyCast = true;
    if (!$value = Redis::get($key)) {
      $applyCast = false;
      $value = $filler();
      Redis::set($key, $value);
    }

    return $cast && $applyCast ? $cast($value) : $value;
  }

  /**
   * Limpiar valores
   * 
   * @param Array $keys Llaves
   */
  public static function clear(Array $keys)
  {
    $prefix = config('database.redis.options.prefix');
    foreach ($keys as $key) {
      $__keys = array_map(function ($k) use ($prefix){
        return str_replace($prefix, '', $k);
      }, Redis::keys($key));
      if($__keys)
        Redis::del($__keys);
    }
  }

}
