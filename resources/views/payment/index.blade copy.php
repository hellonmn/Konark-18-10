<!-- resources/views/receipt.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 100%; max-width: 600px; margin: 0 auto; }
        .header { text-align: center; margin-bottom: 20px; }
        .content { margin-bottom: 20px; }
        .footer { text-align: center; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Receipt</h2>
        </div>
        <div class="content">
            <p><strong>Date:</strong> {{ $date }}</p>
            <p><strong>Customer Name:</strong> {{ $customer_name }}</p>
            <p><strong>Items:</strong></p>
            <ul>
                @foreach($items as $item)
                    <li>{{ $item['name'] }} - ${{ number_format($item['price'], 2) }}</li>
                @endforeach
            </ul>
            <p><strong>Total:</strong> ${{ number_format($total, 2) }}</p>
        </div>
        <div class="footer">
            <p>Thank you for your business!</p>
        </div>
    </div>
</body>
</html>
