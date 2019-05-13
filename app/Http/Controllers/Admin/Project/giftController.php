<?php

namespace App\Http\Controllers\Admin\Project;

use App\Models\GiftProject\Gift;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use File;
use Image;

class giftController extends Controller
{
    public function editGiftProject(Request $request,$id){
        $gift = Gift::find($id);
        if(!$gift){
            return back()->with('info','Подарок не найден');
        }
        $this->validate($request,[
            'need_sum'=>'required',
            'limit'=>'required',
            'delivery_date'=>'required',
            'description'=>'required',
        ]);
        $gift->update([
           'need_sum'=>$request->need_sum,
           'limit'=>$request->limit,
           'delivery_date'=>$request->delivery_date,
           'description'=>$request->description,
        ]);
        if($request->delivery_method){
            $gift->update([
                'delivery_method'=>$request->delivery_method
            ]);
        }
        if($request->question_user){
            $gift->update([
               'question_user'=>$request->question_user
            ]);
        }
        return back()->with('success','Подарок проекта успешно обновлен!');

    }

    /**
     * Метод загрузки нового изображения подарка
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uploadImageGift(Request $request,$id){
        $gift = Gift::find($id);
        if(!$gift){
            return back()->with('info','Подарок не найден');
        }
        $this->validate($request,[
            'image_link'=>'required|max:5000'
        ],[
            'image_link.required'=>'Изображение не выбрано',
            'image_link.max'=>'Файл больше 5мб'
        ]);
        
        
//        $gift_image = $request->file('image_link');
//        $hash_str = str_random(5);
//        $filename = 'gift'.$hash_str.'.'. $gift_image->getClientOriginalExtension();
//        Image::make($gift_image)->resize(600, 360)->save(public_path('images/gifts/'.$filename));
//        $gift->image_link = 'images/gifts/'.$filename;
        
        
        if ($request->hasFile('image_link')) {
            if (file_exists(public_path($gift->image_link))) { File::delete($gift->image_link); }
            Storage::disk('public')->delete($gift->image_link);
            $gift->image_link = $request->file('poster_link')->storePublicly('project/'.$project->id,'public');
            //Image::make(Storage::disk('public')->path($project->poster_link))->resize(600, 360)->save(Storage::disk('public')->path($project->poster_link))->destroy();
        }
        
        $gift->save();
        return back()->with('success','Изображения подарка успешно сохранено!');
    }


    /**
     * Метод удаления подарка изображения
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteImage($id){
        $gift = Gift::find($id);
        if(!$gift){
            return back()->with('info','Подарок не найден!');
        }
        if(file_exists(public_path($gift->image_link))){
            File::delete($gift->image_link);
        }
        $gift->update([
           'image_link'=>null,
        ]);
        return back()->with('success','Изображения подарка удалено!');
    }
}
