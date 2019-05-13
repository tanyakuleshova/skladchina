{{-- на входе $project --}}

@extends('admin.layouts.admin-app')

@section('admin_content')
<div class="wrapper wrapper-content  animated fadeInDown article details_project">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="ibox">
                <div class="pull-left">
                   <div class="alert">Линк: {{route('show_project',[$project->id,$project->SEO])}}</div>
                </div>
                <div class="pull-right">
                    <div class="alert alert-danger">{{ $project->statusName }}</div>
                </div>
                <div class="ibox-content">
                    
                    <div class="row">
                        <table class="table table-striped">
                            <tr>
                                <td>Название:</td>
                                <td>{{ $project->name }}</td>
                            </tr>
                            <tr>
                                <td>Автор:</td>
                                <td> {{$project->author?$project->author->fullName:'-'}}</td>
                            </tr>
                            <tr>
                                <td>Админ:</td>
                                <td>{{$project->admin?$project->admin->fullName:'-'}}</td>
                            </tr>
                            <tr>
                                <td>Дата начала:</td>
                                <td>{{ $project->date_start }}</td>
                            </tr>
                            <tr>
                                <td>Дата завершения:</td>
                                <td>{{ $project->date_finish }}</td>
                            </tr>
                            <tr>
                                <td>Тип проекта:</td>
                                <td>{{ $project->type?$project->type->name:'---' }}</td>
                            </tr>
                            <tr>
                                <td>Требуемая сумма:</td>
                                <td>{{ $project->need_sum }} грн</td>
                            </tr>
                            <tr>
                                <td>Собрано:</td>
                                <td>{{ $project->getActualSumm() }}грн. / {{  round($project->projectProcent(),2) }}%</td>
                            </tr>
                            <tr>
                                <td>Количество спонсоров:</td>
                                <td>{{ $project->getSposoredCount() }}</td>
                            </tr>
                            
                            @if($project->projectProcent()<70)
                                <tr>
                                    <td>Правило Пост-модерации:</td>
                                    <td>Собрано меньше 70% от необходимой суммы</td>
                                </tr>
                                
                                <tr>
                                    
                                        <form action="{{route('a_postmodprojects.update',$project->id)}}" 
                                              method="post"
                                              class="js_submit"
                                              id-want='Продлить размещение проекта'>
                                            {{csrf_field()}}
                                            {{ method_field('PUT') }}
                                            <input type="hidden" name="action" value="continue">
                                            <td>
                                                <button class="btn btn-warning">Продлить размещение проекта на</button>
                                            </td>
                                            <td>
                                                <input type="number" name="days" value="10" min="10" max="100" placeholder="10-100 дней"> Дней
                                            </td>
                                        </form> 
                                    
                                </tr>
                            @endif   
                            
                            @if($project->projectProcent()>=70)
                                <tr>
                                    <td>Правило Пост-модерации:</td>
                                    <td>Собрано больше 70%, но меньше 100% от необходимой суммы</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="success">
                                        <form action="{{route('a_postmodprojects.update',$project->id)}}" 
                                              method="post"
                                              class="js_submit"
                                              id-want='Закрыть проект как успешный'>
                                            {{csrf_field()}}
                                            {{ method_field('PUT') }}
                                            <input type="hidden" name="action" value="closesuccess">
                                                <button class="btn btn-warning pull-right">Закрыть проект как успешный</button>
                                        </form> 
                                    </td>
                                </tr>
                            @endif
                            
                                <tr>
                                    <td colspan="2">
                                        <form action="{{route('a_postmodprojects.update',$project->id)}}" 
                                              method="post"
                                              class="js_submit"
                                              id-want='ЗАКРЫТЬ проект, вернуть средства спонсорам!!!'>
                                            {{csrf_field()}}
                                            {{ method_field('PUT') }}
                                            <input type="hidden" name="action" value="closedfail">
                                            <button class="btn btn-danger pull-right">ЗАКРЫТЬ проект, вернуть средства спонсорам!!!</button>
                                        </form>       
                                    </td>
                                </tr>
                            
                            
                        </table>
                        

                    </div>


                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <a class="btn btn-info pull-left" href="{{route('a_postmodprojects.index')}}">К списку проектов на пост модерации</a>
     
        </div>   
</div>
    
</div>


@endsection
@section('admin_script')
<script>
$(document).ready(function () {
    $('.js_submit').on('submit',function(){
        var text = $(this).attr('id-want');

        return confirm('Вы уверены ? '+ text);
    })

  
});

</script>
@endsection