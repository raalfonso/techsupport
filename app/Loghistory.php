<?php

namespace App;
use App\Models\History;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;
trait Loghistory
{
    
    public function logResponse(): void
    {
        History::create([
            'id' => Uuid::uuid4()->toString(),
            'report_id' => $this->id, // or $this->report_id if exists
            'status' => $this->status,
            'action' => 'responded',
            'created_at' => now(),
            'performed_by' => auth()->id(),
        ]);
    }

    public function logValidate(): void
    {
        History::create([
            'id' => Uuid::uuid4()->toString(),
            'report_id' => $this->id, // or $this->report_id if exists
            'status' => $this->status,
            'action' => 'validated',
            'created_at' => now(),
            'performed_by' => auth()->id(),
        ]);
    }

    public function logResolve(): void
    {
        History::create([
            'id' => Uuid::uuid4()->toString(),
            'report_id' => $this->id, // or $this->report_id if exists
            'status' => $this->status,
            'action' => 'resolved',
            'created_at' => now(),
            'performed_by' => auth()->id(),
        ]);
    }

}
