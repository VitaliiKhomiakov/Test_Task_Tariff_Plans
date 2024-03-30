<?php declare(strict_types=1);

namespace Repository;

use ObsceneWord;
use PDO;

class ObsceneWordRepository extends AbstractRepository
{
    /**
     * @param int $lastId
     * @param int $limit
     * @return ObsceneWord[]
     */
    public function findBy(int $lastId = 0, int $limit = 50): array
    {
        $stmt = $this->query()
            ->prepare('SELECT * FROM `obscene_word` WHERE `id` > :id LIMIT :limit');
        $stmt->bindParam(':id', $lastId, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return array_map(fn($item) => new ObsceneWord($item), $stmt->fetchAll(PDO::FETCH_ASSOC));
    }
}