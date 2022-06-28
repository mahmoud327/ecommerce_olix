<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Requests\Web\Admin\CityRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Governorate;

class CityController extends Controller
{

    // to get all cities
    public function index()
    {
        $cities = City::all();
        return view('web.admin.cities.index', compact('cities'));
    }

    // create page city
    // public function create()
    // {
    //   $governorates = Governorate::pluck('name', 'id');

    //   $selectedID = Governorate::first();

    //   return view ('web.admin.cities.create',compact('selectedID', 'governorates'));
    // }

    // to create a city
    public function store(CityRequest $request)
    {
        $city = new City;
        $city->name = [ 'en' => $request->name_en, 'ar' => $request->name_ar];
        $city->governorate_id = $request->governorate_id;
        $city->save();

        session()->flash('Add', 'تم أضافة السجل بنجاح ');
        return redirect()->back();
    }



    // to edit page
    // public function edit($id)
    // {
    //   $model = City::findOrFail($id);

    //   $governorates = Governorate::pluck('name', 'id');

    //   $selectedID = $model->governorate->id;

    //   return view('web.admin.cities.edit', compact('model','governorates','selectedID'));
    // }

    // to edit a city
    public function update(Request $request, $id)
    {
        $city = City::findOrFail($id);
        $city->name = [ 'en' => $request->name_en, 'ar' => $request->name_ar];
        $city->governorate_id = $request->governorate_id;
        $city->update();

        session()->flash('edit', 'تم تعديل السجل بنجاح ');
        return redirect()->back();
    }

    // to delete a city
    public function destroy($id)
    {
        $city = City::findOrFail($id);
        $city->delete();
        session()->flash('delete', 'تم حذف السجل بنجاح ');
        return redirect()->back();
    }
    

    public function city(Request $request)
    {
        $cities = City::where(function ($q) use ($request) {
            if ($request->has('governorate_id')) {
                $q->where('governorate_id', $request->governorate_id);
            }
        })->get();
        $response    = [
          'status'  => 1,
          'message' =>'sucess',
          'data'    => $cities
        ];
        
        return response()->json($response);
    }
}
