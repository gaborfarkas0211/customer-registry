<?php

namespace App\Http\Controllers;

class EventController extends Controller
{
    public function index(): array
    {
        return [
            [
                'title' => 'John Doe',
                'start' => '2023-09-01 12:00:00',
                'end' => '2023-09-01 13:00:00',
            ]
        ];
    }
}
