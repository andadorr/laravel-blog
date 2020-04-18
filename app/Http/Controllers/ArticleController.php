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
}
