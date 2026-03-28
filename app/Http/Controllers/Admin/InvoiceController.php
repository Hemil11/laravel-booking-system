<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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

        $bulkStatusOptions = [
            'paid' => __('Mark as paid'),
            'unpaid' => __('Mark as unpaid'),
        ];

        return view('admin.invoices.index', compact('invoices', 'bulkStatusOptions'));
    }

    public function bulk(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'bulk_action' => ['required', 'string', Rule::in(['delete', 'set_status'])],
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer', 'exists:invoices,id'],
            'status_value' => ['nullable', 'string', Rule::in(['paid', 'unpaid'])],
        ]);

        $ids = array_values(array_unique(array_map('intval', $validated['ids'])));
        $invoices = Invoice::query()->whereIn('id', $ids)->get();

        if ($invoices->count() !== count($ids)) {
            return back()->withErrors(['ids' => __('Invalid selection.')]);
        }

        $affected = 0;

        if ($validated['bulk_action'] === 'delete') {
            foreach ($invoices as $invoice) {
                $invoice->delete();
                $affected++;
            }

            return back()->with('status', __('Deleted :n invoice(s).', ['n' => $affected]));
        }

        $statusValue = $validated['status_value'] ?? '';
        if ($statusValue === '') {
            return back()->withErrors(['status_value' => __('Choose paid or unpaid.')]);
        }

        foreach ($invoices as $invoice) {
            if ($invoice->status !== $statusValue) {
                $invoice->update(['status' => $statusValue]);
                $affected++;
            }
        }

        return back()->with('status', __('Updated :n invoice(s).', ['n' => $affected]));
    }
}
