<?php

namespace App\Models;

use App\Models\HealthHistoryModel;
use App\Models\UserHealthModel;
use CodeIgniter\Model;
use Throwable;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'prenom', 'email', 'password', 'date_naissance', 'genre', 'role_id', 'est_gold', 'gold_expires_at'];
    protected $useTimestamps = true;
    protected $returnType = 'array';

    protected $validationRules = [
        'nom' => 'required|max_length[100]',
        'prenom' => 'required|max_length[100]',
        'email' => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[6]',
        'date_naissance' => 'required|valid_date',
        'genre' => 'required|in_list[M,F,Autre]',
        'role_id' => 'required|integer',
    ];

    protected $validationMessages = [
        'nom' => [
            'required' => 'Le nom est requis.',
            'max_length' => 'Le nom ne doit pas dépasser 100 caractères.',
        ],
        'prenom' => [
            'required' => 'Le prénom est requis.',
            'max_length' => 'Le prénom ne doit pas dépasser 100 caractères.',
        ],
        'email' => [
            'required' => 'L\'email est requis.',
            'valid_email' => 'L\'email n\'est pas valide.',
            'is_unique' => 'Cet email est déjà utilisé.',
        ],
        'password' => [
            'required' => 'Le mot de passe est requis.',
            'min_length' => 'Le mot de passe doit faire au moins 6 caractères.',
        ],
        'date_naissance' => [
            'required' => 'La date de naissance est requise.',
            'valid_date' => 'La date de naissance n\'est pas valide.',
        ],
        'genre' => [
            'required' => 'Le genre est requis.',
            'in_list' => 'Le genre doit être M, F ou Autre.',
        ],
        'role_id' => [
            'required' => 'Le rôle est requis.',
            'integer' => 'Le rôle doit être un nombre entier.',
        ],
    ];

    public function getUserWithRole($id)
    {
        return $this->select('users.*, role.nom_role')
                    ->join('role', 'users.role_id = role.id')
                    ->where('users.id', $id)
                    ->first();
    }

    public function getUserByEmail(string $email): ?array
    {
        $user = $this->where('email', $email)->first();

        return $user ?: null;
    }

    public function refreshGoldStatus(int $userId): bool
    {
        $user = $this->find($userId);
        if (! $user) {
            return false;
        }

        $isGold = (bool) ($user['est_gold'] ?? false);
        if (! $isGold) {
            return false;
        }

        $expiresAt = $user['gold_expires_at'] ?? null;
        if ($expiresAt === null || $expiresAt === '') {
            return true;
        }

        $now = date('Y-m-d H:i:s');
        if ($expiresAt < $now) {
            $this->update($userId, ['est_gold' => 0, 'gold_expires_at' => null]);
            return false;
        }

        return true;
    }

    public function getProfile(int $userId, ?bool $isGold = null): ?array
    {
        $account = $this->find($userId);

        if (! $account) {
            return null;
        }

        $userHealthModel = new UserHealthModel();
        $health = $userHealthModel->getByUserId($userId);

        return [
            'account' => $account,
            'health'  => $health,
            'user'    => $this->buildProfileSummary($account, $health, $isGold),
        ];
    }

    public function profileValidationRules(int $userId): array
    {
        return [
            'nom'              => 'required|max_length[100]',
            'prenom'           => 'required|max_length[100]',
            'email'            => 'required|valid_email|is_unique[users.email,id,' . $userId . ']',
            'genre'            => 'required|in_list[M,F,Autre]',
            'date_naissance'   => 'required|valid_date',
            'taille'           => 'required|numeric|greater_than[0]',
            'poids'            => 'required|numeric|greater_than[0]',
            'password'         => 'permit_empty|min_length[6]',
            'password_confirm' => 'permit_empty|matches[password]',
        ];
    }

    public function profileValidationMessages(): array
    {
        return [
            'nom' => [
                'required'   => 'Le nom est requis.',
                'max_length' => 'Le nom ne doit pas dépasser 100 caractères.',
            ],
            'prenom' => [
                'required'   => 'Le prénom est requis.',
                'max_length' => 'Le prénom ne doit pas dépasser 100 caractères.',
            ],
            'email' => [
                'required'    => 'L\'email est requis.',
                'valid_email' => 'L\'email n\'est pas valide.',
                'is_unique'   => 'Cet email est déjà utilisé.',
            ],
            'genre' => [
                'required' => 'Le genre est requis.',
                'in_list'  => 'Le genre doit être M, F ou Autre.',
            ],
            'date_naissance' => [
                'required'   => 'La date de naissance est requise.',
                'valid_date' => 'La date de naissance n\'est pas valide.',
            ],
            'taille' => [
                'required'     => 'La taille est requise.',
                'numeric'      => 'La taille doit être un nombre.',
                'greater_than' => 'La taille doit être supérieure à zéro.',
            ],
            'poids' => [
                'required'     => 'Le poids est requis.',
                'numeric'      => 'Le poids doit être un nombre.',
                'greater_than' => 'Le poids doit être supérieur à zéro.',
            ],
            'password' => [
                'min_length' => 'Le mot de passe doit faire au moins 6 caractères.',
            ],
            'password_confirm' => [
                'matches' => 'La confirmation ne correspond pas au mot de passe.',
            ],
        ];
    }

    public function updateProfile(int $userId, array $userData, array $healthData): bool
    {
        $this->db->transBegin();

        try {
            if ($this->skipValidation(true)->update($userId, $userData) === false) {
                return $this->rollbackProfileUpdate();
            }

            $healthPayload = array_merge($healthData, ['user_id' => $userId]);
            $userHealthModel = new UserHealthModel();
            $healthHistoryModel = new HealthHistoryModel();
            $currentHealth = $userHealthModel->getByUserId($userId);
            $healthChanged = $this->healthChanged($currentHealth, $healthPayload);
            $healthSaved = $currentHealth
                ? $userHealthModel->skipValidation(true)->update((int) $currentHealth['id'], $healthPayload)
                : $userHealthModel->skipValidation(true)->insert($healthPayload);

            if ($healthSaved === false) {
                return $this->rollbackProfileUpdate();
            }

            if ($healthChanged && $healthHistoryModel->skipValidation(true)->insert($healthPayload) === false) {
                return $this->rollbackProfileUpdate();
            }

            if ($this->db->transStatus() === false) {
                return $this->rollbackProfileUpdate();
            }

            $this->db->transCommit();
            $this->skipValidation(false);

            return true;
        } catch (Throwable) {
            return $this->rollbackProfileUpdate();
        }
    }

    public function createUserWithHealth(array $userData, array $healthData): ?int
    {
        $this->db->transBegin();

        $this->insert($userData);
        $userId = (int) $this->getInsertID();

        if ($userId <= 0) {
            $this->db->transRollback();

            return null;
        }

        $healthPayload = array_merge($healthData, ['user_id' => $userId]);

        $userHealthModel = new UserHealthModel();
        $healthHistoryModel = new HealthHistoryModel();

        $userHealthModel->insert($healthPayload);
        $healthHistoryModel->insert($healthPayload);

        if ($this->db->transStatus() === false) {
            $this->db->transRollback();

            return null;
        }

        $this->db->transCommit();

        return $userId;
    }

    private function healthChanged(?array $currentHealth, array $healthPayload): bool
    {
        return ! $currentHealth
            || abs((float) $currentHealth['taille'] - (float) $healthPayload['taille']) > 0.001
            || abs((float) $currentHealth['poids'] - (float) $healthPayload['poids']) > 0.001;
    }

    private function rollbackProfileUpdate(): bool
    {
        $this->skipValidation(false);
        $this->db->transRollback();

        return false;
    }

    private function buildProfileSummary(array $account, ?array $health, ?bool $isGold = null): array
    {
        $taille = isset($health['taille']) ? (float) $health['taille'] : null;
        $poids = isset($health['poids']) ? (float) $health['poids'] : null;
        $imc = $this->calculateImc($taille, $poids);

        return [
            'name'   => trim((string) $account['prenom'] . ' ' . (string) $account['nom']) ?: 'Utilisateur',
            'goal'   => 'Atteindre mon IMC ideal',
            'imc'    => $imc !== null ? number_format($imc, 1, '.', '') : '--',
            'gender' => $this->formatGender((string) ($account['genre'] ?? '')),
            'height' => $taille !== null ? $this->formatMeasurement($taille) . ' cm' : '--',
            'weight' => $poids !== null ? $this->formatMeasurement($poids) . ' kg' : '--',
            'gold'   => $isGold ?? (bool) ($account['est_gold'] ?? false),
        ];
    }

    private function calculateImc(?float $tailleCm, ?float $poidsKg): ?float
    {
        if ($tailleCm === null || $poidsKg === null || $tailleCm <= 0 || $poidsKg <= 0) {
            return null;
        }

        $tailleM = $tailleCm / 100;

        return $poidsKg / ($tailleM * $tailleM);
    }

    private function formatGender(string $gender): string
    {
        return match ($gender) {
            'M' => 'Homme',
            'F' => 'Femme',
            'Autre' => 'Autre',
            default => '--',
        };
    }

    private function formatMeasurement(float $value): string
    {
        return rtrim(rtrim(number_format($value, 2, '.', ''), '0'), '.');
    }

}
