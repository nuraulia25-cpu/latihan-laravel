<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LecturerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('lecturer.index', [
            'title' => 'lecturer',
            'lecturers' => lecturer::latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('lecturer.create', [
            'title' => 'Create lecturer',
            'departments' => Department::latest()->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => 'required',
                'department_id' => 'required',
                'avatar' => 'image|nullable|mimes:jpeg,png,jpg,webp|max:1024',
            ],
            [
                'name.required' => 'Nama wajib di input',
                'department_id.required' => 'Program Studi wajib di input',
                'avatar.image' => 'File avatar harus berupa gambar',
                'avatar.mimes' => 'File avatar harus berupa file dengan ekstensi: jpeg, png, jpg, webp',
                'avatar.max' => 'File avatar tidak boleh lebih dari 1MB',
            ]

        );

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('lecturers', 'public');
        }

        Lecturer::create($validated);
        return to_route('lecturer.index')->withSuccess('Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lecturer $lecturer) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lecturer $lecturer)
    {
        return view('lecturer.edit', [
            'title' => 'Edit lecturer',
            'departments' => Department::latest()->get(),
            'lecturer' => $lecturer,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lecturer $lecturer)
    {
        $validated = $request->validate(
            [
                'name' => 'required',
                'department_id' => 'required',
                'avatar' => 'image|nullable|mimes:jpeg,png,jpg,webp|max:1024',
            ],
            [
                'name.required' => 'Nama wajib di input',
                'department_id.required' => 'Program Studi wajib di input',
                'avatar.image' => 'File avatar harus berupa gambar',
                'avatar.mimes' => 'File avatar harus berupa file dengan ekstensi: jpeg, png, jpg, webp',
                'avatar.max' => 'File avatar tidak boleh lebih dari 1MB',
            ]

        );

        if ($request->hasFile('avatar')) {

            if ($lecturer->avatar) {
                Storage::disk('public')->delete($lecturer->avatar);
            }

            $validated['avatar'] = $request->file('avatar')->store('lecturers', 'public');
        }

        $lecturer->update($validated);
        return to_route('lecturer.index')->withSuccess('Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lecturer $lecturer)
    {
        $lecturer->delete();

        return to_route('lecturer.index')->withSuccess('Data Berhasil Dihapus');
    }
}
