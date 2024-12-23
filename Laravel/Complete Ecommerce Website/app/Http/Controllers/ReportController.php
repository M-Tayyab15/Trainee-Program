<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Cart; // Import the Cart model
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $categoryQuery = $request->input('category', '');
        $monthQuery = $request->input('month', Carbon::now()->month);
        $yearQuery = $request->input('year', Carbon::now()->year);

        
        $categories = Category::all();
        $monthlyReport = Cart::generateMonthlyReport($yearQuery);
        return view('admin.reports', compact('categories', 'monthlyReport', 'categoryQuery', 'monthQuery', 'yearQuery'));
    }


    public function generatePdf(Request $request)
    {
    
        $yearQuery = $request->input('year', now()->year);

       
        $allCategories = DB::table('tbl_category')
            ->select('name AS category_name')
            ->get();

   
        $reportData = DB::select("
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
                c.status = 3  AND 
                YEAR(FROM_UNIXTIME(c.updated_on)) = :year                                           
            GROUP BY 
                cat.name          
            ORDER BY 
                cat.name;
        ", ['year' => $yearQuery]);

 
        $structuredData = [];
        foreach ($reportData as $row) {
            $structuredData[$row->category_name] = [
                'January' => $row->January,
                'February' => $row->February,
                'March' => $row->March,
                'April' => $row->April,
                'May' => $row->May,
                'June' => $row->June,
                'July' => $row->July,
                'August' => $row->August,
                'September' => $row->September,
                'October' => $row->October,
                'November' => $row->November,
                'December' => $row->December,
            ];
        }

    
        $categories = $allCategories->pluck('category_name')->toArray();

        // Step 5: Render the view for PDF content
        $html = view('admin.pdf_report', compact('structuredData', 'categories', 'yearQuery'))->render();

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);

      
        $mpdf->Output("report.pdf", "I");
    }
}
