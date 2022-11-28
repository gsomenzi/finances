<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends ApiController
{
    public function getAll(Request $request) {
        $request->validate([
            'destination' => 'nullable|in:receipt,expense'
        ]);
        $user = auth()->user();
        $query = $user->categories()->orderBy('description', 'asc');
        if($request->get('destination')) {
            $query->where('destination', $request->get('destination'));
        }
        $paginationData = $this->getPaginationData($request);
        $categories = $query->paginate($paginationData['limit']);
        return response()->json($categories, 200);
    }

    public function getOne(Request $request, $category) {
        parent::getOne($request, $category);
        return response()->json($category, 200);
    }

    public function create(Request $request) {
        $request->validate([
            'description' => 'required',
            'destination' => 'required|in:receipt,expense'
        ]);
        $input = $request->only(['description', 'destination']);
        $category = Category::create(array_merge([
            'user_id' => auth()->user()->id
        ], $input));
        return response()->json($category, 201);
    }

    public function update(Request $request, $category) {
        parent::update($request, $category);
        $request->validate([
            'description' => 'required'
        ]);
        $input = $request->only(['description']);
        $category->update($input);
        return response()->json($category, 200);
    }

    public function delete(Request $request, $category) {
        parent::delete($request, $category);
        $category->delete();
        return response()->json([], 204);
    }
}
