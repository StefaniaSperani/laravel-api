<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Models\Type;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Project;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */

    public function guestView()
    {
        $projects = Project::all();

        return view('guest.myprojects', compact('projects'));
    }

    public function index()
    {
        $projects = Project::paginate(3);

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * 
     */
    public function create()
    {
        $types = Type::all();

        return view('admin.projects.create', compact('types'));
    }

    /**
    * Store a newly created resource in storage.
    *
    //  * @param  \Illuminate\Http\Request  $request
    */
    public function store(StoreProjectRequest $request)
    {
        $userId = Auth::id();

        $data = $request->validated();
        $slug = Project::generateSlug($request->title);
        $data['slug'] = $slug;

        $data['user_id'] = $userId;
        if ($request->hasFile('cover_image')) {
            $path = Storage::disk('public')->put('project_images', $request->cover_image);
            $data['cover_image'] = $path;
        }

        $new_project = Project::create($data);
        return redirect()->route('admin.projects.show', $new_project->slug);
    }

    /**
    * Display the specified resource.
    *
    //  * @param  int  $id
    */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    public function showGuest(Request $request)
    {
        // dd($request->slug);
        $project = Project::where('slug', $request->slug)->first();

        return view('guest.showguest', compact('project'));
    }

    /**
    * Show the form for editing the specified resource.
    *
    //  * @param  int  $id
    */
    public function edit(Project $project)
    {
        $types = Type::all();
        return view('admin.projects.edit', compact('project', 'types'));
    }

    /**
    * Update the specified resource in storage.
    *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $userId = Auth::id();
        $data['user_id'] = $userId;
        $data = $request->validated();
        $slug = Project::generateSlug($request->title);
        $data['slug'] = $slug;
        if ($request->hasFile('cover_image')) {
            if ($project->cover_image) {
                Storage::delete($project->cover_image);
            }

            $path = Storage::disk('public')->put('project_images', $request->cover_image);
            $data['cover_image'] = $path;
        }
        $project->update($data);
        return redirect()->route('admin.projects.index')->with('message', "$project->title updated successfully");
    }

    /**
    * Remove the specified resource from storage.
    *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    */
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('admin.projects.index')->with('message', "$project->title deleted successfully");
    }
}