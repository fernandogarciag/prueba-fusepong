<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $myCompany = User::findOrFail(Auth::id())->company_id;
      $projects = Project::where('company_id', $myCompany)->get()->toArray();
      $data = array(
        'title' => "Projectos",
        'errors' => array(),
        'projects' => $projects,
      );
      return view('react', [
        'errors_name' => array(),
        'nameJS' => "project/index",
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
        'title' => "Crear Nuevo Projecto",
        'errors' => array(),
        'project' => array('name' => ""),
      );
      return view('react', [
        'errors_name' => array('name'),
        'nameJS' => "project/create-edit",
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
      $this->validator($request->all())->validate();
      $myCompany = User::findOrFail(Auth::id())->company_id;
      Project::create([
        'company_id' => $myCompany,
        'name' => $request->input('name'),
      ]);
      return redirect()->route('projects.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
      $data = array(
        'title' => $project["name"] . " - Projecto - Información",
        'errors' => array(),
        'project' => $project,
      );
      return view('react', [
        'errors_name' => array(),
        'nameJS' => "project/show",
        'data' => $data
      ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
      $data = array(
        'title' => $project->name . " - Projecto - Editar",
        'errors' => array(),
        'project' => $project->toArray(),
      );
      return view('react', [
        'errors_name' => array('name'),
        'nameJS' => "project/create-edit",
        'data' => $data
      ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
      $this->validator($request->all())->validate();
      $project->name = $request->input('name');
      $project->save();
      return redirect()->route('projects.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
      $project->delete();
      return redirect()->route('projects.index');
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
        'name' => ['required', 'string', 'max:255']
      ]);
    }
}
