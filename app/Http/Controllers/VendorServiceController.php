<?php

namespace App\Http\Controllers;

use Exception;
use DataTables;
use App\Models\Business;
use App\Models\Category;
use App\Models\SubService;
use App\Models\ServiceType;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\VendorProfile;
use App\Models\VendorService;
use App\Events\VendorLogEvent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\VendorServiceResource;
use PhpOffice\PhpSpreadsheet\Calculation\Web\Service;

class VendorServiceController extends Controller
{
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'image' => ['max:50', 'mimes:PNG,png,jpg,JPG,JPEG,jpeg'],
        ]);
    }

    public function services(Request $request)
    {
        $vendor = Auth::guard('business')->user();
        $edit_permission =  $vendor->vendor_profile->edit_permission;
        $vendor_id = $vendor->vendor_id;

        if ($request->ajax()) {
            $data = VendorServiceResource::collection(VendorService::where('vendor_id', $vendor_id)->latest()->get());
            return Datatables::of($data)->addColumn('action', function ($data) use ($edit_permission) {
                if ($edit_permission == 'Read') {
                    $button = '---';
                } else {
                    $buttonClass = 'text-danger';
                    $buttonLabel = 'Deactive';
                    if ($data['status'] == 'true') {
                        $buttonClass = 'text-success';
                        $buttonLabel = 'Active';
                    }
                    $button = '<div class="btn-group btn-group-sm"><a href="' . route('vendor.service.update.status', $data['id']) . '" class="btn btn-link px-0 ' . $buttonClass . '" >' . $buttonLabel . '</a> ';
                    $button .= '<a href="' . route('vendor.service.edit', $data['id']) . '" class="btn btn-link px-0"> | Edit</a>';
                    $button .= '<button type="button"  id="' . $data['id'] . '" class="delete btn btn-link px-0"> | Delete</button></div>';
                }
                return $button;
            })
                ->rawColumns(['action'])->addIndexColumn()->toJson();
        }
        return view('dashboard.services', compact(['vendor_id', 'edit_permission']));
    }

    public function create()
    {
        $vendor_id = Auth::guard('business')->user()->vendor_id;
        $profile   = VendorProfile::where('vendor_id', $vendor_id)->with('vendorDocument')->first();
        $vendor_gst_type = false;
        if (empty($profile->vendorDocument)) {
            $vendor_gst_type = false;
        } else if (empty($profile->vendorDocument->gst_no)) {
            $vendor_gst_type = false;
        } else {
            $vendor_gst_type = true;
        }
        $serviceType = '';
        $services = '';
        $category_type = $profile->category_type;
        if ($category_type) {
            // $cn = substr($category_type, 0, -1);
            $arr = [];
            foreach (explode(',', $category_type) as $ex) {
                $g = Category::select('id')->whereIn('category_name', [$ex])->first();
                if ($g) {
                    $arr = Arr::prepend($arr, $g->id);
                }
            }
            $serviceType = ServiceType::whereIn('category_id', $arr)->get();
        }

        if ($vendor_gst_type) {
            return view('dashboard.services.add-service-with-gst', compact(['serviceType', 'vendor_id']));
        } else {
            return view('dashboard.services.add-service-with-none-gst', compact(['serviceType', 'vendor_id']));
        }
    }

    public function store(Request $request)
    {
        $service_type_name = '';
        $service_name = '';
        if ("package" == $request->type) {
            $request->validate(['service_type_name' => 'required', 'package_name' => 'required', 'package_description' => 'required', 'actual_price']);
            $service_type_name =  $request->service_type_name;
        } else {
            $request->validate(['service_id' => 'required', 'sub_service_name' => 'required', 'actual_price']);
            $serviceData = Service::findOrFail($request->service_id);
            $service_name = $serviceData->service_name;
            $service_type_name =  $serviceData->serviceType->service_type_name ?? '';
        }

        $vendorService = new VendorService;
        $vendorService->vendor_id               =   $request->vendor_id;
        $vendorService->service_id              =   $request->service_id;
        $vendorService->service_name            =  $service_name;
        $vendorService->service_type_name       =   $service_type_name;
        $vendorService->type                    =   $request->type;
        $vendorService->created_by              =   'vendor';
        $vendorService->package_name            =   $request->package_name;
        $vendorService->package_category        =   $request->package_category;
        $vendorService->package_description     =   $request->package_description;
        $vendorService->sub_service_name        =   $request->sub_service_name;
        $vendorService->duration                =   intval($request->duration);
        $vendorService->available_for           =   $request->available_for;

        // User End
        $vendorService->actual_price            =   doubleval($request->actual_price);
        $vendorService->discount_type           =   intval($request->discount_type);
        $vendorService->discount                =   doubleval($request->discount);
        $vendorService->discount_valid          =   intval($request->discount_valid);
        $vendorService->actual_discount_amount  =   doubleval($request->actual_discount_amount);
        $vendorService->discount_price          =   doubleval($request->list_price);
        $vendorService->after_discount_price    =   doubleval($request->after_discount_price);
        $vendorService->gst                     =   doubleval($request->gst);
        $vendorService->pre_gst_amount          =   doubleval($request->pre_gst_amount);
        $vendorService->list_price              =   doubleval($request->list_price);
        $vendorService->final_vendor_collection =   doubleval($request->final_vendor_collection);
        $vendorService->vendor_earning          =   doubleval($request->vendor_earning);
        $vendorService->internet_charge         =   doubleval($request->internet_charge);
        $vendorService->internet_charge_amount  =   doubleval($request->internet_charge_amount);
        $vendorService->settlement_amount       =   doubleval($request->settlement_amount);

        // Zoylee end
        $vendorService->commission_on           =   intval($request->commission_on);
        $vendorService->commission_type         =   intval($request->commission_type);
        $vendorService->commission              =   doubleval($request->commission);
        $vendorService->commission_pass_on      =   doubleval($request->commission_pass_on);
        $vendorService->commission_amount       =   doubleval($request->commission_amount);
        $vendorService->gst_on_zoylee_commission =   doubleval($request->gst_on_zoylee_commission);
        $vendorService->zoylee_net_income       =   doubleval($request->zoylee_net_income);
        $vendorService->zoylee_user_discount    =   doubleval($request->zoylee_user_discount);
        $vendorService->final_zoylee_income     =   doubleval($request->final_zoylee_income);
        $vendorService->status                  =   $request->status == "true" ? true : false;

        if ($vendorService->save()) {
            try {
                $this->updateMaxDiscountMinPrice($request->vendor_id);
            } catch (Exception $e) {
                report($e);
            }
            return redirect()->route('business.dashboard.services')->with('success', "Successfully Added");
        }
        return back()->with('error', "Something went worng");
    }

    public function edit($id)
    {
        $vendorService = VendorService::find($id);
        $profile = VendorProfile::where('vendor_id', $vendorService->vendor_id)->with('vendorDocument')->first();
        $category_type = $profile->category_type;
        $vendor_gst_type = false;
        if (empty($profile->vendorDocument)) {
            $vendor_gst_type = false;
        } else if (empty($profile->vendorDocument->gst_no)) {
            $vendor_gst_type = false;
        } else {
            $vendor_gst_type = true;
        }

        $serviceType = '';
        if ($category_type) {
            $cn = substr($category_type, 0, -1);
            $arr = [];
            foreach (explode(',', $category_type) as $ex) {
                $g = Category::select('id')->whereIn('category_name', [$ex])->first();
                if ($g) {
                    $arr = Arr::prepend($arr, $g->id);
                }
            }
            $serviceType = ServiceType::whereIn('category_id', $arr)->get();
        }
        if ($vendor_gst_type) {
            return view('dashboard.services.edit-service-with-gst', compact(['vendorService', 'serviceType']));
        } else {
            return view('dashboard.services.edit-service-with-none-gst', compact(['vendorService', 'serviceType']));
        }
    }


    public function update(Request $request, $vendor_service_id)
    {
        $service_type_name = '';
        $service_name = '';
        if ("package" == $request->type) {
            $request->validate(['service_type_name' => 'required', 'package_name' => 'required', 'package_description' => 'required', 'actual_price']);
            $service_type_name =  $request->service_type_name;
        } else {
            $request->validate(['service_id' => 'required', 'sub_service_name' => 'required', 'actual_price']);
            $serviceData = Service::findOrFail($request->service_id);
            $service_name = $serviceData->service_name;
            $service_type_name =  $serviceData->serviceType->service_type_name ?? '';
        }
        $vendorService                          =   VendorService::find($vendor_service_id);
        $vendorService->vendor_id               =   $request->vendor_id;
        $vendorService->service_name            =   $service_name;
        $vendorService->service_type_name       =   $service_type_name;
        $vendorService->type                    =   $request->type;
        $vendorService->created_by              =   'vendor';
        $vendorService->package_name            =   $request->package_name;
        $vendorService->package_category        =   $request->package_category;
        $vendorService->package_description     =   $request->package_description;
        $vendorService->sub_service_name        =   $request->sub_service_name;
        $vendorService->duration                =   intval($request->duration);
        $vendorService->available_for           =   $request->available_for;

        // User End
        $vendorService->actual_price            =   doubleval($request->actual_price);
        $vendorService->discount_type           =   intval($request->discount_type);
        $vendorService->discount                =   doubleval($request->discount);
        $vendorService->discount_valid          =   intval($request->discount_valid);
        $vendorService->actual_discount_amount  =   doubleval($request->actual_discount_amount);
        $vendorService->discount_price          =   doubleval($request->list_price);
        $vendorService->after_discount_price    =   doubleval($request->after_discount_price);
        $vendorService->gst                     =   doubleval($request->gst);
        $vendorService->pre_gst_amount          =   doubleval($request->pre_gst_amount);
        $vendorService->list_price              =   doubleval($request->list_price);
        $vendorService->final_vendor_collection =   doubleval($request->final_vendor_collection);
        $vendorService->vendor_earning          =   doubleval($request->vendor_earning);
        $vendorService->internet_charge         =   doubleval($request->internet_charge);
        $vendorService->internet_charge_amount  =   doubleval($request->internet_charge_amount);
        $vendorService->settlement_amount       =   doubleval($request->settlement_amount);

        // Zoylee end
        $vendorService->commission_on           =   intval($request->commission_on);
        $vendorService->commission_type         =   intval($request->commission_type);
        $vendorService->commission              =   doubleval($request->commission);
        $vendorService->commission_pass_on      =   doubleval($request->commission_pass_on);
        $vendorService->commission_amount       =   doubleval($request->commission_amount);
        $vendorService->gst_on_zoylee_commission =   doubleval($request->gst_on_zoylee_commission);
        $vendorService->zoylee_net_income       =   doubleval($request->zoylee_net_income);
        $vendorService->zoylee_user_discount    =   doubleval($request->zoylee_user_discount);
        $vendorService->final_zoylee_income     =   doubleval($request->final_zoylee_income);

        $vendorService->status                  =   $request->status == "true" ? true : false;

        if ($vendorService->save()) {
            try {
                $this->updateMaxDiscountMinPrice($request->vendor_id);
            } catch (Exception $e) {
                report($e);
            }
            return redirect()->route('business.dashboard.services')->with('success', "Successfully Updated");
        }
        return back()->with('error', "Something went worng");
    }

    public function updateStatus($id)
    {
        try {
            $getService = VendorService::find($id);
            if ($getService->status == "true") {
                //Generate log-------------------
                $msg = 'Vendor services status Deactive updated - ' . $getService->service_name;
                $eventData = ['vendor_id' => $getService->vendor_id, 'data' => $msg];
                event(new VendorLogEvent($eventData));
                //End generate log-------------------
                $getService->update(['status' => 'false']);
                return back()->with('success', 'Deactive');
            } else {
                $getService->update(['status' => 'true']);
                //Generate log-------------------
                $msg = 'Vendor services status Active updated - ' . $getService->service_name;
                $eventData = ['vendor_id' => $getService->vendor_id, 'data' => $msg];
                event(new VendorLogEvent($eventData));
                //End generate log-------------------
                return back()->with('success', 'Active');
            }
        } catch (Exception $ex) {
            return back()->with('info', 'Please try later');
        }
    }

    public function destroy($id)
    {
        $path = config('app.image_upload_dir') . '/uploads/business/business/';
        $find = VendorService::find($id);
        if (!empty($find)) {
            $l = strpos($find->image, '.');
            if (File::exists($path . $find->image) && $l > 0) {
                @unlink($path . "/" . $find->image);
            }
            //Generate log----------------------
            $msg = 'Vendor services  deleted - ' . $find->service_name;
            $eventData = ['vendor_id' => $find->vendor_id, 'data' => $msg];
            event(new VendorLogEvent($eventData));
            //End generate log----------------------
            if ($find->delete()) {
                Session::flash('success', 'Deleted');
                return back();
            }
        }
        Session::flash('info', 'Failed');
        return back();
    }


    public function ajaxService(Request $request)
    {
        $id =  $request->id;
        $data = Service::where('categories_id', $id)->get();
        $options = "<option>-Select Service-</option>";
        if ($data != null && count($data) > 0) {
            foreach ($data as $d) {
                $options .= "<option value='" . $d->service_name . "' id='" . $d->id . "'>" . $d->service_name . "</option>";
            }
            print_r($options);
            exit;
        }
        echo "<option value=''>No Service Found</option>";
    }

    public function ajaxSubService(Request $request)
    {
        $id = $request->id;
        $data = SubService::where('services_id', $id)->get();
        $options = "<option>-Select Service-</option>";
        if ($data != null && count($data) > 0) {
            foreach ($data as $d) {
                $options .= "<option value='" . $d->sub_name . "' id='" . $d->id . "'>" . $d->sub_name . "</option>";
            }
            print_r($options);
            exit;
        }
        echo "<option value=''>No Service Found</option>";
    }


    private function updateMaxDiscountMinPrice($vendor_id)
    {
        $vendor = VendorProfile::with('services')->where('vendor_id', $vendor_id)->first();
        if ($vendor) {
            $vendor->max_discount = doubleval($vendor->services->max('discount'));
            $vendor->min_price = doubleval($vendor->services->min('discount_price'));
            $vendor->save();
        }
    }
}
