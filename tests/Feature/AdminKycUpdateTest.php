<?php
namespace Tests\Feature;

use App\Models\{User, KycSubmission};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminKycUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_update_kyc_status(): void
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        $admin = User::create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'full_name' => 'Admin',
            'role' => 0,
            'role_type' => 'ADMIN',
            'is_admin' => true,
            'is_email_verified' => 1,
        ]);

        $user = User::create([
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'full_name' => 'User',
            'role' => 1,
            'role_type' => 'USER',
            'is_email_verified' => 1,
        ]);

        $submission = KycSubmission::create([
            'user_id' => $user->id,
            'full_name' => 'User',
            'id_number' => '12345',
            'front_image_path' => 'front.jpg',
            'back_image_path' => 'back.jpg',
        ]);

        $response = $this->actingAs($admin)
            ->patch(route('admin.kyc.update', $submission->id), [
                'status' => 'approved',
            ]);

        $response->assertRedirect(route('admin.kyc.index'));
        $this->assertDatabaseHas('kyc_submissions', [
            'id' => $submission->id,
            'status' => 'approved',
            'reviewed_by' => $admin->id,
        ]);
    }

    public function test_update_fails_with_invalid_status(): void
    {
        $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        $admin = User::create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'full_name' => 'Admin',
            'role' => 0,
            'role_type' => 'ADMIN',
            'is_admin' => true,
            'is_email_verified' => 1,
        ]);

        $user = User::create([
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'full_name' => 'User',
            'role' => 1,
            'role_type' => 'USER',
            'is_email_verified' => 1,
        ]);

        $submission = KycSubmission::create([
            'user_id' => $user->id,
            'full_name' => 'User',
            'id_number' => '12345',
            'front_image_path' => 'front.jpg',
            'back_image_path' => 'back.jpg',
        ]);

        $response = $this->actingAs($admin)
            ->patch(route('admin.kyc.update', $submission->id), [
                'status' => 'rejected',
            ]);

        $response->assertSessionHasErrors('note');
        $this->assertDatabaseHas('kyc_submissions', [
            'id' => $submission->id,
            'status' => 'pending',
        ]);
    }
}
