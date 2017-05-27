<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\InspectionItem;
use App\InspectionType;
use App\InspectionHeader;
use App\InspectionDetail;
use App\InspectionTechnician;
use App\Vehicle;
use App\Customer;
use Validator;
use Redirect;
use Response;
use Session;
use DB;
use Illuminate\Validation\Rule;
class InspectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inspects = DB::table('inspection_header as i')
            ->join('customer as c','c.id','i.customerId')
            ->join('vehicle as v','v.id','i.vehicleId')
            ->join('vehicle_model as vd','vd.id','v.modelId')
            ->join('vehicle_make as vk','vk.id','vd.makeId')
            ->select('i.*','c.*','v.*','vd.name as model','vd.year as year','vd.transmission as transmission','vk.name as make')
            ->get();
        return View('inspect.index',compact('inspects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $items = InspectionItem::where('isActive',1)->get();
        $customers = DB::table('customer')
            ->select('customer.*')
            ->get();
        $models = DB::table('vehicle_model as vd')
            ->join('vehicle_make as vk','vd.makeId','vk.id')
            ->select('vd.*','vk.name as make')
            ->get();
        $technicians = DB::table('technician')
            ->where('isActive',1)
            ->select('technician.*')
            ->get();
        return View('inspect.create',compact('items','customers','models','technicians'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'firstName' => 'required|max:100',
            'middleName' => 'max:100',
            'lastName' => 'required|max:100',
            'contact' => 'required',
            'email' => 'nullable|email',
            'address' => 'required|max:140',
            'plate' => 'required',
            'modelId' => 'required',
            'mileage' => 'nullable|numeric',
            'technician.*' => 'required',
            'remarks' => 'max:140',
            'form.*' => 'required',
            'item.*' => 'required',
        ];
        $messages = [
            'unique' => ':attribute already exists.',
            'required' => 'The :attribute field is required.',
            'max' => 'The :attribute field must be no longer than :max characters.'
        ];
        $niceNames = [
            'firstName' => 'First Name',
            'middleName' => 'Middle Name',
            'lastName' => 'Last Name',
            'contact' => 'Contact No.',
            'email' => 'Email Address',
            'address' => 'Address',
            'plate' => 'Plate No.',
            'modelId' => 'Vehicle Model',
            'mileage' => 'Mileage',
            'technician.*' => 'Technician Assigned',
            'remarks' => 'Remarks',
            'form.*' => 'Form',
            'item.*' => 'Item'
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        else{
            try{
                DB::beginTransaction();
                $customer = Customer::updateOrCreate(
                    [
                        'firstName' => trim($request->firstName),
                        'middleName' => trim($request->middleName),
                        'lastName' => trim($request->lastName)
                    ],[
                        'contact' => $request->contact,
                        'email' => $request->email,
                        'address' => trim($request->address),
                    ]
                );
                $vehicle = Vehicle::updateOrCreate(
                    ['plate' => str_replace('_','',trim($request->plate))],
                    [
                        'modelId' => $request->modelId,
                        'mileage' => $request->mileage
                    ]
                );
                $inspection = InspectionHeader::create([
                    'customerId' => $customer->id,
                    'vehicleId' => $vehicle->id,
                    'remarks' => trim($request->remarks)
                ]);
                $forms = $request->form;
                $items = $request->itemId;
                foreach($items as $key=>$item){
                    InspectionDetail::create([
                        'inspectionId' => $inspection->id,
                        'itemId' => $item,
                        'remarks' => $forms[$key],
                        'isActive' => 1
                    ]);
                }
                $technicians = $request->technician;
                foreach($technicians as $technician){
                    InspectionTechnician::create([
                        'inspectionId' => $inspection->id,
                        'technicianId' => $technician,
                        'isActive' => 1
                    ]);
                }
                DB::commit();
            }catch(\Illuminate\Database\QueryException $e){
                DB::rollBack();
                $errMess = $e->getMessage();
                return Redirect::back()->withErrors($errMess);
            }
            $request->session()->flash('success', 'Successfully added.');  
            return Redirect::back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return View('layout.404');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $inspect = InspectionHeader::findOrfail($id);
        $customers = DB::table('customer')
            ->select('customer.*')
            ->get();
        $models = DB::table('vehicle_model as vd')
            ->join('vehicle_make as vk','vd.makeId','vk.id')
            ->select('vd.*','vk.name as make')
            ->get();
        $technicians = DB::table('technician')
            ->where('isActive',1)
            ->select('technician.*')
            ->get();
        return View('inspect.edit',compact('inspect','customers','models','technicians'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'firstName' => 'required|max:100',
            'middleName' => 'max:100',
            'lastName' => 'required|max:100',
            'contact' => 'required',
            'email' => 'nullable|email',
            'address' => 'required|max:140',
            'plate' => 'required',
            'modelId' => 'required',
            'mileage' => 'nullable|numeric',
            'technician.*' => 'required',
            'remarks' => 'max:140',
            'form.*' => 'required',
            'item.*' => 'required',
        ];
        $messages = [
            'unique' => ':attribute already exists.',
            'required' => 'The :attribute field is required.',
            'max' => 'The :attribute field must be no longer than :max characters.'
        ];
        $niceNames = [
            'firstName' => 'First Name',
            'middleName' => 'Middle Name',
            'lastName' => 'Last Name',
            'contact' => 'Contact No.',
            'email' => 'Email Address',
            'address' => 'Address',
            'plate' => 'Plate No.',
            'modelId' => 'Vehicle Model',
            'mileage' => 'Mileage',
            'technician.*' => 'Technician Assigned',
            'remarks' => 'Remarks',
            'form.*' => 'Form',
            'item.*' => 'Item'
        ];
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        else{
            try{
                DB::beginTransaction();
                $customer = Customer::updateOrCreate(
                    [
                        'firstName' => trim($request->firstName),
                        'middleName' => trim($request->middleName),
                        'lastName' => trim($request->lastName)
                    ],[
                        'contact' => $request->contact,
                        'email' => $request->email,
                        'address' => trim($request->address),
                    ]
                );
                $vehicle = Vehicle::updateOrCreate(
                    ['plate' => str_replace('_','',trim($request->plate))],
                    [
                        'modelId' => $request->modelId,
                        'mileage' => $request->mileage
                    ]
                );
                $inspection = InspectionHeader::findOrFail($id);
                $inspection->update([
                    'customerId' => $customer->id,
                    'vehicleId' => $vehicle->id,
                    'remarks' => trim($request->remarks)
                ]);
                $forms = $request->form;
                $items = $request->itemId;
                InspectionDetail::where('inspectionId',$id)->update(['isActive'=>0]);
                foreach($items as $key=>$item){
                    InspectionDetail::updateOrCreate(
                        [
                            'inspectionId' => $inspection->id,
                            'itemId' => $item,
                        ],
                        [   
                            'remarks' => $forms[$key],
                            'isActive' => 1
                        ]
                    );
                }
                InspectionTechnician::where('inspectionId',$id)->update(['isActive'=>0]);
                $technicians = $request->technician;
                foreach($technicians as $technician){
                    InspectionTechnician::updateOrCreate(
                        [
                            'inspectionId' => $inspection->id,
                            'technicianId' => $technician
                        ],
                        ['isActive' => 1]
                    );
                }
                DB::commit();
            }catch(\Illuminate\Database\QueryException $e){
                DB::rollBack();
                $errMess = $e->getMessage();
                return Redirect::back()->withErrors($errMess);
            }
            $request->session()->flash('success', 'Successfully updated.');  
            return Redirect::back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return View('layouts.404');
    }
    
    public function customer($id)
    {
        $customer = DB::table('customer as c')
            ->where(DB::raw('CONCAT_WS(" ",c.firstName,c.middleName,c.lastName)'),''.$id)
            ->select('c.*')
            ->first();
        return response()->json(['customer'=>$customer]);
    }
    
    public function vehicle($id)
    {
        $vehicle = DB::table('vehicle as v')
            ->where('v.plate',''.$id)
            ->select('v.*')
            ->first();
        if(!empty($vehicle)){
            return response()->json(['vehicle'=>$vehicle]);
        }
    }
}