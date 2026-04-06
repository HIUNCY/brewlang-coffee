<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #78350f; padding-bottom: 20px; margin-bottom: 20px; }
        .order-code { font-size: 24px; font-weight: bold; color: #78350f; }
        .status-box { background: #fdf8f6; padding: 20px; border-radius: 8px; margin-bottom: 20px; text-align: center; }
        .status { font-size: 1.5em; font-weight: bold; color: #b45309; text-transform: uppercase; }
        .footer { margin-top: 30px; text-align: center; color: #6b7280; font-size: 0.9em; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Brewlang Coffee System</h1>
        <p>Order Status Update</p>
    </div>

    <p>Hi {{ $order->customer_name }},</p>
    
    <div class="status-box">
        <p>Order Code: <span class="order-code">{{ $order->order_code }}</span></p>
        <p>Your order is now:</p>
        <div class="status">{{ $order->status_label }}</div>
    </div>

    <p style="text-align: center; font-size: 1.1em; margin: 30px 0;">
        @if($order->status === 'paid')
            Your payment has been received. We're preparing your order.
        @elseif($order->status === 'in_progress')
            Your order is now being prepared by our barista.
        @elseif($order->status === 'all_done')
            Your order is ready! Please pick it up at the counter.
        @else
            Please check the latest status.
        @endif
    </p>

    <div class="footer">
        <p>Thank you for choosing Brewlang!</p>
        <p>&copy; {{ date('Y') }} Brewlang Coffee System</p>
    </div>
</body>
</html>
