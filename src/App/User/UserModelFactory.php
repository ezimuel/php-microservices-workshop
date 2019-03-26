<?php
declare(strict_types=1);

namespace App\User;

use PDO;
use Psr\Container\ContainerInterface;

class UserModelFactory
{
    public function __invoke(ContainerInterface $container) : UserModel
    {
        $config = $container->get('config');
        if (!isset($config['database']['pdo']['dsn'])) {
            throw new \RuntimeException('You need to configure the PDO database');
        }
        $pdo = new PDO(
            $config['database']['pdo']['dsn'],
            $config['database']['pdo']['user'] ?? '',
            $config['database']['pdo']['password'] ?? ''
        );
        
        return new UserModel($pdo);
    }
}
