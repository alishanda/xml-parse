<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('rows', function ($user) {
    \Log::error(23123213);
    return true;
});
