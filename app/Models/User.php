<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
	use HasRoles, SoftDeletes;
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
		'phone',
		'photo',
		'title',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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
        ];
    }

    public function cartItems() {
        return $this->belongsToMany(Product::class, 'carts', 'user_id', 'product_id')->withTimestamps();
    }
    
    public function hasAdded(Product $product) {
        return $this->cartItems()->where('product_id', $product->id)->exists();
    }
    
    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'coupon_user')->withPivot('used_at')->withTimestamps();
    }

    // public function likes() {
    //     return $this->belongsToMany(Post::class, 'post_like')->withTimestamps();
    // }
    
    // public function hasLiked(Post $post) {
    //     return $this->likes()->where('post_id', $post->id)->exists();
    // }

    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function parent()
    {
        return $this->hasOne(Guardian::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
