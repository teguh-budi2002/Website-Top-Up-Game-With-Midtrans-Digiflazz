<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Halaman Pembayaran</title>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
</head>

<body>
    <div>
        <h1>Judul Game</h1>
        <p>{{ $order->product->name_game }}</p>
        <h4>Price</h4>
        <p>Rp. {{ number_format($order->total_price, 2) }}</p>
        <h5>Qty</h5>
        <p>{{ $order->qty }}</p>
    </div>
    <div>
        <button id="pay-button">Pay Now!</button>
    </div>

    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function (result) {
                    alert("payment success!");
                    console.log(result);
                },
                onPending: function (result) {
                    alert("wating your payment!");
                    console.log(result);
                },
                onError: function (result) {
                    alert("payment failed!");
                    console.log(result);
                },
                onClose: function () {
                    alert('you closed the popup without finishing the payment');
                }
            })
        });

    </script>
</body>

</html>
