<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use League\Csv\Reader;
use App\Models\File;
use Exception;
use Carbon\Carbon;

interface ParseFile {
    public static function parseFile(File $file);
}

class Knjiga extends Model implements ParseFile
{
    use HasFactory;

    /**
     * MySql table Files
     */
     protected $primaryKey = 'id';
     protected $table = 'knjige';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'naziv',
        'autor',
        'izdavac',
        'godina_izdanja',
    ];

    /**
     * custom attributes (human readable time)
     * @var string (formated date)
     */
    protected $appends = ['godina_izdavanja_formated'];

    public function getGodinaIzdavanjaFormatedAttribute() {
      return $this->godinaIzdanja(); 
    }

    /**
     * Parse file and save in DB
     * @param File instance
     * @return int on success || null
     */
    public static function parseFile(File $file){

      switch( $file->file_info['extension']) {
        case 'csv':
          return self::parseCsvFile($file);
          break;

        case 'xml':
          return self::parseXmlFile($file);
          break;

        case 'xlsx':
          return self::parseXlsxFile($file);
          break;

        default:
          return false;
      }

      return false;

    }

    /**
    * Parse CSV file and save in DB
    * @param File instance
    * @return int on success || null
     */
    private static function parseCsvFile(File $file){
      $counter = 0;
      try{
        $csv = Reader::createFromPath($file->path, 'r');
        $csv->setHeaderOffset(0);

        $header = $csv->getHeader();
        $records = $csv->getRecords();

        foreach ($records as $record) {
          $exists = Knjiga::where([
                            ['naziv', '=', trim( $record['Naziv Knjige'] )],
                            ['autor', '=', trim( $record['Autor'] )],
                            ['izdavac', '=', trim( $record['Izdavac'] )],
                            ['godina_izdanja', '=', Carbon::createFromFormat('!d/m/Y',$record['Godina Izdanja'])->timestamp],
                            ])->first();

          if ( !$exists ){
            $a = Knjiga::create([
              'naziv' => trim( $record['Naziv Knjige'] ),
              'autor' => trim( $record['Autor'] ),
              'izdavac' => trim( $record['Izdavac'] ),
              'godina_izdanja' => Carbon::createFromFormat('!d/m/Y',$record['Godina Izdanja'])->timestamp,
            ]);
            if ( ! $a ) return null;
            $counter++;
          }

        }
      } catch (Exception $e) {
        return null;
      }

      return $counter;
    }

    /**
    * @STATUS: NOT READY!
    * Parse XML file and save in DB XLSX
    * @param File instance
    * @return int on success || null
     */
     private static function parseXmlFile(File $file){
        return null;
     }

     /**
     * @status: NOT READY!
     * Parse XLSX file and save in DB
     * @param File instance
     * @return int on success || null
      */
      private static function parseXlsxFile(File $file){
         return null;
      }

      /**
      * Human readable date
      * @param timestamp
      * @return string as formated date
      */
      public function godinaIzdanja(){
        return Carbon::createFromTimestamp($this->godina_izdanja)->format('d/m/Y');
      }

}
