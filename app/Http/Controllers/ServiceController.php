<?php

namespace App\Http\Controllers;

use App\Models\Analysis;
use App\Models\Prescriptions;
use App\Models\Services;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{

    public function today()
    {
        $data = [];
        $services = Services::with('patient.user', 'serviceStatus')->whereDate('service_date', Carbon::today());

        $data['data'] = $services->paginate(10);

        return response()->json($data);
    }

    public function after()
    {
        $data = [];
        $services = Services::with('patient.user', 'serviceStatus')->whereDate('service_date', '>', Carbon::today())
            ->orderBy('service_date', 'ASC');

        $data['data'] = $services->paginate(10);

        return response()->json($data);
    }

    public function before()
    {
        $data = [];
        $services = Services::with('patient.user', 'serviceStatus')->whereDate('service_date', '<', Carbon::today())
            ->orderBy('service_date', 'DESC');

        $data['data'] = $services->paginate(10);

        return response()->json($data);
    }

    public function detail($id)
    {
        $service = Services::with('patient.user', 'prescriptions', 'analysis', 'serviceStatus')->where('id', $id)->first();

        return response()->json($service);
    }

    public function addPrescription(Request $request, $id)
    {

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

    public function removePrescription($id)
    {
        $prescription = Prescriptions::find($id);
        $trash  = $prescription->prescription;

        $path   = 'assets/images/prescriptions/' . $trash;

        unlink($path);

        $prescription->delete();

        return response()->json($prescription);
    }

    public function addAnalysis(Request $request, $id)
    {

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

    public function removeAnalysis($id)
    {
        $analyses = Analysis::find($id);
        $trash  = $analyses->analyses;

        $path   = 'assets/images/analyses/' . $trash;

        unlink($path);

        $analyses->delete();

        return response()->json($analyses);
    }

    public function changeStatus(Request $request, $id)
    {
        $service = Services::find($id)->update([
            'status_id' => $request->status_id
        ]);

        if ($request->status_id == 4) {
            // mail ile ödeme bilgileri gönderilecektir
        } else if ($request->status_id == 2) {
            // mail ile hastanın gelmediği bildirimi yapılacaktır.
        } else if ($request->status_id == 5) {
            // mail ile hastanın muayneyi iptal etme bildirimi yapılacaktır.
        }

        return response()->json(['message' => 'Success']);
    }

    public function add(Request $request)
    {
        $user = User::with('patient')->where('id', Auth::id())->first();

        $service = Services::create([
            'patient_id' => $user->patient->id,
            'service_no' => 'R-' . rand(100, 9999999),
            'status_id' => 1,
            'desc' => $request->desc,
            'service_date' => $request->service_date
        ]);

        return response()->json(['message' => 'Success', 'service' => $service]);
    }

    public function myServicesToday()
    {
        $data = [];
        $user = User::with('patient')->where('id', Auth::id())->first();
        $services = Services::with('patient.user', 'serviceStatus')
            ->where('patient_id', $user->patient->id)
            ->whereDate('service_date', Carbon::today())
            ->orderBy('service_date', 'DESC');

        $data['data'] = $services->paginate(10);

        return response()->json($data);
    }

    public function myServicesBefore()
    {
        $data = [];
        $user = User::with('patient')->where('id', Auth::id())->first();
        $services = Services::with('patient.user', 'serviceStatus')
            ->where('patient_id', $user->patient->id)
            ->whereDate('service_date', '<', Carbon::today())
            ->orderBy('service_date', 'DESC');

        $data['data'] = $services->paginate(10);

        return response()->json($data);
    }

    public function myServicesAfter()
    {
        $data = [];
        $user = User::with('patient')->where('id', Auth::id())->first();
        $services = Services::with('patient.user', 'serviceStatus')
            ->where('patient_id', $user->patient->id)
            ->whereDate('service_date', '>', Carbon::today())
            ->orderBy('service_date', 'DESC');

        $data['data'] = $services->paginate(10);

        return response()->json($data);
    }
}
