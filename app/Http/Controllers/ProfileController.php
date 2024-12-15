<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Menampilkan form edit profile
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    // Menyimpan perubahan profile
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'company_name' => 'nullable|string|max:255',
            'admin_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        // Update data user
        $user->company_name = $request->company_name;
        $user->admin_name = $request->admin_name;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('profile')->with('success', 'Profile berhasil diperbarui.');
    }
}
