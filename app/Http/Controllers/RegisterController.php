<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
  public function showRegistrationForm()
  {
    $companies = Company::select('id', 'name')->get()->toArray();
    $data = array(
      'title' => "Registro",
      'errors' => array(),
      'companies' => $companies,
    );
    return view('react', [
      'errors_name' => array('name', 'email', 'company', 'password'),
      'nameJS' => "register",
      'data' => $data
    ]);
  }

  public function register(Request $request)
  {
    // dd("paso");
    $this->validator($request->all())->validate();
    event(new Registered($user = $this->create($request->all())));
    $this->guard()->login($user);
    if ($response = $this->registered($request, $user)) {
        return $response;
    }
    return $request->wantsJson()
                ? new JsonResponse([], 201)
                : redirect($this->redirectPath());
  }

  protected function validator(array $data)
  {
    $rules = array(
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'company' => ['required', 'integer'],
      'password' => ['required', 'string', 'min:8', 'confirmed'],
    );
    $messages = array(
      'company.integer' => 'Es necesario escoger una compañía.',
    );
    return Validator::make($data, $rules, $messages);
  }
  
  protected function guard()
  {
    return Auth::guard();
  }

  protected function create(array $data)
  {
      return User::create([
          'name' => $data['name'],
          'email' => $data['email'],
          'password' => Hash::make($data['password']),
          'company_id' => $data['company']
      ]);
  }
  
  protected function registered(Request $request, $user)
  {
      //
  }
}
