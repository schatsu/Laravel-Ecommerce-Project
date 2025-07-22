<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceRelationManagerResource\RelationManagers\InvoicesRelationManager;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use BezhanSalleh\FilamentShield\Support\Utils;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Kullanıcı Yönetimi';
    protected static ?int $navigationSort = 1;
    protected static ?string $label = 'Kullanıcı';
    protected static ?string $pluralLabel = 'Kullanıcılar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Kullanıcı Bilgileri')
                    ->tabs([
                        Tabs\Tab::make('Genel Bilgiler')->schema([
                            Card::make([
                                Grid::make(2)->schema([
                                    TextInput::make('name')
                                        ->label('Ad')
                                        ->required()
                                        ->maxLength(255),

                                    TextInput::make('surname')
                                        ->label('Soyad')
                                        ->required()
                                        ->maxLength(255),
                                ]),

                                Grid::make(2)->schema([
                                    TextInput::make('phone')
                                        ->label('Telefon')
                                        ->tel()
                                        ->mask(fn () => '(999) 999 99 99')
                                        ->prefixIcon('heroicon-o-phone')
                                        ->maxLength(20),

                                    TextInput::make('email')
                                        ->label('E-posta')
                                        ->email()
                                        ->required()
                                        ->maxLength(255),
                                ]),

                                Grid::make(2)->schema([
                                    DateTimePicker::make('email_verified_at')
                                        ->label('E-posta Doğrulama Tarihi'),

                                    TextInput::make('password')
                                        ->label('Şifre')
                                        ->password()
                                        ->maxLength(255)
                                        ->autocomplete('new-password')
                                        ->required(fn (string $context): bool => $context === 'create'),
                                ]),
                            ]),
                        ]),

                        Tabs\Tab::make('Roller')->schema([
                            Card::make([
                                Select::make('roles')
                                    ->label('Roller')
                                    ->relationship('roles', 'name')
                                    ->multiple()
                                    ->searchable()
                                    ->preload()
                                    ->columnSpanFull(),
                            ]),
                        ]),
                    ])->columnSpanFull(),
            ]);
    }



    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Ad')->searchable(),
                Tables\Columns\TextColumn::make('surname')->label('Soyad')->searchable(),
                Tables\Columns\TextColumn::make('phone')->label('Telefon')->searchable(),
                Tables\Columns\TextColumn::make('email')->label('E-posta')->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')->label('Doğrulama')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label('Oluşturulma')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->label('Güncellenme')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }


    public static function getRelations(): array
    {
        return [
            InvoicesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return Utils::isResourceNavigationBadgeEnabled()
            ? strval(static::getEloquentQuery()->count())
            : null;
    }
}
