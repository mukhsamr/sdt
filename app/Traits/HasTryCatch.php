<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Try Catch
 */
trait HasTryCatch
{
    public static function execute(callable $try, callable $catch = null, ?string $message = null): array
    {
        try {
            $try();
            $alert['status'] = 'success';
        } catch (Throwable $th) {
            if ($catch) $catch();

            if ($th) {
                Log::error($th);
                dd($th);
            }

            $alert['status'] = 'error';
        }

        $alert['msg'] = $message;
        return $alert;
    }
}
