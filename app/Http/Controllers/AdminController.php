<?php

namespace App\Http\Controllers;

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
use App\Models\Partnership;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function admin_akun() 
    {
        $userId = Auth::id();  

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user(); 
        $ausers = User::orderBy('created_at', 'desc')->get();

        return view('admin/akun', compact('user', 'ausers'));
    }



    public function admin_akundestroy($id)
    {
        // Temukan user berdasarkan ID yang diberikan
        $user = User::findOrFail($id);
        // Ambil semua ID organisasi terkait user
        $organisations = Organisasi::where('user_id', $id)->pluck('id');

        // Ambil semua ID kerja sama berdasarkan organisasi yang ditemukan
        $partnerships = KerjaSama::whereIn('organisation_id', $organisations)->pluck('id');

        // Ambil semua ID acara berdasarkan kerja sama yang ditemukan
        $eventIds = Acara::whereIn('partnership_id', $partnerships)->pluck('id');

        // Hapus semua dokumen terkait acara
        AcaraDokumen::whereIn('event_id', $eventIds)->delete();

        // Hapus semua acara
        Acara::whereIn('partnership_id', $partnerships)->delete();

        // Hapus semua kerja sama
        KerjaSama::whereIn('organisation_id', $organisations)->delete();

        KerjaSamaDokumen::whereIn('partnership_id', $partnerships)->delete();

        // Hapus semua organisasi
        Organisasi::where('user_id', $id)->delete();

        // Hapus user
        $user->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('admin.akun')->with('success', 'Data user dan semua yang terkait berhasil dihapus.');
    }

    public function admin_akunupdate(Request $request, $id)
    {
        // Validasi input data
        $request->validate([
            'nama' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'telepon' => 'required',
            'alamat' => 'required',
            'bidang' => 'required',
            'role' => 'required|string|in:Admin,Mitra',
            'status' => 'required|string|in:Active,Inactive',
        ]);

        // Cari pengguna berdasarkan ID
        $user = User::findOrFail($id);

        // Update data pengguna
        $user->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => $request->password,
            'alamat' => $request->alamat,
            'bidang' => $request->bidang,
            'telepon' => $request->telepon,
            'role' => $request->role,
            'status' => $request->status,
        ]);

        // Redirect ke halaman yang sesuai atau memberikan respons sukses
        return redirect()->route('admin.akun')->with('success', 'Akun berhasil diperbarui');
    }

    public function admin_akunstore(Request $request)
    {
        // Validasi input data
        $request->validate([
            'nama' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'email' => 'required|email|max:255|unique:users,email',
            'telepon' => 'required|integer',
            'alamat' => 'required|string',
            'bidang' => 'required|string',
            'role' => 'required|string|in:Admin,Mitra',
            'status' => 'required|string|in:Active,Inactive',
        ]);

        // Menyimpan data pengguna baru ke dalam database
        User::create([
            'nama' => $request->nama,
            'password' => $request->password,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'bidang' => $request->bidang,
            'telepon' => $request->telepon,
            'role' => $request->role,
            'status' => $request->status,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('admin.akun')->with('success', 'Akun baru berhasil ditambahkan');
    }

    public function admin_mitra() 
    {
        $userId = Auth::id();  

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user(); 
        $amitra = Organisasi::orderBy('created_at', 'desc')->get();
        $ausers = User::where('role', 'Mitra')
              ->orderBy('nama', 'asc')
              ->get();


        return view('admin/mitra', compact('user', 'amitra', 'ausers'));
    }



    public function admin_mitradestroy($id)
{


    // Ambil semua ID organisasi terkait user
    $organisations = Organisasi::where('id', $id)->pluck('id');

    // Ambil semua ID kerja sama berdasarkan organisasi yang ditemukan
    $partnerships = KerjaSama::whereIn('organisation_id', $organisations)->pluck('id');

    // Ambil semua ID acara berdasarkan kerja sama yang ditemukan
    $eventIds = Acara::whereIn('partnership_id', $partnerships)->pluck('id');

    // Hapus semua dokumen terkait acara
    AcaraDokumen::whereIn('event_id', $eventIds)->delete();

    // Hapus semua acara
    Acara::whereIn('partnership_id', $partnerships)->delete();

    // Hapus semua kerja sama
    KerjaSama::whereIn('organisation_id', $organisations)->delete();

    KerjaSamaDokumen::whereIn('partnership_id', $partnerships)->delete();

    // Hapus semua organisasi
    Organisasi::where('id', $id)->delete();


    // Redirect dengan pesan sukses
    return redirect()->route('admin.mitra')->with('success', 'Data mitra dan semua yang terkait berhasil dihapus.');
}


    public function admin_mitraupdatev($id)
    {
        // Cari mitra berdasarkan ID
        $mitra = Organisasi::find($id);

        if (!$mitra) {
            // Jika mitra tidak ditemukan
            return redirect()->back()->with('error', 'Mitra tidak ditemukan.');
        }

        // Perbarui status verifikasi mitra
        // Misalnya, kita toggle antara terverifikasi dan belum terverifikasi
        $mitra->is_verified = !$mitra->is_verified;  // Mengubah status
        $mitra->save();

        // Redirect dengan pesan sukses
        return redirect()->route('admin.mitra')->with('success', 'Status verifikasi mitra berhasil diperbarui.');
    }

    public function admin_mitrastore(Request $request)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'description' => 'nullable|string',
            'phone_number' => 'required|string|max:15',
            'website' => 'nullable|url|max:255',
            'type' => 'required|string|in:Company,NGO,University,Other',
            'user_id' => 'required|exists:users,id',
            'is_verified' => 'required|boolean',
        ]);

        // Perbarui data mitra
        Organisasi::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'description' => $request->description,
            'phone_number' => $request->phone_number,
            'website' => $request->website,
            'type' => $request->type,
            'user_id' => $request->user_id,
            'is_verified' => $request->is_verified,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('admin.mitra')->with('success', 'Data mitra berhasil ditambahkan.');
    }

    public function admin_mitraupdate(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string',
            'description' => 'nullable|string',
            'phone_number' => 'required|string|max:15',
            'website' => 'nullable|url|max:255',
            'type' => 'required|string|in:Company,NGO,University,Other',
            'user_id' => 'required|exists:users,id',
            'is_verified' => 'required|boolean',
        ]);

        // Cari mitra berdasarkan ID
        $mitra = Organisasi::findOrFail($id);

        // Perbarui data mitra
        $mitra->update([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'description' => $request->description,
            'phone_number' => $request->phone_number,
            'website' => $request->website,
            'type' => $request->type,
            'user_id' => $request->user_id,
            'is_verified' => $request->is_verified,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('admin.mitra')->with('success', 'Data mitra berhasil diperbarui.');
    }

    public function admin_kerjasama() 
    {
        $userId = Auth::id();  

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user(); 
        $akerjasama = KerjaSama::orderBy('created_at', 'desc')->get();
        $amitra = Organisasi::orderBy('name', 'asc')
              ->where('is_verified', '1')
              ->get();


        return view('admin/kerjasama', compact('user', 'amitra', 'akerjasama'));
    }



    public function admin_kerjasamadestroy($id)
    {


      // Pastikan ID adalah array untuk menggunakan whereIn
      $partnershipIds = is_array($id) ? $id : [$id];

      // Hapus semua dokumen terkait kerja sama
      KerjaSamaDokumen::whereIn('partnership_id', $partnershipIds)->delete();

      // Ambil semua ID acara berdasarkan kerja sama yang ditemukan
      $eventIds = Acara::whereIn('partnership_id', $partnershipIds)->pluck('id');

      // Hapus semua dokumen terkait acara
      AcaraDokumen::whereIn('event_id', $eventIds)->delete();

      // Hapus semua acara
      Acara::whereIn('partnership_id', $partnershipIds)->delete();

      // Hapus semua kerja sama
      KerjaSama::whereIn('id', $partnershipIds)->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('admin.kerjasama')->with('success', 'Data kerjasama dan semua yang terkait berhasil dihapus.');
    }

    public function admin_kerjasamastore(Request $request)
    {
        $request->validate([
            'organisation_id' => 'required|exists:organisations,id',
            'title' => 'required',
            'partnership_type' => 'required|string|max:255',
            'details' => 'nullable|string',
            'document' => 'nullable|file|mimes:pdf,doc,docx',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:Pending,Approved,Rejected',
            'is_active' => 'required|in:Active,Inactive',
            'notes' => 'nullable|string',
        ]);

        // Ambil data organisasi berdasarkan ID
        $organisation = Organisasi::findOrFail($request->organisation_id);

        // Simpan dokumen
        $documentPath = null;
        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $organisationName = str_replace(' ', '_', $organisation->name); // Mengganti spasi dengan underscore
            $startDate = $request->start_date;
            $documentName = "{$organisationName}-kerjasama-{$startDate}." . $document->getClientOriginalExtension();
            
            // Pastikan folder public/files/document ada
            $destinationPath = public_path('files/document');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $documentPath = $document->move('files/document', $documentName); 
        }

        // Simpan data ke database
        $partnership = KerjaSama::create([
            'organisation_id' => $request->organisation_id,
            'partnership_type' => $request->partnership_type,
            'title' => $request->title,
            'details' => $request->details,
            'document' => $documentName ?? null,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'approval_date' => $request->approval_date,
            'status' => $request->status,
            'is_active' => $request->is_active,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.kerjasama')->with('success', 'Kerjasama berhasil ditambahkan!');
    }


    public function admin_kerjasamaupdate(Request $request, $id)
    {
        $request->validate([
            'organisation_id' => 'required|exists:organisations,id',
            'partnership_type' => 'required|string|max:255',
            'details' => 'nullable|string',
            'document' => 'nullable|file|mimes:pdf,doc,docx',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:Pending,Approved,Rejected',
            'is_active' => 'required|in:Active,Inactive',
            'notes' => 'nullable|string',
        ]);
    
        // Find the KerjaSama record by ID
        $kerjasama = KerjaSama::findOrFail($id);
    
        // Ambil data organisasi berdasarkan ID
        $organisation = Organisasi::findOrFail($request->organisation_id);
    
        $documentPath = $kerjasama->document; // Default to the existing document if none is uploaded
        if ($request->hasFile('document')) {
            $document = $request->file('document');
            $organisationName = str_replace(' ', '_', $organisation->name); // Mengganti spasi dengan underscore
            $startDate = $request->start_date;
            $documentName = "{$organisationName}-kerjasama-{$startDate}." . $document->getClientOriginalExtension();
            
            // Pastikan folder public/files/document ada
            $destinationPath = public_path('files/document');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
    
            // Simpan file ke folder dan set path
            $document->move($destinationPath, $documentName);
            $documentPath = "{$documentName}";
        }
    
        // Update data Kerjasama
        $kerjasama->update([
            'organisation_id' => $request->organisation_id,
            'partnership_type' => $request->partnership_type,
            'details' => $request->details,
            'document' =>  $documentPath,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'approval_date' => $request->approval_date,
            'status' => $request->status,
            'is_active' => $request->is_active,
            'notes' => $request->notes,
        ]);
    
        return redirect()->route('admin.kerjasama')->with('success', 'Kerjasama berhasil diperbaharui!');
    }

    public function admin_profil() 
    {
        $userId = Auth::id();  

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user(); 

        return view('admin/profil', compact('user'));
    }

    // Update data profil
public function admin_profilupdate(Request $request)
{
    // Validasi data input
    $request->validate([
        'nama' => 'required|string|max:255',  // Use 'nama' instead of 'name' to match the form input name
        'email' => 'required|email|max:255',
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Ambil data user berdasarkan ID
    $user = User::findOrFail($request->id);

    // Buat folder jika belum ada
    $profileFolderPath = public_path('img/profile');
    if (!File::exists($profileFolderPath)) {
        File::makeDirectory($profileFolderPath, 0755, true);
    }

    // Simpan file foto profil jika ada
    $profilePictureName = $user->profile_picture;  // Default to current picture if no new one is uploaded
    if ($request->hasFile('profile_picture')) {
        // Generate a new file name based on the email and name
        $file = $request->file('profile_picture');
        $profilePictureName = strtolower(str_replace(' ', '_', $request->email . '--' . $request->nama)) . '.' . $file->getClientOriginalExtension();
        $file->move($profileFolderPath, $profilePictureName);
    }

    // Update data user
    $user->nama = $request->nama;  // Corrected 'name' to 'nama'
    $user->email = $request->email;
    $user->profile_picture = $profilePictureName;
    $user->save();

    // Kembali ke halaman profil dengan pesan sukses
    return redirect()->route('admin.profil')->with('success', 'Data profil berhasil diperbarui.');
}

public function admin_dokumentasi() 
{
    $userId = Auth::id();  

    if (!$userId) {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }

    $user = Auth::user(); 
    $adokumentasi = KerjaSamaDokumen::orderBy('created_at', 'desc')->get();
    $amitra = KerjaSama::orderBy('partnership_type', 'asc')
          ->where('is_active', 'Active')
          ->get();


    return view('admin/dokumentasi', compact('user', 'amitra', 'adokumentasi'));
}



public function admin_dokumentasidestroy($id)
{
    // Temukan user berdasarkan ID yang diberikan
    $dokumentasi = KerjaSamaDokumen::findOrFail($id);

    // Hapus data user
    $dokumentasi->delete();

    // Redirect dengan pesan sukses
    return redirect()->route('admin.dokumentasi')->with('success', 'Data dokumentasi dan semua yang terkait berhasil dihapus.');
}

// Method to handle form submission and store the data
public function admin_dokumentasistore(Request $request)
{
    // Validate the incoming request
    $validated = $request->validate([
        'partnership_id' => 'required|exists:partnerships,id', // Validating the partnership ID
        'title' => 'required|string|max:255',
        'file' => 'required|file|mimes:pdf,doc,docx,jpeg,jpg,png|max:10240', // File validation (max 10MB)
        'date' => 'required|date',
        'description' => 'required|string|max:1000',
    ]);

    // Ambil data organisasi berdasarkan ID
    $organisation = KerjaSama::findOrFail($validated['partnership_id']);

    // Simpan dokumen
    $documentPath = null;
    if ($request->hasFile('file')) {
        $document = $request->file('file');
        $organisationName = str_replace(' ', '_', $organisation->partnership_type); // Mengganti spasi dengan underscore
        $date = $validated['date'];
        $documentName = "{$organisationName}-kerjasama-dokumentasi-kontrak-{$date}." . $document->getClientOriginalExtension();
        
        // Pastikan folder public/files/document ada
        $destinationPath = public_path('files/dokumentasi');
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true); // Membuat folder jika belum ada
        }

        // Simpan file ke folder yang diinginkan
        $documentPath = $document->move('files/dokumentasi', $documentName); 
    }
    $documentPath1 = null;
    if ($request->hasFile('mou')) {
        $document1 = $request->file('mou');
        $organisationName1 = str_replace(' ', '_', $organisation->partnership_type); // Mengganti spasi dengan underscore
        $date1 = $validated['date'];
        $documentName1 = "{$organisationName1}-kerjasama-dokumentasi-mou-{$date1}." . $document1->getClientOriginalExtension();
        
        // Pastikan folder public/files/document ada
        $destinationPath1 = public_path('files/mou');
        if (!File::exists($destinationPath1)) {
            File::makeDirectory($destinationPath1, 0755, true); // Membuat folder jika belum ada
        }

        // Simpan file ke folder yang diinginkan
        $documentPath1 = $document1->move('files/mou', $documentName1); 
    }
    $documentPath2 = null;
    if ($request->hasFile('moa')) {
        $document2 = $request->file('moa');
        $organisationName2 = str_replace(' ', '_', $organisation->partnership_type); // Mengganti spasi dengan underscore
        $date2 = $validated['date'];
        $documentName2 = "{$organisationName2}-kerjasama-dokumentasi-moa-{$date2}." . $document2->getClientOriginalExtension();
        
        // Pastikan folder public/files/document ada
        $destinationPath2 = public_path('files/moa');
        if (!File::exists($destinationPath2)) {
            File::makeDirectory($destinationPath2, 0755, true); // Membuat folder jika belum ada
        }

        // Simpan file ke folder yang diinginkan
        $documentPath2 = $document2->move('files/moa', $documentName2); 
    }

    // Create a new Dokumentasi record in the database
    KerjaSamaDokumen::create([
        'partnership_id'  => $request->partnership_id, // menggunakan validated input
        'title'  => $request->title,
        'file' => $documentName ?? null, // Store the file path if the file exists
        'mou' => $documentName1 ?? null,
        'moa' => $documentName2 ?? null,
        'date'  => $request->date,
        'description' => $request->description,
    ]);


    // Redirect back with success message
    return redirect()->route('admin.dokumentasi')->with('success', 'Dokumentasi kerjasama berhasil ditambahkan.');
}

// Method to handle form submission and update the data
public function admin_dokumentasiupdate(Request $request, $id)
{
    // Validate the incoming request
    $validated = $request->validate([
        'partnership_id' => 'required|exists:partnerships,id', // Validating the partnership ID
        'title' => 'required|string|max:255',
        'file' => 'nullable|file|mimes:pdf,doc,docx,jpeg,jpg,png|max:10240', // File validation (optional, max 10MB)
        'date' => 'required|date',
        'description' => 'required|string|max:1000',
    ]);

    // Find the existing record
    $dokumentasi = KerjaSamaDokumen::findOrFail($id);
    $organisation = KerjaSama::findOrFail($validated['partnership_id']);

    // Update the document if a new file is uploaded
    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $organisationName = str_replace(' ', '_', $organisation->partnership_type); // Replace spaces with underscores
        $date = $validated['date'];
        $documentName = "{$organisationName}-kerjasama-dokumentasi-kontrak-{$date}." . $file->getClientOriginalExtension();

        // Determine the destination path
        $destinationPath = public_path('files/dokumentasi');
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true); // Create folder if not exists
        }

        // Move the file to the destination folder
        $file->move($destinationPath, $documentName);

        // Delete the old file if exists
        if ($dokumentasi->file && File::exists(public_path($dokumentasi->file))) {
            File::delete(public_path($dokumentasi->file));
        }

        // Update the file path in the database
        $dokumentasi->file = "{$documentName}";
    }

     // Update the document if a new file is uploaded
     if ($request->hasFile('mou')) {
        $file1 = $request->file('mou');
        $organisationName1 = str_replace(' ', '_', $organisation->partnership_type); // Replace spaces with underscores
        $date1 = $validated['date'];
        $documentName1 = "{$organisationName1}-kerjasama-dokumentasi-mou-{$date1}." . $file1->getClientOriginalExtension();

        // Determine the destination path
        $destinationPath1 = public_path('files/mou');
        if (!File::exists($destinationPath1)) {
            File::makeDirectory($destinationPath1, 0755, true); // Create folder if not exists
        }

        // Move the file to the destination folder
        $file1->move($destinationPath1, $documentName1);

        // Delete the old file if exists
        if ($dokumentasi->mou && File::exists(public_path($dokumentasi->mou))) {
            File::delete(public_path($dokumentasi->mou));
        }

        // Update the file path in the database
        $dokumentasi->mou = "{$documentName1}";
    }

    // Update the document if a new file is uploaded
    if ($request->hasFile('moa')) {
        $file2 = $request->file('moa');
        $organisationName2 = str_replace(' ', '_', $organisation->partnership_type); // Replace spaces with underscores
        $date2 = $validated['date'];
        $documentName2 = "{$organisationName2}-kerjasama-dokumentasi-moa-{$date2}." . $file2->getClientOriginalExtension();

        // Determine the destination path
        $destinationPath2 = public_path('files/moa');
        if (!File::exists($destinationPath2)) {
            File::makeDirectory($destinationPath2, 0755, true); // Create folder if not exists
        }

        // Move the file to the destination folder
        $file2->move($destinationPath2, $documentName2);

        // Delete the old file if exists
        if ($dokumentasi->moa && File::exists(public_path($dokumentasi->moa))) {
            File::delete(public_path($dokumentasi->moa));
        }

        // Update the file path in the database
        $dokumentasi->moa = "{$documentName2}";
    }

    // Update other fields in the database
    $dokumentasi->update([
        'partnership_id' => $validated['partnership_id'],
        'title' => $validated['title'],
        'date' => $validated['date'],
        'description' => $validated['description'],
    ]);

    // Redirect back with success message
    return redirect()->route('admin.dokumentasi')->with('success', 'Dokumentasi kerjasama berhasil diperbarui.');
}

