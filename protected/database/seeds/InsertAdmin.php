<?php

use Illuminate\Database\Seeder;

class InsertAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin')->insert([
        	'username'     => 'trieunn',
        	'password'     => bcrypt('123456'),
        	'email'        => 'trieu.nguyennhu@gmail.com',
        	'fullname'     => 'Administrator',
        	'role_id'      => '1'
        ]);
    }
}
