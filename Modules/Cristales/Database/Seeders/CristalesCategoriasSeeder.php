<?php namespace Modules\Cristales\Database\Seeders; 
 
use Illuminate\Database\Seeder; 
use Illuminate\Database\Eloquent\Model; 
use DB; 
 
class CristalesCategoriasSeeder extends Seeder { 
 
  /** 
   * Run the database seeds. 
   * 
   * @return void 
   */ 
  public function run() 
  { 
    Model::unguard(); 
     
    DB::table('cristales__categoriacristales')->insert(['id'=> '3', 
    'nombre'=> 'Monofocal',//id 3 
    ]); 
 
    DB::table('cristales__categoriacristales')->insert(['id'=> '2', 
    'nombre'=> 'Bifocal',//id 2 
    ]); 
 
    DB::table('cristales__categoriacristales')->insert(['id'=> '1', 
    'nombre'=> 'Multifocal',//id 1 
    ]); 
  } 
 
}