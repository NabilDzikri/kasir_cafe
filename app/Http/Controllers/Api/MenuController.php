<?php

namespace App\Http\Controllers\Api;

use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function getAllMenu()
    {
        // Retrieve AllMeja from your database
        $AllMenu = Menu::all();

        // Return the users as a JSON response
        return response()->json($AllMenu);
    }

    public function getMenu($id)
    {
        // Retrieve a specific user from your database
        $menu = Menu::find($id);

        if (!$menu) {
            return response()->json(['error' => 'Ganemu Bro'], 404);
        }

        // Return the user as a JSON response
        return response()->json($menu);
    }

    public function createMenu(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'nama_menu' => 'required|string|max:50',
            'jenis' => 'required|string|max:50',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image',
            'harga' => 'required|integer',
        ]);

         // Create a new user instance
        $menu = new Menu();
        $menu->nama_menu = $validatedData['nama_menu'];
        $menu->jenis = $validatedData['jenis'];
        $menu->deskripsi = $validatedData['deskripsi'];
        $menu->harga = $validatedData['harga'];

        // Handle image upload if provided
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $filename = $this->hashFilename($gambar->getClientOriginalName());
            $path = $gambar->storeAs('public/FotoMenu', $filename);
            $menu->gambar = $filename;
    }

    // Save the user to the database
        $menu->save();
        
    // Return a JSON response with the newly created user
        return response()->json(['menu' => $menu], 201);
    }

    private function hashFilename($filename)
    {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $hash = md5(uniqid());
        return $hash . '.' . $extension;
    }

    public function updateMenu(Request $request, $id)
    {
        // Find the user to update
        $menu = Menu::find($id);

        

        // If the user doesn't exist, return a 404 error
        if (!$menu) {
            return response()->json(['error' => 'Ganemu Bro'], 404);
        }

        // Validate the incoming request data
        $validatedData = $request->validate([
            'nama_menu' => 'string|max:50',
            'jenis' => 'string|max:50',
            'deskripsi' => 'string',
            'gambar' => 'nullable|image',
            'harga' => 'integer',
        ]);

        // Update the user with the validated data
        $menu->nama_menu = $validatedData['nama_menu'] ?? $menu->nama_menu;
        $menu->jenis = $validatedData['jenis'] ?? $menu->jenis;
        $menu->deskripsi = $validatedData['deskripsi'] ?? $menu->deskripsi;
        $menu->harga = $validatedData['harga'] ?? $menu->harga;

        if ($request->hasFile('gambar')) {
            // Delete the existing image if there is one
            if ($menu->gambar) {
                Storage::delete('public/FotoMenu/'.$menu->gambar);
            }
    
            $gambar = $request->file('gambar');
            $filename = $this->hashFilename($gambar->getClientOriginalName());
            $path = $gambar->storeAs('public/FotoMenu', $filename);
            $menu->gambar = $filename;
        } else {
            $menu->gambar = $validatedData['gambar'] ?? $menu->gambar;
        }
    
        // Save the user to the database
        $menu->save();


        // Return a JSON response with the updated user
        return response()->json(['menu' => $menu]);
    }

    public function destroyMenu($id)
    {
        // Find the user to delete
        $menu = Menu::find($id);

        // If the user doesn't exist, return a 404 error
        if (!$menu) {
            return response()->json(['error' => 'Ganemu Bro'], 404);
        }

        // Delete the user
        $menu->delete();

        // Return a JSON response with a success message
        return response()->json(['message' => 'Done']);
    }
}
