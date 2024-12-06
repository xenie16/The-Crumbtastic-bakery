<?php

declare(strict_types=1);

namespace Business;

use Data\StatusDAO;
use Entities\Status;

class StatusService
{
   private StatusDAO $statusDAO;

   public function __construct()
   {
      $this->statusDAO = new StatusDAO();
   }

   public function getAllStatuses(): array
   {
      $records = $this->statusDAO->getAllStatuses();
      $statuses = [];

      foreach ($records as $record) {
         $statuses[] = new Status($record['id'], $record['status']);
      }

      return $statuses;
   }
}
