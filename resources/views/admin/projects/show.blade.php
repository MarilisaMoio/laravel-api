@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="fs-4 text-secondary my-4">
        {{ __('Dashboard') }}
    </h2>
    <div class="row justify-content-center">
        <div class="col">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Name: </strong>{{ $project->name }}</li>
                <li class="list-group-item"><strong>ID: </strong>{{ $project->id }}</li>
                <li class="list-group-item"><strong>Slug: </strong>/{{ $project->slug }}</li>
                <li class="list-group-item"><strong>For: </strong>{{ $project->client_name ? $project->client_name : '---' }}</li>
                <li class="list-group-item"><strong>Type: </strong>{{ $project->type ? $project->type->name : '---' }}</li>
                <li class="list-group-item"><strong>Techs: </strong>
                    @if(count($project->technologies) > 0)
                        @foreach($project->technologies as $tech)
                            <span class="badge rounded-pill bg-secondary">{{ $tech->name }}</span>
                        @endforeach
                    @else
                        ---
                    @endif
                </li>
                <li class="list-group-item"><strong>Created: </strong>{{ $project->created_at }}</li>
                <li class="list-group-item"><strong>Updated: </strong>{{ $project->updated_at }}</li>
                <li class="list-group-item">
                    <strong>Summary</strong>
                    <p class="mb-0">{{ $project->summary ? $project->summary : '---' }}</p>
                </li>
                @if($project->img)
                    <li class="list-group-item">
                        <strong>IMG</strong>
                        <img src="{{ asset('storage/' . $project->img) }}" alt="" style="max-height:500px; display:block">
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
@endsection
