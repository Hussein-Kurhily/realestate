<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSaleRealestateRequest;
use App\Models\SaleRealestate;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SaleRealestateController extends Controller {

    protected $realEstateService;

    public function __construct(SaleRealestate $realEstateService){
        $this->realEstateService = $realEstateService;
    }

    public function index() : JsonResponse {
    try{
        // get all realEstates
        $realestates = SaleRealestate::all();

        return response()->json(['status' => 'success', 'data' => $realestates], 201);
    } catch (\Exception $e) {
            // إرجاع استجابة بخطأ داخلي في الخادم
            return response()->json(['message' => 'خطأ بالسيرفر يرجى المحاولة لاحقا'], 500);
    }
}




// store object of realestate in database 
public function store(StoreSaleRealestateRequest $request){
    try {
        /** @var \App\Models\UserModel $user **/
        $user = Auth::user();
        if (!$user) { 
            return response()->json(['message' => 'غير مسجل'], 401);
        }
        $userid = $user->id;
        $validated = $request->validated(); //this should replace by specifec Reques
      

        //hangle images 
        $images = $this->realEstateService->handleImages64($request->images);

        // Create SaleRealestate record
        $this->realEstateService->createRecord($validated, $userid, $images);

        return response()->json(['status' => 'success'], 201);
    } catch (\Exception $e) {
        // Handle any errors
        return response()->json(['message' =>'خطأ بالسيرفر يرجى المحاولة لاحقا'], 500);
    }
}


    // show By id 
    public function show()
    {
        /** @var \App\Models\UserModel $user **/
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'لا يمكنك القيام بهذه العملية'], 401);
        }
    
        $userid = $user->id;

        $myRealEstate = SaleRealestate::where('user_id',$userid)->get();

        if (!$myRealEstate) {
            return response()->json(['message' => 'العقار غير موجود'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $myRealEstate], 200);
    }


    // show  showRealEstateByCountry
    public function showRealEstateByCountry(Request $request)
    {
        /** @var \App\Models\UserModel $user **/
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'لا يمكنك القيام بهذه العملية'], 401);
        }
    

        $myRealEstate = SaleRealestate::where('city',$request->city)->get();

        if (!$myRealEstate) {
            return response()->json(['message' => 'العقار غير موجود'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $myRealEstate], 200);
    }
    
 // delete 
 public function destroy(Request $request): JsonResponse
{
    try {
        // جلب المستخدم الحالي
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'لا يمكنك القيام بهذه العملية'], 401);
        }

        // البحث عن الطلب بواسطة المعرف
        $realestate = $this->realEstateService->findRealEstateById($request->id);

        if (!$realestate) {
            return response()->json(['message' => 'الطلب ليس موجود'], 404);
        }

        // التحقق مما إذا كان المستخدم هو صاحب الطلب ة
        if ($user->id !== $realestate->user_id ) {
            return response()->json(['message' => 'يمكن لمالك الطلب فقط حذفه'], 403);
        }

        // حذف الطلب
        $this->realEstateService->deleteRealEstate($request->id);

        return response()->json(['state' => 'success','message' => 'تم حذف الطلب'], 201);
    } catch (\Exception $e) {
        // تسجيل الخطأ
        Log::error('Error deleting order: ' . $e->getMessage());

        // إرجاع استجابة بخطأ داخلي في الخادم
        return response()->json(['message' => 'خطأ بالسيرفر يرجى المحاولة لاحقا'], 500);
    }
}








// update
public function update(StoreSaleRealestateRequest $request, $id)
{
    $realestate = SaleRealestate::find($id);

    if (!$realestate) {
        return response()->json(['status' => 'faild', 'message' => 'Realestate not found'], 404);
    }

    $validated = $request->validated();

    $imagePaths = $realestate->images;

    if ($request->has('images')) {
        foreach ($request->images as $base64Image) {
            $image = base64_decode($base64Image);
            $imageName = uniqid() . '.png';
            Storage::put('public/images/' . $imageName, $image);
            $imagePaths[] = 'storage/images/' . $imageName;
        }
    }

    $validated['images'] = $imagePaths;

    $realestate->update($validated);

    return response()->json(['status' => 'success', 'data' => $realestate], 200);
}




public function handleImages64(Request $request) {
    // استقبال صورة Base64


    // استقبال صورة Base64
    $base64Image = $request->input('image');

    // إزالة المعلومات الإضافية
    list($type, $base64Image) = explode(';', $base64Image);
    list(, $base64Image) = explode(',', $base64Image);

    // تحويل Base64 إلى صورة
    $imageData = base64_decode($base64Image);

    // تحديد امتداد الملف
    $extension = Str::after($type, '/');
    $fileName = Str::random(10) . '.' . $extension;
    // تخزين الصورة في نظام الملفات
    $path = 'images/' . $fileName;
    Storage::put($path, $imageData);

    
    // إرجاع رابط الوصول للصورة
    return response()->json(['url' => Storage::url($path)], 201);
 }

}