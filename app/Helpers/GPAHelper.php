<?php

if (!function_exists('calculateGPA')) {
    /**
     * Calculate GPA and credit data for a specific grade level.
     *
     * @param \Illuminate\Support\Collection $academicRecords
     * @param string $gradeLevel
     * @return array
     */
    function calculateGPA($academicRecords, $gradeLevel)
    {
        // Filter records for the given grade level
        $filteredRecords = $academicRecords->filter(fn($record) => $record['gradelevel'] === $gradeLevel);

        // Initialize variables for calculations
        $totalCreditsAttempted = 0;
        $totalCreditsAwarded = 0;
        $totalUnweightedPoints = 0;
        $totalWeightedPoints = 0;

        // Define grade points for Unweighted and Weighted scales
        $gradePoints = [
            'A+' => ['unweighted' => 4.00, 'weighted' => 5.33],
            'A'  => ['unweighted' => 4.00, 'weighted' => 5.00],
            'A-' => ['unweighted' => 3.67, 'weighted' => 4.67],
            'B+' => ['unweighted' => 3.33, 'weighted' => 4.33],
            'B'  => ['unweighted' => 3.00, 'weighted' => 4.00],
            'B-' => ['unweighted' => 2.67, 'weighted' => 3.67],
            'C+' => ['unweighted' => 2.33, 'weighted' => 3.33],
            'C'  => ['unweighted' => 2.00, 'weighted' => 3.00],
            'C-' => ['unweighted' => 1.67, 'weighted' => 2.67],
            'D+' => ['unweighted' => 1.33, 'weighted' => 2.33],
            'D'  => ['unweighted' => 1.00, 'weighted' => 2.00],
            'D-' => ['unweighted' => 0.67, 'weighted' => 1.67],
            'F'  => ['unweighted' => 0.00, 'weighted' => 0.00],
            'I'  => ['unweighted' => 0.00, 'weighted' => 0.00],
        ];

        // Process each record
        foreach ($filteredRecords as $record) {
            $grade = $record['grade'];
            $credit = $record['credit'];

            // Add to total credits attempted
            $totalCreditsAttempted += $credit;

            // Add to credits awarded if grade is not 'F' or 'I'
            if (!in_array($grade, ['F', 'I'])) {
                $totalCreditsAwarded += $credit;
            }

            // Add to total grade points for GPA calculations
            $totalUnweightedPoints += $gradePoints[$grade]['unweighted'] * $credit;
            $totalWeightedPoints += $gradePoints[$grade]['weighted'] * $credit;
        }

        // Calculate GPAs
        $unweightedGPA = $totalCreditsAttempted > 0 ? $totalUnweightedPoints / $totalCreditsAttempted : 0;
        $weightedGPA = $totalCreditsAttempted > 0 ? $totalWeightedPoints / $totalCreditsAttempted : 0;

        return [
            'filteredRecords' => $filteredRecords,
            'totalCreditsAttempted' => $totalCreditsAttempted,
            'totalCreditsAwarded' => $totalCreditsAwarded,
            'unweightedGPA' => $unweightedGPA,
            'weightedGPA' => $weightedGPA,
        ];
    }
}
