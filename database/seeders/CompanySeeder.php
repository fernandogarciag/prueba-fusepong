<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Company;
use App\Models\History;
use App\Models\Project;
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
          'Iphone 13',
          'Iphone SE 2',
      )
    ),
    array(
      'Samsung',
      array(
          'Galaxy Node 21',
          'Galaxy Z Flip 4',
      )
    ),
    array(
      'Xiaomi',
      array(
          'Mi 12',
          'Redmi Note 11',
        )
      )
  );

  private $histories_array = array(
    array(
      'Mejorar la pantalla',
      array(
        array(
          'Mejorando reconocimiendo dactilar',
          '2'
        ),
        array(
          'Mejorando dureza',
          '2'
        ),
        array(
          'Buscando mejores materiales',
          '3'
        ),
        array(
          'Mejorando sistema tactil',
          '3'
        ),
      )
    ),
    array(
      'Mejorar la camara',
      array(
        array(
          'Mejorando detección de gestos',
          '2'
        ),
        array(
          'Mejorando campo de visión',
          '2'
        ),
        array(
          'Mejorando dureza',
          '3'
        ),
        array(
          'Buscando mejores materiales',
          '3'
        ),
      )
    ),
    array(
      'Mejorar la bateria',
      array(
        array(
          'Mejorando ciclos',
          '2'
        ),
        array(
          'Mejorando duración',
          '2'
        ),
        array(
          'Buscando mejores materiales',
          '3'
        ),
        array(
          'Mejorando temperatura máxima',
          '3'
        ),
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
      foreach ($company[1] as $project) {
        $idProject = Project::create([
          'company_id' => $idCompany,
          'name' => $project,
        ])->id;
        foreach ($this->histories_array as $history) {
          $idHistory = History::create([
            'project_id' => $idProject,
            'user_id' => $userId,
            'name' => $history[0],
          ])->id;
          foreach ($history[1] as $task) {
            $idTicket = Ticket::create([
              'history_id' => $idHistory,
              'name' => $task[0],
              'state' => $task[1],
            ])->id;
            for ($i = 1; $i <= 3; $i++) { 
              Comment::create([
                'ticket_id' => $idTicket,
                'user_id' => $userId,
                'content' => "Comentario número " . $i,
              ]);
            }
          }
        }
      }
    }
  }
}
