<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Shuchkin\SimpleXLS;


class ParseExelFile extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|View
     */
    public function index(): View|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('main');
    }

    public function run(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json(['result' => $this->bolts($request->toArray())]);
    }
    private function parseExel(): SimpleXLS|bool
    {
        return SimpleXLS::parse(public_path('files\exel.xls'));
    }

    private function bolts($data) {
        $file = $this->parseExel()->rows(0, 18);
        $diameters = $data['diameter'];
        $type = $data['type'];
        $column = $data['column'];
        $result = [];
        foreach ($file as $row) {
            if(in_array($row[1], $diameters)) {
                foreach ($type as $value) {
                    switch ($value) {
                        case 'type1':
                            $result[] = [
                                $row[28] => $row[29] * $column,
                                'length' => $row[16],
                                'nut bolt' => $row[29] * $column * 2,
                            ];
                            break;
                        case 'type2':
                            $result[] = [
                                $row[28] => $row[29] * $column,
                                'length' => $row[17],
                                'nut bolt' => $row[29] * $column * 2,
                            ];
                            break;
                        case 'type3':
                            $result[] = [
                                $row[28] => $row[29] * $column,
                                'length' => $row[18],
                                'nut bolt' => $row[29] * $column * 2,
                            ];
                            break;
                    }
                }
            }
        }
        return $result;
    }
}
