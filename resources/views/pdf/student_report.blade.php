<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transcript</title>
<style>
* {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
		font-size: 10px;
    line-height: 1.2;
}
.mainTableFirst {
    background: url({{ public_path('script-bg.png') }}) no-repeat;
    background-size: cover;
    padding: 70px 70px 30px;
}
.column:nth-child(2), .columns:nth-child(2) {
    padding-left: 5%;
}
.column:nth-child(1), .columns:nth-child(1) {
    padding-right: 5%;
}
.mainTableSecond {
    background: url({{ public_path('secondBG.png') }}) no-repeat;
    background-size: cover;
    padding: 50px 70px;
    color: #295293;
    background-position: center;
	}
	.pdfHead {
    vertical-align: middle;
    padding: 0 30px;
}
.pdfHead .headImg {
    float: left;
    margin-right: 4%;
    width: 20%;
}
.pdfHead .headImg img {
    width: 100px;
}
.headTxt {
    width: 76%;
    float: right;
}
.headTxt h2 {
    letter-spacing: 1px;
    font-weight: 400;
    font-size: 22px;
    margin-bottom: 12px;
}
p {
    font-size: 10px;
    line-height: 1.4;
}
.pdfsubhead {
    clear: both;
    padding-top: 10px;
	}
.tabletwo {
	clear: both;
}
.column {
   float: left;
    width: 45%;
}
.pdfmain {
    border: 2px solid #000000;
    clear: both;
}
.mainCol {
    height: 570px;
    min-height: 570px;
    max-height: 570px; 
    clear: both;
    padding: 30px 20px;
}
.mainCol .column {
    height: 325px;
    min-height: 325px;
    max-height: 325px;
}
.mainTableSecond p {
    font-size: 10px;
    line-height: 1.5;
}
.secondHead {
    color: #295293;
}
</style> 
</head>
<body>
<div class="mainTableFirst">
    <div class="mainTable">
        <div class="pdfHead">
            <div class="headImg"><img src="{{ public_path('script-logo.png') }}"></div>
            <div class="headTxt">
		<h2>ELITE PREPARATORY ACADEMY</h2>
                <p>Office of the Registrar <br>
                    452 Lakeside Blvd <br>
                    Hopatcong, NJ 07843 <br>
                    Phone: (732)397-7988 <br>
                Email: contact@eliteprepacademy.org</p>
            </div>
	</div>

        <div class="pdfsubhead">
            <table width="100%" style="border-top: 2px solid #000000; padding: 10px 0;">
                <tbody>
                    <tr>
                        <td>Name: {{ $student->name }}</td>
                        <td>Date of Birth: {{ $student->dob }}</td>
                        <td>Guardian: {{ $student->father_name ?? 'N/A' }}</td>
			</tr>
			<tr>
                        <td>Address: {{ $student->address ?? 'N/A' }}</td>
                        <td>Gender: {{ $student->gender ?? 'N/A' }}</td>
                        <td>Counselor: {{ $student->counselor ?? 'N/A' }}</td>
			</tr>
                    <tr>
                        <td></td>
                        <td>Date of Graduation: {{ $student->graduation_date ?? 'N/A' }}</td>
                        <td></td>
			</tr>
		</tbody>
	</table>
        </div>

        <div class="pdfmain" >
            <table width="100%">
                <tbody>
                    <tr>
                        <td colspan="2" style="text-align: center; font-size: 10px; padding: 20px 0 0;">ACADEMIC RECORD</td>
                    </tr>
                </tbody>
            </table>
	
            <div class="tabletwo mainCol">
                @php
                    // Group academic records by grade level
                    $gradeLevels = ['9th', '10th', '11th', '12th'];
                    $gradeData = [];
                    
                    foreach ($gradeLevels as $grade) {
                        $gradeData[$grade] = $academicRecords->filter(fn($record) => strtolower($record->gradelevel) === strtolower($grade));
                    }
                    
                    // Define grade points for calculations
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

                <!-- First Row: Grade 9 and Grade 10 -->
                <div class="column">
                    @php
                        $grade = '9th';
                        $records = $gradeData[$grade];
                        $totalCreditsAttempted = 0;
                        $totalCreditsAwarded = 0;
                        $totalUnweightedPoints = 0;
                        $totalWeightedPoints = 0;
                        
                        foreach ($records as $record) {
                            $gradeValue = $record->grade;
            $credit = $record->credit;

            $totalCreditsAttempted += $credit;

                            if (!in_array($gradeValue, ['F', 'I'])) {
                $totalCreditsAwarded += $credit;
            }

                            if (isset($gradePoints[$gradeValue])) {
                                $totalUnweightedPoints += $gradePoints[$gradeValue]['unweighted'] * $credit;
                                $totalWeightedPoints += $gradePoints[$gradeValue]['weighted'] * $credit;
                            }
                        }
                        
        $unweightedGPA = $totalCreditsAttempted > 0 ? $totalUnweightedPoints / $totalCreditsAttempted : 0;
        $weightedGPA = $totalCreditsAttempted > 0 ? $totalWeightedPoints / $totalCreditsAttempted : 0;
                        $year = 2021;
                        $nextYear = 2022;
		@endphp
                    <table width="100%">
                        <tbody>
                            <td colspan="12" style="text-align: center; font-size: 10px; padding-bottom: 10px;">Grade {{ $grade }} Year {{ $year }}-{{ $nextYear }}</td>
                            <tr>
                                <td colspan="8" style="text-align: left; font-size: 10px; text-decoration: underline;">Course</td>
                                <td colspan="1" style="text-align: center; font-size: 10px; text-decoration: underline;">Credits</td>
                                <td colspan="1" style="text-align: center; font-size: 10px; text-decoration: underline;">Grade</td>
                            </tr>
                            
                            @forelse($records as $record)
                            <tr>
                                <td colspan="8" style="text-align: left;">{{ $record->coursetitle }}</td>
                                <td colspan="1" style="text-align: center;">{{ $record->credit }}</td>
                                <td colspan="1" style="text-align: center;">{{ $record->grade }}</td>
                            </tr>
                            @empty
                            @for($i = 0; $i < 8; $i++)
                            <tr>
                                <td colspan="8" style="text-align: left;"></td>
                                <td colspan="1" style="text-align: center;"></td>
                                <td colspan="1" style="text-align: center;"></td>
                            </tr>
                            @endfor
                            @endforelse
                            
                            <tr>
                                <td colspan="8" style="text-align: left; padding: 10px;"></td>
                                <td colspan="1" style="text-align: left; padding: 10px;"></td>
                                <td colspan="1" style="text-align: left; padding: 10px;"></td>
                            </tr>
                            <tr>
                                <td colspan="8" style="text-align: left;">Term GPA (unweighted):</td>
                                <td colspan="2" style="text-align: right; padding-right: 25px;">{{ $totalCreditsAttempted > 0 ? number_format($unweightedGPA, 3) : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td colspan="8" style="text-align: left;">Term GPA (weighted):</td>
                                <td colspan="2" style="text-align: right; padding-right: 25px;">{{ $totalCreditsAttempted > 0 ? number_format($weightedGPA, 3) : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td colspan="8" style="text-align: left;">Term Credits:</td>
                                <td colspan="2" style="text-align: right; padding-right: 25px;">{{ $totalCreditsAttempted }}</td>
    </tr>
</tbody>
		</table>
		</div>
		
                <div class="column">
                    @php
                        $grade = '10th';
                        $records = $gradeData[$grade];
        $totalCreditsAttempted = 0;
        $totalCreditsAwarded = 0;
        $totalUnweightedPoints = 0;
        $totalWeightedPoints = 0;

                        foreach ($records as $record) {
                            $gradeValue = $record->grade;
            $credit = $record->credit;

            $totalCreditsAttempted += $credit;

                            if (!in_array($gradeValue, ['F', 'I'])) {
                $totalCreditsAwarded += $credit;
            }

                            if (isset($gradePoints[$gradeValue])) {
                                $totalUnweightedPoints += $gradePoints[$gradeValue]['unweighted'] * $credit;
                                $totalWeightedPoints += $gradePoints[$gradeValue]['weighted'] * $credit;
                            }
                        }
                        
        $unweightedGPA = $totalCreditsAttempted > 0 ? $totalUnweightedPoints / $totalCreditsAttempted : 0;
        $weightedGPA = $totalCreditsAttempted > 0 ? $totalWeightedPoints / $totalCreditsAttempted : 0;
                        $year = 2022;
                        $nextYear = 2023;
  @endphp
                    <table width="100%">
                        <tbody>
                            <td colspan="12" style="text-align: center; font-size: 10px; padding-bottom: 10px;">Grade {{ $grade }} Year {{ $year }}-{{ $nextYear }}</td>
                            <tr>
                                <td colspan="8" style="text-align: left; font-size: 10px; text-decoration: underline;">Course</td>
                                <td colspan="1" style="text-align: center; font-size: 10px; text-decoration: underline;">Credits</td>
                                <td colspan="1" style="text-align: center; font-size: 10px; text-decoration: underline;">Grade</td>
                            </tr>
                            
                            @forelse($records as $record)
                            <tr>
                                <td colspan="8" style="text-align: left;">{{ $record->coursetitle }}</td>
                                <td colspan="1" style="text-align: center;">{{ $record->credit }}</td>
                                <td colspan="1" style="text-align: center;">{{ $record->grade }}</td>
                            </tr>
                            @empty
                            @for($i = 0; $i < 8; $i++)
                            <tr>
                                <td colspan="8" style="text-align: left;"></td>
                                <td colspan="1" style="text-align: center;"></td>
                                <td colspan="1" style="text-align: center;"></td>
                            </tr>
                            @endfor
                            @endforelse
                            
                            <tr>
                                <td colspan="8" style="text-align: left; padding: 10px;"></td>
                                <td colspan="1" style="text-align: left; padding: 10px;"></td>
                                <td colspan="1" style="text-align: left; padding: 10px;"></td>
                            </tr>
                            <tr>
                                <td colspan="8" style="text-align: left;">Term GPA (unweighted):</td>
                                <td colspan="2" style="text-align: right; padding-right: 25px;">{{ $totalCreditsAttempted > 0 ? number_format($unweightedGPA, 3) : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td colspan="8" style="text-align: left;">Term GPA (weighted):</td>
                                <td colspan="2" style="text-align: right; padding-right: 25px;">{{ $totalCreditsAttempted > 0 ? number_format($weightedGPA, 3) : 'N/A' }}</td>
    </tr>
                            <tr>
                                <td colspan="8" style="text-align: left;">Term Credits:</td>
                                <td colspan="2" style="text-align: right; padding-right: 25px;">{{ $totalCreditsAttempted }}</td>
			</tr>
		</tbody>
	</table>
                </div>
<div style="clear: both;"></div>
                <!-- Second Row: Grade 11 and Grade 12 -->
                <div class="columns" style=" width: 45%; float: left; ">
                    @php
                        $grade = '11th';
                        $records = $gradeData[$grade];
        $totalCreditsAttempted = 0;
        $totalCreditsAwarded = 0;
        $totalUnweightedPoints = 0;
        $totalWeightedPoints = 0;

                        foreach ($records as $record) {
                            $gradeValue = $record->grade;
            $credit = $record->credit;

            $totalCreditsAttempted += $credit;

                            if (!in_array($gradeValue, ['F', 'I'])) {
                $totalCreditsAwarded += $credit;
            }

                            if (isset($gradePoints[$gradeValue])) {
                                $totalUnweightedPoints += $gradePoints[$gradeValue]['unweighted'] * $credit;
                                $totalWeightedPoints += $gradePoints[$gradeValue]['weighted'] * $credit;
                            }
                        }
                        
        $unweightedGPA = $totalCreditsAttempted > 0 ? $totalUnweightedPoints / $totalCreditsAttempted : 0;
        $weightedGPA = $totalCreditsAttempted > 0 ? $totalWeightedPoints / $totalCreditsAttempted : 0;
                        $year = 2023;
                        $nextYear = 2024;
    @endphp
                    <table width="100%">
                        <tbody>
                            <td colspan="12" style="text-align: center; font-size: 10px; padding-bottom: 10px;">Grade {{ $grade }} Year {{ $year }}-{{ $nextYear }}</td>
                            <tr>
                                <td colspan="8" style="text-align: left; font-size: 10px; text-decoration: underline;">Course</td>
                                <td colspan="1" style="text-align: center; font-size: 10px; text-decoration: underline;">Credits</td>
                                <td colspan="1" style="text-align: center; font-size: 10px; text-decoration: underline;">Grade</td>
                            </tr>
                            
                            @forelse($records as $record)
                            <tr>
                                <td colspan="8" style="text-align: left;">{{ $record->coursetitle }}</td>
                                <td colspan="1" style="text-align: center;">{{ $record->credit }}</td>
                                <td colspan="1" style="text-align: center;">{{ $record->grade }}</td>
                            </tr>
                            @empty
                            @for($i = 0; $i < 8; $i++)
                            <tr>
                                <td colspan="8" style="text-align: left;"></td>
                                <td colspan="1" style="text-align: center;"></td>
                                <td colspan="1" style="text-align: center;"></td>
                            </tr>
                            @endfor
                            @endforelse
                            
                            <tr>
                                <td colspan="8" style="text-align: left; padding: 10px;"></td>
                                <td colspan="1" style="text-align: left; padding: 10px;"></td>
                                <td colspan="1" style="text-align: left; padding: 10px;"></td>
                            </tr>
                            <tr>
                                <td colspan="8" style="text-align: left;">Term GPA (unweighted):</td>
                                <td colspan="2" style="text-align: right; padding-right: 25px;">{{ $totalCreditsAttempted > 0 ? number_format($unweightedGPA, 3) : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td colspan="8" style="text-align: left;">Term GPA (weighted):</td>
                                <td colspan="2" style="text-align: right; padding-right: 25px;">{{ $totalCreditsAttempted > 0 ? number_format($weightedGPA, 3) : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td colspan="8" style="text-align: left;">Term Credits:</td>
                                <td colspan="2" style="text-align: right; padding-right: 25px;">{{ $totalCreditsAttempted }}</td>
    </tr>
</tbody>
		</table>
		</div>

                <div class="columns" style="width: 45%; float: right;">
                    @php
                        $grade = '12th';
                        $records = $gradeData[$grade];
        $totalCreditsAttempted = 0;
        $totalCreditsAwarded = 0;
        $totalUnweightedPoints = 0;
        $totalWeightedPoints = 0;

                        foreach ($records as $record) {
                            $gradeValue = $record->grade;
            $credit = $record->credit;

            $totalCreditsAttempted += $credit;

                            if (!in_array($gradeValue, ['F', 'I'])) {
                $totalCreditsAwarded += $credit;
            }

                            if (isset($gradePoints[$gradeValue])) {
                                $totalUnweightedPoints += $gradePoints[$gradeValue]['unweighted'] * $credit;
                                $totalWeightedPoints += $gradePoints[$gradeValue]['weighted'] * $credit;
                            }
                        }
                        
        $unweightedGPA = $totalCreditsAttempted > 0 ? $totalUnweightedPoints / $totalCreditsAttempted : 0;
        $weightedGPA = $totalCreditsAttempted > 0 ? $totalWeightedPoints / $totalCreditsAttempted : 0;
                        $year = 2024;
                        $nextYear = 2025;
    @endphp
                    <table width="100%">
                        <tbody>
                            <td colspan="12" style="text-align: center; font-size: 10px; padding-bottom: 10px;">Grade {{ $grade }} Year {{ $year }}-{{ $nextYear }}</td>
                            <tr>
                                <td colspan="8" style="text-align: left; font-size: 10px; text-decoration: underline;">Course</td>
                                <td colspan="1" style="text-align: center; font-size: 10px; text-decoration: underline;">Credits</td>
                                <td colspan="1" style="text-align: center; font-size: 10px; text-decoration: underline;">Grade</td>
                            </tr>
                            
                            @forelse($records as $record)
                            <tr>
                                <td colspan="8" style="text-align: left;">{{ $record->coursetitle }}</td>
                                <td colspan="1" style="text-align: center;">{{ $record->credit }}</td>
                                <td colspan="1" style="text-align: center;">{{ $record->grade }}</td>
                            </tr>
                            @empty
                            @for($i = 0; $i < 8; $i++)
                            <tr>
                                <td colspan="8" style="text-align: left;"></td>
                                <td colspan="1" style="text-align: center;"></td>
                                <td colspan="1" style="text-align: center;"></td>
                            </tr>
                            @endfor
                            @endforelse
                            
                            <tr>
                                <td colspan="8" style="text-align: left; padding: 10px;"></td>
                                <td colspan="1" style="text-align: left; padding: 10px;"></td>
                                <td colspan="1" style="text-align: left; padding: 10px;"></td>
                            </tr>
                            <tr>
                                <td colspan="8" style="text-align: left;">Term GPA (unweighted):</td>
                                <td colspan="2" style="text-align: right; padding-right: 25px;">{{ $totalCreditsAttempted > 0 ? number_format($unweightedGPA, 3) : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td colspan="8" style="text-align: left;">Term GPA (weighted):</td>
                                <td colspan="2" style="text-align: right; padding-right: 25px;">{{ $totalCreditsAttempted > 0 ? number_format($weightedGPA, 3) : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td colspan="8" style="text-align: left;">Term Credits:</td>
                                <td colspan="2" style="text-align: right; padding-right: 25px;">{{ $totalCreditsAttempted }}</td>
    </tr>
</tbody>
		</table>
		</div>
	</div>
</div>

        <div class="pdffirstFooter" style="clear: both; padding: 20px 0 0 ">
            <table width="100%">
                <tbody>
                    <tr>
                        <td colspan="12" style="text-align: center; font-size: 10px;  ">OFFICIAL SCHOOL USE</td>
			</tr>
                </tbody>
	</table>
            <div class="tabletwo">
                <div class="column" style="padding-right:5%; padding-bottom: 30px;">
	<table width="100%">
		<tbody>
                            @php
                                // Calculate cumulative GPAs
                                $cumulativeCreditsAttempted = 0;
                                $cumulativeCreditsAwarded = 0;
                                $cumulativeUnweightedPoints = 0;
                                $cumulativeWeightedPoints = 0;
                                
                                foreach ($academicRecords as $record) {
                                    $gradeValue = $record->grade;
                                    $credit = $record->credit;
                                    
                                    $cumulativeCreditsAttempted += $credit;
                                    
                                    if (!in_array($gradeValue, ['F', 'I'])) {
                                        $cumulativeCreditsAwarded += $credit;
                                    }
                                    
                                    if (isset($gradePoints[$gradeValue])) {
                                        $cumulativeUnweightedPoints += $gradePoints[$gradeValue]['unweighted'] * $credit;
                                        $cumulativeWeightedPoints += $gradePoints[$gradeValue]['weighted'] * $credit;
                                    }
                                }
                                
                                $cumulativeUnweightedGPA = $cumulativeCreditsAttempted > 0 ? $cumulativeUnweightedPoints / $cumulativeCreditsAttempted : 0;
                                $cumulativeWeightedGPA = $cumulativeCreditsAttempted > 0 ? $cumulativeWeightedPoints / $cumulativeCreditsAttempted : 0;
                            @endphp
                            <tr>
                                <td colspan="8" style="text-align: left; font-size: 10px;">Cum GPA (unweighted): </td>
                                <td colspan="2" style="text-align: right; font-size: 10px;">{{ number_format($cumulativeUnweightedGPA, 3) }}</td>
			</tr>
			<tr>
                                <td colspan="8" style="text-align: left; font-size: 10px;">Cum GPA (weighted): </td>
                                <td colspan="2" style="text-align: right; font-size: 10px;">{{ number_format($cumulativeWeightedGPA, 3) }}</td>
			</tr>
			<tr>
                                <td colspan="8" style="text-align: left; font-size: 10px;">Cum Credits: </td>
                                <td colspan="2" style="text-align: right; font-size: 10px;">{{ $cumulativeCreditsAttempted }}</td>
			</tr>
			<tr>
                                <td colspan="8" style="text-align: left; font-size: 10px;">Issue Date: </td>
                                <td colspan="2" style="text-align: right; font-size: 10px;">{{ date('m/d/Y') }}</td>
			</tr>
                        </tbody>
                    </table>
                </div>
                <div class="column" style="padding-left:5%;">
                    <div class="signatureImg" style="text-align: center;">
                        <img src="{{ public_path('script-sign.png') }}" style="width: 120px;">
                        <p class="signaturetxt" style="border-top: 2px solid #000000;">Registrar</p>
                    </div>
                </div>
            </div>
            <p class="bottomLast" style="text-align: center; clear: both; color: red; padding-top: 30px; font-size: 10px; letter-spacing: 0.5px;">Effective September 1, 2023, this is the authorized transcript format. Any discrepancies indicate unauthorized alterations.</p>
        </div>
    </div>
</div>
<div class="mainTableSecond">
    <div class="secondHead">
        <h3 style="text-align: center; font-size: 20px; padding-bottom: 20px;">TRANSCRIPT KEY</h3>
        <p>Office of the Registrar <br>
            452 Lakeside Blvd <br>
            Hopatcong, NJ 07843 <br>
             Phone: (732)397-7988 <br>
            Email: contact@eliteprepacademy.org</p>
    </div>
    <div class="pdfsecondTable" style="padding: 2% 0 0 8%;">
        <table width="100%" text-align: left; padding: 10px;>
            <tbody>
                <tr>
                    <td colspan="6" style="text-align: center; font-weight: 600; font-size: 10px;">Grading System</td>
                    <td colspan="6" style="text-align: center; font-weight: 600; font-size: 10px;">Grade Points</td>
			</tr>
			<tr>
                    <td colspan="1" style="width: 100px;">A</td>
                    <td colspan="7" style="text-align: left;">-Excellent</td>
                    <td colspan="1" style="text-align: center; text-decoration: underline;">Grade</td>
                    <td colspan="1" style="text-align: center; text-decoration: underline;">Unweighted</td>
                    <td colspan="1" style="text-align: center; text-decoration: underline;">Weighted Honors</td>
                    <td colspan="1" style="text-align: center; text-decoration: underline;">Weighted AP</td>
			</tr>
			<tr>
                    <td colspan="1" style="width: 100px;">B</td>
                    <td colspan="7" style="text-align: left;">-Good</td>
                    <td colspan="1" style="text-align: center;">A+</td>
                    <td colspan="1" style="text-align: center;">4.00</td>
                    <td colspan="1" style="text-align: center;">4.83</td>
                    <td colspan="1" style="text-align: center;">5.33</td>
			</tr>
                <tr>
                    <<td colspan="1" style="width: 100px;">C</td>
                    <td colspan="7" style="text-align: left;">-Fair</td>
                    <td colspan="1" style="text-align: center;">A</td>
                    <td colspan="1" style="text-align: center;">4.00</td>
                    <td colspan="1" style="text-align: center;">4.50</td>
                    <td colspan="1" style="text-align: center;">5.00</td>
			</tr>
                <tr>
                    <td colspan="1" style="width: 100px;">D</td>
                    <td colspan="7" style="text-align: left;">-Barely Passed</td>
                    <td colspan="1" style="text-align: center;">A-</td>
                    <td colspan="1" style="text-align: center;">3.67</td>
                    <td colspan="1" style="text-align: center;">4.17</td>
                    <td colspan="1" style="text-align: center;">4.67</td>
			</tr>
			<tr>
                    <td colspan="1" style="width: 100px;">F</td>
                    <td colspan="7" style="text-align: left;">-Failure</td>
                    <td colspan="1" style="text-align: center;">B+</td>
                    <td colspan="1" style="text-align: center;">3.33</td>
                    <td colspan="1" style="text-align: center;">3.83</td>
                    <td colspan="1" style="text-align: center;">4.33</td>
			</tr>
			<tr>
                    <td colspan="1" style="width: 100px;">I</td>
                    <td colspan="7" style="text-align: left;">-Work incomplete, due to circumstances beyond</td>
                    <td colspan="1" style="text-align: center;">A+</td>
                    <td colspan="1" style="text-align: center;">4.00</td>
                    <td colspan="1" style="text-align: center;">4.83</td>
                    <td colspan="1" style="text-align: center;">5.33</td>
			</tr>
			<tr>
                    <td colspan="1" style="width: 100px;"></td>
                    <td colspan="7" style="text-align: left;">-the student's control, but of passing quality</td>
                    <td colspan="1" style="text-align: center;">A</td>
                    <td colspan="1" style="text-align: center;">4.00</td>
                    <td colspan="1" style="text-align: center;">4.50</td>
                    <td colspan="1" style="text-align: center;">5.00</td>
			</tr>
			<tr>
                    <td colspan="1" style="width: 100px;"></td>
                    <td colspan="7" style="text-align: left;"></td>
                    <td colspan="1" style="text-align: center;">A-</td>
                    <td colspan="1" style="text-align: center;">3.67</td>
                    <td colspan="1" style="text-align: center;">4.17</td>
                    <td colspan="1" style="text-align: center;">4.67</td>
			</tr>
			<tr>
                    <td colspan="8" style="text-align: left;">The grades A, B, C, and D may be modified by plus (+) or minus (-) suffixes.</td>
                    <td colspan="1" style="text-align: center;">B+</td>
                    <td colspan="1" style="text-align: center;">3.33</td>
                    <td colspan="1" style="text-align: center;">3.83</td>
                    <td colspan="1" style="text-align: center;">3.00</td>
			</tr>
			<tr>
                    <td colspan="7" style="text-align: center; font-weight: 600;">Credits Required for Graduation</td>
                    <td colspan="1" style="text-align: center;"></td>
                    <td colspan="1" style="text-align: center;">B</td>
                    <td colspan="1" style="text-align: center;">3.00</td>
                    <td colspan="1" style="text-align: center;">3.50</td>
                    <td colspan="1" style="text-align: center;">4.00</td>
			</tr>
			<tr>
                    <td colspan="4" style="text-align: left;">English</td>
                    <td colspan="3" style="text-align: center;">16 (4 years)</td>
                    <td colspan="1" style="text-align: center;"></td>
                    <td colspan="1" style="text-align: center;">B-</td>
                    <td colspan="1" style="text-align: center;">2.67</td>
                    <td colspan="1" style="text-align: center;">3.17</td>
                    <td colspan="1" style="text-align: center;">3.67</td>
			</tr>
			<tr>
                    <td colspan="4" style="text-align: left;">Social Science</td>
                    <td colspan="3" style="text-align: center;">16 (4 years)</td>
                    <td colspan="1" style="text-align: center;"></td>
                    <td colspan="1" style="text-align: center;">C+</td>
                    <td colspan="1" style="text-align: center;">2.33</td>
                    <td colspan="1" style="text-align: center;">2.33</td>
                    <td colspan="1" style="text-align: center;">2.33</td>
			</tr>
			<tr>
                    <td colspan="4" style="text-align: left;">Mathematics</td>
                    <td colspan="3" style="text-align: center;">16 (4 years)</td>
                    <td colspan="1" style="text-align: center;"></td>
                    <td colspan="1" style="text-align: center;">C</td>
                    <td colspan="1" style="text-align: center;">2.00</td>
                    <td colspan="1" style="text-align: center;">2.00</td>
                    <td colspan="1" style="text-align: center;">2.00</td>
			</tr>
			<tr>
                    <td colspan="4" style="text-align: left;">Science</td>
                    <td colspan="3" style="text-align: center;">16 (4 years)</td>
                    <td colspan="1" style="text-align: center;"></td>
                    <td colspan="1" style="text-align: center;">C-</td>
                    <td colspan="1" style="text-align: center;">1.67</td>
                    <td colspan="1" style="text-align: center;">1.67</td>
                    <td colspan="1" style="text-align: center;">1.67</td>
			</tr>
			<tr>
                    <td colspan="4" style="text-align: left;">Health/Physical Education</td>
                    <td colspan="3" style="text-align: center;">16 (4 years)</td>
                    <td colspan="1" style="text-align: center;"></td>
                    <td colspan="1" style="text-align: center;">D+</td>
                    <td colspan="1" style="text-align: center;">1.33</td>
                    <td colspan="1" style="text-align: center;">1.33</td>
                    <td colspan="1" style="text-align: center;">1.33</td>
			</tr>
			<tr>
                    <td colspan="4" style="text-align: left;">Second Language</td>
                    <td colspan="3" style="text-align: center;">12 (3 years)</td>
                    <td colspan="1" style="text-align: center;"></td>
                    <td colspan="1" style="text-align: center;">D</td>
                    <td colspan="1" style="text-align: center;">1.00</td>
                    <td colspan="1" style="text-align: center;">1.00</td>
                    <td colspan="1" style="text-align: center;">1.00</td>
			</tr>
			<tr>
                    <td colspan="4" style="text-align: left;">Art</td>
                    <td colspan="3" style="text-align: center;">12 (3 years)</td>
                    <td colspan="1" style="text-align: center;"></td>
                    <td colspan="1" style="text-align: center;">D-</td>
                    <td colspan="1" style="text-align: center;">0.67</td>
                    <td colspan="1" style="text-align: center;">0.67</td>
                    <td colspan="1" style="text-align: center;">0.67</td>
			</tr>
            <tr>
                    <td colspan="4" style="text-align: left;">Electives</td>
                    <td colspan="3" style="text-align: center;">16</td>
                    <td colspan="1" style="text-align: center;"></td>
                    <td colspan="1" style="text-align: center;">F</td>
                    <td colspan="1" style="text-align: center;">0.00</td>
                    <td colspan="1" style="text-align: center;">0.00</td>
                    <td colspan="1" style="text-align: center;">0.00</td>
			</tr>
            <tr>
                    <td colspan="4" style="text-align: left;">Research Project</td>
                    <td colspan="3" style="text-align: center;">6</td>
                    <td colspan="1" style="text-align: center;"></td>
                    <td colspan="1" style="text-align: center;">I</td>
                    <td colspan="1" style="text-align: center;">0.00</td>
                    <td colspan="1" style="text-align: center;">0.00</td>
                    <td colspan="1" style="text-align: center;">0.00</td>
			</tr>

		</tbody>
	</table>
	</div>
    <p class="bottomLast" style="text-align: center; clear: both; color: red; padding-top: 50px; font-size: 10px; letter-spacing: 0.5px;">Effective September 1, 2023, this is the authorized transcript format. Any discrepancies indicate unauthorized alterations.</p>
</div>
</body>
</html>