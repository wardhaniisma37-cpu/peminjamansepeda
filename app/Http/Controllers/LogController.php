<?php

namespace App\Http\Controllers;


use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * Menampilkan daftar log aktivitas
     */
    public function index()
    {
        $logs = Log::with('user')->orderBy('created_at', 'desc')->paginate(20);
        return view('logs', compact('logs'));
    }

    /**
     * Menyimpan log aktivitas baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'action' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $log = Log::create([
            'user_id' => auth()->id(),
            'action' => $request->action,
            'description' => $request->description,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'log' => $log]);
        }

        return back()->with('success', 'Log berhasil ditambahkan.');
    }

    /**
     * Mengupdate log aktivitas
     */
    public function update(Request $request, $id)
    {
        $log = Log::findOrFail($id);
        
        $request->validate([
            'action' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $log->update([
            'action' => $request->action,
            'description' => $request->description,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Log berhasil diperbarui.');
    }

    /**
     * Menghapus log aktivitas
     */
    public function destroy($id)
    {
        $log = Log::findOrFail($id);
        $log->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Log berhasil dihapus.');
    }
}