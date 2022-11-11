<?php
namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tenants')->insert([
            'name' => 'Main Application',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
