<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use App\Models\SurveyModel;


class AdminController extends BaseController
{
    private function isSessionActive(): bool
    {
        $session = session();
        return $session->has('logged_in') && $session->get('logged_in') === true && $session->has('active') && $session->get('active') === true;
    }

    private function hasRole($requiredRole): bool
    {
        $session = session();
        return $session->has('role') && $session->get('role') === $requiredRole;
    }

    private function authorize($requiredRole): bool
    {
        return $this->isSessionActive() && $this->hasRole($requiredRole);
    }

    private function redirectUnauthorized(): RedirectResponse
    {
        return redirect()->to('/')->with('error', 'Access denied');
    }

    public function HolidayAdminDashboard()
    {
        if (!$this->authorize('super_admin')) {
            return $this->redirectUnauthorized();
        }
    
        $surveyModel = new SurveyModel();
        $db = \Config\Database::connect();
        $data = [];
    
        // Fetch general data
        $data['total_responses'] = $surveyModel->countAllResults();
        $data['avg_age'] = $this->getAverageAge($surveyModel);
        $data['interested_in_income'] = $surveyModel->where('additional_income', 'Yes')->countAllResults();
    
        // Fetch data for house type chart
        list($data['house_types'], $data['house_counts'], $data['house_percentages']) = $this->getHouseTypeData($surveyModel, $data['total_responses']);
    
        // Fetch data for additional income interest chart
        list($data['income_interest_labels'], $data['income_interest_counts']) = $this->getIncomeInterestData($surveyModel);
    
        // Fetch gender data
        list($data['male_count'], $data['female_count'], $data['other_count'], $data['male_percentage'], $data['female_percentage'], $data['other_percentage']) = $this->getGenderData($surveyModel, $data['total_responses']);

        list($data['gender_labels'], $data['gender_counts']) = $this->getGenderChartData($surveyModel);

    
        // Fetch recent entries count
        $data['recent_entries_count'] = $surveyModel->where('created_at >=', date('Y-m-d H:i:s', strtotime('-1 day')))->countAllResults();
    
        // Fetch most interested districts
        $data['interested_districts'] = $this->getInterestedDistricts($surveyModel);
    
        // Example of current online users, assuming it comes from another source
        $data['current_online'] = 80;
    
        // Pagination settings
        $perPage = 5; // Number of entries per page
        $page = $this->request->getVar('page') ?: 1; // Get the current page or default to 1
    
        // Fetch recent survey entries as activities with pagination
        $recentActivities = $surveyModel->orderBy('created_at', 'DESC')
                                        ->paginate($perPage, 'default', $page);
    
        // Fetch most interested districts with pagination
        $interestedDistricts = $surveyModel->select('interested_district, COUNT(*) as count')
                                           ->groupBy('interested_district')
                                           ->orderBy('count', 'DESC')
                                           ->paginate($perPage, 'districts', $page);
    
        $pager = $surveyModel->pager;
    
        $data['recent_activities'] = $recentActivities;
        $data['interested_districts'] = $interestedDistricts;
        $data['pager'] = $pager;
        $data['current_page'] = $page;
        $data['recent_entries_count'] = $surveyModel->where('created_at >=', date('Y-m-d H:i:s', strtotime('-1 day')))->countAllResults();
        $data['per_page'] = $perPage;
    
        // Fetch data from the database with corrected syntax
        $data['villaSessions'] = $surveyModel->where('house_type', 'Villa')->countAllResults();
        $data['farmHouseSessions'] = $surveyModel->where('house_type', 'Farm House')->countAllResults();
        $data['resortSessions'] = $surveyModel->where('resort_type IS NOT NULL', null, false)->countAllResults();
        $data['anyOtherSessions'] = $surveyModel->whereNotIn('house_type', ['Villa', 'Farm House'])->countAllResults();
    
        // Simulating previous period data for demonstration
        $data['prevVillaSessions'] = ['sessions' => 56, 'percentage' => 28];
        $data['prevFarmHouseSessions'] = ['sessions' => 98, 'percentage' => 37];
        $data['prevResortSessions'] = ['sessions' => 45, 'percentage' => 22];
        $data['prevAnyOtherSessions'] = ['sessions' => 25, 'percentage' => 13];
    
        // Fetch demographic data from the existing table
        $data['demographics'] = $this->getDemographics($db);
    
        // Load header and dashboard views
        echo view('holidaycity/admin_header');
        echo view('holidaycity/admin_dashboard', $data);
    }

