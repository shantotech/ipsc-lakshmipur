<?php

namespace App\Support;

use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Streams rows as a CSV file that Excel opens correctly (UTF-8 with BOM,
 * so Bangla text displays properly). Runs instantly, no background queue.
 */
class CsvExport
{
    /**
     * @param  array<string, callable>  $columns  heading => fn ($record) => value
     */
    public static function download(string $filename, Collection $records, array $columns): StreamedResponse
    {
        return response()->streamDownload(function () use ($records, $columns) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, array_keys($columns), escape: '');

            foreach ($records as $record) {
                fputcsv($out, array_map(fn (callable $value) => self::safe($value($record)), $columns), escape: '');
            }

            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    /** Stop spreadsheet apps treating user-typed text as a formula. */
    private static function safe(mixed $value): string
    {
        $value = (string) $value;

        return preg_match('/^[=+\-@\t\r]/', $value) ? "'".$value : $value;
    }
}
