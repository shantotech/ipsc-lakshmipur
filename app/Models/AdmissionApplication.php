<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdmissionApplication extends Model
{
    use SoftDeletes;

    public const CLASSES = [
        'play' => 'Play',
        'nursery' => 'Nursery',
        'kg' => 'KG',
        'one' => 'Class One',
        'two' => 'Class Two',
        'three' => 'Class Three',
        'four' => 'Class Four',
        'five' => 'Class Five',
    ];

    public const STATUSES = [
        'new' => 'New',
        'contacted' => 'Contacted',
        'approved' => 'Approved',
        'rejected' => 'Rejected',
    ];

    public const GENDERS = [
        'male' => 'Boy',
        'female' => 'Girl',
    ];

    /** Year applicants are applying for; admissions run the year before. */
    public const ACADEMIC_YEAR = '2027';

    protected $fillable = [
        'academic_year', 'student_name', 'date_of_birth', 'gender', 'class', 'previous_school',
        'guardian_name', 'phone', 'email', 'address', 'status', 'notes', 'ip_address',
    ];

    protected function casts(): array
    {
        return ['date_of_birth' => 'date'];
    }

    protected static function booted(): void
    {
        // Reference like IPSC-2027-0042, based on the record id.
        static::created(function (AdmissionApplication $application) {
            $application->reference = sprintf('IPSC-%s-%04d', $application->academic_year, $application->id);
            $application->saveQuietly();
        });
    }

    public function ageOn(string $date): string
    {
        $diff = $this->date_of_birth->diff(new \DateTimeImmutable($date));

        return $diff->y.'y '.$diff->m.'m';
    }
}
