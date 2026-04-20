<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin' || Auth::user()->role === 'superadmin') {
                return redirect()->intended(route('admin.dashboard'))->with('success', 'Selamat datang di Dashboard Super Admin!');
            }

            if (Auth::user()->role === 'mitra') {
                return redirect()->intended(route('mitra.dashboard'))->with('success', 'Selamat datang, Mitra!');
            }


            return redirect()->intended('/')->with('success', 'Selamat datang kembali!');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    public function doRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        Auth::login($user);

        return redirect('/')->with('success', 'Pendaftaran berhasil! Akun Anda siap digunakan.');
    }

    public function doRegisterMitra(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'partner_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8',
            'address' => 'required|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'partner_name' => $request->partner_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'role' => 'mitra',
            'is_verified' => false, // Default: unverified
        ]);

        Auth::login($user);

        return redirect()->route('mitra.dashboard')->with('success', 'Pendaftaran Mitra berhasil! Menunggu verifikasi admin.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah keluar dari sistem.');
    }

    public function profile()
    {
        $user = Auth::user();
        if ($user->role === 'admin' || $user->role === 'mitra') {
            return view('admin.profile', compact('user'));
        }
        return view('user.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'pool_address' => 'nullable|string',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        // Handle Pool for Mitra
        if ($user->role === 'mitra') {
            $pool = $user->pool ?: new \App\Models\Pool();
            $pool->name = "Pool " . $user->name;
            $pool->address = $request->pool_address ?? $request->address;

            // Use provided coordinates or geocode via Nominatim
            if ($request->latitude && $request->longitude) {
                $pool->latitude = $request->latitude;
                $pool->longitude = $request->longitude;
            } elseif ($pool->address) {
                try {
                    $response = \Illuminate\Support\Facades\Http::withHeaders([
                        'User-Agent' => 'SewaKendaraanApp/1.0'
                    ])->get('https://nominatim.openstreetmap.org/search', [
                        'q' => $pool->address,
                        'format' => 'json',
                        'limit' => 1
                    ]);

                    if ($response->successful() && count($response->json()) > 0) {
                        $data = $response->json()[0];
                        $pool->latitude = $data['lat'];
                        $pool->longitude = $data['lon'];
                    }
                } catch (\Exception $e) {
                    // Log or handle error quietly, maybe notify user later
                }
            }

            if ($pool->latitude && $pool->longitude) {
                $pool->save();
                $user->pool_id = $pool->id;
            }
        }

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
