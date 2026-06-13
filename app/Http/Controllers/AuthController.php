<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Customer;
use App\Models\Mitra;
use App\Models\Pool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ════════════════════════════════════════════════════════════════
    // LOGIN (multi-guard: coba semua guard)
    // ════════════════════════════════════════════════════════════════

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // 1. Coba guard Admin
        if (auth('admin')->attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard')
                ->with('success', 'Selamat datang, Admin!');
        }

        // 2. Coba guard Mitra
        if (auth('mitra')->attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            $mitra = auth('mitra')->user();
            if (!$mitra->is_verified) {
                auth('mitra')->logout();
                return back()->withErrors([
                    'email' => 'Akun Mitra Anda belum diverifikasi oleh admin.',
                ])->onlyInput('email');
            }
            return redirect()->route('mitra.dashboard')
                ->with('success', 'Selamat datang, ' . $mitra->name . '!');
        }

        // 3. Coba guard Customer
        if (auth('customer')->attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/')
                ->with('success', 'Selamat datang kembali!');
        }

        // Jika gagal login, cek apakah email sebenarnya ada di database
        $email = $credentials['email'];
        $emailExists = Admin::where('email', $email)->exists() ||
                       Mitra::where('email', $email)->exists() ||
                       Customer::where('email', $email)->exists();

        if ($emailExists) {
            return back()->withErrors([
                'password' => 'Password yang Anda masukkan salah.',
            ])->onlyInput('email');
        }

        return back()->withErrors([
            'email' => 'Email yang Anda masukkan tidak terdaftar.',
        ])->onlyInput('email');
    }

    // ════════════════════════════════════════════════════════════════
    // REGISTER CUSTOMER
    // ════════════════════════════════════════════════════════════════

    public function showRegister()
    {
        return view('auth.register');
    }

    public function doRegister(Request $request)
    {
        $messages = [
            'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, dan angka.',
        ];

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:customers,email',
            'phone'    => 'required|string|max:20',
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
        ], $messages);

        $customer = Customer::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        auth('customer')->login($customer);

        return redirect('/')->with('success', 'Pendaftaran berhasil! Akun Anda siap digunakan.');
    }

    // ════════════════════════════════════════════════════════════════
    // REGISTER MITRA
    // ════════════════════════════════════════════════════════════════

    public function showRegisterMitra()
    {
        return view('auth.register-mitra');
    }

    public function doRegisterMitra(Request $request)
    {
        $messages = [
            'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, dan angka.',
        ];

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:mitras,email',
            'phone'    => 'required|string|max:20',
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
            'address'  => 'required|string',
            'ktp_photo'=> 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], $messages);

        $ktpPath = $request->hasFile('ktp_photo')
            ? \App\Services\ImageService::storeWithWatermark($request->file('ktp_photo'), 'mitra/ktp')
            : null;

        $mitra = Mitra::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'address'     => $request->address,
            'ktp_photo'   => $ktpPath,
            'password'    => Hash::make($request->password),
            'is_verified' => false,
        ]);

        auth('mitra')->login($mitra);

        return redirect()->route('mitra.dashboard')
            ->with('success', 'Pendaftaran Mitra berhasil! Menunggu verifikasi admin.');
    }

    // ════════════════════════════════════════════════════════════════
    // LOGOUT (semua guard)
    // ════════════════════════════════════════════════════════════════

    public function logout(Request $request)
    {
        auth('admin')->logout();
        auth('mitra')->logout();
        auth('customer')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah keluar dari sistem.');
    }

    // ════════════════════════════════════════════════════════════════
    // PROFIL (ditangani oleh guard yang sedang aktif)
    // ════════════════════════════════════════════════════════════════

    public function profile()
    {
        if (auth('admin')->check()) {
            $user = auth('admin')->user();
            return view('admin.profile', compact('user'));
        }

        if (auth('mitra')->check()) {
            $user = auth('mitra')->user();
            return view('admin.profile', compact('user'));
        }

        $user = auth('customer')->user();
        return view('user.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        // ── Admin Profile ────────────────────────────────────────────
        if (auth('admin')->check()) {
            /** @var Admin $user */
            $user = auth('admin')->user();
            $messages = [
                'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, dan angka.',
            ];

            $request->validate([
                'name'     => 'required|string|max:255',
                'email'    => 'required|email|unique:admins,email,' . $user->id,
                'phone'    => 'nullable|string|max:20',
                'password' => ['nullable', 'confirmed', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
            ], $messages);

            $user->name  = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;

            if ($request->hasFile('profile_photo')) {
                $user->profile_photo = $request->file('profile_photo')
                    ->store('admin/photos', 'public');
            }

            if ($request->password) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            return back()->with('success', 'Profil berhasil diperbarui!');
        }

        // ── Mitra Profile ────────────────────────────────────────────
        if (auth('mitra')->check()) {
            /** @var Mitra $user */
            $user = auth('mitra')->user();
            $messages = [
                'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, dan angka.',
            ];

            $request->validate([
                'name'         => 'required|string|max:255',
                'email'        => 'required|email|unique:mitras,email,' . $user->id,
                'phone'        => 'nullable|string|max:20',
                'address'      => 'nullable|string',
                'latitude'     => 'nullable|numeric',
                'longitude'    => 'nullable|numeric',
                'pool_address' => 'nullable|string',
                'password'     => ['nullable', 'confirmed', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
            ], $messages);

            $user->name    = $request->name;
            $user->email   = $request->email;
            $user->phone   = $request->phone;
            $user->address = $request->address;

            if ($request->hasFile('mitra_photo')) {
                $user->mitra_photo = $request->file('mitra_photo')
                    ->store('mitra/photos', 'public');
            }

            if ($request->hasFile('ktp_photo')) {
                $user->ktp_photo = \App\Services\ImageService::storeWithWatermark($request->file('ktp_photo'), 'mitra/ktp');
            }

            // Handle Pool update
            $pool = $user->pools()->first() ?? new Pool();
            $pool->mitra_id = $user->id;
            $pool->name     = 'Pool ' . $user->name;
            $pool->address  = $request->pool_address ?? $request->address;

            if ($request->latitude && $request->longitude) {
                $pool->latitude  = $request->latitude;
                $pool->longitude = $request->longitude;
            } elseif ($pool->address) {
                try {
                    $response = \Illuminate\Support\Facades\Http::withHeaders([
                        'User-Agent' => 'SewaKendaraanApp/1.0'
                    ])->get('https://nominatim.openstreetmap.org/search', [
                        'q'      => $pool->address,
                        'format' => 'json',
                        'limit'  => 1,
                    ]);

                    if ($response->successful() && count($response->json()) > 0) {
                        $data            = $response->json()[0];
                        $pool->latitude  = $data['lat'];
                        $pool->longitude = $data['lon'];
                    }
                } catch (\Exception $e) {
                    // silent fail
                }
            }

            $pool->save();

            if ($request->password) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            return back()->with('success', 'Profil berhasil diperbarui!');
        }

        // ── Customer Profile ─────────────────────────────────────────
        /** @var Customer $user */
        $user = auth('customer')->user();
        $messages = [
            'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, dan angka.',
        ];

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:customers,email,' . $user->id,
            'phone'    => 'nullable|string|max:20',
            'address'  => 'nullable|string',
            'password' => ['nullable', 'confirmed', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
        ], $messages);

        $user->name    = $request->name;
        $user->email   = $request->email;
        $user->phone   = $request->phone;
        $user->address = $request->address;

        if ($request->hasFile('ktp_photo')) {
            $user->ktp_photo = \App\Services\ImageService::storeWithWatermark($request->file('ktp_photo'), 'customer/ktp');
        }

        if ($request->hasFile('sim_photo')) {
            $user->sim_photo = \App\Services\ImageService::storeWithWatermark($request->file('sim_photo'), 'customer/sim');
        }

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function destroyProfile(Request $request)
    {
        if (auth('admin')->check()) {
            $user = auth('admin')->user();
            auth('admin')->logout();
            $user->delete();
        } elseif (auth('mitra')->check()) {
            $user = auth('mitra')->user();
            auth('mitra')->logout();
            $user->delete();
        } elseif (auth('customer')->check()) {
            $user = auth('customer')->user();
            auth('customer')->logout();
            $user->delete();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Akun Anda telah berhasil dihapus.');
    }
}
