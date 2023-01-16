<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::orderByDesc('id')->get();
        //dd($projects);
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {

        //dd($request->all());
        //validazione data
        $val_data = $request->validated();
        //dd($val_data);

        //salvo la cover image dentro val_data
        if ($request->hasFile('cover_image')) {

            //put('uploads') -> èercorso dove salvare le cover_image
            $cover_image = Storage::put('uploads', $val_data['cover_image']);
            //dd($cover_image);

            //inserisco cover image dentro val_data
            $val_data['cover_image'] = $cover_image;
        }
        //genrazione project slug
        $project_slug = Project::generateSlug($val_data['title']);
        //dd($project_slug);

        //genrazione project slug
        $val_data['slug'] = $project_slug;
        //dd($val_data);

        //genrazione project
        Project::create($val_data);

        //redirect alla pagina principale
        return to_route('admin.projects.index')->with('message', 'project added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {

        //validazione dei dati
        //dd($request->all());
        $val_data = $request->validated();
        //dd($val_data);

        if ($request->hasFile('cover_image')) {
            if ($project->cover_image) {
                Storage::delete($project->cover_image);
            }
            $cover_image = Storage::put('uploads', $val_data['cover_image']);
            $val_data['cover_image'] = $cover_image;
        };

        //dd($val_data);

        //aggiornare lo slug (serve se cambiamo il titolo)
        $project_slug = Project::generateSlug($val_data['title']);
        $val_data['slug'] = $project_slug;
        //aggiornare il progetto
        $project->update($val_data);

        //redirect
        return to_route('admin.projects.index')->with('message', 'project added successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        if ($project->cover_image) {
            Storage::delete($project->cover_image);
        }

        $project->delete();
        return to_route('admin.projects.index')->with('message', 'Post Delete Successfully');
    }
}
