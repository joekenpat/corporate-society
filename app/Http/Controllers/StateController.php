<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StateController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $states = State::all();
    $response['status'] = "success";
    $response['states'] = $states;
    return response()->json($response, Response::HTTP_OK);
  }
}
