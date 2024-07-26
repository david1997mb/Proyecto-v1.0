<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AreaController extends Controller
{
    public function index()
    {
        $areas = Area::all();
        return response($areas, Response::HTTP_OK);
    }
    public function store(Request $request)
    {
        $area = Area::create($request->all());
        return response($area, Response::HTTP_CREATED);
    }
    public function show(Area $area)
    {
        return response($area, Response::HTTP_OK);
    }
    public function update(Request $request, Area $area)
    {
        $area->update($request->all());
        return response($area, Response::HTTP_OK);
    }
    public function destroy(Area $area)
    {
        $area->delete();
        return response(['msg'=> 'Area Eliminada'], Response::HTTP_NO_CONTENT);
    }
}
