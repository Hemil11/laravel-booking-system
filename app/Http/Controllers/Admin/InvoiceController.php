<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permission:manage_bookings']);
    }

    public function index(): View
    {
        $invoices = Invoice::query()
            ->with(['booking.user', 'booking.service', 'booking.staff'])
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.invoices.index', compact('invoices'));
    }
}
