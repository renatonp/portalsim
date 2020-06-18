<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCpfToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->char('cpf', 15)->after('password')->unique();
            $table->char('celphone', 15)->after('cpf');
            $table->char('phone', 15)->after('celphone');
            $table->date('birthdate')->after('phone')->nullable();
            $table->enum('sex',['M', 'F'])->after('birthdate');
            $table->char('voterstitle', 20)->after('sex')->nullable();
            $table->string('mothersname')->after('voterstitle');
            $table->char('cep', 10)->after('mothersname');
            $table->char('uf', 2)->after('cep');
            $table->string('city')->after('uf');
            $table->string('district')->after('city');
            $table->string('address')->after('district');
            $table->char('number', 20)->after('address');
            $table->string('complement')->after('number')->nullable();

            $table->index('birthdate');
            $table->index('sex');
            $table->index('cep');
            $table->index('uf');
            $table->index('city');
            $table->index('district');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('sex');
            $table->dropColumn('birthdate');
            $table->dropColumn('phone');
            $table->dropColumn('celphone');
            $table->dropColumn('cpf');
            $table->dropColumn('voterstitle');
            $table->dropColumn('mothersname');
            $table->dropColumn('cep');
            $table->dropColumn('uf');
            $table->dropColumn('city');
            $table->dropColumn('district');
            $table->dropColumn('address');
            $table->dropColumn('number');
            $table->dropColumn('complement');            
        });
    }
}
