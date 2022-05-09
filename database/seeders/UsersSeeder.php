<?php

namespace Database\Seeders;

use App\Modules\Admin\Models\Admin;
use App\Modules\Employee\Models\Employee;
use App\Modules\User\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'Admin';
        $user->email = 'admin@admin.com';
        $user->password = bcrypt('123456');
        $user->save();

        $admin = new Admin();
        $admin->role = 'admin';
        $admin->user()->associate($user);
        $admin->save();


    }
}
