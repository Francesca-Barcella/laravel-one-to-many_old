@extends('layouts.admin')

@section('content')

<div class="container">
  <h1>Edit Project</h1>

  <!-- inserisco messaggio per validazione fallita -->
  @if ($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  <form action="{{route('admin.projects.update', $project->slug)}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!--CAMPO COVER_IMAGE-->
    <div class="d-flex mb-3 gap-4">
      <img src="{{asset('storage/' . $project->cover_image)}}" alt="" width="150">

      <div>
        <label for="cover_image" class="form-label @error('cover_image') is-invalid @enderror">Replace Cover Image</label>
        <input type="file" name="cover_image" id="cover_image" class="form-control" placeholder="" aria-describedby="coverImagehelpId">
        <small id="coverImagehelpId" class="text-muted">Add cover image</small>
      </div>
    </div>

    <!-- messaggio di errore direttamente sotto al campo cover image -->
    @error('cover_image')
    <div class="alert alert-danger" role="alert">
      {{$message}}
    </div>
    @enderror


    <!--CAMPO TITLE-->
    <div class="mb-3">
      <label for="title" class="form-label">Name</label>
      <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" placeholder="Add New Project" aria-describedby="titleHelpId" value="{{old('title', $project->title)}}">
      <small id="titleHelpId" class="text-muted">Add new project</small>
    </div>

    <!-- messaggio di errore direttamente sotto al campo title -->
    @error('title')
    <div class="alert alert-danger" role="alert">
      {{$message}}
    </div>
    @enderror

    <!--CAMPO DESCRIPTION-->
    <div class="mb-3">
      <label for="description" class="form-label">Description</label>
      <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="5">{{old('description', $project->description)}}</textarea>
    </div>

    <!-- messaggio di errore direttamente sotto al campo description -->
    @error('description')
    <div class="alert alert-danger" role="alert">
      {{$message}}
    </div>
    @enderror

    <button type="submit" class="btn btn-primary">Update</button>

  </form>
</div>

@endsection