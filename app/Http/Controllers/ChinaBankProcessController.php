<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\ChinaBankProcess;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ChinaBankProcessImport;
use App\Models\Client;
use Maatwebsite\Excel\Exceptions\SheetNotFoundException;
use Maatwebsite\Excel\Exceptions\NoTypeDetectedException;
use Yajra\DataTables\Facades\DataTables;

class ChinaBankProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $client = Client::where("name","like","%China Bank%")->first();
        $processes = ChinaBankProcess::where("client_id","=", $client->id)->get();
        return view("china-bank.index", compact("client","processes"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $file = $request->file('file');

        try {
            Excel::import(new ChinaBankProcessImport(), $file);

            return to_route('china_banks.index')->with('status', 'uploaded actual!');

        }catch(NoTypeDetectedException $e){
            return back()->with('error', $e->getMessage());
        }catch(SheetNotFoundException $e){
            return back()->with('error', $e->getMessage() . 'Check sheet name from ' . $file->getClientOriginalName());
        }catch(Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $chinaBankProcess = ChinaBankProcess::findOrFail($id);
        return view("china-bank.show", compact("chinaBankProcess"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChinaBankProcess $chinaBankProcess)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ChinaBankProcess $chinaBankProcess)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChinaBankProcess $chinaBankProcess)
    {
        //
    }

    public function getProcesses(Request $request)
    {
        if ($request->ajax()) {

            $data = ChinaBankProcess::where('isProcessed','=',false)->orderBy('created_at','desc')->get();
            if(count($data) == 0) {
                $data = ChinaBankProcess::where('isProcessed','=',true)->orderBy('created_at','desc')->get();
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="' . route('china_banks.show', $row->id) . '" class="edit btn btn-success btn-sm"><i class="fas fa-sm fa-download"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
