<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentSuccessNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $tipePembayaran = ucfirst($this->payment->tipe_pembayaran);
        $registrasi = $this->payment->registrasi;

        return (new MailMessage)
            ->subject('Pembayaran ' . $tipePembayaran . ' Berhasil - PMB UMPAR')
            ->greeting('Halo, ' . $notifiable->namaLengkap . '!')
            ->line('Pembayaran **' . $tipePembayaran . '** Anda telah berhasil diverifikasi.')
            ->line('')
            ->line('**Detail Transaksi:**')
            ->line('Nomor Pendaftaran: ' . $registrasi->nomorPendaftaran)
            ->line('Order ID: ' . $this->payment->order_id)
            ->line('ID Transaksi: ' . $this->payment->id_transaksi)
            ->line('Tipe Pembayaran: ' . $tipePembayaran)
            ->line('Metode: ' . strtoupper(str_replace('_', ' ', $this->payment->payment_type ?? '-')))
            ->line('Total: Rp ' . number_format($this->payment->jumlah, 0, ',', '.'))
            ->line('Status: **LUNAS**')
            ->line('')
            ->action('Lihat Detail Pembayaran', route('payment.success', $this->payment->order_id))
            ->line('Terima kasih telah melakukan pembayaran!')
            ->line('')
            ->line('Simpan email ini sebagai bukti pembayaran Anda.')
            ->salutation('Salam, Tim PMB Universitas Muhammadiyah Parepare');
    }

    /**
     * Tentukan email tujuan
     * Cek dari formulir dulu, baru dari model
     */
    public function routeNotificationForMail($notifiable)
    {
        return $notifiable->formulir->email ?? $notifiable->email ?? null;
    }
}