@extends('admin.layouts.app')

@section('title', 'Listagem de posts')

@section('content')

<!-- <a href="/posts/create">Criar Novo Post</a> -->
<a href="{{ route("posts.create") }}">Criar Novo Post</a>

<hr>

@if (session('message'))
    <div style="color:rgb(68, 168, 68)">
        {{session('message')}}    
    </div>    
@endif

<form action="{{ route('posts.search') }}" method="post">
    @csrf
    <input type="text" name="search" placeholder="Filtrar: ">
    <button type="submit">Filtrar</button>
</form>

<h1>Posts</h1>


    
   {{--  <p>{{ $post->title }} [<a href="{{ route('posts.show', ['id' => $id])}}">Ver Detalhes Do Card(Titulo - Conteúdo)</a>]</p>
 --}}
    {{-- <p>{{ $post->title }} [<a href="{{ route('posts.show', ['id' => $id])}}">Ver Detalhes Do Card(Titulo - Conteúdo)</a>]</p> --}}
    
    <table style="border: 3px solid rgb(36, 36, 148);">
        <thead>
            <td>ID</td>
            <td>Imagem</td>
            <td>Título</td>
            <td>Conteúdo</td>
            <td>Link Show</td>
            <td>Link Edit</td>
        </thead>
        
        <tbody>
            @foreach($posts as $post)
                <tr>
                    <td># {{ $post->id }}</td>
                    <td><img src="{{url("storage/{$post->image}")}} " alt="{{ $post->title }}" style="max-width:100px;" /></td>
                    <td><p>{{ $post->title }}
                    <td><p>{{ $post->content }}</p></td>
                    <td>[<a href="{{ route('posts.show', $post->id)}}">Ver Detalhes Do Card(Titulo - Conteúdo - {{$post->id}})</a>]</p></td></td>
                    <td><a href="{{ route('posts.edit', $post->id) }}">Editar Post</a></td>
                </tr>
            
            @endforeach
           
        </tbody>
    </table>
    
    {{-- @foreach($posts as $post) --}}
    
        @if (isset($filters))
            {{ $posts->appends($filters)->links() }}
        @else
            {{ $posts->links() }}
        @endif
  
    {{-- @endforeach --}}

@endsection