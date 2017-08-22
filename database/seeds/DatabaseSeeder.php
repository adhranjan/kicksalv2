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
        $images=array('avatars'=>'d27ee45e19dd72f8b4fd4a49f983e1b5','futsals'=>'7f982e45f27edfbe19d4a493e4d518bd');
        foreach ($images as $index=>$image){
            \App\AppImageResource::create([
                'storage_path'=>$index.'/no_avatar.png',
                'image_id'=>$image,
            ]);
        }




       $roles=['App Developer'=>'developer_user','App Owner'=>'kicksal_owners','App Staffs'=>'kicksal_staffs','Futsal Admin'=>'futsal_admin','Futsal Owner'=>'futsal_owners','Futsal Staffs'=>'futsal_staffs','Player Users'=>'player_user'];
        foreach ($roles as $index=>$role){
            \App\Role::create([
                'name'=>$role,
                'display_name'=>$index,
            ]);
        }
        // create roles

        $permissions=['Manage Futsal'=>'manage-futsal','Manage My Futsal'=>'manage-my-futsal','Futsal Bills'=>'my-futsal-bills'];
        foreach ($permissions as $index=>$permission){
            \App\Permission::create([
                'name'=>$permission,
                'display_name'=>$index,
            ]);
        } // create permissions

        $user=\App\User::create([
            'name'=>'Ranjan Adhikari',
            'email'=>'ranjan_adhikari@hotmail.com',
            'password'=>bcrypt('password'),
            'api_token'=>str_random(60),
        ]);
        $user->kicksalOwnerProfile()->create([
            'phone'=>'9860097769',
            'gender'=>'1',
        ]);

        // create user
        $kicksal_owners=\App\Role::find(2);
        $user->attachRole($kicksal_owners); // make that user as kicksal owner



        $futsalCRUD=\App\Permission::find(1); // manage futsal
        $kicksal_owners->attachPermission($futsalCRUD); // kicksal owner can manage futsal


        $futsal_admin=\App\Role::find(4); // Futsal admin
        $manage_my_futsal=\App\Permission::where('name','like','%my-futsal%')->get();  // manage my futsal
        $futsal_admin->attachPermissions($manage_my_futsal); // futsal admin can manage his futsal


        $bookingTimes=[['05:00','06:00'],['06:00','07:00'],['07:00','08:00'],['09:00','10:00'],['10:00','11:00'],['11:00','12:00'],['12:00','13:00'],['13:00','14:00'],['14:00','15:00'],['15:00','16:00'],['16:00','17:00'],['17:00','18:00'],['18:00','19:00'],['19:00','20:00'],['20:00','21:00']];
        foreach ($bookingTimes as $bookingTime){
            BookTime::create([
                'start_time'=>$bookingTime[0],
                'end_time'=>$bookingTime[1],
            ]);
        }

        $Payments=[['E-sewa','esewa.com'],['Bank','bank.com'],['Ipay','ipay.com/api/v2']];
        foreach ($Payments as $payment){
            \App\PaymentGateway::create([
                'name'=>$payment[0],
                'api_url'=>$payment[1],
            ]);
        }

        $days = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
        foreach ($days as $day){
            \App\WeekDay::create([
                'day'=>$day,
            ]);
        }

    }
}
