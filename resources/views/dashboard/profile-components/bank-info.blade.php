<input type="hidden" id="currentBankName" value="{{$vendorDocument->bank_name ?? ''}}">
<input type="hidden" id="currentBranchName" value="{{$vendorDocument->branch_name ?? ''}}">
<form action="{{route('vendor.profile.update.bank',$vendor->vendor_id)}}" method="post" name="save_bank_details" id="save_bank_details">
    @csrf
    @method('Patch')
    <div class="form-row">
        <div class="form-group col-12">
            <h4 class="intor-tital">Bank info</h4>
        </div>
        <div class="col-md pt-3">
            <label for="pan">PAN No : <span class="text-danger">*</span></label> <small class="text-danger" id="pan_id_err"></small>
            <input type="text" name="pan_no"
                   id="pan_id"
                   style="text-transform: uppercase;"
                   value="{{$vendorDocument->pan_no ?? ''}}"
                   class="form-control form-control-sm h-70 outline-none rounded-0">

        </div>
        <div class="col-md pt-3">
            <label for="gst">GST No : <span class="text-danger"></span></label> <small class="text-danger" id="gst_id_err"></small>
            <input type="text" name="gst_no"
                   value="{{$vendorDocument->gst_no ?? ''}}"
                   style="text-transform: uppercase;"
                   id="gst_id" class="form-control form-control-sm h-70 outline-none rounded-0">
        </div>
    </div>

    <div class="form-row">
        <div class="col-md  pt-3">
            <label for="bankName">Bank Name : <span class="text-danger">*</span></label> <small class="text-danger" id="bank_name_err"></small>
            <select class="custom-select custom-select-sm h-70 outline-none rounded-0" required name="bank_name" id="bank_name">
                <option value="">--select bank--</option>
                <option value="Abhyudaya Cooperative Bank">Abhyudaya Cooperative Bank</option><option value="Ahmedabad Mercantile Co Operative Bank">Ahmedabad Mercantile Co Operative Bank</option><option value="Airtel Payments Bank">Airtel Payments Bank</option><option value="Akola Janata Commercial Co Operative Bank">Akola Janata Commercial Co Operative Bank</option><option value="Allahabad Bank">Allahabad Bank</option><option value="Almora Urban Cooperative Bank">Almora Urban Cooperative Bank</option><option value="Andhra Bank">Andhra Bank</option><option value="Andhra Pragathi Grameena Bank">Andhra Pragathi Grameena Bank</option><option value="Australia and New Zealand Banking Group">Australia and New Zealand Banking Group</option><option value="Axis Bank">Axis Bank</option><option value="Bandhan Bank">Bandhan Bank</option><option value="Bank of America">Bank of America</option><option value="Bank of Baharain and Kuwait BSC">Bank of Baharain and Kuwait BSC</option><option value="Bank of Baroda">Bank of Baroda</option><option value="Bank of Ceylon">Bank of Ceylon</option><option value="Bank of India">Bank of India</option><option value="Bank of Maharashtra">Bank of Maharashtra</option><option value="Bank of Tokyo Mitsubishi">Bank of Tokyo Mitsubishi</option><option value="Barclays Bank">Barclays Bank</option><option value="Bassein Catholic Cooperative Bank">Bassein Catholic Cooperative Bank</option><option value="Canara Bank">Canara Bank</option><option value="Catholic Syrian Bank">Catholic Syrian Bank</option><option value="Central Bank of India">Central Bank of India</option><option value="Citi Bank">Citi Bank</option><option value="City Union Bank">City Union Bank</option><option value="Corporation Bank">Corporation Bank</option><option value="DCB Bank">DCB Bank</option><option value="Dena Bank">Dena Bank</option><option value="Deogiri Nagari Sahakari Bank Aurangabad">Deogiri Nagari Sahakari Bank Aurangabad</option><option value="Deustche Bank">Deustche Bank</option><option value="Dhanalakshmi Bank">Dhanalakshmi Bank</option><option value="Federal Bank">Federal Bank</option><option value="Gurgaon Gramin Bank">Gurgaon Gramin Bank</option><option value="HDFC Bank">HDFC Bank</option><option value="Himachal Pradesh State Cooperative Bank">Himachal Pradesh State Cooperative Bank</option><option value="HSBC Bank">HSBC Bank</option><option value="ICICI Bank">ICICI Bank</option><option value="IDBI Bank">IDBI Bank</option><option value="IDFC Bank">IDFC Bank</option><option value="Indian Bank">Indian Bank</option><option value="Indian Overseas Bank">Indian Overseas Bank</option><option value="Indusind Bank">Indusind Bank</option><option value="Jammu and Kashmir Bank">Jammu and Kashmir Bank</option><option value="Karnataka Bank">Karnataka Bank</option><option value="Karnataka Vikas Grameena Bank">Karnataka Vikas Grameena Bank</option><option value="Karur Vysya Bank">Karur Vysya Bank</option><option value="Kerala Gramin Bank">Kerala Gramin Bank</option><option value="Kotak Mahindra Bank">Kotak Mahindra Bank</option><option value="Lakshmi Vilas Bank">Lakshmi Vilas Bank</option><option value="Nainital Bank">Nainital Bank</option><option value="Oriental Bank of Commerce">Oriental Bank of Commerce</option><option value="Pragathi Krishna Gramin Bank">Pragathi Krishna Gramin Bank</option><option value="Prathama Bank">Prathama Bank</option><option value="Punjab and Sind Bank">Punjab and Sind Bank</option><option value="Punjab National Bank">Punjab National Bank</option><option value="RBL Bank">RBL Bank</option><option value="Reserve Bank of India">Reserve Bank of India</option><option value="South Indian Bank">South Indian Bank</option><option value="Standard Chartered Bank">Standard Chartered Bank</option><option value="State Bank of Bikaner and Jaipur">State Bank of Bikaner and Jaipur</option><option value="State Bank of Hyderabad">State Bank of Hyderabad</option><option value="State Bank of India">State Bank of India</option><option value="State Bank of Mysore">State Bank of Mysore</option><option value="State Bank of Patiala">State Bank of Patiala</option><option value="State Bank of Travancore">State Bank of Travancore</option><option value="Syndicate Bank">Syndicate Bank</option><option value="Tamilnad Mercantile Bank">Tamilnad Mercantile Bank</option><option value="UCO Bank">UCO Bank</option><option value="United Bank of India">United Bank of India</option><option value="Vijaya Bank">Vijaya Bank</option><option value="Yes Bank">Yes Bank</option>
                <option value="Zila Sahakri Bank">Zila Sahakri Bank</option>
                <option value="AU Small Finance Bank">AU Small Finance Bank</option>
                <option value="Fino Payments Bank">Fino Payments Bank</option>
                <option value="Paytm Payments Bank">Paytm Payments Bank</option>

            </select>
        </div>
        <div class="col-md  pt-3">
            <label for="open">Branch Name : <span class="text-danger">*</span></label> <small class="text-danger" id="branch_name_err"></small>
            <input type="text" required  list="datalist_branch_name"  class="form-control form-control-sm h-70 outline-none rounded-0"  name="branch_name" id="branch_name">
            <datalist id="datalist_branch_name">
                <option value="noida">Noida</option>
                <option value="delhi">Delhi</option>
                <option value="lko">Lucknow</option>
            </datalist>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md pt-3">
            <label for="account_no">Account No : <span class="text-danger">*</span></label> <small class="text-danger" id="account_no_err"></small>
            <input type="text" name="account_no"
                   value="{{$vendorDocument->account_no ?? ''}}"
                   id="account_no" class="number form-control form-control-sm h-70 outline-none rounded-0">
        </div>
        <div class="col-md pt-3">
            <label for="account_holder">Account Holder : <span class="text-danger">*</span></label> <small class="text-danger" id="account_holder_err"></small>
            <input type="text" name="account_holder"
                   value="{{$vendorDocument->account_holder ?? ''}}"
                   id="account_holder" class=" form-control form-control-sm h-70 outline-none rounded-0">
        </div>
    </div>
    <div class="form-row">
        <div class="col-md pt-3">
            <label for="ifsc">IFSC Code : <span class="text-danger">*</span></label> <small class="text-danger" id="ifsc_err"></small>
            <input type="text" name="ifsc" id="ifsc"
                   value="{{$vendorDocument->ifsc ?? ''}}"
                   style="text-transform: uppercase;"
                   class="form-control form-control-sm h-70 outline-none rounded-0">
        </div>
        <div class="col-md pt-3">
            <label for="kyc">KYC (If any):</label>
            <input type="text" name="kyc"
                   value="{{$vendorDocument->kyc ?? ''}}"
                   id="kyc" class="form-control form-control-sm h-70 outline-none rounded-0">
        </div>
    </div>
    <div class="form-row py-4 ">
        <div class="col-md-6 text-left">
        </div>
        <div class="col-md-6 text-right">
            <button type="submit" class="btn btn-info rounded-0 btn-submit btn-submit-bank" value="save">Save</button>
        </div>
    </div>
</form>
