<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        return view('author.profile.index');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'bio'    => 'nullable',
            'social' => 'nullable',
            'photo'  => 'nullable|image',
            'password' => 'nullable|min:6'
        ]);

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $user->photo = $request->file('photo')->store('profiles', 'public');
        }

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->bio    = $request->bio;
        $user->social = $request->social;
        $user->save();

        return back()->with('success', 'Profile berhasil diperbarui');
    }
}
