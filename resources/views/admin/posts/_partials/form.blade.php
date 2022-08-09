@if ($errors->any())

    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach

    </ul>
    
@endif

@csrf

<hr>
File:
<input type="file" name="image" id="image" />
<hr>
<input type="text" name="title" id="title" placeholder="Título" value="{{ $post->title ?? old('title') }}">
<hr>
<textarea name="content" id="content" cols="30" rows="4" placeholder="Conteúdo">{{ $post->content ?? old('content') }}</textarea>
<hr>
<button type="submit">Enviar</button>

