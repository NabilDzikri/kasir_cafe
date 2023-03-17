<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\DetailTransaksi;

class TransaksiController extends Controller
{
    public function createTransaksi(Request $request){
        $validatedData = $request->validate([
            'id_user' => 'required|integer',
            'id_meja' => 'required|integer',
            'nama_pelanggan' => 'required|string',
            'status' => 'required',   
            'id_menus' => 'required|integer',
            'total' => 'required|integer',
        ]);
    
        $transaksi = new Transaksi();
        $transaksi->id_user = $validatedData['id_user'];
        $transaksi->id_meja = $validatedData['id_meja'];
        $transaksi->nama_pelanggan = $validatedData['nama_pelanggan'];
        $transaksi->status = $validatedData['status'];

        $transaksi->save();

        foreach ($validatedData['id_menus'] as $id_menu) {

            $menu = Menu::find($id_menu);
            $detailtransaksi = new DetailTransaksi();
            $detailtransaksi->id_menu = $id_menu;
            $detailtransaksi->harga = $menu->harga*$total;
            $detailtransaksi->total = $validatedData['total'];
    
            $detailtransaksi->save();
        }
    }

    public function getAllMenu()
    {
        // Retrieve AllMeja from your database
        $AllTransaksi = Transaksi::all();

        // Return the users as a JSON response
        return response()->json($AllTransaksi);
    }

    public function getTransaksi($id)
    {
        // Retrieve a specific user from your database
        $transaksi = Transaksi::find($id);

        if (!$transaksi) {
            return response()->json(['error' => 'Ganemu Bro'], 404);
        }

        // Return the user as a JSON response
        return response()->json($transaksi);
    }
}
