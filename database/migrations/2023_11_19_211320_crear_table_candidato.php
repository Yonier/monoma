<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('candidato', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('source');
      $table->foreignId('owner')->constrained(
        table: 'usuario',
        indexName: 'candidato_owner_user_id'
      );
      $table->timestamp('updated_at')->useCurrent();
      $table->timestamp('created_at')->useCurrent();
      $table->foreignId('created_by')->constrained(
        table: 'usuario',
        indexName: 'candidato_created_by_user_id'
      );
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('candidato');
  }
};
