<?php

use App\Models\User;
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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id');
            $table->increments('transaction_id');
            $table->string('nom_expediteur');
            $table->string('prenom_expediteur');
            $table->string('telephone_expediteur');
            $table->string('ville_origine');
            $table->string('ville_destinataire');
            $table->string('nom_beneficiaire');
            $table->string('prenom_beneficiaire');
            $table->string('telephone_beneficiaire');
            $table->string('code_retrait')->unique();
            $table->integer('montant');
            $table->tinyInteger('etat');
            $table->datetime('date_retrait')->nullable();
            $table->datetime('date_transfert');
            $table->foreignIdFor(User::class, 'user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
