<?php

namespace App\Containers\AppSection\Authentication\Tests\Functional\WEB;

use App\Containers\AppSection\Authentication\Tests\Functional\WebTestCase;
use App\Containers\AppSection\Authentication\UI\WEB\Controllers\RegisterController;
use Illuminate\Support\Facades\Hash;

final class RegisterTest extends WebTestCase
{
    public function testGuestCanRegisterAndCannotReuseEmail(): void
    {
        $this->assertSame(':memory:', config('database.connections.sqlite.database'));
        $data = [
            'name' => 'Test İstifadəçi',
            'email' => 'new.user@example.test',
            'password' => 'A-strong-password1',
            'password_confirmation' => 'A-strong-password1',
        ];

        $this->get(action([RegisterController::class, 'showForm']))->assertOk();
        $this->post(action(RegisterController::class), $data)->assertRedirectToRoute('login.form');
        $this->assertDatabaseHas('users', ['email' => $data['email']]);
        $this->assertTrue(Hash::check($data['password'], (string) $this->app['db']->table('users')->where('email', $data['email'])->value('password')));
        $this->post(action(RegisterController::class), $data)->assertSessionHasErrors('email');
    }
}
