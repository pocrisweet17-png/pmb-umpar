<?php
namespace App\Helpers;
use App\Models\Notif;

class NotifHelper
{
    public static function push($registrasiId, $title, $message = null)
    {
        return Notif::create([
            'registrasi_id' => $registrasiId,
            'title' => $title,
            'message' => $message,
        ]);
    }
}
