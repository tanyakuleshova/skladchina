<section class="project_requisites">
    <h3 class="text-center m">
        Реквизиты проекта {{$project->name}}
    </h3>
    <div class="col-md-12">

        <h2>Сканы :</h2>
        @if($project->requisites)
        @if($project->requisites->galleries)
        @foreach($project->requisites->galleries as $gallery)
        <img width="500" height="500" src="{{asset($gallery->image)}}"></a>
        @endforeach
        @endif
        @endif

    </div>

    <div class="col-lg-12 details_project_aboutProject">
        @if($project->requisites)
        @if($project->requisites->type_proj == 'individual')
        <h3>Юридична особа</h3>
        <span>Посада: </span><strong>{{$project->requisites->position}}</strong>
        <br>
        <span>ПІБ: </span><strong>{{$project->requisites->FIO}}</strong>
        <br>
        <span>Повна назва організації: </span>
        <strong>{{$project->requisites->name_organ}}</strong>
        <br>
        <span>Країна реєстрації: </span>
        <strong>{{$project->requisites->country_register}}</strong>
        <br>
        <span>Місто: </span><strong>{{$project->requisites->city}}</strong>
        <br>
        <span>Телефон: </span><strong>{{$project->requisites->phone}}</strong>
        <br>
        <span>Код ЄДРПОУ: </span><strong>{{$project->requisites->inn_or_rdpo}}</strong>
        <br>
        <span>Юридична адреса: </span>
        <strong>{{$project->requisites->legal_address}}</strong>
        <br>
        <span>Фактична адреса: </span>
        <strong>{{$project->requisites->physical_address}}</strong>
        <br>
        <span>Код банку: </span><strong>{{$project->requisites->code_bank}}</strong>
        <br>
        <span>Розрахунковий рахунок: </span>
        <strong>{{$project->requisites->сhecking_account}}</strong>
        <br>
        <span>Інше: </span><strong>{{$project->requisites->other}}</strong>
        <br>
        @elseif($project->requisites->type_proj == 'FOP')
        <h3>Фізична особа</h3>
        <span>ПІБ: </span><strong>{{$project->requisites->FIO}}</strong>
        <br>
        <span>Дата народження: </span><strong>{{$project->requisites->date_birth}}</strong>
        <br>
        <span>Країна реєстрації: </span><strong>{{$project->requisites->country_register}}</strong>
        <br>
        <span>Місто: </span><strong>{{$project->requisites->city}}</strong>
        <br>
        <span>Телефон: </span><strong>{{$project->requisites->phone}}</strong>
        <br>
        <span>ІНН: </span><strong>{{$project->requisites->inn_or_rdpo}}</strong>
        <br>
        <span>Ким виданий : </span><strong>{{$project->requisites->issued_by_passport}}</strong>
        <br>
        <span>Коли виданий: </span><strong>{{$project->requisites->date_issued}}</strong>
        <br>
        <span>Код банку: </span><strong>{{$project->requisites->code_bank}}</strong>
        <br>
        <span>Розрахунковий рахунок: </span><strong>{{$project->requisites->сhecking_account}}</strong>
        <br>
        <span>Інше: </span><strong>{{$project->requisites->other}}</strong>
        <br>
        @else
        <h3>Підприємець</h3>
        <span>Найменування / ПІБ: </span><strong>{{$project->requisites->FIO}}</strong>
        <br>
        <span>Країна реєстрації: </span><strong>{{$project->requisites->country}}</strong>
        <br>
        <span>Місто: </span><strong>{{$project->requisites->city}}</strong>
        <br>
        <span>Телефон: </span><strong>{{$project->requisites->phone}}</strong>
        <br>
        <span>Код ЄДРПОУ: </span><strong>{{$project->requisites->inn_or_rdpo}}</strong>
        <br>
        <span>Юридична адреса: </span><strong>{{$project->requisites->legal_address}}</strong>
        <br>
        <span>Фактична адреса: </span><strong>{{$project->requisites->physical_address}}</strong>
        <br>
        <span>Код банку: </span><strong>{{$project->requisites->code_bank}}</strong>
        <br>
        <span>Розрахунковий рахунок: </span><strong>{{$project->requisites->сhecking_account}}</strong>
        <br>
        <span>Інше: </span><strong>{{$project->requisites->other}}</strong>
        <br>
        @endif
        @endif

    </div>
</section>