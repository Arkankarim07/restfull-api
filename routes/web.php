<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/setup', function () {
    // Mendefinisikan kredensial pengguna yang ingin dibuat atau diotentikasi
   $credentials = [
    'email' => 'admin@admin.com',
    'password' => 'password'
   ];
   
  // Mencoba untuk mengotentikasi pengguna dengan kredensial yang diberikan
if (!Auth::attempt($credentials)) {
    // Jika otentikasi gagal, maka buat pengguna baru
    $user = new \App\Models\User();

    $user->name = 'Admin';
    $user->email = $credentials['email'];
    $user->password = Hash::make($credentials['password']);

    // Simpan pengguna baru ke dalam database
    $user->save();

    // Sekarang, otentikasi pengguna baru yang baru dibuat
    if (Auth::attempt($credentials)) {
        // Dapatkan informasi pengguna yang telah diotentikasi
        $user = Auth::user();

        // Buat token untuk akses dengan hak akses 'create', 'update', 'delete'
        $adminToken = $user->createToken('admin-token', ['create', 'update', 'delete']);

        // Buat token untuk akses dengan hak akses 'create', 'update'
        $updateToken = $user->createToken('update-token', ['create', 'update']);

        // Buat token dasar tanpa hak akses khusus
        $basicToken = $user->createToken('basic-token');

        // Kirim respons berisi informasi token yang dihasilkan
        return [
            'admin' => $adminToken->plainTextToken,
            'update' => $updateToken->plainTextToken,
            'basic' => $basicToken->plainTextToken
            // Contoh respons:
            // "admin": "1|BdfRedGuDxFzV59Ut5D98P83B7lCGgX4uk8iHjMWc39a6c63",
            // "update": "2|w6ZCR9YFE3l4yHQH7LrMrKErRqiG4KcRtpK6XXMT672c452d",
            // "basic": "3|MQdJq3biSMkFjPkBTFIFsYBfbjhofsF1h3y9udLIc529b296"
        ];
    }
}
});
