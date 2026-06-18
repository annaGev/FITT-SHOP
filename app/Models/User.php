<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'mobile' => 'string',
        ];
    }
    protected static function boot()
    {
        parent::boot();

        // При сохранении/создании
        static::saving(function ($user) {
            if ($user->mobile && $user->isDirty('mobile')) {
                $user->mobile = self::normalizePhone($user->mobile);
            }
        });

        static::creating(function ($user) {
            if ($user->mobile) {
                $user->mobile = self::normalizePhone($user->mobile);
            }
        });
    }

    /**
     * Нормализует русский номер телефона
     */
   /**
 * Нормализует русский номер телефона
 */
public static function normalizePhone($phone): string
{
    // Убираем всё кроме цифр
    $phone = preg_replace('/[^0-9]/', '', $phone);
    
    // Если пусто, возвращаем пустую строку
    if (empty($phone)) {
        return '';
    }
    
    // Если 10 цифр (без кода страны)
    if (strlen($phone) == 10) {
        $phone = '7' . $phone;
    }
    
    // Если начинается с 8 (российский формат)
    if (strlen($phone) == 11 && substr($phone, 0, 1) == '8') {
        $phone = '7' . substr($phone, 1);
    }
    
    // Если 11 цифр и начинается с 7 - оставляем как есть
    if (strlen($phone) == 11 && substr($phone, 0, 1) == '7') {
        return $phone; // 79991234567
    }
    
    // Если получилось больше 11 цифр, обрезаем
    if (strlen($phone) > 11) {
        $phone = substr($phone, 0, 11);
    }
    
    // Если меньше 11 цифр, добавляем 7 в начало
    if (strlen($phone) < 11) {
        $phone = '7' . $phone;
    }
    
    return $phone; // 79991234567 (без +)
}

    /**
     * Форматированный номер для отображения
     */
    /**
 * Форматированный номер для отображения
 */
public function getFormattedMobileAttribute(): string
{
    $phone = preg_replace('/[^0-9]/', '', $this->mobile ?? '');
    
    if (empty($phone) || strlen($phone) < 11) {
        return $this->mobile ?? '';
    }
    
    // Если есть код страны 7 в начале, убираем для форматирования
    if (strlen($phone) == 11 && $phone[0] == '7') {
        $phone = substr($phone, 1); // Убираем 7
        return '+7 ' . preg_replace('/(\d{3})(\d{3})(\d{2})(\d{2})/', '($1) $2-$3-$4', $phone);
        // +7 (999) 123-45-67
    }
    
    return $this->mobile;
}
}
