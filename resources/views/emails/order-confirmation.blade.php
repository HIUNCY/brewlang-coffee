<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; line-height: 1.6; color: #292524; max-width: 640px; margin: 0 auto; padding: 24px; }
        .header { text-align: center; border-bottom: 2px solid #78350f; padding-bottom: 20px; margin-bottom: 20px; }
        .order-code { font-size: 24px; font-weight: bold; color: #78350f; }
        .details { background: #fffbeb; padding: 18px; border-radius: 12px; margin-bottom: 24px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 10px; border-bottom: 1px solid #e7e5e4; text-align: left; }
        th { background: #fafaf9; font-weight: 600; color: #57534e; }
        .total { font-weight: bold; font-size: 1.1em; text-align: right; }
        .footer { margin-top: 30px; color: #6b7280; font-size: 0.92em; }
        .highlight { font-weight: bold; color: #92400e; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Brewlang Coffee</h1>
        <p>Your order has been received.</p>
    </div>

    <p>Hi {{ $order->customer_name }},</p>
    <p>Thank you for your order. Please proceed to the cashier to complete your payment.</p>

    <div class="details">
        <p>Order Code: <span class="order-code">{{ $order->order_code }}</span></p>
        <p>Status: <span class="highlight">Unpaid</span></p>
        <p>Table Number: <strong>{{ $order->table_number }}</strong></p>
    </div>

    <h3>Order Summary</h3>
    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->menu_name_snapshot }}</td>
                <td>{{ $item->quantity }}</td>
                <td>Rp {{ number_format($item->price_snapshot, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="total">Total:</td>
                <td class="total">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Please show your order code to our staff when needed.</p>
        <p>&copy; {{ date('Y') }} Brewlang Coffee</p>
    </div>
</body>
</html>
