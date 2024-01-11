<?php

namespace App\Http\Controllers\Process;

use Exception;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Imports\ProcessImport;
use App\Models\Process\Process;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Process\ProcessDetail;
use Maatwebsite\Excel\Exceptions\SheetNotFoundException;
use Maatwebsite\Excel\Exceptions\NoTypeDetectedException;

class ProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $processes = Process::where('isProcessed','=',false)->orderBy("id")->get();
        $client = Client::whereIn("id",$processes->pluck('client_id')->toArray())->orderBy("id")->first();
        return view("processes.index", compact("processes","client"));
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
        try {


            $client = Client::find($request->client_id);
            $processes = Process::where('client_id', '=', $client->id)->get();
            if($processes->count() > 0) {
                foreach( $processes as $proc ) {
                    $processedCounts = ProcessDetail::where('process_id',$proc->id)->count();
                    if( $processedCounts == 0) {
                        $proc->delete();
                    }
                }
            }

            $file = $request->file('file');

            $lastProcess = Process::orderBy('batch')->first();
            if($lastProcess == null){
                $batch = 1;
            }else{
                $batch = +$lastProcess->batch + 1;
            }

            $process = new Process();
            $process->client_id = $client->id;
            $process->date = now()->format("Y-m-d");
            $process->time = now()->format("H:i:s");
            $process->delivery_date = now()->format("Y-m-d");
            $process->isProcessed = 0;
            $process->batch = $batch;
            $process->final_batch = $batch;
            $process->brstn = $client->brstn;
            $process->file_name = $file->getClientOriginalName();
            $process->user_id = Auth::user()->id;
            $process->save();

            Excel::import(new ProcessImport($process), $file);

            $processDetails = ProcessDetail::where('process_id','=',$process->id)->count();

            if($processDetails == 0){
                $process->delete();
                return back()->with('error','Process has been cancelled.');
            }

            return to_route('processes.index')->with('success', 'uploaded actual!');

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
        $process = Process::findOrFail($id);
        return view("processes.show", compact("process"));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Process $process)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Process $process)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Process $process)
    {
        //
    }
}
