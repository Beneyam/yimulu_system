<?php

use Illuminate\Database\Seeder;
use App\Role;
class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Role::truncate();
        Role::create(['name'=>'yimulu_salesManager']);
        Role::create(['name'=>'Transaction Manager']);
        Role::create(['name'=>'Agent Manager']);
        Role::create(['name'=>'System Viewer']);
        Role::create(['name'=>'Agent']);

    }
}
