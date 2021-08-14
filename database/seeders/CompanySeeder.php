<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\History;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CompanySeeder extends Seeder
{
  private $companies_array = array(
    array(
      'Apple',
      array(
        array(
          'Iphone 13',
          array(
            array(
              'Nueva pantalla',
              'Descripción de Apple con Iphone 13 y Nueva pantalla',
              '2'
            ),
            array(
              'Nuevas aplicaciones',
              'Descripción de Apple con Iphone 13 y Nuevas aplicaciones',
              '2'
            ),
            array(
              'Nueva cámara',
              'Descripción de Apple con Iphone 13 y Nueva cámara',
              '3'
            ),
            array(
              'Nueva batería',
              'Descripción de Apple con Iphone 13 y Nuevaa batería',
              '3'
            ),
          ),
        )
      )
    ),
    array(
      'Samsung',
      array(
        array(
          'Galaxy Node 21',
          array(
            array(
              'Nueva pantalla',
              'Descripción de Samsung con Galaxy Node 21 y Nueva pantalla',
              '2'
            ),
            array(
              'Nuevas aplicaciones',
              'Descripción de Samsung con Galaxy Node 21 y Nuevas aplicaciones',
              '2'
            ),
            array(
              'Nueva cámara',
              'Descripción de Samsung con Galaxy Node 21 y Nueva cámara',
              '3'
            ),
            array(
              'Nuevaa batería',
              'Descripción de Samsung con Galaxy Node 21 y Nuevaa batería',
              '3'
            ),
          ),
        ),
        array(
          'Galaxy Node 11',
          array(
            array(
              'Nueva pantalla',
              'Descripción de Samsung con Galaxy Node 11 y Nueva pantalla',
              '2'
            ),
            array(
              'Nuevas aplicaciones',
              'Descripción de Samsung con Galaxy Node 11 y Nuevas aplicaciones',
              '2'
            ),
            array(
              'Nueva cámara',
              'Descripción de Samsung con Galaxy Node 21 y Nueva cámara',
              '3'
            ),
            array(
              'Nuevaa batería',
              'Descripción de Samsung con Galaxy Node 21 y Nuevaa batería',
              '3'
            ),
          ),
        )
      )
    ),
    array(
      'Xiaomi',
      array(
        array(
          'Mi 12',
          array(
            array(
              'Nueva pantalla',
              'Descripción de Xiaomi con Mi 12 y Nueva pantalla',
              '2'
            ),
            array(
              'Nuevas aplicaciones',
              'Descripción de Xiaomi con Mi 12 y Nuevas aplicaciones',
              '2'
            ),
            array(
              'Nueva cámara',
              'Descripción de Samsung con Galaxy Node 21 y Nueva cámara',
              '3'
            ),
            array(
              'Nuevaa batería',
              'Descripción de Samsung con Galaxy Node 21 y Nuevaa batería',
              '3'
            ),
          ),
        ),
        array(
          'Redmi Note 11',
          array(
            array(
              'Nueva pantalla',
              'Descripción de Xiaomi con Redmi Note 11 y Nueva pantalla',
              '2'
            ),
            array(
              'Nuevas aplicaciones',
              'Descripción de Xiaomi con Redmi Note 11 y Nuevas aplicaciones',
              '2'
            ),
            array(
              'Nueva cámara',
              'Descripción de Samsung con Galaxy Node 21 y Nueva cámara',
              '3'
            ),
            array(
              'Nuevaa batería',
              'Descripción de Samsung con Galaxy Node 21 y Nuevaa batería',
              '3'
            ),
          ),
        )
      )
    )
  );

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    foreach ($this->companies_array as $company) {
      $idCompany = Company::create([
        'name' => $company[0],
        'nit' => rand(1000, 9999),
        'phone' => rand(100000000, 9999999999),
        'address' => 'Calle ' . rand(10, 99) . ' # ' . rand(10, 99) . ' - ' . rand(10, 99),
        'email' => $company[0].'@gmail.com',
      ])->id;
      $userId = User::create([
        'name' => $company[0],
        'email' => $company[0].'@gmail.com',
        'password' => Hash::make('123456789'),
        'company_id' => $idCompany
      ])->id;
      foreach ($company[1] as $history) {
        $idHistory = History::create([
          'user_id' => $userId,
          'name' => $history[0],
        ])->id;
        foreach ($history[1] as $task) {
          Ticket::create([
            'history_id' => $idHistory,
            'name' => $task[0],
            'description' => $task[1],
            'state_id' => $task[2],
          ]);
        }
      }
    }
  }
}
