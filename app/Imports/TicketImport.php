<?php

namespace App\Imports;

use App\Models\Associations;
use App\Models\Portes;
use App\Models\Tickets;
use Illuminate\Support\Facades\Log;
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

        // Ignorer les lignes invalides ou l’en-tête
        if ($this->count == 1 || empty($row[0])) {
            return null;
        }

        // Créer le ticket
        $ticket = Tickets::create([
            'ticket_code'   => $row[0],
            'ticket_st'     => $row[1] ?? '',
            'ticket_free'   => $row[2] ?? '',
            'ticket_seas'   => $row[3] ?? '',
            'ticket_passed' => $row[4] ?? '',
            'evenment_id'   => $this->eventId,
        ]);

        // Récupérer le nom de la porte (row[5]) et chercher son ID
        $porteName = $row[5]; // index 5
        $porte = Portes::where('porte_name', $porteName)->first();

        // Créer l'association si la porte existe
        if ($porte && $ticket) {
            Associations::create([
                'tickets_id' => $ticket->ticket_id,
                'port_id'    => $porte->porte_id,
            ]);
        } else {
            Log::warning('Porte non trouvée ou ticket non créé pour la ligne : ' . json_encode($row));
        }

        return null;

    }
}
