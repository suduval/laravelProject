<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyAnalytic;

class SummaryController extends Controller
{
    public function summary($sSearchParam, $aValue){

        //Accepted Search Params
        $aSearchParams = ['suburb', 'state', 'country'];

        if(!in_array($sSearchParam, $aSearchParams)){
            return response()->json(['status' => 0, 'message' => 'Invalid Search Param'], 400);
        }

        $aPropertyIds = Property::where($sSearchParam, '=', $aValue)->get()->pluck('id');

        if(count($aPropertyIds) == 0){
            return response()->json(['status' => 0, 'message' => 'Invalid Search Value for '.$sSearchParam], 400);
        }

        $aPropertyAnalytics = PropertyAnalytic::whereIn('property_id', $aPropertyIds)->get()->sortBy('value')->pluck('value');

        if(count($aPropertyAnalytics) == 0){
            return response()->json(['status' => 0, 'message' => 'No Property Summary Available for Given '.$sSearchParam. ' And '. $aValue], 400);
        }

        $aOutput = ['minValue' => $aPropertyAnalytics->first(),
            'maxValue' => $aPropertyAnalytics->last(),
            'medianValue' => $this->getMedianValue($aPropertyAnalytics),
            'propertiesWithValue' => $this->getPropertiesWithValue($aPropertyAnalytics),
            'propertiesWithoutValue' => $this->getPropertiesWithoutValue($aPropertyAnalytics)];

        return response()->json(['status' => 1, 'summary' => $aOutput]);

    }

    private function getMedianValue($aPropertyAnalytics){
        $aGroups = $aPropertyAnalytics->split(2);
        if(isset($aGroups[1])){
            return $aGroups[1]->first();
        }
        return $aGroups[0]->last();
    }

    private function getPropertiesWithValue($aPropertyAnalytics){

        $oFilter = $aPropertyAnalytics->filter(function ($value, $key){
            if($value !=0){
                return true;
            }
        });
        $iPropertiesWithValue =  $oFilter->count();

        return ($iPropertiesWithValue/ $aPropertyAnalytics->count()) * 100;

    }

    private function getPropertiesWithoutValue($aPropertyAnalytics){

        $oFilter = $aPropertyAnalytics->filter(function ($value, $key){
            if($value ==0 ){
                return true;
            }
        });
        $iPropertiesWithoutValue =  $oFilter->count();

        return ($iPropertiesWithoutValue/ $aPropertyAnalytics->count()) * 100;
    }
}
