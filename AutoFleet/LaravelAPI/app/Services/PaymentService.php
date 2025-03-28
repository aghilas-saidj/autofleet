<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Support\Str;

class PaymentService
{



    public function getAllPayments()
    {
        return Payment::all();
    }










    public function createPayment(array $data): Payment
    {
        $data['uuid'] = Str::uuid(); // Generate a unique UUID if not provided
        return Payment::create($data);
    }













    public function updatePayment(int $paymentId, array $data): Payment
    {
        $payment = Payment::findOrFail($paymentId);
        $payment->update($data);
        return $payment;
    }

   









    public function getPaymentById(int $paymentId): Payment
    {
        return Payment::findOrFail($paymentId);
    }











    public function getPaymentsByBookingId(int $bookingId)
    {
        return Payment::where('booking_id', $bookingId)->get();
    }
















    public function deletePayment(int $paymentId): bool
    {
        $payment = Payment::findOrFail($paymentId);
        return $payment->delete();
    }



















    public function getTotalRevenue()
    {
        return Payment::where('status', 'completed')->sum('amount');
    }
















    public function getTotalRevenueForLastMonth()
    {
        return Payment::where('status', 'completed')
            ->whereBetween('created_at', [
                now()->startOfMonth()->subMonth(), // Start of last month
                now()->startOfMonth()              // End of last month
            ])
            ->sum('amount');
    }

    












    public function getTotalRevenueForCurrentMonth()
    {
        return Payment::where('status', 'completed')
            ->whereBetween('created_at', [
                now()->startOfMonth(), // Start of the current month
                now()->endOfMonth()    // End of the current month
            ])
            ->sum('amount');
    }



















    public function getTotalRevenueForCurrentWeek()
    {
        return Payment::where('status', 'completed')
            ->whereBetween('created_at', [
                now()->startOfWeek(), // Start of the current week
                now()->endOfWeek()    // End of the current week
            ])
            ->sum('amount');
    }




    













    public function getCurrentWeekRevenue()
{
    $currentWeekRevenue = $this->paymentservice->getTotalRevenueForCurrentWeek();

    return response()->json([
        'current_week_revenue' => $currentWeekRevenue,
    ]);
}

















public function getTotalRevenueForToday()
{
    return Payment::where('status', 'completed')
        ->whereDate('created_at', today()) // Filter by today's date
        ->sum('amount');
}















public function getTotalRevenueForCurrentYear()
{
    return Payment::where('status', 'completed')
        ->whereYear('created_at', now()->year) // Filter by current year
        ->sum('amount');
}
















public function getTrendRevenueForCurrentMonth()
{
    return Payment::where('status', 'completed')
        ->whereBetween('created_at', [
            now()->startOfMonth(), // Start of the current month
            now()->endOfMonth()    // End of the current month
        ])
        ->pluck('amount'); // Retrieve only the 'amount' column
}














public function getTrendRevenueForCurrentWeek()
{
    return Payment::where('status', 'completed')
        ->whereBetween('created_at', [
            now()->startOfWeek(), // Start of the current week
            now()->endOfWeek()    // End of the current week
        ])
        ->pluck('amount'); // Retrieve only the 'amount' column
}













public function getTrendRevenueForToday()
{
    return Payment::where('status', 'completed')
        ->whereDate('created_at', today()) // Filter by today's date
        ->pluck('amount'); // Retrieve only the 'amount' column
}

















public function getTrendRevenueForCurrentYear()
{
    return Payment::where('status', 'completed')
        ->whereYear('created_at', now()->year) // Filter by current year
        ->pluck('amount'); // Retrieve only the 'amount' column
}





}