public function admin_acara() 
{
    $userId = Auth::id();  

    if (!$userId) {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }

    $user = Auth::user(); 
    $aevents = Acara::orderBy('created_at', 'desc')->get();
    $amitra = KerjaSama::orderBy('partnership_type', 'asc')
          ->where('is_active', 'Active')
          ->get();


    return view('admin/acara', compact('user', 'amitra', 'aevents'));
}



public function admin_acaradestroy($id)
{
 
    // Pastikan ID adalah array untuk menggunakan whereIn
    $eventIds = is_array($id) ? $id : [$id];

    // Hapus semua dokumen terkait acara
    AcaraDokumen::whereIn('event_id', $eventIds)->delete();

    // Hapus semua acara
    Acara::whereIn('id', $eventIds)->delete();

    // Redirect dengan pesan sukses
    return redirect()->route('admin.acara')->with('success', 'Data acara dan semua yang terkait berhasil dihapus.');
}

public function admin_acarastore(Request $request)
{
    // Validasi input
    $request->validate([
        'partnership_id' => 'required|exists:partnerships,id',
        'event_name' => 'required|string|max:255',
        'event_details' => 'required|string',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'status' => 'required|in:Ongoing,Completed,Cancelled',
    ]);

    // Simpan data ke database
    Acara::create([
        'partnership_id' => $request->partnership_id,
        'event_name' => $request->event_name,
        'event_details' => $request->event_details,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'status' => $request->status,
    ]);

    // Redirect dengan pesan sukses
    return redirect()->route('admin.acara')->with('success', 'Acara berhasil disimpan.');
}

