<?php

namespace App\Console\Commands;

use App\Mail\BlockStudentMail;
use App\Models\Pinjam;
use App\Models\Student;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class BlockStudent extends Command
{
    protected $signature = 'student:block';

    protected $description = 'Block student';

    public function handle()
    {
        try {
            $update = Student::withoutGlobalScopes()
                ->has('pinjams')
                ->update(['is_block' => 1]);

            if ($update) {
                $this->sendMail();
            }

            Log::info($update . ' siswa di block');
        } catch (\Throwable $th) {
            Log::error($th);
        }

        return;
    }

    protected function sendMail()
    {
        $list = Pinjam::select('id', 'user_id', 'student_id')
            ->whereDate('created_at', date('Y-m-d'))
            ->with([
                'user' => fn ($query) => $query->select('id', 'email'),
                'student' => fn ($query) => $query->withoutGlobalScopes()->select('id', 'nama', 'tipe')
            ])->get()->groupBy(fn ($item) => $item->user->email);

        foreach ($list as $email => $item) {
            $siswa = $item->pluck('student.nama');
            Mail::to($email)->send(new BlockStudentMail($siswa->toArray()));
        }
    }
}
