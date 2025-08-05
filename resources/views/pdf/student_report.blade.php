<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transcript</title>
	<link href='https://fonts.googleapis.com/css?family=Open Sans Condensed:300' rel='stylesheet'> 
    <style>
	* {
		font-family: 'Open Sans Condensed';
	}
	.pdfHead span {
		color: #005589;
		font-size: 10px;
	}
	.pdfHead p {
		color: #005589;
		margin: 3px 0 0;
		font-size: 13px;
	}
	.pdfHead h2 {
		color: #005589;
		font-size: 22px;
		margin: 0;
	}
	.pdfHead {
		text-align: center;
		padding: 15px 0;
		margin-bottom: 20px;
	}
	th {
		border: 1px solid #333;
		font-size: 10px;
		padding: 5px;
	}
	td {
		border-left: 1px solid #333;
		border-right: 1px solid #333;
		font-size: 10px;
		padding: 5px;
	}
	.secondTbl td {
		border-bottom: none;
		border-top: none;
	}
	.mainTable tr:last-child td {
		border-top: 1px solid #333;
	}
	tr:last-child td {
		border-bottom: 1px solid #333;
	}
	.tabletwo {
		clear: both;
	}
	.column {
	  float: left;
	  width: 49%; 
	}
	.column td {
	  text-align: center;
	}
	.column td:first-child {
	  text-align: left;
	}
	table {
		border-collapse: collapse;
	}
	.tablebottom input {
		border: none;
		border-bottom: 1px solid #333;
		background: transparent;
		width: 24%;
	}
	.tablebottom {
		background: #effaff;
		padding: 20px;
		border: 1px solid #333;
		transform: translateY(15px);
	}
	.tablebottom p {
		padding-bottom: 40px;
		margin: 0;
	}
	.second-bottom h4 {
		font-size: 22px;
		margin: 0;
	}
	.second-bottom {
		background: #23486c;
		padding: 20px;
		color: #fff;
		text-align: center;
		margin-top: 15px;
		font-size: 12px;
	}
	.second-bottom em {
		color: #ffde59;
	}
	.column tr:last-child td {
    border-top: 1px solid #333;
}
    </style> 
</head>
<body>
<div class="mainTable" style="padding: 0 0 50px; background: url({{ public_path('mainbg.png') }}); background-size: contain; background-position: center; background-repeat: no-repeat;">
	<div class="pdfHead" style="background: url({{ public_path('trans-head.png') }}); background-size: cover; background-position: left center;">
		<h2>ELITE PREPARATORY ACADEMY</h2>
		<p>OFFICIAL HIGH SCHOOL TRANSCRIPT</p>
		<span>CONTACT@ELITEPREPACADEMY.ORG • ELITEPREPACADEMY.ORG</span>
	</div>
	<table width="100%">
		<thead>
			<tr style="background: #29235c; color: #fff;">
				<th colspan="12">STUDENT INFORMATION</th>
			</tr>
			<tr>
				<th>STUDENT NAME</th>
				<th>DOB</th>
				<th colspan="4">EMAIL</th>
				<th colspan="2">GRADUATION DATE</th>
				<th colspan="4">PARENTS</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>{{ $student['name'] }}</td>
				<td>{{ $student['dob'] }}</td>
				<td colspan="4">{{ $student['email'] }}</td>
				<td colspan="2">{{ $student['graduation_date'] }}</td>
				<td colspan="2">Father: {{ $student['father_name'] }}</td>
				<td colspan="2">Mother: {{ $student['mother_name'] }}</td>
			</tr>
		</tbody>
	</table>
	
	<table width="100%" style="padding-top: 15px;">
		<thead>
			<tr style="background: #29235c; color: #fff;">
				<th colspan="12">ACADEMIC RECORD</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td colspan="6" style="border: none; text-align: center; color: #00558a">SCHOOL YEAR 2021 - 2022 GRADE LEVEL: <span style="color: #bf0004;">9TH</span></td>
				<td colspan="6" style="border: none; text-align: center; color: #00558a">SCHOOL YEAR 2022-2023 GRADE LEVEL: <span style="color: #bf0004;">10TH</span></td>
			</tr>
		</tbody>
	</table>
	
	<div class="tabletwo">
	<div class="column" style="padding-right:1%">
		<table width="100%">
			<thead>
				<tr style="background: #29235c; color: #fff;">
					<th colspan="10" style="text-align: left">Course Title</th>
					<th colspan="1">Grade</th>
					<th colspan="1">Credits</th>
				</tr>
			</thead>
			<tbody>
   @php
        // Filter records for '11th grade'
        $filteredRecords = $academicRecords->filter(fn($record) => $record['gradelevel'] === '9th');

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
   
@endphp
    @foreach($filteredRecords as $record)
        @php
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
        
