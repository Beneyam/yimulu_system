<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
//use Illuminate\Support\Facades\Facade\DB;
use Illuminate\Support\Facades\Hash;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
       // Role::truncate();
        DB::table('role_user')->truncate();
        $yimulu_sales_manager_role = Role::where('name','yimulu_salesManager')->first();
        $transaction_manager_role = Role::where('name','Transaction Manager')->first();
        $agent_manager_role = Role::where('name','Agent Manager')->first();
        $system_viewer_role = Role::where('name','System Viewer')->first();
        $agent_role = Role::where('name','Agent')->first();

        $yimulu_sales=User::create([
            'name'=>'yimulu_salesManager',
            'email'=>'yimulu_sales@admin.com',
            'phone_number'=>'0973111472',
            'password'=>Hash::make('sami@123'),
            'address'=>'Addis Ababa, Wosen Area',
        ]);
        $agent_manager=User::create([
            'name'=>'Agent Manager',
            'email'=>'agent_manager@admin.com',
            'phone_number'=>'0973111474',
            'password'=>Hash::make('sami@123'),
            'address'=>'Addis Ababa, Wosen Area',
        ]);
        $tran=User::create([
            'name'=>'Transaction Manager',
            'email'=>'tran_manager@admin.com',
            'phone_number'=>'0973111475',
            'password'=>Hash::make('sami@123'),
            'address'=>'Addis Ababa, Wosen Area',
        ]);
        $system=User::create([
            'name'=>'System Viewer',
            'email'=>'system@admin.com',
            'phone_number'=>'0973111476',
            'password'=>Hash::make('sami@123'),
            'address'=>'Addis Ababa, Wosen Area',
        ]);
        $agent=User::create([
            'name'=>'Agent',
            'email'=>'agent@admin.com',
            'phone_number'=>'0973111477',
            'password'=>Hash::make('sami@123'),
            'address'=>'Addis Ababa, Wosen Area',
        ]);

        $yimulu_sales->roles()->attach($yimulu_sales_manager_role);
        $tran->roles()->attach($transaction_manager_role);
        $agent_manager->roles()->attach($agent_manager_role);
        
        $system->roles()->attach($system_viewer_role);
        $agent->roles()->attach($agent_role);
    }
}
