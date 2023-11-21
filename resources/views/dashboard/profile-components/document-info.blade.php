<div class="row my-2 p-3 ">
    <div class="form-group col-12">
        <h4 class="intor-tital">Documents info</h4>
    </div>
    <div class="col-12 mx-auto">

        <div class="form-row">
            <div class="col-md-3 pt-3">
                <form action="{{route('vendor.profile.update.banner')}}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="bannerImg">Banner Image :</label>
                        <input type="file" class="form-control-file border" name="banner" id="bannerImg" required>
                        <button type="submit" class="btn btn-info btn-sm btn-block  rounded-0 ">Upload</button>
                    </div>
                </form>
            </div>

            <div class="col-md-3 pt-3 ">
                <form action="{{route('vendor.profile.update.logo')}}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="logoImg">LOGO Image :(100X100) </label>
                        <input type="file" class="form-control-file border" name="logo" id="logoImg" required/>
                        <button type="submit" class="btn btn-info btn-sm btn-block  rounded-0 ">Upload</button>
                    </div>
                </form>
            </div>

            <div class="col-md-3 pt-3">
                <form action="{{route('vendor.profile.update.pan')}}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="bannerImg">PAN Image : (400X400) </label>
                        <input type="file" class="form-control-file border" name="pan_image" id="panImg" required/>
                        <button type="submit" class="btn btn-info btn-sm btn-block  rounded-0 ">Upload</button>
                    </div>
                </form>
            </div>

            <div class="col-md-3 pt-3">

                <form action="{{route('vendor.profile.update.business.certificate')}}" enctype="multipart/form-data"
                      method="post">
                    @csrf
                    <div class="form-group">
                        <label for="bannerImg">Business Certificate : <small>allow pdf</small> </label>
                        <input type="file" class="form-control-file border" name="business_certificate_image"
                               id="businessCertificateImg" required/>
                        <button type="submit" class="btn btn-info btn-sm btn-block  rounded-0 ">Upload</button>
                    </div>
                </form>
            </div>
        </div>


    </div>
</div>

<div class="row my-4 p-3 border">
    @if (strpos($vendor->banner,'.'))
        <div class="col-md-3">
            <div class="image-div">
                <img src="{{cdn($vendor->banner)}}" class="img-thumbnail" alt="" srcset="">
            </div>
        </div>
    @endif
    @if (strpos($vendor->logo,'.'))
        <div class="col-md-3">
            <div class="image-div text-center">
                <img src="{{cdn($vendor->logo)}}" height="250" alt="" srcset="" class="img-thumbnail">
            </div>
        </div>
    @endif
    @if($vendorDocument)
        <div class="col-md-3">
            <div class="image-div text-center">
                <img src="{{cdn($vendorDocument->pan_image ?? '')}}" height="250" alt="" srcset=""
                     class="img-thumbnail">
            </div>
        </div>
        <div class="col-md-3">
            <div class="image-div text-center">
                <img src="{{cdn($vendorDocument->business_certificate_image ?? '')}}" height="250" alt="" srcset=""
                     class="img-thumbnail">
            </div>
        </div>
    @endif
</div>
