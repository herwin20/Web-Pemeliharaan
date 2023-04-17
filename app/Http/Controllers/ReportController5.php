<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Report5Model;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ReportController5 extends Controller
{
    public function index(Request $request)
    {
        // Report Kerjaan dari JSON
        //$url = 'https://script.google.com/macros/s/AKfycbw9E6nf6JLXmJoGc6JrREROgD6bDAxcu0roUzQIxd666viRbp1Xz2UxBM-Z-rU27HRLeQ/exec';
        //$api = Http::get($url);
        //$report = $api->json();

        // Call elqeuont General
        //$report = ReportModel::all();

        //return view('reportpekerjaan/reportpekerjaan', ['report' => $report]);

        if ($request->ajax()) {
            $data = Report5Model::select(
                'id',
                'week',
                'nama_pekerjaan',
                'uraian_pekerjaan',
                'lokasi',
                'temuan',
                'rekomendasi',
                'status'
            )->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="edit5" id="' . $data->id . '" class="edit5 btn btn-primary btn-sm"> <i class="bx bx-edit-alt"></i></button>';
                    $button .= '   <button type="button" name="delete5" id="' . $data->id . '" class="delete5 btn btn-danger btn-sm"> <i class="bx bx-trash"></i></button>';
                    return $button;
                })
                ->make(true);
        }

        return view('reportpekerjaan.reportpekerjaan5');
    }

    public function store(Request $request)
    {
        $rules = array(
            'week' => 'required',
            'nama_pekerjaan' => 'required',
            'tipe_pekerjaan' => 'required',
            'uraian_pekerjaan',
            'lokasi' => 'required',
            'unit' => 'required',
            'subsistem',
            'pic' => 'required',
            'temuan',
            'material',
            'rekomendasi',
            'status' => 'required',
        );

        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'week' => $request->week,
            'nama_pekerjaan' => $request->nama_pekerjaan,
            'tipe_pekerjaan' => $request->tipe_pekerjaan,
            'uraian_pekerjaan' => $request->uraian_pekerjaan,
            'lokasi' => $request->lokasi,
            'unit' => $request->unit,
            'subsistem' => $request->subsistem,
            'pic' => $request->pic,
            'temuan' => $request->temuan,
            'material' => $request->material,
            'rekomendasi' => $request->rekomendasi,
            'status' => $request->status,
            'photo' => '',
        );

        Report5Model::create($form_data);
        return response()->json(['success' => 'Data Added successfully Blok 5']);
    }

    public function edit($id)
    {
        if (request()->ajax()) {
            $data = Report5Model::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function update(Request $request)
    {
        $rules = array(
            'week' => 'required',
            'nama_pekerjaan' => 'required',
            'tipe_pekerjaan' => 'required',
            'uraian_pekerjaan',
            'lokasi' => 'required',
            'unit' => 'required',
            'subsistem',
            'pic' => 'required',
            'temuan',
            'material',
            'rekomendasi',
            'status' => 'required',
        );

        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'week' => $request->week,
            'nama_pekerjaan' => $request->nama_pekerjaan,
            'tipe_pekerjaan' => $request->tipe_pekerjaan,
            'uraian_pekerjaan' => $request->uraian_pekerjaan,
            'lokasi' => $request->lokasi,
            'unit' => $request->unit,
            'subsistem' => $request->subsistem,
            'pic' => $request->pic,
            'temuan' => $request->temuan,
            'material' => $request->material,
            'rekomendasi' => $request->rekomendasi,
            'status' => $request->status,
            'photo' => '',
        );

        Report5Model::whereId($request->hidden_id)->update($form_data);
        return response()->json(['success' => 'Data Blok 5 is successfully updated']);
    }

    public function destroy($id)
    {
        $data = Report5Model::findOrFail($id);
        $data->delete();
    }

    public function analyze()
    {
        //$datareport12 = DB::connection('mysql2')->table('report_pekerjaan_harian')->count();
        $datareport12 = Report5Model::all()->count();
        $datastatusDone = Report5Model::where('status', '=', 'Sudah Dikerjakan')->count();
        $datastatusWM = Report5Model::where('status', '=', 'Waiting Material')->count();
        $datastatusWS = Report5Model::where('status', '=', 'Waiting Shutdown')->count();
        $datastatusWA = Report5Model::where('status', '=', 'Waiting Analisis')->count();
        $datastatusWI = Report5Model::where('status', '=', 'Waiting Inspection')->count();
        $datastatusWE = Report5Model::where('status', '=', 'Waiting Execution')->count();

        $PM = Report5Model::where('tipe_pekerjaan', '=', 'PM')->count();
        $CM = Report5Model::where('tipe_pekerjaan', '=', 'CM')->count();
        $OnCall = Report5Model::where('tipe_pekerjaan', '=', 'ON CALL')->count();
        $lembur = Report5Model::where('tipe_pekerjaan', '=', 'LEMBUR')->count();
        $other = Report5Model::where('tipe_pekerjaan', '=', 'OTHERS')->count();
        $OH = Report5Model::where('tipe_pekerjaan', '=', 'OH')->count();

        $date = Carbon::parse('2023-01-01 00:00:00');
        $datework = Carbon::parse($date);
        $now = Carbon::now();

        $diff = $datework->diffInDays($now);

        //$totalnotdone = $datastatusWM + $datastatusWA + $datastatusWE + $datastatusWS + $datastatusWI;
        $percentage = number_format(((float)($datastatusDone / $datareport12)) * 100, 1, '.', '');

        //Cari Material yg sering
        $materialfreq = DB::connection('mysql2')->table('report_pekerjaan_harian5')
            ->select('material', DB::raw('COUNT(material) AS total'))
            ->groupBy('material')
            ->havingRaw('COUNT(material) > 0')
            ->orderBy('total', 'desc')->paginate(5);

        return view('reportpekerjaan/report-analyze5', [
            'datareport12' => $datareport12,
            'datastatusDone' => $datastatusDone,
            'datastatusWM' => $datastatusWM,
            'datastatusWS' => $datastatusWS,
            'datastatusWA' => $datastatusWA,
            'datastatusWI' => $datastatusWI,
            'datastatusWE' => $datastatusWE,

            'percentage' => $percentage,
            'PM' => $PM,
            'CM' => $CM,
            'OnCall' => $OnCall,
            'lembur' => $lembur,
            'other' => $other,
            'OH' => $OH,
            'diff' => $diff,

            'materialfreq' => $materialfreq,
        ]);
    }
}
