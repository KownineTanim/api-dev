<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use Validator;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::latest('id')->get();

        return response()->json([
            'success' => true,
            'message' => 'All Tags',
            'data' => $tags
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error occured',
                'errors' => $validator->getMessageBag(),
            ], 422);
        }

        $tag = new Tag();
        $tag->name = $request->name;
        $tag->created_at = date('Y-m-d H:i');
        $tag->save();

        return response()->json([
            'success' => true,
            'message' => 'Tag created successfully',
            'data' => [],
        ], 201);

    }

    public function search(Request $request)
    {
        $tags = Tag::where('name', 'LIKE', '%' . $request->name . '%')->get();

        if (count($tags) > 0){
            return response()->json([
                'status' => 200,
                'tags' => $tags
            ], 200);
        } else{
            return response()->json([
                'status' => 404,
                'message' => 'Nothing found'
            ],404);
        }

    }

    public function edit($id)
    {
        $tag = Tag::find($id);

        if ($tag){
            return response()->json([
                'status' => 200,
                'tag' => $tag
            ], 200);
        } else{
            return response()->json([
                'status' => 404,
                'message' => 'No such Tag found'
            ],404);
        }

    }

    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error occured',
                'errors' => $validator->getMessageBag(),
            ], 422);
        }

        $tag = Tag::find($id);

        if ($tag){
            Tag::where('id', $id)
            ->update([
                'name' => $request->name,
                'updated_at' => date('Y-m-d H:i')
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Tag Updated Successfully',
                'data' => [],
            ], 201);
        } else{
            return response()->json([
                'status' => 404,
                'message' => 'No such Tag found'
            ],404);
        }

    }

    public function destroy($id)
    {
        $tag = Tag::find($id);

        if ($tag){
            $tag->delete();
            return response()->json([
                'success' => true,
                'message' => 'Tag deleted successfully'
            ]);
        } else{
            return response()->json([
                'status' => 404,
                'message' => 'No such Tag found'
            ],404);
        }

    }

}
