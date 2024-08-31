<?php

namespace App\Http\Controllers\Admin\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class ProfileController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;

    public function index()
    {
        $profile = App\Models\Profile\Profile::where('statusenabled', $this->statusEnabled())
        ->where('kdprofile', $this->kdprofile())
        ->get();

        if ($profile->isEmpty()) {
            return $this->failedResponse('Profile not found');
        } else {
            return $this->successResponse('Profile retrieved successfully', $profile);
        }
    }

    public function show($id)
    {
        $profile = App\Models\Profile\Profile::find($id);

        if (!$profile) {
            return $this->failedResponse('Profile not found');
        } else {
            return $this->successResponse('Profile retrieved successfully', $profile);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                // Add validation rules for other fields if needed
            ]);

            $profile = App\Models\Profile\Profile::create([
                'kdprofile' => '1',
                'statusenabled' => '1',
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'logo' => $request->logo,
                'website' => $request->website,
                'slogan' => $request->slogan,
                'description' => $request->description,
                'vision' => $request->vision,
                'mission' => $request->mission,
                'motto' => $request->motto,
                'fax' => $request->fax,
                'npwp' => $request->npwp,
                'npsn' => $request->npsn
            ]);

            $log = $this->logActivity('Create Profile ', $request, json_encode($profile));
            return $this->successCreatedResponse('Profile created successfully', $profile);
        } catch (\Exception $e) {
            return $this->failedResponse('Profile failed to create');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
                // Add validation rules for other fields if needed
            ]);

            $profile = App\Models\Profile\Profile::find($id);

            if (!$profile) {
                return $this->failedResponse('Profile not found');
            }

            $profile->update([
                'kdprofile' => '1',
                'statusenabled' => $request->statusenabled,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'logo' => $request->logo,
                'website' => $request->website,
                'slogan' => $request->slogan,
                'description' => $request->description,
                'vision' => $request->vision,
                'mission' => $request->mission,
                'motto' => $request->motto,
                'fax' => $request->fax,
                'npwp' => $request->npwp,
                'npsn' => $request->npsn
            ]);

            $log = $this->logActivity('Update Profile ', $request, json_encode($profile));
            return $this->successResponse('Profile updated successfully', $profile);
        } catch (\Exception $e) {
            return $this->failedResponse('Profile failed to update');
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $profile = App\Models\Profile\Profile::find($id);

            if (!$profile) {
                return $this->failedResponse('Profile not found');
            }

            $profile->delete();

            $log = $this->logActivity('Delete Profile ', $request, json_encode($profile));
            return $this->successResponse('Profile deleted successfully');
        } catch (\Exception $e) {
            return $this->failedResponse('Profile failed to delete');
        }
    }


    public function uploadLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $profile = App\Models\Profile\Profile::find($request->id);

        if (!$profile) {
            return $this->failedResponse('Profile not found');
        }

        $imageName = time() . '.' . $request->logo->extension();

        $request->logo->move(public_path('images'), $imageName);

        $profile->update([
            'logo' => $imageName
        ]);

        $log = $this->logActivity('Upload Logo Profile ', $request, json_encode($profile));
        return $this->successResponse('Logo uploaded successfully', $profile);
    }

    public function removeLogo(Request $request)
    {
        $profile = App\Models\Profile\Profile::find($request->id);

        if (!$profile) {
            return $this->failedResponse('Profile not found');
        }

        $profile->update([
            'logo' => null
        ]);

        $log = $this->logActivity('Remove Logo Profile ', $request, json_encode($profile));
        return $this->successResponse('Logo removed successfully', $profile);
    }
}
