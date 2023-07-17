<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\ReportModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use SebastianBergmann\Diff\Diff;

class ReportController extends Controller
{

    //public function index()
    //{
    //    return view('reportpekerjaan.reportpekerjaan');
    //}

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
            $data = ReportModel::select(
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
                    $button = '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm"> <i class="bx bx-edit-alt"></i></button>';
                    $button .= '   <button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"> <i class="bx bx-trash"></i></button>';
                    return $button;
                })
                ->make(true);
        }

        $kerjaan = array();

        return view('reportpekerjaan.reportpekerjaan', ['kerjaan' => $kerjaan]);
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
            'photo' => 'mimes:csv,txt,xlx,xls,pdf,jpg,jpeg,png|max:2048'
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

        ReportModel::create($form_data);
        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function edit($id)
    {
        if (request()->ajax()) {
            $data = ReportModel::findOrFail($id);
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

        ReportModel::whereId($request->hidden_id)->update($form_data);
        return response()->json(['success' => 'Data Blok 1-2 is successfully updated']);
    }

    public function destroy($id)
    {
        $data = ReportModel::findOrFail($id);
        $data->delete();
    }

    public function analyze()
    {
        //$datareport12 = DB::connection('mysql2')->table('report_pekerjaan_harian')->count();
        $datareport12 = ReportModel::all()->count();
        $datastatusDone = ReportModel::where('status', '=', 'Sudah Dikerjakan')->count();
        $datastatusWM = ReportModel::where('status', '=', 'Waiting Material')->count();
        $datastatusWS = ReportModel::where('status', '=', 'Waiting Shutdown')->count();
        $datastatusWA = ReportModel::where('status', '=', 'Waiting Analisis')->count();
        $datastatusWI = ReportModel::where('status', '=', 'Waiting Inspection')->count();
        $datastatusWE = ReportModel::where('status', '=', 'Waiting Execution')->count();

        $PM = ReportModel::where('tipe_pekerjaan', '=', 'PM')->count();
        $CM = ReportModel::where('tipe_pekerjaan', '=', 'CM')->count();
        $OnCall = ReportModel::where('tipe_pekerjaan', '=', 'ON CALL')->count();
        $lembur = ReportModel::where('tipe_pekerjaan', '=', 'LEMBUR')->count();
        $other = ReportModel::where('tipe_pekerjaan', '=', 'OTHERS')->count();
        $OH = ReportModel::where('tipe_pekerjaan', '=', 'OH')->count();

        $date = Carbon::parse('2023-01-01 00:00:00');
        $datework = Carbon::parse($date);
        $now = Carbon::now();

        $diff = $datework->diffInDays($now);

        //$totalnotdone = $datastatusWM + $datastatusWA + $datastatusWE + $datastatusWS + $datastatusWI;
        $percentage = number_format(((float)($datastatusDone / $datareport12)) * 100, 1, '.', '');

        //Cari Material yg sering
        $materialfreq = DB::connection('mysql2')->table('report_pekerjaan_harian')
            ->select('material', DB::raw('COUNT(material) AS total'))
            ->groupBy('material')
            ->havingRaw('COUNT(material) > 0')
            ->orderBy('total', 'desc')->paginate(5);

        return view('reportpekerjaan/report-analyze', [
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
