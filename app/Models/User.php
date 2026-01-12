<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * الحقول القابلة للتعبئة الجماعية
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'MobileNumber',
        'RoleID',
        'display_order',
    ];

    /**
     * الحقول المخفية عند التحويل إلى JSON/Array
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * تحديد أنواع الـ Casts للحقول
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at'    => 'datetime',
            'password'             => 'hashed',
            'subscription_end_date'=> 'datetime',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'RoleID');
    }

    /**
     * التحقق مما إذا كان المستخدم لديه صلاحية معينة على كيان وإجراء محددين
     *
     * @param int $entityId
     * @param int $actionId
     * @return bool
     */
    public function hasPermission($entityId, $actionId): bool
    {
        if (!$this->role) {
            return false;
        }

        return $this->role->permissions()
            ->where('entity_id', $entityId)
            ->where('action_id', $actionId)
            ->exists();
    }
}