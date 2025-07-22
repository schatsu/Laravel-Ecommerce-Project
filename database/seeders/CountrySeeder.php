<?php

namespace Database\Seeders;

use App\Helpers\DateFormat;
use App\Helpers\SlugHelper;
use App\Models\City;
use App\Models\Country;
use App\Models\District;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = Str::replace("Turkey", "Türkiye", File::get("database/data/countries.json"));

        $countries = json_decode($json);

        $cityId = 0;
        $cities = [];
        $districts = [];
        $timestamp = Carbon::now();

        foreach ($countries as $data) {
            $country = Country::query()->create([
                'name' => $data->name,
                'slug' => Str::slug($data->name),
                'short_name' => $data->iso2,
                'native_name' => $data->native ?? $data->name,
                'phone_code' => $data->phone_code,
                'capital' => $data->capital,
                'flag' => $data->emoji,
            ]);

            if (count($data->states) === 0) {
                ++$cityId;
                $cities[] = [
                    'id' => $cityId,
                    'country_id' => $country->id,
                    'name' => '-',
                    'slug' => Str::slug($data->name." ".$country->name, '-'),
                    'code' => $data->phone_code,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ];
                $districts[] = [
                    'city_id' => $cityId,
                    'name' => '-',
                    'slug' => Str::slug($data->name." ".$country->name." "."city", '-'),
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ];
            } else {
                foreach ($data->states as $state) {
                    ++$cityId;
                    $cities[] = [
                        'id' => $cityId,
                        'country_id' => $country->id,
                        'name' => $state->name,
                        'slug' => Str::slug($state->name." ".$country->name, '-'),
                        'code' => $state->state_code,
                        'created_at' => $timestamp,
                        'updated_at' => $timestamp,
                    ];
                    if (count($state->cities) === 0) {
                        $districts[] = [
                            'city_id' => $cityId,
                            'name' => $state->name,
                            'slug' => Str::slug($state->name." ".$state->name, '-'),
                            'created_at' => $timestamp,
                            'updated_at' => $timestamp,
                        ];
                    } else {
                        foreach ($state->cities as $city) {
                            $districts[] = [
                                'city_id' => $cityId,
                                'name' => $city->name,
                                'slug' => Str::slug($city->name." ".$state->name, '-'),
                                'created_at' => $timestamp,
                                'updated_at' => $timestamp,
                            ];
                        }
                    }
                }
            }
        }

        $citiesChunks = collect($cities)->chunk(500);
        $citiesChunks->each(function ($chunk) {
            City::query()->insert($chunk->toArray());
        });

        $districtsChunks = collect($districts)->chunk(500);
        $districtsChunks->each(function ($chunk) {
            District::query()->insert($chunk->toArray());
        });
    }
}
