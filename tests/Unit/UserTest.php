<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserTest extends TestCase
{
    /** @test */
    public function it_can_create_a_user()
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }
    
    /** @test */
    public function it_can_delete_a_user()
    {
        // Asegurarse de que el usuario existe en la base de datos
        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        // Eliminar el usuario
        $user= User::where('name','John Doe')->first()->delete();

        // Asegurarse de que el usuario ha sido eliminado de la base de datos
        $this->assertDatabaseMissing('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }

    /** @test */
    public function it_authenticates_a_user()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $credentials = [
            'email' => $user->email,
            'password' => 'password',
        ];

        $this->assertTrue(Auth::attempt($credentials));
    }
}