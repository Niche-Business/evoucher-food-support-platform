<?php

namespace App\Http\Controllers\Organisation;

use App\Http\Controllers\Controller;
use App\Models\FundLoad;
use App\Models\BankDeposit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role;
        
        // Get fund loads for this organisation
        $fundLoads = FundLoad::where('organisation_user_id', $user->id)
            ->with('admin')
            ->latest()
            ->get();
        
        // Get bank deposits for this organisation
        $bankDeposits = BankDeposit::where('organisation_user_id', $user->id)
            ->latest()
            ->get();
        
        // Calculate statistics
        $totalFundsLoaded = $fundLoads->sum('amount');
        $totalBankDeposits = $bankDeposits->where('status', 'verified')->sum('amount');
        $bankDepositsCount = $bankDeposits->count();
        $fundLoadsCount = $fundLoads->count();
        
        return view('organisation.reports.index', compact(
            'fundLoads',
            'bankDeposits',
            'totalFundsLoaded',
            'totalBankDeposits',
            'bankDepositsCount',
            'fundLoadsCount',
            'role'
        ));
    }
    
    public function exportFundLoadsExcel()
    {
        $user = Auth::user();
        $fundLoads = FundLoad::where('organisation_user_id', $user->id)
            ->with('admin')
            ->latest()
            ->get();
        
        $fileName = 'fund-loads-' . now()->format('Y-m-d-His') . '.xlsx';
        
        return \Excel::download(new \App\Exports\FundLoadsExport($fundLoads), $fileName);
    }
    
    public function exportFundLoadsPdf()
    {
        $user = Auth::user();
        $fundLoads = FundLoad::where('organisation_user_id', $user->id)
            ->with('admin')
            ->latest()
            ->get();
        
        $totalFundsLoaded = $fundLoads->sum('amount');
        $orgName = $user->organisation_profile->name ?? 'Organisation';
        
        $pdf = \PDF::loadView('organisation.reports.fund-loads-pdf', compact('fundLoads', 'totalFundsLoaded', 'orgName'));
        return $pdf->download('fund-loads-' . now()->format('Y-m-d-His') . '.pdf');
    }
    
    public function exportBankDepositsExcel()
    {
        $user = Auth::user();
        $bankDeposits = BankDeposit::where('organisation_user_id', $user->id)
            ->latest()
            ->get();
        
        $fileName = 'bank-deposits-' . now()->format('Y-m-d-His') . '.xlsx';
        
        return \Excel::download(new \App\Exports\BankDepositsExport($bankDeposits), $fileName);
    }
    
    public function exportBankDepositsPdf()
    {
        $user = Auth::user();
        $bankDeposits = BankDeposit::where('organisation_user_id', $user->id)
            ->latest()
            ->get();
        
        $totalDeposits = $bankDeposits->where('status', 'verified')->sum('amount');
        $orgName = $user->organisation_profile->name ?? 'Organisation';
        
        $pdf = \PDF::loadView('organisation.reports.bank-deposits-pdf', compact('bankDeposits', 'totalDeposits', 'orgName'));
        return $pdf->download('bank-deposits-' . now()->format('Y-m-d-His') . '.pdf');
    }
}
