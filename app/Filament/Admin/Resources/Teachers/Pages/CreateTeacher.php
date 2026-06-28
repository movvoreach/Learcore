<?php

namespace App\Filament\Admin\Resources\Teachers\Pages;

use App\Filament\Admin\Resources\Teachers\TeacherResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class CreateTeacher extends CreateRecord
{
    protected static string $resource = TeacherResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        return DB::transaction(function () use ($data): Model {
            $password = $data['account_password'];
            unset($data['account_password']);

            $user = User::query()->create([
                'name' => trim($data['first_name'].' '.($data['last_name'] ?? '')),
                'email' => $data['email'],
                'password' => $password,
            ]);

            $teacherRole = Role::findOrCreate('teacher', 'web');
            $user->syncRoles([$teacherRole]);

            $data['user_id'] = $user->id;

            return static::getModel()::create($data);
        });
    }
protected function getCancelFormAction(): \Filament\Actions\Action
    {
        return parent::getCancelFormAction()
            ->label('ត្រឡប់');
    }
}