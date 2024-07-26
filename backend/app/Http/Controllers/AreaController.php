<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AreaController extends Controller
{
    public function index()
    {
        $areas = Area::select('areas.*')
        ->paginate(50);
        return response()->json($areas);
    }

    public function store(Request $request)
    {
        $rules = ['name' => 'required|string|min:1|max:100'];
        $validator = Validator::make($request->input(),$rules);
        if ($validator->fails()) {
            return response()->json([
                'status'=>false,
                'errors'=> $validator->errors()->all()
            ],400);
        }
        $area = new Area($request->input());
        $area->save();
        return response()->json([
            'status'=>true,
            'message'=> 'Area Creada Correctamente'
        ],200);
    }

    public function show(Area $area)
    {
        return response()->json(['status'=>true,'data'=>$area]);
    }

    public function update(Request $request, Area $area)
    {
        $rules = ['name' => 'required|string|min:1|max:100'];
        $validator = Validator::make($request->input(),$rules);
        if ($validator->fails()) {
            return response()->json([
                'status'=>false,
                'errors'=> $validator->errors()->all()
            ],400);
        }
        $area->update($request->input());
        return response()->json([
            'status'=>true,
            'message'=> 'Area Actualizada Correctamente'
        ],200);
    }

    public function destroy(Area $area)
    {
        $area->delete();
        return response()->json([
            'status'=>true,
            'message'=> 'Area Eliminada Correctamente'
        ],200);
    }
    public function all() {
        $areas = Area::select('areas.*')
        ->get();
        return response()->json($areas);
    }
    public function areasbyevent() {
        $areas = DB::table('event_area')
            ->select('areas.id', 'areas.name', DB::raw('count(event_area.area_id) as count'))
            ->rightJoin('areas', 'event_area.area_id', '=', 'areas.id')
            ->groupBy('areas.id', 'areas.name')
            ->orderByDesc('count')
            ->get();
    
        return response()->json($areas);
    }
     
}
