<?php

namespace App\Http\Controllers\Modules\Permission;

use App\Http\Controllers\Controller;
use App\Models\Permission;

class MethodController extends Controller
{
    /**
     * Verify if doctor has permission to access specific record type for a patient
     */
    public function verifyRecordPermission($doctorId, $patientId, $recordType)
    {
        $permission = Permission::where('doctor_id', $doctorId)
            ->where('patient_id', $patientId)
            ->where('status', 'Active')
            ->where(function($query) {
                $query->whereNull('expiry_date')
                      ->orWhere('expiry_date', '>=', now());
            })
            ->first();
        
        if (!$permission) {
            abort(403, 'You do not have permission to access this record.');
        }
        
        $scope = $permission->permission_scope ?? [];
        
        if (!$this->hasPermissionScope($scope, $recordType)) {
            abort(403, 'You do not have permission to access this type of record.');
        }
        
        return true;
    }

    /**
     * Check if permission scope allows access to a specific record type
     */
    public function hasPermissionScope($scope, $type)
    {
        // If scope is empty or null, deny access
        if (empty($scope)) {
            return false;
        }
        
        // If scope contains 'all', grant access to everything
        if (in_array('all', $scope)) {
            return true;
        }
        
        // Check if specific type is in scope
        return in_array($type, $scope);
    }
}
