<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TodoTest extends DuskTestCase
{
    public function testRegister()
    {
        $this->browse(function ($browser){
           $browser->visit('register')
               ->type('name', 'Liutauras Liutauras')
               ->type('email', 'liutauras@gmail.com')
               ->type('password', 'liutauras123')
               ->type('password_confirmation', 'liutauras123')
               ->attach('userimage', 'C:\Users\Liutauras\Desktop\Stuff\1.jpg')
               ->press('Register')
               ->assertPathIs('/ToDo-App/public/todo');
        });
    }

    public function testCreateTodo()
    {
        $this->browse(function ($browser){
           $browser->visit('todo')
               ->clickLink('Add Todo')
               ->type('todo', 'Testing it With Dusk')
               ->type('category', 'dusk')
               ->type('description', 'This is created with dusk')
               ->press('Add')
               ->assertPathIs('ToDo-App/public/todo');
        });
    }

    public function testViewTodo()
    {
        $this->browse(function ($browser){
           $browser->visit('todo')
               ->assertVisible('#view1')
               ->visit(
                   $browser->attribute('#view1', 'href')
               )
               ->assertPathIs('ToDo-App/public/todo/1')
               ->clickLink('Edit')
               ->type('description', 'Testing it with dusk again')
               ->press('Update')
               ->assertPathIs('Todo-App/public/todo/1');
        });
    }

    public function testEditTodo()
    {
        $this->browse(function ($browser) {
            $browser->visit('todo')
                ->assertVisible('#edit1')
                ->visit(
                    $browser->attribute('#edit1', 'href')
                )
                ->type('description', 'Testing it with dusk again')
                ->press('Update')
                ->assertPathIs('/Todo-App/public/todo/1');
        });
    }

    public function testDeleteTodo()
    {
        $this->browse(function ($browser) {
            $browser->visit('todo')
                ->assertVisible('#delete1')
                ->visit(
                    $browser->attribute('#delete1', 'href')
                )
                ->assertPathIs('/Todo-App/public/todo');
        });
    }

    public function testLogout()
    {
        $this->browse(function ($browser) {
            $browser->visit('todo')
                ->clickLink('Logout')
                ->assertPathIs('/Todo-App/public/login');
        });
    }

    public function testLogin()
    {
        $this->browse(function ($browser) {
            $browser->visit('login')
                ->type('email', 'liutauras@gmail.com')
                ->type('password', 'liutauras123')
                ->press('Login')
                ->assertPathIs('/Todo-App/public/todo');
        });
    }
}
