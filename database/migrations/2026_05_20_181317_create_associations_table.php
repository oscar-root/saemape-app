<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // database/migrations/xxxx_create_associations_table.php
public function up(): void
{
    Schema::create('associations', function (Blueprint $table) {
        $table->id();
        $table->string('num_rccm')->unique(); // NumRCCM: Int dans le diagramme, mais String pour le format RDC
        $table->string('raison_sociale');     // RaisonSociale: Varchar
        $table->date('date_creation');        // DateCreation: Date
        
        // Relation 1-to-1 avec le Délégué (Représenter)
        $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
        
        $table->string('statut')->default('en_attente'); 
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('associations');
    }
};
