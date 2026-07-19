<?php

namespace App\Filament\Admin\Resources\Roles;

use App\Filament\Admin\Resources\Roles\Pages\CreateRole;
use App\Filament\Admin\Resources\Roles\Pages\EditRole;
use App\Filament\Admin\Resources\Roles\Pages\ListRoles;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\CheckboxList;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $modelLabel = 'តួនាទី';

    protected static ?string $pluralModelLabel = 'តួនាទី';

    protected static bool $shouldRegisterNavigation = false;

    public static function canAccess(): bool
    {
        $user = auth()->user();
        return $user && ($user->hasRole('super_admin') || $user->can('roles.view'));
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('តួនាទី')
                ->columns(2)
                ->schema([
                    TextInput::make('name')
                        ->label('ឈ្មោះតួនាទី')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),
                    TextInput::make('guard_name')
                        ->label('ឈ្មោះ Guard')
                        ->default('web')
                        ->required()
                        ->maxLength(255),
                ])
                ->columnSpanFull(),

            Section::make('សិទ្ធិអនុញ្ញាត')
                ->columns(2)
                ->schema([
                    CheckboxList::make('users_permissions')
                        ->label('គ្រប់គ្រងអ្នកប្រើប្រាស់ (User Management)')
                        ->options(fn (): array => Permission::whereIn('name', [
                            'users.view', 'users.create', 'users.update', 'users.delete'
                        ])->pluck('name', 'id')->all())
                        ->dehydrated(false)
                        ->afterStateHydrated(fn ($component, $record) => $component->state($record ? $record->permissions->whereIn('name', [
                            'users.view', 'users.create', 'users.update', 'users.delete'
                        ])->pluck('id')->toArray() : [])),

                    CheckboxList::make('roles_permissions')
                        ->label('គ្រប់គ្រងតួនាទី & សិទ្ធិ (Role & Permission Management)')
                        ->options(fn (): array => Permission::whereIn('name', [
                            'roles.view', 'roles.create', 'roles.update', 'roles.delete'
                        ])->pluck('name', 'id')->all())
                        ->dehydrated(false)
                        ->afterStateHydrated(fn ($component, $record) => $component->state($record ? $record->permissions->whereIn('name', [
                            'roles.view', 'roles.create', 'roles.update', 'roles.delete'
                        ])->pluck('id')->toArray() : [])),

                    CheckboxList::make('academic_permissions')
                        ->label('គ្រប់គ្រងការសិក្សា (Academic Structure)')
                        ->options(fn (): array => Permission::whereIn('name', [
                            'academic.view', 'academic.create', 'academic.update', 'academic.delete'
                        ])->pluck('name', 'id')->all())
                        ->dehydrated(false)
                        ->afterStateHydrated(fn ($component, $record) => $component->state($record ? $record->permissions->whereIn('name', [
                            'academic.view', 'academic.create', 'academic.update', 'academic.delete'
                        ])->pluck('id')->toArray() : [])),

                    CheckboxList::make('students_permissions')
                        ->label('គ្រប់គ្រងនិស្សិត (Student Management)')
                        ->options(fn (): array => Permission::whereIn('name', [
                            'students.view', 'students.create', 'students.update', 'students.delete'
                        ])->pluck('name', 'id')->all())
                        ->dehydrated(false)
                        ->afterStateHydrated(fn ($component, $record) => $component->state($record ? $record->permissions->whereIn('name', [
                            'students.view', 'students.create', 'students.update', 'students.delete'
                        ])->pluck('id')->toArray() : [])),

                    CheckboxList::make('courses_permissions')
                        ->label('គ្រប់គ្រងវគ្គសិក្សា (Course Management)')
                        ->options(fn (): array => Permission::whereIn('name', [
                            'courses.view', 'courses.create', 'courses.update', 'courses.delete'
                        ])->pluck('name', 'id')->all())
                        ->dehydrated(false)
                        ->afterStateHydrated(fn ($component, $record) => $component->state($record ? $record->permissions->whereIn('name', [
                            'courses.view', 'courses.create', 'courses.update', 'courses.delete'
                        ])->pluck('id')->toArray() : [])),

                    CheckboxList::make('lessons_permissions')
                        ->label('គ្រប់គ្រងមេរៀន (Lesson Management)')
                        ->options(fn (): array => Permission::whereIn('name', [
                            'lessons.view', 'lessons.create', 'lessons.update', 'lessons.delete'
                        ])->pluck('name', 'id')->all())
                        ->dehydrated(false)
                        ->afterStateHydrated(fn ($component, $record) => $component->state($record ? $record->permissions->whereIn('name', [
                            'lessons.view', 'lessons.create', 'lessons.update', 'lessons.delete'
                        ])->pluck('id')->toArray() : [])),

                    CheckboxList::make('assessments_permissions')
                        ->label('គ្រប់គ្រងការវាយតម្លៃ (Assessment Management)')
                        ->options(fn (): array => Permission::whereIn('name', [
                            'assessments.view', 'assessments.create', 'assessments.update', 'assessments.delete'
                        ])->pluck('name', 'id')->all())
                        ->dehydrated(false)
                        ->afterStateHydrated(fn ($component, $record) => $component->state($record ? $record->permissions->whereIn('name', [
                            'assessments.view', 'assessments.create', 'assessments.update', 'assessments.delete'
                        ])->pluck('id')->toArray() : [])),

                    CheckboxList::make('promotions_permissions')
                        ->label('គ្រប់គ្រងការឡើងថ្នាក់ (Promotion Management)')
                        ->options(fn (): array => Permission::whereIn('name', [
                            'promotions.view', 'promotions.create', 'promotions.update', 'promotions.delete'
                        ])->pluck('name', 'id')->all())
                        ->dehydrated(false)
                        ->afterStateHydrated(fn ($component, $record) => $component->state($record ? $record->permissions->whereIn('name', [
                            'promotions.view', 'promotions.create', 'promotions.update', 'promotions.delete'
                        ])->pluck('id')->toArray() : [])),

                    CheckboxList::make('teacher_permissions')
                        ->label('សិទ្ធិគ្រូបង្រៀន (Teacher)')
                        ->options(fn (): array => Permission::whereIn('name', [
                            'view teacher dashboard', 'view teacher courses', 'create courses', 'manage course content',
                            'view course students', 'manage assignments', 'manage quizzes', 'manage gradebook',
                            'attendance.view', 'attendance.create', 'attendance.update', 'attendance.delete', 'view reports'
                        ])->pluck('name', 'id')->all())
                        ->dehydrated(false)
                        ->afterStateHydrated(fn ($component, $record) => $component->state($record ? $record->permissions->whereIn('name', [
                            'view teacher dashboard', 'view teacher courses', 'create courses', 'manage course content',
                            'view course students', 'manage assignments', 'manage quizzes', 'manage gradebook',
                            'attendance.view', 'attendance.create', 'attendance.update', 'attendance.delete', 'view reports'
                        ])->pluck('id')->toArray() : [])),

                    CheckboxList::make('student_permissions')
                        ->label('សិទ្ធិសិស្ស (Student)')
                        ->options(fn (): array => Permission::whereIn('name', [
                            'view student dashboard', 'view my courses', 'view available courses', 'view assignments',
                            'view quizzes', 'view grades', 'attendance.view', 'view certificates'
                        ])->pluck('name', 'id')->all())
                        ->dehydrated(false)
                        ->afterStateHydrated(fn ($component, $record) => $component->state($record ? $record->permissions->whereIn('name', [
                            'view student dashboard', 'view my courses', 'view available courses', 'view assignments',
                            'view quizzes', 'view grades', 'attendance.view', 'view certificates'
                        ])->pluck('id')->toArray() : [])),

                    CheckboxList::make('settings_permissions')
                        ->label('សិទ្ធិកំណត់ប្រព័ន្ធ & ភាសា (Settings & Languages)')
                        ->options(fn (): array => Permission::whereIn('name', [
                            'language.view', 'language.create', 'language.update', 'language.delete',
                            'translation.view', 'translation.update', 'translation.import', 'translation.export'
                        ])->pluck('name', 'id')->all())
                        ->dehydrated(false)
                        ->afterStateHydrated(fn ($component, $record) => $component->state($record ? $record->permissions->whereIn('name', [
                            'language.view', 'language.create', 'language.update', 'language.delete',
                            'translation.view', 'translation.update', 'translation.import', 'translation.export'
                        ])->pluck('id')->toArray() : [])),

                    CheckboxList::make('other_permissions')
                        ->label('សិទ្ធិផ្សេងៗ (Others)')
                        ->options(fn (): array => Permission::whereNotIn('name', [
                            'users.view', 'users.create', 'users.update', 'users.delete',
                            'roles.view', 'roles.create', 'roles.update', 'roles.delete',
                            'academic.view', 'academic.create', 'academic.update', 'academic.delete',
                            'students.view', 'students.create', 'students.update', 'students.delete',
                            'courses.view', 'courses.create', 'courses.update', 'courses.delete',
                            'lessons.view', 'lessons.create', 'lessons.update', 'lessons.delete',
                            'assessments.view', 'assessments.create', 'assessments.update', 'assessments.delete',
                            'promotions.view', 'promotions.create', 'promotions.update', 'promotions.delete',
                            'view teacher dashboard', 'view teacher courses', 'create courses', 'manage course content',
                            'view course students', 'manage assignments', 'manage quizzes', 'manage gradebook',
                            'attendance.view', 'attendance.create', 'attendance.update', 'attendance.delete', 'view reports',
                            'view student dashboard', 'view my courses', 'view available courses', 'view assignments',
                            'view quizzes', 'view grades', 'attendance.view', 'view certificates',
                            'language.view', 'language.create', 'language.update', 'language.delete',
                            'translation.view', 'translation.update', 'translation.import', 'translation.export'
                        ])->pluck('name', 'id')->all())
                        ->dehydrated(false)
                        ->afterStateHydrated(fn ($component, $record) => $component->state($record ? $record->permissions->whereNotIn('name', [
                            'users.view', 'users.create', 'users.update', 'users.delete',
                            'roles.view', 'roles.create', 'roles.update', 'roles.delete',
                            'academic.view', 'academic.create', 'academic.update', 'academic.delete',
                            'students.view', 'students.create', 'students.update', 'students.delete',
                            'courses.view', 'courses.create', 'courses.update', 'courses.delete',
                            'lessons.view', 'lessons.create', 'lessons.update', 'lessons.delete',
                            'assessments.view', 'assessments.create', 'assessments.update', 'assessments.delete',
                            'promotions.view', 'promotions.create', 'promotions.update', 'promotions.delete',
                            'view teacher dashboard', 'view teacher courses', 'create courses', 'manage course content',
                            'view course students', 'manage assignments', 'manage quizzes', 'manage gradebook',
                            'attendance.view', 'attendance.create', 'attendance.update', 'attendance.delete', 'view reports',
                            'view student dashboard', 'view my courses', 'view available courses', 'view assignments',
                            'view quizzes', 'view grades', 'attendance.view', 'view certificates',
                            'language.view', 'language.create', 'language.update', 'language.delete',
                            'translation.view', 'translation.update', 'translation.import', 'translation.export'
                        ])->pluck('id')->toArray() : [])),
                ])
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('ឈ្មោះតួនាទី')->searchable()->sortable(),
                TextColumn::make('permissions.name')->label('សិទ្ធិអនុញ្ញាត')->badge()->separator(',')->limitList(6),
                TextColumn::make('created_at')->label('បានបង្កើតនៅ')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                EditAction::make()
                    ->label('កែសម្រួល')
                    ->successNotificationTitle('តួនាទីត្រូវបានកែសម្រួលដោយជោគជ័យ!'),
                DeleteAction::make()
                    ->label('លុប')
                    ->successNotificationTitle('តួនាទីត្រូវបានលុបដោយជោគជ័យ!'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('លុបដែលបានជ្រើសរើស')
                        ->successNotificationTitle('តួនាទីដែលបានជ្រើសរើសត្រូវបានលុបដោយជោគជ័យ!'),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRoles::route('/'),
            'create' => CreateRole::route('/create'),
            'edit' => EditRole::route('/{record}/edit'),
        ];
    }
}
