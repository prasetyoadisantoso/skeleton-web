<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'These credentials do not match our records.',
    'password' => 'The provided password is incorrect.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',

    'messages' => [
        'success' => 'Sukses',
        'failed' => 'Gagal',
        'login_success' => 'Login Sukses',
        'email_not_verified' => 'Email tidak terverifikasi',
        'user_not_registered' => 'User tidak terdaftar',
        'user_not_found' => 'User tidak ditemukan',
        'user_verified' => 'User terverifikasi',
        'email_sent' => 'Email terikirim',
        'token_invalid' => 'Token Tidak Terdaftar',
        'password_change' => 'Password telah diganti',
        'password_not_match' => 'Password tidak cocok',
    ],

    'login' => [
        "title" => 'Login',
        "header" => 'Halaman Login',
        "email" => 'Alamat Email...',
        "password" => 'Kata Sandi...',
        "remember_me" => 'Ingat saya',
        "forgot_password" => 'Lupa password ?',
        "sign_up" => 'Daftar',
        "sign_in" => 'Masuk',
    ],

    'registration' => [
        "title" => 'Pendaftaran',
        "header" => 'Halaman Pendaftaran',
        "full_name" => 'Nama Lengkap...',
        "email" => 'Alamat Email...',
        "password" => 'Password...',
        "confirm_password" => 'Konfirmasi Password...',
        "register" => "Daftar",
        "forgot_password" => 'Lupa password ?',
        "sign_in" => 'Masuk'
    ],

    'verification' => [
        'title' => 'Verifikasi',
        'header' => 'Halaman Verifikasi',
        "alert" => "Kami telah mengirimkan kode verifikasi ke email Anda, jika Anda tidak menerima email kami, silakan kirim ulang
        verifikasi dengan formulir di bawah ini",
        "email" => 'Alamat Email...',
        'resend_verification' => 'Kirim Verifikasi',
        "sign_in" => 'Masuk',
        "sign_up" => "Daftar",
    ],

    'forgot_password' => [
        'title' => 'Lupa Password',
        'header' => 'Halaman Lupa Password',
        "alert" => "Kirim email untuk mengatur ulang kata sandi",
        "email" => 'Alamat Email...',
        'reset_password' => 'Kirim & Atur Ulang Kata Sandi',
        "sign_in" => 'Masuk',
        "sign_up" => "Daftar",
    ],

    'reset_password' => [
        'title' => 'Atur Ulang Kata Sandi',
        'header' => 'Halaman Atur Ulang Kata Sandi',
        "old_password" => 'Password Lama...',
        'new_password' => 'Password Baru...',
        'confirm_password' => 'Konfirmasi Password...',
        'reset_password' => 'Atur Ulang Kata Sandi',
        "sign_in" => 'Masuk',
        "sign_up" => "Daftar",
    ],

];