public function admin_acaraupdate(Request $request, $id)
{
    // Validasi input
    $request->validate([
        'partnership_id' => 'required|exists:partnerships,id',
        'event_name' => 'required|string|max:255',
        'event_details' => 'required|string',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'status' => 'required|in:Ongoing,Completed,Cancelled',
    ]);

    // Cari acara berdasarkan ID
    $acara = Acara::findOrFail($id);

    // Perbarui data
    $acara->update([
        'partnership_id' => $request->partnership_id,
        'event_name' => $request->event_name,
        'event_details' => $request->event_details,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'status' => $request->status,
    ]);

    // Redirect dengan pesan sukses
    return redirect()->route('admin.acara')->with('success', 'Data acara berhasil diperbarui.');
}

public function admin_dokumentasia() 
    {
        $userId = Auth::id();  

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user(); 
        $adocuments = AcaraDokumen::orderBy('created_at', 'desc')->get();
        $amitra = Acara::orderBy('event_name', 'asc')
              ->get();


        return view('admin/dokumentasia', compact('user', 'amitra', 'adocuments'));
    }



    public function admin_dokumentasiadestroy($id)
    {
        // Temukan user berdasarkan ID yang diberikan
        $dokumentasia = AcaraDokumen::findOrFail($id);

        // Hapus data user
        $dokumentasia->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('admin.dokumentasia')->with('success', 'Data dokumentasi acara dan semua yang terkait berhasil dihapus.');
    }

    // Menyimpan dokumentasi acara
    public function admin_dokumentasiastore(Request $request)
    {
        // Validasi form
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'document_name' => 'required|string|max:255',
            'file' => 'required|file|mimes:jpeg,jpg,png|max:10240', // File validation (max 10MB)
            'description' => 'nullable|string|max:500',
        ]);

        // Ambil data organisasi berdasarkan ID
        $organisation = Acara::findOrFail($validated['event_id']);


        // Simpan dokumen
        $documentPath = null;
        if ($request->hasFile('file')) {
            $document = $request->file('file');
            $organisationName = str_replace(' ', '_', $organisation->event_name); // Mengganti spasi dengan underscore
            $document_name = $validated['document_name'];
            $timestamp = now()->format('YmdHis');
            $documentName = "{$organisationName}-acarq-dokumentasi-{$document_name}-{$timestamp}." . $document->getClientOriginalExtension();
            
            // Pastikan folder public/files/document ada
            $destinationPath = public_path('img/dokumentasi');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true); // Membuat folder jika belum ada
            }

            // Simpan file ke folder yang diinginkan
            $documentPath = $document->move('img/dokumentasi', $documentName); 
        }

        // Menyimpan data dokumentasi ke database
        AcaraDokumen::create([
            'event_id' => $request->event_id,
            'document_name' => $request->document_name,
            'file' => $documentName,
            'description' => $request->description,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('admin.dokumentasia')->with('success', 'Dokumentasi Acara berhasil disimpan!');
    }

         // Menyimpan dokumentasi acara
public function admin_dokumentasiaupdate(Request $request, $id)
{
    // Validasi form
    $validated = $request->validate([
        'event_id' => 'required|exists:events,id',
        'document_name' => 'required|string|max:255',
        'file' => 'nullable|file|mimes:jpeg,jpg,png|max:10240', // File bersifat opsional
        'description' => 'nullable|string|max:500',
    ]);

    // Ambil data acara berdasarkan ID
    $acara = AcaraDokumen::findOrFail($id);
    $event = Acara::findOrFail($validated['event_id']);

    // Simpan dokumen jika ada file yang diunggah
    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $eventName = str_replace(' ', '_', $event->event_name); // Mengganti spasi dengan underscore
        $documentName = "{$eventName}-acara-dokumentasi-{$validated['document_name']}-" . now()->format('YmdHis') . "." . $file->getClientOriginalExtension();
        
        // Tentukan jalur tujuan
        $destinationPath = public_path('img/dokumentasi');
        
        // Pastikan folder tujuan tersedia
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }

        // Simpan file ke folder tujuan
        $file->move($destinationPath, $documentName);
        
        // Perbarui jalur file pada database
        $acara->file = "{$documentName}";
    }

    // Perbarui data dokumentasi
    $acara->update([
        'event_id' => $validated['event_id'],
        'document_name' => $validated['document_name'],
        'description' => $validated['description'],
    ]);

    // Redirect dengan pesan sukses
    return redirect()->route('admin.dokumentasia')->with('success', 'Dokumentasi Acara berhasil diperbarui!');
}


}
