<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('pages.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nra'      => 'required|string',
            'password' => 'required|string',
        ], [
            'nra.required'      => 'NRA wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $user = User::where('nra', $request->nra)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'nra' => 'NRA atau password salah.',
            ])->withInput($request->only('nra'));
        }

        Auth::login($user, $request->boolean('remember'));

        $request->session()->regenerate();

        return redirect()->route('home');
    }

    public function showRegister()
    {
        return view('pages.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'nra_seq'               => 'required|digits_between:1,5',
            'nra_roman'             => ['required', 'string', 'regex:/^(M{0,4}(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3}))$/i'],
            'nra_year'              => 'required|digits:2',
            'phone'                 => 'nullable|string|max:20',
            'password'              => 'required|string|min:8|confirmed',
        ], [
            'name.required'         => 'Nama lengkap wajib diisi.',
            'email.required'        => 'Email wajib diisi.',
            'email.email'           => 'Format email tidak valid.',
            'email.unique'          => 'Email sudah terdaftar.',
            'nra_seq.required'      => 'Nomor urut NRA wajib diisi.',
            'nra_seq.digits_between'=> 'Nomor urut NRA harus berupa angka.',
            'nra_roman.required'    => 'Angka Romawi NRA wajib diisi.',
            'nra_roman.regex'       => 'Format angka Romawi tidak valid (contoh: XXII).',
            'nra_year.required'     => 'Tahun NRA wajib diisi.',
            'nra_year.digits'       => 'Tahun NRA harus 2 digit (contoh: 23).',
            'password.required'     => 'Password wajib diisi.',
            'password.min'          => 'Password minimal 8 karakter.',
            'password.confirmed'    => 'Konfirmasi password tidak cocok.',
        ]);

        // Rakit NRA: 000.KD.XXII.23
        $nra = str_pad($request->nra_seq, 3, '0', STR_PAD_LEFT)
             . '.KD.'
             . strtoupper($request->nra_roman)
             . '.'
             . $request->nra_year;

        // Cek uniqueness NRA yang sudah dirakit
        if (User::where('nra', $nra)->exists()) {
            return back()->withErrors(['nra_seq' => 'NRA ' . $nra . ' sudah terdaftar.'])->withInput();
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'nra'      => $nra,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
