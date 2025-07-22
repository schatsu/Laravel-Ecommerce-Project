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
use RealRashid\SweetAlert\Facades\Alert;


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

        $user->invoices()->create($attributes->toArray());

        return redirect()->route('account.address');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAddressRequest $request, string $slug): RedirectResponse
    {
        $attributes = collect($request->validated());

        $user = auth()->user();

        $invoice = $user->invoices()->where('slug', $slug)->firstOrFail();

        $invoice->update($attributes->toArray());

        throw_unless($invoice, \Exception::class, 'Hata');

        alert()->success('başarılı');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
