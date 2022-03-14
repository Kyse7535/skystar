<?php
use Nowakowskir\JWT\JWT;
use Nowakowskir\JWT\TokenDecoded;
use Nowakowskir\JWT\TokenEncoded;

// https://github.com/nowakowskir/php-jwt
class JWTProtocols {
    private string $key;

    function __construct() {
        $this->key = 'my-key-as-plaintext';
    }

    /**
     *  Normalement, on souhaite qu'un JWT Token est une durée de vie très courte. (15m)
     *  Néanmoins, ici on ne sauvegarde pas l'utilisateur dans la base de donnée, l'utilisateur est anonyme.
     *  Ainsi, nous n'avons pas besoin de sécurité particulère, et dans l'optique de faire un jeu stable on peut lui donner le temps le plus long possible.
     *  Soit d'après le RGPD, un cookie a une durée de vie maximum d'1 an sur un navigateur.
     * */
    function generateTokenDecoded(string $payload): TokenDecoded {
        $now = new DateTimeImmutable();
        return new TokenDecoded([
            'payload_key' => $payload,
            'exp' => $now->modify("+1 year")->getTimestamp()
        ]);
    }

    function getUseAlgorithm(): string {
        return JWT::ALGORITHM_HS256;
    } 

    function sign(string $payload): string {
        $tokenDecoded = $this->generateTokenDecoded($payload);
        return $tokenDecoded->encode($this->key, $this->getUseAlgorithm())->toString();
    }

    function getPseudo(string $token): string {
        $leeway = 500;
        $tokenEncoded = new TokenEncoded($token);
        $tokenEncoded->validate($this->key, $this->getUseAlgorithm(), $leeway);
        return $tokenEncoded->decode()->getPayload()['payload_key'];
    }
}