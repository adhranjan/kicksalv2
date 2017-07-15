<?php

use App\BookTime;
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
       $roles=['App Developer'=>'developer','App Owner'=>'kicksal_owners','App Staffs'=>'kicksal_staffs','Futsal Admin'=>'futsal_admin','Futsal Owner'=>'futsal_owners','Futsal Staffs'=>'futsal_staffs','Mobile Users'=>'users'];
        foreach ($roles as $index=>$role){
            \App\Role::create([
                'name'=>$role,
                'display_name'=>$index,
            ]);
        }
        // create roles

        $permissions=['Manage Futsal'=>'manage-futsal','Manage My Futsal'=>'manage-my-futsal'];
        foreach ($permissions as $index=>$permission){
            \App\Permission::create([
                'name'=>$permission,
                'display_name'=>$index,
            ]);
        } // create permissions

        $user=\App\User::create([
            'name'=>'Ranjan Adhikari',
            'email'=>'adh.ranjan@gmail.com',
            'password'=>bcrypt('password'),
        ]); // create user
        $kicksal_owners=\App\Role::find(2);
        $user->attachRole($kicksal_owners); // make that user as kicksal owner



        $futsalCRUD=\App\Permission::find(1); // manage futsal
        $kicksal_owners->attachPermission($futsalCRUD); // kicksal owner can manage futsal


        $futsal_admin=\App\Role::find(4); // Futsal admin
        $manage_my_futsal=\App\Permission::find(2);  // manage my futsal
        $futsal_admin->attachPermission($manage_my_futsal); // futsal admin can manage his futsal


        $bookingTimes=[['05:00','06:00'],['06:00','07:00'],['07:00','08:00'],['09:00','10:00'],['10:00','11:00'],['11:00','12:00'],['12:00','13:00'],['13:00','14:00'],['14:00','15:00'],['15:00','16:00'],['16:00','17:00'],['17:00','18:00'],['18:00','19:00'],['19:00','20:00'],['20:00','21:00']];
        foreach ($bookingTimes as $bookingTime){
            BookTime::create([
                'time'=>$bookingTime[0].'-'.$bookingTime[1],
            ]);
        }

        $Payments=[['E-sewa','esewa.com'],['Bank','bank.com']];
        foreach ($Payments as $payment){
            \App\PaymentGateway::create([
                'name'=>$payment[0],
                'api_url'=>$payment[1],
            ]);
        }
    }
}
