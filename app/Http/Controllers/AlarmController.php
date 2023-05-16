<?php

namespace App\Http\Controllers;

use App\Models\Alarm;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlarmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Alarm::with('device');
        
        if($request->input('showDeleted') === '1') {
            $data->onlyTrashed();
        }

        if ($request->has('filter') && !empty($request->filter)) {
            $data->where('name', 'like', '%'.$request->filter . '%');
        }
        if ($request->has('name') && !empty($request->name)) {
            $data->where('name', 'like','%'.$request->name.'%');
        }
        if ($request->has('severity') && !empty($request->severity)) {
            $data->where('severity', $request->severity);
        }
        $device = $request->input('device');
        $data->WhereHas('device', function ($q) use ($device) {            
           $q->Where('name', 'like', '%'.$device.'%');
        });

        $filter_created_at=$request->input('created_at');
            if (!empty($filter_created_at)){               
                    $data->whereDate('created_at', date_create($filter_created_at)); 
               
            }
       
        $data = $data->orderBy($request
            ->has('order') ? $request->order : 'created_at', $request->has('descending') ? $request->descending : 'asc')
            ->paginate($request->has('limit') ? $request->limit : 15);
        return response()->json($data, 200);
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
            'name' => 'required',
            //'params' => 'required',
            'path' => 'required',
            'device_id' => 'required',
        ];

        $this->validate($request, $rules);
        $path = $request->input('path');
        $path = 'https://loremflickr.com/320/240?random='.rand(1,100) ;
        $name = $request->input('name');
        $device_id=$request->input('device_id')[0];
        $severity=$request->input('severity');
        //$alarm = Alarm::create($request->input());
        $alarm = Alarm::create(['name' => $name, 
                                'device_id' => $device_id, 
                                'severity' => $severity, 
                                'path' => $path]);
        //$alarm->device()->sync($request->input('device_id'));
        
        return response()->json($alarm, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($alarm)
    {
        $resource = Alarm::find($alarm);
         
        //$resource->load('alarms');
        return response()->json($resource, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $alarm)
    {
        // Set rules
        $rules = [
            'name' => 'required',
            //'params' => 'required',
            'path' => 'required',
            'device_id' => 'required',
        ];

        // Validate those rules
        $this->validate($request, $rules);
        

        $resource = Alarm::find($alarm);

        $alarmsData = $request->input('alarms');

        //$path = $request->input('path');
        $name = $request->input('name');
        $device_id=$request->input('device_id');
        $severity=$request->input('severity');
        
        //$resource->alarms()->sync($alarmsData);
        

        $resource->update(['name' => $name, 
                            'device_id' => $device_id, 
                            'severity' => $severity]);

        
        /* $TrustMembersData = $request->input('TrustMembers');
        
        if (!empty($TrustMembersData) && count($TrustMembersData) > 0) {
        foreach ($TrustMembersData as $TrustMembersD) {     
          User::where('id',$TrustMembersD)->update([
                                               'alarm_id' => $alarm,
                                               'manager_id' => $alarmsData[0]
                                               ]);
        } 
       }*/

        return response()->json(['data' => $resource, 'message' => 'The alarm has been updated'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Alarm $alarm)
    {
        $alarm->delete();

        return response()->json([
            'message' => 'Trust alarm has been deleted successfully!'
        ], 200);
    }

    public function restore (Request $request, $id) {
        $trustMgtalarm = Alarm::onlyTrashed()->find($id);

        $trustMgtalarm->restore();

        return response()->json([
            'message'   => 'The Trust alarm has been restored successfully'
        ], 200);
    }

    public function options()
    {
        $data = Alarm::select(['id','label'])->get();
        return response()->json($data, 200);
    }
}
