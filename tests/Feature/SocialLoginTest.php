<?php

namespace Tests\Feature;

use Auth;
use Mockery;
use App\AuditLog;
use Tests\TestCase;
use Socialite;
use Illuminate\Foundation\Testing\RefreshDatabase;


class SocialLoginTest extends TestCase

{
    use RefreshDatabase;


    protected function mockSocialiteResponse($providerName, $socialiteUserClass,  $userMockedMethods)
    {
        // Mock calls to Socialite with my user details
        $socialUser = Mockery::mock($socialiteUserClass);
        foreach ($userMockedMethods as $method => $return) {
            $socialUser->shouldReceive($method)->andReturn($return);
        }

        $provider = Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $provider->shouldReceive('user')->andReturn($socialUser);

        Socialite::shouldReceive('driver')->with($providerName)->andReturn($provider);
    }



    /**
     * When I visit login/twitter I end up at / and logged in with a new user 
     * 
     * @test
     */
    public function can_login_with_twitter()
    {

        $this->mockSocialiteResponse('twitter', 'Laravel\Socialite\One\User', [
            'getId' => 12345678,
            'getName' => 'My Name',
            'getEmail' => 'myemail@example.com'
        ]);

        // call the twitter callback page
        $response = $this->get('/login/twitter/callback');

        // check redirected to / and logged in with my mocked user
        $response->assertRedirect('/');
        $this->assertEquals('My Name', Auth::user()->getName());

        // check / displays user name 
        $response = $this->get('/');
        $response->assertSee('My Name');
    }


    /**
     * @test
     */
    public function oauth_authentication_is_logged_in_database()
    {

        $this->mockSocialiteResponse('twitter', 'Laravel\Socialite\One\User', [
            'getId' => 12345678,
            'getName' => 'My Name',
            'getEmail' => 'myemail@example.com'
        ]);

        // call the twitter callback page
        $response = $this->get('/login/twitter/callback');

        // check login action logged 
        $auditLog = AuditLog::all()->first();
        $this->assertEquals(AuditLog::USER_OAUTH_AUTHENTICATION, $auditLog->getEvent());
        $this->assertStringContainsString('My Name', $auditLog->getDetails());
        $this->assertStringContainsString('12345678', $auditLog->getDetails());
    }
}
