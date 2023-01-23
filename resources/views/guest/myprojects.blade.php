@extends('layouts.app')

@section('content')

<div class="container">
<h1>My Projects!</h1>
        <table class="table mytable">
            <thead>
            <tr>
                <th scope="col">Title</th>
                <th scope="col">Content</th>
                <th scope="col">Thumb</th>
            </tr>
            </thead>
            <tbody>
            @foreach($projects as  $project)
                    <tr>
                        <td><a href="{{route('showguest', ['slug'=>$project->slug])}}" title="View Post">{{ $project->title}}</a></td>
                        <td>{{Str::limit( $project->content,50)}}</td>
                        <td><img src="{{ asset('storage/' . $project->cover_image) }}" class="img-fluid" width="150px"></td>
                    </tr>
            @endforeach
            </tbody>
        </table>
        {{-- {{ $projects->links('vendor.pagination.bootstrap-5') }} --}}
    </div>
@endsection