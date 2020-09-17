<?php namespace Modules\Productos\Database\Seeders; 
 
use Illuminate\Database\Seeder; 
use Illuminate\Database\Eloquent\Model; 
use DB; 
use Faker\Factory as Faker; 
 
class ProductosCategoriasTableSeeder extends Seeder { 
 
  /** 
   * Run the database seeds. 
   * 
   * @return void 
   */ 
  public function run() 
  { 
    Model::unguard(); 
     
    $faker = Faker::create(); 
     
    for ($i=0; $i < 50; $i++)  
    { 
      DB::table('productos__categoriaproductos')->insert([ 
      'codigo'=> $faker->unique()->userName, 
      'nombre'=> $faker->unique()->domainWord , 
      'descripcion'=> $faker->catchPhrase, 
   
      ]); 
    } 
  } 
 
}