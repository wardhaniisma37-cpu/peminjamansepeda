<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ItemController extends Controller
{
    /**
     * Display a listing of the items (GET)
     */
    public function index()
    {
        $items = Item::all();
        return view('items', compact('items'));
    }

    /**
     * Store a newly created item (POST)
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'stock' => 'required|integer|min:0',
            'kondisi' => 'required|in:baik,rusak,perbaikan',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Buat item baru
        $item = new Item();
        $item->name = $request->name;
        $item->description = $request->description;
        $item->stock = $request->stock;
        $item->kondisi = $request->kondisi;

        // Upload gambar ke public/images
        if ($request->hasFile('image')) {
            // Buat folder images jika belum ada
            if (!file_exists(public_path('images'))) {
                mkdir(public_path('images'), 0777, true);
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', $image->getClientOriginalName());
            $image->move(public_path('images'), $imageName);
            $item->image = 'images/' . $imageName;
        }

        $item->save();

        return redirect()->route('items')->with('success', 'Barang berhasil ditambahkan!');
    }

    /**
     * Update the specified item (PUT)
     */
    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'stock' => 'required|integer|min:0',
            'kondisi' => 'required|in:baik,rusak,perbaikan',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Update data
        $item->name = $request->name;
        $item->description = $request->description;
        $item->stock = $request->stock;
        $item->kondisi = $request->kondisi;

        // Upload gambar baru jika ada
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($item->image && file_exists(public_path($item->image))) {
                unlink(public_path($item->image));
            }
            
            // Buat folder images jika belum ada
            if (!file_exists(public_path('images'))) {
                mkdir(public_path('images'), 0777, true);
            }
            
            // Upload gambar baru
            $image = $request->file('image');
            $imageName = time() . '_' . preg_replace('/[^a-zA-Z0-9.]/', '_', $image->getClientOriginalName());
            $image->move(public_path('images'), $imageName);
            $item->image = 'images/' . $imageName;
        }

        $item->save();

        return redirect()->route('items')->with('success', 'Barang berhasil diupdate!');
    }

    /**
     * Remove the specified item (DELETE)
     */
    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        
        // Hapus file gambar jika ada
        if ($item->image && file_exists(public_path($item->image))) {
            unlink(public_path($item->image));
        }
        
        $item->delete();

        return redirect()->route('items')->with('success', 'Barang berhasil dihapus!');
    }

    /**
     * Get all items for AJAX request
     */
    public function allItems()
    {
        $items = Item::all();
        return response()->json($items);
    }
}