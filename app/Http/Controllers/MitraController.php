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
class MitraController extends Controller
{
    public function mitra_mitra() 
    {
        $userId = Auth::id();  

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user(); 
        $amitra = Organisasi::orderBy('created_at', 'desc')->where('user_id', $userId)->get();
        $ausers = User::where('role', 'Mitra')
              ->where('id', $userId)
              ->orderBy('nama', 'asc')
              ->get();


        return view('mitra/mitra', compact('user', 'amitra', 'ausers'));
    }

    public function mitra_mitrastore(Request $request)
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
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('mitra.mitra')->with('success', 'Data mitra berhasil ditambahkan.');
    }

    public function mitra_mitraupdate(Request $request, $id)
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
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('mitra.mitra')->with('success', 'Data mitra berhasil diperbarui.');
    }

    public function mitra_profil() 
    {
        $userId = Auth::id();  

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user(); 

        return view('mitra/profil', compact('user'));
    }

    // Update data profil
    public function mitra_profilupdate(Request $request)
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
        return redirect()->route('mitra.profil')->with('success', 'Data profil berhasil diperbarui.');
    }

    public function mitra_kerjasama() 
    {
        $userId = Auth::id();  

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user(); 
        // Ambil data organisasi berdasarkan user_id
        $organisations = Organisasi::where('user_id', $userId)->pluck('id'); 

        // Ambil data KerjaSama berdasarkan organisation_id yang dimiliki user
        $akerjasama = KerjaSama::whereIn('organisation_id', $organisations)
            ->orderBy('created_at', 'desc')
            ->get();
        $amitra = Organisasi::orderBy('name', 'asc')
              ->where('is_verified', '1')
              ->where('user_id', $userId)
              ->get();


        return view('mitra/kerjasama', compact('user', 'amitra', 'akerjasama'));
    }

    public function mitra_kerjasamastore(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'organisation_id' => 'required|exists:organisations,id',
            'partnership_type' => 'required|string|max:255',
            'details' => 'nullable|string',
            'document' => 'nullable|file|mimes:pdf,doc,docx',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
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
            'title' => $request->title,
            'organisation_id' => $request->organisation_id,
            'partnership_type' => $request->partnership_type,
            'details' => $request->details,
            'document' => $documentName ?? null,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'notes' => $request->notes,
        ]);

        return redirect()->route('mitra.kerjasama')->with('success', 'Kerjasama berhasil ditambahkan!');
    }

    public function mitra_kerjasamaupdate(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'organisation_id' => 'required|exists:organisations,id',
            'partnership_type' => 'required|string|max:255',
            'details' => 'nullable|string',
            'document' => 'nullable|file|mimes:pdf,doc,docx',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'notes' => 'nullable|string',
        ]);
    
        // Find the KerjaSama record by ID
        $kerjasama = KerjaSama::findOrFail($id);
    
        // Ambil data organisasi berdasarkan ID
        $organisation = Organisasi::findOrFail($request->organisation_id);
    
        // Simpan dokumen jika ada
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
            'title' => $request->title,
            'organisation_id' => $request->organisation_id,
            'partnership_type' => $request->partnership_type,
            'details' => $request->details,
            'document' => $documentPath, // Simpan path dokumen baru atau yang lama
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'notes' => $request->notes,
        ]);
    
        return redirect()->route('mitra.kerjasama')->with('success', 'Kerjasama berhasil diperbaharui!');
    }
    
    public function mitra_dokumentasi() 
    {
        $userId = Auth::id();  

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user(); 
        $organisations = Organisasi::where('user_id', $userId)->pluck('id'); 
        $partnership = KerjaSama::where('organisation_id', $organisations)->pluck('id');
$adokumentasi = KerjaSamaDokumen::orderBy('created_at', 'desc')
    ->whereIn('partnership_id', $partnership)
    ->get();

        $amitra = KerjaSama::orderBy('partnership_type', 'asc')
            ->where('is_active', 'Active')
            ->where('organisation_id', $organisations )
            ->get();


        return view('mitra/dokumentasi', compact('user', 'amitra', 'adokumentasi'));
    }

    public function mitra_dokumentasistore(Request $request)
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
        return redirect()->route('mitra.dokumentasi')->with('success', 'Dokumentasi kerjasama berhasil ditambahkan.');
    }

    // Method to handle form submission and update the data
    public function mitra_dokumentasiupdate(Request $request, $id)
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
        return redirect()->route('mitra.dokumentasi')->with('success', 'Dokumentasi kerjasama berhasil diperbarui.');
    }

    public function mitra_acara() 
    {
        $userId = Auth::id();  

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user(); 
        $organisations = Organisasi::where('user_id', $userId)->pluck('id'); 
        $partnership = KerjaSama::where('organisation_id', $organisations)->pluck('id');
        $aevents = Acara::orderBy('created_at', 'desc')->whereIn('partnership_id', $partnership)->get();
        $amitra = KerjaSama::orderBy('partnership_type', 'asc')
            ->where('is_active', 'Active')
            ->where('organisation_id', $organisations )
            ->get();


        return view('mitra/acara', compact('user', 'amitra', 'aevents'));
    }

    public function mitra_acarastore(Request $request)
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
        return redirect()->route('mitra.acara')->with('success', 'Acara berhasil disimpan.');
    }

    public function mitra_acaraupdate(Request $request, $id)
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
        return redirect()->route('mitra.acara')->with('success', 'Data acara berhasil diperbarui.');
    }
    
    public function mitra_dokumentasia() 
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

    // Ambil dokumen acara berdasarkan event yang ditemukan, diurutkan dari yang terbaru
    $adocuments = AcaraDokumen::whereIn('event_id', $eventIds)
        ->orderBy('created_at', 'desc')
        ->get();

        $amitra = Acara::whereIn('partnership_id', $partnerships)
        ->orderBy('event_name', 'asc')
        ->get();
    

        return view('mitra/dokumentasia', compact('user', 'amitra', 'adocuments'));
    }

    
    // Menyimpan dokumentasi acara
    public function mitra_dokumentasiastore(Request $request)
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
        return redirect()->route('mitra.dokumentasia')->with('success', 'Dokumentasi Acara berhasil disimpan!');
    }

         // Menyimpan dokumentasi acara
public function mitra_dokumentasiaupdate(Request $request, $id)
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
    return redirect()->route('mitra.dokumentasia')->with('success', 'Dokumentasi Acara berhasil diperbarui!');
}

}
