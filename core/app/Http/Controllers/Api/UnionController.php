<?php

namespace App\Http\Controllers\Api;

class UnionController extends BaseJsonController
{
    protected string $fileName = 'unions';

    public function byUpazila($upazilaId)
    {
        $unions = collect($this->getData())
            ->where('upazila_id', (string) $upazilaId)
            ->values()
            ->all();

        if (empty($unions)) {
            return $this->sendError('No unions found for this upazila.');
        }

        return $this->sendResponse($unions, "Successfully retrieved unions for upazila ID {$upazilaId}.");
    }
}
