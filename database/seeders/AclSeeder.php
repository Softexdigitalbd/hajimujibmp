<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AclSeeder extends Seeder
{
    public function run(): void
    {
        // ── Permissions ───────────────────────────────────────────────────────
        // Mapped 1-to-1 with route groups so permission names are predictable.
        $permissions = [

            // Complaints
            ['name' => 'complaints.index',         'label' => 'Browse Complaint List',          'group' => 'Complaints'],
            ['name' => 'complaints.show',          'label' => 'View Complaint Details',         'group' => 'Complaints'],
            ['name' => 'complaints.update_status', 'label' => 'Update Complaint Status',        'group' => 'Complaints'],
            ['name' => 'complaints.comment',       'label' => 'Post Comments on Complaints',    'group' => 'Complaints'],
            ['name' => 'complaints.download',      'label' => 'Download Complaint Attachments', 'group' => 'Complaints'],

            // Settings
            ['name' => 'settings.behaviour',   'label' => 'Manage Complaint Behaviour',   'group' => 'Settings'],
            ['name' => 'settings.statuses',    'label' => 'Manage Complaint Statuses',    'group' => 'Settings'],
            ['name' => 'settings.transitions', 'label' => 'Manage Status Transitions',    'group' => 'Settings'],
            ['name' => 'settings.questions',   'label' => 'Manage Form Questions',        'group' => 'Settings'],
            ['name' => 'settings.trash',       'label' => 'View & Restore System Trash',  'group' => 'Settings'],

            // User Management
            ['name' => 'users.view',   'label' => 'View Users List',    'group' => 'User Management'],
            ['name' => 'users.create', 'label' => 'Create New Users',   'group' => 'User Management'],
            ['name' => 'users.edit',   'label' => 'Edit User & Role',   'group' => 'User Management'],
            ['name' => 'users.delete', 'label' => 'Delete Users',       'group' => 'User Management'],

            // Role Management
            ['name' => 'roles.view',   'label' => 'View Roles List',      'group' => 'Role Management'],
            ['name' => 'roles.create', 'label' => 'Create Roles',         'group' => 'Role Management'],
            ['name' => 'roles.edit',   'label' => 'Edit Role Permissions', 'group' => 'Role Management'],
            ['name' => 'roles.delete', 'label' => 'Delete Roles',          'group' => 'Role Management'],
        ];

        foreach ($permissions as $data) {
            Permission::firstOrCreate(['name' => $data['name']], $data);
        }

        // Remove any stale permissions no longer in the list
        $validNames = array_column($permissions, 'name');
        Permission::whereNotIn('name', $validNames)->delete();

        // ── Default Roles ──────────────────────────────────────────────────────

        // 1. Complaint Manager — can view and manage complaints only
        $manager = Role::firstOrCreate(
            ['name' => 'manager'],
            ['label' => 'Complaint Manager', 'description' => 'Can view and manage complaints.']
        );
        $manager->permissions()->sync(
            Permission::whereIn('name', [
                'complaints.index',
                'complaints.show',
                'complaints.update_status',
                'complaints.comment',
                'complaints.download',
            ])->pluck('id')
        );

        // 2. Read-Only Viewer — can only browse the complaint list and view details
        $viewer = Role::firstOrCreate(
            ['name' => 'viewer'],
            ['label' => 'Read-Only Viewer', 'description' => 'Can view complaints only.']
        );
        $viewer->permissions()->sync(
            Permission::whereIn('name', [
                'complaints.index',
                'complaints.show',
            ])->pluck('id')
        );
    }
}
