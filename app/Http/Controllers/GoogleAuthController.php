<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Customer;
use App\Models\Mitra;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;

class GoogleAuthController extends Controller
{
    /**
     * Redirect ke halaman OAuth Google.
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle callback dari Google.
     * Strategi: cek email di tabel admins → mitras → customers.
     * Jika tidak ada → buat akun customer baru.
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Login Google gagal. Silakan coba lagi.']);
        }

        // ── 1. Cek tabel Admins ───────────────────────────────────────
        $admin = Admin::where('email', $googleUser->getEmail())
            ->orWhere('google_id', $googleUser->getId())
            ->first();

        if ($admin) {
            // Update google_id & avatar jika belum tersimpan
            $admin->update([
                'google_id' => $googleUser->getId(),
                'avatar'    => $googleUser->getAvatar(),
            ]);

            auth('admin')->login($admin);
            request()->session()->regenerate();

            return redirect()->route('admin.dashboard')
                ->with('success', 'Selamat datang, ' . $admin->name . '!');
        }

        // ── 2. Cek tabel Mitras ───────────────────────────────────────
        $mitra = Mitra::where('email', $googleUser->getEmail())
            ->orWhere('google_id', $googleUser->getId())
            ->first();

        if ($mitra) {
            if (!$mitra->is_verified) {
                return redirect()->route('login')
                    ->withErrors(['email' => 'Akun Mitra Anda belum diverifikasi oleh admin.']);
            }

            $mitra->update([
                'google_id' => $googleUser->getId(),
                'avatar'    => $googleUser->getAvatar(),
            ]);

            auth('mitra')->login($mitra);
            request()->session()->regenerate();

            return redirect()->route('mitra.dashboard')
                ->with('success', 'Selamat datang, ' . $mitra->name . '!');
        }

        // ── 3. Cek tabel Customers ────────────────────────────────────
        $customer = Customer::where('email', $googleUser->getEmail())
            ->orWhere('google_id', $googleUser->getId())
            ->first();

        if ($customer) {
            $customer->update([
                'google_id' => $googleUser->getId(),
                'avatar'    => $googleUser->getAvatar(),
            ]);
        } else {
            // Buat akun Customer baru dari data Google
            $customer = Customer::create([
                'name'      => $googleUser->getName(),
                'email'     => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar'    => $googleUser->getAvatar(),
                'password'  => null, // tanpa password untuk akun Google
            ]);
        }

        auth('customer')->login($customer);
        request()->session()->regenerate();

        return redirect()->intended('/')
            ->with('success', 'Selamat datang, ' . $customer->name . '!');
    }
}
