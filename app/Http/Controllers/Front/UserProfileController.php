<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Http\Resources\DistrictResource;
use App\Models\City;
use App\Models\Country;
use App\Models\District;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
}
