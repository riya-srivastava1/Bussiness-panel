@extends('layouts.app')
@php
	$data = Auth::guard('business')->user();
@endphp

@section('styles')
	<style>
		.stylist-img-hover:hover{
			transition: .2s;
			transform: scale(7);
		}
		.table td, .table th {
			font-size: 13px;
		}
	</style>
@endsection

@section('content')

<!-- BEGIN .main-content -->
<div id="content" class="app-content">
	<!-- Row start -->
	<div class="row gutters">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
			<div class="card bg-white">
				<div class="card-header">
                    Manage Slider
				</div>

				<div class="card-body">
                    <form class="row" action="{{route('vendor.slider.store')}}" enctype="multipart/form-data" method="post" id="form-signin">
                        @csrf
                        <div class="control-group col">
                            <input type="text" name="title" id="title" class="form-control overflow-hidden" placeholder="title" >
                            <label for="title"><span class="text-danger"></span></label>
                        </div>
                        <div class="control-group col">
                            <input type="file" name="image" id="image" class="form-control overflow-hidden" placeholder="Image" required>
                            <label for="image"><span class="text-danger"></span></label>
                        </div>
                        <div class="control-group text-right col-2">
                            <button type="submit" class="btn btn-info ">Upload</button>
                        </div>
                    </form>
				</div>

				<div class="card-body">
					<table class="table table-bordered text-center">
						<thead>
							<tr>
								<th>#</th>
								<th>Title</th>
								<th>Image</th>
							</tr>
                        </thead>
                        <tbody>
                            @foreach($sliders as $slider)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$slider->title}}</td>
                                <td>
                                    <div class=''>
                                        <form action="{{route('vendor.slider.destroy',['id'=>$slider->id])}}" method="post">
                                            @csrf @method('delete')
                                            <button type="submit" class="btn btn-link" onclick="return confirm('Are you sure you want to delete this item?');">Delete</button>
                                        </form>
                                        {{-- <img class="w-100" height="300" width="500" src="{{cdn('uploads/slider/'.$slider->image)}}" alt="{{$slider->image}}" /> --}}
                                        <img class="w-100" height="300" width="500" src="{{cdn($slider->image)}}" alt="{{$slider->image}}" />
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- Row end -->

</div>






@endsection

@section('scripts')
<script src="{{asset('business-lib/dashboard/js/matrix.interface.js')}}"></script>
<script>





</script>
@endsection
