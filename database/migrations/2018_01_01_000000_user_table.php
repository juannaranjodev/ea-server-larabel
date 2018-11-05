<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class UserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->index()->unsigned();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role',['admin', 'member'])->default('member');
            $table->boolean('is_allowed')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
        });
        // insert admin
        DB::table('users')->insert(
            array(
                'email' => 'schuttendennis@gmail.com',
                'name' => 'admin',
                'password' => bcrypt('123456'),//password
                'role' => 'admin',
                'is_allowed' => true,
            )
        );
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_resets');
    }
}