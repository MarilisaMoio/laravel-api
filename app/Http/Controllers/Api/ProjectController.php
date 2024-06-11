<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('type', 'technologies')->paginate(3);

        return response()->json([
            'success' => true,
            'results' => $projects
        ]);
    }

    public function show($slug)
    {
        $project = Project::where('slug', '=', $slug)->with('type', 'technologies')->first();

        $data = [];

        if($project){
            $data = [
                'success' => true,
                'results' => $project
            ];
        } else {
            $data = [
                'success' => false,
                'message' => 'Cannot find a project with this name'
            ];
        }

        return response()->json([$data]);
    }
}
