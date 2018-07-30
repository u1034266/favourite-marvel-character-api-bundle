# Favourite Marvel Character API Bundle
A simple Marvel API bundle that allows you to connect to the Marvel universe via the Marvel API, and choose a fourite marvel character.

## Disclaimer
This application is intended solely for education purposes only, and free to use and build upon based on this understanding. Marvel owns the api, and requires that all developers adhere to the requirements on their site (https://developer.marvel.com/) 
## Requirements
* PHP 7.0 > 
* Marvel API Account (http://developer.marvel.com/account)
  * Obtain a Marvel API key if you don't have one.
* Symfony 3.4 >
* Composer (https://getcomposer.org/download/)
* Symfony Flex (optional)

## Installation & Setup
## 1. Clone the repository
```console
$ git clone https://github.com/u1034266/favourite-marvel-character-api-bundle.git
``` 
## 2. Configure your API Keys
Once you've logged into your Marvel API account, then copy your API keys and place them into `app/config/parameters.yml`
```console
parameters:
    //...
    
    marvel_api_pubKey: #yourApiPublicKey
    marvel_api_privKey: #yourApiPrivateKey
    marvel_auth_referrer: localhost
```
## 4. Database Migration
Update your data fixture config in the `src/AppBundle/DataFixtures/ORM/LoadUserData.php` file, and add your `admin user` credentials.
```console
public function load(ObjectManager $manager)
{
    $user = new User();
    $user->setUsername('admin');
    $user->setEmail('admin@admin.com');
    $encoder = $this->container->get('security.password_encoder');
    $password = $encoder->encodePassword($user, 'admin');
    $user->setPassword($password);

    $manager->persist($user);
    $manager->flush();

}
```
Load the fixtures
```console
$ php bin/console doctrine:fixtures:load
```
Invoke the Migration
```console
$ php bin/console doctrine:schema:update --force
```

## Usage
### Calling the API client
```console
<?php
    //...
    $client = $this->get('marvel_api_client');
    
    //...
```
### Endpoints
Only two(2) endpoints are configured in this example.
```console
    //...
    // To get data for the logged-in user's favourite character
    $response = $client->getCharacter($this->getUser()->getCharacterid());
    
    // To get all characters ie. Limit currently set to 20 chars. Can increase as per required.
    $response = $client->getCharacters();
```
## Optional Improvements
Whilst this feature is cool and lightweight, some cool-to-have improvements may include:
* Building DataWrappers
* User registration functionality (currently their is only one user. Ie. admin user)

## Additional info

* [Marvel API documentation](http://developer.marvel.com/docs)
* [Marvel API terms of use](http://developer.marvel.com/terms)

Thats it, enjoy!