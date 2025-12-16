<?php

namespace App\Http\Controllers\Front;


use App\Http\Controllers\Controller;
use App\Http\Requests\Front\StoreInvoiceRequest;
use App\Http\Requests\Front\UpdateAddressRequest;
use App\Models\Country;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Throwable;


class CustomerInvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Factory|Application|View
    {
        $user = auth()->user();

        $address = $user?->invoices;

        $countries = Country::query()->select(['id','slug', 'name'])->orderByRaw("CASE WHEN (name = 'Türkiye') THEN 1 ELSE 0 END DESC")->get();

        return view('app.account.address', compact('address', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request): RedirectResponse
    {
        $attributes = collect($request->validated());

        $user = auth()->user();

        if (!empty($attributes->get('default_invoice')) && $attributes->get('default_invoice')) {
            $user->invoices()->update(['default_invoice' => false]);
        }
        elseif ($user->invoices()->count() === 0) {
            $attributes->get('default_invoice') == true;
        }

        $user->invoices()->create($attributes->toArray());

        return redirect()->route('account.address')->with('toast_success', 'Adres başarıyla kaydedildi.');
    }

    /**
     * Update the specified resource in storage.
     * @throws Throwable
     */
    public function update(UpdateAddressRequest $request, string $slug): RedirectResponse
    {
        $attributes = collect($request->validated());

        $user = auth()->user();

        $invoice = $user->invoices()->where('slug', $slug)->firstOrFail();

        if ($request->has('default_invoice') && $request->default_invoice) {
            $user->invoices()->where('id', '!=', $invoice->id)->update(['default_invoice' => false]);
            $attributes->put('default_invoice', true);
        } else {
            $attributes->put('default_invoice', false);
        }

        $invoice->update($attributes->toArray());

        throw_unless($invoice, \Exception::class, 'Hata');

        return redirect()->back()->with('toast_success', 'Adres başarıyla güncellendi.');
    }

    public function setDefault(string $slug): RedirectResponse
    {
        $user = auth()->user();

        $invoice = $user->invoices()->where('slug', $slug)->firstOrFail();

        $user->invoices()->update(['default_invoice' => false]);

        $invoice->update(['default_invoice' => true]);

        return redirect()->back()->with('toast_success', 'Varsayılan adres güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug): RedirectResponse
    {
        $user = auth()->user();

        $invoice = $user->invoices()->where('slug', $slug)->firstOrFail();

        $invoice->delete();

        return redirect()->back()->with('toast_success', 'Adres başarıyla silindi.');
    }
}
