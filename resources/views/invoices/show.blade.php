<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                margin: 0;
                padding: 20px;
            }
            .invoice-container {
                box-shadow: none !important;
            }
        }

        body {
            background: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .invoice-container {
            background: white;
            max-width: 900px;
            margin: 30px auto;
            padding: 40px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            border-radius: 8px;
        }

        .invoice-header {
            border-bottom: 3px solid #ec3737;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .invoice-title {
            color: #ec3737;
            font-size: 2.5rem;
            font-weight: bold;
            margin: 0;
        }

        .company-info {
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .invoice-meta {
            background: linear-gradient(135deg, #fff5f5 0%, #ffe5e5 100%);
            padding: 20px;
            border-radius: 6px;
            margin-bottom: 30px;
        }

        .invoice-meta h6 {
            color: #ec3737;
            font-weight: 600;
            margin-bottom: 15px;
            font-size: 1.1rem;
        }

        .invoice-table {
            margin: 30px 0;
        }

        .invoice-table thead {
            background: #ec3737;
            color: white;
        }

        .invoice-table thead th {
            padding: 12px;
            font-weight: 600;
            border: none;
        }

        .invoice-table tbody td {
            padding: 12px;
            border-bottom: 1px solid #e0e0e0;
        }

        .invoice-table tbody tr:last-child td {
            border-bottom: 1px solid #e0e0e0;
        }

        .totals-section {
            background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%);
            border: 2px solid #ec3737;
            border-radius: 8px;
            padding: 20px;
            margin-top: 30px;
        }

        .totals-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 1rem;
        }

        .totals-row.discount {
            color: #ec3737;
            font-weight: 600;
        }

        .totals-row.grand-total {
            border-top: 2px solid #ec3737;
            margin-top: 10px;
            padding-top: 15px;
            font-size: 1.3rem;
            font-weight: bold;
            color: #ec3737;
        }

        .invoice-footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 2px solid #e0e0e0;
            text-align: center;
            color: #666;
            font-size: 0.9rem;
        }

        .payment-badge {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 4px;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .payment-badge.paid {
            background: rgba(34, 197, 94, 0.1);
            color: #22c55e;
        }

        .payment-badge.partial {
            background: rgba(234, 179, 8, 0.1);
            color: #eab308;
        }

        .payment-badge.pending {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        .print-button {
            background: linear-gradient(135deg, #ec3737 0%, #d42f2f 100%);
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 6px;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(236, 55, 55, 0.3);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .print-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(236, 55, 55, 0.4);
        }

        .back-button {
            background: white;
            border: 2px solid #ec3737;
            color: #ec3737;
            padding: 12px 30px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .back-button:hover {
            background: #ec3737;
            color: white;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Action Buttons (No Print) -->
        <div class="no-print mb-4 d-flex justify-content-between align-items-center">
            <a href="{{ route('invoices.index') }}" class="back-button">
                ← Back to Invoices
            </a>
            <button onclick="window.print()" class="print-button">
                🖨️ Print Invoice
            </button>
        </div>

        <!-- Invoice Header -->
        <div class="invoice-header">
            <div class="row">
                <div class="col-6">
                    <h1 class="invoice-title">INVOICE</h1>
                    <p class="text-muted mb-0">#{{ $invoice->invoice_number }}</p>
                </div>
                <div class="col-6 text-end company-info">
                    <h5 class="fw-bold mb-2">{{ auth()->user()->business->name }}</h5>
                    <p class="mb-0 text-secondary">
                        {{ auth()->user()->business->address ?? 'Business Address' }}<br>
                        {{ auth()->user()->business->phone ?? 'Phone Number' }}<br>
                        {{ auth()->user()->business->email ?? 'Email Address' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Invoice Meta Information -->
        <div class="row">
            <div class="col-md-7">
                <div class="invoice-meta">
                    <h6>BILL TO</h6>
                    <div>
                        <p class="fw-bold mb-1" style="font-size: 1.1rem;">
                            {{ $invoice->customer->name ?? 'Walk-in Customer' }}
                        </p>
                        @if($invoice->customer)
                            @if($invoice->customer->email)
                                <p class="mb-1">
                                    <strong>Email:</strong> {{ $invoice->customer->email }}
                                </p>
                            @endif
                            @if($invoice->customer->phone)
                                <p class="mb-1">
                                    <strong>Phone:</strong> {{ $invoice->customer->phone }}
                                </p>
                            @endif
                            @if($invoice->customer->address)
                                <p class="mb-0">
                                    <strong>Address:</strong> {{ $invoice->customer->address }}
                                </p>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="invoice-meta">
                    <h6>INVOICE DETAILS</h6>
                    <div class="mb-2">
                        <strong>Date:</strong> {{ \Carbon\Carbon::parse($invoice->date)->format('F d, Y') }}
                    </div>
                    <div class="mb-2">
                        <strong>Sales Channel:</strong> {{ $invoice->salesChannel->name ?? 'N/A' }}
                    </div>
                    <div class="mb-2">
                        <strong>Payment Method:</strong> {{ $invoice->payment_method }}
                    </div>
                    <div>
                        <strong>Status:</strong>
                        @if(strtolower($invoice->payment_status) === 'paid')
                            <span class="payment-badge paid">Paid</span>
                        @elseif(strtolower($invoice->payment_status) === 'partial')
                            <span class="payment-badge partial">Partial</span>
                        @else
                            <span class="payment-badge pending">Pending</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoice Items Table -->
        <table class="table invoice-table">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Item Description</th>
                    <th class="text-center" style="width: 100px;">Qty</th>
                    <th class="text-end" style="width: 120px;">Unit Price</th>
                    @if($invoice->saleItems->where('discount_amount', '>', 0)->count() > 0)
                        <th class="text-end" style="width: 120px;">Discount</th>
                    @endif
                    <th class="text-end" style="width: 150px;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->saleItems as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <strong>{{ $item->product->name }}</strong>
                            @if($item->product->sku)
                                <br><small class="text-muted">SKU: {{ $item->product->sku }}</small>
                            @endif
                        </td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-end">{{ auth()->user()->business->currency }} {{ number_format($item->unit_price, 2) }}</td>
                        @if($invoice->saleItems->where('discount_amount', '>', 0)->count() > 0)
                            <td class="text-end">
                                @if($item->discount_amount > 0)
                                    <span style="color: #ec3737; font-weight: 600;">
                                        -{{ auth()->user()->business->currency }} {{ number_format($item->discount_amount, 2) }}
                                    </span>
                                    <br>
                                    <small class="text-muted">
                                        ({{ $item->discount_type === 'percent' ? $item->discount_value . '%' : auth()->user()->business->currency . ' ' . number_format($item->discount_value, 2) }})
                                    </small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        @endif
                        <td class="text-end fw-bold">{{ auth()->user()->business->currency }} {{ number_format($item->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals Section -->
        <div class="row">
            <div class="col-md-6">
                @if($invoice->notes)
                    <div class="mb-3">
                        <h6 class="fw-bold mb-2">Notes:</h6>
                        <p class="text-secondary">{{ $invoice->notes }}</p>
                    </div>
                @endif
            </div>
            <div class="col-md-6">
                <div class="totals-section">
                    <div class="totals-row">
                        <span>Subtotal:</span>
                        <span>{{ auth()->user()->business->currency }} {{ number_format($invoice->subtotal, 2) }}</span>
                    </div>

                    @if($invoice->discount > 0)
                        <div class="totals-row discount">
                            <span>Item Discounts:</span>
                            <span>-{{ auth()->user()->business->currency }} {{ number_format($invoice->discount, 2) }}</span>
                        </div>
                    @endif

                    <div class="totals-row">
                        <span>Tax ({{ number_format($invoice->tax_rate, 0) }}%):</span>
                        <span>{{ auth()->user()->business->currency }} {{ number_format($invoice->tax, 2) }}</span>
                    </div>

                    <div class="totals-row grand-total">
                        <span>GRAND TOTAL:</span>
                        <span>{{ auth()->user()->business->currency }} {{ number_format($invoice->total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoice Footer -->
        <div class="invoice-footer">
            <p class="mb-1">Thank you for your business!</p>
            <p class="mb-0 text-muted">
                This is a computer-generated invoice. For any queries, please contact us at {{ auth()->user()->business->email ?? 'your@email.com' }}
            </p>
        </div>
    </div>

    <script>
        // Auto print detection
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('print') === 'true') {
            window.onload = function() {
                window.print();
            }
        }
    </script>
</body>
</html>

