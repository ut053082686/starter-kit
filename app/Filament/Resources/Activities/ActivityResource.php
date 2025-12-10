<?php

namespace App\Filament\Resources\Activities;

use App\Filament\Resources\Activities\Pages\ListActivities;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Activity;
use UnitEnum;

class ActivityResource extends Resource
{
    protected static ?string $model = Activity::class;

    public static BackedEnum|string|null $navigationIcon = 'heroicon-o-clipboard-document-list';
    public static UnitEnum|string|null $navigationGroup = 'Settings';
    public static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('description')
                    ->label('Aktivitas')
                    ->searchable()
                    ->sortable(),

                // Tidak dibuat sortable kustom untuk menghindari closure injection error
                Tables\Columns\TextColumn::make('causer.name')
                    ->label('Oleh')
                    ->searchable(function (Builder $query, string $search): Builder {
                        return $query->whereHasMorph(
                            'causer',
                            [User::class],
                            fn (Builder $q) => $q->where('name', 'like', "%{$search}%")
                        );
                    })
                    ->default('–'),

                Tables\Columns\TextColumn::make('subject_type')
                    ->label('Model')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => Str::afterLast($state ?? '', '\\'))
                    ->default('–'),

                // Tambahkan kolom tanggal di sini
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([])
            ->actions([])
            ->bulkActions([])
            ->recordTitleAttribute('description')
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListActivities::route('/'),
        ];
    }

    // Read-only
    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }
}