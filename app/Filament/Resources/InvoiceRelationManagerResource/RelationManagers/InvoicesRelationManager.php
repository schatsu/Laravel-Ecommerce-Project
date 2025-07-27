<?php

namespace App\Filament\Resources\InvoiceRelationManagerResource\RelationManagers;

use App\Enums\Admin\InvoiceCompanyTypeEnum;
use App\Models\City;
use App\Models\Country;
use App\Models\District;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class InvoicesRelationManager extends RelationManager
{
    protected static string $relationship = 'invoices';
    protected static ?string $title = 'Faturalar';


    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('Ad Soyad / Şirket Yetkilisi')
                ->required()
                ->maxLength(255),

            Forms\Components\Select::make('country_id')
                ->label('Ülke')
                ->options(Country::query()->pluck('name', 'id'))
                ->searchable()
                ->reactive()
                ->afterStateUpdated(fn($state, callable $set) => $set('city_id', null))
                ->required(),

            Forms\Components\Select::make('city_id')
                ->label('İl')
                ->options(fn(callable $get) => City::query()->where('country_id', $get('country_id'))->pluck('name', 'id')
                )
                ->searchable()
                ->reactive()
                ->afterStateUpdated(fn($state, callable $set) => $set('district_id', null))
                ->required(),

            Forms\Components\Select::make('district_id')
                ->label('İlçe')
                ->options(fn(callable $get) => District::query()->where('city_id', $get('city_id'))->pluck('name', 'id')
                )
                ->searchable()
                ->required(),

            Forms\Components\Select::make('company_type')
                ->label('Fatura Türü')
                ->options(InvoiceCompanyTypeEnum::labels())
                ->required()
                ->reactive(),

            Forms\Components\TextInput::make('identity_number')
                ->label('T.C. Kimlik No')
                ->maxLength(11)
                ->visible(fn(Forms\Get $get) => $get('company_type') === InvoiceCompanyTypeEnum::INDIVIDUAL->value
                ),

            Forms\Components\TextInput::make('company_name')
                ->label('Şirket Adı')
                ->maxLength(255)
                ->visible(fn(Forms\Get $get) => $get('company_type') === InvoiceCompanyTypeEnum::CORPORATE->value
                ),

            Forms\Components\TextInput::make('tax_number')
                ->label('Vergi Numarası')
                ->maxLength(50)
                ->visible(fn(Forms\Get $get) => $get('company_type') === InvoiceCompanyTypeEnum::CORPORATE->value
                ),

            Forms\Components\TextInput::make('tax_office')
                ->label('Vergi Dairesi')
                ->maxLength(255)
                ->visible(fn(Forms\Get $get) => $get('company_type') === InvoiceCompanyTypeEnum::CORPORATE->value
                ),

            Forms\Components\TextInput::make('phone')
            ->label('Telefon')
            ->prefix('+90')
            ->mask('(999) 999 99 99'),

            Forms\Components\Toggle::make('default_invoice')
                ->label('Varsayılan Fatura'),

            Forms\Components\Textarea::make('address')
                ->label('Adres')
                ->rows(3)
                ->required()
                ->columnSpanFull(),

        ]);
    }


    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Ad Soyad / Yetkili'),
                Tables\Columns\TextColumn::make('company_name')->label('Şirket'),
                Tables\Columns\TextColumn::make('company_type')
                    ->label('Fatura Türü')
                    ->state(function ($record) {
                        return match ($record->company_type) {
                            InvoiceCompanyTypeEnum::INDIVIDUAL => 'Bireysel',
                            InvoiceCompanyTypeEnum::CORPORATE => 'Kurumsal',
                            default => 'Belirsiz',
                        };
                    }),
                Tables\Columns\TextColumn::make('phone')->label('Telefon'),

                Tables\Columns\IconColumn::make('default_invoice')
                    ->label('Varsayılan')
                    ->boolean(),
                Tables\Columns\TextColumn::make('city.name')->label('İl'),
                Tables\Columns\TextColumn::make('district.name')->label('İlçe'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Fatura Ekle')
                    ->modalHeading('Yeni Fatura Oluştur')
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}

