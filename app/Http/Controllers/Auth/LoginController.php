<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\KerjaSama;
use App\Models\Acara;
use App\Models\AcaraDokumen;
use App\Models\KerjaSamaDokumen;
use App\Models\Organisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Carbon\Carbon;

class LoginController extends Controller
{
    // Tampilkan halaman login
    public function index()
    {
        return view('login');
    }

    public function daftar()
    {
        return view('daftar');
    }

    public function register(Request $request)
{
    // Validasi data input dengan pesan kustom
    $validator = Validator::make($request->all(), [
        'nama' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'telepon' => 'required',
            'alamat' => 'required',
            'bidang' => 'required',
    ], [
        'nama.required' => 'Nama wajib diisi.',
        'email.required' => 'Email wajib diisi.',
        'email.unique' => 'Email sudah terdaftar.',
        'password.required' => 'Password wajib diisi.',
        'password.min' => 'Password minimal 8 karakter.',
        'profile_picture.image' => 'File harus berupa gambar.',
        'profile_picture.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
        'profile_picture.max' => 'Ukuran gambar maksimal 2MB.',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Buat folder jika belum ada
    $profileFolderPath = public_path('img/profile');
    if (!File::exists($profileFolderPath)) {
        File::makeDirectory($profileFolderPath, 0755, true);
    }

    // Simpan file foto profil jika ada
    $profilePictureName = null;
    if ($request->hasFile('profile_picture')) {
        $file = $request->file('profile_picture');
        $profilePictureName = strtolower(str_replace(' ', '_', $request->email . '--' . $request->nama)) . '.' . $file->getClientOriginalExtension();
        $file->move($profileFolderPath, $profilePictureName);
    }

    // Buat user baru
    User::create([
        'nama' => $request->nama,
        'email' => $request->email,
        'alamat' => $request->alamat,
        'bidang' => $request->bidang,
        'telepon' => $request->telepon,
        'password' => Hash::make($request->password),
        'profile_picture' => $profilePictureName, // Simpan path relatif file
        'status' => 'Active', // Status default
        'email_verified_at' => Carbon::now('Asia/Jakarta'),
    ]);

    // Redirect dengan pesan sukses
    return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan login.');
}


  // Tampilkan halaman dashboard (untuk fleksibilitas)
public function mitra_dashboard() 
{
    $userId = Auth::id();  

    if (!$userId) {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }

    $user = Auth::user(); 

    // Ambil semua ID organisasi yang dimiliki oleh user
    $organisations = Organisasi::where('user_id', $userId)->pluck('id');

    // Ambil semua ID kerja sama berdasarkan organisasi yang ditemukan
    $partnerships = KerjaSama::whereIn('organisation_id', $organisations)->pluck('id');

    // Ambil semua ID acara berdasarkan kerja sama yang ditemukan
    $eventIds = Acara::whereIn('partnership_id', $partnerships)->pluck('id');

    // Hitung total pengajuan berdasarkan organisasi user
    $totalPengajuan = KerjaSama::whereIn('organisation_id', $organisations)->count();

    // Hitung total dokumentasi kerja sama berdasarkan partnership ID
    $totalDokumentasi = KerjaSamaDokumen::whereIn('partnership_id', $partnerships)->count();

    // Hitung total acara berdasarkan partnership ID
    $totalAcara = Acara::whereIn('partnership_id', $partnerships)->count();

    // Hitung total dokumentasi acara berdasarkan event ID
    $totalDokumentasiAcara = AcaraDokumen::whereIn('event_id', $eventIds)->count();

    return view('mitra/dashboard', compact(
        'user',
        'totalPengajuan',
        'totalDokumentasi',
        'totalAcara',
        'totalDokumentasiAcara'
    ));
}


    public function admin_dashboard()
    {
        $userId = Auth::id();  

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user(); 

        // Count data for dashboard
        $totalAkun = User::count();
        $totalManajemen = Organisasi::count();
        $totalPengajuan = Kerjasama::count();
        $totalDokumentasi = KerjaSamaDokumen::count();
        $totalAcara = Acara::count();
        $totalDokumentasiAcara = AcaraDokumen::count();

        return view('admin.dashboard', compact(
            'user', 
            'totalAkun', 
            'totalManajemen', 
            'totalPengajuan', 
            'totalDokumentasi', 
            'totalAcara', 
            'totalDokumentasiAcara'
        ));
    }
    public function login(Request $request)
    {        
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Proses login
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Jika login berhasil
            $user = Auth::user(); 
    
            // Cek level pengguna dan arahkan ke dashboard yang sesuai
            if ($user->role === 'Admin') {
                // Cek status akun setelah role Admin
                if ($user->status === 'Inactive') {
                    Auth::logout();
                    return redirect()->route('login')->with('error', 'Akun Anda tidak aktif.');
                }
                return redirect()->route('admin.dashboard')->with('success', "Selamat datang, $user->nama!");
            } elseif ($user->role === 'Mitra') {
                // Cek status akun setelah role Mitra
                if ($user->status === 'Inactive') {
                    Auth::logout();
                    return redirect()->route('login')->with('error', 'Akun Anda tidak aktif.');
                }
                return redirect()->route('mitra.dashboard')->with('success', "Selamat datang, $user->nama!");
            } else {
                // Jika level tidak dikenali, logout dan beri pesan kesalahan
                Auth::logout();
                return redirect()->route('login')->with('error', 'Hak akses tidak valid.');
            }
        } else {
            // Jika login gagal
            return redirect()->back()->with('error', 'Email atau password salah!');
        }
    }
    

    // Logout
    public function logout()
    {
        Auth::logout();
        session()->flush();
        return redirect('/login')->with('success', 'Anda berhasil logout.');
    }
}
