<?php
namespace App\Services;

use App\Models\Unavailability;


class CarsWithoutUnavailabilityService
{
    

    	
    protected $unavailability;

    public function __construct(Unavailability $unavailability)
    {
        $this->unavailability = $unavailability;
    }







public function get($from = null, $to = null)
{


    // Check if the unavailability table is empty
    if (!$this->unavailability->exists()) {
        // You can handle the empty table case here, for example:
        \Log::info('The unavailability table is empty.');

     return 'full_availability';
    }


    $query = $this->unavailability->query();

    // $query->where(function ($query) use ($from, $to) {
    //     if ($from) {
    //         $query->where(function ($q) use ($from) {
    //             $q->where('unavailable_from', '<', $from)
    //               ->where('unavailable_to', '<', $from);
    //         });
    //     }
    //     if ($to) {
    //         $query->orWhere(function ($q) use ($to) {
    //             $q->where('unavailable_from', '>', $to)
    //               ->where('unavailable_to', '>', $to);
    //         });


    //     }
    // });


    $startDate1 = $from;
    $endDate1 =  $to;
    $date1Start = new \DateTime($startDate1);
    $date1End = new \DateTime($endDate1);

    $unavailableCars = [];


    // Filter records that have an intersection with the provided date range
    $intersections = $query->where(function ($query) use ($date1Start, $date1End) {
        // Ensure that the date range has any intersection with the unavailability period
        $query->whereRaw('? BETWEEN unavailable_from AND unavailable_to', [$date1Start->format('Y-m-d H:i')])
            ->orWhereRaw('? BETWEEN unavailable_from AND unavailable_to', [$date1End->format('Y-m-d H:i')])
            ->orWhereRaw('unavailable_from BETWEEN ? AND ?', [
                $date1Start->format('Y-m-d H:i'),
                $date1End->format('Y-m-d H:i')
            ])
            ->orWhereRaw('unavailable_to BETWEEN ? AND ?', [
                $date1Start->format('Y-m-d H:i'),
                $date1End->format('Y-m-d H:i')
            ]);
    })->get();

    // Check the intersections
    if ($intersections->isEmpty()) {
        $unavailableCars = [];
   //     echo "No intersection found.";
        return $unavailableCars;


    } else {
        // If there are intersections, you can output the intersecting records
          foreach ($intersections as $unavailability) {
             $unavailableCars[] = $unavailability->car_id;
           //   echo "Intersection found with Unavailability ID: " . $unavailability->id . "and cad ID : ".  $unavailability->car_id. "\n";
             // echo "From: " . $unavailability->unavailable_from . " To: " . $unavailability->unavailable_to . "\n";
          }

       return $unavailableCars;
       
    }
}



















public function isNotUnavailable($carId, $from, $to)
{
// Check if the unavailability table is empty
if (!$this->unavailability->exists()) {
    // You can handle the empty table case here, for example:
    \Log::info('The unavailability table is empty.');

 return 'full_availability';
}


$query = $this->unavailability->query();
$query->where('car_id', $carId);

$query->where(function ($query) use ($from, $to) {
    if ($from) {
        $query->where(function ($q) use ($from) {
            $q->where('unavailable_from', '<', $from)
              ->where('unavailable_to', '<', $from);
        });
    }
    if ($to) {
        $query->orWhere(function ($q) use ($to) {
            $q->where('unavailable_from', '>', $to)
              ->where('unavailable_to', '>', $to);
        });
    }
});

return $query->with('car')->get();



}

}