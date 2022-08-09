@extends('admin.layouts.app')

@section('title', 'Atualizar as informações')

@section('content')


<h1>Atualizar Novo Post -> name {{$post->title}}</h1>

<form action="{{ route("posts.update", $post->id )}}" method="POST" enctype="multipart/form-data">
    
    {{-- {{ @method('PUT') }} --}}
    @include('admin.posts._partials.form')

</form>
    
@endsection