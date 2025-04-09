<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    private function checkRole($allowedRoles = ['admin'])
{
    $userRole = Auth::user()->rol ?? null;
    
    if (!$userRole || !in_array($userRole, $allowedRoles)) {
        if ($userRole === 'vendedor') {
            return redirect()->route('sales.create')
                ->with('error', 'No tienes permiso para acceder a esta sección.');
        }
        
        return redirect()->route('login');
    }
    
    return null; // No redirect needed
}
    public function index(Request $request)
    {
        $period = $request->period ?? 'day';
        $date = $request->date ?? Carbon::now()->format('Y-m-d');
        $userId = $request->user_id ?? 'all';
        
        $users = User::orderBy('name')->get();
        $sales = $this->getSalesByPeriod($period, $date, $userId);
        
        return view('reports.index', compact('sales', 'period', 'date', 'users', 'userId'));
    }
    
    public function detail($id)
    {
        $sale = Sale::with(['details.product', 'user'])->findOrFail($id);
        
        return view('reports.detail', compact('sale'));
    }
    
    private function getSalesByPeriod($period, $date, $userId)
    {
        $query = Sale::with('user')
                    ->select('sales.*', 'users.name as user_name')
                    ->join('users', 'sales.user_id', '=', 'users.id');
        
        // Filtro por usuario
        if ($userId !== 'all') {
            $query->where('sales.user_id', $userId);
        }
        
        switch ($period) {
            case 'day':
                $query->whereDate('sales.created_at', $date);
                break;
                
            case 'week':
                $startOfWeek = Carbon::parse($date)->startOfWeek();
                $endOfWeek = Carbon::parse($date)->endOfWeek();
                $query->whereBetween('sales.created_at', [$startOfWeek, $endOfWeek]);
                break;
                
            case 'month':
                $startOfMonth = Carbon::parse($date)->startOfMonth();
                $endOfMonth = Carbon::parse($date)->endOfMonth();
                $query->whereBetween('sales.created_at', [$startOfMonth, $endOfMonth]);
                break;
                
            case 'year':
                $startOfYear = Carbon::parse($date)->startOfYear();
                $endOfYear = Carbon::parse($date)->endOfYear();
                $query->whereBetween('sales.created_at', [$startOfYear, $endOfYear]);
                break;
        }
        
        return $query->orderBy('sales.created_at', 'desc')->get();
    }
}