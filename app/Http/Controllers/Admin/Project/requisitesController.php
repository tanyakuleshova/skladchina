<?php

namespace App\Http\Controllers\Admin\Project;

use App\Models\Project\RequisitesProject;
use App\Models\Project\GalleryProject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use File;
use Image;

class requisitesController extends Controller
{
    public function editIndividualReq(Request $request,$id){
        $requsities = RequisitesProject::find($id);
        if(!$requsities){
            return back()->with('info','Реквизиты проекта не найдены!');
        }
        $requsities->update([
            'position'=>$request->position,
            'FIO'=>$request->FIO,
            'name_organ'=>$request->name_organ,
            'country_register'=>$request->country_register,
            'city'=>$request->city,
            'phone'=>$request->phone,
            'inn_or_rdpo'=>$request->inn_or_rdpo,
            'legal_address'=>$request->legal_address,
            'physical_address'=>$request->physical_address,
            'code_bank'=>$request->code_bank,
            'сhecking_account'=>$request->сhecking_account,
            'other'=>$request->other,
        ]);
        return back()->with('success','Реквизиты проекта успешно обновлены.');
    }

    public function editFopReq(Request $request,$id){
        $requsities = RequisitesProject::find($id);
        if(!$requsities){
            return back()->with('info','Реквизиты проекта не найдены!');
        }
        $requsities->update([
            'FIO'=>$request->FIO,
            'date_birth'=>$request->date_birth,
            'country_register'=>$request->country_register,
            'city'=>$request->city,
            'phone'=>$request->phone,
            'inn_or_rdpo'=>$request->inn_or_rdpo,
            'issued_by_passport'=>$request->issued_by_passport,
            'date_issued'=>$request->date_issued,
            'code_bank'=>$request->code_bank,
            'сhecking_account'=>$request->сhecking_account,
            'other'=>$request->other,
        ]);
        return back()->with('success','Реквизиты проекта успешно обновлены.');
    }

    public function editEntityReq(Request $request,$id){
        $requsities = RequisitesProject::find($id);
        if(!$requsities){
            return back()->with('info','Реквизиты проекта не найдены!');
        }
        $requsities->update([
            'FIO'=>$request->FIO,
            'country_register'=>$request->country_register,
            'city'=>$request->city,
            'phone'=>$request->phone,
            'inn_or_rdpo'=>$request->inn_or_rdpo,
            'legal_address'=>$request->legal_address,
            'physical_address'=>$request->physical_address,
            'code_bank'=>$request->code_bank,
            'сhecking_account'=>$request->сhecking_account,
            'other'=>$request->other,
        ]);
        return back()->with('success','Реквизиты проекта успешно обновлены.');
    }

    /**
     * Метод удлаения сканов проекта
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteRequisitImage($id){
        $requisites_image = GalleryProject::find($id);
        if(!$requisites_image){
            return back()->with('info','Изображение не найдено!');
        }
        if (file_exists(public_path($requisites_image->link_scan))) {
            File::delete($requisites_image->link_scan);
        }
        $requisites_image->delete();
        return back()->with('success','Изображение успешно удалено.');
    }

}
