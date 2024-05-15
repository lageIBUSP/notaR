<?php

namespace App\Utils;

class Csv
{
    protected $columnsNames = [];
    protected $data = [];

    public function __construct(string $content) {
        $rows = array_map('str_getcsv', explode(PHP_EOL, $content));
        $this->columnsNames = array_map('trim', array_shift($rows));

        foreach ($rows as $row) {
            $row = array_map('trim', $row);
            if( sizeof($row) == sizeof($this->columnsNames) )  {
                $associatedRowData = array_combine($this->columnsNames, $row);
                if (empty($keyField)) {
                    $this->data[] = $associatedRowData;
                } else {
                    $this->data[$associatedRowData[$keyField]] = $associatedRowData;
                }
            }
        }
    }

    public function getColumnNames(): array {
        return $this->columnsNames;
    }

    public function getData(): array {
        return $this->data;
    }
}