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
       if(DB::table('users')->get()->count() == 0){

             DB::table('users')->insert(

                 [
                     'uniqueid' => 'IDs5s61stbozCuMPACuPQCRaUAJHSo',
                     'password' => bcrypt('testtest'),
                     'username'=> 'johndoe',
                     'mnemonic'=>'support bring step energy joy art thick dad couple again glory yeahhorrible want eye flower figure',
                     'balance'=>1000000000,
                     'pin'=>123456,
                     'vendor'=>true,
                     'admin'=>true,
                     'verified'=>true,
                     'created_at' => date('Y-m-d H:i:s'),
                     'updated_at' => date('Y-m-d H:i:s'),
                 ]);

         } else { echo "\e[31mTable is not empty, therefore NOT (users)"; }

         if(DB::table('settings')->get()->count() == 0){

               DB::table('settings')->insert(

                   [
                        'fee'=>1,
                       'vendor_price' => 1000000,
                       'created_at' => date('Y-m-d H:i:s'),
                       'updated_at' => date('Y-m-d H:i:s'),
                   ]);

           } else { echo "\e[31mTable is not empty, therefore NOT (settings)"; }

     }
}
