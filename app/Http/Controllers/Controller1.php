<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class Controller1 extends Controller
{
    public function create()
    {
        return view('create');
    }

    public function update($nim)
    {
        $data = Mahasiswa::where('nim', $nim)->first();
        if ($data) {
            return view('update', ['data' => $data]);
        } else {
            return redirect('/read');
        }
    }

    public function edit(Request $request)
    {
        $data = Mahasiswa::where('nim', $request->nim)->first();
        if ($data) {
            $data->nama = $request->nama; 
            $data->alamat = $request->alamat;
            $data->alamat = $request->umur;
            $data->alamat = $request->email;
            $data->updated_at = date('Y-m-d H:i:s');
            // now();
            print_r($request->all());
            // $data->save();
           // return redirect('/read')->with('pesan', 'Data dengan NIM :' . $request->nim . ' berhasil diupdate');
           return redirect('/read')->with('pesan', 'Data dengan NIM :' . $request->all() . ' berhasil diupdate');
       
        } else {
            //return redirect('/read')->with('pesan', 'Data tidak ditemukan/gagal update');
              return redirect('/read')->with('pesan', 'Data tidak ditemukan/gagal update'.$request->all());
        }
        
    }

    public function save(Request $request) 
    {
        $validateData = $request->validate([
            'nim'=> 'required|regex:/^G\d{3}.\d{2}.\d{4}$/|unique:mahasiswa,nim',
            'nama'=> 'required|string|max:25',
            'umur'=> 'required|integer|between:1,100',
            'alamat'=> 'required|min:6',
            'email'=> 'required|email'
        ]);

        $model = new Mahasiswa();
        $model->insert([
            'nim' => $request->nim,
            'nama' => $request->nama,
            'umur' => $request->umur,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'created_at' => now()
        ]);

        return view('view', ['data' => $request->all()]);
    }

    public function read()
    {
        $model = new Mahasiswa();
        $dataAll = $model->all();
        return view('read', ['dataAll' => $dataAll]);
    }

    public function delete($nim)
    {
        $data = Mahasiswa::where('nim', $nim)->first();
        if ($data) {
            $data->delete();
            return redirect('/read')->with('pesan', 'Data NIM:' . $nim . ' Berhasil dihapus');
        } else {
            return redirect('/read')->with('pesan', 'Data NIM : ' . $nim . ' tidak ditemukan');
        }
    }

    public function tampilkan(Request $request)
    {
        $model = new Mahasiswa();

        $model->create([
            'nim' => $request->nim,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'umur' => $request->umur,
            'email' => $request->email,
            'created_at' => now(),
        ]);

        $dataAll = $model->all();
        return view('tampil2', ['data' => $request->all(), 'dataAll' => $dataAll]);
    }
}