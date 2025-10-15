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
        $totalWeightedHonorsPoints = 0;
        $totalWeightedAPPoints = 0;

        // Define grade points for Unweighted, Weighted Honors, and Weighted AP scales
        $gradePoints = [
            'A+' => ['unweighted' => 4.33, 'weighted_honors' => 4.83, 'weighted_ap' => 5.33],
            'A'  => ['unweighted' => 4.00, 'weighted_honors' => 4.50, 'weighted_ap' => 5.00],
            'A-' => ['unweighted' => 3.67, 'weighted_honors' => 4.17, 'weighted_ap' => 4.67],
            'B+' => ['unweighted' => 3.33, 'weighted_honors' => 3.83, 'weighted_ap' => 4.33],
            'B'  => ['unweighted' => 3.00, 'weighted_honors' => 3.50, 'weighted_ap' => 4.00],
            'B-' => ['unweighted' => 2.67, 'weighted_honors' => 3.17, 'weighted_ap' => 3.67],
            'C+' => ['unweighted' => 2.33, 'weighted_honors' => 2.33, 'weighted_ap' => 2.33],
            'C'  => ['unweighted' => 2.00, 'weighted_honors' => 2.00, 'weighted_ap' => 2.00],
            'C-' => ['unweighted' => 1.67, 'weighted_honors' => 1.67, 'weighted_ap' => 1.67],
            'D+' => ['unweighted' => 1.33, 'weighted_honors' => 1.33, 'weighted_ap' => 1.33],
            'D'  => ['unweighted' => 1.00, 'weighted_honors' => 1.00, 'weighted_ap' => 1.00],
            'D-' => ['unweighted' => 0.67, 'weighted_honors' => 0.67, 'weighted_ap' => 0.67],
            'F'  => ['unweighted' => 0.00, 'weighted_honors' => 0.00, 'weighted_ap' => 0.00],
            'I'  => ['unweighted' => 0.00, 'weighted_honors' => 0.00, 'weighted_ap' => 0.00],
        ];

        // Process each record
        foreach ($filteredRecords as $record) {
            $grade = $record['grade'];
            $credit = $record['credit'];
            $courseTitle = $record['coursetitle'];

            // Skip courses without grades (in-progress courses)
            if (empty($grade) || !isset($gradePoints[$grade])) {
                continue;
            }

            // Add to total credits attempted
            $totalCreditsAttempted += $credit;

            // Add to credits awarded if grade is not 'F' or 'I'
            if (!in_array($grade, ['F', 'I'])) {
                $totalCreditsAwarded += $credit;
            }

            // Determine course type and calculate appropriate GPA points
            $courseType = 'unweighted'; // Default to unweighted
            
            if (stripos($courseTitle, 'AP') !== false) {
                $courseType = 'weighted_ap';
            } elseif (stripos($courseTitle, 'Honors') !== false) {
                $courseType = 'weighted_honors';
            }

            // Add to total grade points for GPA calculations
            $totalUnweightedPoints += $gradePoints[$grade]['unweighted'] * $credit;
            
            if ($courseType === 'weighted_ap') {
                $totalWeightedAPPoints += $gradePoints[$grade]['weighted_ap'] * $credit;
            } elseif ($courseType === 'weighted_honors') {
                $totalWeightedHonorsPoints += $gradePoints[$grade]['weighted_honors'] * $credit;
            } else {
                // For unweighted courses, use unweighted points for both calculations
                $totalWeightedHonorsPoints += $gradePoints[$grade]['unweighted'] * $credit;
                $totalWeightedAPPoints += $gradePoints[$grade]['unweighted'] * $credit;
            }
        }

        // Calculate GPAs
        $unweightedGPA = $totalCreditsAttempted > 0 ? $totalUnweightedPoints / $totalCreditsAttempted : 0;
        $weightedHonorsGPA = $totalCreditsAttempted > 0 ? $totalWeightedHonorsPoints / $totalCreditsAttempted : 0;
        $weightedAPGPA = $totalCreditsAttempted > 0 ? $totalWeightedAPPoints / $totalCreditsAttempted : 0;

        return [
            'filteredRecords' => $filteredRecords,
            'totalCreditsAttempted' => $totalCreditsAttempted,
            'totalCreditsAwarded' => $totalCreditsAwarded,
            'unweightedGPA' => $unweightedGPA,
            'weightedHonorsGPA' => $weightedHonorsGPA,
            'weightedAPGPA' => $weightedAPGPA,
        ];
    }
}
