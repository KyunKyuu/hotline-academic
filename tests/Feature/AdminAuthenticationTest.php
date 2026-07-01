<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_when_opening_dashboard(): void
    {
        $response = $this->get('/admin/hotline');

        $response->assertRedirect('/admin/login');
    }

    public function test_admin_can_login_and_open_dashboard(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('secret123'),
            'is_admin' => true,
        ]);

        $login = $this->post('/admin/login', [
            'email' => 'admin@example.com',
            'password' => 'secret123',
        ]);

        $login->assertRedirect(route('hotline.dashboard'));

        $this->get('/admin/hotline')->assertOk();
    }

    public function test_non_admin_cannot_login_to_dashboard(): void
    {
        User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('secret123'),
            'is_admin' => false,
        ]);

        $response = $this->from('/admin/login')->post('/admin/login', [
            'email' => 'user@example.com',
            'password' => 'secret123',
        ]);

        $response->assertRedirect('/admin/login');
        $response->assertSessionHasErrors('email');
    }
}
