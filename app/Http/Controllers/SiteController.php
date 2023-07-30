<?php

namespace App\Http\Controllers;

use App\Models\Cashout;
use App\Models\Income;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SiteController extends Controller
{
    public function index()
    {
        return view('app.index');
    }

    public function cashout()
    {
        return view('app.cashout');
    }

    public function income()
    {
        return view('app.income');
    }

    public function createCashout(Request $request)
    {
        $data = $request->validate([
            'date' => ['required', 'date'],
            'desc' => ['required'],
            'credit' => ['required']
        ]);

        Cashout::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Data Created'
        ]);
    }

    public function updateCashout(Request $request, $id)
    {
        $cashout = Cashout::find($id);

        $data = $request->validate([
            'date' => ['required', 'date'],
            'desc' => ['required'],
            'credit' => ['required']
        ]);

        $cashout->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Data Updated'
        ]);
    }

    public function deleteCashout($id)
    {
        $cashout = Cashout::find($id);
        $cashout->delete();


        return response()->json([
            'success' => true,
            'message' => 'Data Deleted'
        ]);
    }

    public function formatCurrency($amount): string
    {
        $formatter = new \NumberFormatter('id_ID', \NumberFormatter::CURRENCY);

        return $formatter->formatCurrency($amount, 'IDR');
    }

    /**
     * @throws \Exception
     */
    public function datatableCashout()
    {
        return DataTables::eloquent(Cashout::query())
            ->addColumn('action', function () {
                $btnEdit = '<button class="btn btn-warning btn-sm mx-2 edit">Edit</button>';
                $btnDelete = '<button class="btn btn-sm btn-danger delete">Delete</button>';

                return $btnEdit.$btnDelete;
            })
            ->addColumn('rp_credit', function ($row) {
                return $this->formatCurrency($row->credit);
            })
            ->rawColumns(['action'])
            ->make();
    }

    /**
     * @throws \Exception
     */
    public function datatableIncome()
    {
        return DataTables::eloquent(Income::query())
            ->addColumn('action', function () {
                $btnEdit = '<button class="btn btn-warning btn-sm mx-2 edit">Edit</button>';
                $btnDelete = '<button class="btn btn-sm btn-danger delete">Delete</button>';

                return $btnEdit.$btnDelete;
            })
            ->addColumn('rp_debit', function ($row) {
                return $this->formatCurrency($row->debit);
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function createIncome(Request $request)
    {
        $data = $request->validate([
            'date' => ['required', 'date'],
            'desc' => ['required'],
            'debit' => ['required']
        ]);

        Income::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Data Created'
        ]);
    }

    public function updateIncome(Request $request, $id)
    {
        $cashout = Income::find($id);

        $data = $request->validate([
            'date' => ['required', 'date'],
            'desc' => ['required'],
            'debit' => ['required']
        ]);

        $cashout->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Data Updated'
        ]);
    }

    public function deleteIncome($id)
    {
        $cashout = Income::find($id);
        $cashout->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Deleted'
        ]);
    }

    public function reportPage()
    {
        $month = now()->format('Y-m');
        return view('app.report', ['month' => $month]);
    }

    public function report($date)
    {
        $income = Income::query()->where('date', 'like', "%$date%")->get();
        $cashout = Cashout::query()->where('date', 'like', "%$date%")->get();
        $data = collect($income)->merge($cashout)->groupBy('date');
        $formatter = new \NumberFormatter('id_ID', \NumberFormatter::CURRENCY_ACCOUNTING);

        return view('app.daily_report', [
            'date' => Carbon::createFromFormat('Y-m', $date)->translatedFormat('F Y'),
            'data' => $data,
            'formatter' => $formatter
        ]);
    }

    public function avarageReport($date)
    {
        $income = Income::query()->where('date', 'like', "%$date%")->get();
        $data = collect($income)->groupBy('date');
        $formatter = new \NumberFormatter('id_ID', \NumberFormatter::CURRENCY_ACCOUNTING);
        $totalOmset = [];

        foreach ($data as $value) {
            $totalOmset[] = $value->sum('debit');
        }

        return view('app.avarage', [
            'data' => $data,
            'formatter' => $formatter,
            'total_omset' => array_sum($totalOmset),
            'avg' => collect($totalOmset)->avg()
        ]);
    }

      function chartReport($date)
    {
        return view('app.chart', [
            'date' => $date
        ]);
    }

    public function chartData($date)
    {
        $income = Income::query()->where('date', 'like', "%$date%")->get();
        $data = collect($income)->groupBy('date');
        $totalOmset = [];

        foreach ($data as $key => $value) {
            $totalOmset[$key] = $value->sum('debit');
        }

        return collect($totalOmset)->toJson();
    }
}
