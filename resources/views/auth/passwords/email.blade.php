@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row restoring_wrap">
		<div class="col-md-8 col-md-offset-2">
			<h2 class="text-center"><span class="greeny">Восстановление</span> пароля</h2>
			<div class="registration_inner">
				@if (session('status'))
				<div class="alert alert-success">
					{{ session('status') }}
				</div>
				@endif

				<form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
					{{ csrf_field() }}

					<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
						   <label for="email" class="col-md-12">Введите E-Mail</label>

						<div class="col-md-12">
							<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="E-Mail" required>
							@if ($errors->has('email'))
							<span class="help-block">
								<strong>{{ $errors->first('email') }}</strong>
							</span>
							@endif
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-12 text-center">
							<button type="submit" class="btn">Отправить</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
