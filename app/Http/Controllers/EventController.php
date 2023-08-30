<?php

namespace App\Http\Controllers;

use App\Factories\ReceptionTimeEventFactory;

class EventController extends Controller
{
    public function index(ReceptionTimeEventFactory $receptionTimeEventFactory): array
    {
        return $receptionTimeEventFactory->getEvents();
    }
}
