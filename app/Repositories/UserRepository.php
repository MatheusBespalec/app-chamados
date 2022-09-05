<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UserRepository
{
    private function saveImage(UploadedFile $file): string
    {
        return $file->storeAs('users', Str::random(30) . '.' .  $file->extension());
    }

    private function deleteImage(string $fileName): void
    {
        Storage::delete($fileName);
    }

    public function update(User $user, string $name, string $email, ?UploadedFile $image): User
    {
        if ($image instanceof UploadedFile) {
            if (!is_null($user->image)) {
                $this->deleteImage($user->image);
            }
            $fileName = $this->saveImage($image);
        }

        $user->update([
            'name' => $name,
            'email' => $email,
            'image' => $fileName ?? $user->image
        ]);

        return $user;
    }
}
