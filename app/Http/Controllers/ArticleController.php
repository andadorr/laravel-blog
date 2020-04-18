<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;

class ArticleController extends Controller
{

     public function index()
    {
        $articles = Article::paginate();

        // Статьи передаются в шаблон
        // compact('articles') => [ 'articles' => $articles ]
        return view('article.index', compact('articles'));
    }

    public function show($id)
    {
    	$article = Article::findOrFail($id);
    	return view('article.show', compact('article'));
    }

    public function create()
    {
    	$article = new Article();
    	return view('article.create', compact('article'));
    }

    public function store(Request $request)
    {
        // Проверка введённых данных
        // Если будут ошибки, то возникнет исключение
        // Иначе возвращаются данные формы
        $data = $this->validate($request, [
            'name' => 'required|unique:articles',
            'body' => 'required|min:10',
        ]);

        $article = new Article();
        // Заполнение статьи данными из формы
        $article->fill($data);
        // При ошибках сохранения возникнет исключение
        $article->save();
        $request->session()->flash('status', 'Article was added!');

        // Редирект на указанный маршрут с добавлением флеш-сообщения
        return redirect()
            ->route('articles.index');
    }

    public function edit($id)
    {
    	$article = Article::findOrFail($id);
    	return view('article.edit', compact('article'));
    }

    public function update(Request $request, $id)
	{
	    $article = Article::findOrFail($id);
	    $data = $this->validate($request, [
	        // У обновления немного изменённая валидация. В проверку уникальности добавляется название поля и id текущего объекта
	        // Если этого не сделать, Laravel будет ругаться на то что имя уже существует
	        'name' => 'required|unique:articles,name,' . $article->id,
	        'body' => 'required|min:10',
	    ]);

	    $article->fill($data);
	    $article->save();
	    return redirect()
	        ->route('articles.index');
	}
}
