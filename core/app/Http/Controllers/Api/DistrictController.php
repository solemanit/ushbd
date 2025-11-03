<?php

namespace App\Http\Controllers\Api;

class DistrictController extends BaseJsonController
{
    protected string $fileName = 'districts';

    public function index()
    {
        return $this->sendResponse($this->getData(), 'Successfully retrieved all districts.');
    }

    public function byDivision($divisionId)
    {
        $districts = collect($this->getData())
            ->where('division_id', (string) $divisionId)
            ->values()
            ->all();

        if (empty($districts)) {
            return $this->sendError('No districts found for this division.');
        }

        return $this->sendResponse($districts, "Successfully retrieved districts for division ID {$divisionId}.");
    }
}
