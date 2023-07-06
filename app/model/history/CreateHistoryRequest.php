<?php 

namespace Ewallet\Model\History;

class CreateHistoryRequest {

    public int $accountNumber;
    public float $nominal;
    public string $historyName, $historyCategory, $historyType;

    public function __construct(int $accountNumber, float $nominal, string $historyName, string $historyCategory, string $historyType) {
        $this->accountNumber = $accountNumber;
        $this->nominal = $nominal;
        $this->historyName = $historyName;
        $this->historyCategory = $historyCategory;
        $this->historyType = $historyType;
    }

}