<?php

namespace App\Http\Controllers;

//import model Task
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // jumlah data yang ditampilkan per paginasi halaman
        $max_data = 5;

        if (request('search')) {
            // menampilkan pencarian data
            $data=Task::where('task', 'like', '%' . request('search') . '%')->paginate($max_data)->withQueryString();
        } else {
            // menampilkan data
            $data = Task::orderBy('id', 'desc')->paginate($max_data);
        }

        // tampilkan data ke view
        return view("task.app", compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validasi form
        $request->validate([
            'task' => 'required'
        ]);

        // data yang akan disimpan
        $data = [
            'task' => $request->input('task')
        ];
        // simpan data
        Task::create($data);

        // redirect ke halaman task dan tampilkan pesan berhasil simpan data
        return redirect()->route('task')->with('success', 'Tugas baru telah berhasil disimpan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // validasi form
        $request->validate([
            'task' => 'required'
        ]);

        // data yang akan diubah
        $data = [
            'task' => $request->input('task'),
            'is_done' => $request->input('is_done')
        ];
        // ubah data berdasarkan id
        Task::where('id', $id)->update($data);

        // redirect ke halaman task dan tampilkan pesan berhasil ubah data
        return redirect()->route('task')->with('success', 'Tugas telah berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // hapus data berdasarkan id
        Task::where('id', $id)->delete();

        // redirect ke halaman task dan tampilkan pesan berhasil hapus data
        return redirect()->route('task')->with('success', 'Tugas telah berhasil dihapus.');
    }
}
