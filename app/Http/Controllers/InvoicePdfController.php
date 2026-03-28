<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class InvoicePdfController extends Controller
{
    public function __invoke(Invoice $invoice): Response
    {
        Gate::authorize('viewPdf', $invoice);

        $invoice->load([
            'booking.user',
            'booking.staff',
            'booking.service',
        ]);

        $booking = $invoice->booking;
        if (! $booking) {
            abort(404);
        }

        $pdf = Pdf::loadView('invoices.pdf', [
            'invoice' => $invoice,
            'booking' => $booking,
        ]);

        $pdf->setPaper('a4', 'portrait');

        $filename = 'invoice-'.$invoice->id.'.pdf';

        return $pdf->download($filename);
    }
}
