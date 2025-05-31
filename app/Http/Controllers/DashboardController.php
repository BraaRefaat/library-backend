<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Journal;
use App\Models\Message;
use App\Models\Department;
use App\Models\User;

class DashboardController
{
    public function counts()
    {
        $data = [
            'books' => Book::count(),
            'journals' => Journal::count(),
            'messages' => Message::count(),
            'departments' => Department::count(),
            'users' => User::count(),
        ];
        return response()->json($data);
    }
}
