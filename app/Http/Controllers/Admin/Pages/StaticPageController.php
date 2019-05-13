<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Models\StaticPage;
use App\Models\StaticPageLanguage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Validator;

class StaticPageController extends Controller
{
    /**
     * Список статических страниц
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = StaticPage::with('lang')->paginate(20);
        return view('admin.pages.list', compact('pages'));
    }

    /**
     * Метод вывода представления для создания новой страницы
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.pages.create');
    }
    
    /**
     * Метод создания новой категории
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        //$valid = $this->pageValidate($request);
        //if ($valid->fails()) { return redirect()->back()->withErrors($valid)->withInput(); }
        
        $new_page      = StaticPage::create(['slug'=>$request->input('slug')]);
        
        foreach (LaravelLocalization::getSupportedLocales() as $key => $lang) {
            $description = new StaticPageLanguage([
                'language'          =>$key,
                'title'             => $request->title["$key"],
                'name'              => $request->name["$key"],
                'meta_description'  => $request->meta_description["$key"],
                'meta_keywords'     => $request->meta_keywords["$key"],
                'description'       => $request->description["$key"]]);
            $new_page->lang()->save($description);
        }
        

        
        return redirect()->route('a_s_page.index')->with('success', 'Новая страница "'. $new_page->name .'" успешно создана!');
    }
    
    /**
     * Метод вывода представления редактирования страницы
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = StaticPage::with('lang')->findOrFail($id);
        return view('admin.pages.edit', compact('page'));        //Возвращаем представление с данными для редактирования
    }

    /**
     * Метод обновления категории проектов
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
//        $valid = $this->categoryValidate($request);
//        if ($valid->fails()) {
//            return redirect()->back()->withErrors($valid)->withInput();
//        }
        
        $page = StaticPage::findOrFail($id);
        $page->update(['slug'=>$request->input('slug')]);
        
        foreach (LaravelLocalization::getSupportedLocales() as $key => $lang) {
            $description = StaticPageLanguage::where('static_page_id',$page->id)->firstOrNew(['language'=>$key]);
            
            $description->title             = $request->title["$key"];
            $description->name              = $request->name["$key"];
            $description->meta_description  = $request->meta_description["$key"];
            $description->meta_keywords     = $request->meta_keywords["$key"];
            $description->description       = $request->description["$key"];
            
            $page->lang()->save($description);
        }
        
        return redirect()->route('a_s_page.index')->with('success', 'Страница "'. $page->name .'" успешно обновлена!');
    }

    /**
     * Метод удаления категории проекта
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $page = StaticPage::findOrFail($id);

        $old_name = $page->name;
        $page->delete();
        return redirect()->route('a_s_page.index')->with('success','Страница "'. $old_name .'" успешно удалена!');
    }
    
    /**
     * Проверка страницы
     * @param Request $request
     * @return Validator
     */
    protected function pageValidate(Request $request) {
        $validator_slug = Validator::make($request->all(), [
            'slug' => 'required|unique:static_page|max:255'
        ],[]);
        
        //проверка категории, для включенных языков
        foreach (LaravelLocalization::getSupportedLocales() as $key => $lang) {
            $validator_seo = Validator::make($request->all(), [
                'category.'.$key  => 'required|max:190',
                'description.'.$key  => 'required|min:10'
            ],[
                'category.'.$key.'.required' => 'Название категории, обязательное поле, язык '.$lang['native'],
                'category.'.$key.'.max' => 'Название категории, максимальная длина :max символов, язык '.$lang['native'],
                'description.'.$key.'.required' => 'Описание категории, обязательное поле, язык '.$lang['native'],
                'description.'.$key.'.min' => 'Описание категории, минимальная длина :min символов, язык '.$lang['native'],
            ]);
            if ($validator_seo->fails()) { return $validator_seo; }
        }
        return $validator_seo;
    }
    
}
