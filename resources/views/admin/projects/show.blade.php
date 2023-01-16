@extends('layouts.admin')

@section('content')

@if($project->cover_image)
<img src="{{asset('storage/'. $project->cover_image)}}" alt="" class="img-fluid">
@else
<div class="placeholder p-5 bg-secondary">placeholder</div>
@endif

<h1>Title project: {{$project->title}}</h1>
<h5>Slug Title project: {{$project->slug}}</h5>
<div class="content"> Descritpion project:{{$project->description}}</div>



@endsection