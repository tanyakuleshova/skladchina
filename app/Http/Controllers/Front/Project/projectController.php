<?php

namespace App\Http\Controllers\Front\Project;

use App\Models\Project\Project;
use App\Models\Project\VideoProject;
use App\Models\SettingProject\CategoryProject;
use App\Models\SettingProject\StatusProject;
use App\Models\SettingProject\TypeProject;
use App\Models\SettingProject\City;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

use App\Http\Controllers\Front\Project\EditSteps\OneStepController;
use App\Http\Controllers\Front\Project\EditSteps\TwoStepController;
use App\Http\Controllers\Front\Project\EditSteps\ThirdStepController;
use App\Http\Controllers\Front\Project\EditSteps\FourStepController;
use App\Http\Controllers\Front\Project\EditSteps\FiveStepController;
use App\Http\Controllers\Front\Project\EditSteps\SixStepController;

use Image;
use File;
use Carbon\Carbon;

class projectController extends Controller
{
    protected $selected_fields  = ['city_id','category_id'];
    protected $sorted_name      = ['name','popular','new','end'];
    
    protected $search_field     = 'search';


    protected $StepsCreateProject = [1,2,3,4,5,6];
    
    
    private $projects;
    private $request;


    public function __construct() {
        $this->middleware('auth')->except('index','show','showProject','search'); 
        $this->request = request();// :)
    }

    
    public function search(Request $request) {
        if($request->get($this->search_field) && strlen(trim($request->get($this->search_field)))>=3) {
            $request->session()->flash($this->search_field, trim($request->get($this->search_field)));
            return redirect()->route('project.index');
        }
        return back();
    }
    
    /**
     * Метод вывода списка проектов на фронт
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     */
    public function index(Request $request)
    {
        $cities     = City::with('lang')->get();
        $categories = CategoryProject::with('lang')->get();

        $this->projects = Project::allActive();
        
        if($request->session()->has($this->search_field)) {  $this->searching(); }
        
        
        if ($request->get('city_id')) { $this->parseSelector($cities->pluck('id')->toArray());} 
        
        if ($request->get('category_id')) { $this->parseSelector($categories->pluck('id')->toArray(),'category_id'); } 
        
        if ($request->get('sort') && in_array($request->get('sort'), $this->sorted_name)){
            $this->parseSort();
        } else {
            $this->projects->orderBy('id', 'desc');                             //сортировка по умолчанию
            $this->request->offsetUnset('sort');
            $this->request->offsetUnset('sort_order');
        }
        

        $projects = $this->projects->paginate(6)->appends($this->request->all());

        if ($projects->isEmpty() && $request->get('page')>1) {
            $data = $request->all(); unset($data['page']);
            return response()->redirectToRoute('projects',$data);
        } 

        return view('front.project.listProject', compact('projects','cities','categories'));
    }
    
    protected function parseSelector($ids = [1,2], $strParam = 'city_id') {
  
        if (!in_array($strParam,$this->selected_fields)) { return ; }

        if ($this->request->get($strParam) && in_array($this->request->get($strParam), $ids)) {
            return $this->projects->where($strParam,  $this->request->get($strParam));
        }
        
        $this->request->offsetUnset($strParam);
    }
    
    protected function parseSort() {
        $sort   = $this->request->get('sort');
        $order  = $this->request->get('sort_order');
        if (!in_array(strtolower($order), ['asc','desc'])) { $order = 'asc'; }
        switch ($sort){
            case 'name':
                $this->projects->orderBy('name', $order);
                break;
            case 'popular':
                $this->projects->orderBy('current_sum', $order);
                break;
            case 'new':
                $this->projects->orderBy('date_start', $order);
                break;
            case 'end':
                $this->projects->orderBy('date_finish', $order);
                break;
            default:
                $this->projects->orderBy('id', 'desc');
                break;
        }  
    }
    
    
    protected function searching() {
        $search = $this->request->session()->pull($this->search_field);
        $this->request->session()->flash($this->search_field, $search);
        $this->projects->searchOf(trim($search));
    }
    
