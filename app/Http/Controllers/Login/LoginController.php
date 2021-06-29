<?php

namespace App\Http\Controllers\Login;

use App\Admin;
use App\Anggota;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index()
    {
        if (Session::has('login_sebagai')) {
            if (Session::get('login_sebagai') == 'admin') {
                return redirect('admin/dashboard');
            } else {
                return redirect('anggota/dashboard');
            }
        }
        return view('auth.login');
    }
    public function logout()
    {
        Session::flush();
        return redirect('login')->with('sukses', 'Anda Berhasil Keluar Dari Sistem');
    }
    public function postlogin(Request $request)
    {
        // dd($request->all());
        $username = $request->username;
        $password = $request->password;
        $loginSebagai = $request->masuk_sebagai;
        if ($loginSebagai == 'admin') {
            $data = Admin::where('username', $username)->first();
            if ($data) { //apakah username tersebut ada atau tidak
                if (Hash::check($password, $data->password)) {
                    Session::put('id', $data->id);
                    Session::put('nama', $data->nama);
                    Session::put('username', $data->username);
                    Session::put('foto' . $data->foto);
                    Session::put('login_sebagai', 'admin');
                    Session::put('login', TRUE);
                    return redirect('admin/dashboard')->with('sukses', 'Anda Berhasil Masuk Ke Sistem');
                }
            }
            return redirect('login')->with('gagal', 'Username atau password salah !');
        } else {
            $data = Anggota::where('username', $username)->first();
            if ($data) {
                if (Hash::check($password, $data->password)) {
                    Session::put('id', $data->id);
                    Session::put('nama', $data->nama);
                    Session::put('kode_anggota', $data->kode_anggota);
                    Session::put('username' . $data->username);
                    Session::put('foto' . $data->foto);
                    Session::put('jenis_anggota', $data->jenis_anggota);
                    Session::put('tempat_lahir', $data->tempat_lahir);
                    Session::put('tgl_lahir', $data->tgl_lahir);
                    Session::put('jk', $data->jk);
                    Session::put('no_hp', $data->no_hp);
                    Session::put('alamat', $data->alamat);
                    Session::put('login_sebagai', 'anggota');
                    Session::put('login', TRUE);
                    return \redirect('anggota/dashboard')->with('sukses', 'Anda Berhasil Masuk Ke Sistem');
                }
            }
            return \redirect('login')->with('gagal', 'Username atau password salah !');
        }
    }
}
