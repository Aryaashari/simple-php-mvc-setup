<?php 

namespace Ewallet\Service;

use Ewallet\Config\Database;
use Ewallet\Domain\History;
use Ewallet\Model\History\CreateHistoryRequest;
use Ewallet\Repository\HistoryRepository;

class HistoryService {


    private HistoryRepository $historyRepo;

    public function __construct(HistoryRepository $historyRepository) {
        $this->historyRepo = $historyRepository;
    }


    public function getAll() : array {
        try {
            $histories = $this->historyRepo->findAll();
            return $histories;
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function getById(int $id) : ?History {
        try {
            $history = $this->historyRepo->findById($id);
            return $history;
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function getByAccountNumber(int $accountNumber) : array {
        try {
            $histories = $this->historyRepo->findByAccountNumber($accountNumber);
            return $histories;
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function create(CreateHistoryRequest $request) : History {

        try {
            return $this->historyRepo->create(new History(null,$request->accountNumber, $request->nominal, $request->historyName, $request->historyCategory, null));
        } catch(\Exception $e) {
            throw $e;
        }

    }


}