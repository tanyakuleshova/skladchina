{{-- на входе обхект $project --}}
<div class="col-xs-12 col-sm-6 col-md-4">
    <div class="product_wrap">
       @include('front.project._partials.stickers',['project'=>$project])
       
       @include('front.project.blocks.show_small_project_nowrap',['project'=>$project])
   </div>
</div>
