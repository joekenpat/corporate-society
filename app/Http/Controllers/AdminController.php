<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Deposit;
use App\Models\Investment;
use App\Models\User;
use App\Models\Withdrawal;
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

    if (!$admin || !Hash::check($request->password, $admin->password)) {
      $response['status'] = "error";
      $response['message'] = "login Failed!";
      $response['errors'] = [
        'email' => ['The provided credentials are incorrect.'],
      ];
      return response()->json($response, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    $response['status'] = "success";
    $response['message'] = "login successfull!";
    $response['token'] = $admin->createToken('admin')->plainTextToken;
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
      'pending_member_count'=>User::where('status','paid')->count(),
      'declined_member_count'=>User::where('status','declined')->count(),
      'approved_member_count'=>User::where('status','approved')->count(),

      'active_investment_count'=>Investment::where('completed_at',null)->count(),
      'completed_investment_count'=>Investment::where('completed_at','<>',null)->count(),

      'pending_withdrawal_count'=>Withdrawal::where('status','pending')->count(),
      'failed_withdrawal_count'=>Withdrawal::where('status','failed')->count(),
      'completed_withdrawal_count'=>Withdrawal::where('status','completed')->count(),

      'pending_deposit_count'=>Deposit::where('status','pending')->count(),
      'failed_deposit_count'=>Deposit::where('status','failed')->count(),
      'completed_deposit_count'=>Deposit::where('status','completed')->count(),
    ]
  }
}
