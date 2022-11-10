<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\Tag;

class TagController extends ApiController
{
    public function getAll(Request $request) {
        $user = auth()->user();
        $query = $user->tags()->orderBy('description', 'asc');
        $paginationData = $this->getPaginationData($request);
        $tags = $query->paginate($paginationData['limit']);
        return response()->json($tags, 200);
    }

    public function getOne(Request $request, $tag) {
        parent::getOne($request, $tag);
        return response()->json($tag, 200);
    }

    public function create(Request $request) {
        $request->validate([
            'description' => 'required'
        ]);
        $input = $request->only(['description']);
        $tag = Tag::create(array_merge([
            'user_id' => auth()->user()->id
        ], $input));
        return response()->json($tag, 201);
    }

    public function update(Request $request, $tag) {
        parent::update($request, $tag);
        $request->validate([
            'description' => 'required'
        ]);
        $input = $request->only(['description']);
        $tag->update($input);
        return response()->json($tag, 200);
    }

    public function delete(Request $request, $tag) {
        parent::delete($request, $tag);
        $tag->delete();
        return response()->json([], 204);
    }
}
