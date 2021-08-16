<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Http\Response;

class LoginController extends Controller
{
  public function index()
  {
    if (Auth::check()) {
      return redirect()->route('histories.index');
    } else {
      return redirect()->route('login');
    }
  }
  public function showLoginForm()
  {
    $data = array(
      'title' => "Log In",
      'errors' => array(),
    );
    return view('react', [
      'errors_name' => array('email', 'password', 'remember'),
      'nameJS' => "login",
      'data' => $data
    ]);
  }
}