@endphp
        <tr>
            <td colspan="10">{{ $record['coursetitle'] }}</td>
            <td colspan="1">{{ $record['grade'] }}</td>
            <td colspan="1">{{ $record['credit'] }}</td>
        </tr>
    @endforeach

   @php
        // Calculate GPAs
        $unweightedGPA = $totalCreditsAttempted > 0 ? $totalUnweightedPoints / $totalCreditsAttempted : 0;
        $weightedGPA = $totalCreditsAttempted > 0 ? $totalWeightedPoints / $totalCreditsAttempted : 0;
		@endphp

    <tr>
        <td colspan="12" style="text-align: right;">
            Credits Awarded: {{ $totalCreditsAwarded }} <br>
            Credits Attempted: {{ $totalCreditsAttempted }} <br>
            Year Unweighted GPA: {{ number_format($unweightedGPA, 2) }} <br>
            Year Weighted GPA: {{ number_format($weightedGPA, 2) }}
        </td>
    </tr>
</tbody>

		</table>
		</div>
		
	</div>
	
	<div class="column" style="padding-left:1%">
		<table width="100%">
			<thead>
				<tr style="background: #29235c; color: #fff;">
					<th colspan="10" style="text-align: left">Course Title</th>
					<th colspan="1">Grade</th>
					<th colspan="1">Credits</th>
				</tr>
			</thead>
			<tbody>
   @php
        // Filter records for '11th grade'
        $filteredRecords = $academicRecords->filter(fn($record) => $record['gradelevel'] === '10th');

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
  
@endphp
    @foreach($filteredRecords as $record)
      @php
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
			@endphp

        <tr>
            <td colspan="10">{{ $record['coursetitle'] }}</td>
            <td colspan="1">{{ $record['grade'] }}</td>
            <td colspan="1">{{ $record['credit'] }}</td>
        </tr>
    @endforeach

   @php
        // Calculate GPAs
        $unweightedGPA = $totalCreditsAttempted > 0 ? $totalUnweightedPoints / $totalCreditsAttempted : 0;
        $weightedGPA = $totalCreditsAttempted > 0 ? $totalWeightedPoints / $totalCreditsAttempted : 0;
  @endphp

    <tr>
        <td colspan="12" style="text-align: right;">
            Credits Awarded: {{ $totalCreditsAwarded }} <br>
            Credits Attempted: {{ $totalCreditsAttempted }} <br>
            Year Unweighted GPA: {{ number_format($unweightedGPA, 2) }} <br>
            Year Weighted GPA: {{ number_format($weightedGPA, 2) }}
        </td>
    </tr>
</tbody>

		</table>
		</div>
	<table width="100%" style="clear: both;">
		<tbody>
			<tr>
				<td colspan="6" style="border: none; text-align: center; color: #00558a">SCHOOL YEAR 2023-2024 GRADE LEVEL: <span style="color: #bf0004;">11TH</span></td>
				<td colspan="6" style="border: none; text-align: center; color: #00558a">SCHOOL YEAR 2024 - 2025 GRADE LEVEL: <span style="color: #bf0004;">12TH</span></td>
			</tr>
		</tbody>
	</table>
	<div class="tabletwo">
	<div class="column" style="padding-right:1%">
		<table width="100%">
			<thead>
				<tr style="background: #29235c; color: #fff;">
					<th colspan="10" style="text-align: left">Course Title</th>
					<th colspan="1">Grade</th>
					<th colspan="1">Credits</th>
				</tr>
			</thead>
			<tbody>
    @php
        // Filter records for '11th grade'
        $filteredRecords = $academicRecords->filter(fn($record) => $record['gradelevel'] === '11th');

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
    @endphp

    @foreach($filteredRecords as $record)
        @php
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
        @endphp

        <tr>
            <td colspan="10">{{ $record['coursetitle'] }}</td>
            <td colspan="1">{{ $record['grade'] }}</td>
            <td colspan="1">{{ $record['credit'] }}</td>
        </tr>
    @endforeach

    @php
        // Calculate GPAs
        $unweightedGPA = $totalCreditsAttempted > 0 ? $totalUnweightedPoints / $totalCreditsAttempted : 0;
        $weightedGPA = $totalCreditsAttempted > 0 ? $totalWeightedPoints / $totalCreditsAttempted : 0;
    @endphp

    <tr>
        <td colspan="12" style="text-align: right;">
            Credits Awarded: {{ $totalCreditsAwarded }} <br>
            Credits Attempted: {{ $totalCreditsAttempted }} <br>
            Year Unweighted GPA: {{ number_format($unweightedGPA, 2) }} <br>
            Year Weighted GPA: {{ number_format($weightedGPA, 2) }}
        </td>
    </tr>
