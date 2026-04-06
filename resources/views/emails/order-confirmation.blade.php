<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #78350f; padding-bottom: 20px; margin-bottom: 20px; }
        .order-code { font-size: 24px; font-weight: bold; color: #78350f; }
        .details { background: #fdf8f6; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 10px; border-bottom: 1px solid #e5e7eb; text-align: left; }
        th { background: #f9fafb; font-weight: 600; color: #6b7280; }
        .total { font-weight: bold; font-size: 1.2em; text-align: right; }
        .footer { margin-top: 30px; text-align: center; color: #6b7280; font-size: 0.9em; }
        .highlight { font-weight: bold; color: #b45309; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Brewlang Coffee System</h1>
        <p>Order Placed Successfully!</p>
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
                <td>{{ $item->menu->name ?? 'Unknown item' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
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
        <p>Please show your Order Code to our staff.</p>
        <p>&copy; {{ date('Y') }} Brewlang Coffee System</p>
    </div>
</body>
</html>
