<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\History;
use App\Models\Project;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request, Project $project, History $history, Ticket $ticket)
  {
    $this->validator($request->all())->validate();
    Comment::create([
      'ticket_id' => $ticket->id,
      'user_id' => Auth::id(),
      'content' => $request->input('content')
    ]);
    return redirect()->route('tickets.show', ['project' => $project->id, 'history' => $history->id, 'ticket' => $ticket]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(Project $project, History $history, Ticket $ticket, Comment $comment)
  {
    $comment->delete();
    return redirect()->route('tickets.show', ['project' => $project->id, 'history' => $history->id, 'ticket' => $ticket]);
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
      'content' => ['required', 'string', 'max:65000'],
    ]);
  }
}
