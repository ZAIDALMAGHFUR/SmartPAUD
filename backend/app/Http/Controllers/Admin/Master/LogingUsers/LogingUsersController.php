<?php

namespace App\Http\Controllers\Admin\Master\LogingUsers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;

class LogingUsersController extends Controller
{
    use  App\Traits\ApiResponse\ApiResponse;
    use App\Traits\LogingSystems\LogingSystems;
    public function index()
    {
        $logingUsers = App\Models\Master\LogingUsers::with(['users', 'users.employee'])->get();

        if ($logingUsers->isNotEmpty()) {
            return $this->successResponse('Loging Users loaded successfully', $logingUsers);
        } else {
            return $this->failedResponse('Loging Users loaded failed, data not found');
        }
    }
    public function GetUsingFilters( $tglawal, $tglakhir)
    {
        $logingUsers = App\Models\Master\LogingUsers::with(['users', 'users.employee'])
            ->whereBetween('tgllogin', [$tglawal, $tglakhir])
            ->get();

        if ($logingUsers->isNotEmpty()) {
            return $this->successResponse('Loging Users loaded successfully', $logingUsers);
        } else {
            return $this->failedResponse('Loging Users loaded failed, data not found');
        }
    }

    public function show($userId)
    {
        $logingUsers = App\Models\Master\LogingUsers::where('users_id', $userId)->with(['users', 'users.employee'])->first();

        if ($logingUsers->isNotEmpty()) {
            return $this->successResponse('Loging Users loaded successfully', $logingUsers);
        } else {
            return $this->failedResponse('Loging Users loaded failed, data not found');
        }
    }


    public function search(Request $request)
    {
        $logingUsers = App\Models\Master\LogingUsers::with('users')
            ->where('ipaddress', 'like', '%' . $request['ipaddress'] . '%')
            ->where('browser', 'like', '%' . $request['browser'] . '%')
            ->where('activity', 'like', '%' . $request['activity'] . '%')
            ->where('url', 'like', '%' . $request['url'] . '%')
            ->where('method', 'like', '%' . $request['method'] . '%')
            ->where('keterangan', 'like', '%' . $request['keterangan'] . '%')
            ->where('device', 'like', '%' . $request['device'] . '%')
            ->where('tgllogin', 'like', '%' . $request['tgllogin'] . '%')
            ->where('waktulogin', 'like', '%' . $request['waktulogin'] . '%')
            ->get();

        if ($logingUsers->isNotEmpty()) {
            return $this->successResponse('Loging Users loaded successfully', $logingUsers);
        } else {
            return $this->failedResponse('Loging Users loaded failed, data not found');
        }
    }

    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'users_id' => 'required',
            ]);

            $logingUsers = App\Models\Master\LogingUsers::create([
                'users_id' => $request->users_id,
                'ipaddress' => $request->ipaddress,
                'browser' => $request->browser,
                'activity' => $request->activity,
                'url' => $request->url,
                'method' => $request->method,
                'keterangan' => $request->keterangan,
                'device' => $request->device,
                'tgllogin' => $request->tgllogin,
                'waktulogin' => $request->waktulogin,
            ]);

            return $this->successCreatedResponse('Loging Users created successfully', $logingUsers);
        } catch (\Exception $e) {
            return $this->failedResponse('Loging Users failed to create');
        }
    }
}
