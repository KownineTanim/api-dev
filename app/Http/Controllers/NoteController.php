<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Category, Note};
use Validator;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::latest('id')->get();

        return response()->json([
            'success' => true,
            'message' => 'All Notes',
            'data' => $notes
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required'],
            'body' => ['required'],
            'category_id' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error occured',
                'errors' => $validator->getMessageBag(),
            ], 422);
        }

        $note = new Note();
        $note->title = $request->title;
        $note->body = $request->body;
        $note->tags = $request->tags;
        $note->category_id = $request->category_id;
        $note->save();

        return response()->json([
            'success' => true,
            'message' => 'Note created successfully',
            'data' => [],
        ], 201);

    }

    public function search(Request $request)
    {
        $notes = Note::where('title', 'LIKE', '%' . $request->title . '%')->get();

        if (count($notes) > 0){
            return response()->json([
                'status' => 200,
                'notes' => $notes
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
        $note = Note::find($id);

        if ($note){
            return response()->json([
                'status' => 200,
                'note' => $note
            ], 200);
        } else{
            return response()->json([
                'status' => 404,
                'message' => 'No such Note found'
            ],404);
        }

    }

    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'body' => 'required',
            'category_id' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error occured',
                'errors' => $validator->getMessageBag(),
            ], 422);
        }

        $note = Note::find($id);

        if ($note){
            Note::where('id', $id)
            ->update([
                'title' => $request->title,
                'body' => $request->body,
                'tags' => $request->tags,
                'category_id' => $request->category_id,
                'updated_at' => date('Y-m-d H:i')
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Note Updated successfully',
                'data' => [],
            ], 201);
        } else{
            return response()->json([
                'status' => 404,
                'message' => 'No such Note found'
            ],404);
        }

    }

    public function destroy($id)
    {
        $note = Note::find($id);

        if ($note){
            $note->delete();
            return response()->json([
                'success' => true,
                'message' => 'Note deleted successfully'
            ]);
        } else{
            return response()->json([
                'status' => 404,
                'message' => 'No such Note found'
            ],404);
        }

    }
}
