<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\UpdateAccountDetailsRequest;
use App\Http\Resources\CityResource;
use App\Http\Resources\DistrictResource;
use App\Models\City;
use App\Models\Country;
use App\Models\CouponUsage;
use App\Models\District;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserProfileController extends Controller
{
    public function account(): Factory|Application|View
    {
        /** @var User $user */
        $user = auth()->user();

        return view('app.account.index', compact('user'));
    }

    public function cities($countrySlug): AnonymousResourceCollection
    {
        $country = Country::query()->select('id')->where('slug', $countrySlug)->firstOrFail();

        $cities = City::query()->select(['slug', 'name'])->where('country_id', $country->id)->get();

        return CityResource::collection($cities);
    }

    public function districts($citySlug): AnonymousResourceCollection
    {
        $city = City::query()->select('id')->where('slug', $citySlug)->firstOrFail();

        $districts = District::query()->select(['slug', 'name'])->where('city_id', $city->id)->get();

        return DistrictResource::collection($districts);
    }

    public function accountDetails(): Factory|Application|View
    {
        /** @var User $user */
        $user = auth()->user();

        return view('app.account.account-detail', compact('user'));
    }

    public function updateAccountDetails(UpdateAccountDetailsRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $attributes = collect($request->validated())->except(['current_password', 'password', 'password_confirmation']);

        if ($request->filled('password')) {
            $attributes->put('password', bcrypt($request->password));
        }

        $user->update($attributes->toArray());

        return redirect()->back()->with('toast_success', 'Hesap bilgileriniz başarıyla güncellendi.');
    }

    public function coupons(): Factory|Application|View
    {
        /** @var User $user */
        $user = auth()->user();

        $activeCoupon = null;
        if ($user->cart && $user->cart->coupon) {
            $coupon = $user->cart->coupon;
            if ($coupon->isValidForUser($user->id)) {
                $activeCoupon = $coupon;
            }
        }

        $usedCoupons = CouponUsage::query()
            ->with('coupon', 'order')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('app.account.coupons', compact('user', 'activeCoupon', 'usedCoupons'));
    }
}
