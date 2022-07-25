<?php

namespace Session;

use Symfony\Component\Security\Csrf\Exception\TokenNotFoundException;

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

    public function has($key)
    {
        return array_key_exists($key, $this->getData());
    }

    public function get($key)
    {
        return $this->getData()[$key];
    }

    public function put($key, $value)
    {
        $this->getData();
        $this->data[$key] = $value;
        $this->persist();
    }

    public function remove($key)
    {
        $this->getData();
        unset($this->data[$key]);
        $this->persist();
    }

    public function clear()
    {
        $this->data = [];
        $this->persist();
    }

    public function toArray()
    {
        return $this->getData();
    }

    public function flash()
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

    private function persist()
    {
        if (!file_put_contents($this->fileName, serialize($this->data))){
            throw new \Exception("Can't write file ". $this->fileName);
        }
    }

    public function getToken(string $tokenId): string
    {
        if ($this->hasToken($tokenId)){
            return $this->get("_csrf:". $tokenId);
        } else {
            throw new TokenNotFoundException("The CSRF token not found!");
        }
    }

    public function setToken(string $tokenId, string $token)
    {
        $this->put("_csrf:". $tokenId, $token);
    }

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