<?php

namespace App\Filament\Resources;

use App\Enums\Admin\ReviewStatusEnum;
use App\Filament\Resources\ReviewResource\Pages;
use App\Models\Review;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationGroup = 'Mağaza';

    protected static ?string $navigationLabel = 'Yorumlar';

    protected static ?string $modelLabel = 'Yorum';

    protected static ?string $pluralModelLabel = 'Yorumlar';

    protected static ?int $navigationSort = 6;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::pending()->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Yorum Bilgileri')
                    ->schema([
                        Forms\Components\Select::make('product_id')
                            ->label('Ürün')
                            ->relationship('product', 'name')
                            ->required()
                            ->disabled(),

                        Forms\Components\Select::make('user_id')
                            ->label('Kullanıcı')
                            ->relationship('user', 'name')
                            ->required()
                            ->disabled(),

                        Forms\Components\TextInput::make('rating')
                            ->label('Puan')
                            ->disabled()
                            ->suffix('/ 5'),

                        Forms\Components\Select::make('status')
                            ->label('Durum')
                            ->options([
                                'pending' => 'Beklemede',
                                'approved' => 'Onaylandı',
                                'rejected' => 'Reddedildi',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('title')
                            ->label('Başlık')
                            ->disabled()
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('content')
                            ->label('Yorum')
                            ->disabled()
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Admin Yanıtı')
                    ->schema([
                        Forms\Components\Textarea::make('admin_reply')
                            ->label('Yanıt')
                            ->rows(4)
                            ->placeholder('Müşteriye yanıt yazın...')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Ürün')
                    ->searchable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Kullanıcı')
                    ->searchable(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Başlık')
                    ->limit(30)
                    ->searchable(),

                Tables\Columns\TextColumn::make('rating')
                    ->label('Puan')
                    ->badge()
                    ->color(fn (int $state): string => match (true) {
                        $state >= 4 => 'success',
                        $state >= 3 => 'warning',
                        default => 'danger',
                    })
                    ->formatStateUsing(fn (int $state): string => str_repeat('★', $state) . str_repeat('☆', 5 - $state)),

                Tables\Columns\TextColumn::make('status')
                    ->label('Durum')
                    ->badge()
                    ->color(fn (ReviewStatusEnum $state): string => $state->color())
                    ->formatStateUsing(fn (ReviewStatusEnum $state): string => $state->label()),

                Tables\Columns\IconColumn::make('admin_reply')
                    ->label('Yanıt')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->getStateUsing(fn (Review $record): bool => !empty($record->admin_reply)),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tarih')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Durum')
                    ->options([
                        'pending' => 'Beklemede',
                        'approved' => 'Onaylandı',
                        'rejected' => 'Reddedildi',
                    ]),
                Tables\Filters\SelectFilter::make('rating')
                    ->label('Puan')
                    ->options([
                        '5' => '5 Yıldız',
                        '4' => '4 Yıldız',
                        '3' => '3 Yıldız',
                        '2' => '2 Yıldız',
                        '1' => '1 Yıldız',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('Onayla')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Review $record): bool => $record->status !== ReviewStatusEnum::APPROVED)
                    ->action(fn (Review $record) => $record->update(['status' => 'approved'])),

                Tables\Actions\Action::make('reject')
                    ->label('Reddet')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (Review $record): bool => $record->status !== ReviewStatusEnum::REJECTED)
                    ->action(fn (Review $record) => $record->update(['status' => 'rejected'])),

                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('approve')
                        ->label('Seçilenleri Onayla')
                        ->icon('heroicon-o-check')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(fn ($records) => $records->each->update(['status' => 'approved'])),

                    Tables\Actions\BulkAction::make('reject')
                        ->label('Seçilenleri Reddet')
                        ->icon('heroicon-o-x-mark')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(fn ($records) => $records->each->update(['status' => 'rejected'])),

                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReviews::route('/'),
            'edit' => Pages\EditReview::route('/{record}/edit'),
        ];
    }
}
