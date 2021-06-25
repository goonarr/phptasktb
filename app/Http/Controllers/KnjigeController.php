<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Knjiga;
use Exception;
use Validator;
use Carbon\Carbon;

class KnjigeController extends Controller
{

  private $search_terms;

  /**
   * Create a new KnjigeController instance.
   * middleware protecting routes
   * @return void
   */
  public function __construct()
  {
    //basic auth middleware declared in web routes

    $this->search_terms = [];
  }

  /**
   * Display Knjige && search results (via GET query)
   * @param Request (inputs as GET: (naziv, autor, izdavac, godina_izdanja, last, before))
   * @return View
   */
  public function index (Request $request){

    if ( ($knjige = $this->searchKnjige($request)) === false ) return redirect()->route('index.knjiga')->withErrors(['Search request malformed!']);


    return view('knjige', ['knjige' => $knjige, 'search_terms' => $this->search_terms]);

  }

  /**
   * SEARCH KNJIGE TABLE from database
   * @param Request (naziv, autor, izdavac, godina_izdanja, last, before)
   * @return Collection (of Kniga) || false (bool)
   *
   */
  private function searchKnjige(Request $request){
    $validate = Validator::make($request->all(), [
      'naziv' => 'nullable|string',
      'autor' => 'nullable|string',
      'izdavac' => 'nullable|string',
      'godina_izdanja' => 'nullable|integer',
      'last' => 'nullable|integer',
      'before' => 'nullable|integer',
    ]);

    $knjige = Knjiga::all(); //OVO NIKAD NE BIH RADIO U PRODUKCIJI!!! Inicijalni search, ili pagination na empty query ...->take(25) eg.

    try{
      if ( !$validate->fails() ){
        if ( $request->input('naziv') ) {
          $knjige = $knjige->intersect(Knjiga::where('naziv', trim($request->input('naziv')))->get());
          $this->search_terms['naziv'] = trim($request->input('naziv'));
        }

        if ( $request->input('autor') ) {
          $knjige = $knjige->intersect(Knjiga::where('autor', trim($request->input('autor')))->get());
          $this->search_terms['autor'] = trim($request->input('autor'));
        }

        if ( $request->input('izdavac') ) {
          $knjige = $knjige->intersect(Knjiga::where('izdavac', trim($request->input('izdavac')))->get());
          $this->search_terms['izdavac'] = trim($request->input('izdavac'));
        }

        if ( $request->input('godina_izdanja') ) {
          $year_start_ts = Carbon::createFromFormat('!Y',trim($request->input('godina_izdanja')))->timestamp;
          $year_end_ts = Carbon::createFromFormat('!Y',trim($request->input('godina_izdanja')+1))->timestamp;
          $knjige = $knjige->intersect(Knjiga::where('godina_izdanja', '>', $year_start_ts)->where('godina_izdanja', '<', $year_end_ts)->get());
          $this->search_terms['Godina izdanja'] = trim($request->input('godina_izdanja'));
        }

        if ( $request->input('last') ) {
          $year_start_ts = Carbon::now()->subYears((int)$request->input('last'))->timestamp;
          $knjige = $knjige->intersect(Knjiga::where('godina_izdanja', '>', $year_start_ts)->get());
          $this->search_terms['Zadnjih'] = trim($request->input('last').' godina');
        }

        if ( $request->input('before') ) {
          $year_start_ts = Carbon::now()->subYears((int)$request->input('before'))->timestamp;
          $knjige = $knjige->intersect(Knjiga::where('godina_izdanja', '<', $year_start_ts)->get());
          $this->search_terms['Starije od zadnjih'] = trim($request->input('before').' godina');
        }
      }
    } catch (Exception $e){
      return false;
    }

    return ( $knjige )?$knjige:[];
  }

  /**
   * API ENDPOINT equivalent to...
   * @function index 
   * @param Request (as body POST: naziv, autor, izdavac, godina_izdanja, last, before)
   * @return JSON
   */
  public function apiSearchKnjige(Request $request){

    if ( ($knjige = $this->searchKnjige($request)) === false ) return response()->json([
      'status' => 'error',
      'message' => 'bad request'
    ], 400);

    return response()->json([
      'status' => 'ok',
      'message' => 'success',
      'queryResult' => $knjige
    ]);
  }
}
