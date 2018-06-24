<?php

namespace App\Http\Controllers;

use App\Http\Requests\CsvRequest;
use App\Models\CsvData;
use Maatwebsite\Excel\Facades\Excel;


class ImportController extends Controller
{

    /**
     * @var array
     */
    protected $status = [
        'created' => 0,
        'updated' => 0,
        'deleted' => 0
    ];

    /**
     * @var CsvData
     */
    private $model;


    /**
     * ImportController constructor.
     *
     * @param CsvData $csvModel
     */
    public function __construct(CsvData $csvModel)
    {
        $this->model = $csvModel;
    }


    /**
     * @param CsvData $csvModel
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('home', [
            'allRecords' => $this->model::all()
        ]);
    }


    /**
     * @param CsvRequest $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function parse(CsvRequest $request)
    {
        $path = $request->file('csv_file')->path();

        $input = Excel::load($path, function () {})->get()->toArray();

        // Якщо даних нема в новому csv файлі то вони повинні бути видалені
        if (empty($input)) {

            $deleted = $this->model->deleteAll();

            $this->status['deleted'] += $deleted;

            $afterDeleted = array_merge($this->status, [
                'allRecords' => $this->model::all()
            ]);

            return view('home', $afterDeleted );

        }

        // Якщо дані є - обробляємо їх
        foreach ($input as $item) {

            $data = $this->model->saveData($item);

            $this->status['created'] += $data['created'];
            $this->status['updated'] += $data['updated'];
        }

        $afterChanges = array_merge($this->status, [
            'allRecords' => $this->model::all()
        ]);

        return view('home', $afterChanges );

    }
}
