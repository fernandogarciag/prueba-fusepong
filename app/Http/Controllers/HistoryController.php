<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $myCompany = User::findOrFail(Auth::id())->company_id;
      $histories = History::select('histories.id', 'histories.name as historyName', 'users.name as userName')
      ->join("users", 'histories.user_id', "users.id")
      ->where('users.company_id', $myCompany)
      ->get()->toArray();
      $data = array(
        'title' => "Historias",
        'errors' => array(),
        'histories' => $histories,
      );
      return view('react', [
        'errors_name' => array(),
        'nameJS' => "history/index",
        'data' => $data
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $data = array(
        'title' => "Crear Nueva Historia",
        'errors' => array(),
        'history' => array('name' => ""),
      );
      return view('react', [
        'errors_name' => array('name'),
        'nameJS' => "history/create-edit",
        'data' => $data
      ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      Validator::make($request->all(), array(
        'name' => ['required', 'string', 'max:255']
      ));
      History::create([
        'user_id' => Auth::id(),
        'name' => $request->input('name'),
      ]);
      return redirect()->route('histories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $history = History::select('histories.id', 'histories.name as historyName', 'users.name as userName', 'users.email as userEmail')
      ->join("users", 'histories.user_id', "users.id")
      ->where('histories.id', $id)
      ->firstOrFail()->toArray();
      $data = array(
        'title' => $history["historyName"] . " - Historia - Información",
        'errors' => array(),
        'history' => $history,
      );
      return view('react', [
        'errors_name' => array(),
        'nameJS' => "history/show",
        'data' => $data
      ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(History $history)
    {
      $data = array(
        'title' => $history->name . " - Historia - Editar",
        'errors' => array(),
        'history' => $history->toArray(),
      );
      return view('react', [
        'errors_name' => array('name'),
        'nameJS' => "history/create-edit",
        'data' => $data
      ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, History $history)
    {
      $history->name = $request->input('name');
      $history->save();
      return redirect()->route('histories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(History $history)
    {
      $history->delete();
      return redirect()->route('histories.index');
    }
}
