<?php

namespace App\Http\Controllers;

use App\Models\Lga;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LgaController extends Controller
{
   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $lgas = Lga::all();
    $response['status'] = "success";
    $response['lgas'] = $lgas;
    return response()->json($response, Response::HTTP_OK);
  }
}
