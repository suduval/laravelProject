<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddPropertyRequest;
use App\Http\Requests\UpdatePropertyAnalyticsRequest;
use App\Models\Property;

class PropertiesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddPropertyRequest $request)
    {
        $aProperty = $request->only('suburb', 'state', 'country');

        try{
            $oProperty = Property::create($aProperty);
            return response()->json(['status' => 1, 'message' => 'New Property Added', 'property' => $oProperty]);

        }catch(\Exception $exception){
            return response()->json(['status' => 0, 'message' => 'Something Went Wrong Contact Admin']);
        }
    }

    public function update(UpdatePropertyAnalyticsRequest $request){

        $oProperty = Property::find($request->get('property'));
        $iAnalyticTypeId = $request->get('analytic_types');
        $fValue = $request->get('value');

        $aAttachments = [$iAnalyticTypeId => ['value' => $fValue]];

        $oProperty->analyticTypes()->syncWithoutDetaching($aAttachments);

        return response()->json(['status' => 1, 'message' => 'Property Analytic Types Updated']);

    }


}
