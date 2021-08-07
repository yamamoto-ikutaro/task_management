<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'=>'鈴木一郎',
            'email'=>'yamamoto.sxbx37@gmail.com',
            'password'=>'b113k276t',
        ]);
        DB::table('users')->insert([
            'name'=>'鈴木二郎',
            'email'=>'iyamamoto.sxbx37@gmail.com',
            'password'=>'b113k276t',
        ]);
        DB::table('users')->insert([
            'name'=>'鈴木三郎',
            'email'=>'iiyamamoto.sxbx37@gmail.com',
            'password'=>'b113k276t',
        ]);
        DB::table('users')->insert([
            'name'=>'鈴木四郎',
            'email'=>'iiiyamamoto.sxbx37@gmail.com',
            'password'=>'b113k276t',
        ]);
        DB::table('users')->insert([
            'name'=>'鈴木五郎',
            'email'=>'iiiiyamamoto.sxbx37@gmail.com',
            'password'=>'b113k276t',
        ]);
        DB::table('users')->insert([
            'name'=>'鈴木六郎',
            'email'=>'iiiiiyamamoto.sxbx37@gmail.com',
            'password'=>'b113k276t',
        ]);
        DB::table('users')->insert([
            'name'=>'山本太郎',
            'email'=>'yamamoto@gmail.com',
            'password'=>'b113k276t',
        ]);
    }
}
