<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductReport;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\Media;
use Hash;
use DB;

class ProductReportController extends Controller
{
    public function index($produt_id)
    {
        $product_reports = ProductReport::where('product_id', $produt_id)->get();
        return view('web.admin.product_reports.index', compact('product_reports'));
    }

    public function destroy($id)
    {
        $reports_product=ProductReport::find($id);
        $reports_product->delete();

        return back()->with('status', 'deleted successfully');
    }


    public function delete_all(Request $request)
    {
        $delete_all_id = explode(",", $request->delete_all_id);
        ProductReport::whereIn('id', $delete_all_id)->delete();

        return back()->with('status', "Deleted successfully");
    }
}
