<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class Order extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

 /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'city',
        'region',
        'phone',
        'budget',
        'description',
        'type'   
    ];


    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }



    public function createOrder(array $data, int $id): Order {
    return Order::create([
        'user_id' => $id,
        'city' => $data['city'],
        'region' => $data['region'],
        'phone' => $data['phone'],
        'budget' => $data['budget'],
        'description' => $data['description'],
        'type' => $data['type'],
    ]);
    }
/**
     * Find an order by its ID.
     *
     * @param int $id
     * @return OrderModel|null
     */
    public function findOrderById(int $id) : Order {
        // البحث عن الطلب بواسطة المعرف
        try {
            return Order::find($id);
        }catch (\Exception $e) {
            Log::error('Error deleting order: ' . $e->getMessage());
        }
    }
    public function deleteOrder(int $id) : void {
        try{
            $order = Order::findOrderById($id);
            $order->delete();
        }catch (\Exception $e) {
            Log::error('Error deleting order: ' . $e->getMessage());
        }
    }

    public static function getSaleOrders() : Order {
        return  Order::where('type', 'sale')->get();
    }
}
