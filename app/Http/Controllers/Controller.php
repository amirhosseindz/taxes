<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Validate request inputs in ajax mode
     *
     * @param Request $request
     * @param array $rules
     * @param array $niceNames
     */
    protected function ajaxValidate(Request $request, $rules = [], $niceNames = [])
    {
        $validator = \Validator::make($request->all(), $rules);
        if (!empty($niceNames))
            $validator->setAttributeNames($niceNames);
        if ($validator->fails())
            $this->throwAlert($validator->errors()->getMessageBag(), false);
    }

    protected function throwAlert($message = 'Error! Something Wrong Happened.', $json = true, $status = 404)
    {
        if ($json)
            response()->json(['status' => $message], $status)->send();
        else
            response($message, $status)->send();
        die();
    }
}
