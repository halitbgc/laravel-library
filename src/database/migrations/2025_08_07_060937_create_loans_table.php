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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
    
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
    
            $table->timestamp('borrowed_at')->nullable(); // kitabin teslim alindigi tarih
            $table->timestamp('due_date'); // kitabin teslim edilmesi gereken tarih
            $table->timestamp('returned_at')->nullable(); // kitabin teslim edildigi tarih
            
            $table->foreignId('approved_by')->nullable(); // user id of the librarian who approved the loan request
            $table->timestamp('approved_at')->nullable(); // loan request approved date
            
            $table->enum('status', ['pending', 'approved', 'rejected', 'returned', 'borrowed'])->default('pending');

            $table->timestamps();
        });
    }   

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