</tbody>

		</table>
		</div>
		<div class="column" style="padding-left:1%">
		<table width="100%">
			<thead>
				<tr style="background: #29235c; color: #fff;">
					<th colspan="10" style="text-align: left">Course Title</th>
					<th colspan="1">Grade</th>
					<th colspan="1">Credits</th>
				</tr>
			</thead>
			<tbody>
    @php
        // Filter records for '11th grade'
        $filteredRecords = $academicRecords->filter(fn($record) => $record['gradelevel'] === '12th');

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
    @endphp

    @foreach($filteredRecords as $record)
        @php
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
        @endphp

        <tr>
            <td colspan="10">{{ $record['coursetitle'] }}</td>
            <td colspan="1">{{ $record['grade'] }}</td>
            <td colspan="1">{{ $record['credit'] }}</td>
        </tr>
    @endforeach

    @php
        // Calculate GPAs
        $unweightedGPA = $totalCreditsAttempted > 0 ? $totalUnweightedPoints / $totalCreditsAttempted : 0;
        $weightedGPA = $totalCreditsAttempted > 0 ? $totalWeightedPoints / $totalCreditsAttempted : 0;
    @endphp

    <tr>
        <td colspan="12" style="text-align: right;">
            Credits Awarded: {{ $totalCreditsAwarded }} <br>
            Credits Attempted: {{ $totalCreditsAttempted }} <br>
            Year Unweighted GPA: {{ number_format($unweightedGPA, 2) }} <br>
            Year Weighted GPA: {{ number_format($weightedGPA, 2) }}
        </td>
    </tr>
</tbody>

		</table>
		</div>
	</div>
	
	<div class="tablebottom" style="clear: both;">
		<p style="font-size: 12px;"><em>I herebycertify and affirm that this is the official transcript and record of Aleksandre Gogiashvili in the academic studies of 2020-2024</em></p>
		<form>
			<label>Signature</label><input type="signature">
			&nbsp;&nbsp;<label>Title</label><input type="title">&nbsp;&nbsp;
			<label>Date</label><input type="text">
		</form>
	</div>
</div>

