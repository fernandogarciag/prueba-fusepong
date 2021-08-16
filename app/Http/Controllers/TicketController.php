<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Project;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project, History $history)
    {
      $tickets = Ticket::where('history_id', $history->id)->get()->toArray();
      $data = array(
        'title' => "Ticketes - " . $project->name . " - " . $history->name,
        'errors' => array(),
        'project' => $project->toArray(),
        'history' => $history->toArray(),
        'tickets' => $tickets,
      );
      return view('react', [
        'errors_name' => array(),
        'nameJS' => "ticket/index",
        'data' => $data
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project, History $history)
    {
      $data = array(
        'title' => "Crear Nuevo Tickete - " . $project->name . " - " . $history->name,
        'errors' => array(),
        'project' => $project->toArray(),
        'history' => $history->toArray(),
        'ticket' => array('name' => ""),
      );
      return view('react', [
        'errors_name' => array('name'),
        'nameJS' => "ticket/create-edit",
        'data' => $data
      ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Project $project, History $history)
    {
      Validator::make($request->all(), array(
        'name' => ['required', 'string', 'max:255']
      ));
      History::create([
        'history_id' => $history->name,
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
