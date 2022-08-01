<?php

namespace Services;

use Exception\SqlException;
use mysqli;
use Photo;

class PhotoService
{
    private mysqli $connection;

    public function __construct(mysqli $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param $title
     * @param $file
     * @return Photo
     * @throws SqlException
     */
    public function createImage($title, $file): Photo
    {
        if ($statement = $this->connection->prepare("INSERT INTO photos (title, url, thumbnail, created_at, updated_at) VALUES (?,?,?,?,?)")){
            $currentDate = date("Y-m-d H:i:s");
            $statement->bind_param("sssss",$title, $file, $file, $currentDate, $currentDate);
            if (!$statement->execute()){
                throw new SqlException('Query error: '. $this->connection->error);
            }
            return $this->getImageById($this->connection->insert_id);
        } else {
            throw new SqlException('Query error: '. $this->connection->error);
        }
    }

    /**
     * @param $size
     * @param $offset
     * @return Photo[]
     * @throws SqlException
     */
    public function getPhotosPaginated($size, $offset)
    {
        if ($statement = mysqli_prepare($this->connection, 'SELECT * FROM photos LIMIT ? OFFSET ?')) {
            mysqli_stmt_bind_param($statement, "ii", $size, $offset);
            mysqli_stmt_execute($statement);
            $result = mysqli_stmt_get_result($statement);
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return array_map(function ($row){
                return new Photo($row['id'], $row['title'], $row['thumbnail'], $row['url']);
            }, $rows);
        } else {
            throw new SqlException('Query error: '. mysqli_error($this->connection));
        }
    }

    public function getTotal()
    {
        if ($result = mysqli_query($this->connection, 'SELECT count(*) as count FROM photos')) {
            $row = mysqli_fetch_assoc($result);
            return $row['count'];
        } else {
            throw new SqlException('Query error: '. mysqli_error($this->connection));
        }
    }

    public function getImageById($id): Photo
    {
        if ($statement = mysqli_prepare($this->connection, 'SELECT * FROM photos WHERE id = ?')) {
            mysqli_stmt_bind_param($statement, "i", $id);
            mysqli_stmt_execute($statement);
            $result = mysqli_stmt_get_result($statement);
            $row = mysqli_fetch_assoc($result);
            return new Photo($row['id'], $row['title'], $row['thumbnail'], $row['url']);
        } else {
            throw new SqlException('Query error: '. mysqli_error($this->connection));
        }
    }

    public function updateImage($id, $title)
    {
        if ($statement = mysqli_prepare($this->connection, 'UPDATE photos SET title = ? WHERE id = ?')) {
            mysqli_stmt_bind_param($statement, "si", $title, $id);
            mysqli_stmt_execute($statement);
        } else {
            throw new SqlException('Query error: '. mysqli_error($this->connection));
        }
    }

    public function deleteImage($id)
    {
        if ($statement = mysqli_prepare($this->connection, 'DELETE FROM photos WHERE id = ?')) {
            mysqli_stmt_bind_param($statement, "i", $id);
            mysqli_stmt_execute($statement);;
        } else {
            throw new SqlException('Query error: '. mysqli_error($this->connection));
        }
    }
}