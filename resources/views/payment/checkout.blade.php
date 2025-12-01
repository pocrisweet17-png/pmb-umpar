<button id="pay-button" class="btn btn-lg btn-success">Bayar Sekarang Rp {{ number_format($payment->jumlah) }}</button>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script>
    document.getElementById('pay-button').onclick = function(){
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(){ location.href="{{ route('payment.finish', $reg->idRegistrasi) }}"; },
            onPending: function(){ location.href="{{ route('payment.finish', $reg->idRegistrasi) }}"; },
            onError: function(){ location.href="{{ route('payment.finish', $reg->idRegistrasi) }}"; },
            onClose: function(){ alert('Jangan tutup dulu ya!'); }
        });
    };
</script>