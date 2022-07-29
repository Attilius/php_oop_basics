<?php

namespace Session;

use Symfony\Component\Security\Csrf\Exception\TokenNotFoundException;
use Exception;

class FileSession implements SessionInterface
{
    private string $fileName;
    private $data;

    public function __construct(array $config)
    {
        $folder = $config["folder"];
        $id = session_id();
        $this->fileName = $folder.DIRECTORY_SEPARATOR.$id;
    }

    /**
     * @param $key
     * @return bool
     */
    public function has($key): bool
    {
        return array_key_exists($key, $this->getData());
    }

    public function get($key)
    {
        return $this->getData()[$key];
    }

    /**
     * @param $key
     * @param $value
     * @return void
     * @throws Exception
     */
    public function put($key, $value): void
    {
        $this->getData();
        $this->data[$key] = $value;
        $this->persist();
    }

    /**
     * @param $key
     * @return void
     * @throws Exception
     */
    public function remove($key): void
    {
        $this->getData();
        unset($this->data[$key]);
        $this->persist();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function clear(): void
    {
        $this->data = [];
        $this->persist();
    }

    public function toArray()
    {
        return $this->getData();
    }

    /**
     * @return Flash
     */
    public function flash(): Flash
    {
        return new Flash($this);
    }

    private function getData()
    {
        if ($this->data == null){
            if (file_exists($this->fileName)){
                $this->data = unserialize(file_get_contents($this->fileName));
            } else $this->data = [];
        }
        return $this->data;
    }

    /**
     * @return void
     * @throws Exception
     */
    private function persist(): void
    {
        if (!file_put_contents($this->fileName, serialize($this->data))){
            throw new \Exception("Can't write file ". $this->fileName);
        }
    }

    /**
     * @param string $tokenId
     * @return string
     */
    public function getToken(string $tokenId): string
    {
        if ($this->hasToken($tokenId)){
            return $this->get("_csrf:". $tokenId);
        } else {
            throw new TokenNotFoundException("The CSRF token not found!");
        }
    }

    /**
     * @param string $tokenId
     * @param string $token
     * @return void
     * @throws Exception
     */
    public function setToken(string $tokenId, string $token): void
    {
        $this->put("_csrf:". $tokenId, $token);
    }

    /**
     * @param string $tokenId
     * @return string|null
     * @throws Exception
     */
    public function removeToken(string $tokenId): ?string
    {
        if ($this->hasToken($tokenId)){
            $token = $this->getToken($tokenId);
            $this->remove("_csrf:". $tokenId);
            return $token;
        }
        return null;
    }

    public function hasToken(string $tokenId): bool
    {
        return $this->has("_csrf:". $tokenId);
    }
}