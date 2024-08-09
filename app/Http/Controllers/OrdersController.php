<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\OrderRequest;
use App\Models\Order as OrderModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User as UserModel;
use Hamcrest\Core\HasToString;


class OrdersController extends Controller {

    protected $orderService;

    public function __construct(OrderModel $orderService){
        $this->orderService = $orderService;
    }

    /**
 * Handle the registration request.
 *
 * @param OrderRequest $request
 * @return JsonResponse
 */

     // تابع لإنشاء طلب بيع أو إيجار
     public function storeOrder(OrderRequest $request) : JsonResponse {
        try {
            $validatedData = $request->validated() ;
           
            /** @var \App\Models\UserModel $user **/
            $user = Auth::user();

            if (!$user) {
                return response()->json(['message' => 'لا يمكنك القيام بهذه العملية'], 401);
            }
        
            $userid = $user->id;
        
            $this->orderService->createOrder($validatedData, $userid);
          
            return response()->json(
               ['state' => 'success',], 201);
            } catch (\Exception $e) {
                Log::error('Error creating order: '.$e->getMessage());
                return response()->json(
                    ['message' => 'فشل في اضافة الطلب'],500);
            }
        
     }
 
     // تابع لجلب جميع طلبات البيع
    public function getSaleOrders(): JsonResponse {
        try {
            $saleOrders = OrderModel::where('type','sale')->get();

            return response()->json([
                'message' => 'success',
                 'date' => $saleOrders],201);

        } catch (\Exception $e) {
            // تسجيل الخطأ
            Log::error('Error fetching sale orders: ' . $e->getMessage());

            // إرجاع استجابة بخطأ داخلي في الخادم
            return response()->json(['message' => 'خطأ بالسيرفر يرجى المحاولة لاحقا'], 500);
        }
    }
 
    // تابع لجلب جميع طلبات الإيجار
    public function getRentOrders(): JsonResponse
    {
        try {
            $rentOrders = OrderModel::where('type', 'rent')->get();
            return response()->json([
                'message' => 'success',
                 'date' => $rentOrders],201);
        } catch (\Exception $e) {
            // تسجيل الخطأ
            Log::error('Error fetching rent orders: ' . $e->getMessage());

            // إرجاع استجابة بخطأ داخلي في الخادم
            return response()->json(['message' => 'خطأ بالسيرفر يرجى المحاولة لاحقا'], 500);
        }
    }


    /**
 * Remove the specified resource from storage.
 *
 * @return JsonResponse
 */
// * @param int $id
public function destroy(Request $request): JsonResponse
{
    try {
        // جلب المستخدم الحالي
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'لا يمكنك القيام بهذه العملية'], 401);
        }

        // البحث عن الطلب بواسطة المعرف
        $order = $this->orderService->findOrderById($request->id);

        if (!$order) {
            return response()->json(['message' => 'الطلب ليس موجود'], 404);
        }

        // التحقق مما إذا كان المستخدم هو صاحب الطلب ة
        if ($user->id !== $order->user_id ) {
            return response()->json(['message' => 'يمكن لمالك الطلب فقط حذفه'], 403);
        }

        // حذف الطلب
        $this->orderService->deleteOrder($request->id);

        return response()->json(['state' => 'success','message' => 'تم حذف الطلب'], 201);
    } catch (\Exception $e) {
        // تسجيل الخطأ
        Log::error('Error deleting order: ' . $e->getMessage());

        // إرجاع استجابة بخطأ داخلي في الخادم
        return response()->json(['message' => 'خطأ بالسيرفر يرجى المحاولة لاحقا'], 500);
    }
}
/**
     * Display the specified resource.
     */
    public function show(Request $request): JsonResponse {
        
        try {
            // جلب المستخدم الحالي
            $user = Auth::user();
    
            if (!$user) {
                return response()->json(['message' => 'لا يمكنك القيام بهذه العملية'], 401);
            }
            $id = $user->id;
            $myOrders = OrderModel::where('user_id', $id)->get();
            return response()->json(
                [
                    'message' => 'success',
                     'date' => $myOrders]
                ,201);

        } catch (\Exception $e) {
            // تسجيل الخطأ
            Log::error('Error deleting order: ' . $e->getMessage());
    
            // إرجاع استجابة بخطأ داخلي في الخادم
            return response()->json(['message' => 'خطأ بالسيرفر يرجى المحاولة لاحقا'], 500);
        }


    }







    /**
     * Display a listing of the resource.
     */
    public function addRentOrder(Request $request)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }





}
