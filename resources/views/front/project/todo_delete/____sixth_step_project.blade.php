@extends('layouts.app')
@section('style')
<link href="{{asset('administrator/css/plugins/summernote/summernote.css')}}" rel="stylesheet">
<link href="{{asset('administrator/css/plugins/summernote/summernote-bs3.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="wrap">
	<section>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h2 class="create_title"><span class="greeny">{{trans('createproject.createprj')}}</h2>
				</div>
			</div>
		</div>
	</section>
	@if(Session::has('success_message'))
		<div class="container">
			<div class="alert alert-success">{{Session::get('success_message')}}</div>
		</div>
	@endif
	@if(Session::has('warning_message'))
		<div class="container">
			<div class="alert alert-warning">{{Session::get('warning_message')}}</div>
		</div>
	@endif
	<section class="create_tabs">
		<div class="wide-border">
                    @include('front.project.show_steps.navigation_steps',['nstep'=>6,'project'=>$project])
		</div>
		<div class="container">
			<!-- Tab panes -->
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="tab6">
					<div class="row">
						<div class="col-md-8">
							<div class="create_project create_finish">
								<div class="description">
                                                                    {!!trans('createproject.moderationtext')!!}
								</div>
								<div class="create_finish_manager">
									<img src="img/manager_img.jpg" height="86" width="129">
								</div>
								<h4>{{trans('createproject.managername')}}</h4>
								<div class="mail">
									<p>
										<img src="{{asset('images/front/mail.png')}}" height="12" width="15">
										{{trans('createproject.managermail')}}
									</p>
								</div>
								<div class="skype">
									<p>
										<img src="{{asset('images/front/skype.png')}}" height="14" width="14">
										{{trans('createproject.managerskype')}}
									</p>
								</div>
								<form class="buttons_project" action="{{route('delete_add_project',$project->id)}}" method="post">
									{{csrf_field()}}
									<a href="{{route('send_to_moderation',$project->id)}}"  class="btn project_moderation_btn">{{trans('createproject.sendmoderation')}}</a>
								</form>
							</div>
						</div>
						<div class="col-md-4 create_view">
								<div class="previous_view">
									<img class="create_view_img" src="{{asset('images/front/view.png')}}" height="10"
									width="16" alt="">
									<a href="#">{{trans('createproject.previewproj')}}</a>
								</div>
							
								<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-12">
										<div class="product_wrap create_product_wrap">
											<a href="{{route('show_project',$project->id)}}">
												<img src="{{asset($project->poster_link)}}"/>
											</a>
											<div class="product_wrap_info">
												<div class="description">
													<a href="{{route('show_project',$project->id)}}">
														<h3>{{$project->name}}</h3>
													</a>
													<p>{{$project->short_desc}}</p>
													<span>Автор:
														<a href=""> {{Auth::user()->name.' '.Auth::user()->last_name}}</a>
													</span>
													<div class="media">
														<p>
															<img src="{{asset('images/front/media.png')}}" width="15" height="15">
															{{ ($project->categoryProject && $project->categoryProject->cld)?$project->categoryProject->cld->name:''}}
														</p>
													</div>
													<div class="place">
														<p>
															<img src="{{asset('images/front/place.png')}}" width="12" height="15">
															{{($project->projectCity && $project->projectCity->cld)?$project->projectCity->cld->name:''}}
														</p>
													</div>
												</div>
												<div class="stats">
													<div class="progress">
														<div class="progress-bar progress-bar-success" role="progressbar"
															aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"
															style="width: 10%">
															<span class="sr-only">{{$project->projectProcent()}}% Complete (success)</span>
														</div>
													</div>
													<div class="row">
														<div class="col-xs-4 col-md-4 product_statistics">
															<div class="chose_number">
																{{round($project->projectProcent(),2)}}%
															</div>
															<div class="chose_description">
																{{trans('listprojectsall.progress')}}
															</div>
														</div>
														<div class="col-xs-4 col-md-4 product_statistics product_statistics_center">
															<div class="chose_number">
																{{$project->current_sum}} грн
															</div>
															<div class="chose_description">
																{{trans('listprojectsall.sobral')}}
															</div>
														</div>
														<div class="col-xs-4 col-md-4 product_statistics">
															<div class="chose_number">
																16 годин
															</div>
															<div class="chose_description">
																{{trans('listprojectsall.ostalos')}}
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
@endsection
@section('script')
<script src="{{asset('administrator/js/plugins/summernote/summernote.min.js')}}"></script>
<script>
	$(document).ready(function () {
		$('.summernote').summernote();
	});
</script>
@endsection