<?php

namespace App\Http\Controllers\Api;

class DivisionController extends BaseJsonController
{
    protected string $fileName = 'divisions';

    public function index()
    {
        $divisions = $this->getData();

        // Optional: sort by ID
        $divisions = collect($divisions)
            ->sortBy('id', SORT_NATURAL)
            ->values()
            ->all();

        return $this->sendResponse($divisions, 'Successfully retrieved all divisions.');
    }
}
