@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="fs-4 text-secondary my-4">
        {{ __('Dashboard') }}
    </h2>
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">Projects</div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Slug</th>
                                <th scope="col">Commissioned by</th>
                                <th scope="col">IMG</th>
                                <th scope="col">Type</th>
                                <th scope="col" style="width:100px;">Techs</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allProjects as $project)
                                <tr>
                                    <td>{{ $project->name }}</td>
                                    <td>/{{ $project->slug }}</td>
                                    <td>{{ $project->client_name }}</td>
                                    <td>{{ $project->img ? 'YES' : 'NO' }}</td>
                                    <td>{{ $project->type_id ? $project->type->name : '---' }}</td>
                                    <td>
                                        @if(count($project->technologies) > 0)
                                            @foreach($project->technologies as $tech)
                                                <span class="badge rounded-pill bg-secondary">{{ $tech->name }}</span>
                                            @endforeach
                                        @else
                                            ---
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-success" href="{{ route('admin.projects.show', $project->id) }}">See</a>
                                        <a class="btn btn-warning" href="{{ route('admin.projects.edit', $project->id) }}">Edit</a>
                                        <button class="btn btn-danger js-delete" data-id="{{ $project->id }}" data-name="{{ $project->name }}">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@include('partials.modal')
@endsection
