<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Filament\Models\Contracts\HasAvatar;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable implements HasAvatar
{
    use HasFactory, Notifiable, HasRoles, LogsActivity;

    /**
     * Kolom yang boleh diisi (juga akan dilog jika pakai logFillable).
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar_url',
    ];

    /**
     * Kolom yang disembunyikan.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting atribut.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ----------------------------------------------------------------------
    // Avatar untuk Filament
    // ----------------------------------------------------------------------
    public function getFilamentAvatarUrl(): ?string
    {
        if ($this->avatar_url) {
            // pastikan storage:link sudah dibuat
            return Storage::disk('public')->url($this->avatar_url);
        }

        // null => Filament akan menampilkan inisial
        return null;
    }

    // ----------------------------------------------------------------------
    // Activity Log (Spatie)
    // ----------------------------------------------------------------------
    protected static array $recordEvents = ['created', 'updated', 'deleted'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()      // catat kolom $fillable
            ->logOnlyDirty()     // hanya jika ada perubahan nilai
            ->dontSubmitEmptyLogs(); // skip jika tidak ada perubahan
    }
}