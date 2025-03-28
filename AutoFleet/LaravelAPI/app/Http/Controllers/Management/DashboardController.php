<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\DashboardMetrics\CustomerMetrics;
use App\Helpers\DashboardMetrics\FinancialMetrics;
use App\Helpers\DashboardMetrics\FleetMetrics;
use App\Helpers\DashboardMetrics\OperationalMetrics;


class DashboardController extends Controller
{

    protected $customermetrics;
    protected $financialmetrics;
    protected $fleetmetrics;
    protected $operationalmetrics;


    public function __construct(CustomerMetrics $customermetrics, FinancialMetrics $financialmetrics, FleetMetrics $fleetmetrics, OperationalMetrics $operationalmetrics)
    {
        $this->customermetrics = $customermetrics;
        $this->financialmetrics = $financialmetrics;
        $this->fleetmetrics = $fleetmetrics;
        $this->operationalmetrics = $operationalmetrics;

    }







    public function get()
    {
        $customerData = $this->customermetrics->get();
        $financialData = $this->financialmetrics->get();
        $fleetData = $this->fleetmetrics->get();
        $operationalData = $this->operationalmetrics->get();


        $data = [
            'customerData'=>$customerData,
            'financialData'=>$financialData,
            'fleetData'=>$fleetData,
            'operationalData'=>$operationalData,
        ];


        return $data;

    }






}
