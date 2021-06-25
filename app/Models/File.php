<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Storage;

class File extends Model
{
    use HasFactory;

    /**
     * MySql table Files
     */
     protected $primaryKey = 'id';
     protected $table = 'files';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'path',
        'parsed',
        'file_info'
    ];

    protected $casts = [
  	   'file_info' => 'array'
    ];

    /**
     * Where files will be stored
     */
    protected static $storage_path = "public/upload/";

    /**
     * Where files will be stored (URI CONTEXT)
     */
    protected static $url_path = "upload/";

    /**
     * User who uploaded
     * @return User model
     */
    public function user(){
      return $this->belongsTo( 'App\Models\User' );
    }

    /**
     * Create full file path for store
     */
    public static function storagePath(){
      return storage_path("app/".self::$storage_path);
    }

    /**
     * Return URL path of file
     * @return string (url formated)
     */
    public function url(){
      return env('APP_URL').Storage::url(self::$url_path.$this->file_info['systemName']);
    }
}
