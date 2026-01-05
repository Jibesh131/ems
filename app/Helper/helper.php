<?php

use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

if (!function_exists('route_details')) {
    function route_details($route)
    {
        $route = Route::getRoutes()->getByName($route);

        if ($route) {
            dd([
                'uri' => $route->uri(),
                'methods' => $route->methods(),
                'action' => $route->getActionName(),
                'middleware' => $route->middleware(),
            ]);
        }
    }
}

if (!function_exists('format_date')) {
    function format_date($date, $format = 'jS F Y', $blank = '-')
    {
        if (empty($date)) {
            return $blank;
        }

        try {
            return Carbon::parse($date)->format($format);
        } catch (DateException $err) {
            return  '-';
        }
    }
}

if (!function_exists('format_amount')) {
    function format_amount($amount, $decimals = 2, $currency = '$', $specialFormat = false)
    {
        if ($specialFormat) {
            if (intval($amount) == $amount) {
                $formatted = number_format((float)$amount, 0, '.', ',');
            } else {
                $formatted = number_format((float)$amount, $decimals, '.', ',');
            }
        } else {
            $formatted = number_format((float)$amount, $decimals, '.', ',');
        }

        return $currency . $formatted;
    }
}

if (!function_exists('format_amount_without_commas')) {
    function format_amount_without_commas($amount)
    {
        if (intval($amount) == $amount) {
            $formatted = number_format((float)$amount, 0, '.', '');
        } else {
            $formatted = number_format((float)$amount, 2, '.', '');
        }
        return $formatted;
    }
}

if (!function_exists('uploadImage')) {

    /**
     * Upload an image to storage with unique name
     *
     * @param UploadedFile|string|null $image The uploaded file from request
     * @param string $folder The folder in 'storage/app/public' to save
     * @param string|null $oldFile Optional: path of old file to delete
     * @return string|null Stored file path relative to 'storage/app/public'
     */
    function uploadImage($image, string $folder = 'images', ?string $oldFile = null): ?string
    {
        if (!$image) {
            // If no new image, return old file or null
            return $oldFile ?? null;
        }

        // Make sure folder exists
        if (!Storage::disk('public')->exists($folder)) {
            Storage::disk('public')->makeDirectory($folder);
        }

        // Delete old file if exists
        if ($oldFile && Storage::disk('public')->exists($oldFile)) {
            Storage::disk('public')->delete($oldFile);
        }

        // Build unique filename: uniqid + timestamp + original extension
        $filename = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();

        // Store in given folder
        return $image->storeAs($folder, $filename, 'public');
    }
}


if (! function_exists('json_to_array')) {
    function json_to_array($data)
    {
        if (is_array($data)) {
            return $data;
        }
        if (is_string($data)) {
            $decoded = json_decode($data, true);
            return is_array($decoded) ? $decoded : [];
        }
        return [];
    }
}

if (! function_exists('setLengthLimit')) {
    function setLengthLimit($str, $len = 30, $ifNull = '--')
    {
        if (is_null($str) || $str === '') {
            return $ifNull;
        }
        if (strlen($str) <= $len + 3) {
            return $str;
        }
        return substr($str, 0, $len) . '...';
    }
}

if (!function_exists('formatDuration')) {
    function formatDuration($seconds)
    {
        $seconds = intval($seconds);
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $secs = $seconds % 60;

        if ($hours > 0) {
            return sprintf("%02d:%02d:%02d", $hours, $minutes, $secs);
        } else {
            return sprintf("%02d:%02d", $minutes, $secs);
        }
    }
}

if (!function_exists('status_badge')) {
    /**
     * Returns the badge class for a given status.
     *
     * @param string $status
     * @return string
     */
    function status_badge($status)
    {
        return match (strtolower($status)) {
            'active' => 'badge-success',
            'inactive' => 'badge-danger',
            'pending' => 'badge-warning',
            default => 'badge-secondary',
        };
    }
}