    /**
     * Метод вывода подробной информации о проекте, для пользователей
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function show($id,$seo='')
    {
        //$project    = Project::where('id',$id)->active()->closedSuccess('or')->with('balance')->firstOrFail();
        $project    = Project::where('id',$id)
                ->with(['balance','projectGifts'=>function($query){
                    $query->orderBy('need_sum', 'asc');
                }])->firstOrFail();
        $project->update(['viewed'=>$project->viewed+1]);
        
        request()->session()->put('redirect_router_project', route('project.show', $id));
        
        return view('front.project.show', compact('project'));
    }

    
    /**
     * Метод вывода представления для создания проекта
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function create()
    {
        return view('front.project.show_steps.create');
    }

    /**
     * Первый шаг при создании проекта
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        if (!$request->input('confirm_with_rules')) { return back()->with('warning_message', 'Для создания проекта нужно согласится с правилами.'); }
        $project = Project::create(['user_id'=>$request->user()->id,'project_giftt_type'=>1]);
        return response()->redirectToRoute('project.edit', $project->id);
    }
    
    /**
     * Метод вывода пользователю редактирования проекта пользователя
     * @param $id
     * @param type $step
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($id, $step = null)
    {
        $project = null;
        if(Auth::guard('admin')->user() && Auth::guard('web')->user()) {
            $project = Project::where('id', $id)->where('user_id', Auth::id())->first();
        } 
        if(!$project) {
            $project = Project::allEdited()->where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        }
        
        
        if(!in_array($step, $this->StepsCreateProject)) { return redirect()->route('edit_project',['id'=>$id,'step'=>1]); }

        switch ($step) {
            case 1:
                return OneStepController::edit($project);
            case 2:
                return TwoStepController::edit($project);
            case 3:
                return ThirdStepController::edit($project);
            case 4:
                return FourStepController::edit($project);
            case 5:
                return FiveStepController::edit($project);       
        }
        
        return SixStepController::edit($project); 
    }
    
    public function update(Request $request, $id, $step = null) {
        
        $project = null;
        if(Auth::guard('admin')->user() && Auth::guard('web')->user()) {
            $project = Project::where('id', $id)->where('user_id', Auth::id())->first();
        } 
        if(!$project) {
            $project = Project::allEdited()->where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        }
        
        
        if(!in_array($step, $this->StepsCreateProject)) { return redirect()->route('edit_project',['id'=>$id,'step'=>1])->with('warning_message', 'Неизвестный шаг в науке.');}
        
        switch ($step) {
            case 1:
                return OneStepController::update($request, $project);
            case 2:
                return TwoStepController::update($request, $project);
            case 3:
                return ThirdStepController::update($request, $project);
            case 4:
                return FourStepController::update($request, $project);
            case 5:
                return FiveStepController::update($request, $project); 
            }
        
            
        return SixStepController::update($project);  //отправка проекта на модерацию    
    }

    /**
     * Метод удаления проекта пользователем со всеми изображениями
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        if(Auth::guard('admin')->user() && Auth::guard('web')->user()) {
            $project = Project::moderation()->where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        } else {
            $project = Project::allEdited()->where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        }

        if(!$project->isAllEdited && !Auth::guard('admin')->user()) { return back()->with('warning_message', 'Невозможно удалить, статус  проекта!'); }

//        $project->projectGifts()->delete();
//        
//        if ($project->projectGifts) {
//
//        }
//        
//        if ($project->requisites) {
//            if ($project->requisites->galleries) {
//                foreach ($project->requisites->galleries as $gallery) {
//                    if (file_exists(public_path($gallery->link_scan))) {
//                        File::delete($gallery->link_scan);
//                    }
//                }
//            }
//        }
        $project->delete();
        return redirect(route('myprojects.index'))->with('success_message', 'Проект успешно удален!')->withInput();
    }
    
    /**
     * Метод удаления видео проекта
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deleteVideoProject($id)
    {
        $video = VideoProject::find($id);
        if (!$video) {
            return back()->with('warning_message', 'Видео проекта не найдено!');
        }

        if ($video->projectVideo->user_id != Auth::user()->id) {
            return back()->with('warning_message', 'Видео проекта принадлежит не вашему проекту');
        }
        
        $project = $video->projectVideo;
        $res = array_filter($project->valid_steps, function ($element) { return ($element != 2); } );
        sort($res);
        $project->update(['valid_steps'=>$res]);

        if ($video->self_video == 0) {
            $video->delete();
        }else{
            Storage::disk('public')->delete($video->link_video);
            $video->delete();
        }
        return back()->with('success_message', 'Видео успешно удалено!');
    }


    


    
}