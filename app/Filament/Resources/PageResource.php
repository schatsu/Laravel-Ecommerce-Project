<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Filament\Resources\PageResource\RelationManagers;
use App\Models\Page;
use BezhanSalleh\FilamentShield\Support\Utils;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Site';
    protected static ?int $navigationSort = 2;
    protected static ?string $label = 'Sayfa';
    protected static ?string $pluralLabel = 'Sayfalar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Sayfa Bilgileri')
                    ->description('Sayfa başlığı, slug ve yayın durumunu buradan düzenleyebilirsiniz.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Başlık')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn($state, callable $set) => $set('slug', \Str::slug($state))),

                                Forms\Components\TextInput::make('slug')
                                    ->label('Slug')
                                    ->required()
                                    ->unique(Page::class, 'slug', ignoreRecord: true),
                            ]),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Yayın Durumu'),
                    ])
                    ->columns(1)
                    ->collapsible(),

                Section::make('İçerik')
                    ->description('Sayfa içeriğini buradan düzenleyebilirsiniz.')
                    ->schema([
                        Forms\Components\RichEditor::make('content')
                            ->label('İçerik')
                            ->columnSpanFull(),
                    ])
                    ->columns(1)
                    ->collapsible(),
            ]);
    }



    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Başlık')->searchable(),
                TextColumn::make('slug')->label('Slug')->searchable(),
                BooleanColumn::make('is_active')->label('Aktif mi'),
                TextColumn::make('updated_at')->label('Güncellendi')->since(),
            ])
            ->reorderable('order')
            ->defaultSort('order')
            ->filters([
                //
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return Utils::isResourceNavigationBadgeEnabled()
            ? strval(static::getEloquentQuery()->count())
            : null;
    }
}
