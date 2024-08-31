<?php

namespace App\Http\Controllers\Auth;

use App;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;


class AuthController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;
    public function login(Request $request)
    {
        try {
            $credentials = $request->only('username', 'password');
            $timezone = $request->input('timezone');
            $locale = $request->input('locale');

            // Check user credentials
            if (!auth()->attempt($credentials)) {
                $user = App\Models\User::where('username', $credentials['username'])->first();
                if ($user) {
                    $user->increment('failed_login_count', 1, [
                        'last_failed_login_at' => now(),
                        'last_failed_login_ip' => $request->ip(),
                    ]);
                }

                return response()->json([
                    'status' => 'error',
                    'code' => '401',
                    'message' => 'Invalid Credentials',
                ], 401);
            }

            $user = $request->user();
            $roles = $user->roles()->pluck('name')->toArray();

            // Cache allowed roles to reduce database queries
            $allowedRoles = Cache::remember('allowed_roles', 60, function () {
                return App\Models\Roles::pluck('name')->toArray();
            });

            $invalidRoles = array_intersect($roles, $allowedRoles);

            // Check for invalid roles
            if (count($invalidRoles) === 0) {
                return response()->json([
                    'status' => 'error',
                    'code' => '401',
                    'message' => 'Unauthorized. User does not have a valid role.',
                ], 401);
            }

            // Check if the user is verified
            if ($user->is_verified == 0) {
                return response()->json([
                    'status' => 'error',
                    'code' => '401',
                    'message' => 'Unauthorized. User is not verified.',
                ], 401);
            }

            // Generate token
            $token = $user->createToken('authToken', $roles)->plainTextToken;

            // Update user login information
            $user->update([
                'last_login_at' => now(),
                'last_login_ip' => $request->ip(),
                'failed_login_count' => 0,
                'is_active' => 1,
                'ip_address' => $request->ip(),
                'timezone' => $timezone,
                'locale' => $locale,
            ]);

            // Return successful login response
            return response()->json([
                'status' => 'success',
                'meta' => [
                    'token' => $token,
                ],
                'data' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'roles_id' => $user->roles_id,
                    'is_verified' => $user->is_verified,
                    'verification_token' => $user->verification_token,
                    'reset_token' => $user->reset_token,
                    'reset_token_expires_at' => $user->reset_token_expires_at,
                    'last_login_at' => $user->last_login_at,
                    'last_failed_login_at' => $user->last_failed_login_at,
                    'failed_login_count' => $user->failed_login_count,
                    'last_failed_login_ip' => $user->last_failed_login_ip,
                    'last_login_ip' => $user->last_login_ip,
                    'timezone' => $user->timezone,
                    'locale' => $user->locale,
                    'ip_address' => $user->ip_address,
                    'roles' => $roles,
                ],
            ], 201);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Internal Server Error',
            ], 500);
        }
    }



    public function logout(Request $request)
    {
        try {
            $user = $request->user();

            // Get user roles
            $roles = $user->roles()->pluck('name')->toArray();

            // Revoke user's token
            $request->user()->tokens()->where('id', $request->user()->currentAccessToken()->id)->delete();

            // Update user logout details
            $user->update([
                'is_active' => 0, // Set user as inactive on logout
                'ip_address' => $request->ip(),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'User logged out successfully.',
                'data' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'roles_id' => $user->roles_id,
                    'is_verified' => $user->is_verified,
                    'verification_token' => $user->verification_token,
                    'reset_token' => $user->reset_token,
                    'reset_token_expires_at' => $user->reset_token_expires_at,
                    'last_login_at' => $user->last_login_at,
                    'last_failed_login_at' => $user->last_failed_login_at,
                    'failed_login_count' => $user->failed_login_count,
                    'last_failed_login_ip' => $user->last_failed_login_ip,
                    'last_login_ip' => $user->last_login_ip,
                    'timezone' => $user->timezone,
                    'locale' => $user->locale,
                    'ip_address' => $user->ip_address,
                ],
            ], 200);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error during logout.',
            ], 500);
        }
    }

    public function logoutLockScreen(Request $request)
    {
        try {
            $user = $request->user();

            // Get user roles
            $roles = $user->roles()->pluck('name')->toArray();

            // Revoke user's token
            $request->user()->tokens()->where('id', $request->user()->currentAccessToken()->id)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'User logged out successfully.',
                'data' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'roles' => $roles,
                ],
            ], 200);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error during logout.',
            ], 500);
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $request->validate([
                'old_password' => 'required',
                'new_password' => 'required|min:8|confirmed',
            ]);

            $user = $request->user();

            if (Hash::check($request->old_password, $user->password)) {
                $user->update([
                    'password' => bcrypt($request->new_password),
                ]);
            return $this->successResponse('Password changed successfully', $user);
            } else {
                return $this->failedResponse('Old password is incorrect');
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            return $this->failedResponse('Error: ' . $ex->getMessage());
        }
    }
}
