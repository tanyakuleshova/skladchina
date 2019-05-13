@extends('layouts.app')
@section('content')
<div class="wrap">
	<section class="create_project show-update">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h2 class="caption">ОБНОВЛЕНИЕ к проекту {{ $project->name }}</h2>
				</div>
			</div>
			@if($upd->image)  
			<div class="row">
				<div class="col-md-12">
					<div class="media_profile">
						<img src="{{asset($upd->image)}}" class="img-responsive">
					</div>
				</div>
			</div>
			@endif
			<div class="row">
				<div class="col-md-12">
					<div class="description">
						<label>Статус</label>
						{{ $upd->status->name  }}
					</div>
				</div>

				<div class="col-md-12">
					<div class="description">
						<label>Описание</label>
						{!! $upd->shotDesc  !!}
					</div>
				</div>

				<div class="col-md-12">
					<div class="description">
						<label>Описание</label>
						{!! $upd->text  !!}
					</div>
				</div>
			</div>


			<div class="row">
				<div class="col-md-12">
					<div class="update-navigation">
						<a href="{{ route('myprojects.index') }}" class="btn btn-info">Назад, Мои проекты</a>
						<a href="{{ route('projectup.index') }}?project_id={{ $project->id }}" class="btn btn-info">Назад, Мои обновления</a>
					</div>
				</div>
			</div>

		</div>
	</section>
</div>
@endsection