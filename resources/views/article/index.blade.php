@extends('layouts.app')

@section('content')

	<a href="{{ route('welcome') }}">Main</a>
	@if (Session::has('status'))
		<div class="alert alert-success">{{ Session::get('status') }}</div>
	@endif
    <h1>Список статей</h1>
    @foreach ($articles as $article)
    	(<a href="{{ route('articles.edit', $article->id) }}">EDIT</a>)
    	{{ Form::open(['url' => route('articles.destroy', $article), 'method' => 'delete'])}}
    		{{ Form::submit('Delete!')}}
    	{{ Form::close()}}
        <h2>{{$article->name}}</h2>
        {{-- Str::limit – функция-хелпер, которая обрезает текст до указанной длины --}}
        {{-- Используется для очень длинных текстов, которые нужно сократить --}}
        <div>{{Str::limit($article->body, 200)}}</div>
    @endforeach
@endsection