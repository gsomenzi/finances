<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class ApiController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function getPaginationData($request) {
        $requestData = $request->only(['page', 'limit', 'q']);
        return [
            'page' => $requestData['page'] ?? 1,
            'limit' => $requestData['limit'] ?? 25,
            'q' => $requestData['q'] ?? null
        ];
    }

    public function getOne(Request $request, $item) {
        if ($request->user()->cannot('view', $item)) {
            abort(403);
        }
    }

    public function update(Request $request, $item) {
        if ($request->user()->cannot('update', $item)) {
            abort(403);
        }
    }

    public function delete(Request $request, $item) {
        if ($request->user()->cannot('delete', $item)) {
            abort(403);
        }
    }
}
