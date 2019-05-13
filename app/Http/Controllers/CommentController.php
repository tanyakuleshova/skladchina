<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Models\Comment;
use App\Models\Project\Project;
use App\User;


class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin')->only(['index']);
    }
    
    /**
     * Метод, для администратора, список комментариев к конкретному блогу
     * @param int $id_blog
     * @return view
     */
    public function index($id_blog) {
        $blog = Blog::findOrFail($id_blog);
        $comments = Comment::where('blog_id',$id_blog)->orderBy('created_at','desc')->paginate(20);
        return view('Admin.admin.blog.blogListComments',  compact(['blog','comments']));
    }
    
    /**
     * Метод, для администратора, удаление комментария
     * @param int $id
     * @return redirect
     */
    public function destroy($id) {
        
        if (!request()->ajax()) { return \Response::json(['error'=>'Не верный запрос']); }
        
        $project = Project::find(request()->input('project_id', 0));
        $comment = Comment::find($id);
        
        if (!$project || !$comment) { return \Response::json(['error'=>'Что-то пошло не так']); }

        if($comment->project_id != $project->id) { return \Response::json(['error'=>'Комментарий не к этому проекту']); }
        
        if($project->user_id != auth()->id()) { return \Response::json(['error'=>'Не достаточно прав, для удаления.']); }
        
        $update = Comment::where('parent_id',$comment->id)->update(['parent_id'=>null]);
        $comment->delete();
        return \Response::json(['success'=>'Комментарий успешно удален!']);
    }

    
    /**
     * Метод записи комментария к блогу, доступен всем зарегестрированным пользователям
     * @param Request $request
     * @return json
     */
    public function store(Request $request){
        if (!request()->ajax()) { return \Response::json(['error'=>'Не верный запрос']); }

        $data = array();

        $data['project_id'] = (int)$request->input('comment_project_ID');
        $data['text'] = $request->input('text');

        //Проверка
        $validator = Validator::make($data,[
                'project_id' => 'integer|required',
                'text' => 'required',
        ]);
        //Ошибки
        if ($validator->fails()) { return \Response::json(['error'=>$validator->errors()->all()]); }

        //получаем модель записи к которой принадлежит комментарий
        $project = Project::find($data['project_id']);
        if(!$project) { return \Response::json(['error'=>'Не известный проект!']); }

        $data['parent_id']  = (User::find($request->input('comment_parent',null)))?(int)$request->input('comment_parent'):null;
        $data['user_id']    = $request->user()->id;
        /*
         * Создаем объект для сохранения, передаем ему массив данных
         */
        $comment = new Comment($data); 
        /*
         * Сохраняем данные в БД
         * Используем связывающий метод comments()
         * для того, чтобы автоматически заполнилось поле post_id
         */
        $project->comments()->save($comment);


        /*
         * Формируем массив данных для вывода нового комментария с помощью AJAX
         * сразу после его добавления (без перезагрузки)
         */
        unset($data);$data = array();
        $data['id']     = $comment->id;
        $data['name']   = Auth::user()->name;
        $data['avatar'] = Auth::user()->avatar;
        $data['status'] = 1;
        $data['text'] = $request->input('text');

        //Вывод шаблона сохраняем в переменную
        $view_comment = view(env('THEME').'.comments.new_comment')->with('data', $data)->render();

        //Возвращаем AJAX вывод шаблона  с данными
        return \Response::json(['success'=>true, 'comment'=>$view_comment, 'data'=>$data]);

    }
}
