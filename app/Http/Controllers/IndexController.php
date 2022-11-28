<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    private $response = [];

    public function dumpCSV(Request $request) {
        try {
            if (!$request->has("csv_file") && !$request->has("tabel_name"))
                throw new Exception("Preencha os campos obrigatórios.");

            $file = $request->file("csv_file");

            if (!$file->isValid())
                throw new Exception("Ocorreu um erro durante a requisição. Tente novamente.");

            if ($file->getMimeType() !== "text/csv")
                throw new Exception("O arquivo não é um CSV.");

            $csv = file($file);
            $csv_length = count($csv);

            if ($csv_length) {
                $db_table = $request->input("tabel_name");
                $db_columns = "ID," . strtoupper($csv[0]);
                $db_instruction = "INSERT INTO {$db_table} ({$db_columns}) VALUES ([valueshere])";
        
                $dump = [];
                $first_row = $request->has("dump_header") ? 0 : 1;
                for ($row = $first_row; $row < $csv_length; $row++) {
                    $pk = $first_row == 1 ? $row : $row + 1;
                    $values = "{$pk},'" . str_replace(",", "','", $csv[$row]) . "'";
                    $dump[] = str_replace("[valueshere]", $values, $db_instruction);
                }

                $this->response = [
                    "status" => 1,
                    "message" => "OK",
                    "data" => $dump
                ];
            } else {
                throw new Exception("Arquivo vazio.");
            }
        } catch(Exception $e) {
            $this->response = [
                "status" => $e->getCode(),
                "message" => $e->getMessage()
            ];
        } finally {
            return view('index', $this->response);
        }
    }
}
