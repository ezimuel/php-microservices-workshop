<?php
declare(strict_types=1);

namespace App\User;

use App\Exception;
use PDO;
use PDOStatement;
use Ramsey\Uuid\Uuid;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;

class UserModel
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Get all user
     */
    public function getAll(): Paginator
    {
        $sth = $this->pdo->prepare('SELECT * FROM user');
        if ($sth->execute() === false) {
            return new UserCollection();
        }
        $sth->setFetchMode(PDO::FETCH_CLASS, UserEntity::class);
        return new UserCollection(new ArrayAdapter($sth->fetchAll()));
    }

    /**
     * Get a user by $id
     *
     * @throws Exception\NoResourceFoundException
     * @throws Exception\RuntimeException if an error occurs during select
     */
    public function getUser(string $id): UserEntity
    {
        $sth = $this->pdo->prepare('SELECT * FROM user WHERE id = :id');
        $sth->bindParam(':id', $id);
        if ($sth->execute() === false) {
            $this->throwRuntimeException($sth);
        }
        $sth->setFetchMode(PDO::FETCH_CLASS, UserEntity::class);
        $result = $sth->fetch();
        if (empty($result)) {
            throw Exception\NoResourceFoundException::create('User not found');
        }
        return $result;
    }

    /**
     * Add a user with $data values
     *
     * @throws Exception\InvalidParameterException if the data is not valid.
     * @throws Exception\RuntimeException if an error occurs during insert.
     */
    public function addUser(array $data, UserInputFilter $inputFilter): string
    {
        $inputFilter->setData($data);
        if (! $inputFilter->isValid()) {
            throw Exception\InvalidParameterException::create(
                'Invalid parameter',
                $inputFilter->getMessages()
            );
        }

        $data = $inputFilter->getValues();
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['id'] = (Uuid::uuid4())->toString();

        $sth = $this->pdo->prepare(
            'INSERT INTO user (id, name, email, password) ' .
            'VALUES (:id, :name, :email, :password)'
        );
        $sth->bindParam(':id', $data['id']);
        $sth->bindParam(':name', $data['name']);
        $sth->bindParam(':email', $data['email']);
        $sth->bindParam(':password', $data['password']);
        if ($sth->execute() === false) {
            $this->throwRuntimeException($sth);
        }

        return $data['id'];
    }

    /**
     * Update the user with $id and $data
     *
     * @throws Exception\InvalidParameterException if the data is not valid.
     * @throws Exception\NoResourceFoundException if no rows are returned by
     *     the update operation.
     */
    public function updateUser(string $id, array $data, UserInputFilter $inputFilter): UserEntity
    {
        $user = $this->getUser($id);
        if (empty($user)) {
            throw Exception\NoResourceFoundException::create('User not found');
        }

        $inputFilter->setData($data);
        $inputFilter->get('email')->setRequired(false);
        $inputFilter->get('password')->setRequired(false);
        if (! $inputFilter->isValid()) {
            throw Exception\InvalidParameterException::create(
                'Invalid parameter',
                $inputFilter->getMessages()
            );
        }
        $params = [];
        foreach ($data as $key => $value) {
            $params[] = sprintf("%s = :%s", $key, $key);
        }
        $sth = $this->pdo->prepare(sprintf(
            "UPDATE user SET %s WHERE id = :id",
            implode(', ', $params)
        ));
        $data['id'] = $id;
        if ($sth->execute($data) === false) {
            $this->throwRuntimeException($sth);
        }
        $user->exchangeArray($data);
        return $user;
    }

    /**
     * Remove the user with $id
     *
     * @throws Exception\NoResourceFoundException if no rows are returned by
     *     the delete operation.
     */
    public function deleteUser($id): bool
    {
        $sth = $this->pdo->prepare('DELETE FROM user WHERE id = :id');
        $sth->bindParam(':id', $id);
        if ($sth->execute() === false) {
            throw Exception\NoResourceFoundException::create('User not found');
        }
        return true;
    }

    protected function throwRuntimeException(PDOStatement $sth): void
    {
        throw Exception\RuntimeException::create(sprintf(
            "Database error (%s): %s",
            $sth->errorCode(),
            print_r($sth->errorInfo(), true)
        ));
    }
}
