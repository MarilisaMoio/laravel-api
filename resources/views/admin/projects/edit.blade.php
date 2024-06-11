@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="fs-4 text-secondary my-4">
        {{ __('Dashboard') }}
    </h2>
    <div class="row justify-content-center">
        <div class="col">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('admin.projects.update', $project->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')

                <div class="mb-3">
                    <label for="name" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $project->name, old('name') }}">
                </div>
                <div class="mb-3">
                    <label for="client_name" class="form-label">Commissionato da</label>
                    <input type="text" class="form-control" id="client_name" name="client_name" value="{{ $project->client_name, old('client_name') }}">
                </div>
                <div class="mb-3">
                    <label for="type_id" class="form-label">Tipologia</label>
                    <select class="form-select" id="type_id" name="type_id">
                        <option @selected($project->type_id == old('type_id', "")) value="">Nessuna tipologia selezionata</option>
                        @foreach($types as $type)
                        <option value="{{ $type->id }}" @selected($type->id == old('type_id', $project->type_id)) >{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="img" class="form-label">Immagine</label>
                    <input class="form-control mb-2" type="file" id="img" name="img">
                    @if($project->img)
                        <img src="{{ asset('storage/' . $project->img) }}" alt="" style="max-height:100px; display:block">
                    @else
                        <small>No image.</small>
                    @endif
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="deleteImg" name="deleteImg">
                    <label class="form-check-label" for="deleteImg">
                        Delete existing img?
                    </label>
                </div>
                <div class="mb-3 mt-4">
                    <h5>Technologies</h5>

                    @foreach ($techs as $tech)
                        <div class="form-check">
                            @if ($errors->any())
                                <input class="form-check-input" @checked(in_array($tech->id, old('techs', []))) type="checkbox" name="techs[]" value="{{ $tech->id }}" id="tech-{{ $tech->id }}">
                            @else
                                <input class="form-check-input" @checked($project->technologies->contains($tech)) type="checkbox" name="techs[]" value="{{ $tech->id }}" id="tech-{{ $tech->id }}">
                            @endif
                            <label class="form-check-label" for="tech-{{ $tech->id }}">
                            {{ $tech->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <div class="mb-3">
                    <label for="summary" class="form-label">Sommario</label>
                    <textarea class="form-control" id="summary" rows="5" name="summary">{{ $project->summary, old('summary') }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