    private function getDemographics($surveyModel)
    {
        $db = \Config\Database::connect();

        // Query to get gender distribution
        $genderQuery = $db->query("
            SELECT 
                gender AS category,
                COUNT(*) AS count,
                (COUNT(*) * 100 / (SELECT COUNT(*) FROM survey_responses)) AS percentage
            FROM survey_responses
            GROUP BY gender
        ");

        // Query to get age distribution
        $ageQuery = $db->query("
            SELECT 
                CASE 
                    WHEN age BETWEEN 18 AND 25 THEN '18-25 Age Group' 
                    WHEN age BETWEEN 26 AND 35 THEN '26-35 Age Group' 
                    ELSE 'Other Age Group'
                END AS category,
                COUNT(*) AS count,
                (COUNT(*) * 100 / (SELECT COUNT(*) FROM survey_responses)) AS percentage
            FROM survey_responses
            GROUP BY category
        ");

        return array_merge($genderQuery->getResultArray(), $ageQuery->getResultArray());
    }
    
    private function getAverageAge($surveyModel)
    {
        $avgAgeData = $surveyModel->select('AVG(age) as avg_age')->first();
        return $avgAgeData ? round($avgAgeData['avg_age'], 2) : 'N/A';
    }
    
    private function getHouseTypeData($surveyModel, $totalResponses)
    {
        $houseTypeData = $surveyModel->select('house_type, COUNT(*) as count')
                                     ->groupBy('house_type')
                                     ->findAll();
    
        $houseTypes = ['Villa', 'Farm house', 'Resort', 'Any Other'];
        $houseCounts = array_fill(0, count($houseTypes), 0);
    
        foreach ($houseTypeData as $houseData) {
            switch ($houseData['house_type']) {
                case 'Villa':
                    $houseCounts[0] += $houseData['count'];
                    break;
                case 'Farm house':
                    $houseCounts[1] += $houseData['count'];
                    break;
                case 'Resort':
                    $houseCounts[2] += $houseData['count'];
                    break;
                default:
                    $houseCounts[3] += $houseData['count'];
                    break;
            }
        }
    
        $housePercentages = array_map(function($count) use ($totalResponses) {
            return $totalResponses > 0 ? round(($count / $totalResponses) * 100, 2) : 0;
        }, $houseCounts);
    
        return [$houseTypes, $houseCounts, $housePercentages];
    }
    
    private function getIncomeInterestData($surveyModel)
    {
        $incomeInterestData = $surveyModel->select('additional_income, COUNT(*) as count')
                                          ->groupBy('additional_income')
                                          ->findAll();
    
        $incomeInterestLabels = [];
        $incomeInterestCounts = [];
        foreach ($incomeInterestData as $incomeData) {
            $incomeInterestLabels[] = $incomeData['additional_income'];
            $incomeInterestCounts[] = $incomeData['count'];
        }
    
        return [$incomeInterestLabels, $incomeInterestCounts];
    }
    
    private function getGenderData($surveyModel, $totalResponses)
    {
        $maleCount = $surveyModel->where('gender', 'Male')->countAllResults();
        $femaleCount = $surveyModel->where('gender', 'Female')->countAllResults();
        $otherCount = $surveyModel->where('gender', 'Other')->countAllResults();
    
        $malePercentage = $totalResponses > 0 ? round(($maleCount / $totalResponses) * 100, 2) : 0;
        $femalePercentage = $totalResponses > 0 ? round(($femaleCount / $totalResponses) * 100, 2) : 0;
        $otherPercentage = $totalResponses > 0 ? round(($otherCount / $totalResponses) * 100, 2) : 0;
    
        return [$maleCount, $femaleCount, $otherCount, $malePercentage, $femalePercentage, $otherPercentage];
    }
    
    private function getInterestedDistricts($surveyModel)
    {
        return $surveyModel->select('interested_district, COUNT(*) as count')
                           ->groupBy('interested_district')
                           ->orderBy('count', 'DESC')
                           ->findAll(4); // Fetch top 4 interested districts
    }

    public function HealthcareAdminDashboard()
    {
        if ($this->authorize('super_admin')) {
            return view('healthcare/admin_dashboard');
        } else {
            return $this->redirectUnauthorized();
        }
    }

    private function getGenderChartData($surveyModel)
    {
        $genderData = $surveyModel->select('gender, COUNT(*) as count')
                                ->groupBy('gender')
                                ->findAll();

        $genderLabels = [];
        $genderCounts = [];
        foreach ($genderData as $gender) {
            $genderLabels[] = $gender['gender'];
            $genderCounts[] = $gender['count'];
        }

        return [$genderLabels, $genderCounts];
    }
}