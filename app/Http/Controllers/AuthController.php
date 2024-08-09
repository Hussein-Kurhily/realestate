<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User as ModelsUser;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {


    protected $userService;

    public function __construct(ModelsUser $userService){
        $this->userService = $userService;
    }

/**
 * Handle the registration request.
 *
 * @param RegisterRequest $request
 * @return JsonResponse
 */


 public function register(RegisterRequest $request): JsonResponse {
    try{
        // Validate the request data
        $validatedData = $request->validated();

        // Create the user using the service
        $user = $this->userService->createUser($validatedData);

    return response()->json(['state' => 'success','message' => 'تم انشاء الحساب بنجاح',], 201);

    } catch (\Exception $e) {
        // Log the exception message
        Log::error('Registration failed: ' . $e->getMessage());

        return response()->json([
            'message' => 'خطأ بالسيرفر يرجى المحاولة لاحقا'
        ], 500);
    }
    
 }

    public function login(LoginRequest $request): JsonResponse {
        try {
            // Retrieve the authenticated user
            $isUser = ModelsUser::where('email', $request->email)->first();

        // Check if user exists
        if (!$isUser) {
            return response()->json([
                'message' => 'الحساب غير موجود يرجى انشاء حساب'
            ], 404);  // 404 Not Found is more appropriate here
        }

        // Check if the password is correct
        if (!Hash::check($request->password, $isUser->password)) {
            return response()->json([
                'message' => 'كلمة المرور غير صحيحة'
            ], 401);  // 401 Unauthorized
        }
            
        if(Auth::attempt($request->only('email', 'password'))) {
             /** @var \App\Models\MyUserModel $user **/
            $user = Auth::user();

            // Generate token for the user
            $token = $user->createToken('auth_token')->plainTextToken;
    
            return response()->json(['state' => 'success','access_token'=> $token ], 201);
}
        } catch (\Exception $e) {
            // Log and return error if authentication fails
            Log::error('Login failed: ' . $e->getMessage());
            return response()->json(['message' => 'خطأ بالسيرفر يرجى المحاولة لاحقا'], 500);
        }
    }

    
    public function logout(Request $request) {
        try {
            // Retrieve the authenticated user
            $isUser = ModelsUser::where('email', $request->email)->first();

        // Check if user exists
        if (!$isUser) {
            return response()->json([
                'message' => 'الحساب غير موجود يرجى انشاء حساب'
            ], 404);  // 404 Not Found is more appropriate here
        }

        // Check if the password is correct
        if (!Hash::check($request->password, $isUser->password)) {
            return response()->json([
                'message' => 'كلمة المرور غير صحيحة'
            ], 401);  // 401 Unauthorized
        }
            
        if(Auth::attempt($request->only('email', 'password'))) {
            
            
            $request->user()->currentAccessToken()->delete();
            return response(['state' => 'success','message' => 'تم تسجيل الخروج'],201);
       
           
}
        } catch (\Exception $e) {
            return response(['message' => 'خطأ بالسيرفر يرجى المحاولة لاحقا'], 500);
        }
    }
    

    public function removeAccount(LoginRequest $request) : JsonResponse {
        try {
           

            // delete token for the user

            $request->user()->currentAccessToken()->delete();
            $request->user()->delete() ;

            return response()->json(['state' => 'success',
                'message'=>'تم حذف الحساب'],201);
            
        } catch (\Exception $e) {
            return response()->json(['message' => 'خطأ بالسيرفر يرجى المحاولة لاحقا'], 500);
        }  
    }
}




/* 

 public function verify(Request $request)
{
    
    $user = ModelsUser::where('email', $request->email)->first();

    if (!$user) {
        return response()->json(['message' => 'User not found.'], 404);
    }

    $verificationCode = VerificationCode::where('user_id', $user->id)
                                        ->where('code', $request->code)
                                        ->where('expires_at', '>', now())
                                        ->first();

    if (!$verificationCode) {
        return response()->json(['message' => 'Invalid or expired code.'], 400);
    }

    // Verification successful
    $user->email_verified_at = now();
    $user->save();

    return response()->json(['message' => 'Email verified successfully.'], 200);
}



 
 /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     
    public function user(): JsonResponse
    {
        $user = Auth::user();

        return response()->json($user);
    }





*/