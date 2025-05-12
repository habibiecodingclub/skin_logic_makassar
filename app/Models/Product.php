<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    protected $fillable= [
        "Product_Name",
        "Product_Category",
        "Product_Price",
        "SKU-Number",
        "Description"
    ];
        // Mutator untuk SKU-Number
    // public function setSkuNumberAttribute($value)
    // {
    //     // Tambahkan prefix "Rp." jika belum ada
    //     if (!str_starts_with($value, 'Rp.')) {
    //         $value = 'Rp.' . $value;
    //     }
    //     $this->attributes['Product_Price'] = $value;
    // }

    // public function getProductPriceAttribute($value)
    // {
    //     return 'Rp. ' . number_format($value, 2, ',', '.');
    // }

    /**
     * Get the possible enum values for the Product_Category column.
     *
     * @return array
     */
    public static function getProductCategoryOptions()
    {
        $tableName = (new self)->getTable(); // Ambil nama tabel dari model
        $columnName = 'Product_Category'; // Nama kolom enum

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
