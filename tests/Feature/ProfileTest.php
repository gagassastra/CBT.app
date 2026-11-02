<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/profile');

        $response->assertOk();
    }

    public function test_profile_information_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $user->refresh();

        $this->assertSame('Test User', $user->name);
        $this->assertSame('test@example.com', $user->email);
        $this->assertNull($user->email_verified_at);
    }

    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => $user->email,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $this->assertNotNull($user->refresh()->email_verified_at);
    }

    public function test_user_can_delete_their_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete('/profile', [
                'password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
        $this->assertNull($user->fresh());
    }

    public function test_correct_password_must_be_provided_to_delete_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->delete('/profile', [
                'password' => 'wrong-password',
            ]);

        $response
            ->assertSessionHasErrorsIn('userDeletion', 'password')
            ->assertRedirect('/profile');

        $this->assertNotNull($user->fresh());
    }

    public function test_guru_can_upload_own_profile_photo(): void
    {
        Storage::fake('public');

        $guru = User::factory()->create(['role' => 'guru']);
        $file = UploadedFile::fake()->create('guru.jpg', 120, 'image/jpeg');

        $response = $this
            ->actingAs($guru)
            ->patch('/profile', [
                'name' => $guru->name,
                'email' => $guru->email,
                'foto' => $file,
            ]);

        $response->assertSessionHasNoErrors()->assertRedirect('/profile');

        $guru->refresh();
        $this->assertNotNull($guru->foto);
        Storage::disk('public')->assertExists($guru->foto);
    }

    public function test_admin_can_manage_user_photo(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['role' => 'admin']);
        $file = UploadedFile::fake()->create('pengajar.png', 150, 'image/png');

        $response = $this
            ->actingAs($admin)
            ->post('/admin/pengguna', [
                'name' => 'Budi Santoso, S.Pd.',
                'email' => 'budi@alqudwah.sch.id',
                'role' => 'guru',
                'password' => 'rahasia123',
                'foto' => $file,
            ]);

        $response->assertSessionHasNoErrors()->assertRedirect(route('admin.pengguna.index'));

        $created = User::where('email', 'budi@alqudwah.sch.id')->first();
        $this->assertNotNull($created);
        $this->assertNotNull($created->foto);
        Storage::disk('public')->assertExists($created->foto);
    }
}
