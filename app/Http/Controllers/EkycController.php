<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EkycRegistration;
use Illuminate\Support\Facades\Auth;

class EkycController extends Controller
{

    public function step1()
    {
       
        $Ekyc = EkycRegistration::where('user_id', Auth::id())
            ->where('status', 'draft')
            ->first();

        
        if ($Ekyc) {
            session(['Ekyc_id' => $Ekyc->id]);
        }

        return view('Ekyc.step1', compact('Ekyc'));
    }

    public function storeStep1(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'nik' => 'required|string|max:20',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
        ]);

        $Ekyc = EkycRegistration::updateOrCreate(
            ['id' => session('Ekyc_id')],
            [
                'user_id' => Auth::id(),
                'nama' => $request->nama,
                'nik' => $request->nik,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'status' => 'draft',
            ]
        );

        session(['Ekyc_id' => $Ekyc->id]);

        return redirect()->route('Ekyc.step2')->with('success', 'Data pribadi disimpan, lanjut ke langkah berikutnya.');
    }

   
   
    public function step2()
    {
       
        $Ekyc = EkycRegistration::where('user_id', auth()->id())->first();
        
        return view('ekyc.step2', compact('Ekyc'));
    }
    public function storeStep2(Request $request)
    {
        $validated = $request->validate([
            'file_ktp' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'file_selfie' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

     
        $Ekyc = EkycRegistration::firstOrCreate(['user_id' => auth()->id()]);

        if ($request->hasFile('file_ktp')) {
           
            $validated['file_ktp'] = $request->file('file_ktp')->store('ekyc', 'public');
        }

        if ($request->hasFile('file_selfie')) {
           
            $validated['file_selfie'] = $request->file('file_selfie')->store('ekyc', 'public');
        }

        $Ekyc->update($validated);

        
        return redirect()->route('ekyc.step3')->with('success', 'Dokumen disimpan, lanjut ke langkah berikutnya.');
       
    }
}