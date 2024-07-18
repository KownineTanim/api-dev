<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest('id')->get();

        return response()->json([
            'success' => true,
            'message' => 'All Categories',
            'data' => $categories
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

        $category = new Category();
        $category->name = $request->name;
        $category->created_at = date('Y-m-d H:i');
        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'Category created successfully',
            'data' => [],
        ], 201);

    }

    public function search(Request $request)
    {
        $categories = Category::where('name', 'LIKE', '%' . $request->name . '%')->get();

        if (count($categories) > 0){
            return response()->json([
                'status' => 200,
                'categories' => $categories
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
        $category = Category::find($id);

        if ($category){
            return response()->json([
                'status' => 200,
                'category' => $category
            ], 200);
        } else{
            return response()->json([
                'status' => 404,
                'message' => 'No such Category found'
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

        $category = Category::find($id);

        if ($category){
            Category::where('id', $id)
            ->update([
                'name' => $request->name,
                'updated_at' => date('Y-m-d H:i')
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Category Updated successfully',
                'data' => [],
            ], 201);
        } else{
            return response()->json([
                'status' => 404,
                'message' => 'No such Category found'
            ],404);
        }

    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if ($category){
            $category->delete();
            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully'
            ]);
        } else{
            return response()->json([
                'status' => 404,
                'message' => 'No such Category found'
            ],404);
        }

    }
}
