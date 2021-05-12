<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BankController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function listBank()
  {
    $banks = Bank::select([
      'code',
      'name',
    ])->get();
    $response['status'] = "success";
    $response['banks'] = $banks;
    return response()->json($response, Response::HTTP_OK);
  }
}
