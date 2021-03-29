<?php

namespace Tests\Feature;

use Tests\TestCase;

class RegisterController extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use DatabaseTransactions;
    public function testRegister()
    {
        $testUserName = 'テストユーザー';
        $testGender = 'male';
        $testAge = '20';
        $testEmail = 'test@gmail.com';
        $testPassword = '1234';

        $response = $this->post(route('register'),
            [
                'name' => $testUserName,
                'gender' => $testGender,
                'age' => $testAge,
                'email' => $testEmail,
                'password' => $testPassword,
            ]
        );

        // 投稿内容がDBに登録されているか
        $this->assertDatabaseHas('users', [
            'name' => $testUserName,
            'gender' => $testGender,
            'age' => $testAge,
            'email' => $testEmail,
        ]);

        // DBに登録されているパスワードと、テスト送信したパスワードを比較
        $this->assertTrue(Hash::check($testPassword,
        User::where('name', $testUserName)->first()->password
        ));

        $response->assertRedirect(route('articles.index'));
    }
}
