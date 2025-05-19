<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityReport;
use App\Models\ActivityReportTache;
use App\Models\Agent;
use App\Models\Site;
use App\Models\Tache;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Create new user
     * @param Request $request
     * @return JsonResponse
    */
    public function createUser(Request $request): JsonResponse
    {

        try {
            $data = $request->validate([
                'name' => 'required|string',
                'password' => 'required|string',
                'role'=>'required|string',
            ]);
            $user=User::updateOrCreate(
                ['name'=>$data['name']],
                [
                'name'=>$data['name'],
                'password'=>bcrypt($data['password']),
                'role'=>$data['role'],
                'state'=>'allowed',
            ]);
            return response()->json([
                'status' => 'success',
                'result' => $user,
            ]);
        }
        catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return response()->json(['errors' => $errors ]);
        }
        catch (\Illuminate\Database\QueryException $e){
            return response()->json(['errors' => $e->getMessage() ]);
        }

    }

    /**
     * view all clients
     * @return JsonResponse
    */
    public function allUser():JsonResponse
    {
        $users = User::where('state', 'allowed')->get();
        return response()->json([
            "users"=>$users
        ]);
    }

// 1. Lister les agents
    public function listAgents(): JsonResponse
    {
        return response()->json([
            "status" => "success",
            "result" => Agent::all()
        ]);
    }

    // 2. Lister les sites
    public function listSites(): JsonResponse
    {
        return response()->json([
            "status" => "success",
            "result" => Site::all()
        ]);
    }

    // 3. Lister les activités
    public function listActivities(): JsonResponse
    {
        return response()->json([
            "status" => "success",
            "result" => Activity::with('site')->get()
        ]);
    }

    // 4. Lister les tâches
    public function listTaches(): JsonResponse
    {
        return response()->json([
            "status" => "success",
            "result" => Tache::with(['agent', 'activite'])->get()
        ]);
    }

    // 5. Lister les rapports d'activités avec rapport des tâches
    public function listActivityReports(): JsonResponse
    {
        $reports = ActivityReport::with([
            'agent',
            'site',
            'activity',
            'taches' => function ($query) {
                $query->with('tache');
            }
        ])->get();

        return response()->json([
            "status" => "success",
            "result" => $reports
        ]);
    }

    // 6. Créer ou mettre à jour un agent
    public function saveAgent(Request $request): JsonResponse
    {
        $data = $request->validate([
            'nom' => 'required|string',
            'matricule' => 'required|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        $agent = Agent::updateOrCreate(
            ['matricule' => $data['matricule']],
            $data
        );

        return response()->json(['status' => 'success', 'result' => $agent]);
    }

    // 7. Créer ou mettre à jour un site
    public function saveSite(Request $request): JsonResponse
    {
        $data = $request->validate([
            'libelle' => 'required|string',
            'adresse' => 'required|string',
            'latlng' => 'required|string',
        ]);

        $site = Site::updateOrCreate(
            ['libelle' => $data['libelle']],
            $data
        );

        return response()->json(['status' => 'success', 'result' => $site]);
    }

    // 8. Créer une activité
    public function createActivity(Request $request): JsonResponse
    {
        $data = $request->validate([
            'titre' => 'required|string',
            'description' => 'required|string',
            'date' => 'nullable|date',
            'site_id' => 'required|exists:sites,id',
        ]);

        $activity = Activity::create($data);
        return response()->json(['status' => 'success', 'result' => $activity]);
    }

    // 9. Créer une tâche
    public function createTache(Request $request): JsonResponse
    {
        $data = $request->validate([
            'libelle' => 'required|string',
            'description' => 'nullable|string',
            'activite_id' => 'nullable|exists:activities,id',
            'agent_id' => 'required|exists:agents,id',
            'status' => 'nullable|string',
        ]);

        $tache = Tache::create($data);
        return response()->json(['status' => 'success', 'result' => $tache]);
    }

    // 10. Créer un rapport d'activité (début)
    public function startActivityReport(Request $request): JsonResponse
    {
        $data = $request->validate([
            'agent_id' => 'required|exists:agents,id',
            'activity_id' => 'required|exists:activities,id',
            'site_id' => 'nullable|exists:sites,id',
            'latlng' => 'nullable|string',
            'date' => 'nullable|date',
            'commentaire' => 'nullable|string',
        ]);

        $report = ActivityReport::create($data);
        return response()->json(['status' => 'success', 'result' => $report]);
    }

    // 11. Clôturer un rapport d'activité
    public function endActivityReport(Request $request, $id): JsonResponse
    {
        $report = ActivityReport::findOrFail($id);

        $data = $request->validate([
            'latlng' => 'nullable|string',
            'commentaire' => 'nullable|string',
            'status' => 'required|in:completed',
        ]);

        $report->update($data);

        return response()->json(['status' => 'success', 'result' => $report]);
    }

    // 12. Ajouter une tâche à un rapport
    public function attachTacheToReport(Request $request): JsonResponse
    {
        $data = $request->validate([
            'report_id' => 'required|exists:activity_reports,id',
            'tache_id' => 'required|exists:taches,id',
            'status' => 'nullable|string',
            'commentaire' => 'nullable|string',
        ]);

        $reportTache = ActivityReportTache::create($data);
        return response()->json(['status' => 'success', 'result' => $reportTache]);
    }

    // 13. Mettre à jour le statut d'une tâche liée à un rapport
    public function updateTacheReport(Request $request, $id): JsonResponse
    {
        $data = $request->validate([
            'status' => 'required|in:pending,completed',
            'commentaire' => 'nullable|string',
        ]);

        $reportTache = ActivityReportTache::findOrFail($id);
        $reportTache->update($data);

        return response()->json(['status' => 'success', 'result' => $reportTache]);
    }
}