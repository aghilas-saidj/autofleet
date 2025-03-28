<?php

namespace App\Helpers\DashboardMetrics;

use App\Services\PaymentService;
use App\Services\ExpenseService;

class FinancialMetrics
{
  
    
    protected $paymentservice;
    protected $expenseservice;

    public function __construct(PaymentService $paymentservice, ExpenseService $expenseservice,) {
        $this->paymentservice = $paymentservice;
        $this->expenseservice = $expenseservice;
    }

    public function get()
    {

        $totalRevenue = $this->paymentservice->getTotalRevenue();
        $totalExpenses = $this->expenseservice->getTotalExpenses();
        $netProfit = $totalRevenue - $totalExpenses;


        $lastMonthRevenue = $this->paymentservice->getTotalRevenueForLastMonth();
        $currentMonthRevenue = $this->paymentservice->getTotalRevenueForCurrentMonth();
        $monthlyExpenses = $this->expenseservice->getTotalExpensesForCurrentMonth();
        $monthlyNetProfit = $currentMonthRevenue - $monthlyExpenses;


        $currentWeekRevenue = $this->paymentservice->getTotalRevenueForCurrentWeek();
        $weeklyExpenses = $this->expenseservice->getTotalExpensesForCurrentWeek();
        $weeklyNetProfit = $currentWeekRevenue - $weeklyExpenses;


        $todayRevenue = $this->paymentservice->getTotalRevenueForToday();
        $dailyExpenses = $this->expenseservice->getTotalExpensesForCurrentDay();
        $todayNetProfit = $todayRevenue - $dailyExpenses;


        $yearlyRevenue = $this->paymentservice->getTotalRevenueForCurrentYear();
        $yearlyExpenses = $this->expenseservice->getTotalExpensesForCurrentYear();
        $yearlyNetProfit = $yearlyRevenue - $yearlyExpenses;


        $getTrendRevenueForCurrentMonth = $this->paymentservice->getTrendRevenueForCurrentMonth();
        $getTrendRevenueForCurrentWeek = $this->paymentservice->getTrendRevenueForCurrentWeek();
        $getTrendRevenueForToday = $this->paymentservice->getTrendRevenueForToday();
        $getTrendRevenueForCurrentYear = $this->paymentservice->getTrendRevenueForCurrentYear();


return response()->json([
            'total_revenue' => $totalRevenue,
            'total_expenses' => $totalExpenses,
            'total_net_profit' => $netProfit,

            'last_month_revenue' => $lastMonthRevenue,

            'monthly_revenue' => $currentMonthRevenue,
            'monthly_expenses' => $monthlyExpenses,
            'monthly__net_profit' => $monthlyNetProfit,


            'weekly_revenue' => $currentWeekRevenue,
            'weekly_expenses' => $weeklyExpenses,
            'weekly__net_profit' => $weeklyNetProfit,


            'daily_revenue' => $todayRevenue,
            'daily_expenses' => $dailyExpenses,
            'daily__net_profit' => $todayNetProfit,


            'yearly_revenue' => $yearlyRevenue,
            'yearly_expenses' => $yearlyExpenses,
            'yearly__net_profit' => $yearlyNetProfit,
            

            'daily_trend_revenue' => $getTrendRevenueForToday,
            'weekly_trend_revenue' => $getTrendRevenueForCurrentWeek,
            'monthly_trend_revenue' => $getTrendRevenueForCurrentMonth,
            'yearly_trend_revenue' => $getTrendRevenueForCurrentYear,







        ]);



    }


}