<div class="secondTbl" style="padding-top: 100px; background: url({{ public_path('mainbg.png') }}); background-size: contain; background-position: center; background-repeat: no-repeat;">
	<div class="pdfHead" style="background: url({{ public_path('trans-head.png') }}); background-size: cover; background-position: left center;">
		<h2>ELITE PREPARATORY ACADEMY</h2>
		<p>OFFICIAL HIGH SCHOOL TRANSCRIPT</p>
		<span>452 LAKESIDE BLVD. HOPATCONG, NJ 07843 • 732.397.7988</span> <br>
		<span>CONTACT@ELITEPREPACADEMY.ORG • ELITEPREPACADEMY.ORG</span>
	</div>
	<table width="100%">
		<thead>
			<tr style="background: #29235c; color: #fff;">
				<th colspan="12">TRANSCRIPT KEY</th>
			</tr>
		</thead>
	</table>
	<table width="100%">
		<thead>
			<tr>
				<th colspan="6">GRADING SYSTEM</th>
				<th colspan="6">CREDITS REQUIRED FOR GRADUATION</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td colspan="6">A-Excellent</td>
				<td colspan="3" style="border-right: 0;">English</td>
				<td colspan="3" style="border-left: 0;">16</td>
			</tr>
			<tr>
				<td colspan="6">B-Good</td>
				<td colspan="3" style="border-right: 0;">History/Social Science</td>
				<td colspan="3" style="border-left: 0;">16</td>
			</tr>
			<tr>
				<td colspan="6">C-Fair</td>
				<td colspan="3" style="border-right: 0;">Math</td>
				<td colspan="3" style="border-left: 0;">16</td>
			</tr>
			<tr>
				<td colspan="6">D-Barely Passed</td>
				<td colspan="3" style="border-right: 0;">Science</td>
				<td colspan="3" style="border-left: 0;">16</td>
			</tr>
			<tr>
				<td colspan="6">F-Failure</td>
				<td colspan="3" style="border-right: 0;">Health/Physical Education</td>
				<td colspan="3" style="border-left: 0;">16</td>
			</tr>
			<tr>
				<td colspan="6">I-Work incomplete, due to circumstances beyond the student'<br>scontrol, but of passing quality</td>
				<td colspan="3" style="border-right: 0;">Art</td>
				<td colspan="3" style="border-left: 0;">8</td>
			</tr>
			<tr>
				<td colspan="6">The grades A, B, C, and D may be modified 1 by plus (+) <br>or minus (-) suffixes.</td>
				<td colspan="3" style="border-right: 0;">Electives</td>
				<td colspan="3" style="border-left: 0;">16</td>
			</tr>
		</tbody>
		<thead>
			<tr>
				<th colspan="3">GRADE</th>
				<th colspan="3">UNWEIGHTED</th>
				<th colspan="3">WEIGHTED HONORS</th>
				<th colspan="3">WEIGHTED AP</th>
			</tr>
		</thead>
		<tbody style="text-align: center;">
			<tr>
				<td colspan="3">A+</td>
				<td colspan="3" style="border-left: 1px solid #333;">4.00</td>
				<td colspan="3" style="border-left: 1px solid #333;">4.83</td>
				<td colspan="3" style="border-left: 1px solid #333;">5.33</td>
			</tr>
			<tr>
				<td colspan="3">A</td>
				<td colspan="3" style="border-left: 1px solid #333;">4.00</td>
				<td colspan="3" style="border-left: 1px solid #333;">4.50</td>
				<td colspan="3" style="border-left: 1px solid #333;">5.00</td>
			</tr>
			<tr>
				<td colspan="3">A-</td>
				<td colspan="3" style="border-left: 1px solid #333;">3.67</td>
				<td colspan="3" style="border-left: 1px solid #333;">4.17</td>
				<td colspan="3" style="border-left: 1px solid #333;">4.67</td>
			</tr>
			<tr>
				<td colspan="3">B+</td>
				<td colspan="3" style="border-left: 1px solid #333;">3.33</td>
				<td colspan="3" style="border-left: 1px solid #333;">3.83</td>
				<td colspan="3" style="border-left: 1px solid #333;">4.33</td>
			</tr>
			<tr>
				<td colspan="3">B</td>
				<td colspan="3" style="border-left: 1px solid #333;">3.00</td>
				<td colspan="3" style="border-left: 1px solid #333;">3.50</td>
				<td colspan="3" style="border-left: 1px solid #333;">4.00</td>
			</tr>
			<tr>
				<td colspan="3">B-</td>
				<td colspan="3" style="border-left: 1px solid #333;">2.67</td>
				<td colspan="3" style="border-left: 1px solid #333;">3.17</td>
				<td colspan="3" style="border-left: 1px solid #333;">3.67</td>
			</tr>
			<tr>
				<td colspan="3">C+</td>
				<td colspan="3" style="border-left: 1px solid #333;">2.33</td>
				<td colspan="3" style="border-left: 1px solid #333;">2.33</td>
				<td colspan="3" style="border-left: 1px solid #333;">2.33</td>
			</tr>
			<tr>
				<td colspan="3">C</td>
				<td colspan="3" style="border-left: 1px solid #333;">2.00</td>
				<td colspan="3" style="border-left: 1px solid #333;">2.00</td>
				<td colspan="3" style="border-left: 1px solid #333;">2.00</td>
			</tr>
			<tr>
				<td colspan="3">C-</td>
				<td colspan="3" style="border-left: 1px solid #333;">1.67</td>
				<td colspan="3" style="border-left: 1px solid #333;">1.67</td>
				<td colspan="3" style="border-left: 1px solid #333;">1.67</td>
			</tr>
			<tr>
				<td colspan="3">D+</td>
				<td colspan="3" style="border-left: 1px solid #333;">1.33</td>
				<td colspan="3" style="border-left: 1px solid #333;">1.33</td>
				<td colspan="3" style="border-left: 1px solid #333;">1.33</td>
			</tr>
			<tr>
				<td colspan="3">D</td>
				<td colspan="3" style="border-left: 1px solid #333;">1.00</td>
				<td colspan="3" style="border-left: 1px solid #333;">1.00</td>
				<td colspan="3" style="border-left: 1px solid #333;">1.00</td>
			</tr>
			<tr>
				<td colspan="3">D-</td>
				<td colspan="3" style="border-left: 1px solid #333;">0.67</td>
				<td colspan="3" style="border-left: 1px solid #333;">0.67</td>
				<td colspan="3" style="border-left: 1px solid #333;">0.67</td>
			</tr>
			<tr>
				<td colspan="3">F</td>
				<td colspan="3" style="border-left: 1px solid #333;">0.00</td>
				<td colspan="3" style="border-left: 1px solid #333;">0.00</td>
				<td colspan="3" style="border-left: 1px solid #333;">0.00</td>
			</tr>
			<tr>
				<td colspan="3">I</td>
				<td colspan="3" style="border-left: 1px solid #333;">0.00</td>
				<td colspan="3" style="border-left: 1px solid #333;">0.00</td>
				<td colspan="3" style="border-left: 1px solid #333;">0.00</td>
			</tr>
		</tbody>
	</table>
	<div class="second-bottom">
		<h4>OFFICIAL SCHOOL USE</h4>
		<p><span>Cum Unweighted GPA: 3.9</span> <span>Cum Weighted GPA: 4.2</span> <span>Cum Credits: 87</span> <span>Issue Date: 09/26/2024</span></p>
		<em>EffectiveSeptember 1, 2024, this is the authorized transcript format. Any discrepancies indicate unauthorized alterations</em>
	</div>
</div>
</body>
</html>