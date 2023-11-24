 @extends('layouts.app')
 @section('dashboard-manage-stylist', 'selected')
 @php
     $data = Auth::guard('business')->user();
 @endphp

 @section('styles')
     <style>
         .stylist-img-hover:hover {
             transition: .2s;
             transform: scale(7);
         }

         .table td,
         .table th {
             font-size: 13px;
         }
     </style>
 @endsection

 @section('content')

     <div id="content" class="app-content">

         <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
             <div class="card bg-white">
                 <div class="card-header">Stylists
                     <span class="float-right"><a href="#" id="add_serive" class="btn btn-success">Add a
                             Stylist</a></span>
                 </div>

                 <div class="card-body" id="Showaddservie" style="display: none;">
                     <form method="post" action="{{ route('vendor.add.stylist.store') }}" class="form-signin-stylists"
                         enctype="multipart/form-data">
                         @csrf
                         <input type="hidden" name="_method" value="" id="stylistformpatch">
                         <div class="form-row">
                             <div class="form-group col-md-3">
                                 <label for="inputEmail4" class="col-form-label">Name <span
                                         class="text-danger">*</span></label>
                                 <input type="text" name="name" id="name" class="form-control" required />
                             </div>
                             <div class="form-group col-md-3">
                                 <label for="inputPassword4" class="col-form-label">Title <span
                                         class="text-danger">*</span></label>
                                 <input type="text" name="title" id="title" class="form-control" required />
                             </div>
                             <div class="form-group col-md-3">
                                 <label for="inputEmail4" class="col-form-label">Experience</label>
                                 <input type="text" name="experience" id="experience" class="form-control" required />
                             </div>

                             <div class="form-group col-md-3">
                                 <label for="inputEmail4" class="col-form-label">Gender served
                                     <span class="text-danger">*</span>
                                 </label>
                                 <select class="custom-select" id="gender_served" name="gender_served" required>
                                     <option value="">Select gender served</option>
                                     <option value="Male">Male</option>
                                     <option value="Female">Female</option>
                                     <option value="Unisex">Unisex</option>
                                 </select>
                             </div>
                         </div>
                         <div class="form-row">
                             <div class="form-group col-md-4">
                                 <label for="inputEmail4" class="col-form-label">Speciality</label>
                                 <textarea class="form-control" name="speciality" id="speciality" style="height: 38px"></textarea>
                             </div>
                             <div class="form-group col-md-4">
                                 <label for="inputPassword4" class="col-form-label">Image</label>
                                 <div class="custom-file">
                                     <input type="file" class="custom-file-input rounded-0" id="image"
                                         name="image">
                                     <label class="custom-file-label text-muted" for="customFile">Choose file</label>
                                 </div>
                             </div>
                             <div class="form-group col-md-4">
                                 <button type="submit" class="btn btn-success margin-top-33 btn-block">Save</button>
                             </div>
                         </div>
                     </form>

                 </div>

                 <div class="card-body">
                     <table class="table table-bordered text-center">
                         <thead>
                             <tr>
                                 <th>#</th>
                                 <th>Image</th>
                                 <th>Name</th>
                                 <th>Title</th>
                                 <th>Gender served</th>
                                 <th>Experience</th>
                                 <th>Speciality</th>
                                 <th>Actions</th>
                             </tr>
                         </thead>
                         <tbody>
                             @foreach ($stylists as $stylist)
                                 <tr>
                                     <td>{{ $loop->iteration }}</td>
                                     <td class="text-center">
                                         <img src="{{ strpos($stylist->image, '.') > 0 ? cdn('uploads/business/stylists/' . $stylist->image) : asset('business-lib/assets/img/stylist.png') }} "
                                             style="height: 30px;" class="stylist-img-hover" alt="" srcset="">
                                     </td>
                                     <td class="text-center">{{ $stylist->name }}</td>
                                     <td class="text-center">{{ $stylist->title }}</td>
                                     <td class="text-center">{{ $stylist->gender_served }}</td>
                                     <td class="text-center">{{ $stylist->experience }}</td>
                                     <td class="text-center">{{ $stylist->speciality }}</td>
                                     <td class="text-center">
                                         <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                             <button class="btn btn-link edit-add-stylist" type="button"
                                                 data-parent="#collapse-group" href="#collapseGTwo" data-toggle="collapse"
                                                 id="{{ $stylist }}">Edit</button>
                                             <button type="button" class="btn btn-link">
                                                 <form
                                                     action="{{ route('vendor.add.stylist.delete', ['id' => $stylist->id]) }}"
                                                     method="post">
                                                     @csrf @method('DELETE')
                                                     <button type="submit" class="btn btn-link"
                                                         onclick="return confirm('Are you sure you want to delete this item?');">
                                                         Delete
                                                     </button>
                                                 </form>
                                             </button>
                                         </div>
                                     </td>
                                 </tr>
                             @endforeach

                         </tbody>
                     </table>
                 </div>
             </div>
         </div>
         <!-- Row end -->
     </div>

 @endsection

 @section('scripts')

 <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

 <script src="{{asset('business-lib/dashboard/js/matrix.interface.js')}}"></script>
 <script>
     $('.edit-add-stylist').click(function() {
         var row = JSON.parse($(this).attr('id'));
         $('#name').val(row['name']);
         $('#title').val(row['title']);
         $('#experience').val(row['experience']);
         $('#speciality').val(row['speciality']);
         $('#gender_served').val(row['gender_served']);
         var route = "{{route('vendor.add.stylist.update',['id'=>'setid'])}}".replace("setid", row['_id']);
         $('.msg-header').html("UPDATE STYLIST INFO");
         $('.form-signin-stylists').attr('action', route);
         $('#stylistformpatch').val("PATCH");
         $('#Showaddservie').slideToggle();
     });
 </script>
 @endsection
