<?php

namespace App\Http\Controllers\Api;

class UpazilaController extends BaseJsonController
{
    protected string $fileName = 'upazilas';

    public function index()
    {
        return $this->sendResponse($this->getData(), 'Successfully retrieved all upazilas.');
    }

    public function byDistrict($districtId)
    {
        $upazilas = collect($this->getData())
            ->where('district_id', (string) $districtId)
            ->values()
            ->all();

        if (empty($upazilas)) {
            return $this->sendError('No upazilas found for this district.');
        }

        return $this->sendResponse($upazilas, "Successfully retrieved upazilas for district ID {$districtId}.");
    }
}
