<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Models\SettingProject\City;
use App\Models\SettingProject\CityDescription;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

use Validator;

class CityController extends Controller
{
    /**
     * Показать список всех городов с пагинацией
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::paginate(20);
        return view('admin.settings.cities.cities_list', compact('cities'));
    }

    
    /**
     * Метод вывода представления для создания нового города
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.settings.cities.city_new');
    }
    
    //$languages = LaravelLocalization::getSupportedLocales();
    
    /**
     * Метод создания нового города
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $valid = $this->cityValidate($request);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        $new_city = new City(['seo'=>$request->seo]);
        $new_city->save();
        
        foreach (LaravelLocalization::getSupportedLocales() as $key => $lang) {
            $description = new CityDescription(['language'=>$key,'name'=>$request->city["$key"]]);
            $new_city->lang()->save($description);
        }

        return redirect()->route('cities.index')->with('success', 'Новый город!');
    }

    /**
     * Метод вывода представления редактирования города
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $city = City::with('lang')->findOrFail($id);
        return view('admin.settings.cities.city_edit', compact('city'));        //Возвращаем представление с данными для редактирования
    }


    /**
     * Метод обновления категории проектов
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $valid = $this->cityValidate($request, $id);
        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }
        
        $city = City::findOrFail($id);
        
        $city->seo = $request->seo;
        $city->save();
        
        foreach (LaravelLocalization::getSupportedLocales() as $key => $lang) {
            $description = CityDescription::where('list_city_id',$city->id)->firstOrNew(['language'=>$key]);
            $description->name = $request->city["$key"];
            $city->lang()->save($description);
        }
        
        return redirect()->back()->with('success', 'Город '.$city->description->name.' успешно обноавлен!');
    }

    /**
     * Метод удаления города
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $city = City::findOrFail($id);
        $old_name = $city->description->name;
        $city->delete();
        return redirect()->back()->with('success','Город '.$old_name.' успешно удален!');
    }
    
    
    /**
     * Проверка города
     * @param Request $request
     * @return Validator
     */
    protected function cityValidate(Request $request, $id = null) {
        //проверка на уникальность сео
        $validator_seo = Validator::make($request->all(), [
            'seo' => 'required|unique:list_city,seo,'.$id.'|max:255'
            //'unique:sys_deposit,slug,'.$id.',id',
        ]);
        if ($validator_seo->fails()) { return $validator_seo; }

        //проверка имени города, для включенных языков
        foreach (LaravelLocalization::getSupportedLocales() as $key => $lang) {
            $validator_seo = Validator::make($request->all(), [
                'city.'.$key  => 'required|max:190'
            ],[
                'city.'.$key.'.required' => 'Название города, обязательное поле, язык '.$lang['native'],
                'city.'.$key.'.max' => 'Город, максимальная длина :max символов, язык '.$lang['native'],
            ]);
            if ($validator_seo->fails()) { return $validator_seo; }
        }
        return $validator_seo;
    }
}
