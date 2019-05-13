<?php

namespace App\Http\Controllers\Front\Project;

use App\Models\Project\GalleryProject;
use App\Models\Project\Project;
use App\Models\Project\RequisitesProject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Image;
use File;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Front\Project\EditSteps\FiveStepController;

class requisitiesController extends Controller
{
    public function __construct() {
        $this->middleware('auth'); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function choseTypeReq(Request $request, $id)
    {
            $project = Project::where('id', $id)->where('user_id', Auth::id())->AllEdited()->firstOrFail();
            
            $this->validate($request, [
                'type_proj' => 'required'
            ], [
                'type_proj.required' => 'Выберите один пункт из предоставленных'
            ]);
            
            $requisities_project = RequisitesProject::firstOrNew(['project_id'=>$project->id]);
            $requisities_project->type_proj = $request->input('type_proj');
            $requisities_project->save();
            
            return redirect(route('edit_project',['id'=>$project->id,'step'=>5]));

    }

    /**
     * Метод сохранения реквизитов проекта для юр. лиц
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function individualRequisities(Request $request, $id)
    {
        $project = Project::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        FiveStepController::validateUpdate($project);
        $this->downloadFiles($request, $project);
        
        $this->validate($request, [
            'position' => 'required',
            'FIO' => 'required',
            'name_organ' => 'required',
            'country_register' => 'required',
            'city' => 'required',
            'phone' => 'required',
            'inn_or_rdpo' => 'required',
            'legal_address' => 'required',
            'physical_address' => 'required',
            'code_bank' => 'required',
            'сhecking_account' => 'required',
        ], [
            'FIO.required' => 'Данное поле обязательное.',
            'position.required' => 'Данное поле обязательное.',
            'FIO.required' => 'Данное поле обязательное.',
            'name_organ.required' => 'Данное поле обязательное.',
            'country_register.required' => 'Данное поле обязательное.',
            'city.required' => 'Данное поле обязательное.',
            'phone.required' => 'Данное поле обязательное.',
            'inn_or_rdpo.required' => 'Данное поле обязательное.',
            'legal_address.required' => 'Данное поле обязательное.',
            'physical_address.required' => 'Данное поле обязательное.',
            'code_bank.required' => 'Данное поле обязательное.',
            'сhecking_account.required' => 'Данное поле обязательное.',
        ]);
        $project->requisites()->update([
            'FIO'               => strip_tags($request->FIO),
            'position'          => strip_tags($request->position),
            'name_organ'        => strip_tags($request->name_organ),
            'country_register'  => strip_tags($request->country_register),
            'city'              => strip_tags($request->city),
            'phone'             => strip_tags($request->phone),
            'inn_or_rdpo'       => $request->inn_or_rdpo,
            'legal_address'     => strip_tags($request->legal_address),
            'physical_address'  => strip_tags($request->physical_address),
            'code_bank'         => $request->code_bank,
            'сhecking_account'  => strip_tags($request->сhecking_account),
            'other'             => $request->input('other')?strip_tags($request->input('other')):NULL
        ]);

//        if ($request->hasFile('requisities_image')) {
//            foreach ($request->requisities_image as $file) {
//                $hash_str = str_random(5);
//                $filename = 'scan_' . $hash_str . '.' . $file->getClientOriginalExtension();
//                Image::make($file)->save(public_path('images/scan_projects/' . $filename));
//                $scan_proj = new GalleryProject();
//                $scan_proj->requisites_id = $project->requisites->id;
//                $scan_proj->link_scan = 'images/scan_projects/' . $filename;
//                $scan_proj->save();
//            }
//        }
        
        FiveStepController::validateUpdate($project,1);
        return back()->with('success_message', 'Данные успещно сохранены!');

    }

    public function fopRequisities(Request $request, $id)
    {
        $project = Project::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        FiveStepController::validateUpdate($project);
        $this->downloadFiles($request, $project);
        
        $this->validate($request, [
            'FIO' => 'required',
            'date_birth' => 'required',
            'country_register' => 'required',
            'city' => 'required',
            'phone' => 'required',
            'inn_or_rdpo' => 'required',
            'series_and_number_pasport' => 'required',
            'issued_by_passport' => 'required',
            'date_issued' => 'required',
            'code_bank' => 'required',
            'сhecking_account' => 'required',
        ], [
            'FIO.required' => 'Данное поле обязательное.',
            'position.required' => 'Данное поле обязательное.',
            'date_birth.required' => 'Данное поле обязательное.',
            'country_register.required' => 'Данное поле обязательное.',
            'city.required' => 'Данное поле обязательное.',
            'phone.required' => 'Данное поле обязательное.',
            'inn_or_rdpo.required' => 'Данное поле обязательное.',
            'series_and_number_pasport.required' => 'Данное поле обязательное.',
            'issued_by_passport.required' => 'Данное поле обязательное.',
            'date_issued.required' => 'Данное поле обязательное.',
            'code_bank.required' => 'Данное поле обязательное.',
            'сhecking_account.required' => 'Данное поле обязательное.',
        ]);
        $project->requisites()->update([
            'FIO'                   => strip_tags($request->FIO),
            'date_birth'            => strip_tags($request->date_birth),
            'country_register'      => strip_tags($request->country_register),
            'city'                  => strip_tags($request->city),
            'phone'                 => strip_tags($request->phone),
            'inn_or_rdpo'           => strip_tags($request->inn_or_rdpo),
            'series_and_number_pasport' => $request->series_and_number_pasport,
            'issued_by_passport'    => strip_tags($request->issued_by_passport),
            'date_issued'           => $request->date_issued,
            'code_bank'             => $request->code_bank,
            'сhecking_account'      => strip_tags($request->сhecking_account),
            'other'                 => $request->input('other')?strip_tags($request->input('other')):NULL
        ]);


//        if ($request->hasFile('requisities_image')) {
//            foreach ($request->requisities_image as $file) {
//                $hash_str = str_random(5);
//                $filename = 'scan_' . $hash_str . '.' . $file->getClientOriginalExtension();
//                Image::make($file)->save(public_path('images/scan_projects/' . $filename));
//                $scan_proj = new GalleryProject();
//                $scan_proj->requisites_id = $project->requisites->id;
//                $scan_proj->link_scan = 'images/scan_projects/' . $filename;
//                $scan_proj->save();
//            }
//        }
//        
        FiveStepController::validateUpdate($project,1);
        return back()->with('success_message', 'Данные успещно сохранены!');

    }

    public function entityRequisities(Request $request, $id)
    {
        $project = Project::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        FiveStepController::validateUpdate($project);
        $this->downloadFiles($request, $project);
        
        $this->validate($request, [
            'FIO' => 'required',
            'country' => 'required',
            'city' => 'required',
            'phone' => 'required',
            'code' => 'required',
            'ur_adress' => 'required',
            'adress' => 'required',
            'code_bank' => 'required',
            'score' => 'required',
        ], [
            'FIO.required' => 'Данное поле обязательное.',
            'country.required' => 'Данное поле обязательное.',
            'city.required' => 'Данное поле обязательное.',
            'phone.required' => 'Данное поле обязательное.',
            'code.required' => 'Данное поле обязательное.',
            'ur_adress.required' => 'Данное поле обязательное.',
            'adress.required' => 'Данное поле обязательное.',
            'code_bank.required' => 'Данное поле обязательное.',
            'score.required' => 'Данное поле обязательное.',
        ]);
        $project->requisites()->update([
            'FIO'               => strip_tags($request->FIO),
            'country_register'  => strip_tags($request->country),
            'city'              => strip_tags($request->city),
            'phone'             => strip_tags($request->phone),
            'inn_or_rdpo'       => strip_tags($request->code),
            'legal_address'     => $request->ur_adress,
            'physical_address'  => strip_tags($request->adress),
            'code_bank'         => $request->code_bank,
            'сhecking_account'  => strip_tags($request->score),
            'other'             => $request->input('other')?strip_tags($request->input('other')):NULL
        ]);

        
        
//        if ($request->hasFile('requisities_image')) {
//            foreach ($request->requisities_image as $file) {
//                $hash_str = str_random(5);
//                $filename = 'scan_' . $hash_str . '.' . $file->getClientOriginalExtension();
//                Image::make($file)->save(public_path('images/scan_projects/' . $filename));
//                $scan_proj = new GalleryProject();
//                $scan_proj->requisites_id = $project->requisites->id;
//                $scan_proj->link_scan = 'images/scan_projects/' . $filename;
//                $scan_proj->save();
//            }
//        }
        FiveStepController::validateUpdate($project,1);
        return back()->with('success_message', 'Данные успещно сохранены!');

    }
    
    
    protected function downloadFiles(Request $request, Project $project) {
        if (!$request->hasFile('requisities_image')) { return ;}
        
        if ($project->requisites->galleries) {
            foreach ($project->requisites->galleries as $item) {
                $item->forceDelete();
            }
        }
        
        foreach ($request->requisities_image as $file) {
            $scan = new GalleryProject([
                'link_scan' => Storage::disk('public')->putFile('project/'.$project->id.'/scans',$file)
            ]);
            
            $project->requisites->galleries()->save($scan);
        }  
    }
    
    public function downloadFileReq(Request $request, $id) {
        $project = Project::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        if (!$request->hasFile('requisities_image')) { return ;}
        
        foreach ($request->requisities_image as $file) {
            $scan = new GalleryProject([
                'link_scan' => Storage::disk('public')->putFile('project/'.$project->id.'/scans',$file)
            ]);
            
            $project->requisites->galleries()->save($scan);
        }  
        return response()->json(['key'=>'записано']);
    }

    public function deleteFileReq(Request $request, $id) {
        $project = Project::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        $f = GalleryProject::where('id',$request->get('key'))->firstOrFail();
        
        if ($f->prequisites && $f->prequisites->project_id == $project->id) {
            $f->forceDelete();
            return response()->json();
        }
        
        return 'Что-то пошло не так.';
        
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
