<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Models\SettingProject\CategoryProject;
use App\Models\SettingProject\CategoryProjectDescription;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Validator;

class categoriesProjectController extends Controller
{
    /**
     * Список категорий
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = CategoryProject::with('langcur')->paginate(20);
        return view('admin.settings.categories.list', compact('categories'));
    }

    /**
     * Метод вывода представления для создания новой категории
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.settings.categories.new');
    }
    
    /**
     * Метод создания новой категории
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $valid = $this->categoryValidate($request);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        
        $new_cat        = new CategoryProject();
        $new_cat->thumb = $request->get('thumb');
        $new_cat->save();
        
        foreach (LaravelLocalization::getSupportedLocales() as $key => $lang) {
            $description = new CategoryProjectDescription(['language'=>$key,
                'name'          => $request->category["$key"],
                'description'   => $request->description["$key"]]);
            $new_cat->lang()->save($description);
        }
        
        //обратная совместимость, fix
        $descript = $new_cat->descript;
        $new_cat->name          = $descript->name;
        $new_cat->description   = $descript->description;
        $new_cat->save();
        
        return redirect()->route('catgories_project.index')->with('success', 'Новая категория "'. $new_cat->descript->name .'" успешно создана!');
    }
    
    /**
     * Метод вывода представления редактирования категории
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = CategoryProject::with('lang')->findOrFail($id);
        return view('admin.settings.categories.edit', compact('category'));        //Возвращаем представление с данными для редактирования
    }

    /**
     * Метод обновления категории проектов
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $valid = $this->categoryValidate($request);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        
        $category = CategoryProject::findOrFail($id);
        if (!$category) {
            return back()->with('info', 'Категория не найдена');
        }
        
        foreach (LaravelLocalization::getSupportedLocales() as $key => $lang) {
            $description = CategoryProjectDescription::where('project_categories_id',$category->id)
                    ->firstOrNew(['language'=>$key]);
            $description->name          = $request->category["$key"];
            $description->description   = $request->description["$key"];
            $category->lang()->save($description);
        }
        
        return back()->with('success', 'Категория "'. $category->descript->name .'" успешно обновлена!');
    }

    /**
     * Метод удаления категории проекта
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $category = CategoryProject::find($id);
        if (!$category) {
            return back()->with('info', 'Категория не найдена!');
        }
        $old_name = $category->descript->name;
        $category->delete();
        return back()->with('success','Категория "'. $old_name .'" успешно удалена!');
    }
    
    /**
     * Проверка категории
     * @param Request $request
     * @return Validator
     */
    protected function categoryValidate(Request $request) {
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
