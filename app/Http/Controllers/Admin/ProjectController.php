<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Type;
use App\Models\Technology;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
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
        $allProjects = Project::all();

        return view('admin.projects.index', compact('allProjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        $techs = Technology::all();

        return view('admin.projects.create', compact('types', 'techs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $formData = $request->all();
        $this->validator($formData);
        $formData['slug'] = Str::slug($formData['name'], '-');
        if($request->hasFile('img')){
            $img_path = Storage::disk('public')->put('project_images', $formData['img']);
            $formData['img'] = $img_path;
        };

        $newProject = new Project();
        $newProject->fill($formData);
        $newProject->save();

        $newProject->technologies()->attach($formData['techs']);

        return redirect()->route('admin.projects.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        $techs = Technology::all();

        return view('admin.projects.edit', compact('project', 'types', 'techs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $formData = $request->all();
        $this->validator($formData, $project);

        if($request->hasFile('img')){
            if($project->img) {
                Storage::delete($project->img);
            };

            $img_path = Storage::disk('public')->put('project_images', $formData['img']);
            $formData['img'] = $img_path;
        } elseif ($request->has('deleteImg')){
            Storage::delete($project->img);
            $formData['img'] = null;
        };


        $formData['slug'] = Str::slug($formData['name'], '-');


        $project->fill($formData);
        $project->save();

        if($formData['techs']){
            $project->technologies()->sync($formData['techs']);
        } else{
            $project->technologies()->sync([]);
        };

        return redirect()->route('admin.projects.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('admin.projects.index');
    }

    //validator custom che dovrebbe funzionare sia per edit che per create, andando a sostituire una regola solo se passo l'istanza project
    private function validator($input, $project = false){

        $rules = [
            'name' => [
                'required',
                'min:5',
                'max:150',
                'unique:projects,name'
            ],
            'client_name' => 'nullable|min:5|max:600',
            'summary' => 'nullable|min:10|max:2000',
            'img' => 'nullable|image|max:512',
            'type_id' => 'nullable|exists:types,id',
            'techs' => 'exists:technologies,id'
        ];

        if ($project) {
            array_pop($rules['name']);
            array_push($rules['name'], Rule::unique('projects')->ignore($project));
        }

        $messages = [
            'required' => 'Il campo ":attribute" è vuoto, ma è necessario compilarlo.',
            'min' => 'Il campo ":attribute" necessita di almeno :min caratteri.',
            'max' => [
                'numeric' => 'Il campo ":attribute" accetta un valore massimo di :max.',
                'string' => 'Il campo ":attribute" accetta un massimo di :max caratteri.',
                'file' => 'Il campo ":attribute" non deve superare i :max kilobyte'
            ],
            'unique' => 'Il valore inserito nel campo ":attribute" è già presente nel nostro sistema.',
            'image' => 'Il campo ":attribute" può contenere solo file di immagini.',
            'exists' => 'Il campo ":attribute" non è valido'
        ];

        $validator = Validator::make($input, $rules, $messages)->validate();

        return $validator;
    }
}
