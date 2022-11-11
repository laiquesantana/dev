<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => \Str::orderedUuid(),
            'name' => 'Adminstrador Geral',
            'email' => 'laiquesantana@gmail.com',
            'cpf' => '06001814562',
            'password' => Hash::make('adminsgs'),
            'tenant_id' => 1,
            'tipo' => 'admin',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()

        ]);

        $user= User::first();
        $user->assignRole('superAdmin');
    }
}
