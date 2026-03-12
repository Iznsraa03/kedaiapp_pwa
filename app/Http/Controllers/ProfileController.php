<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('pages.edit-profil', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'phone'          => ['nullable', 'string', 'max:20'],
            'address'        => ['nullable', 'string', 'max:500'],
            'avatar_cropped' => ['nullable', 'string'],
        ]);

        // Simpan hasil crop (base64) jika ada
        if (!empty($request->avatar_cropped)) {
            $base64 = $request->avatar_cropped;

            // Ekstrak data base64 murni
            if (str_contains($base64, ',')) {
                $base64 = explode(',', $base64)[1];
            }

            $imageData = base64_decode($base64);

            // Validasi ukuran (maks 2MB)
            if (strlen($imageData) > 2 * 1024 * 1024) {
                return back()->withErrors(['avatar_cropped' => 'Ukuran foto maksimal 2MB.'])->withInput();
            }

            // Hapus avatar lama jika ada
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Simpan file baru
            $filename = 'avatars/' . $user->id . '_' . time() . '.jpg';
            Storage::disk('public')->put($filename, $imageData);

            $validated['avatar'] = $filename;
        }

        // Hapus key avatar_cropped agar tidak masuk ke update
        unset($validated['avatar_cropped']);

        $user->update($validated);

        return redirect()->route('profil')->with('success', 'Profil berhasil diperbarui.');
    }
}
