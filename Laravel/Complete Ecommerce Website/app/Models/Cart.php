<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cart extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'tbl_cart';

    // Disable timestamps since your table uses custom columns for created_at and updated_at
    public $timestamps = false;

    // Specify the primary key of the table (if not the default 'id')
    protected $primaryKey = 'cart_id';

    // Define the fillable columns (columns that can be mass assigned)
    protected $fillable = [
        'user_id',
        'payment_mode',
        'status',
        'total_amount',
        'ip_address',
        'created_on',
        'updated_on',
        'trasaction_details',
    ];

    
    public function cartProducts()
    {
        return $this->hasMany(CartProduct::class, 'cart_id', 'cart_id');
    }

    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function getStatus()
    {
        return $this->status; 
    }

    public static function generateMonthlyReport($yearQuery)
    {
       
        $query = "
            SELECT 
                cat.name AS category_name,  
                SUM(CASE WHEN DATE_FORMAT(FROM_UNIXTIME(c.updated_on), '%m') = '01' THEN 1 ELSE 0 END) AS January,
                SUM(CASE WHEN DATE_FORMAT(FROM_UNIXTIME(c.updated_on), '%m') = '02' THEN 1 ELSE 0 END) AS February,
                SUM(CASE WHEN DATE_FORMAT(FROM_UNIXTIME(c.updated_on), '%m') = '03' THEN 1 ELSE 0 END) AS March,
                SUM(CASE WHEN DATE_FORMAT(FROM_UNIXTIME(c.updated_on), '%m') = '04' THEN 1 ELSE 0 END) AS April,
                SUM(CASE WHEN DATE_FORMAT(FROM_UNIXTIME(c.updated_on), '%m') = '05' THEN 1 ELSE 0 END) AS May,
                SUM(CASE WHEN DATE_FORMAT(FROM_UNIXTIME(c.updated_on), '%m') = '06' THEN 1 ELSE 0 END) AS June,
                SUM(CASE WHEN DATE_FORMAT(FROM_UNIXTIME(c.updated_on), '%m') = '07' THEN 1 ELSE 0 END) AS July,
                SUM(CASE WHEN DATE_FORMAT(FROM_UNIXTIME(c.updated_on), '%m') = '08' THEN 1 ELSE 0 END) AS August,
                SUM(CASE WHEN DATE_FORMAT(FROM_UNIXTIME(c.updated_on), '%m') = '09' THEN 1 ELSE 0 END) AS September,
                SUM(CASE WHEN DATE_FORMAT(FROM_UNIXTIME(c.updated_on), '%m') = '10' THEN 1 ELSE 0 END) AS October,
                SUM(CASE WHEN DATE_FORMAT(FROM_UNIXTIME(c.updated_on), '%m') = '11' THEN 1 ELSE 0 END) AS November,
                SUM(CASE WHEN DATE_FORMAT(FROM_UNIXTIME(c.updated_on), '%m') = '12' THEN 1 ELSE 0 END) AS December
            FROM 
                tbl_cart_products ci
            INNER JOIN 
                tbl_cart c ON ci.cart_id = c.cart_id
            INNER JOIN 
                tbl_product p ON ci.pro_id = p.pro_id
            INNER JOIN 
                tbl_category cat ON p.cat_id = cat.cat_id
            WHERE 
                c.status = 3  
                AND YEAR(FROM_UNIXTIME(c.updated_on)) = :year
            GROUP BY 
                cat.name
            ORDER BY 
                cat.name;
        ";

        $results = DB::select($query, ['year' => $yearQuery]);

        $monthlyReport = [];
        foreach ($results as $result) {
            $categoryName = $result->category_name;
            $monthlyReport[$categoryName] = [
                1 => $result->January,
                2 => $result->February,
                3 => $result->March,
                4 => $result->April,
                5 => $result->May,
                6 => $result->June,
                7 => $result->July,
                8 => $result->August,
                9 => $result->September,
                10 => $result->October,
                11 => $result->November,
                12 => $result->December
            ];
        }

        return $monthlyReport;
    }
}
