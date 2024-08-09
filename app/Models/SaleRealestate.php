<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class SaleRealestate extends Model
{
    use HasFactory;

    protected $table = 'sale_realestate_table';

    protected $fillable = [
        'user_id', 'phone', 'type', 'city', 'region', 'desc', 'brushes',
        'preparation', 'seller_type', 'floor', 'price', 'area', 'views',
        'evaluation', 'property_type', 'bathrooms_number', 'wifi', 'elevator',
        'barking', 'swimming_bool', 'solar_energy', 'images'
    ];
    protected $casts = [
        'images' => 'json',
        'wifi' => 'boolean',
        'elevator' => 'boolean',
        'barking' => 'boolean',
        'swimming_bool' => 'boolean',
        'solar_energy' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    
    public function createRecord(array $data, int $id, array $images): SaleRealestate {
        return SaleRealestate::create([
        'user_id' => $id,
        'phone' => $data['phone'],
        'type' => $data['type'],
        'city' => $data['city'],
        'region' => $data['region'],
        'desc' => $data['desc'],
        'brushes' => $data['brushes'],
        'preparation' => $data['preparation'],
        'seller_type' => $data['seller_type'],
        'floor' => $data['floor'],
        'price' => $data['price'],
        'area' => $data['area'],
        'views' => $data['views'],
        'evaluation' => $data['evaluation'],
        'property_type' => $data['property_type'],
        'bathrooms_number' => $data['bathrooms_number'],
        'wifi' => $data['wifi'],
        'elevator' => $data['elevator'],
        'barking' => $data['barking'],
        'swimming_bool' => $data['swimming_bool'],
        'solar_energy' => $data['solar_energy'],
        'images' =>  $images,
        ]);
    }
      


public function handleImages64(array $images) {
    $urls = []; // مصفوفة لتخزين الروابط

    foreach ($images as $image) {
        // استقبال صورة Base64
        $base64Image = $image;
        // إزالة المعلومات الإضافية
        list($type, $base64Image) = explode(';', $base64Image);
        list(, $base64Image) = explode(',', $base64Image);

        // تحويل Base64 إلى صورة
        $imageData = base64_decode($base64Image);

        // تحديد امتداد الملف
        $extension = Str::after($type, '/');
        $fileName = Str::random(10) . '.' . $extension;
        // تخزين الصورة في نظام الملفات
        $path = 'public/images/' . $fileName;
        Storage::put($path, $imageData);
        // إضافة رابط الوصول للصورة إلى المصفوفة
        $urls[] = Storage::url($path);  }

    // إرجاع مصفوفة الروابط كاستجابة 
    return $urls;
}

/**
     * Find an SaleRealestate by its ID.
     *
     * @param int $id
     * @return SaleRealestate|null
     */
    public function findRealEstateById(int $id) : SaleRealestate {
        // البحث عن الطلب بواسطة المعرف
        try {
            return SaleRealestate::find($id);
        }catch (\Exception $e) {
            Log::error('Error deleting order: ' . $e->getMessage());
        }
    }
    public function deleteRealEstate(int $id) : void {
        try{
            $realEsate = SaleRealestate::findSaleRealestateById($id);
            $realEsate->delete();
        }catch (\Exception $e) {
            Log::error('Error deleting order: ' . $e->getMessage());
        }
    }
    
}

