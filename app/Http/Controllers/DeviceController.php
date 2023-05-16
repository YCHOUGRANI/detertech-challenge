<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Device::with('alarms');
        //$user = Auth::user();        
        
        /* switch ($user->id) {
            case 2:
            case 3:
                $data->where('label', 'Northern' );
                break;            
            case 4:
            case 5:
                $data->where('label', 'North West' );
                break;           
            case 6:
            case 7:
                $data->where('label', 'South East' );
                break;            
            case 8:
                $data->where('label', 'Central' );
                break;
            case 9:                
                $data->where('label', '' )
                ->orwhereNull('label');
                break;
            default:                
                break;
        }     */            
        if($request->input('showDeleted') === '1') {
            $data->onlyTrashed();
        }

        if ($request->has('filter') && !empty($request->filter)) {
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
            'location' => 'required',
            'region' => 'required',
        ];

        $this->validate($request, $rules);

        $trust_region = Device::create($request->input());
        /* $managersData = $request->input('managers');
        $trust_region->managers()->sync($managersData);

        $TrustMembersData = $request->input('TrustMembers');
        
        if (!empty($TrustMembersData) && count($TrustMembersData) > 0) {
        foreach ($TrustMembersData as $TrustMembersD) {     
          User::where('id',$TrustMembersD)->update([
                                               'trust_region_id' => $trust_region,
                                               'manager_id' => $managersData[0]
                                               ]);
        } 
       }*/

        return response()->json($trust_region->load('alarms'), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($trust_region)
    {
        $resource = Device::withTrashed()->find($trust_region);
         
        $resource->load('alarms');
        return response()->json($resource, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $trust_region)
    {
        // Set rules
        $rules = [
            'label' => 'required',
            'address_line_1' => 'required',
            'city' => 'required',
            'postcode' => 'required',
        ];

        // Validate those rules
        $this->validate($request, $rules);
        

        $resource = Device::withTrashed()->find($trust_region);

        $alarmsData = $request->input('alarms');
        $resource->alarms()->sync($alarmsData);
        

        $resource->update($request->input());

        
        $TrustMembersData = $request->input('TrustMembers');
        
        if (!empty($TrustMembersData) && count($TrustMembersData) > 0) {
        foreach ($TrustMembersData as $TrustMembersD) {     
          User::where('id',$TrustMembersD)->update([
                                               'trust_region_id' => $trust_region,
                                               'manager_id' => $alarmsData[0]
                                               ]);
        }
       }

        return response()->json(['data' => $resource->load('alarms'), 'message' => 'The region has been updated'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Device $trust_region)
    {
        $trust_region->delete();

        return response()->json([
            'message' => 'Trust Region has been deleted successfully!'
        ], 200);
    }

    public function restore (Request $request, $id) {
        $trustMgtRegion = Device::onlyTrashed()->find($id);

        $trustMgtRegion->restore();

        return response()->json([
            'message'   => 'The Trust Region has been restored successfully'
        ], 200);
    }

    public function options()
    {
        $data = Device::select(['id','label'])->get();
        return response()->json($data, 200);
    }
}
