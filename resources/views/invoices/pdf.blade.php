<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ __('Invoice #:id', ['id' => $invoice->id]) }}</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            line-height: 1.45;
            color: #111827;
            margin: 0;
            padding: 28px 36px;
        }
        .muted { color: #6b7280; }
        .header {
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 14px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0 0 4px 0;
            font-size: 22px;
            color: #1e1b4b;
        }
        .meta-table {
            width: 100%;
            margin-bottom: 22px;
        }
        .meta-table td { vertical-align: top; padding: 0; }
        .meta-table td:last-child { text-align: right; }
        .section-title {
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #4b5563;
            margin: 0 0 6px 0;
        }
        .box {
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            padding: 12px 14px;
            margin-bottom: 16px;
            background: #fafafa;
        }
        .box p { margin: 0 0 4px 0; }
        .box p:last-child { margin-bottom: 0; }
        table.breakdown {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        table.breakdown th,
        table.breakdown td {
            padding: 8px 10px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }
        table.breakdown th {
            background: #f3f4f6;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #374151;
        }
        table.breakdown .num { text-align: right; font-family: DejaVu Sans, monospace; }
        table.breakdown tr.total-row td {
            border-bottom: none;
            font-weight: bold;
            font-size: 12px;
            padding-top: 12px;
        }
        .status-paid { color: #15803d; font-weight: bold; }
        .status-unpaid { color: #b45309; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ config('app.name') }}</h1>
        <span class="muted">{{ __('Invoice') }}</span>
    </div>

    <table class="meta-table">
        <tr>
            <td>
                <p class="section-title">{{ __('Bill to') }}</p>
                <p style="margin:0;font-weight:bold;">{{ $booking->user?->name ?? '—' }}</p>
                <p class="muted" style="margin:4px 0 0 0;">{{ $booking->user?->email ?? '' }}</p>
            </td>
            <td>
                <p><strong>{{ __('Invoice #') }}</strong> {{ $invoice->id }}</p>
                <p class="muted">{{ __('Issued') }}: {{ $invoice->created_at?->timezone(config('app.timezone'))->format('Y-m-d H:i') ?? '—' }}</p>
                <p>
                    <strong>{{ __('Payment') }}:</strong>
                    @if ($invoice->status === \App\Models\Invoice::STATUS_PAID)
                        <span class="status-paid">{{ __('Paid') }}</span>
                    @else
                        <span class="status-unpaid">{{ __('Unpaid') }}</span>
                    @endif
                </p>
            </td>
        </tr>
    </table>

    <p class="section-title">{{ __('Appointment & service') }}</p>
    <div class="box">
        <p><strong>{{ __('Service') }}</strong> — {{ $booking->service?->name ?? '—' }}</p>
        @if ($booking->service?->description)
            <p class="muted" style="margin-top:6px;">{{ \Illuminate\Support\Str::limit(strip_tags($booking->service->description), 320) }}</p>
        @endif
        <p style="margin-top:8px;">
            <strong>{{ __('Duration') }}:</strong> {{ $booking->service?->duration ?? '—' }} {{ __('minutes') }}
            &nbsp;|&nbsp;
            <strong>{{ __('Date') }}:</strong> {{ $booking->date?->format('Y-m-d') ?? '—' }}
            &nbsp;|&nbsp;
            <strong>{{ __('Time') }}:</strong> {{ $booking->time ? substr((string) $booking->time, 0, 5) : '—' }}
        </p>
        <p>
            <strong>{{ __('Staff') }}:</strong> {{ $booking->staff?->full_name ?? '—' }}
        </p>
        <p>
            <strong>{{ __('Booking reference') }}:</strong> #{{ $booking->id }}
        </p>
    </div>

    <p class="section-title">{{ __('Price breakdown') }}</p>
    <table class="breakdown">
        <thead>
            <tr>
                <th>{{ __('Description') }}</th>
                <th class="num" style="width:28%;">{{ __('Amount (USD)') }}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $booking->service?->name ?? __('Service') }}</td>
                <td class="num">${{ number_format((float) $invoice->amount, 2) }}</td>
            </tr>
            <tr>
                <td>{{ __('Tax') }}</td>
                <td class="num">${{ number_format((float) $invoice->tax, 2) }}</td>
            </tr>
            <tr class="total-row">
                <td>{{ __('Total due') }}</td>
                <td class="num">${{ number_format((float) $invoice->total, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <p class="muted" style="margin-top:24px;font-size:9px;">
        {{ __('Thank you for your business.') }}
    </p>
</body>
</html>
