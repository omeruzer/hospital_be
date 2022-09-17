<?php

namespace App\Http\Controllers;

use App\Models\Analysis;
use App\Models\Prescriptions;
use App\Models\Services;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ServiceController extends Controller
{

    public function today(){
        $data = [];
        $services = Services::with('patient.user','serviceStatus')->whereDate('service_date', Carbon::today());

        $data['data'] = $services->paginate(10);

        return response()->json($data);
    }

    public function after(){
        $data = [];
        $services = Services::with('patient.user','serviceStatus')->whereDate('service_date', '>', Carbon::today())
            ->orderBy('service_date', 'ASC');

        $data['data'] = $services->paginate(10);

        return response()->json($data);
    }

    public function before(){
        $data = [];
        $services = Services::with('patient.user','serviceStatus')->whereDate('service_date', '<', Carbon::today())
            ->orderBy('service_date', 'DESC');

        $data['data'] = $services->paginate(10);

        return response()->json($data);
    }

    public function detail($id){
        $service = Services::with('patient.user', 'prescriptions', 'analysis','serviceStatus')->where('id', $id)->first();

        return response()->json($service);
    }

    public function addPrescription(Request $request, $id){

        if (request()->hasFile('prescription')) {
            $this->validate(request(), [
                'file' => 'image|mimes:jpg,png,jpeg',
            ]);

            $img = request()->file('prescription');

            $imgName = rand(0, 999) . '-' . time() . '.' . $img->extension();

            if ($img->isValid()) {

                $img->move('assets/images/prescriptions/', $imgName);


                $prescription = Prescriptions::create([
                    'service_id' => $id,
                    'prescription' => $imgName,
                ]);

                return response()->json($prescription);
            }
        }
    }

    public function removePrescription($id){
        $prescription = Prescriptions::find($id);
        $trash  = $prescription->prescription;

        $path   = 'assets/images/prescriptions/'.$trash;

        unlink($path);

        $prescription->delete();

        return response()->json($prescription);
    }

    public function addAnalysis(Request $request, $id){

        if (request()->hasFile('analyses')) {
            $this->validate(request(), [
                'file' => 'image|mimes:jpg,png,jpeg',
            ]);

            $img = request()->file('analyses');

            $imgName = rand(0, 999) . '-' . time() . '.' . $img->extension();

            if ($img->isValid()) {

                $img->move('assets/images/analyses/', $imgName);


                $analyses = Analysis::create([
                    'service_id' => $id,
                    'analyses' => $imgName,
                ]);

                return response()->json($analyses);
            }
        }
    }

    public function removeAnalysis($id){
        $analyses = Analysis::find($id);
        $trash  = $analyses->analyses;

        $path   = 'assets/images/analyses/'.$trash;

        unlink($path);

        $analyses->delete();

        return response()->json($analyses);
    }

    public function changeStatus(Request $request,$id){
        $service = Services::find($id)->update([
            'status_id'=>$request->status_id
        ]);

        return response()->json(['message'=>'Success']);
    }

}
