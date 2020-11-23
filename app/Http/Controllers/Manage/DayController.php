<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Day;
use App\Models\DaySeller;
use Illuminate\Http\Request;

class DayController extends Controller{

    public function index(Request $request){
        $days = Day::all()->merge($request->user()->seller->days);

        return view('manage.open-hours', [
            'days' => $days
        ]);
    }

    public function update(Request $request){
        $request->validate([
            'day_id.*' => 'required|exists:App\Models\Day,id|distinct',
            'start.*' => 'nullable|date_format:H:i|required_with:end.*|before:end.*',
            'end.*' => 'nullable|date_format:H:i|required_with:start.*|after:start.*',
        ]);

        $data = collect($request->day_id)->map(function ($day_id) use($request){
            if($request->start[$day_id] != null || $request->end[$day_id] != null){
                return [
                    'start' => $request->start[$day_id],
                    'end' => $request->end[$day_id],
                ];
            }
        })->reject(function ($daySeller){
            return empty($daySeller);
        });

        $request->user()->seller->days()->sync($data);

        return redirect()->route('manage.open-hours.index')->with([
            'success' => 'Data berhasil diperbarui.'
        ]);
    }
}
