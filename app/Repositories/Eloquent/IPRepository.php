<?php

namespace App\Repositories\Eloquent;

use App\Models\IP;
use App\Repositories\IPRepositoryInterface;
use TimWassenburg\RepositoryGenerator\Repository\BaseRepository;

/**
 * Class IPRepository.
 */
class IPRepository extends BaseRepository implements IPRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param IP $model
     */
    public function __construct(IP $model)
    {
        parent::__construct($model);
    }
}
