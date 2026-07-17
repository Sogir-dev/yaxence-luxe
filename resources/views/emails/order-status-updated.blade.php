<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $headline }}</title>
</head>
<body style="margin:0; padding:0; background-color:#000000; font-family: Georgia, 'Times New Roman', serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#000000;">
        <tr>
            <td align="center" style="padding: 40px 20px;">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px; width:100%; background-color:#0a0a0a; border:1px solid #4a3a19;">

                    {{-- Header --}}
                    <tr>
                        <td align="center" style="padding: 40px 30px 20px;">
                            <p style="margin:0; font-size:22px; letter-spacing:4px; color:#d4af6a; font-family: Georgia, serif;">
                                YAXENCE <span style="color:#ffffff;">LUXE</span>
                            </p>
                        </td>
                    </tr>

                    {{-- Message --}}
                    <tr>
                        <td align="center" style="padding: 0 30px 30px;">
                            <p style="margin:0 0 8px; font-size:11px; letter-spacing:3px; text-transform:uppercase; color:#d4af6a;">Order #{{ $order->id }}</p>
                            <h1 style="margin:0 0 10px; font-size:24px; color:#ffffff; font-weight:normal;">{{ $headline }}</h1>
                            <p style="margin:0; font-size:14px; color:#a3a3a3; line-height:1.6;">
                                {{ $body }}
                            </p>
                        </td>
                    </tr>

                    {{-- Items --}}
                    <tr>
                        <td style="padding: 0 30px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-top:1px solid #262626;">
                                @foreach($order->items as $item)
                                    <tr>
                                        <td style="padding: 14px 0; border-bottom:1px solid #262626; font-size:14px; color:#d4d4d4;">
                                            {{ $item->product_name }} &times; {{ $item->quantity }}
                                        </td>
                                        <td align="right" style="padding: 14px 0; border-bottom:1px solid #262626; font-size:14px; color:#e5e5e5;">
                                            &#8358;{{ number_format($item->subtotal, 0) }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td style="padding: 16px 0; font-size:15px; color:#ffffff; font-weight:bold;">Total</td>
                                    <td align="right" style="padding: 16px 0; font-size:15px; color:#d4af6a; font-weight:bold;">
                                        &#8358;{{ number_format($order->total, 0) }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- Shipping --}}
                    <tr>
                        <td style="padding: 10px 30px 30px;">
                            <p style="margin:0 0 4px; font-size:11px; letter-spacing:2px; text-transform:uppercase; color:#737373;">Shipping To</p>
                            <p style="margin:0; font-size:14px; color:#d4d4d4; line-height:1.6;">{{ $order->shipping_address }}</p>
                        </td>
                    </tr>

                    {{-- CTA --}}
                    <tr>
                        <td align="center" style="padding: 0 30px 40px;">
                            <a href="{{ route('checkout.confirmation', $order) }}"
                               style="display:inline-block; background-color:#d4af6a; color:#000000; text-decoration:none; padding: 14px 32px; font-size:11px; letter-spacing:2px; text-transform:uppercase; font-family: Arial, sans-serif; font-weight:bold;">
                                View Order
                            </a>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td align="center" style="padding: 24px 30px; border-top:1px solid #262626;">
                            <p style="margin:0; font-size:11px; color:#525252; letter-spacing:1px;">
                                &copy; {{ date('Y') }} YAXENCE LUXE &middot; A House of Fragrance
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
