<!DOCTYPE html>
<html>
<head>
    <title>Pembayaran Midtrans</title>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
</head>
<body>
    <button id="pay-button">Bayar Sekarang</button>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function () {
            window.snap.pay('{{ $snap_token }}', {
                onSuccess: function(result){ window.location.href = '/dashboard'; },
                onPending: function(result){ window.location.href = '/dashboard'; },
                onError: function(result){ alert('Pembayaran gagal!'); }
            });
        }
    </script>
</body>
</html>