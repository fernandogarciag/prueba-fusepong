<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder
{
  private $states_array = array(
    'Activo',
    'Desarrollo',
    'Terminado'
  );

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    foreach ($this->states_array as $state) {
      State::insert([
        'name' => $state,
      ]);
    }
  }
}
