<?php namespace Modules\Cristales\Database\Seeders; 
 
use Illuminate\Database\Seeder; 
use Illuminate\Database\Eloquent\Model; 
use DB; 
use Faker\Factory as Faker; 
 
class CristalesCristalesSeeder extends Seeder { 
 
  /** 
   * Run the database seeds. 
   * 
   * @return void 
   */ 
  public function run() 
  { 
    Model::unguard(); 
 
    //multifocal: Blanco ESF, Blanco CIL, Fotocromatico Esferico, Fotocromatico Cilindrico, Anti Reflex, Fotocromatico Antireflex 
 
    DB::table('cristales__cristales')->insert([ 
    'nombre'=> 'Blanco ESF', 
    'categoria_cristal_id' => '1' 
    ]); 
 
    DB::table('cristales__cristales')->insert([ 
    'nombre'=> 'Blanco CIL', 
    'categoria_cristal_id' => '1' 
    ]); 
 
    DB::table('cristales__cristales')->insert([ 
    'nombre'=> 'Fotocromatico Esferico', 
    'categoria_cristal_id' => '1' 
    ]); 
 
    DB::table('cristales__cristales')->insert([ 
    'nombre'=> 'Fotocromatico Cilindrico', 
    'categoria_cristal_id' => '1' 
    ]); 
 
    DB::table('cristales__cristales')->insert([ 
    'nombre'=> 'Anti Reflex', 
    'categoria_cristal_id' => '1' 
    ]); 
 
    DB::table('cristales__cristales')->insert([ 
    'nombre'=> 'Fotocromatico Antireflex', 
    'categoria_cristal_id' => '1' 
    ]); 
 
    //bifocal: Blanco ESF, Blanco CIL, Fotocromatico Esferico, Fotocromatico Cilindrico, Anti Reflex, Fotocromatico Antireflex 
 
    DB::table('cristales__cristales')->insert([ 
    'nombre'=> 'Blanco ESF', 
    'categoria_cristal_id' => '2' 
    ]); 
 
    DB::table('cristales__cristales')->insert([ 
    'nombre'=> 'Blanco CIL', 
    'categoria_cristal_id' => '2' 
    ]); 
 
    DB::table('cristales__cristales')->insert([ 
    'nombre'=> 'Fotocromatico Esferico', 
    'categoria_cristal_id' => '2' 
    ]); 
 
    DB::table('cristales__cristales')->insert([ 
    'nombre'=> 'Fotocromatico Cilindrico', 
    'categoria_cristal_id' => '2' 
    ]); 
 
    DB::table('cristales__cristales')->insert([ 
    'nombre'=> 'Anti Reflex', 
    'categoria_cristal_id' => '2' 
    ]); 
 
    DB::table('cristales__cristales')->insert([ 
    'nombre'=> 'Fotocromatico Antireflex', 
    'categoria_cristal_id' => '2' 
    ]); 
 
    //monofocal: Blanco, A.R. ,Poly ,Poly A.R., Foto  
 
    DB::table('cristales__cristales')->insert([ 
    'nombre'=> 'Blanco', 
    'categoria_cristal_id' => '3' 
    ]); 
 
    DB::table('cristales__cristales')->insert([ 
    'nombre'=> 'A.R.', 
    'categoria_cristal_id' => '3' 
    ]); 
 
    DB::table('cristales__cristales')->insert([ 
    'nombre'=> 'Poly', 
    'categoria_cristal_id' => '3' 
    ]); 
 
    DB::table('cristales__cristales')->insert([ 
    'nombre'=> 'Poly A.R.', 
    'categoria_cristal_id' => '3' 
    ]); 
 
    DB::table('cristales__cristales')->insert([ 
    'nombre'=> 'Foto', 
    'categoria_cristal_id' => '3' 
    ]); 
     
  } 
 
}
