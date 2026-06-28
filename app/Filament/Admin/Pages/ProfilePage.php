<?php

namespace App\Filament\Admin\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class ProfilePage extends Page
{
    use WithFileUploads;

    protected static string|BackedEnum|null $navigationIcon = null;

    protected static ?string $navigationLabel = 'មើលប្រវត្តិរូប';

    protected static ?string $title = 'ប្រវត្តិរូប';

    protected static ?string $slug = 'my-profile';

    // Hide from sidebar navigation — only accessible from user menu
    protected static bool $shouldRegisterNavigation = false;

    protected string $view = 'filament.admin.pages.profile-page';

    /** @var \Livewire\Features\SupportFileUploads\TemporaryUploadedFile|null */
    public $avatarFile = null;

    public string $successMessage = '';

    public static function getNavigationIcon(): string|BackedEnum|Htmlable|null
    {
        return new HtmlString('<span></span>');
    }

    public function uploadAvatar(): void
    {
        $this->validate([
            'avatarFile' => 'required|image|max:2048',
        ], [
            'avatarFile.required' => 'សូមជ្រើសរើសរូបភាព',
            'avatarFile.image'    => 'ឯកសារត្រូវតែជារូបភាព',
            'avatarFile.max'      => 'រូបភាពមិនអាចធំជាង 2MB',
        ]);

        $user = auth()->user();

        // Delete old avatar
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $this->avatarFile->store('avatars', 'public');

        $user->update(['avatar' => $path]);

        $this->avatarFile = null;
        $this->successMessage = 'រូបភាពត្រូវបានធ្វើបច្ចុប្បន្នភាពដោយជោគជ័យ!';

        $this->dispatch('avatar-updated');
    }

    public function removeAvatar(): void
    {
        $user = auth()->user();

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->update(['avatar' => null]);
        $this->successMessage = 'រូបភាពត្រូវបានលុបដោយជោគជ័យ!';
    }

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        $user = auth()->user();

        $roles = $user?->getRoleNames()->map(fn ($r) => match ($r) {
            'super_admin' => 'ស៊ូប៉ែអ្នកគ្រប់គ្រង',
            'admin'       => 'អ្នកគ្រប់គ្រង',
            'teacher'     => 'គ្រូបង្រៀន',
            'student'     => 'និស្សិត',
            default       => $r,
        })->implode(', ') ?? '—';

        $student = $user?->student?->load(['department', 'academicYear', 'semester']);
        $teacher = $user?->teacher;

        return [
            'user'    => $user,
            'roles'   => $roles,
            'student' => $student,
            'teacher' => $teacher,
        ];
    }
}
