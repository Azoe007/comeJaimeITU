<?php

namespace App\Controllers;

use App\Models\ObjectifHistoryModel;
use App\Models\ProgrammeModel;
use App\Models\TransactionModel;

class MonObjectifController extends BaseController
{
    protected ObjectifHistoryModel $objectifHistoryModel;
    protected ProgrammeModel $programmeModel;
    protected TransactionModel $transactionModel;

    public function __construct()
    {
        $this->objectifHistoryModel = new ObjectifHistoryModel();
        $this->programmeModel = new ProgrammeModel();
        $this->transactionModel = new TransactionModel();
    }

    public function index()
    {
        $userId = (int) session('user_id');

        if ($userId <= 0) {
            return redirect()->to(base_url('login'))->with('error', 'Veuillez vous connecter pour consulter votre objectif.');
        }

        $currentObjectif = $this->objectifHistoryModel->latestForUser($userId);
        $latestProgramme = $this->programmeModel->where('id_user', $userId)->orderBy('created_at', 'DESC')->first();
        $latestTransaction = $this->transactionModel->where('id_user', $userId)->orderBy('created_at', 'DESC')->first();

        return view('objectif/current', [
            'pageTitle' => 'Mon objectif - Health Coach',
            'currentObjectif' => $currentObjectif,
            'latestProgramme' => $latestProgramme,
            'latestTransaction' => $latestTransaction,
        ]);
    }
}
