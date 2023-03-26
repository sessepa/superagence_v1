<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class UserAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    //private UrlGeneratorInterface $urlGenerator;

    public function __construct(private UrlGeneratorInterface $urlGenerator)
    {
        //$this->urlGenerator = $urlGenerator;

    }

    /**
     * @param Request $request
     * @return Passport  Nouveau élément de symfony depuis la 5.3 qui permet de gérer l'authentification des users
     */
    public function authenticate(Request $request): Passport
    {
        //Ici on fait $request->request car on fait appel à la méthode POST
        $email = $request->request->get('email', '');

        //Insère le dernier user saisi
        $request->getSession()->set(Security::LAST_USERNAME, $email);

        // Objet par defaut qui permet
        return new Passport(
            new UserBadge($email), //va chercher le user via son email
            new PasswordCredentials($request->request->get('password', '')), //Recupère le mdp saisi
            [
                //Token qui permet de verifier que le formulaire vient bien du site
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        //Pour rediriger l'utilsateur sur la page où il était connecté
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        // for example:  Ici on rédirige l'utilisateur vers la page home
         return new RedirectResponse($this->urlGenerator->generate('home'));
        //throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
