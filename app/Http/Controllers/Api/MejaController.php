<?php

namespace App\Http\Controllers\Api;

use App\Models\Meja;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MejaController extends Controller
{
    public function getAllMeja()
    {
        // Retrieve AllMeja from your database
        $AllMeja = Meja::all();

        // Return the users as a JSON response
        return response()->json($AllMeja);
    }

    public function getMeja($id)
    {
        // Retrieve a specific user from your database
        $meja = Meja::find($id);

        if (!$meja) {
            return response()->json(['error' => 'Ganemu Bro'], 404);
        }

        // Return the user as a JSON response
        return response()->json($meja);
    }

    public function createMeja(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'nomor_meja' => 'required|string|max:50',
        ]);

        // Create the new user with the validated data
        $meja = Meja::create([
            'nomor_meja' => $validatedData['nomor_meja'],
        ]);

        // Return a JSON response with the newly created user
        return response()->json(['meja' => $meja], 201);
    }

    public function updateMeja(Request $request, $id)
    {
        // Find the user to update
        $meja = Meja::find($id);

        

        // If the user doesn't exist, return a 404 error
        if (!$meja) {
            return response()->json(['error' => 'Ganemu Bro'], 404);
        }

        // Validate the incoming request data
        $validatedData = $request->validate([
            'nomor_meja' => 'string|max:50',
        ]);

        // Update the user with the validated data
        $meja->update([
            'nomor_meja' => $validatedData['nomor_meja'] ?? $meja->nomor_meja,
        ]);

        // Return a JSON response with the updated user
        return response()->json(['meja' => $meja]);
    }

    public function destroyMeja($id)
    {
        // Find the user to delete
        $meja = Meja::find($id);

        // If the user doesn't exist, return a 404 error
        if (!$meja) {
            return response()->json(['error' => 'Ganemu Bro'], 404);
        }

        // Delete the user
        $meja->delete();

        // Return a JSON response with a success message
        return response()->json(['message' => 'Done']);
    }
}
