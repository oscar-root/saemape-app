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
    Schema::create('declarations', function (Blueprint $table) {
        $table->id();
        // Relation avec l'association (Une association a plusieurs déclarations)
        $table->foreignId('association_id')->constrained()->onDelete('cascade');
        
        // Attributs du diagramme page 36
        $table->string('qualite_minerai');    // Ex: Cuivre, Cobalt, Cassitérite
        $table->double('quantite_produite');  // En tonnes ou Kg
        $table->double('tennaire');           // Teneur (concentration)
        $table->string('localite');           // Site d'extraction
        
        // Finances (Lié à la mission du Caissier/Agent)
        $table->decimal('montant_cotisation', 15, 2)->default(0);
        $table->date('date_paiement')->nullable();
        
        $table->string('statut')->default('en_attente'); // en_attente, validé (par ABT)
        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('declarations');
    }
};
