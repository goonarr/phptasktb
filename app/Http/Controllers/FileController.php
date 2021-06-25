<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\File;
use App\Models\Knjiga;
use Exception;
use Validator;
use Illuminate\Support\Facades\Hash;
use Storage;
use Illuminate\Support\Str;

class FileController extends Controller
{
  /**
   * Acceptable file types
   * @var Array
   */
  protected $acceptable_types = ['csv', 'xml', 'xlsx'];

  /**
   * Create a new FileController instance.
   * middleware protecting routes
   * @return void
   */
  public function __construct()
  {

    $this->middleware('can:create,App\Models\File',  ['only' => ['uploadForm', 'upload', 'listFiles', 'parseFile']]);
  }

  /**
   * HTML output for file upload
   * @param Request instance
   * @return View instance
   */
  public function uploadForm(Request $request){
    return view('fupload');
  }

  /**
   * File upoad processing POST
   * @param Request instance
   * @return redirect
   */
  public function upload( Request $request ){

    $validate = Validator::make($request->all(), [
      'file_name' => 'required|file',
      'parseOptin' => 'required'
    ]);

    if ( $validate->fails() ){
      return redirect()->back()->withErrors(['No file selected.']);
    }

    try{
      $file = $request->file('file_name');

      if ( ! in_array( strtolower( $file->getClientOriginalExtension() ), $this->acceptable_types )){
        return redirect()->back()->withErrors(['You are joking, right??']);
      }

      $fileName = $file->getClientOriginalName();
      $fileExtension = strtolower( $file->getClientOriginalExtension() );
      $fileSlugName = Str::slug(Hash::make($file->getSize().$file->getClientOriginalName().time()), '').'.'.$fileExtension;
      $fileSize = $file->getSize();
      $fileMimeType = $file->getMimeType();
      $fileOriginalUploadPath = $file->getRealPath();

      $file->move(File::storagePath(), $fileSlugName); //URL: http://192.168.0.220/phptask/storage/upload/2y10bvokdb5hanvnuzc0nzoznaq3gvoc4jp37cjzj4iazikv8581w

      $file_obj = File::create([
        'user_id' => auth()->user()->id,
        'name' => $fileName,
        'path' => File::storagePath().$fileSlugName,
        'file_info' => [
          'extension' => $fileExtension,
          'size' => $fileSize,
          'systemName' => $fileSlugName,
          'mimeType' => $fileMimeType,
          'originalUploadPath' => $fileOriginalUploadPath
        ],
      ]);

      if ( $request->input('parseOptin') == 'upload-parse' ){
        if ( ($new_entries = Knjiga::parseFile($file_obj)) !== null ){
          $file_obj->parsed = true;
          $file_obj->save();
        }
        else{
          return redirect()->back()->withErrors(['Error occurred parsing file data!', 'File data corrupted!' ]);
        }
      }

    } catch( Exception $e ){
      return redirect()->back()->withErrors(['Error occured please try again!', $e->getMessage() ]);
    }

    if ( $file_obj ){
      $s_msg = 'File upload successfully';
      if ($request->input('parseOptin') == 'upload-parse') $s_msg = "File upload and parsed successfully with $new_entries inserts!";
      return redirect()->back()->withSuccess($s_msg);
    }
  }

  /**
   * HTML list files uploaded
   * @param Request instance
   * @return View instance
   */
  public function listFiles(Request $request){

    $files = File::all();
    return view('listfiles', ['files'=>$files]);
  }

  /**
   *Delete file from system and DB row
   * @param Request instance
   * @return Redirect
   */
  public function deleteFile(Request $request){

    $file = File::findOrFail($request->input('file_id'));
    $errors = [];

    try {
      unlink($file->path);
    } catch (Exception $e){
      $errors[] = "File deletion failed!";
    }

    try{
      $file->delete();
    } catch (Exception $e){
      $errors[] = "Database error";
    }

    if ( empty($errors) ){
      return redirect()->back()->withSuccess('File deleted, row deleted');
    } else {
      return redirect()->back()->withErrors($errors);
    }

  }

  /**
   * Parse file dataand store in DB as Knjiga
   * @param Request instance
   * @return Redirect
   */
  public function parseFile(Request $request){
    $file_obj = File::findOrFail($request->input('file_id'));

    if ( ($new_entries = Knjiga::parseFile($file_obj)) !== null ){
      $file_obj->parsed = true;
      $file_obj->save();
    }
    else{
      return redirect()->back()->withErrors(['Error occurred parsing file data!', 'File data corrupted!' ]);
    }

    return redirect()->back()->withSuccess("File upload and parsed successfully with $new_entries inserts!");

  }

}
