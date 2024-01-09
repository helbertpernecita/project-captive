<?php

namespace App\Imports\Process;

use App\Models\Process\Process;
use Maatwebsite\Excel\Concerns\ToModel;

class ProcessImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Process([
            try{
                $messages = Session::get('messages', []);
                $msg = [];
                $trans_type = strtolower($row['trans_type']);
                $cancelled = strtolower($row['cancelled']);

                if($trans_type == "complete" && $cancelled == 'no'){
                    $station_code = $row['station'];
                    $machine_plan_code = strtolower($row['machine']);
                    $product_sap_code = $row['code'];
                    if(is_string($row['date'])){
                        $pm_production_date = Carbon::parse($row['date']);
                    }else{
                        $pm_production_date = $this->transformDate($row['date']);
                    }
                    $quantity = $row['quantity'];
                    $client = strtoupper($row['client']);

                    $product = Product::where('case_code','=', $product_sap_code)->first();
                    if($product == null){
                        $product = Product::where('sap_code','=', $product_sap_code)->first();
                        if($product == null){
                            if(str_contains($product_sap_code, 'RF') || str_contains($product_sap_code, 'PF')){
                                $produc_sap_code_rf = str_replace(['RF','PF'], ['',''], $product_sap_code);
                                $product = Product::where('sap_code','=', $produc_sap_code_rf)->first();
                                if($product == null){
                                    if(str_contains($product_sap_code, 'RF') || str_contains($product_sap_code, 'PF')){
                                        $produc_sap_code_pf = str_replace(['RF','PF'], [' RF',' PF'], $product_sap_code);
                                        $product = Product::where('sap_code','=', $produc_sap_code_pf)->first();

                                    }
                                }
                            }
                        }
                    }
                    $company = Company::find($this->request['company_id']);
                    if( $company->short_name == $client){
                        if($product != null){
                            $station = Station::where('plan_code','=',$station_code)->first();
                            if($station == null){
                                $station_id = "";
                                $all_stations = Station::all();
                                foreach($all_stations as $one_station){
                                    if(str_contains($one_station->sap_code,'/')){
                                        $one_station_array = explode('/',$one_station->sap_code);
                                        if(count($one_station_array) > 0){
                                            foreach($one_station_array as $one_station_str){
                                                if(strtolower($one_station_str) == $station_code){
                                                    $station_id = $one_station->id;
                                                }
                                            }
                                        }
                                        $station = Station::find($station_id);
                                    }else{
                                        $station = Station::where('sap_code','=',$station_code)->first();
                                    }
                                }
                            }
                            if($station != null){
                                $machine = Machine::where('plan_code','=',$machine_plan_code)->first();
                                if($machine == null){
                                    $machine = Machine::where('sap_code','=',$machine_plan_code)->first();
                                    if($machine == null){
                                        $all_machines = Machine::all();
                                        foreach($all_machines as $one_machine){
                                            if(str_contains($one_machine->sap_code,'/')){
                                                $one_machine_array = explode('/',$one_machine->sap_code);
                                                if(count($one_machine_array) > 0){
                                                    foreach($one_machine_array as $one_machine_str){
                                                        if(strtolower($one_machine_str) == $machine_plan_code){
                                                            $machine_id = $one_machine->id;
                                                            $machine = Machine::find($machine_id);
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                $plan = Plan::find($this->request['plan_id']);
                                if($machine != null){
                                    $planDetail = PlanDetail::where('product_id','=', $product->id)
                                        ->where('machine_id','=', $machine->id)
                                        ->where('station_id','=', $station->id)
                                        ->where('date','=', $pm_production_date->format('Y-m-d'))
                                        ->where('plan_id','=', $plan->id)
                                        ->first();
                                    if($planDetail != null){
                                        $batch_number = DB::table('plan_detail_product')
                                            ->where('plan_detail_id','=',$planDetail->id)
                                            ->where('product_id','=',$product->id)
                                            ->count();
                                        $planDetail->products()->attach($planDetail->id, [
                                            'product_id' => $planDetail->product_id,
                                            'station_id' => $planDetail->station_id,
                                            'machine_id' => $planDetail->machine_id,
                                            'batch_number' => +$batch_number + 1,
                                            'batch_quantity' => $quantity,
                                            'user_id' => Auth::user()->id,
                                            'shift' => $planDetail->shift,
                                            'date' => $planDetail->date,
                                            'remarks' => 'from import',
                                        ]);
                                    }else{
                                        $capacity = Capacity::where('machine_id','=', $machine->id)
                                        ->where('product_id','=', $product->id)
                                        ->where('station_id','=', $station->id)
                                        ->first();
                                        $dates = Date::where('weekofyear','=', $pm_production_date->format('W'))->where('year','=', $pm_production_date->format('Y'))->get();
                                        foreach($dates as $date){
                                            $detail =  new PlanDetail;
                                            $detail->plan_quantity = 0;
                                            $detail->actual_quantity = 0;
                                            $detail->flow_rate = 0;
                                            $detail->capacity_id = $capacity->id ?? null;
                                            $detail->date = $date->date;
                                            $detail->shift = '1st/2nd';
                                            $detail->revision = $plan->revision;
                                            $detail->plan_fg_cost = 0;
                                            $detail->plan_minutes = 0;
                                            $detail->operator_cost = 0;
                                            $detail->actual_fg_cost = 0;
                                            $detail->user_id = Auth::user()->id;
                                            $detail->machine_id = $machine->id;
                                            $detail->product_id = $product->id;
                                            $detail->station_id = $station->id;
                                            $detail->plan_id = $plan->id;
                                            $detail->company_id = $product->variantDetail->company_id;
                                            $detail->save();

                                            if($date->date == $pm_production_date->format('Y-m-d')){
                                                $detail->products()->attach($detail->id, [
                                                    'product_id' => $detail->product_id,
                                                    'station_id' => $detail->station_id,
                                                    'machine_id' => $detail->machine_id,
                                                    'batch_number' => 1,
                                                    'batch_quantity' => $quantity,
                                                    'user_id' => Auth::user()->id,
                                                    'shift' => $detail->shift,
                                                    'date' => $detail->date,
                                                    'remarks' => 'from import no plan',
                                                ]);
                                            }
                                        }
                                    }

                                    if($capacity == null && $product->variantDetail->variant->code != 'Bundling'){
                                        $msg[] = ['capacity' => $product->variantDetail->variant->code . ' / ' . $product->short_name . ' / ' . $machine->plan_code . '/' . $station->code];
                                        $this->errQty += +$quantity;
                                    }
                                }else{
                                    $msg[] = ['machine' => $machine_plan_code];
                                    $this->errQty += +$quantity;
                                }
                            }else{
                                $msg[] = ['station' => $station_code];
                                $this->errQty += +$quantity;
                            }
                        }else{
                            $msg[] = ['product' => $product_sap_code];
                            $this->errQty += +$quantity;
                        }
                    }

                    $messages[] = $msg;
                    $messages = collect($messages)->unique()->toArray();
                    Session::put('messages',$messages);
                    Session::put('errQty', $this->errQty);
                }
            }catch(Exception $e){
                Log::error('Failed to import', ['error' => $e->getMessage()]);
                return null;
            }
        ]);
    }
}
