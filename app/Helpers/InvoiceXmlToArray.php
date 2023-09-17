<?php

namespace App\Helpers;

use App\Exceptions\Helpers\CouldNotTransformInvoiceXmlToArrayException;
use Exception;
use Illuminate\Support\Arr;
use Mtownsend\XmlToArray\XmlToArray;

class InvoiceXmlToArray
{
    private array $data;

    public function __construct(
        private readonly string $content
    ) {
    }

    /**
     * @throws CouldNotTransformInvoiceXmlToArrayException
     */
    public function transform(): array
    {
        $content = $this->convertedContent();

        try {
            $this->setInformation($content);
            $this->setIssuer($content['cac:AccountingSupplierParty']['cac:Party']);
            $this->setAcquirer($content['cac:AccountingCustomerParty']['cac:Party']);
            $this->setTaxes($content['cac:TaxTotal']['cac:TaxSubtotal']);
            $this->setItems($content['cac:InvoiceLine']);
        } catch (Exception $exception) {
            throw new CouldNotTransformInvoiceXmlToArrayException($exception);
        }

        return $this->data;
    }

    private function setInformation(array $content): void
    {
        if (Arr::isAssoc($content['cbc:Note'])) {
            $observation = $content['cbc:Note']['@content'];
        } else {
            $observation = collect($content['cbc:Note'])
                ->map(function ($note) {
                    return is_array($note) ? $note['@content'] : $note;
                })
                ->join(PHP_EOL);
        }

        $this->data = [
            'transaction_type_code' => $content['cbc:ProfileID']['@content'],
            'document_type_code' => $content['cbc:InvoiceTypeCode']['@content'],
            'currency_code' => $content['cbc:DocumentCurrencyCode']['@content'],
            'series' => explode('-', $content['cbc:ID'])[0],
            'correlative_number' => explode('-', $content['cbc:ID'])[1],
            'issue_date' => $content['cbc:IssueDate'],
            'issue_time' => $content['cbc:IssueTime'],
            'due_date' => $content['cbc:DueDate'] ?? $content['cbc:IssueDate'],
            'observation' => $observation,
            'base_amount' => $content['cac:LegalMonetaryTotal']['cbc:LineExtensionAmount']['@content'],
            'tax_amount' => $content['cac:TaxTotal']['cbc:TaxAmount']['@content'],
            'discount_amount' => $content['cac:LegalMonetaryTotal']['cbc:AllowanceTotalAmount']['@content'],
            'other_charges_amount' => $content['cac:LegalMonetaryTotal']['cbc:ChargeTotalAmount']['@content'],
            'total_amount' => $content['cac:LegalMonetaryTotal']['cbc:PayableAmount']['@content'],
        ];
    }

    private function setIssuer(array $issuer): void
    {
        $this->data['issuer'] = [
            'company_name' => $issuer['cac:PartyLegalEntity']['cbc:RegistrationName'],
            'trade_name' => $issuer['cac:PartyName']['cbc:Name'],
            'identification' => [
                'code' => $issuer['cac:PartyIdentification']['cbc:ID']['@attributes']['schemeID'],
                'value' => $issuer['cac:PartyIdentification']['cbc:ID']['@content'],
            ],
        ];
    }

    private function setAcquirer(array $acquirer): void
    {
        $this->data['acquirer'] = [
            'company_name' => $acquirer['cac:PartyLegalEntity']['cbc:RegistrationName'],
            'identification' => [
                'code' => $acquirer['cac:PartyIdentification']['cbc:ID']['@attributes']['schemeID'],
                'value' => $acquirer['cac:PartyIdentification']['cbc:ID']['@content'],
            ],
        ];
    }

    private function setTaxes(array $taxes): void
    {
        $this->data['taxes'] = [];
        $taxes = Arr::isAssoc($taxes) ? [$taxes] : $taxes;

        foreach ($taxes as $tax) {
            $this->data['taxes'][] = [
                'code' => $tax['cac:TaxCategory']['cac:TaxScheme']['cbc:ID']['@content'],
                'amount' => $tax['cbc:TaxAmount']['@content'],
            ];
        }
    }

    private function setItems(array $items): void
    {
        $this->data['items'] = [];

        foreach ($items as $item) {
            $unitPrice = $item['cac:PricingReference']['cac:AlternativeConditionPrice']['cbc:PriceAmount']['@content'];
            $totalAmount = $item['cbc:LineExtensionAmount']['@content']
                + $item['cac:TaxTotal']['cbc:TaxAmount']['@content'];

            $itemData = [
                'code' => $item['cac:Item']['cac:SellersItemIdentification']['cbc:ID'],
                'description' => $item['cac:Item']['cbc:Description'],
                'quantity' => $item['cbc:InvoicedQuantity']['@content'],
                'unit_value' => $item['cac:Price']['cbc:PriceAmount']['@content'],
                'unit_price' => $unitPrice,
                'base_amount' => $item['cbc:LineExtensionAmount']['@content'],
                'tax_amount' => $item['cac:TaxTotal']['cbc:TaxAmount']['@content'],
                'discount_amount' => 0,
                'other_charges_amount' => 0,
                'total_amount' => $totalAmount,
                'taxes' => [],
            ];

            $taxes = $item['cac:TaxTotal']['cac:TaxSubtotal'];
            $taxes = Arr::isAssoc($taxes) ? [$taxes] : $taxes;

            foreach ($taxes as $tax) {
                $itemData['taxes'][] = [
                    'code' => $tax['cac:TaxCategory']['cac:TaxScheme']['cbc:ID']['@content'],
                    'amount' => $tax['cbc:TaxAmount']['@content'],
                ];
            }

            $this->data['items'][] = $itemData;
        }
    }

    private function convertedContent(): array
    {
        return XmlToArray::convert($this->content);
    }
}
