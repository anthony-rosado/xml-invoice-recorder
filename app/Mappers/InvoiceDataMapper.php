<?php

namespace App\Mappers;

use App\Exceptions\Mappers\UnableToGetElementFromData;
use ErrorException;

readonly class InvoiceDataMapper
{
    public function __construct(
        private array $data
    ) {
    }

    public function getAttributes(): array
    {
        return [
            'series' => $this->data['series'],
            'correlative_number' => $this->data['correlative_number'],
            'issue_date' => $this->data['issue_date'],
            'issue_time' => $this->data['issue_time'],
            'due_date' => $this->data['due_date'],
            'observation' => $this->data['observation'],
            'base_amount' => $this->data['base_amount'],
            'tax_amount' => $this->data['tax_amount'],
            'discount_amount' => $this->data['discount_amount'],
            'other_charges_amount' => $this->data['other_charges_amount'],
            'total_amount' => $this->data['total_amount'],
        ];
    }

    /**
     * @throws UnableToGetElementFromData
     */
    public function getTransactionTypeCode(): string
    {
        return $this->get('transaction_type_code');
    }

    /**
     * @throws UnableToGetElementFromData
     */
    public function getDocumentTypeCode(): string
    {
        return $this->get('document_type_code');
    }

    /**
     * @throws UnableToGetElementFromData
     */
    public function getCurrencyCode(): string
    {
        return $this->get('currency_code');
    }

    /**
     * @throws UnableToGetElementFromData
     */
    public function getIssuer(): array
    {
        return $this->get('issuer');
    }

    /**
     * @throws UnableToGetElementFromData
     */
    public function getAcquirer(): array
    {
        return $this->get('acquirer');
    }

    /**
     * @throws UnableToGetElementFromData
     */
    public function getUser(): array
    {
        return $this->get('user');
    }

    /**
     * @throws UnableToGetElementFromData
     */
    public function getTaxes(): array
    {
        return $this->get('taxes');
    }

    /**
     * @throws UnableToGetElementFromData
     */
    public function getItems(): array
    {
        return $this->get('items');
    }

    /**
     * @throws UnableToGetElementFromData
     */
    private function get(string $key)
    {
        try {
            $element = $this->data[$key];
        } catch (ErrorException $errorException) {
            throw new UnableToGetElementFromData($key, $errorException);
        }

        return $element;
    }
}
