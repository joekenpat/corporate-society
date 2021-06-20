<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Deposit;
use App\Models\Investment;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
  // public function __construct()
  // {
  //   $this->middleware(['auth:admin']);
  // }
  public function login_admin(Request $request)
  {
    $this->validate($request, [
      'email' => 'required|email|exists:admins,email',
      'password' => 'required',
    ]);

    $admin = Admin::where('email', $request->email)->firstOrFail();

    if ($admin->status == 'disabled') {
      $response['status'] = "error";
      $response['message'] = "login Failed!";
      $response['errors'] = [
        'email' => ['This Account has been Disabled!'],
      ];
      return response()->json($response, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    if (!$admin || !Hash::check($request->password, $admin->password)) {
      $response['status'] = "error";
      $response['message'] = "login Failed!";
      $response['errors'] = [
        'email' => ['The provided credentials are incorrect.'],
      ];
      return response()->json($response, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    $admin->tokens()->delete();

    $response['status'] = "success";
    $response['message'] = "login successfull!";
    $response['token'] = $admin->createToken(config('app.name') . '_PAK', ["{$admin->role}-admin"])->plainTextToken;
    return response()->json($response, Response::HTTP_OK);
  }


  public function profile()
  {
    $response['status'] = "success";
    $response['profile'] = auth()->user();
    return response()->json($response, Response::HTTP_OK);
  }

  public function adminDashboardStatus()
  {
    $stats = [
      'pending_member_count' => User::where('status', 'paid')->count(),
      'declined_member_count' => User::where('status', 'declined')->count(),
      'approved_member_count' => User::where('status', 'approved')->count(),

      'active_investment_count' => Investment::where('completed_at', null)->count(),
      'completed_investment_count' => Investment::where('completed_at', '<>', null)->count(),

      'pending_withdrawal_count' => Withdrawal::where('status', 'pending')->count(),
      'failed_withdrawal_count' => Withdrawal::where('status', 'failed')->count(),
      'completed_withdrawal_count' => Withdrawal::where('status', 'completed')->count(),

      'pending_deposit_count' => Deposit::where('status', 'pending')->count(),
      'failed_deposit_count' => Deposit::where('status', 'failed')->count(),
      'completed_deposit_count' => Deposit::where('status', 'completed')->count(),
    ];
    $response['status'] = "success";
    $response['table_stats'] = $stats;
    return response()->json($response, Response::HTTP_OK);
  }

  /**
   * Store the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function adminStoreNewAdminDetails(Request $request)
  {
    // return dd($request);
    $this->validate($request, [
      'first_name' => 'required|alpha|between:3,50',
      'last_name' => 'required|alpha|between:3,50',
      'email' => 'required|email|unique:admin',
      'password' => 'required|string|between:4,25',
      'password_confirmation' => 'required|same:password'
    ],);
    $updateableAttributes = [
      'first_name',
      'last_name',
      'email',
    ];
    $newUser = new Admin();
    foreach ($updateableAttributes as $key) {
      if ($request->has($key) && $request->{$key} != (null || "")) {
        $newUser->{$key} = $request->{$key};
      }
    }
    $newUser->password = Hash::make($request->password);
    $newUser->status = 'enabled';
    $newUser->save();
    event(new Registered($newUser));

    $response['status'] = "success";
    $response['message'] = "New Admin Created added Successfully!";
    return response()->json($response, Response::HTTP_OK);
  }

  public function update_password(Request $request)
  {
    $this->validate($request, [
      'current_password' => 'required|string',
      'new_password' => 'required|string',
      'new_password_confirmation' => 'required|string|same:new_password',
    ]);

    $admin = Admin::find(Auth('admin')->id());
    $credentials = [
      "email" => $admin->email,
      'password' => $request->input('current_password'),
    ];

    if (password_verify($request->input('current_password'), $admin->password)) {
      $admin->password = Hash::make($request->input('new_password'));
      $admin->update();
      $admin->tokens()->delete();
      $response['status'] = 'success';
      $response['message'] = 'Password Change Successfull';
      $response['token_type'] = "Bearer";
      $response['token'] = $admin->createToken(config('app.name') . '_PAK', ["admin:{$admin->role}"])->plainTextToken;
      return response()->json($response, Response::HTTP_OK);
    } else {
      $response['message'] = 'Invalid Credentials';
      $response['errors'] = ['current_password' => ['Current Password is not correct']];
      return response()->json($response, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
  }

  public function isSuperAdmin()
  {
    $response['status'] = "success";
    $response['is_super_admin'] = auth()->user()->tokenCan('super-admin');
    return response()->json($response, Response::HTTP_OK);
  }

  public function adminToggleSubAdminStatus($admin_id, $status)
  {
    $editAdmin = Admin::where('id', $admin_id)->firstOrFail();
    $editAdmin->status = $status;
    $response['status'] = "success";
    if ($editAdmin->isDirty()) {
      $editAdmin->update();
      $response['message'] = "Sub Admin: {$editAdmin->first_name} set as: {$status}!";
    } else {
      $response['message'] = "Sub Admin: {$editAdmin->first_name} set as: {$status}!";
    }
    return response()->json($response, Response::HTTP_OK);
  }

  public function adminListSubAdmin()
  {
    $sub_admins = Admin::where('id', '<>', auth()->user()->id)
      ->paginate(10);
    $response['status'] = "success";
    $response['admins'] = $sub_admins;
    return response()->json($response, Response::HTTP_OK);
  }
}
