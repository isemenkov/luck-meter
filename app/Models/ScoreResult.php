<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Interfaces\ResultsRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;

final class ScoreResult extends Model implements ResultsRepository
{
    use HasFactory;

    protected $fillable = [
        'phone_number',
        'result',
        'score',
    ];

    public function saveResult(string $phoneNumber, string $result, int $score): void
    {
        $this->create([
            'phone_number' => $phoneNumber,
            'result' => $result,
            'score' => $score,
        ]);
    }

    public function getResults(string $phoneNumber, int $limit): array
    {
        return $this
            ->where('phone_number', $phoneNumber)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(function (ScoreResult $result) {
                return [
                    'score' => sprintf('%s (%s points)', $result->result, $result->score),
                    'time' => $result->created_at->diffForHumans(),
                ];
            })
            ->toArray();
    }
}
