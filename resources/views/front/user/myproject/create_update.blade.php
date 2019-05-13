@extends('layouts.app')
@section('content')
<link href="{{asset('administrator/css/plugins/summernote/summernote.css')}}" rel="stylesheet">
<link href="{{asset('administrator/css/plugins/summernote/summernote-bs3.css')}}" rel="stylesheet">
<div class="wrap">
	<section class="create_project create-update">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h2 class="caption">Создание обновлений</h2>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<form action="{{route('projectup.store')}}" method="post"  enctype="multipart/form-data">
						{{csrf_field()}}
						<input type="hidden" name="project_id" value="{{ $project->id }}">
						<div class="media_profile">
							<a href="#"><img src="{{asset('images/front/add_photo.png')}}" height="88" width="94" alt=""></a>
							<div class="media_profile_info">
								@if ($errors->has('application_image'))
								<span class="help-block">
									<strong>{{ $errors->first('application_image') }}</strong>
								</span>
								@endif
								<input type="file" name="application_image" multiple accept="image/jpeg,image/png" >
							</div>
						</div>
						<label>Название обновления</label>
						@if ($errors->has('shot_desc'))
						<span class="help-block">
							<strong>{{ $errors->first('shot_desc') }}</strong>
						</span>
						@endif
						<input name="shot_desc" class="" placeholder="Введите название обновления" value="{{ old('shot_desc') }}" required>
						<label>Описание</label>
						@if ($errors->has('main_desc'))
						<span class="help-block">
							<strong>{{ $errors->first('main_desc') }}</strong>
						</span>
						@endif
						<textarea name="main_desc"
						class="summernote"
						placeholder="Введите детальное описание обновления" 
						required>{{ old('main_desc')}}</textarea>
						<button class="btn btn-warning" type="submit">Создать обновление к проекту</button>
					</form>
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
<script src="{{asset('administrator/js/plugins/summernote/summernote.min.js')}}"></script>
<script>
$(document).ready(function(){

	$('.summernote').summernote();

});
</script>
@endsection