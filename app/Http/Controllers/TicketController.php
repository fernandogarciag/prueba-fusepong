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
      $tickets = $history->tickets->toArray();
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
        'ticket' => array('name' => "", 'state' => ""),
      );
      return view('react', [
        'errors_name' => array('name', 'state'),
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
      $this->validator($request->all())->validate();
      Ticket::create([
        'history_id' => $history->id,
        'name' => $request->input('name'),
        'state' => $request->input('state')
      ]);
      return redirect()->route('tickets.index', ['project' => $project->id, 'history' => $history->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project, History $history, Ticket $ticket)
    {
      $deleteHistory = count($history->tickets->toArray()) === 1;
      $data = array(
        'title' => $ticket["name"] . " - Tiquete - Información - " . $project->name . " - " . $history->name,
        'errors' => array(),
        'project' => $project->toArray(),
        'history' => $history->toArray(),
        'ticket' => $ticket->toArray(),
        'deleteHistory' => $deleteHistory
      );
      return view('react', [
        'errors_name' => array(),
        'nameJS' => "ticket/show",
        'data' => $data
      ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project, History $history, Ticket $ticket)
    {
      $data = array(
        'title' => $ticket["name"] . " - Tiquete - Editar - " . $project->name . " - " . $history->name,
        'errors' => array(),
        'project' => $project->toArray(),
        'history' => $history->toArray(),
        'ticket' => $ticket->toArray(),
      );
      return view('react', [
        'errors_name' => array('name', 'state'),
        'nameJS' => "ticket/create-edit",
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
    public function update(Request $request, Project $project, History $history, Ticket $ticket)
    {
      $this->validator($request->all())->validate();
      $ticket->name = $request->input('name');
      $ticket->state = $request->input('state');
      $ticket->save();
      return redirect()->route('tickets.index', ['project' => $project->id, 'history' => $history->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project, History $history, Ticket $ticket)
    {
      $deleteHistory = count($history->tickets->toArray()) === 1;
      if ($deleteHistory) {
        $history->delete();
        return redirect()->route('histories.index', ['project' => $project->id]);
      } else {
        $ticket->delete();
        return redirect()->route('tickets.index', ['project' => $project->id, 'history' => $history->id]);
      }
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
      return Validator::make($data, [
        'name' => ['required', 'string', 'max:255'],
        'state' => ['required', 'integer'],
      ]);
    }
}
