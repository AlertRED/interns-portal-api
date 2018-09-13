<?php

namespace App\Http\Controllers\V1\Intern;

use App\Http\Controllers\Controller;

class InternsController extends Controller
{
    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getIntern($id) {
        return response()->json([
            "id" => $id,
            "data" => "..."
        ]);
    }
}