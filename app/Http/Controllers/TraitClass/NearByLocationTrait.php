<?php

namespace App\Http\Controllers\TraitClass;

use Exception;
use Illuminate\Http\Request;
use App\Models\NearByLocation;
use Illuminate\Support\Facades\Storage;

trait NearByLocationTrait
{
    public function updateNeraByLocation($city, $locality, $near)
    {
        try {
            $getData = NearByLocation::where('city', $city)
                ->where('locality', $locality)
                ->count();
            if (!$getData) {
                $location = new NearByLocation();
                $location->city = $city;
                $location->locality = $locality;
                $location->near = $near;
                $location->save();
            }
        } catch (Exception $e) {
            report($e);
        }
    }
}
