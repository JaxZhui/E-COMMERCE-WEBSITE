<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AdminAuthController extends Controller
{
    /**
     * Get all admins (protected route - sensitive data)
     */
    public function index()
    {
        try {
            $admins = Admin::select('id', 'username', 'last_login_at', 'created_at')
                          ->whereNotNull('last_login_at')
                          ->orderBy('last_login_at', 'desc')
                          ->get();
                                
            return response()->json([
                'success' => true,
                'message' => 'Logged in admins retrieved successfully',
                'data' => [
                    'admins' => $admins,
                    'total' => $admins->count()
                ]
            ], 200);
                    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve admins',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Admin login
     */
   public function login(Request $request)
{
    try {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $credentials = $request->only('username', 'password');

        // Specify the admin guard explicitly
        if (!$token = auth('admin')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        $admin = auth('admin')->user();
        $admin->last_login_at = now();
        $admin->save();

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'token' => $token,
                'token_type' => 'bearer',
                'admin' => [
                    'id' => $admin->id,
                    'username' => $admin->username,
                    'last_login_at' => $admin->last_login_at
                ]
            ]
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Login failed',
            'error' => $e->getMessage()
        ], 500);
    }
}

    /**
     * Admin logout
     */
    public function logout()
    {
        try {
            $token = JWTAuth::getToken();
            
            if ($token) {
                JWTAuth::invalidate($token);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully'
            ], 200);
                    
        } catch (TokenExpiredException $e) {
            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully (token was expired)'
            ], 200);
            
        } catch (TokenInvalidException $e) {
            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully (token was invalid)'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Logout failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get current authenticated admin profile
     */
    public function profile()
    {
        try {
            $admin = Auth::guard('admin')->user();
            
            return response()->json([
                'success' => true,
                'message' => 'Profile retrieved successfully',
                'data' => [
                    'admin' => [
                        'id' => $admin->id,
                        'username' => $admin->username,
                        'last_login_at' => $admin->last_login_at,
                        'created_at' => $admin->created_at
                    ]
                ]
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
