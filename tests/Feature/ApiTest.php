<?php

namespace Tests\Feature;

use App\Models\Candidato;
use Tests\TestCase;

class ApiTest extends TestCase
{

  /**
   * Generar access token
   * @param bool $manager true si es manager sino agent
   */
  private function authReq($manager = true) {
    $req = $this->post('/api/auth', [
      'username' => $manager ? 'tester' : 'tester2',
      'password' => '123'
    ]);
    return [$req, $req->json()['data']['token']];
  }

  public function test_generar_access_token()
  {
    [$response] = $this->authReq();

    $response->assertStatus(200);
  }

  /**
   * Crear candidato
   */
  public function test_crear_candidato(){
    [$_, $accessToken] = $this->authReq();
    $response = $this->withHeaders([
      'Authorization' => 'Bearer ' . $accessToken,
    ])->post('/api/lead', [
      'name' => 'Mi candidato',
      'source' => 'Fotocasa',
      'owner' => 2
    ]);

    $response->assertStatus(201);
  }

  /**
   * Para obtener un candidato con un id en concreto
   */
  public function test_obtener_candidato_con_id(){
    [$_, $accessToken] = $this->authReq(false);
    $response = $this->withHeaders([
      'Authorization' => 'Bearer ' . $accessToken,
    ])->get('/api/lead/1');

    $response->assertStatus(200);
  }

  /**
   * Obtener candidatos por agente
   */
  public function test_obtener_candidatos_agente(){
    [$_, $accessToken] = $this->authReq(false);
    $response = $this->withHeaders([
      'Authorization' => 'Bearer ' . $accessToken,
    ])->get('/api/leads');

    $response
      ->assertStatus(200)
      ->assertJsonCount(Candidato::where('owner', 2)->count(), 'data')
    ;
  }

  /**
   * Obtener candidatos por manager
   */
  public function test_obtener_candidatos_manager(){
    [$_, $accessToken] = $this->authReq();
    $response = $this->withHeaders([
      'Authorization' => 'Bearer ' . $accessToken,
    ])->get('/api/leads');

    $response
      ->assertStatus(200)
      ->assertJsonCount(Candidato::count(), 'data')
    ;
  }

}
