<?php

namespace App\Services\Controllers;

use App\Exceptions\CustomException;
use App\Services\Features\ParamTrait;
use App\Repositories\WorkerRepository;
use Illuminate\Pagination\LengthAwarePaginator;

readonly class WorkerControllerService
{
    use ParamTrait;

    public function __construct(private WorkerRepository $workerRepository)
    {
    }

    /**
     * @throws CustomException
     */
    public function getData(mixed $params = []): LengthAwarePaginator|array
    {
        return match (self::getParamType($params)) {
            'id' => self::getWorkerById($params),
            'all', '' => self::getAllWorkers(),
            'filter' => self::getFilteredWorkers($params),
            'relation-filter' => self::relationFilter($params),
            default => []
        };
    }

    /**
     * @throws CustomException
     */
    private function getFilteredWorkers(array $params): array
    {
        return $this->workerRepository->findBy($params['filter']);
    }

    /**
     * @throws CustomException
     */
    private function relationFilter(array $params): LengthAwarePaginator
    {
        return $this->workerRepository->findWorkersByOrderTypeId($params['relation-filter']);
    }

    /**
     * @throws CustomException
     */
    private function getWorkerById(int $id): array
    {
        return $this->workerRepository->find($id);
    }

    /**
     * @throws CustomException
     */
    private function getAllWorkers(): LengthAwarePaginator
    {
        return $this->workerRepository->getAll();
    }

}
