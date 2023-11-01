<?php

namespace Fillicode\BeeId;

use GuzzleHttp\Exception\GuzzleException;
use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\User;

class Provider extends AbstractProvider
{
    /**
     * bee-id site url
     *
     * @var string
     */
    protected string $authUrlSite = 'https://bee-id.ru';

    /**
     * Returns the url for obtaining authorization
     *
     * @param $state
     * @return string
     */
    protected function getAuthUrl($state): string
    {
        return $this->buildAuthUrlFromBase($this->authUrlSite . '/oauth/authorize', $state);
    }

    /**
     * Returns the url to receive the token
     *
     * @return string
     */
    protected function getTokenUrl(): string
    {
        return $this->authUrlSite . '/oauth/token';
    }

    /**
     * Returns the authorized user
     *
     * @param $token
     * @return array|mixed
     * @throws GuzzleException
     */
    protected function getUserByToken($token): mixed
    {
        $response = $this->getHttpClient()->get(
            $this->authUrlSite . '/api/user',
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                ],
            ]
        );

        $response = json_decode($response->getBody(), true);

        return $response['data']['user'];
    }

    /**
     * Converts user data to an object
     *
     * @param array $user
     * @return User
     */
    protected function mapUserToObject(array $user): User
    {
        return (new User())->setRaw($user)->map([
            'id' => $user['id'],
            'name' => $user['name'],
            'post' => $user['post'],
            'email' => $user['email'],
            'phone' => $user['phone'],
        ]);
    }

    /**
     * Requests an access token
     *
     * @param $code
     * @return array|mixed
     * @throws GuzzleException
     */
    public function getAccessTokenResponse($code): mixed
    {
        $response = $this->getHttpClient()->post(
            $this->getTokenUrl(),
            [
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'form_params' => [
                    'grant_type' => 'authorization_code',
                    'client_id' => $this->clientId,
                    'client_secret' => $this->clientSecret,
                    'redirect_uri' => $this->redirectUrl,
                    'code' => $code,
                ],
            ]
        );

        return json_decode($response->getBody(), true);
    }
}