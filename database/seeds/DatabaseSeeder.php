<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(UsersTableSeeder::class);
    }
}


// ruby test <
class UsersTableSeeder extends Seeder
{
  public function run()
  {
    App\User::truncate();
    factory(App\User::class)->create([
      'email' => 'super@ez.com',
      'password' => bcrypt('123456'),
      'name' => 'super',
    ]);
    factory(App\User::class)->create([
      'email' => 'admin@ez.com',
      'password' => bcrypt('123456'),
      'name' => 'approved',
    ]);
    factory(App\User::class)->create([
      'email' => 'user@ez.com',
      'password' => bcrypt('123456'),
      'name' => 'user',
    ]);
    $users = factory(App\User::class, 15)->create();

    /**
     * Seeding roles table
     */
    Bican\Roles\Models\Role::truncate();
    DB::table('role_user')->truncate();
    $superAdminRole = Bican\Roles\Models\Role::create([
      'name' => 'SuperAdmin',
      'slug' => 'superadmin'
    ]);
    $adminRole = Bican\Roles\Models\Role::create([
      'name' => 'Admin',
      'slug' => 'admin'
    ]);
    $userRole = Bican\Roles\Models\Role::create([
      'name' => 'User',
      'slug' => 'user'
    ]);


    App\User::whereEmail('super@ez.com')->get()->map(function ($user) use ($superAdminRole) {
      $user->attachRole($superAdminRole);
    });
    App\User::whereEmail('admin@ez.com')->get()->map(function ($user) use ($adminRole) {
      $user->attachRole($adminRole);
    });
    App\User::whereEmail('user@ez.com')->get()->map(function ($user) use ($userRole) {
      $user->attachRole($userRole);
    });

    // profiles
    $faker = Faker::create();

    App\Models\Profile::truncate();
    $users = App\User::all();
    $users->each(function ($user) use ($faker) {
      $user->profile()->save(
        factory(App\Models\Profile::class)->create()
      );
    });
  }
}

// ruby test >