<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Treatment extends Model
{
    //
    use HasFactory;
    protected $fillable= [
        "Treatment_Name",
        "Treatment_Category",
        "Treatment_Price",
        "SKU-Number",
        "Description"
    ];

    public function getProductPriceAttribute($value)
    {
        return "Rp. " . number_format($value, 2, ',', '.');
    }
      /**
     * Get the possible enum values for the Product_Category column.
     *
     * @return array
     */
    public static function getTreatmentCategoryOptions()
    {
        $tableName = (new self)->getTable(); // Ambil nama tabel dari model
        $columnName = 'Treatment_Category'; // Nama kolom enum

        // Query untuk mengambil tipe kolom enum
        $type = DB::selectOne("
            SHOW COLUMNS FROM $tableName
            WHERE Field = ?
        ", [$columnName])->Type;

        // Ekstrak opsi enum dari hasil query
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $enumValues = [];
        if ($matches) {
            $enumValues = str_getcsv($matches[1], ',', "'");
        }

        // Format opsi untuk Select::make
        $options = [];
        foreach ($enumValues as $value) {
            $options[$value] = $value; // Anda bisa menyesuaikan format tampilan jika diperlukan
        }

        return $options;
    }

}
