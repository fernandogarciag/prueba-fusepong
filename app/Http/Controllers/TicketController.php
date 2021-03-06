<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\History;
use App\Models\Project;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
      $idTicket = Ticket::create([
        'history_id' => $history->id,
        'name' => $request->input('name'),
        'state' => $request->input('state')
      ])->id;
      Comment::create([
        'ticket_id' => $idTicket,
        'user_id' => Auth::id(),
        'content' => 'Cre?? este tickete'
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
      $comments = Comment::select('comments.id', 'comments.content', 'users.name', 'comments.updated_at')
      ->join("users", 'comments.user_id', "users.id")
      ->orderByDesc('comments.id')
      ->where('ticket_id', $ticket->id)
      ->get()->toArray();
      $data = array(
        'title' => $ticket["name"] . " - Tiquete - Informaci??n - " . $project->name . " - " . $history->name,
        'errors' => array(),
        'project' => $project->toArray(),
        'history' => $history->toArray(),
        'ticket' => $ticket->toArray(),
        'deleteHistory' => $deleteHistory,
        'comments' => $comments
      );
      return view('react', [
        'errors_name' => array('content'),
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
      if ($ticket->name != $request->input('name')) {
        Comment::create([
          'ticket_id' => $ticket->id,
          'user_id' => Auth::id(),
          'content' => 'Cambie el nombre del tiquete de ' . $ticket->name . ' a ' . $request->input('name')
        ]);
        $ticket->name = $request->input('name');
      }
      if ($ticket->state != $request->input('state')) {
        $stateName = array(
          1 => 'Activo',
          2 => 'En Proceso',
          3 => 'Terminado'
        );
        Comment::create([
          'ticket_id' => $ticket->id,
          'user_id' => Auth::id(),
          'content' => 'Cambie el Estado del tiquete de ' . $stateName[$ticket->state] . ' a ' . $stateName[$request->input('state')]
        ]);
        $ticket->state = $request->input('state');
      }
      $ticket->save();
      return redirect()->route('tickets.show', ['project' => $project->id, 'history' => $history->id, 'ticket'=> $ticket->id]);
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
      ], array(
        'state.integer' => 'Es necesario escoger un estado.',
      ));
    }
}
