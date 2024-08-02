<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;
use Illuminate\Support\Facades\DB;

class PetController extends Controller
{
    public function uploadImage(Request $request)
    {

        try {
            $request->validate([
                'file.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'petId' => 'required|integer|exists:pets,id'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'code' => 422,
                'type' => 'string',
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }


        $pet = Pet::find($request->petId);
        if (!$pet) {
            return response()->json([
                'code' => 404,
                'type' => 'string',
                'message' => 'Pet not found'
            ], 404);
        }

        if (!$request->hasFile('file')) {
            return response()->json([
                'code' => 400,
                'type' => 'string',
                'message' => 'No file uploaded'
            ], 400);
        }

        $imageName = time() . '.' . $request->file->extension();
        $request->file->move(public_path('images'), $imageName);


        $photoUrls = $pet->photoUrls;
        $photoUrls = json_decode($photoUrls, true);
        $photoUrls[] = url('public/images/' . $imageName);

        $photoUrlsJson = json_encode($photoUrls);

        $pet->photoUrls = $photoUrlsJson;
        $pet->save();

        file_put_contents(public_path('photoUrls.json'), json_encode($photoUrls));

        return response()->json([
            'code' => 0,
            'type' => 'string',
            'message' => 'Image uploaded successfully'
        ], 200);
    }

    public function store(Request $request)
    {


        try {
            $request->validate([
                'category_id' => 'required|integer|exists:categories,id',
                'name' => 'required|string|max:255',
                'files' => 'required',
                'files.*' => 'mimes:jpg,jpeg,png,bmp|max:20000',
                'tags' => 'required|array',
                'tags.*' => 'exists:tags,id',
                'status' => 'required|string|in:available,pending,sold',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'code' => 405,
                'type' => 'string',
                'message' => 'Validation failed'
            ], 405);
        }


        $pet = new Pet;
        $pet->category_id = $request->category_id;
        $pet->name = $request->name;
        $pet->status = $request->status;

        $photoUrls = [];
        if ($request->hasfile('files')) {
            foreach ($request->file('files') as $file) {
                $name = time() . '.' . $file->extension();
                $file->move(public_path('images'), $name);
                $photoUrls[] = url('public/images/' . $name);
            }
        }

        $pet->photoUrls = json_encode($photoUrls);

        $pet->save();

        // Attach tags
        if ($request->has('tags')) {
            foreach ($request->tags as $tagId) {
                $pet->tags()->attach($tagId);
            }


            return response()->json([
                'code' => 0,
                'type' => 'string',
                'message' => 'Pet added successfully'
            ], 200);
        }
    }
    public function update_put(Request $request)
    {

        $request->validate([
            'id' => 'sometimes|integer',
            'category_id' => 'sometimes|integer|exists:categories,id',
            'name' => 'sometimes|string|max:255',
            'photoUrls' => 'sometimes|array',
            'tags' => 'sometimes|array',
            'tags.*' => 'exists:tags,id',
            'status' => 'sometimes|string|in:available,pending,sold',
        ]);

        $id = $request->petId;
        $pet = Pet::find($id);

        if (!$pet) {
            return response()->json([
                'code' => 404,
                'type' => 'string',
                'message' => 'Pet not found'
            ], 404);
        }

        if ($request->has('category_id')) {
            $pet->category_id = $request->category_id;
        }

        if ($request->has('name')) {
            $pet->name = $request->name;
        }

        if ($request->has('status')) {
            $pet->status = $request->status;
        }

        if ($request->has('tags')) {
            $pet->tags()->detach();
            foreach ($request->tags as $tagId) {
                $pet->tags()->attach($tagId);
            }
        }

        $pet->save();

        return response()->json([
            'code' => 0,
            'type' => 'string',
            'message' => 'Pet updated successfully'
        ], 200);
    }
    public function findByStatus(Request $request)
    {
        $request->validate([
            'status' => 'required|array',
            'status.*' => 'in:available,pending,sold',
        ]);

        $statusArray = $request->query('status');

        if (!$statusArray) {
            return response()->json([
                'code' => 400,
                'type' => 'string',
                'message' => 'Status parameter is required'
            ], 400);
        }

        $pets = Pet::whereIn('status', $statusArray)->get();

        return response()->json($pets, 200);
    }
    public function findById(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        $pet = Pet::find($request->query('id'));

        if (!$pet) {
            return response()->json([
                'code' => 404,
                'type' => 'string',
                'message' => 'Pet not found'
            ], 404);
        }

        return response()->json($pet, 200);
    }
    public function update(Request $request)
    {

        $request->validate([
            'petId' => 'required|integer',
            'name' => 'sometimes|string|max:255',
            'status' => 'sometimes|string|in:available,pending,sold',
        ]);

        $pet = Pet::find($request->petId);

        if (!$pet) {
            return response()->json([
                'code' => 404,
                'type' => 'string',
                'message' => 'Pet not found'
            ], 404);
        }

        if ($request->has('name')) {
            $pet->name = $request->name;
        }

        if ($request->has('status')) {
            $pet->status = $request->status;
        }

        $pet->save();

        return response()->json([
            'code' => 0,
            'type' => 'string',
            'message' => 'Pet updated successfully'
        ], 200);
    }
    public function delete(Request $request)
    {

        $request->validate([
            'petId' => 'required|integer',
        ]);

        $apiKey = $request->all()['apikey'];

        // Validate the API key
        $apiKeyRecord = DB::table('api_key')->where('key', $apiKey)->first();

        if (!$apiKeyRecord) {
            return response()->json([
                'code' => 403,
                'type' => 'string',
                'message' => 'Invalid API key'
            ], 403);
        }

        $pet = Pet::find($request->petId);

        if (!$pet) {
            return response()->json([
                'code' => 404,
                'type' => 'string',
                'message' => 'Pet not found'
            ], 404);
        }

        $pet->delete();

        return response()->json([
            'code' => 0,
            'type' => 'string',
            'message' => 'Pet deleted successfully'
        ], 200);
    }
}
