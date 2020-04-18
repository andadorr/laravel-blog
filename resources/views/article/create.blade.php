@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<a href="{{ route('welcome') }}">Main</a>

{{ Form::model($article, ['url' => route('articles.store')]) }}
    {{ Form::label('name', 'Название') }}
    {{ Form::text('name') }}<br>
    {{ Form::label('body', 'Содержание') }}
    {{ Form::textarea('body') }}<br>
    {{ Form::submit('Создать') }}
{{ Form::close() }}