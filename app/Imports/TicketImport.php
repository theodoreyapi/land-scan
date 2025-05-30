<?php

namespace App\Imports;

use App\Models\Tickets;
use Maatwebsite\Excel\Concerns\ToModel;

class TicketImport implements ToModel
{
    protected $eventId;
    public $count = 0;

    public function __construct($eventId)
    {
        $this->eventId = $eventId;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $this->count++;
        
        return new Tickets([
            'ticket_code' => $row[0],
            'ticket_st' => $row[1],
            'ticket_free' => $row[2],
            'ticket_seas' => $row[3],
            'ticket_passed' => $row[4],
            'evenment_id' => $this->eventId,
        ]);
    }
}
