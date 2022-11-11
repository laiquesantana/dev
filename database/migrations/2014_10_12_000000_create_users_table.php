<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('photo')->default('profile.png');
            $table->enum('tipo', ['admin', 'default', 'gerente'])->nullable();
            $table->string('email')->unique();
            $table->string('cpf', 11)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->unsignedBigInteger('tenant_id')->default(1)->index();
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
}
