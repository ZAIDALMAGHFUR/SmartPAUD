<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class UsersController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $users = App\Models\Users::with(['roles', 'employee'])
            ->where('statusenabled', $this->statusEnabled())
            ->where('kdprofile', $this->kdprofile())
            ->get();

        if ($users->isEmpty()) {
            return $this->failedResponse('Users not found');
        } else {
            return $this->successResponse('Users retrieved successfully', $users);
        }
    }

    public function show($id)
    {
        $user = App\Models\Users::with(['roles', 'employee'])->find($id);

        if (!$user) {
            return $this->failedResponse('User not found');
        } else {
            return $this->successResponse('User retrieved successfully', $user);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required',
                'password' => 'required',
                'roles_id' => 'required',
            ]);

            $user = App\Models\Users::create([
                'username' => $request->username,
                'password' => bcrypt($request->password),
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'roles_id' => $request->roles_id,
            ]);

            if ($user) {
                $log = $this->logActivity('Create User', $request, json_encode($user));
                return $this->successCreatedResponse('User created successfully', $user);
            } else {
                return $this->failedResponse('User failed to create');
            }
        } catch (\Exception $e) {
            return $this->failedResponse('Error: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'username' => 'required',
                'password' => 'required',
                'roles_id' => 'required',
            ]);

            $user = App\Models\Users::find($id);

            if ($user) {
                $user->update([
                    'username' => $request->username,
                    'password' => bcrypt($request->password),
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'roles_id' => $request->roles_id,
                ]);

                $log = $this->logActivity('Update User', $request, json_encode($user));
                return $this->successResponse('User updated successfully', $user);
            } else {
                return $this->failedResponse('User not found');
            }
        } catch (\Exception $e) {
            return $this->failedResponse('Error: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $user = App\Models\Users::find($id);

            if (!$user) {
                return $this->failedResponse('User not found');
            }

            $user->delete();
            $log = $this->logActivity('Delete User', $request, json_encode($user));
            return $this->successResponse('User deleted successfully', $user);
        } catch (\Exception $e) {
            return $this->failedResponse('Error: ' . $e->getMessage());
        }
    }
}
